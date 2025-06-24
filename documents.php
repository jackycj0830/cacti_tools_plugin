<?php
// 設定根目錄
$base_dir = __DIR__ . '/docs';
$rel = isset($_GET['f']) ? $_GET['f'] : '';
$path = realpath($base_dir . '/' . $rel);

// 防止路徑穿越
if (!$path || strpos($path, realpath($base_dir)) !== 0) {
    die("非法路徑");
}

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
            echo '<li>📄 <a href="?f=' . urlencode($file_rel) . '">' . htmlspecialchars($file) . '</a></li>';
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
    if ($ext === 'md' || $ext === 'txt') {
        // 支援markdown簡易轉換
        $txt = file_get_contents($path);
        if ($ext === 'md') {
            $txt = htmlspecialchars($txt);
            // Markdown換行與標題
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
    elseif (in_array($ext, ['png','jpg','jpeg','gif'])) {
        echo "<img src='docs/" . htmlspecialchars($rel) . "' style='max-width:90%;max-height:700px'>";
    }
    else {
        // 其他類型直接下載
        echo "<a href='docs/" . htmlspecialchars($rel) . "' download>下載此檔案</a>";
    }
}
?>
