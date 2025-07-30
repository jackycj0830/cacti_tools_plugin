<?php
// 設定根目錄
$base_dir = __DIR__ . '/docs';
$rel = isset($_GET['f']) ? $_GET['f'] : '';
$path = realpath($base_dir . '/' . $rel);

// 防止路徑穿越
if (!$path || strpos($path, realpath($base_dir)) !== 0) {
    die("非法路徑");
}

// 設定允許顯示/預覽的副檔名，加上 mht
$allowed_ext = ['txt', 'pdf', 'xml', 'csv', 'log', 'html', 'htm', 'md', 'png', 'jpg', 'jpeg', 'gif', 'mht'];

// 如果是資料夾，列出所有內容
if (is_dir($path)) {
    echo "<h2>知識庫瀏覽器</h2>";
    echo "<p><b>當前路徑：</b> /docs/" . htmlspecialchars($rel) . "</p>";
    // 上層目錄
    if ($rel) {
        $parent = dirname($rel);
        echo '<a href="?f=' . urlencode($parent === '.' ? '' : $parent) . '">🔙 上一層</a><br><br>';
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
    echo "<hr><small style='color:#888'>放你的Cacti/GIOS文件到 docs/ 目錄，自動顯示！</small>";
}
// 如果是檔案，根據副檔名顯示
else {
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    echo '<p><a href="?f=' . urlencode(dirname($rel)) . '">🔙 返回資料夾</a></p>';
    echo "<h3>檔案：" . htmlspecialchars(basename($path)) . "</h3><hr>";
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
            echo "<a href='docs/" . htmlspecialchars($rel) . "' download>下載此檔案</a>";
        }
    } else {
        echo "不支援的檔案類型";
    }
}
?>
