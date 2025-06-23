<?php
// 文件路徑
$jsonFile = 'logs.json';

// 讀取 JSON 文件
if (file_exists($jsonFile)) {
    $jsonData = file_get_contents($jsonFile);
    $logs = json_decode($jsonData, true);
} else {
    die("Error: JSON file not found.");
}

// 編輯功能
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index']; // 記錄索引
    $solution_en = $_POST['solution_en']; // 英文解決方案
    $solution_zh = $_POST['solution_zh']; // 中文解決方案

    if (isset($logs[$index])) {
        // 新增解決方案欄位
        $logs[$index]['solution'] = [
            'en' => $solution_en,
            'zh' => $solution_zh
        ];

        // 保存至 JSON 文件
        file_put_contents($jsonFile, json_encode($logs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        echo "Log updated successfully!";
    } else {
        echo "Error: Invalid log index.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs Editor</title>
</head>
<body>
    <h1>Edit Logs</h1>
    <form method="POST">
        <label for="index">Log Index:</label>
        <input type="number" id="index" name="index" required>
        <br><br>
        <label for="solution_en">Solution (English):</label>
        <textarea id="solution_en" name="solution_en" required></textarea>
        <br><br>
        <label for="solution_zh">解決方案 (中文):</label>
        <textarea id="solution_zh" name="solution_zh" required></textarea>
        <br><br>
        <button type="submit">Update Log</button>
    </form>

    <h2>Existing Logs:</h2>
    <pre><?php echo htmlspecialchars(json_encode($logs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?></pre>
</body>
</html>
