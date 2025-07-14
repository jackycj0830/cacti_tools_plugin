<?php
// ======= 前端頁面輸出 (GET 或未上傳時) =======
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_FILES)) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cacti Update System</title>
    <style>
        /* ... 同你原本 CSS，這裡省略 ... */
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
        .lang-switcher {
            float: right;
            margin-top: 4px;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="cacti-header">
        <span id="lang-title"></span>
        <select class="lang-switcher" id="lang-select">
            <option value="en">English</option>
            <option value="zh-TW">繁體中文</option>
            <option value="zh-CN">简体中文</option>
        </select>
    </div>
    <div class="cacti-container">
        <div class="cacti-box" id="lang-tips"></div>
        <h2 style="color:#51a351;" id="lang-upload-title"></h2>
        <input type="file" id="zipFile" accept=".zip">
        <ul id="fileList"></ul>
        <button id="uploadBtn" class="cacti-btn" type="button" onclick="uploadFile()" disabled>
            <span id="lang-upload-btn"></span>
        </button>
        <div id="progress"></div>
        <div id="message"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jszip/dist/jszip.min.js"></script>
    <script>
    // --- 多語言內容 ---
    const LANG = {
        'en': {
            'title': 'Cacti Plugin/Resource Upload & Update',
            'tips': `<b>Instructions and Reminders:</b><br>
            1. Only upload certified Cacti packages, plugins, or update files (ZIP format).<br>
            2. The system will automatically extract and deliver the content to the corresponding Cacti server directory.<br>
            3. <b>Do NOT upload unknown or untested files!</b><br>
            4. After upload, check status in the <u>Plugin Management or Update</u> page. Please restart Cacti service manually if needed.<br>
            5. <b>Security Notice:</b> Ensure the file is clean and does not contain Chinese or special characters in the filename.<br>`,
            'upload_title': 'Upload Update File (ZIP)',
            'upload_btn': 'Upload',
            'file_error': 'Please select a ZIP file',
            'zip_error': 'Unable to read ZIP content, please check your file!',
            'uploading': 'Uploading: ',
            'success': '✅ Upload succeeded!<br>File list:<br>',
            'server_error': 'Server error, HTTP status: ',
            'file_upload_fail': 'File upload failed',
            'php_zip_missing': 'Server does not have ZipArchive extension',
            'scp_fail': 'SCP upload failed: ',
            'fix_php_zip': `
                <b>How to Fix:</b><br>
                <u>Linux (Debian/Ubuntu)</u>:<br>
                <code>sudo apt-get install php-zip<br>sudo systemctl restart apache2</code><br>
                <u>CentOS/RHEL</u>:<br>
                <code>sudo yum install php-zip<br>sudo systemctl restart httpd</code><br>
                <u>Windows</u>: Enable <code>extension=zip</code> in php.ini and restart Web service.<br>
            `,
            'server_return_error': 'Backend returned error format!<pre>',
            'contact_admin': 'Check logs/error.log or contact the administrator.',
            'upload_process_error': 'Upload process error!'
        },
        'zh-TW': {
            'title': 'Cacti 系統插件/資源上傳與更新',
            'tips': `<b>操作說明與注意事項：</b><br>
            1. 本功能僅限上傳經認證的 Cacti 套件、插件或更新檔案（ZIP 格式）。<br>
            2. 上傳後，系統會自動將內容解壓縮並傳送到對應 Cacti 伺服器目錄。<br>
            3. <b>請勿上傳來源不明、未經測試之檔案！</b><br>
            4. 傳送完成後請至 <u>插件管理或更新頁</u> 檢查狀態，如需重啟 Cacti 服務請手動操作。<br>
            5. <b>安全提醒：</b> 請確認檔案內容無惡意程式，且檔名無中文或特殊符號。<br>`,
            'upload_title': '上傳更新檔案（ZIP）',
            'upload_btn': '確認並上傳',
            'file_error': '請選擇 ZIP 檔案',
            'zip_error': '無法讀取 ZIP 內容，請確認檔案正確！',
            'uploading': '上傳進度: ',
            'success': '✅ 上傳成功！<br>檔案清單：<br>',
            'server_error': '伺服器回應異常，HTTP狀態：',
            'file_upload_fail': '檔案上傳失敗',
            'php_zip_missing': '伺服器未安裝 ZipArchive 擴展',
            'scp_fail': 'SCP 上傳失敗: ',
            'fix_php_zip': `
                <b>解決方法：</b><br>
                <u>Linux (Debian/Ubuntu)</u>：<br>
                <code>sudo apt-get install php-zip<br>sudo systemctl restart apache2</code><br>
                <u>CentOS/RHEL</u>：<br>
                <code>sudo yum install php-zip<br>sudo systemctl restart httpd</code><br>
                <u>Windows</u>：請於 php.ini 啟用 <code>extension=zip</code> 並重啟 Web 服務。<br>
            `,
            'server_return_error': '後端回傳格式錯誤！<pre>',
            'contact_admin': '請檢查 logs/error.log 或聯絡管理員。',
            'upload_process_error': '上傳過程發生錯誤！'
        },
        'zh-CN': {
            'title': 'Cacti 系统插件/资源上传与更新',
            'tips': `<b>操作说明与注意事项：</b><br>
            1. 本功能仅限上传认证的 Cacti 套件、插件或更新文件（ZIP 格式）。<br>
            2. 上传后，系统会自动解压并传送到对应 Cacti 服务器目录。<br>
            3. <b>请勿上传来源不明、未经测试的文件！</b><br>
            4. 传送完成后请至 <u>插件管理或更新页</u> 检查状态，如需重启 Cacti 服务请手动操作。<br>
            5. <b>安全提醒：</b> 请确认文件内容无恶意程序，且文件名无中文或特殊字符。<br>`,
            'upload_title': '上传更新文件（ZIP）',
            'upload_btn': '确认并上传',
            'file_error': '请选择 ZIP 文件',
            'zip_error': '无法读取 ZIP 内容，请确认文件正确！',
            'uploading': '上传进度: ',
            'success': '✅ 上传成功！<br>文件清单：<br>',
            'server_error': '服务器异常，HTTP 状态：',
            'file_upload_fail': '文件上传失败',
            'php_zip_missing': '服务器未安装 ZipArchive 扩展',
            'scp_fail': 'SCP 上传失败: ',
            'fix_php_zip': `
                <b>解决方法：</b><br>
                <u>Linux (Debian/Ubuntu)</u>:<br>
                <code>sudo apt-get install php-zip<br>sudo systemctl restart apache2</code><br>
                <u>CentOS/RHEL</u>:<br>
                <code>sudo yum install php-zip<br>sudo systemctl restart httpd</code><br>
                <u>Windows</u>: 请在 php.ini 启用 <code>extension=zip</code> 并重启 Web 服务。<br>
            `,
            'server_return_error': '后端返回格式错误！<pre>',
            'contact_admin': '请检查 logs/error.log 或联系管理员。',
            'upload_process_error': '上传过程中发生错误！'
        }
    };

    // 當前語言，預設英文
    let currentLang = 'en';

    function setLang(lang) {
        currentLang = lang;
        document.getElementById('lang-title').innerHTML = LANG[lang]['title'];
        document.getElementById('lang-tips').innerHTML = LANG[lang]['tips'];
        document.getElementById('lang-upload-title').innerHTML = LANG[lang]['upload_title'];
        document.getElementById('lang-upload-btn').innerHTML = LANG[lang]['upload_btn'];
        document.title = LANG[lang]['title'];
        // 清除提示
        document.getElementById('progress').innerHTML = '';
        document.getElementById('message').innerHTML = '';
        document.getElementById('fileList').innerHTML = '';
        document.getElementById('uploadBtn').disabled = true;
        selectedFile = null;
        document.getElementById('zipFile').value = '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        setLang(currentLang);
        document.getElementById('lang-select').value = currentLang;
        document.getElementById('lang-select').addEventListener('change', function() {
            setLang(this.value);
        });
    });

    // ================== 以下和原本 JS 類似 =======================
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
            ul.innerHTML = '<li>' + LANG[currentLang]['file_error'] + '</li>';
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
                ul.innerHTML = '<li>' + LANG[currentLang]['zip_error'] + '</li>';
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
                document.getElementById('progress').innerText = LANG[currentLang]['uploading'] + percent + '%';
            }
        };
        xhr.onload = function() {
            if (xhr.status === 200) {
                let resp;
                try { resp = JSON.parse(xhr.responseText); }
                catch (ex) {
                    document.getElementById('message').innerHTML = LANG[currentLang]['server_return_error'] + xhr.responseText + '</pre>';
                    return;
                }
                if (resp.success) {
                    document.getElementById('message').innerHTML = LANG[currentLang]['success'] + (resp.files || []).join('<br>');
                } else {
                    let msg = '❌ ' + LANG[currentLang]['file_upload_fail'] + ': ' + resp.error + ' (code:' + resp.code + ')';
                    if (resp.code == 900) {
                        msg += '<br><br>' + LANG[currentLang]['fix_php_zip'];
                    }
                    document.getElementById('message').innerHTML = msg;
                }
            } else {
                document.getElementById('message').innerHTML = LANG[currentLang]['server_error'] + xhr.status + '<br>' + LANG[currentLang]['contact_admin'];
            }
        };
        xhr.onerror = function() {
            document.getElementById('message').innerHTML = LANG[currentLang]['upload_process_error'];
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
// （後端不需特別改動，維持英文即可，或者未來可根據需求加上多語言訊息，這裡略）
header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set("Asia/Taipei");

// === 實際設定 ===
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
        error_log($date . " [PERMISSION ERROR] Cannot write log dir: $log_dir\n", 3, '/tmp/upload_debug.log');
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
        json_exit(['success'=>false, 'error'=>'Server does not have ZipArchive extension', 'code'=>900, 'files'=>[]]);
    }
    if (!isset($_FILES['zipFile']) || $_FILES['zipFile']['error'] !== UPLOAD_ERR_OK) {
        json_exit(['success'=>false, 'error'=>'File upload failed', 'code'=>901, 'files'=>[]]);
    }
    $name = $_FILES['zipFile']['name'];
    write_log("Received file: $name", $log_file);

    // --- 解壓縮 ---
    $zip = new ZipArchive();
    $tmpDir = sys_get_temp_dir() . '/zip_' . uniqid();
    if (!mkdir($tmpDir, 0777, true)) {
        json_exit(['success'=>false, 'error'=>'Failed to create temp directory', 'code'=>902, 'files'=>[]]);
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
                json_exit(['success'=>false, 'error'=>'ZIP contains dangerous path: ' . $entry, 'code'=>903, 'files'=>$fileList]);
            }
        }
        $zip->extractTo($tmpDir);
        $zip->close();
        write_log("Unzip success: $tmpDir", $log_file);
    } else {
        rrmdir($tmpDir);
        json_exit(['success'=>false, 'error'=>'Failed to unzip', 'code'=>904, 'files'=>[]]);
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
    write_log("Exec SCP: $cmd", $log_file);
    exec($cmd . " 2>&1", $output, $return_var);
    if ($return_var !== 0) {
        rrmdir($tmpDir);
        json_exit(['success'=>false, 'error'=>'SCP upload failed: '.implode("\n",$output), 'code'=>905, 'files'=>$fileList]);
    }
    write_log("Upload success!", $log_file);

    // --- 清除暫存 ---
    rrmdir($tmpDir);
    write_log("Temp dir cleaned", $log_file);

    json_exit(['success'=>true, 'files'=>$fileList, 'code'=>0]);
} catch (Throwable $e) {
    json_exit(['success'=>false, 'error'=>'Exception: '.$e->getMessage(), 'code'=>999, 'files'=>[]]);
}
?>
