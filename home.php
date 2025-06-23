<?php
// home.php - Cacti Tools Home Page
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>Home - Cacti Tools</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        h1, h2, h3 {
            color: #2d4b23;
        }
        .lang-switch {
            position: absolute;
            top: 20px;
            right: 30px;
        }
        .lang-switch button {
            margin-left: 6px;
            padding: 5px 10px;
            border: 1px solid #2d4b23;
            background: #fff;
            cursor: pointer;
            border-radius: 3px;
        }
        .lang-switch button.active {
            font-weight: bold;
            color: #fff;
            background: #2d4b23;
        }
        p {
            line-height: 1.8;
            font-size: 1.1em;
        }
        pre {
            background-color: #e8e8e8;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
    <script>
        function showLang(lang) {
            // 切換語言顯示
            document.querySelectorAll('.lang-content').forEach(function(div) {
                div.style.display = 'none';
            });
            document.getElementById('lang-' + lang).style.display = 'block';

            // 更新按鈕狀態
            document.querySelectorAll('.lang-switch button').forEach(function(btn) {
                btn.classList.remove('active');
            });
            document.getElementById('btn-' + lang).classList.add('active');
        }

        // 頁面加載後預設顯示English
        window.onload = function() {
            showLang('en');
        };
    </script>
</head>
<body>
    <div class="lang-switch">
        <button id="btn-en" onclick="showLang('en')">English</button>
        <button id="btn-zhHans" onclick="showLang('zhHans')">简体中文</button>
        <button id="btn-zhHant" onclick="showLang('zhHant')">繁體中文</button>
    </div>

    <!-- English -->
    <div id="lang-en" class="lang-content" style="display:none;">
        <h2>Welcome to Cacti Tools</h2>
        <p>
            This tool is designed for viewing Cacti system logs, including real-time log status and local file log checking, making it convenient for administrators to monitor and troubleshoot.
        </p>
        <p>
            Please make sure you have installed the SSHPASS tool before using. Refer to <a href="install_sshpass.php">this document</a> for setup instructions.
        </p>
        <h3>Features:</h3>
        <ul>
            <li><b>Real-time Log Status</b>: View the current system log status for real-time monitoring.</li>
            <li><b>Local File Log Check</b>: Check local system log files for detailed analysis.</li>
            <li><b>Log Knowledge Base</b>: Analyze and reference system log content.</li>
            <li><b>Log Analysis Prompts</b>: Get tips for log file analysis.</li>
            <li><b>RRD File Browser</b>: Explore local RRD files for system insights.</li>
        </ul>
    </div>

    <!-- 簡體中文 -->
    <div id="lang-zhHans" class="lang-content" style="display:none;">
        <h2>欢迎使用 Cacti Tools</h2>
        <p>
            本工具用于查看 Cacti 系统日志，包括实时日志状态与本地文件日志检查功能，方便系统管理员进行监控与排错。
        </p>
        <p>
            本工具需要先安装 SSHPASS 工具，请参考<a href="install_sshpass.php">此文档</a>进行设置安装。
        </p>
        <h3>功能说明：</h3>
        <ul>
            <li><b>实时日志状态</b>：查看当前系统日志状态，进行实时监控。</li>
            <li><b>本地文件日志检查</b>：检查系统记录的本地日志文件，分析具体内容。</li>
            <li><b>日志内容知识库</b>：分析和参考系统日志内容。</li>
            <li><b>日志分析提示词</b>：获取日志文件分析的提示和建议。</li>
            <li><b>RRD 文件浏览器</b>：浏览本地 RRD 文件以获取系统信息。</li>
        </ul>
    </div>

    <!-- 繁體中文 -->
    <div id="lang-zhHant" class="lang-content" style="display:none;">
        <h2>歡迎使用 Cacti Tools</h2>
        <p>
            本工具用於查看 Cacti 系統日誌，包括即時日誌狀態與本地文件日誌檢查功能，方便系統管理員進行監控與除錯。
        </p>
        <p>
            本工具須要先安裝SSHPASS工具，請參考<a href="install_sshpass.php">此篇文件</a>進行設定安裝。
        </p>
        <h3>功能說明：</h3>
        <ul>
            <li><b>即時日誌狀態</b>：查看當前系統日誌狀態，進行即時監控。</li>
            <li><b>本地文件日誌檢查</b>：檢查系統記錄的本地日誌文件，分析具體內容。</li>
            <li><b>日誌內容知識庫</b>：檢查系統記錄的本地日誌文件，分析具體內容。</li>
            <li><b>日誌分析提示詞</b>：檢查系統記錄的本地日誌文件，分析具體內容。</li>
            <li><b>RRD 檔案瀏覽器</b>：檢查系統記錄的本地日誌文件，分析具體內容。</li>
        </ul>
    </div>

</body>
</html>
