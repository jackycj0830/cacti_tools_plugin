<?php
/**
 * 通用多語言和導航組件
 * 為所有頁面提供統一的語言切換和返回按鈕功能
 */

// 多語言配置
$translations = [
    'en' => [
        'back' => 'Back',
        'home' => 'Home',
        'title' => 'Cacti Tools',
        'realtimeStatus' => 'Realtime Log Status',
        'backupLogCheck' => 'Backup Latest Log Check',
        'backupDateCheck' => 'Backup Log Date Check',
        'logKnowledge' => 'Log Content Knowledge Base',
        'logPrompts' => 'Log Analysis Prompts',
        'rrdViewer' => 'RRD File Browser',
        'documentation' => 'Documentation',
        'documents' => 'Documents',
        'tools' => 'Tools',
        'manage' => 'Manage',
        'updater' => 'Updater',
        'graphs' => 'Graphs',
        'status' => 'Status',
        'sharepoint' => 'Sharepoint'
    ],
    'zhHans' => [
        'back' => '返回',
        'home' => '首页',
        'title' => 'Cacti 工具',
        'realtimeStatus' => '实时日志状态',
        'backupLogCheck' => '备份最新日志检查',
        'backupDateCheck' => '备份日志日期选择检查',
        'logKnowledge' => '日志内容知识库',
        'logPrompts' => '日志分析提示词',
        'rrdViewer' => 'RRD 文件浏览器',
        'documentation' => '官方文档',
        'documents' => '文档',
        'tools' => '工具',
        'manage' => '管理',
        'updater' => '更新器',
        'graphs' => '图表',
        'status' => '状态',
        'sharepoint' => '共享资源'
    ],
    'zhHant' => [
        'back' => '返回',
        'home' => '首頁',
        'title' => 'Cacti 工具',
        'realtimeStatus' => '即時日誌狀態',
        'backupLogCheck' => '備份最新日誌檢查',
        'backupDateCheck' => '備份日誌日期選擇檢查',
        'logKnowledge' => '日誌內容知識庫',
        'logPrompts' => '日誌分析提示詞',
        'rrdViewer' => 'RRD 檔案瀏覽器',
        'documentation' => '官方文件',
        'documents' => '文件',
        'tools' => '工具',
        'manage' => '管理',
        'updater' => '更新器',
        'graphs' => '圖表',
        'status' => '狀態',
        'sharepoint' => '共享資源'
    ]
];

/**
 * 生成語言選擇器和返回按鈕的 HTML
 */
function generateLangNavHTML($showBackButton = true, $backUrl = 'index.php') {
    return '
    <!-- 語言選擇器和返回按鈕 -->
    <div class="lang-nav-container">
        ' . ($showBackButton ? '
        <div class="back-button">
            <button onclick="goBack(\'' . $backUrl . '\')" id="backBtn">← Back</button>
        </div>
        ' : '') . '
        
        <div class="language-selector">
            <select id="languageSelect" onchange="changeLanguage(this.value)">
                <option value="en">English</option>
                <option value="zhHans">简体中文</option>
                <option value="zhHant">繁體中文</option>
            </select>
        </div>
    </div>';
}

/**
 * 生成通用的 CSS 樣式
 */
function generateLangNavCSS() {
    return '
    <style>
        /* 語言導航容器 */
        .lang-nav-container {
            position: relative;
            width: 100%;
            height: 40px;
            margin-bottom: 10px;
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
            cursor: pointer;
        }
        .language-selector select:hover {
            background-color: #f0f0f0;
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
            transition: background-color 0.3s;
        }
        .back-button button:hover {
            background-color: #556b45;
        }
        
        /* 響應式設計 */
        @media (max-width: 768px) {
            .language-selector {
                top: 5px;
                right: 10px;
            }
            .back-button {
                top: 5px;
                left: 10px;
            }
            .language-selector select,
            .back-button button {
                font-size: 12px;
                padding: 3px 8px;
            }
        }
    </style>';
}

/**
 * 生成通用的 JavaScript 函數
 */
function generateLangNavJS() {
    global $translations;
    
    return '
    <script>
        // 多語言配置
        const translations = ' . json_encode($translations) . ';
        
        // 當前語言
        let currentLang = localStorage.getItem("cacti_tools_lang") || "en";
        
        // 語言切換函數
        function changeLanguage(lang) {
            currentLang = lang;
            localStorage.setItem("cacti_tools_lang", lang);
            updatePageLanguage();
            
            // 通知父窗口語言變更
            if (window.parent && window.parent !== window) {
                window.parent.postMessage({type: "languageChange", lang: lang}, "*");
            }
        }
        
        // 更新頁面語言
        function updatePageLanguage() {
            const t = translations[currentLang];
            
            // 更新 HTML lang 屬性
            document.documentElement.lang = currentLang === "zhHans" ? "zh-CN" : 
                                           currentLang === "zhHant" ? "zh-TW" : "en";
            
            // 更新返回按鈕文字
            const backBtn = document.getElementById("backBtn");
            if (backBtn) {
                backBtn.innerHTML = "← " + t.back;
            }
            
            // 更新語言選擇器
            const langSelect = document.getElementById("languageSelect");
            if (langSelect) {
                langSelect.value = currentLang;
            }
            
            // 更新頁面標題（如果有的話）
            const titleElement = document.querySelector("h1, h2, .page-title");
            if (titleElement && titleElement.dataset.titleKey) {
                titleElement.textContent = t[titleElement.dataset.titleKey] || titleElement.textContent;
            }
            
            // 更新所有帶有 data-lang-key 屬性的元素
            document.querySelectorAll("[data-lang-key]").forEach(element => {
                const key = element.dataset.langKey;
                if (t[key]) {
                    element.textContent = t[key];
                }
            });
        }
        
        // 返回上一頁
        function goBack(defaultUrl = "index.php") {
            if (window.history.length > 1) {
                window.history.back();
            } else {
                window.location.href = defaultUrl;
            }
        }
        
        // 監聽來自父窗口的語言變更消息
        window.addEventListener("message", function(event) {
            if (event.data.type === "languageChange") {
                currentLang = event.data.lang;
                localStorage.setItem("cacti_tools_lang", currentLang);
                updatePageLanguage();
            }
        });
        
        // 頁面加載完成後初始化
        document.addEventListener("DOMContentLoaded", function() {
            updatePageLanguage();
            
            // 向父窗口請求當前語言
            if (window.parent && window.parent !== window) {
                window.parent.postMessage({type: "requestLanguage"}, "*");
            }
        });
    </script>';
}

/**
 * 輸出完整的語言導航組件
 */
function outputLangNav($showBackButton = true, $backUrl = 'index.php') {
    echo generateLangNavCSS();
    echo generateLangNavHTML($showBackButton, $backUrl);
    echo generateLangNavJS();
}
?>
