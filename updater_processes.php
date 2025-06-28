<?php
date_default_timezone_set("Asia/Taipei");
header('Content-Type: text/plain; charset=utf-8');

// --- 參數 ---
$ssh_host   = '172.17.32.15';
$ssh_user   = 'root';
$ssh_pass   = '';
$remote_path= '/usr/share/cacti/plugins/tools/uploads/';
$log_file   = '/usr/share/cacti/plugins/tools/uploads/upload.log';

// --- log function 強化 ---
function write_log($msg, $log_file) {
    $date = date("[Y-m-d H:i:s]");
    $log_dir = dirname($log_file);
    if (!is_dir($log_dir)) {
        @mkdir($log_dir, 0777, true);
    }
    if (!is_writable($log_dir)) {
        error_log($date . " [權限錯誤] 目錄無法寫入: $log_dir\n", 3, '/tmp/upload_debug.log');
        return;
    }
    file_put_contents($log_file, $date . " " . $msg . "\n", FILE_APPEND);
}

// --- 致命錯誤處理 ---
function fatal_exit($msg, $log_file) {
    write_log($msg, $log_file);
    error_log("[FATAL] " . $msg, 3, '/tmp/upload_debug.log');
    http_response_code(500);
    echo $msg;
    exit;
}

// --- 主流程 ---
try {
    // 0. 檢查 ZipArchive 是否存在
    if (!class_exists('ZipArchive')) {
        fatal_exit("伺服器未安裝或未啟用 ZipArchive 擴展，請聯絡系統管理員。", $log_file);
    }

    // 1. 檢查檔案是否上傳成功
    if (!isset($_FILES['zipFile']) || $_FILES['zipFile']['error'] !== UPLOAD_ERR_OK) {
        $msg = "檔案上傳失敗: " . (isset($_FILES['zipFile']['error']) ? $_FILES['zipFile']['error'] : "No file");
        fatal_exit($msg, $log_file);
    }
    write_log("收到檔案: {$_FILES['zipFile']['name']}", $log_file);

    // 2. 解壓縮，避免 Zip Slip
    $zip = new ZipArchive();
    $tmpDir = sys_get_temp_dir() . '/zip_' . uniqid();
    if (!mkdir($tmpDir, 0777, true)) {
        fatal_exit("建立暫存目錄失敗: $tmpDir", $log_file);
    }

    if ($zip->open($_FILES['zipFile']['tmp_name']) === TRUE) {
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $entry = $zip->getNameIndex($i);

            // 防止 Zip Slip
            $entryPath = $tmpDir . '/' . $entry;
            $realPath = realpath($tmpDir);
            $extractPath = realpath(dirname($entryPath));
            if ($extractPath !== false && strpos($extractPath, $realPath) !== 0) {
                fatal_exit("ZIP 壓縮包內檔案路徑有風險: $entry", $log_file);
            }
        }
        $zip->extractTo($tmpDir);
        $zip->close();
        write_log("解壓縮成功，暫存目錄: $tmpDir", $log_file);
    } else {
        fatal_exit("ZIP 解壓縮失敗", $log_file);
    }

    // 3. sshpass+scp (可改為 SFTP library for PHP 更安全)
    $cmd = sprintf(
        "sshpass -p '%s' scp -o StrictHostKeyChecking=no -r %s/* %s@%s:%s",
        escapeshellcmd($ssh_pass),
        escapeshellarg($tmpDir),
        escapeshellcmd($ssh_user),
        escapeshellcmd($ssh_host),
        escapeshellcmd($remote_path)
    );
    write_log("執行命令: $cmd", $log_file);

    exec($cmd . " 2>&1", $output, $return_var);

    if ($return_var !== 0) {
        $msg = "上傳失敗，錯誤訊息：" . implode("\n", $output);
        fatal_exit($msg, $log_file);
    }
    write_log("上傳成功！", $log_file);

    // 4. 清理暫存
    function rrmdir($dir) {
        if (!file_exists($dir)) return;
        foreach(glob($dir . '/*') as $file){
            if(is_dir($file)) rrmdir($file); else unlink($file);
        }
        rmdir($dir);
    }
    rrmdir($tmpDir);
    write_log("暫存目錄清理完成。", $log_file);

    echo "上傳與解壓縮成功！";
} catch (Throwable $e) {
    fatal_exit("程式例外錯誤: " . $e->getMessage(), $log_file);
}
?>
