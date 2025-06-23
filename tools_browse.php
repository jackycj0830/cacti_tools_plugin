
<?php
/*
 +-------------------------------------------------------------------------+
 | Copyright (C) 2024 Jacky Zou                                           |
 | Tools plugin for Cacti - Tools File Browser                            |
 +-------------------------------------------------------------------------+
*/
$base_dir = __DIR__ . '/tools_files';
$base_url = basename(__DIR__) . '/tools_files';

function list_files($dir, $relative_path = '') {
    $files = array_diff(scandir($dir), array('.', '..'));
    echo '<ul>';
    foreach ($files as $file) {
        $full_path = "$dir/$file";
        $rel_path = ltrim("$relative_path/$file", '/');
        if (is_dir($full_path)) {
            echo "<li><strong>$file/</strong>";
            list_files($full_path, $rel_path);
            echo "</li>";
        } else {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if (in_array($ext, ['php', 'html', 'json', 'sh', 'txt'])) {
                echo "<li><a href='tools_files/$rel_path' target='_blank'>$file</a></li>";
            } else {
                echo "<li>$file</li>";
            }
        }
    }
    echo '</ul>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tools Plugin - 工具檔案瀏覽</title>
</head>
<body>
    <h2>Tools Plugin - 工具檔案瀏覽</h2>
    <p>所有內建工具如下（點擊可於新視窗開啟）：</p>
    <?php list_files($base_dir); ?>
</body>
</html>
