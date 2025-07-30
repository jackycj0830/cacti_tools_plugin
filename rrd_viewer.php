<?php
require_once 'includes/lang_nav.php';

function html_escape($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$currentPath = isset($_GET['path']) ? $_GET['path'] : '../../rra/';
$currentPath = realpath($currentPath);

if ($currentPath === false || strpos($currentPath, realpath('../../rra/')) !== 0) {
    die("非法的目錄路徑。\n");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RRD File Browser</title>
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
        table {
            border-collapse: collapse;
            width: 100%;
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
    </style>
</head>
<body>
    <?php outputLangNav(true, 'index.php'); ?>

    <div class="page-header">
        <h1 data-lang-key="rrdViewer">RRD File Browser</h1>
    </div>

<?php

if (isset($_GET['file'])) {
    $rrdFile = realpath($_GET['file']);
    if ($rrdFile === false || pathinfo($rrdFile, PATHINFO_EXTENSION) !== 'rrd' || strpos($rrdFile, realpath('../rra/')) !== 0) {
        die("非法的文件路徑。\n");
    }

    // 時間範圍處理
    $startInput = isset($_GET['start']) ? $_GET['start'] : '-7 days';
    $endInput = isset($_GET['end']) ? $_GET['end'] : 'now';

    $startTime = strtotime($startInput);
    $endTime = strtotime($endInput);

    if ($startTime === false || $endTime === false || $startTime >= $endTime) {
        die("無效的時間範圍。\n");
    }

    ?>
    <div class="form-container">
        <h2><span data-lang-key="processingRRD">處理 RRD 檔案</span>: <?= basename($rrdFile) ?></h2>

        <p><a href="?path=<?= urlencode(dirname($rrdFile)) ?>" class="nav-link" data-lang-key="backToDirectory">返回目錄</a></p>

        <!-- 查詢表單 -->
        <form method="get">
            <input type="hidden" name="file" value="<?= html_escape($_GET['file']) ?>" />

            <div class="form-group">
                <label for="start" data-lang-key="startTime">開始時間:</label>
                <input type="text" name="start" id="start" value="<?= html_escape($startInput) ?>" style="padding: 5px; margin-left: 10px;" />
            </div>

            <div class="form-group">
                <label for="end" data-lang-key="endTime">結束時間:</label>
                <input type="text" name="end" id="end" value="<?= html_escape($endInput) ?>" style="padding: 5px; margin-left: 10px;" />
            </div>

            <div class="form-group">
                <button type="submit" data-lang-key="query" style="padding: 8px 20px; background-color: #2d4b23; color: white; border: none; border-radius: 3px; cursor: pointer;">查詢</button>
            </div>
        </form>
    </div>
    <?php

    $cmd_avg = "rrdtool fetch $rrdFile AVERAGE --start $startTime --end $endTime";
    $cmd_max = "rrdtool fetch $rrdFile MAX --start $startTime --end $endTime";
    $cmd_last = "rrdtool lastupdate $rrdFile";

    exec($cmd_avg, $out_avg, $ret_avg);
    exec($cmd_max, $out_max, $ret_max);
    exec($cmd_last, $out_last, $ret_last);

    if ($ret_avg === 0 && $ret_max === 0 && $ret_last === 0) {
        $rows = [];
        $numericValues = [];
        $maxValues = [];
        $cur_val = null;

        foreach ($out_last as $line) {
            if (preg_match('/^\d+:\s+(.*)$/', $line, $matches)) {
                $values = preg_split('/\s+/', trim($matches[1]));
                $cur_val = is_numeric($values[0]) ? floatval($values[0]) : null;
            }
        }

        $avg_data = [];
        foreach ($out_avg as $line) {
            if (preg_match('/^\d+:/', $line)) {
                $parts = preg_split('/\s+/', trim($line));
                $timestamp = trim($parts[0], ':');
                $avg_data[$timestamp] = is_numeric($parts[1]) ? floatval($parts[1]) : null;
            }
        }

        $max_data = [];
        foreach ($out_max as $line) {
            if (preg_match('/^\d+:/', $line)) {
                $parts = preg_split('/\s+/', trim($line));
                $timestamp = trim($parts[0], ':');
                $max_data[$timestamp] = is_numeric($parts[1]) ? floatval($parts[1]) : null;
            }
        }

        foreach ($avg_data as $timestamp => $avg_val) {
            $readableTime = date('Y-m-d H:i:s', $timestamp);
            $max_val = isset($max_data[$timestamp]) ? $max_data[$timestamp] : null;
            $numericValues[] = $avg_val;
            $maxValues[] = $max_val;
            $rows[] = [$readableTime, $cur_val, $avg_val, $max_val];
        }

        $validAvg = array_filter($numericValues, 'is_numeric');
        $validMax = array_filter($maxValues, 'is_numeric');

        $average = count($validAvg) ? array_sum($validAvg) / count($validAvg) : 'N/A';
        $max = count($validMax) ? max($validMax) : 'N/A';
        $last = is_numeric($cur_val) ? $cur_val : 'N/A';

        echo "<h3>統計資料</h3>";
        echo "<p><strong>Cur:</strong> " . number_format($last, 2) . " &nbsp; ";
        echo "<strong>Ave:</strong> " . number_format($average, 2) . " &nbsp; ";
        echo "<strong>Max:</strong> " . number_format($max, 2) . "</p>";

        echo "<table>";
        echo "<tr><th>時間</th><th>Cur</th><th>Ave</th><th style='color:red;'>Max</th></tr>";
        foreach ($rows as $row) {
            echo "<tr><td>{$row[0]}</td><td>" . round($row[1], 2) . "</td><td>" . round($row[2], 2) . "</td><td style='color:red;'>" . round($row[3], 2) . "</td></tr>";
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
?>

<div class="form-container">
    <h2><span data-lang-key="browseDirectory">瀏覽目錄</span>: <?= basename($currentPath) ?></h2>

    <ul style="list-style: none; padding: 0;">
        <?php if ($currentPath !== realpath('../../rra/')): ?>
            <?php $parentPath = dirname($currentPath); ?>
            <li style="margin: 5px 0;">
                <a href="?path=<?= urlencode($parentPath) ?>" class="nav-link" data-lang-key="backToParent">返回上層目錄</a>
            </li>
        <?php endif; ?>

        <?php foreach ($items as $item): ?>
            <?php if ($item === '.' || $item === '..') continue; ?>
            <?php $itemPath = realpath($currentPath . DIRECTORY_SEPARATOR . $item); ?>

            <?php if (is_dir($itemPath)): ?>
                <li style="margin: 5px 0;">
                    <a href="?path=<?= urlencode($itemPath) ?>" class="nav-link">
                        📁 [<span data-lang-key="directory">目錄</span>] <?= html_escape($item) ?>
                    </a>
                </li>
            <?php elseif (is_file($itemPath) && pathinfo($item, PATHINFO_EXTENSION) === 'rrd'): ?>
                <li style="margin: 5px 0;">
                    <a href="?file=<?= urlencode($itemPath) ?>" class="nav-link">
                        📊 [<span data-lang-key="rrdFile">RRD 文件</span>] <?= html_escape($item) ?>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>

<script>
    // 擴展多語言配置
    if (typeof translations !== 'undefined') {
        // 英文
        translations.en.processingRRD = 'Processing RRD File';
        translations.en.backToDirectory = 'Back to Directory';
        translations.en.startTime = 'Start Time:';
        translations.en.endTime = 'End Time:';
        translations.en.query = 'Query';
        translations.en.browseDirectory = 'Browse Directory';
        translations.en.backToParent = 'Back to Parent Directory';
        translations.en.directory = 'Directory';
        translations.en.rrdFile = 'RRD File';
        translations.en.timestamp = 'Timestamp';
        translations.en.currentValue = 'Current Value';
        translations.en.averageValue = 'Average Value';
        translations.en.maximumValue = 'Maximum Value';

        // 简体中文
        translations.zhHans.processingRRD = '处理 RRD 文件';
        translations.zhHans.backToDirectory = '返回目录';
        translations.zhHans.startTime = '开始时间:';
        translations.zhHans.endTime = '结束时间:';
        translations.zhHans.query = '查询';
        translations.zhHans.browseDirectory = '浏览目录';
        translations.zhHans.backToParent = '返回上级目录';
        translations.zhHans.directory = '目录';
        translations.zhHans.rrdFile = 'RRD 文件';
        translations.zhHans.timestamp = '时间戳';
        translations.zhHans.currentValue = '当前值';
        translations.zhHans.averageValue = '平均值';
        translations.zhHans.maximumValue = '最大值';

        // 繁體中文
        translations.zhHant.processingRRD = '處理 RRD 檔案';
        translations.zhHant.backToDirectory = '返回目錄';
        translations.zhHant.startTime = '開始時間:';
        translations.zhHant.endTime = '結束時間:';
        translations.zhHant.query = '查詢';
        translations.zhHant.browseDirectory = '瀏覽目錄';
        translations.zhHant.backToParent = '返回上層目錄';
        translations.zhHant.directory = '目錄';
        translations.zhHant.rrdFile = 'RRD 檔案';
        translations.zhHant.timestamp = '時間戳';
        translations.zhHant.currentValue = '目前值';
        translations.zhHant.averageValue = '平均值';
        translations.zhHant.maximumValue = '最大值';
    }
</script>

</body>
</html>
