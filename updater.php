<?php
// 只要直接存取本檔（無 $_FILES）時，回傳 HTML 表單
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_FILES)) {
    ?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>上傳 ZIP 並預覽內容</title>
</head>
<body>
    <h2>上傳 ZIP 檔案</h2>
    <input type="file" id="zipFile" accept=".zip">
    <ul id="fileList"></ul>
    <button id="uploadBtn" type="button" onclick="uploadFile()" disabled>確認並上傳</button>
    <div id="progress"></div>
    <div id="message"></div>
    <script src="https://cdn.jsdelivr.net/npm/jszip/dist/jszip.min.js"></script>
    <script>
        let selectedFile;
        document.getElementById('zipFile').addEventListener('change', function() {
            let file = this.files[0];
            let ul = document.getElementById('fileList');
            ul.innerHTML = '';
            document.getElementById('uploadBtn').disabled = true;
            document.getElementById('progress').innerHTML = '';
            document.getElementById('message').innerHTML = '';
            if (!file) return;
            if (!file.name.match(/\.zip$/i)) {
                ul.innerHTML = '<li>請選擇 ZIP 檔案</li>';
                return;
            }
            selectedFile = file;
            let reader = new FileReader();
            reader.onload = function (e) {
                JSZip.loadAsync(e.target.result).then(function(zip) {
                    Object.keys(zip.files).forEach(function(filename) {
                        let li = document.createElement('li');
                        li.innerText = filename;
                        ul.appendChild(li);
                    });
                    document.getElementById('uploadBtn').disabled = false;
                }, function() {
                    ul.innerHTML = '<li>無法讀取 ZIP 內容，請確認檔案正確！</li>';
                });
            };
            reader.readAsArrayBuffer(file);
        });

        function uploadFile() {
            if (!selectedFile) return;
            let formData = new FormData();
            formData.append('zipFile', selectedFile);
            let xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.upload.onprogress = function(e) {
                if (e.lengthComputable) {
                    let percent = Math.round((e.loaded / e.total) * 100);
                    document.getElementById('progress').innerText = '上傳進度: ' + percent + '%';
                }
            };
            xhr.onload = function() {
                if (xhr.status === 200) {
                    let resp;
                    try { resp = JSON.parse(xhr.responseText); }
                    catch (ex) {
                        document.getElementById('message').innerHTML = '後端回傳格式錯誤！<pre>' + xhr.responseText + '</pre>';
                        return;
                    }
                    if (resp.success) {
                        document.getElementById('message').innerHTML = '上傳成功！<br>檔案清單：<br>' + (resp.files || []).join('<br>');
                    } else {
                        let msg = '錯誤：' + resp.error + ' (錯誤代碼:' + resp.code + ')';
                        // 若為 ZipArchive 未安裝，顯示解決方案
                        if (resp.code == 900) {
                            msg += `<br><br>
                            <b>解決方法：</b><br>
                            1. <b>安裝 Zip 擴展</b><br>
                            <u>Linux (Debian/Ubuntu)</u><br>
                            <code>sudo apt-get install php-zip<br>sudo systemctl restart apache2</code><br>
                            <u>CentOS/RHEL</u><br>
                            <code>sudo yum install php-zip<br>sudo systemctl restart httpd</code><br>
                            <u>Windows</u><br>
                            通常 PHP 已內建 zip.dll，只需確認 php.ini 有啟用：<br>
                            <code>extension=zip</code><br>
                            重啟 Apache 或 Nginx。<br><br>
                            2. <b>確認 extension 啟用</b><br>
                            查看 phpinfo() 頁面，搜尋有無 Zip。<br>
                            或用指令：<br>
                            <code>php -m | grep zip</code><br>
                            有看到 zip 就代表已啟用。
                            `;
                        }
                        document.getElementById('message').innerHTML = msg;
                    }
                } else {
                    document.getElementById('message').innerHTML = '伺服器回應異常，HTTP狀態：' + xhr.status + '<br>請檢查 logs/error.log 或聯絡管理員。';
                }
            };
            xhr.onerror = function() {
                document.getElementById('message').innerHTML = '上傳過程發生錯誤！';
            }
            xhr.send(formData);
        }
    </script>
</body>
</html>
<?php
    exit;
}

// -------------- 以下為 PHP 處理流程 --------------
header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set("Asia/Taipei");

// === 基本參數，請依你的實際環境調整 ===
$ssh_host    = '172.17.32.15';
$ssh_user    = 'root';
$ssh_pass    = '';
$remote_path = '/usr/share/cacti/plugins/tools/uploads/';
$log_file    = '/usr/share/cacti/plugins/tools/uploads/upload.log';

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
function rrmdir($dir) {
    if (!file_exists($dir)) return;
    foreach(glob($dir . '/*') as $file){
        if(is_dir($file)) rrmdir($file); else unlink($file);
    }
    rmdir($dir);
}
function json_exit($arr) {
    echo json_encode($arr, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    exit;
}
try {
    if (!class_exists('ZipArchive')) {
        json_exit(['success'=>false, 'error'=>'伺服器未安裝 ZipArchive 擴展', 'code'=>900, 'files'=>[]]);
    }
    if (!isset($_FILES['zipFile']) || $_FILES['zipFile']['error'] !== UPLOAD_ERR_OK) {
        json_exit(['success'=>false, 'error'=>'檔案上傳失敗', 'code'=>901, 'files'=>[]]);
    }
    $name = $_FILES['zipFile']['name'];
    write_log("收到檔案: $name", $log_file);

    // --- 解壓縮 ---
    $zip = new ZipArchive();
    $tmpDir = sys_get_temp_dir() . '/zip_' . uniqid();
    if (!mkdir($tmpDir, 0777, true)) {
        json_exit(['success'=>false, 'error'=>'建立暫存目錄失敗', 'code'=>902, 'files'=>[]]);
    }
    $fileList = [];
    if ($zip->open($_FILES['zipFile']['tmp_name']) === TRUE) {
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $entry = $zip->getNameIndex($i);
            $fileList[] = $entry;
            // 防 Zip Slip
            $entryPath = $tmpDir . '/' . $entry;
            $realPath = realpath($tmpDir);
            $extractPath = realpath(dirname($entryPath));
            if ($extractPath !== false && strpos($extractPath, $realPath) !== 0) {
                rrmdir($tmpDir);
                json_exit(['success'=>false, 'error'=>'ZIP 內含有危險路徑: ' . $entry, 'code'=>903, 'files'=>$fileList]);
            }
        }
        $zip->extractTo($tmpDir);
        $zip->close();
        write_log("解壓縮成功: $tmpDir", $log_file);
    } else {
        rrmdir($tmpDir);
        json_exit(['success'=>false, 'error'=>'ZIP 解壓縮失敗', 'code'=>904, 'files'=>[]]);
    }

    // --- SCP 上傳 ---
    $cmd = sprintf(
        "sshpass -p '%s' scp -o StrictHostKeyChecking=no -r %s/* %s@%s:%s",
        escapeshellcmd($ssh_pass),
        escapeshellarg($tmpDir),
        escapeshellcmd($ssh_user),
        escapeshellcmd($ssh_host),
        escapeshellcmd($remote_path)
    );
    write_log("執行 SCP: $cmd", $log_file);
    exec($cmd . " 2>&1", $output, $return_var);
    if ($return_var !== 0) {
        rrmdir($tmpDir);
        json_exit(['success'=>false, 'error'=>'SCP 上傳失敗: '.implode("\n",$output), 'code'=>905, 'files'=>$fileList]);
    }
    write_log("上傳成功！", $log_file);

    // --- 清除暫存 ---
    rrmdir($tmpDir);
    write_log("暫存目錄清理完成", $log_file);

    json_exit(['success'=>true, 'files'=>$fileList, 'code'=>0]);
} catch (Throwable $e) {
    json_exit(['success'=>false, 'error'=>'Exception: '.$e->getMessage(), 'code'=>999, 'files'=>[]]);
}
