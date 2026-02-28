<?php
/**
 * Block_IP Dashboard — Run Analysis Endpoint
 * Executes the python script and streams output to the client.
 */

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

// Disable output buffering and execution limits
if (function_exists('apache_setenv')) {
    apache_setenv('no-gzip', 1);
}
set_time_limit(0);
@ini_set('zlib.output_compression', 0);
@ini_set('implicit_flush', 1);

$python = 'C:/Python314/python.exe';
if (!file_exists($python)) {
    $python = 'python'; // Fallback to PATH
}
// Point to the script in the older project
$script = realpath(__DIR__ . '/../Block_IP_20260223/analyze_faz_ips.py');
// Use the exact same log file location that the python script writes to
$logFile = realpath(__DIR__ . '/../Block_IP_20260223/web/') . '/analysis_progress.log';

// 1. Clear previous log
@file_put_contents($logFile, "");

// 2. Start Python script in background (redirecting stderr to stdout to capture errors)
$days = isset($_GET['days']) ? intval($_GET['days']) : 7;
// Note: We'll set the working directory to the python script's directory so it finds its db and csvs properly
$scriptDir = realpath(__DIR__ . '/../Block_IP_20260223/');
$cmd = "cd /D \"$scriptDir\" && start /B $python -u \"$script\" --days $days > NUL 2>&1";

pclose(popen($cmd, "r"));

// 3. Tail the log file
$startTime = time();
$lastSize = 0;
$idleTime = 0;

while (true) {
    // Safety timeout (15 mins)
    if (time() - $startTime > 900) {
        send_msg('error', "Timeout reached.");
        break;
    }

    clearstatcache(true, $logFile);
    $currentSize = @filesize($logFile);

    if ($currentSize !== false && $currentSize > $lastSize) {
        $cancel = FALSE;
        // Read new data
        $fh = fopen($logFile, 'r');
        if ($fh) {
            fseek($fh, $lastSize);
            $newData = fread($fh, $currentSize - $lastSize);
            fclose($fh);

            // Send lines
            $lines = explode("\n", $newData);
            foreach ($lines as $line) {
                if (trim($line) !== '') {
                    send_msg('log', $line);
                }
            }

            $lastSize = $currentSize;
            $idleTime = 0;
        }
    }
    else {
        $idleTime++;
        // If no updates for 15 seconds, assume done (script usually finishes faster or prints 'Finished')
        if ($idleTime > 150) { // 15s * 100ms
            break;
        }
    }

    usleep(100000); // 100ms
}

send_msg('done', "Analysis finished.");

function send_msg($type, $msg)
{
    echo "data: " . json_encode(['type' => $type, 'msg' => $msg]) . "\n\n";
    flush();
}
?>
