<?php
/**
 * Block_IP Dashboard — Run Analysis Endpoint
 * Executes the PHP analysis script and streams output to the client.
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

// Find PHP executable
$phpExec = '';
$candidates = ['C:/xampp/php/php.exe', 'C:/php/php.exe', 'L:/php/php.exe', '../../php/php.exe'];
foreach ($candidates as $candidate) {
    if (file_exists($candidate)) {
        $phpExec = $candidate;
        break;
    }
}
if (!$phpExec) {
    // Try system PATH
    $phpExec = PHP_BINARY ?: 'php';
}

// Point to the PHP analysis script (in the parent directory)
$script = realpath(__DIR__ . '/../faz_analyzer.php');
$logFile = __DIR__ . '/analysis_progress.log';

if (!$script || !file_exists($script)) {
    send_msg('error', "Analysis script not found at: " . __DIR__ . '/../faz_analyzer.php');
    send_msg('done', "Analysis failed.");
    exit;
}

// 1. Clear previous log
file_put_contents($logFile, "");

// 2. Start PHP script in background
$days = isset($_GET['days']) ? intval($_GET['days']) : 7;
$scriptDir = realpath(__DIR__ . '/..');

// Cross-platform execution: Windows uses start /B, Linux uses &
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $cmd = "cd /D \"$scriptDir\" && start /B \"\" \"$phpExec\" -f \"$script\" -- --days $days > NUL 2>&1";
} else {
    $cmd = "cd \"$scriptDir\" && $phpExec -f \"$script\" -- --days $days > /dev/null 2>&1 &";
}

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
    } else {
        $idleTime++;
        if ($idleTime > 150) { // 15s * 100ms
            break;
        }
    }

    usleep(100000); // 100ms
}

send_msg('done', "Analysis finished.");

function send_msg($type, $msg) {
    echo "data: " . json_encode(['type' => $type, 'msg' => $msg]) . "\n\n";
    @ob_flush();
    flush();
}
?>
