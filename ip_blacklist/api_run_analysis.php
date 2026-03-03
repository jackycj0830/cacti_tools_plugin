<?php
/**
 * Block_IP Dashboard — Run Analysis Endpoint
 * Executes the PHP analysis script and streams output to the client via SSE.
 */

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('X-Accel-Buffering: no'); // For Nginx reverse proxy

// Disable ALL output buffering layers (critical for SSE)
if (function_exists('apache_setenv')) {
    apache_setenv('no-gzip', 1);
}
set_time_limit(0);
@ini_set('zlib.output_compression', 0);
@ini_set('implicit_flush', 1);
while (ob_get_level()) {
    ob_end_flush();
}
ob_implicit_flush(true);

// Determine PHP executable path (quote for paths with spaces)
$phpExec = PHP_BINARY;
if (!$phpExec || !file_exists($phpExec)) {
    $phpExec = 'php';
}

// Point to the PHP analysis script
$script = realpath(__DIR__ . '/faz_analyzer.php');
if (!$script) {
    send_msg('error', 'faz_analyzer.php not found in ' . __DIR__);
    send_msg('done', 'Analysis aborted.');
    exit;
}

// Use the exact same log file location
$logFile = __DIR__ . '/web/analysis_progress.log';

// 1. Clear previous log
@file_put_contents($logFile, "");

// 2. Start PHP script in background
$days = isset($_GET['days']) ? intval($_GET['days']) : 7;
$scriptDir = realpath(__DIR__);

// Quote the PHP executable path for paths with spaces (e.g. C:\Program Files\PHP\php.exe)
// Redirect stderr to log file instead of NUL so errors are visible
$cmd = "cd /D \"$scriptDir\" && start /B \"\" \"$phpExec\" -f \"$script\" --days $days > NUL 2>> \"$logFile\"";

pclose(popen($cmd, "r"));

// Small wait to allow the background process to start and write initial output
usleep(500000); // 500ms

// 3. Tail the log file and stream via SSE
$startTime = time();
$lastSize = 0;
$idleTime = 0;
$foundFinished = false;

while (true) {
    // Safety timeout (15 mins)
    if (time() - $startTime > 900) {
        send_msg('error', "Timeout reached (15 minutes).");
        break;
    }

    clearstatcache(true, $logFile);
    $currentSize = @filesize($logFile);

    if ($currentSize !== false && $currentSize > $lastSize) {
        // Read new data
        $fh = fopen($logFile, 'r');
        if ($fh) {
            fseek($fh, $lastSize);
            $newData = fread($fh, $currentSize - $lastSize);
            fclose($fh);

            // Send lines
            $lines = explode("\n", $newData);
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if ($trimmed !== '') {
                    send_msg('log', $line);
                    // Detect when script finishes
                    if ($trimmed === 'Finished') {
                        $foundFinished = true;
                    }
                }
            }

            $lastSize = $currentSize;
            $idleTime = 0;

            // If script wrote "Finished", we're done
            if ($foundFinished) {
                break;
            }
        }
    } else {
        $idleTime++;
        // If no updates for 15 seconds, assume done
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
    if (ob_get_level()) ob_flush();
    flush();
}
?>
