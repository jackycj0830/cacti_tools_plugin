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

        // 自動預覽 zip
        document.getElementById('zipFile').addEventListener('change', function() {
            let file = this.files[0];
            let ul = document.getElementById('fileList');
            ul.innerHTML = '';
            document.getElementById('uploadBtn').disabled = true;
            document.getElementById('progress').innerHTML = '';
            document.getElementById('message').innerHTML = '';
            if (!file) {
                return;
            }
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
            xhr.open('POST', 'updater_processes.php', true);
            xhr.upload.onprogress = function(e) {
                if (e.lengthComputable) {
                    let percent = Math.round((e.loaded / e.total) * 100);
                    document.getElementById('progress').innerText = '上傳進度: ' + percent + '%';
                }
            };
            xhr.onload = function() {
                if (xhr.status === 200) {
                    let resp;
                    try {
                        resp = JSON.parse(xhr.responseText);
                    } catch (ex) {
                        document.getElementById('message').innerHTML = '後端回傳格式錯誤！';
                        return;
                    }
                    if (resp.success) {
                        document.getElementById('message').innerHTML = '上傳成功！<br>檔案清單：<br>' + (resp.files || []).join('<br>');
                    } else {
                        document.getElementById('message').innerHTML = '錯誤：' + resp.error + ' (錯誤代碼:' + resp.code + ')';
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
