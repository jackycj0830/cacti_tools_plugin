<?php
require_once 'includes/lang_nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cacti Knowledge Base</title>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body style="background:#f9faf8;">
    <?php outputLangNav(true, 'index.php'); ?>

    <nav class="navbar navbar-dark" style="background-color: #009966; margin-top: 50px;">
        <a class="navbar-brand" href="#" data-lang-key="knowledgeBase">Cacti Knowledge Base</a>
    </nav>
    <div class="container-fluid" style="padding-top:20px;">
        <div class="row">
            <div class="col-3">
                <input type="text" id="search" class="form-control mb-2" placeholder="搜尋知識庫..." data-lang-key="searchPlaceholder">
                <div id="fileTree"></div>
            </div>
            <div class="col-9">
                <div id="docContent" style="background:#fff;padding:24px;border-radius:10px;"></div>
            </div>
        </div>
    </div>

    <script src="assets/jquery.min.js"></script>
    <script src="assets/app.js"></script>

    <script>
        // 擴展多語言配置
        if (typeof translations !== 'undefined') {
            // 英文
            translations.en.knowledgeBase = 'Cacti Knowledge Base';
            translations.en.searchPlaceholder = 'Search Knowledge Base...';

            // 简体中文
            translations.zhHans.knowledgeBase = 'Cacti 知识库';
            translations.zhHans.searchPlaceholder = '搜索知识库...';

            // 繁體中文
            translations.zhHant.knowledgeBase = 'Cacti 知識庫';
            translations.zhHant.searchPlaceholder = '搜尋知識庫...';
        }

        // 更新搜索框 placeholder
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

            // 更新返回按鈕文字
            const backBtn = document.getElementById("backBtn");
            if (backBtn) {
                backBtn.innerHTML = "← " + t.back;
            }

            // 更新所有帶有 data-lang-key 屬性的元素
            document.querySelectorAll("[data-lang-key]").forEach(element => {
                const key = element.dataset.langKey;
                if (t[key]) {
                    if (element.tagName === 'INPUT' && element.type === 'text') {
                        element.placeholder = t[key];
                    } else {
                        element.textContent = t[key];
                    }
                }
            });
        }
    </script>
</body>
</html>
