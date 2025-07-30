<?php
require_once 'includes/lang_nav.php';

// 設定根目錄
$base_dir = __DIR__ . '/docs';
$rel = $_GET['f'] ?? '';
$path = realpath($base_dir . '/' . $rel);

// 防止路徑穿越
if (!$path || strpos($path, realpath($base_dir)) !== 0) {
    die("非法路徑");
}

// 設定允許顯示/預覽的副檔名，加上 mht
$allowed_ext = ['txt', 'pdf', 'xml', 'csv', 'log', 'html', 'htm', 'md', 'png', 'jpg', 'jpeg', 'gif', 'mht'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents Browser</title>
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
        .nav-link {
            display: inline-block;
            padding: 8px 15px;
            background-color: #6a8c55;
            color: white;
            text-decoration: none;
            border-radius: 3px;
            margin: 5px 5px 5px 0;
        }
        .nav-link:hover {
            background-color: #556b45;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            margin: 8px 0;
        }
        .file-icon {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <?php outputLangNav(true, 'index.php'); ?>

    <div class="page-header">
        <h1 data-lang-key="documents">Documents Browser</h1>
    </div>

    <div class="content-container">
        <?php
        // 如果是資料夾，列出所有內容
        if (is_dir($path)) {
            echo "<h2 data-lang-key='knowledgeBrowser'>知識庫瀏覽器</h2>";
            echo "<p><b data-lang-key='currentPath'>當前路徑：</b> /docs/" . htmlspecialchars($rel) . "</p>";
            // 上層目錄
            if ($rel) {
                $parent = dirname($rel);
                echo '<a href="?f=' . urlencode($parent === '.' ? '' : $parent) . '" class="nav-link" data-lang-key="backToParent">🔙 上一層</a><br><br>';
            }
    $files = scandir($path);
    echo "<ul>";
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $file_rel = $rel ? "$rel/$file" : $file;
        $file_path = "$path/$file";
        if (is_dir($file_path)) {
            echo '<li>📁 <a href="?f=' . urlencode($file_rel) . '">' . htmlspecialchars($file) . '</a></li>';
        } else {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            // 只顯示允許副檔名檔案
            if (in_array($ext, $allowed_ext)) {
                echo '<li>📄 <a href="?f=' . urlencode($file_rel) . '">' . htmlspecialchars($file) . '</a></li>';
            }
        }
    }
    echo "</ul>";
    echo "<hr><small style='color:#888' data-lang-key='fileInstruction'>放你的Cacti/GIOS文件到 docs/ 目錄，自動顯示！</small>";
}
// 如果是檔案，根據副檔名顯示
else {
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    echo '<p><a href="?f=' . urlencode(dirname($rel)) . '" class="nav-link" data-lang-key="backToFolder">🔙 返回資料夾</a></p>';
    echo "<h3><span data-lang-key='file'>檔案</span>：" . htmlspecialchars(basename($path)) . "</h3><hr>";
    if (in_array($ext, $allowed_ext)) {
        if ($ext === 'md' || $ext === 'txt') {
            // 支援 markdown 或純文字
            $txt = file_get_contents($path);
            if ($ext === 'md') {
                $txt = htmlspecialchars($txt);
                // Markdown標題
                $txt = preg_replace('/^# (.*?)$/m', '<h1>$1</h1>', $txt);
                $txt = preg_replace('/^## (.*?)$/m', '<h2>$1</h2>', $txt);
                $txt = preg_replace('/^### (.*?)$/m', '<h3>$1</h3>', $txt);
                $txt = nl2br($txt);
            } else {
                $txt = nl2br(htmlspecialchars($txt));
            }
            echo "<div style='background:#f4f4f4;padding:1em;border-radius:8px;font-size:16px'>$txt</div>";
        }
        elseif ($ext === 'pdf') {
            echo "<embed src='docs/" . htmlspecialchars($rel) . "' type='application/pdf' width='100%' height='800px'>";
        }
        elseif ($ext === 'mht') {
            // 讀檔案內容
            $content = file_get_contents($path);
            // 正則表達式抓出 text/html 主體區塊
            $pattern = '/Content-Type: text\\/html.*?charset=([\\w-]+).*?\\r?\\n\\r?\\n(.*?)\\r?\\n--/is';
            if (preg_match($pattern, $content, $matches)) {
                $charset = trim($matches[1]);
                $html = $matches[2];
                $html = quoted_printable_decode($html);
                if (strtolower($charset) !== 'utf-8') {
                    $html = mb_convert_encoding($html, 'utf-8', $charset);
                }
                echo $html;
            } else {
                echo "<div style='color:red'>此MHT內容格式較複雜，無法自動解包！請用IE或Edge-IE模式開啟。</div>";
                echo "<p><a href='docs/" . htmlspecialchars($rel) . "' download>下載此 MHT 檔案</a></p>";
            }
        }
        elseif (in_array($ext, ['png','jpg','jpeg','gif'])) {
            echo "<img src='docs/" . htmlspecialchars($rel) . "' style='max-width:90%;max-height:700px'>";
        }
        elseif ($ext === 'html' || $ext === 'htm') {
            // 直接以網頁方式顯示 html/htm
            header('Content-Type: text/html; charset=utf-8');
            readfile($path);
        }
        else {
            // 其他允許副檔名的檔案預設下載
            echo "<a href='docs/" . htmlspecialchars($rel) . "' download class='nav-link' data-lang-key='downloadFile'>下載此檔案</a>";
        }
    } else {
        echo "<p data-lang-key='unsupportedFileType'>不支援的檔案類型</p>";
    }
}
?>
    </div>

    <script>
        // 擴展多語言配置
        if (typeof translations !== 'undefined') {
            // 英文
            translations.en.knowledgeBrowser = 'Knowledge Base Browser';
            translations.en.currentPath = 'Current Path:';
            translations.en.backToParent = '🔙 Back to Parent';
            translations.en.backToFolder = '🔙 Back to Folder';
            translations.en.file = 'File';
            translations.en.fileInstruction = 'Put your Cacti/GIOS documents in the docs/ directory for automatic display!';
            translations.en.downloadFile = 'Download this file';
            translations.en.unsupportedFileType = 'Unsupported file type';

            // 简体中文
            translations.zhHans.knowledgeBrowser = '知识库浏览器';
            translations.zhHans.currentPath = '当前路径:';
            translations.zhHans.backToParent = '🔙 返回上级';
            translations.zhHans.backToFolder = '🔙 返回文件夹';
            translations.zhHans.file = '文件';
            translations.zhHans.fileInstruction = '将您的 Cacti/GIOS 文档放在 docs/ 目录中以自动显示！';
            translations.zhHans.downloadFile = '下载此文件';
            translations.zhHans.unsupportedFileType = '不支持的文件类型';

            // 繁體中文
            translations.zhHant.knowledgeBrowser = '知識庫瀏覽器';
            translations.zhHant.currentPath = '當前路徑:';
            translations.zhHant.backToParent = '🔙 返回上層';
            translations.zhHant.backToFolder = '🔙 返回資料夾';
            translations.zhHant.file = '檔案';
            translations.zhHant.fileInstruction = '放你的Cacti/GIOS文件到 docs/ 目錄，自動顯示！';
            translations.zhHant.downloadFile = '下載此檔案';
            translations.zhHant.unsupportedFileType = '不支援的檔案類型';
        }
    </script>

</body>
</html>
