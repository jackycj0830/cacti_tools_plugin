<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cacti Log Viewer Tool</title>

    <!-- 標準 favicon 設定 -->
    <link rel="icon" type="image/x-icon" href="tools_files/favicon.ico">

    <style>
        /* 全局樣式 */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background-color: #2d4b23;
            color: white;
            padding: 10px 20px;
            text-align: center;
            font-size: 2em;
        }
        nav {
            display: flex;
            background-color: #4e6a36;
            padding: 10px;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin-right: 15px;
            font-size: 1em;
            padding: 5px 10px;
            background-color: #6a8c55;
            border-radius: 5px;
        }
        nav a:hover {
            background-color: #556b45;
        }
        .content {
            flex: 1;
            margin: 20px;
            padding: 20px;
            background: white;
            box-shadow: 0 0 5px rgba(0,0,0,0.3);
            overflow: auto;
        }
        iframe {
            width: 100%;
            border: none;
        }
        footer {
            background-color: #4e6a36;
            color: white;
            text-align: center;
            padding: 10px 0;
            font-size: 0.9em;
            position: sticky;
            bottom: 0;
            width: 100%;
        }
        @media (max-width: 768px) {
            header {
                font-size: 2em;
            }
            nav a {
                font-size: 0.9em;
                padding: 5px;
            }
        }
    </style>

    <script>
        // 強制載入 favicon
        function forceLoadFavicon() {
            const faviconUrls = [
                "favicon.ico",
                "favicon.png",
                "favicon.svg"
            ];

            faviconUrls.forEach(url => {
                let link = document.createElement("link");
                link.rel = "icon";
                link.href = url;
                document.head.appendChild(link);
            });
        }

        // 初始化時強制載入 favicon
        window.onload = function() {
            forceLoadFavicon();
            adjustIframeHeight();
        };

        // 調整 iframe 高度以適應螢幕大小
        function adjustIframeHeight() {
            const iframe = document.querySelector('iframe');
            if (iframe) {
                const viewportHeight = window.innerHeight;
                const headerHeight = document.querySelector('header').offsetHeight;
                const footerHeight = document.querySelector('footer').offsetHeight;
                const navHeight = document.querySelector('nav').offsetHeight;
                const contentMargin = 85;
                iframe.style.height = (viewportHeight - headerHeight - footerHeight - navHeight - contentMargin) + 'px';
            }
        }

        // 視窗大小變更時重新計算 iframe 高度
        window.onresize = adjustIframeHeight;
    </script>
</head>
<body>

<header>
    Cacti Tools
</header>

<!-- 選單設計 -->
<nav>
    <a href="tools_files/home.php" target="content_frame">Home</a>
    <a href="tools_files/view_logs_realtime_status.php" target="content_frame">即時日誌狀態</a>
    <a href="tools_files/view_logs_localflie_check.php" target="content_frame">備份最新日誌檢查</a>
    <a href="tools_files/view_logs_localflie_datebak_check.php" target="content_frame">備份日誌日期選擇檢查</a>
    <a href="tools_files/logs_content_kb.php" target="content_frame">日誌內容知識庫</a>
    <a href="tools_files/logs_ai_prompts.php" target="content_frame">日誌分析提示詞</a>
    <a href="tools_files/rrd_viewer.php" target="content_frame">RRD 檔案瀏覽器</a>
</nav>

<!-- 內容區域 -->
<div class="content">
    <iframe name="content_frame" src="tools_files/home.php"></iframe>
</div>

<footer>
    Cacti Tools v1.0.2 | 版權所有 &copy; 2024-2025 TPV Company Group.
</footer>

<!-- 版本資訊按鈕 -->
<div style="position: fixed; bottom: 10px; right: 10px; z-index: 9999;">
    <button id="versionInfoButton" style="padding: 10px 20px; background-color: #dfdfdf; color: black; border: none; border-radius: 5px; cursor: pointer;">
        Version Info
    </button>
</div>

<!-- 版本資訊彈出層 -->
<div id="versionInfoPopup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; max-width: 600px; background: white; border: 1px solid #ccc; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); border-radius: 10px; z-index: 2000; padding: 20px;">
    <div style="text-align: right;">
        <button id="closePopupButton" style="background: none; border: none; font-size: 18px; cursor: pointer;">&times;</button>
    </div>
    <pre style="white-space: pre-wrap; word-wrap: break-word;">
 +-------------------------------------------------------------------------+
 | Cacti Log Viewer Version Information                                    |
 +-------------------------------------------------------------------------+
 | Original Author:                                                        |
 |   Cacti Log Viewer v1.0.0 (2024-12-08)                                  |
 |   Author: Jacky Zou                                                     |
 |   Email: jacky.zou@tpv-tech.com                                         |
 |   Website: https://www.cacti.net/                                       |
 +-------------------------------------------------------------------------+
 | Disclaimer:                                                             |
 |   This script is provided as is without any warranty. Use it at your own|
 |   risk. The author is not responsible for any damages or losses caused  |
 |   by the use of this script.                                            |
 +-------------------------------------------------------------------------+
 | Customized PHP Pages (By Jacky Zou, editor)  v.1.0.0_20241211           |
 |v.1.0.0_20241211: 初階測試版本                                           |
 |功能需求:                                                                |
 |1.查看所有Site日誌文件列表                                              |
 |2.選擇Site日誌文件並顯示內容                                            |
 |3.搜索Site日誌文件中的關鍵字                                            |
 |4.顯示版本信息                                                           |
 +-------------------------------------------------------------------------+
    </pre>
</div>

<script>
    document.getElementById("versionInfoButton").addEventListener("click", function() {
        document.getElementById("versionInfoPopup").style.display = "block";
    });

    document.getElementById("closePopupButton").addEventListener("click", function() {
        document.getElementById("versionInfoPopup").style.display = "none";
    });
</script>

</body>
</html>
