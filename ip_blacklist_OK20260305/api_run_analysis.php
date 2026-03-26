<?php
/**
 * Block_IP Dashboard — Run Analysis Endpoint
 * Executes faz_analyzer.php and streams output to the client via SSE.
 * Supports both Linux and Windows.
 */

// === SSE Headers ===
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');
header('X-Accel-Buffering: no');

// === Disable ALL output buffering ===
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

// === Helper ===
function send_msg($type, $msg)
{
    echo "data: " . json_encode(['type' => $type, 'msg' => $msg], JSON_UNESCAPED_UNICODE) . "\n\n";
    if (ob_get_level()) ob_flush();
    flush();
}

// ============================================================
// DETECT OS
// ============================================================
$isWindows = (PHP_OS_FAMILY === 'Windows' || strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');
send_msg('log', "=== DIAGNOSTICS ===");
send_msg('log', "[DIAG] PHP Version: " . PHP_VERSION);
send_msg('log', "[DIAG] OS: " . PHP_OS . ($isWindows ? " (Windows)" : " (Linux/Unix)"));
send_msg('log', "[DIAG] __DIR__: " . __DIR__);

// ============================================================
// FIND PHP CLI BINARY
// ============================================================
$phpCli = '';

if ($isWindows) {
    // On Windows, PHP_BINARY is usually the CLI binary
    $phpCli = PHP_BINARY;
    if (!$phpCli || !file_exists($phpCli)) {
        $phpCli = 'php';
    }
} else {
    // On Linux, PHP_BINARY might be php-fpm — we need php CLI
    $candidates = [
        '/usr/bin/php',
        '/usr/local/bin/php',
        '/usr/bin/php8.0',
        '/usr/bin/php8.1',
        '/usr/bin/php8.2',
        '/usr/bin/php8.3',
    ];

    // Check if PHP_BINARY is already CLI (not fpm)
    $phpBin = PHP_BINARY;
    if ($phpBin && !str_contains($phpBin, 'fpm') && file_exists($phpBin)) {
        $phpCli = $phpBin;
    }

    if (!$phpCli) {
        foreach ($candidates as $c) {
            if (file_exists($c) && is_executable($c)) {
                $phpCli = $c;
                break;
            }
        }
    }

    // Fallback: use 'which php' to find it
    if (!$phpCli) {
        $which = trim(shell_exec('which php 2>/dev/null') ?? '');
        if ($which && file_exists($which)) {
            $phpCli = $which;
        }
    }

    // Last resort
    if (!$phpCli) {
        $phpCli = 'php';
    }
}

send_msg('log', "[DIAG] PHP_BINARY (raw): " . PHP_BINARY);
send_msg('log', "[DIAG] PHP CLI resolved: " . $phpCli);

// Quick test: verify it's CLI not FPM
if (!$isWindows) {
    $verCheck = trim(shell_exec("\"$phpCli\" -v 2>&1 | head -1") ?? '');
    send_msg('log', "[DIAG] PHP CLI version check: " . ($verCheck ?: '(empty)'));
    if (str_contains(strtolower($verCheck), 'fpm')) {
        send_msg('error', "WARNING: $phpCli appears to be php-fpm, not php CLI!");
    }
}

// ============================================================
// CHECK SCRIPT
// ============================================================
$scriptPath = __DIR__ . '/faz_analyzer.php';
$script = realpath($scriptPath);
send_msg('log', "[DIAG] Script: " . ($script ?: 'NOT FOUND at ' . $scriptPath));

if (!$script) {
    send_msg('error', "FATAL: faz_analyzer.php not found.");
    send_msg('done', "Analysis aborted.");
    exit;
}

// ============================================================
// DETERMINE LOG FILE (use /tmp if web/ not writable)
// ============================================================
$logDir = __DIR__ . '/web';
$logFile = $logDir . '/analysis_progress.log';

// Check if web/ dir is writable
if (!is_dir($logDir) || !is_writable($logDir)) {
    // Fallback to /tmp (always writable on Linux)
    $logFile = $isWindows
        ? sys_get_temp_dir() . '\\faz_analysis_progress.log'
        : '/tmp/faz_analysis_progress.log';
    send_msg('log', "[DIAG] web/ dir not writable, using fallback: " . $logFile);
} else {
    send_msg('log', "[DIAG] Log file: " . $logFile);
}

// Clear previous log
@file_put_contents($logFile, "");
$clearOk = is_writable($logFile) || is_writable(dirname($logFile));
send_msg('log', "[DIAG] Log file writable: " . ($clearOk ? 'YES' : 'NO'));

if (!$clearOk) {
    send_msg('error', "FATAL: Cannot write to log file: " . $logFile);
    send_msg('done', "Analysis aborted — no writable log location.");
    exit;
}

// ============================================================
// BUILD AND EXECUTE COMMAND
// ============================================================
$days = isset($_GET['days']) ? intval($_GET['days']) : 7;
$scriptDir = realpath(__DIR__);

if ($isWindows) {
    // Windows: start /B with quoted paths
    $cmd = "cd /D \"$scriptDir\" && start /B \"\" \"$phpCli\" -f \"$script\" --days $days > NUL 2>> \"$logFile\"";
} else {
    // Linux: nohup in background
    // stdout → /dev/null (logOutput() already writes to log file via file_put_contents)
    // stderr → append to log file (captures PHP warnings/errors)
    $cmd = "cd \"$scriptDir\" && nohup \"$phpCli\" \"$script\" --days $days > /dev/null 2>> \"$logFile\" &";
}


send_msg('log', "=== EXECUTION ===");
send_msg('log', "[CMD] Days: " . $days);
send_msg('log', "[CMD] Command: " . $cmd);
send_msg('log', "[CMD] Launching background process...");

// Execute using pclose(popen()) — non-blocking on both platforms
$proc = popen($cmd, "r");
if ($proc === false) {
    send_msg('error', "FATAL: popen() failed. Check if shell_exec/popen is allowed.");
    send_msg('done', "Analysis aborted.");
    exit;
}
pclose($proc);


send_msg('log', "[CMD] Background process launched. Tailing log file...");

// Wait for process to start
usleep(800000); // 800ms

// Quick check
clearstatcache(true, $logFile);
$initialSize = @filesize($logFile);
send_msg('log', "[TAIL] Initial log file size: " . $initialSize . " bytes");

if ($initialSize === 0 || $initialSize === false) {
    sleep(2);
    clearstatcache(true, $logFile);
    $initialSize = @filesize($logFile);
    send_msg('log', "[TAIL] After 2s wait, log file size: " . $initialSize . " bytes");

    if ($initialSize === 0 || $initialSize === false) {
        send_msg('log', "[WARN] Log file still empty. Trying direct execution...");

        // Direct execution for diagnostics
        $testCmd = "\"$phpCli\" \"$script\" --days $days 2>&1";
        send_msg('log', "[TEST] Direct command: " . $testCmd);

        $output = [];
        $returnCode = null;
        exec($testCmd, $output, $returnCode);

        send_msg('log', "[TEST] Return code: " . $returnCode);
        foreach (array_slice($output, 0, 80) as $line) {
            send_msg('log', $line);
        }
        if (count($output) > 80) {
            send_msg('log', "[TEST] ... (truncated, " . count($output) . " total lines)");
        }

        send_msg('done', "Analysis complete (direct execution mode).");
        exit;
    }
}

// ============================================================
// TAIL LOG FILE AND STREAM VIA SSE
// ============================================================
send_msg('log', "=== TAILING LOG ===");

$startTime = time();
$lastSize = 0;
$idleTime = 0;
$foundFinished = false;

while (true) {
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
        if ($idleTime > 150) {
            send_msg('log', "[TAIL] No output for 15 seconds. Process may have ended.");
            break;
        }
    }

    usleep(100000);
}

send_msg('done', "Analysis finished.");
?>
