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
        h2, h3 {
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
    </style>
    <script>
        function showLang(lang) {
            document.querySelectorAll('.lang-content').forEach(function(div) {
                div.style.display = 'none';
            });
            document.getElementById('lang-' + lang).style.display = 'block';
            document.querySelectorAll('.lang-switch button').forEach(function(btn) {
                btn.classList.remove('active');
            });
            document.getElementById('btn-' + lang).classList.add('active');
        }
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
            This toolset provides Cacti administrators with a collection of essential functions, making system monitoring and management more efficient and user-friendly.<br>
            Please make sure you have installed the <b>SSHPASS</b> tool before using. Refer to <a href="install_sshpass.php">this document</a> for setup instructions.
        </p>
        <h3>Features Overview</h3>
        <div class="function-list">
            <ul>
                <li><b>Home</b>: Overview of Cacti Tools and quick access to all features.</li>
                <li><b>Status</b>: View current system and Cacti status, including service health and availability.</li>
                <li><b>Sharepoint</b>: Manage and access shared resources for Cacti monitoring data.</li>
                <li><b>Graphs</b>: Visualize network and server data in interactive graphs.</li>
                <li><b>RRD Viewer</b>: Browse and inspect local RRD files for data insights.</li>
                <li><b>Documents</b>: Access important documents and user guides.</li>
                <li><b>Documentation</b>: Official Cacti and plugin documentation reference.</li>
                <li><b>Manage</b>: System management, configuration, and tool settings.</li>
                <li><b>Updater</b>: Check and apply updates for Cacti Tools and related plugins.</li>
            </ul>
        </div>
    </div>

    <!-- 简体中文 -->
    <div id="lang-zhHans" class="lang-content" style="display:none;">
        <h2>欢迎使用 Cacti Tools</h2>
        <p>
            本工具集为 Cacti 管理员提供了常用功能，简化系统监控与管理流程。<br>
            请确保已安装 <b>SSHPASS</b> 工具。安装参考<a href="install_sshpass.php">此文档</a>。
        </p>
        <h3>功能一览</h3>
        <div class="function-list">
            <ul>
                <li><b>首页</b>：Cacti 工具欢迎页，快速入口导航。</li>
                <li><b>状态</b>：查看当前系统与 Cacti 服务状态，包括服务健康与可用性。</li>
                <li><b>共享资源</b>：管理和访问 Cacti 监控数据的共享资源。</li>
                <li><b>图表</b>：可视化网络与服务器数据，展示交互式图形。</li>
                <li><b>RRD 查看器</b>：浏览并分析本地 RRD 文件，获取数据洞察。</li>
                <li><b>文档</b>：访问重要文档和用户指南。</li>
                <li><b>官方文档</b>：Cacti 及插件官方文档参考。</li>
                <li><b>管理</b>：系统管理、配置与工具设置。</li>
                <li><b>更新器</b>：检测并应用 Cacti 工具及相关插件的更新。</li>
            </ul>
        </div>
    </div>

    <!-- 繁體中文 -->
    <div id="lang-zhHant" class="lang-content" style="display:none;">
        <h2>歡迎使用 Cacti Tools</h2>
        <p>
            本工具組為 Cacti 管理員提供多項實用功能，簡化系統監控與管理。<br>
            請確認已安裝 <b>SSHPASS</b> 工具，安裝說明請參考<a href="install_sshpass.php">此文件</a>。
        </p>
        <h3>功能總覽</h3>
        <div class="function-list">
            <ul>
                <li><b>首頁</b>：Cacti 工具歡迎頁與快速導航。</li>
                <li><b>狀態</b>：檢視目前系統與 Cacti 服務狀態，包括服務健康與可用性。</li>
                <li><b>共享資源</b>：管理與存取 Cacti 監控數據的共享資源。</li>
                <li><b>圖形</b>：可視化網路與伺服器數據，互動式圖表顯示。</li>
                <li><b>RRD 檔案檢視</b>：瀏覽本地 RRD 檔案，深入瞭解數據。</li>
                <li><b>文件</b>：存取重要文件與使用手冊。</li>
                <li><b>官方文件</b>：Cacti 及擴充套件官方文件查詢。</li>
                <li><b>管理</b>：系統管理、設定與工具選項。</li>
                <li><b>更新器</b>：檢查及更新 Cacti 工具及外掛程式。</li>
            </ul>
        </div>
    </div>

    <div class="copyright">
        &copy; <?php echo date("Y"); ?> Cacti Tools. All rights reserved. | Powered by Jacky Zou and TPV IT Global Infrastructure Team
    </div>
</body>
</html>
