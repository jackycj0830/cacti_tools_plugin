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
$script = __DIR__ . '/../analyze_faz_ips.py';
$logFile = __DIR__ . '/analysis_progress.log';

$runToken = isset($_GET['run_token']) ? $_GET['run_token'] : '';
$lockFile = __DIR__ . '/analysis.lock';
$currentLock = file_exists($lockFile) ? file_get_contents($lockFile) : '';

if ($runToken !== '' && $runToken !== $currentLock) {
    // New run request: save token, reset log, and start Python
    file_put_contents($lockFile, $runToken);
    
    // 1. Clear previous log
    file_put_contents($logFile, "");

    // 2. Start Python script in background (redirecting stderr to stdout to capture errors)
    $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
    $cmd = "start /B $python -u \"$script\" --days $days";
    if (isset($_GET['devname']) && $_GET['devname'] !== 'all') {
        $devname = escapeshellarg($_GET['devname']);
        $cmd .= " --device $devname";
    }
    $cmd .= " > NUL 2>&1";
    pclose(popen($cmd, "r"));
} else {
    // Reconnection for an existing run
    // Do not start the Python script again. Just tail the existing log.
}

// 3. Tail the log file
$startTime = time();
$lastSize = isset($_SERVER['HTTP_LAST_EVENT_ID']) ? intval($_SERVER['HTTP_LAST_EVENT_ID']) : 0;
$idleTime = 0;

while (true) {
    // Safety timeout (4 hours instead of 15 mins to allow for large VT queues)
    if (time() - $startTime > 14400) {
        send_msg('error', "Timeout reached (4 hours).");
        break;
    }

    clearstatcache(true, $logFile);
    $currentSize = filesize($logFile);

    if ($currentSize > $lastSize) {
        $cancel = FALSE;
        // Read new data
        $fh = fopen($logFile, 'r');
        fseek($fh, $lastSize);
        $newData = fread($fh, $currentSize - $lastSize);
        fclose($fh);

        // Send lines
        $lines = explode("\n", $newData);
        $filtered = array_values(array_filter($lines, function($l) { return trim($l) !== ''; }));
        $lastIdx = count($filtered) - 1;
        foreach ($filtered as $i => $line) {
            $id = ($i === $lastIdx) ? $currentSize : null;
            send_msg('log', $line, $id);
        }
        
        $lastSize = $currentSize;
        $idleTime = 0;
    } else {
        $idleTime++;

        // Send a keep-alive ping every ~5 seconds to prevent the browser/firewall from dropping the connection
        if ($idleTime % 50 === 0) {
            echo ": keepalive\n\n";
            if (ob_get_level() > 0) ob_flush();
            flush();
        }

        // If no updates for 60 seconds (60s * 10 = 600 loops of 100ms)
        if ($idleTime > 600) { 
             break; 
        }
    }

    usleep(100000); // 100ms
}

send_msg('done', "Analysis finished.");

function send_msg($type, $msg, $id = null) {
    if ($id !== null) {
        echo "id: $id\n";
    }
    echo "data: " . json_encode(['type' => $type, 'msg' => $msg]) . "\n\n";
    if (ob_get_level() > 0) {
        ob_flush();
    }
    flush();
}

// Initial 4KB padding to force headers out
echo ':' . str_pad(' ', 4096) . "\n\n";
if (ob_get_level() > 0) { ob_flush(); }
flush();
?>
