<?php
function html_escape($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

date_default_timezone_set('Asia/Taipei');

// 目錄根路徑
$rootRrdPath = realpath('../../rra/'); // 改為你的 rrd 根目錄
$currentPath = isset($_GET['path']) ? $_GET['path'] : $rootRrdPath;
$currentPath = realpath($currentPath);

if ($currentPath === false || strpos($currentPath, $rootRrdPath) !== 0) {
    die("非法的目錄路徑。\n");
}

echo "<!DOCTYPE html>";
echo "<html lang='zh'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<title>RRD 檔案瀏覽器</title>";
echo "<style>
table { border-collapse: collapse; width: 100%; margin-top: 20px; }
th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
th { background-color: #f2f2f2; }
</style>";
echo "</head><body>";

if (isset($_GET['file'])) {
    $rrdFile = realpath($_GET['file']);
    if ($rrdFile === false || pathinfo($rrdFile, PATHINFO_EXTENSION) !== 'rrd' || strpos($rrdFile, $rootRrdPath) !== 0) {
        die("非法的文件路徑。\n");
    }

    // 最近要顯示的天數
    $daysToShow = 7; // 你可調整欲顯示天數

    echo "<h2>處理 RRD 檔案：$rrdFile</h2>";

    // 提供返回目錄的鏈接
    $directoryPath = dirname($rrdFile);
    echo "<p><a href='?path=" . urlencode($directoryPath) . "'>返回目錄</a></p>";

    // 查詢天數選擇表單
    echo "<form method='get'>";
    echo "<input type='hidden' name='file' value='" . html_escape($_GET['file']) . "' />";
    echo "顯示天數: <input type='number' name='days' min='1' max='30' value='" . (isset($_GET['days']) ? intval($_GET['days']) : $daysToShow) . "' />";
    echo "<input type='submit' value='重新查詢' />";
    echo "</form><br>";

    if (isset($_GET['days'])) {
        $daysToShow = max(1, min(30, intval($_GET['days'])));
    }

    // 生成最近N天的區間
    $sections = [];
    $now = time();

    // 找到今天的6:00AM，如果現在小於今天6:00AM，則基準點退到昨天6:00AM
    $today_6am = strtotime(date('Y-m-d 06:00:00'));
    if ($now < $today_6am) {
        $today_6am = strtotime('-1 day', $today_6am);
    }

    // 各日區間：[昨天06:01AM ~ 今天06:00AM]
    for ($i = 0; $i < $daysToShow; $i++) {
        $end = strtotime("-{$i} day", $today_6am); // 當天06:00
        $start = strtotime("-1 day", $end) + 60;   // 昨天06:01
        $sections[] = [
            'start' => $start,
            'end' => $end,
            'title' => date('Y-m-d', $end) . "（" . date('m/d H:i', $start) . "~" . date('m/d H:i', $end) . "）"
        ];
    }

    // 查詢、分析每個區間
    $rows = [];
    foreach ($sections as $section) {
        $start = $section['start'];
        $end = $section['end'];
        $dateTitle = $section['title'];

        // 取平均與最大值
        $cmd = "rrdtool fetch '$rrdFile' AVERAGE -r 60 --start $start --end $end";
        $output = shell_exec($cmd);

        // 處理 fetch 輸出
        $lines = explode("\n", trim($output));
        $values = [];
        foreach ($lines as $line) {
            if (preg_match('/^(\d+):\s+(.+)$/', $line, $matches)) {
                $val = trim($matches[2]);
                if (is_numeric($val) && strtolower($val) !== 'nan') {
                    $values[] = floatval($val);
                }
            }
        }

        $ave = count($values) ? round(array_sum($values) / count($values)) : 'N/A';
        $max = count($values) ? round(max($values)) : 'N/A';
        $cnt = count($values);

        $rows[] = [
            'date' => $dateTitle,
            'ave'  => $ave,
            'max'  => $max,
            'cnt'  => $cnt
        ];
    }

    // 顯示統計表格
    echo "<h3>每日 06:01AM~06:00AM 區間統計（四捨五入至整數）</h3>";
    echo "<table>";
    echo "<tr><th>日期 (區間)</th><th style='color:blue;'>平均 (Ave)</th><th style='color:red;'>最大 (Max)</th><th>樣本數</th></tr>";
    foreach ($rows as $row) {
        echo "<tr>";
        echo "<td>" . html_escape($row['date']) . "</td>";
        echo "<td style='color:blue;'>" . html_escape($row['ave']) . "</td>";
        echo "<td style='color:red;'>" . html_escape($row['max']) . "</td>";
        echo "<td>" . html_escape($row['cnt']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    // 返回目錄鏈接
    $directoryPath = dirname($rrdFile);
    echo "<p><a href='?path=" . urlencode($directoryPath) . "'>返回目錄</a></p>";
    echo "</body></html>";
    exit;
}

// 目錄瀏覽功能
$items = scandir($currentPath);
if ($items === false) {
    die("無法讀取目錄內容。\n");
}

echo "<h1>瀏覽目錄：$currentPath</h1><ul>";
if ($currentPath !== $rootRrdPath) {
    $parentPath = dirname($currentPath);
    echo "<li><a href='?path=" . urlencode($parentPath) . "'>返回上層目錄</a></li>";
}
foreach ($items as $item) {
    if ($item === '.' || $item === '..') continue;
    $itemPath = realpath($currentPath . DIRECTORY_SEPARATOR . $item);
    if (is_dir($itemPath)) {
        echo "<li><a href='?path=" . urlencode($itemPath) . "'>[目錄] $item</a></li>";
    } elseif (is_file($itemPath) && pathinfo($item, PATHINFO_EXTENSION) === 'rrd') {
        echo "<li><a href='?file=" . urlencode($itemPath) . "'>[RRD 文件] $item</a></li>";
    }
}
echo "</ul></body></html>";
?>
