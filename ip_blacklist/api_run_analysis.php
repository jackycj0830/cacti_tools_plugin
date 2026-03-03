<?php
/**
 * Block_IP Dashboard — Run Analysis Endpoint (with Diagnostics)
 * Executes the PHP analysis script and streams output to the client via SSE.
 * Includes comprehensive diagnostic logging for troubleshooting.
 */

// === SSE Headers ===
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('X-Accel-Buffering: no'); // Nginx

// === Disable ALL output buffering (critical for SSE) ===
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

// === Helper: Send SSE message ===
function send_msg($type, $msg)
{
    echo "data: " . json_encode(['type' => $type, 'msg' => $msg], JSON_UNESCAPED_UNICODE) . "\n\n";
    if (ob_get_level()) ob_flush();
    flush();
}

// ============================================================
// PHASE 1: DIAGNOSTICS — Send environment info immediately
// ============================================================
send_msg('log', "=== DIAGNOSTICS ===");
send_msg('log', "[DIAG] PHP Version: " . PHP_VERSION);
send_msg('log', "[DIAG] OS: " . PHP_OS . " (" . php_uname('s') . " " . php_uname('r') . ")");
send_msg('log', "[DIAG] __DIR__: " . __DIR__);
send_msg('log', "[DIAG] Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'N/A'));
send_msg('log', "[DIAG] Request URI: " . ($_SERVER['REQUEST_URI'] ?? 'N/A'));

// Check PHP binary
$phpExec = PHP_BINARY;
send_msg('log', "[DIAG] PHP_BINARY: " . ($phpExec ?: '(empty)'));
if (!$phpExec || !file_exists($phpExec)) {
    $phpExec = 'php';
    send_msg('log', "[DIAG] PHP_BINARY not found, fallback to: php");
}

// Check script path
$scriptPath = __DIR__ . '/faz_analyzer.php';
$script = realpath($scriptPath);
send_msg('log', "[DIAG] Script target: " . $scriptPath);
send_msg('log', "[DIAG] Script realpath: " . ($script ?: 'FALSE (file not found!)'));

if (!$script) {
    send_msg('error', "FATAL: faz_analyzer.php not found at: " . $scriptPath);
    // List files in directory to help debug
    $files = @scandir(__DIR__);
    if ($files) {
        $phpFiles = array_filter($files, fn($f) => str_ends_with($f, '.php'));
        send_msg('log', "[DIAG] PHP files in __DIR__: " . implode(', ', $phpFiles));
    }
    send_msg('done', "Analysis aborted — script not found.");
    exit;
}

// Check log file directory
$logDir = __DIR__ . '/web';
$logFile = $logDir . '/analysis_progress.log';
send_msg('log', "[DIAG] Log directory: " . $logDir);
send_msg('log', "[DIAG] Log dir exists: " . (is_dir($logDir) ? 'YES' : 'NO'));
send_msg('log', "[DIAG] Log dir writable: " . (is_writable($logDir) ? 'YES' : 'NO'));

if (!is_dir($logDir)) {
    send_msg('log', "[DIAG] Creating web/ directory...");
    @mkdir($logDir, 0755, true);
    if (!is_dir($logDir)) {
        send_msg('error', "FATAL: Cannot create web/ directory at: " . $logDir);
        send_msg('done', "Analysis aborted — log directory not available.");
        exit;
    }
}

// Clear previous log
$clearOk = @file_put_contents($logFile, "");
send_msg('log', "[DIAG] Log file cleared: " . ($clearOk !== false ? 'OK' : 'FAILED'));
send_msg('log', "[DIAG] Log file path: " . $logFile);
send_msg('log', "[DIAG] Log file writable: " . (is_writable($logFile) ? 'YES' : 'NO'));

// ============================================================
// PHASE 2: BUILD AND EXECUTE COMMAND
// ============================================================
$days = isset($_GET['days']) ? intval($_GET['days']) : 7;
$scriptDir = realpath(__DIR__);

// Build command — Windows specific
// Empty title "" after start /B is required when path is quoted
// Redirect stderr to log file so errors are visible
$cmd = "cd /D \"$scriptDir\" && start /B \"\" \"$phpExec\" -f \"$script\" --days $days > NUL 2>> \"$logFile\"";

send_msg('log', "=== EXECUTION ===");
send_msg('log', "[CMD] Days: " . $days);
send_msg('log', "[CMD] Working dir: " . $scriptDir);
send_msg('log', "[CMD] Full command: " . $cmd);
send_msg('log', "[CMD] Launching background process...");

// Execute
$proc = popen($cmd, "r");
if ($proc === false) {
    send_msg('error', "FATAL: popen() failed. Cannot launch background process.");
    send_msg('done', "Analysis aborted — command execution failed.");
    exit;
}
pclose($proc);

send_msg('log', "[CMD] Background process launched. Tailing log file...");

// Give the process time to start and write first output
usleep(800000); // 800ms

// Quick check if anything was written
clearstatcache(true, $logFile);
$initialSize = @filesize($logFile);
send_msg('log', "[TAIL] Initial log file size: " . $initialSize . " bytes");

if ($initialSize === 0) {
    // Wait a bit more and check again
    sleep(2);
    clearstatcache(true, $logFile);
    $initialSize = @filesize($logFile);
    send_msg('log', "[TAIL] After 2s wait, log file size: " . $initialSize . " bytes");
    
    if ($initialSize === 0) {
        send_msg('log', "[WARN] Log file still empty after 2.8s. The background process may have failed to start.");
        send_msg('log', "[WARN] Trying direct execution for diagnostics...");
        
        // Try running PHP directly and capture output
        $testCmd = "\"$phpExec\" -f \"$script\" --days $days 2>&1";
        send_msg('log', "[TEST] Direct command: " . $testCmd);
        
        $output = [];
        $returnCode = null;
        exec($testCmd, $output, $returnCode);
        
        send_msg('log', "[TEST] Return code: " . $returnCode);
        if (!empty($output)) {
            foreach (array_slice($output, 0, 50) as $line) { // First 50 lines
                send_msg('log', "[TEST] " . $line);
            }
            if (count($output) > 50) {
                send_msg('log', "[TEST] ... (truncated, " . count($output) . " total lines)");
            }
        } else {
            send_msg('log', "[TEST] No output captured from direct execution.");
        }
        
        send_msg('done', "Analysis diagnostics complete. Check output above for errors.");
        exit;
    }
}

// ============================================================
// PHASE 3: TAIL LOG FILE AND STREAM VIA SSE
// ============================================================
send_msg('log', "=== TAILING LOG ===");

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
        $fh = fopen($logFile, 'r');
        if ($fh) {
            fseek($fh, $lastSize);
            $newData = fread($fh, $currentSize - $lastSize);
            fclose($fh);

            $lines = explode("\n", $newData);
            foreach ($lines as $line) {
                $trimmed = trim($line);
                if ($trimmed !== '') {
                    send_msg('log', $line);
                    if ($trimmed === 'Finished') {
                        $foundFinished = true;
                    }
                }
            }

            $lastSize = $currentSize;
            $idleTime = 0;

            if ($foundFinished) {
                break;
            }
        }
    } else {
        $idleTime++;
        if ($idleTime > 150) { // 15s idle = done
            send_msg('log', "[TAIL] No new output for 15 seconds. Assuming process ended.");
            break;
        }
    }

    usleep(100000); // 100ms
}

send_msg('done', "Analysis finished.");
?>
