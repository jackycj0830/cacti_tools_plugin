<!DOCTYPE html>
<html lang="en" id="html-root">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cacti Tools</title>

    <!-- 標準 favicon 設定 -->
    <link rel="icon" type="image/x-icon" href="favicon.ico">

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

        /* 語言選擇器 */
        .language-selector {
            position: absolute;
            top: 10px;
            right: 20px;
            z-index: 1000;
        }
        .language-selector select {
            padding: 5px 10px;
            border: 1px solid #2d4b23;
            background: white;
            color: #2d4b23;
            border-radius: 3px;
            font-size: 14px;
        }

        /* 返回按鈕 */
        .back-button {
            position: absolute;
            top: 10px;
            left: 20px;
            z-index: 1000;
        }
        .back-button button {
            padding: 5px 15px;
            background-color: #6a8c55;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }
        .back-button button:hover {
            background-color: #556b45;
        }

        header {
            background-color: #2d4b23;
            color: white;
            padding: 10px 20px;
            text-align: center;
            font-size: 2em;
            position: relative;
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
                font-size: 1.5em;
            }
            nav a {
                font-size: 0.9em;
                padding: 5px;
            }
            .language-selector {
                top: 5px;
                right: 10px;
            }
            .back-button {
                top: 5px;
                left: 10px;
            }
        }
    </style>

    <script>
        // 多語言配置
        const translations = {
            en: {
                title: "Cacti Tools",
                home: "Home",
                realtimeStatus: "Realtime Log Status",
                backupLogCheck: "Backup Latest Log Check",
                backupDateCheck: "Backup Log Date Check",
                logKnowledge: "Log Content Knowledge Base",
                logPrompts: "Log Analysis Prompts",
                rrdViewer: "RRD File Browser",
                documents: "Documents",
                documentation: "Documentation",
                languageTest: "Language Test",
                footer: "Cacti Tools v1.0.2 | Copyright &copy; 2024-2025 TPV Company Group.",
                versionInfo: "Version Info",
                back: "Back"
            },
            zhHans: {
                title: "Cacti 工具",
                home: "首页",
                realtimeStatus: "实时日志状态",
                backupLogCheck: "备份最新日志检查",
                backupDateCheck: "备份日志日期选择检查",
                logKnowledge: "日志内容知识库",
                logPrompts: "日志分析提示词",
                rrdViewer: "RRD 文件浏览器",
                documents: "文档",
                documentation: "官方文档",
                languageTest: "语言测试",
                footer: "Cacti 工具 v1.0.2 | 版权所有 &copy; 2024-2025 TPV 公司集团.",
                versionInfo: "版本信息",
                back: "返回"
            },
            zhHant: {
                title: "Cacti 工具",
                home: "首頁",
                realtimeStatus: "即時日誌狀態",
                backupLogCheck: "備份最新日誌檢查",
                backupDateCheck: "備份日誌日期選擇檢查",
                logKnowledge: "日誌內容知識庫",
                logPrompts: "日誌分析提示詞",
                rrdViewer: "RRD 檔案瀏覽器",
                documents: "文件",
                documentation: "官方文件",
                languageTest: "語言測試",
                footer: "Cacti 工具 v1.0.2 | 版權所有 &copy; 2024-2025 TPV 公司集團.",
                versionInfo: "版本資訊",
                back: "返回"
            }
        };

        // 當前語言
        let currentLang = localStorage.getItem('cacti_tools_lang') || 'en';

        // 語言切換函數
        function changeLanguage(lang) {
            currentLang = lang;
            localStorage.setItem('cacti_tools_lang', lang);
            updatePageLanguage();

            // 更新 iframe 中的語言
            const iframe = document.querySelector('iframe[name="content_frame"]');
            if (iframe && iframe.contentWindow) {
                try {
                    iframe.contentWindow.postMessage({type: 'languageChange', lang: lang}, '*');
                } catch (e) {
                    console.log('Cannot communicate with iframe:', e);
                }
            }
        }

        // 更新頁面語言
        function updatePageLanguage() {
            const t = translations[currentLang];
            document.getElementById('html-root').lang = currentLang === 'zhHans' ? 'zh-CN' :
                                                       currentLang === 'zhHant' ? 'zh-TW' : 'en';
            document.title = t.title;
            document.querySelector('header h1').textContent = t.title;
            document.querySelector('nav a[href*="home"]').textContent = t.home;
            document.querySelector('nav a[href*="realtime"]').textContent = t.realtimeStatus;
            document.querySelector('nav a[href*="localflie_check"]').textContent = t.backupLogCheck;
            document.querySelector('nav a[href*="datebak_check"]').textContent = t.backupDateCheck;
            document.querySelector('nav a[href*="logs_content_kb"]').textContent = t.logKnowledge;
            document.querySelector('nav a[href*="rrd_viewer"]').textContent = t.rrdViewer;
            document.querySelector('nav a[href*="documents"]').textContent = t.documents;
            document.querySelector('nav a[href*="documentation"]').textContent = t.documentation;
            document.querySelector('nav a[href*="test_lang"]').textContent = t.languageTest;
            document.querySelector('footer').innerHTML = t.footer;
            document.getElementById('versionInfoButton').textContent = t.versionInfo;
            document.querySelector('#languageSelect').value = currentLang;
        }

        // 返回上一頁
        function goBack() {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = 'index.php';
            }
        }

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

        // 初始化
        window.onload = function() {
            forceLoadFavicon();
            adjustIframeHeight();
            updatePageLanguage();
        };

        // 視窗大小變更時重新計算 iframe 高度
        window.onresize = adjustIframeHeight;

        // 監聽來自 iframe 的消息
        window.addEventListener('message', function(event) {
            if (event.data.type === 'requestLanguage') {
                event.source.postMessage({type: 'languageChange', lang: currentLang}, '*');
            }
        });
    </script>
</head>
<body>

<header>
    <!-- 返回按鈕 -->
    <div class="back-button" style="display: none;">
        <button onclick="goBack()">← Back</button>
    </div>

    <!-- 語言選擇器 -->
    <div class="language-selector">
        <select id="languageSelect" onchange="changeLanguage(this.value)">
            <option value="en">English</option>
            <option value="zhHans">简体中文</option>
            <option value="zhHant">繁體中文</option>
        </select>
    </div>

    <h1>Cacti Tools</h1>
</header>

<!-- 選單設計 -->
<nav>
    <a href="home.php" target="content_frame">Home</a>
    <a href="view_logs_realtime_status.php" target="content_frame">即時日誌狀態</a>
    <a href="view_logs_localflie_check.php" target="content_frame">備份最新日誌檢查</a>
    <a href="view_logs_localflie_datebak_check.php" target="content_frame">備份日誌日期選擇檢查</a>
    <a href="logs_content_kb.php" target="content_frame">日誌內容知識庫</a>
    <a href="rrd_viewer.php" target="content_frame">RRD 檔案瀏覽器</a>
    <a href="documents.php" target="content_frame">文件瀏覽器</a>
    <a href="documentation.php" target="content_frame">官方文件</a>
    <a href="test_lang.php" target="content_frame">語言測試</a>
</nav>

<!-- 內容區域 -->
<div class="content">
    <iframe name="content_frame" src="home.php"></iframe>
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
