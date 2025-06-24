<?php
require_once("../vendor/Parsedown.php");

// 僅允許 docs/ 開頭的路徑，防止路徑穿越
$path = $_GET['path'] ?? '';
if (!preg_match('/^docs\\//', $path)) exit('Access denied');

$ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

if ($ext === 'md' || $ext === 'txt') {
    $content = file_get_contents(__DIR__ . '/../' . $path);
    if ($ext === 'md') {
        $Parsedown = new Parsedown();
        $content = $Parsedown->text($content);
    } else {
        $content = nl2br(htmlspecialchars($content));
    }
    echo $content;
} else if ($ext === 'pdf') {
    echo "<embed src='$path' type='application/pdf' width='100%' height='800px'/>";
} else if (in_array($ext, ['png','jpg','jpeg','gif'])) {
    echo "<img src='$path' style='max-width:100%;'/>";
} else {
    echo "檔案類型不支援預覽。";
}
