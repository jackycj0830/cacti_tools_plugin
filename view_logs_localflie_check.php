
<?php
require_once 'includes/lang_nav.php';

// 設置日志目錄路徑
$log_dir = "/var/www/html/remote_logs/log/";

// 獲取所有日誌文件
$log_files = glob($log_dir . "*.log");

// 獲取用戶選擇的日誌文件和參數
$selected_file = $_GET['log_file'] ?? null;
$search_keyword = $_GET['keyword'] ?? null;
$max_lines = isset($_GET['max_lines']) ? intval($_GET['max_lines']) : 5000;

// 限制最大行數為 50000
$max_lines = min($max_lines, 50000);

// 預設按最後一筆最新數據排序
$display_order = $_GET['display_order'] ?? 'newest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cacti Log Viewer Localfile Check</title>
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
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin: 20px 0;
        }
        .form-group {
            margin: 10px 0;
            display: flex;
            align-items: center;
        }
        .form-group label {
            min-width: 120px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php outputLangNav(true, 'index.php'); ?>

    <div class="page-header">
        <h1 data-lang-key="backupLogCheck">Backup Latest Log Check</h1>
    </div>

<?php

// 選擇文件表單
echo "<form method='GET'>";
echo "<label for='log_file'>選擇日誌文件:</label>";
echo "<select name='log_file'>";
foreach ($log_files as $file) {
    $file_name = basename($file);
    $selected = ($selected_file === $file_name) ? "selected" : "";
    echo "<option value='$file_name' $selected>$file_name</option>";
}
echo "</select>";

echo "<label for='keyword'>搜尋關鍵字 (正則表達式):</label>";
echo "<input type='text' name='keyword' value='" . htmlspecialchars($search_keyword) . "' maxlength='150' size='100'>";
echo "<br />";
echo "<label for='max_lines'>顯示行數:</label>";
echo "<input type='number' name='max_lines' value='$max_lines' min='1' max='50000'>";

echo "<label for='display_order'>顯示順序:</label>";
echo "<select name='display_order'>";
echo "<option value='newest'" . ($display_order === 'newest' ? ' selected' : '') . ">從最新開始</option>";
echo "<option value='oldest'" . ($display_order === 'oldest' ? ' selected' : '') . ">從最舊開始</option>";
echo "</select>";

echo "<button type='submit'>读取日志</button>";
echo "</form>";

// 如果選擇了文件，顯示內容
if ($selected_file) {
    $file_path = $log_dir . $selected_file;

    if (file_exists($file_path)) {
        $lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // 紀錄總行數
        $total_lines = count($lines);

        // 根據順序調整行數
        if ($display_order === 'newest') {
            $lines = array_reverse($lines);
        }

        // 限制顯示行數
        $lines = array_slice($lines, 0, $max_lines);

        // 過濾關鍵字
        $matched_lines = $lines; // 預設為未篩選
        if ($search_keyword) {
            $regex = "/$search_keyword/i";
            $matched_lines = array_filter($lines, function ($line) use ($regex) {
                return preg_match($regex, $line);
            });
        }

        // 紀錄匹配行數
        $matched_count = count($matched_lines);

        // 顯示日誌內容為表格
        echo "<h2>顯示日誌文件: $selected_file</h2>";
        echo "<p>日誌總行數: $total_lines</p>";
        echo "<p>匹配行數: $matched_count</p>";

        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<thead>";
        echo "<tr style='background-color: #f2f2f2;'>";
        echo "<th>行號</th>";
        echo "<th>日誌內容</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        $row_index = 0;
        foreach ($matched_lines as $line_number => $line) {
            // 行樣式：單數行和雙數行不同背景顏色
            $row_style = ($row_index % 2 === 0) ? "background-color: #ffffff;" : "background-color: #f9f9f9;";
            echo "<tr style='$row_style'>";
            echo "<td style='text-align: center;'>" . ($line_number + 1) . "</td>";
            echo "<td>" . htmlspecialchars($line) . "</td>";
            echo "</tr>";
            $row_index++;
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>選擇的文件不存在。</p>";
    }
}
?>

