<?php
require_once 'includes/lang_nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Language Test Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .page-header {
            background-color: #2d4b23;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .page-header h1 {
            margin: 0;
            font-size: 1.8em;
        }
        .content-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .test-section {
            margin: 20px 0;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php outputLangNav(true, 'index.php'); ?>
    
    <div class="page-header">
        <h1 data-lang-key="testPage">Language Test Page</h1>
    </div>

    <div class="content-container">
        <div class="test-section">
            <h2 data-lang-key="basicTest">Basic Language Test</h2>
            <p data-lang-key="testDescription">This page tests the multi-language functionality.</p>
            
            <ul>
                <li><span data-lang-key="home">Home</span></li>
                <li><span data-lang-key="realtimeStatus">Realtime Status</span></li>
                <li><span data-lang-key="backupLogCheck">Backup Log Check</span></li>
                <li><span data-lang-key="logKnowledge">Log Knowledge Base</span></li>
                <li><span data-lang-key="rrdViewer">RRD Viewer</span></li>
                <li><span data-lang-key="documents">Documents</span></li>
                <li><span data-lang-key="documentation">Documentation</span></li>
            </ul>
        </div>
        
        <div class="test-section">
            <h3 data-lang-key="instructions">Instructions</h3>
            <p data-lang-key="instructionText">Use the language selector in the top-right corner to switch between English, Simplified Chinese, and Traditional Chinese.</p>
        </div>
    </div>

    <script>
        // 擴展多語言配置
        if (typeof translations !== 'undefined') {
            // 英文
            translations.en.testPage = 'Language Test Page';
            translations.en.basicTest = 'Basic Language Test';
            translations.en.testDescription = 'This page tests the multi-language functionality.';
            translations.en.instructions = 'Instructions';
            translations.en.instructionText = 'Use the language selector in the top-right corner to switch between English, Simplified Chinese, and Traditional Chinese.';
            
            // 简体中文
            translations.zhHans.testPage = '语言测试页面';
            translations.zhHans.basicTest = '基本语言测试';
            translations.zhHans.testDescription = '此页面测试多语言功能。';
            translations.zhHans.instructions = '说明';
            translations.zhHans.instructionText = '使用右上角的语言选择器在英文、简体中文和繁体中文之间切换。';
            
            // 繁體中文
            translations.zhHant.testPage = '語言測試頁面';
            translations.zhHant.basicTest = '基本語言測試';
            translations.zhHant.testDescription = '此頁面測試多語言功能。';
            translations.zhHant.instructions = '說明';
            translations.zhHant.instructionText = '使用右上角的語言選擇器在英文、簡體中文和繁體中文之間切換。';
        }
    </script>

</body>
</html>
