<?php
function html_escape($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$currentPath = isset($_GET['path']) ? $_GET['path'] : '../../rra/';
$currentPath = realpath($currentPath);

if ($currentPath === false || strpos($currentPath, realpath('../../rra/')) !== 0) {
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
    if ($rrdFile === false || pathinfo($rrdFile, PATHINFO_EXTENSION) !== 'rrd' || strpos($rrdFile, realpath('../rra/')) !== 0) {
        die("非法的文件路徑。\n");
    }

    // 時間範圍處理
    $startInput = isset($_GET['start']) ? $_GET['start'] : '-7 day'; // 預設查詢-7天
    $endInput = isset($_GET['end']) ? $_GET['end'] : 'now';

    $startTime = strtotime($startInput);
    $endTime = strtotime($endInput);

    if ($startTime === false || $endTime === false || $startTime >= $endTime) {
        die("無效的時間範圍。\n");
    }

    echo "<h2>處理 RRD 檔案：$rrdFile</h2>";

    // 提供返回目錄的鏈接
    $directoryPath = dirname($rrdFile);
    echo "<p><a href='?path=" . urlencode($directoryPath) . "'>返回目錄</a></p>";

    // 查詢表單
    echo "<form method='get'>";
    echo "<input type='hidden' name='file' value='" . html_escape($_GET['file']) . "' />";
    echo "開始時間: <input type='text' name='start' value='" . html_escape($startInput) . "' />";
    echo "結束時間: <input type='text' name='end' value='" . html_escape($endInput) . "' />";
    echo "<input type='submit' value='查詢' />";
    echo "</form><br>";

    // 抓 AVERAGE、MAX、lastupdate
    $cmd_avg = "rrdtool fetch $rrdFile AVERAGE --start $startTime --end $endTime";
    $cmd_max = "rrdtool fetch $rrdFile MAX --start $startTime --end $endTime";
    $cmd_last = "rrdtool lastupdate $rrdFile";

    exec($cmd_avg, $out_avg, $ret_avg);
    exec($cmd_max, $out_max, $ret_max);
    exec($cmd_last, $out_last, $ret_last);

    if ($ret_avg === 0 && $ret_max === 0 && $ret_last === 0) {
        $cur_val = null;
        foreach ($out_last as $line) {
            if (preg_match('/^\d+:\s+(.*)$/', $line, $matches)) {
                $values = preg_split('/\s+/', trim($matches[1]));
                $cur_val = is_numeric($values[0]) ? intval(round($values[0])) : null;
            }
        }

        // 解析 avg
        $avg_data = [];
        foreach ($out_avg as $line) {
            if (preg_match('/^\d+:/', $line)) {
                $parts = preg_split('/\s+/', trim($line));
                $timestamp = trim($parts[0], ':');
                $avg_data[$timestamp] = is_numeric($parts[1]) ? intval(round($parts[1])) : null;
            }
        }
        // 解析 max
        $max_data = [];
        foreach ($out_max as $line) {
            if (preg_match('/^\d+:/', $line)) {
                $parts = preg_split('/\s+/', trim($line));
                $timestamp = trim($parts[0], ':');
                $max_data[$timestamp] = is_numeric($parts[1]) ? intval(round($parts[1])) : null;
            }
        }

                // 只抓每天 6:00AM 的那一筆（timestamp 必須是當天 6:00AM）
        $rows = [];
        $numericValues = [];
        $maxValues = [];
        foreach ($avg_data as $timestamp => $avg_val) {
            $dt = new DateTime("@$timestamp");
            $dt->setTimezone(new DateTimeZone('Asia/Taipei'));
            if ($dt->format('H:i') == '06:00') {
                $readableTime = $dt->format('Y-m-d H:i:s');
                $max_val = isset($max_data[$timestamp]) ? $max_data[$timestamp] : null;
                $numericValues[] = $avg_val;
                $maxValues[] = $max_val;
                $rows[] = [$readableTime, $cur_val, $avg_val, $max_val];
            }
        }

        // === 新增這段，讓最新的日期在最上面 ===
        usort($rows, function($a, $b) {
            return strtotime($b[0]) - strtotime($a[0]);
        });
        // === 以上 ===

        $validAvg = array_filter($numericValues, 'is_numeric');
        $validMax = array_filter($maxValues, 'is_numeric');
        $average = count($validAvg) ? intval(round(array_sum($validAvg) / count($validAvg))) : 'N/A';
        $max = count($validMax) ? max($validMax) : 'N/A';
        $last = is_numeric($cur_val) ? $cur_val : 'N/A';

        echo "<h3>每日 06:00AM 統計資料（已四捨五入為整數）</h3>";
        echo "<p><strong>Cur:</strong> $last &nbsp; ";
        echo "<strong>Ave:</strong> $average &nbsp; ";
        echo "<strong>Max:</strong> $max</p>";

        echo "<table>";
        echo "<tr><th>時間</th><th>Cur</th><th>Ave</th><th style='color:red;'>Max</th></tr>";
        foreach ($rows as $row) {
            echo "<tr><td>{$row[0]}</td><td>{$row[1]}</td><td>{$row[2]}</td><td style='color:red;'>{$row[3]}</td></tr>";
        }
        echo "</table>";

    } else {
        echo "<p>提取數據時發生錯誤。</p>";
    }
    // 提供返回目錄的鏈接
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
if ($currentPath !== realpath('rra/')) {
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
