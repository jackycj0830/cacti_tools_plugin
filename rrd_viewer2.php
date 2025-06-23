<?php
// 獲取當前的目錄或文件路徑（來自 GET 參數）
$currentPath = isset($_GET['path']) ? $_GET['path'] : '../rra/'; // 初始目錄為 'rra/'

// 確保路徑安全，防止目錄穿越攻擊
$currentPath = realpath($currentPath);
if ($currentPath === false || strpos($currentPath, realpath('../rra/')) !== 0) {
    die("非法的目錄路徑。\n");
}

// 顯示頁面頭部
echo "<!DOCTYPE html>";
echo "<html lang='zh'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<title>RRD 檔案瀏覽器</title>";
echo "</head>";
echo "<body>";

// 如果選中了 RRD 文件，處理數據提取
if (isset($_GET['file'])) {
    $rrdFile = realpath($_GET['file']);
    if ($rrdFile === false || pathinfo($rrdFile, PATHINFO_EXTENSION) !== 'rrd' || strpos($rrdFile, realpath('../rra/')) !== 0) {
        die("非法的文件路徑。\n");
    }

    echo "<h2>處理 RRD 檔案：$rrdFile</h2>";

    // 指定數據類型和時間範圍
    $startTime = strtotime("-1 hour"); // 過去一小時
    $endTime = time(); // 當前時間

    // 使用 rrdtool fetch 提取數據
    $command = "rrdtool fetch $rrdFile AVERAGE --start $startTime --end $endTime";
    exec($command, $output, $return_var);

    // 檢查執行結果
    if ($return_var === 0) {
        echo "<pre>";
        echo "數據內容：\n";
        foreach ($output as $line) {
            // 檢查是否是有效的數據行
            if (preg_match('/^\d+:/', $line)) {
                $parts = preg_split('/\s+/', $line);
                $timestamp = trim($parts[0], ':'); // 提取時間戳
                $readableTime = date('Y-m-d H:i:s', $timestamp); // 將時間戳轉換為日期時間格式
                $dataValues = implode(' ', array_slice($parts, 1)); // 提取數據值
                echo $readableTime . " -> " . htmlspecialchars($dataValues) . "\n";
            } else {
                echo htmlspecialchars($line) . "\n"; // 顯示非數據行（如標題）
            }
        }
        echo "</pre>";
    } else {
        echo "<p>提取數據時發生錯誤。</p>";
    }

    // 提供返回目錄的鏈接
    $directoryPath = dirname($rrdFile);
    echo "<p><a href='?path=" . urlencode($directoryPath) . "'>返回目錄</a></p>";
    echo "</body>";
    echo "</html>";
    exit;
}

// 獲取當前目錄下的所有文件和子目錄
$items = scandir($currentPath);
if ($items === false) {
    die("無法讀取目錄內容。\n");
}

// 顯示當前目錄
echo "<h1>瀏覽目錄：$currentPath</h1>";
echo "<ul>";

// 添加返回上層目錄的選項
if ($currentPath !== realpath('rra/')) {
    $parentPath = dirname($currentPath);
    echo "<li><a href='?path=" . urlencode($parentPath) . "'>返回上層目錄</a></li>";
}

// 列出所有目錄和文件
foreach ($items as $item) {
    if ($item === '.' || $item === '..') {
        continue; // 跳過特殊目錄
    }

    $itemPath = realpath($currentPath . DIRECTORY_SEPARATOR . $item);
    if (is_dir($itemPath)) {
        // 如果是目錄，提供目錄鏈接
        echo "<li><a href='?path=" . urlencode($itemPath) . "'>[目錄] $item</a></li>";
    } elseif (is_file($itemPath) && pathinfo($item, PATHINFO_EXTENSION) === 'rrd') {
        // 如果是 RRD 文件，提供文件鏈接
        echo "<li><a href='?file=" . urlencode($itemPath) . "'>[RRD 文件] $item</a></li>";
    }
}
echo "</ul>";
echo "</body>";
echo "</html>";
