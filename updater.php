<?php
// ======= 前端頁面輸出 (GET 或未上傳時) =======
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_FILES)) {
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>Cacti 更新系統</title>
    <style>
        body {
            background: #f5f5f5;
            font-family: "Microsoft JhengHei", Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .cacti-header {
            background: #51a351;
            color: #fff;
            padding: 16px 24px;
            font-size: 1.4em;
            letter-spacing: 2px;
            font-weight: bold;
        }
        .cacti-container {
            max-width: 600px;
            background: #fff;
            margin: 30px auto;
            border-radius: 8px;
            box-shadow: 0 4px 12px #b2b2b270;
            padding: 32px 24px 16px 24px;
        }
        .cacti-box {
            background: #eaf5ea;
            border-left: 6px solid #51a351;
            color: #2d572c;
            padding: 16px 20px;
            margin-bottom: 30px;
            border-radius: 5px;
            font-size: 1.08em;
        }
        .cacti-btn {
            background: #51a351;
            color: #fff;
            border: none;
            padding: 10px 24px;
            font-size: 1.1em;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        .cacti-btn:disabled {
            background: #b7d9b7;
            cursor: not-allowed;
        }
        input[type="file"] {
            border: 1px solid #b5b5b5;
            background: #f9f9f9;
            padding: 7px 10px;
            border-radius: 4px;
        }
        #fileList {
            margin: 12px 0 6px 0;
            padding-left: 18px;
        }
        #progress {
            margin-top: 6px;
            color: #19591d;
        }
        #message {
            margin-top: 16px;
            padding: 10px;
            background: #f6fff6;
            border-radius: 4px;
            border: 1px solid #d4edd4;
            min-height: 28px;
            color: #2d572c;
            font-size: 1.05em;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <div class="cacti-header">Cacti 系統插件/資源上傳與更新</div>
    <div class="cacti-container">
        <div class="cacti-box">
            <b>操作說明與注意事項：</b><br>
            1. 本功能僅限上傳經認證的 Cacti 套件、插件或更新檔案（ZIP 格式）。<br>
            2. 上傳後，系統會自動將內容解壓縮並傳送到對應 Cacti 伺服器目錄。<br>
            3. <b>請勿上傳來源不明、未經測試之檔案！</b><br>
            4. 傳送完成後請至 <u>插件管理或更新頁</u> 檢查狀態，如需重啟 Cacti 服務請手動操作。<br>
            5. <b>安全提醒：</b> 請確認檔案內容無惡意程式，且檔名無中文或特殊符號。<br>
        </div>
        <h2 style="color:#51a351;">上傳更新檔案（ZIP）</h2>
        <input type="file" id="zipFile" accept=".zip">
        <ul id="fileList"></ul>
        <button id="uploadBtn" class="cacti-btn" type="button" onclick="uploadFile()" disabled>確認並上傳</button>
        <div id="progress"></div>
        <div id="message"></div>
    </div>
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
                        document.getElementById('message').innerHTML = '✅ 上傳成功！<br>檔案清單：<br>' + (resp.files || []).join('<br>');
                    } else {
                        let msg = '❌ 錯誤：' + resp.error + ' (錯誤代碼:' + resp.code + ')';
                        if (resp.code == 900) {
                            msg += `<br><br>
                            <b>解決方法：</b><br>
                            <u>Linux (Debian/Ubuntu)</u>：<br>
                            <code>sudo apt-get install php-zip<br>sudo systemctl restart apache2</code><br>
                            <u>CentOS/RHEL</u>：<br>
                            <code>sudo yum install php-zip<br>sudo systemctl restart httpd</code><br>
                            <u>Windows</u>：請於 php.ini 啟用 <code>extension=zip</code> 並重啟 Web 服務。
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

// ========== 後端 PHP 處理區段 ==========

header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set("Asia/Taipei");

// === 依實際需求設定目標參數 ===
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
?>
