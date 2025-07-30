<?php
// home.php - Cacti Tools Home Page
require_once 'includes/lang_nav.php';
?>

<!DOCTYPE html>
<html lang="en">
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
        h2, h3 {
            color: #2d4b23;
        }
        .function-list {
            margin-top: 10px;
            padding: 15px 25px;
            background: #f1f1f1;
            border-radius: 8px;
            box-shadow: 0 2px 5px #ddd;
        }
        .copyright {
            text-align: center;
            color: #888;
            margin-top: 50px;
            font-size: 0.95em;
        }
        .lang-content {
            display: none;
        }
        .lang-content.active {
            display: block;
        }
    </style>
</head>
<body>
    <?php outputLangNav(false); // 不顯示返回按鈕，因為這是首頁 ?>

    <!-- English -->
    <div id="lang-en" class="lang-content">
        <h2 data-lang-key="welcomeTitle">Welcome to Cacti Tools</h2>
        <p>
            This toolset provides Cacti administrators with a collection of essential functions, making system monitoring and management more efficient and user-friendly.<br>
            Please make sure you have installed the <b>SSHPASS</b> tool before using. Refer to <a href="install_sshpass.php">this document</a> for setup instructions.
        </p>
        <h3>Features Overview</h3>
        <div class="function-list">
            <ul>
                <li><b data-lang-key="home">Home</b>: Overview of Cacti Tools and quick access to all features.</li>
                <li><b>Realtime Log Status</b>: View current system and Cacti log status in real-time.</li>
                <li><b>Backup Log Check</b>: Check and verify backup log files.</li>
                <li><b>Log Knowledge Base</b>: Access comprehensive log analysis knowledge base.</li>
                <li><b data-lang-key="rrdViewer">RRD Viewer</b>: Browse and inspect local RRD files for data insights.</li>
                <li><b data-lang-key="documents">Documents</b>: Access important documents and user guides.</li>
                <li><b data-lang-key="documentation">Documentation</b>: Official Cacti and plugin documentation reference.</li>
                <li><b data-lang-key="tools">Tools</b>: Additional system tools and utilities.</li>
                <li><b data-lang-key="manage">Manage</b>: System management, configuration, and tool settings.</li>
            </ul>
        </div>
    </div>

    <!-- 简体中文 -->
    <div id="lang-zhHans" class="lang-content">
        <h2>欢迎使用 Cacti 工具</h2>
        <p>
            本工具集为 Cacti 管理员提供了常用功能，简化系统监控与管理流程。<br>
            请确保已安装 <b>SSHPASS</b> 工具。安装参考<a href="install_sshpass.php">此文档</a>。
        </p>
        <h3>功能一览</h3>
        <div class="function-list">
            <ul>
                <li><b>首页</b>：Cacti 工具欢迎页，快速入口导航。</li>
                <li><b>实时日志状态</b>：实时查看系统与 Cacti 日志状态。</li>
                <li><b>备份日志检查</b>：检查和验证备份日志文件。</li>
                <li><b>日志知识库</b>：访问全面的日志分析知识库。</li>
                <li><b>RRD 查看器</b>：浏览并分析本地 RRD 文件，获取数据洞察。</li>
                <li><b>文档</b>：访问重要文档和用户指南。</li>
                <li><b>官方文档</b>：Cacti 及插件官方文档参考。</li>
                <li><b>工具</b>：其他系统工具和实用程序。</li>
                <li><b>管理</b>：系统管理、配置与工具设置。</li>
            </ul>
        </div>
    </div>

    <!-- 繁體中文 -->
    <div id="lang-zhHant" class="lang-content">
        <h2>歡迎使用 Cacti 工具</h2>
        <p>
            本工具組為 Cacti 管理員提供多項實用功能，簡化系統監控與管理。<br>
            請確認已安裝 <b>SSHPASS</b> 工具，安裝說明請參考<a href="install_sshpass.php">此文件</a>。
        </p>
        <h3>功能總覽</h3>
        <div class="function-list">
            <ul>
                <li><b>首頁</b>：Cacti 工具歡迎頁與快速導航。</li>
                <li><b>即時日誌狀態</b>：即時檢視系統與 Cacti 日誌狀態。</li>
                <li><b>備份日誌檢查</b>：檢查和驗證備份日誌檔案。</li>
                <li><b>日誌知識庫</b>：存取全面的日誌分析知識庫。</li>
                <li><b>RRD 檔案檢視</b>：瀏覽本地 RRD 檔案，深入瞭解數據。</li>
                <li><b>文件</b>：存取重要文件與使用手冊。</li>
                <li><b>官方文件</b>：Cacti 及擴充套件官方文件查詢。</li>
                <li><b>工具</b>：其他系統工具和實用程式。</li>
                <li><b>管理</b>：系統管理、設定與工具選項。</li>
            </ul>
        </div>
    </div>

    <div class="copyright">
        &copy; <?php echo date("Y"); ?> Cacti Tools. All rights reserved. | Powered by Jacky Zou and TPV IT Global Infrastructure Team
    </div>

    <script>
        // 擴展語言更新函數以處理首頁特定內容
        function updatePageLanguage() {
            const t = translations[currentLang];

            // 更新 HTML lang 屬性
            document.documentElement.lang = currentLang === "zhHans" ? "zh-CN" :
                                           currentLang === "zhHant" ? "zh-TW" : "en";

            // 更新語言選擇器
            const langSelect = document.getElementById("languageSelect");
            if (langSelect) {
                langSelect.value = currentLang;
            }

            // 顯示對應語言的內容
            document.querySelectorAll('.lang-content').forEach(div => {
                div.style.display = 'none';
            });

            const currentLangDiv = document.getElementById('lang-' + currentLang);
            if (currentLangDiv) {
                currentLangDiv.style.display = 'block';
            }

            // 更新所有帶有 data-lang-key 屬性的元素
            document.querySelectorAll("[data-lang-key]").forEach(element => {
                const key = element.dataset.langKey;
                if (t[key]) {
                    element.textContent = t[key];
                }
            });
        }
    </script>
</body>
</html>
