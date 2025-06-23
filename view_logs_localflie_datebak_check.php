
<title>Cacti Log Viewer Localfile DateBak Check</title>
<?php
// 設置目錄路徑
$baseDir = '/var/www/html/remote_logs/BAK/';

// 檢查是否有選擇的日期
$selectedDate = isset($_GET['date']) ? $_GET['date'] : null;

// 檢查是否有選擇的Site Log
$selectedSite = isset($_GET['site']) ? $_GET['site'] : null;

// 列出所有日期資料夾
if (!$selectedDate && !$selectedSite) {
    echo "<h1>選擇日期</h1>";
    echo "<ul>";

    // 檢查目錄下所有資料夾
    if (is_dir($baseDir)) {
        $dates = array_diff(scandir($baseDir), array('.', '..')); // 排除 . 和 ..
        foreach ($dates as $date) {
            if (is_dir($baseDir . $date)) {
                // 顯示日期為超連結
                echo "<li><a href='?date=" . urlencode($date) . "'>$date</a></li>";
            }
        }
    } else {
        echo "目錄不存在或無法訪問！";
    }

    echo "</ul>";
}

// 列出選定日期下的所有 Site Log 檔案
if ($selectedDate && !$selectedSite) {
    $dateDir = $baseDir . $selectedDate . '/';
    echo "<h2>選擇日期：$selectedDate</h2>";
    echo "<h3>選擇Site Log</h3>";
    echo "<ul>";

    if (is_dir($dateDir)) {
        $sites = array_diff(scandir($dateDir), array('.', '..')); // 排除 . 和 ..
        foreach ($sites as $site) {
            // 檢查是否為檔案
            if (is_file($dateDir . $site)) {
                // 顯示 Site Log 檔案為超連結
                echo "<li><a href='?date=" . urlencode($selectedDate) . "&site=" . urlencode($site) . "'>$site</a></li>";
            }
        }
    } else {
        echo "指定的日期目錄不存在！";
    }

    echo "</ul>";
}

// 顯示選定的 Site Log 檔案內容
if ($selectedDate && $selectedSite) {
    $logFile = $baseDir . $selectedDate . '/' . $selectedSite;

    echo "<h2>選定日期：$selectedDate</h2>";
    echo "<h3>選定的Site Log：$selectedSite</h3>";

    if (is_file($logFile)) {
        echo "<pre>";
        echo htmlspecialchars(file_get_contents($logFile)); // 顯示檔案內容並轉義 HTML 特殊字符
        echo "</pre>";
    } else {
        echo "指定的Site Log檔案不存在！";
    }

    // 返回按鈕
    echo "<p><a href='?date=" . urlencode($selectedDate) . "'>返回</a></p>";
}
?>
