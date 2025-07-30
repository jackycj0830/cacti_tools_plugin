
<?php
require_once 'includes/lang_nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cacti Log Viewer Realtime Status</title>
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
    </style>
</head>
<body>
    <?php outputLangNav(true, 'index.php'); ?>

    <div class="page-header">
        <h1 data-lang-key="realtimeStatus">Realtime Log Status</h1>
    </div>

<?php
// 定义远程主机配置
$hosts = [
    "GIOS" => ["host" => "root@172.17.32.18", "path" => "/var/log/cacti/cacti.log", "password" => "4rfvBGT%654"],
    "XM"   => ["host" => "root@172.16.144.158", "path" => "/var/log/cacti/cacti.log", "password" => "Nkdj19748*"],
    "FQ"   => ["host" => "root@172.16.30.86", "path" => "/var/log/cacti/cacti.log", "password" => "FqCacti086%"],
    "TP"   => ["host" => "root@172.16.0.8", "path" => "/var/log/cacti/cacti.log", "password" => "Ej04ru,6@1643"],
    "GZ"   => ["host" => "root@172.26.61.62", "path" => "/var/log/cacti/cacti.log", "password" => "Rumburak#55"],
    "BRMAO"=> ["host" => "root@172.31.111.19", "path" => "/var/log/cacti/cacti.log", "password" => "4rfvBGT%654"],
    "QD"   => ["host" => "root@172.16.223.77", "path" => "/var/log/cacti/cacti.log", "password" => "4rfvBGT%654"],
];

// 定义通过 SSH 读取远程日志的函数
function read_remote_log($host_name, $config, $max_lines, $display_order, $keyword = null) {
    $command = sprintf(
        "sshpass -p '%s' ssh -o StrictHostKeyChecking=no %s 'tail -n %d %s'",
        escapeshellcmd($config['password']),
        escapeshellcmd($config['host']),
        intval($max_lines),
        escapeshellcmd($config['path'])
    );

    exec($command, $output, $status);

    if ($status !== 0) {
        throw new Exception("无法读取 {$host_name} 的日志文件。请检查连接和配置。");
    }

    // 如果设置了关键字，则过滤日志
    if ($keyword) {
        $regex = "/$keyword/i";
        $output = array_filter($output, fn($line) => preg_match($regex, $line));
    }

    // 根据显示顺序调整日志顺序
    if ($display_order === 'oldest') {
        $output = array_reverse($output);
    }

    return $output;
}

// 处理用户输入
$selected_host = $_GET['host'] ?? null;
$search_keyword = $_GET['keyword'] ?? null;
$max_lines = isset($_GET['max_lines']) ? intval($_GET['max_lines']) : 5000;
$max_lines = min($max_lines, 50000); // 限制最大行數為 50000
$display_order = $_GET['display_order'] ?? 'newest';
?>

<!-- 多語言表單 -->
<div class="form-container">
    <form method="GET" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <div class="form-group">
            <label for="host" data-lang-key="selectSite">选择站点:</label>
            <select name="host" id="host" style="padding: 5px; margin-left: 10px;">
                <?php foreach (array_keys($hosts) as $host): ?>
                    <option value="<?= $host ?>" <?= ($selected_host === $host) ? "selected" : "" ?>><?= $host ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="keyword" data-lang-key="searchKeyword">搜索关键字 (可选):</label>
            <input type="text" name="keyword" id="keyword" value="<?= htmlspecialchars($search_keyword) ?>"
                   maxlength="150" style="padding: 5px; margin-left: 10px; width: 300px;">
        </div>

        <div class="form-group">
            <label for="max_lines" data-lang-key="displayLines">显示行数:</label>
            <input type="number" name="max_lines" id="max_lines" value="<?= $max_lines ?>"
                   min="1" max="50000" style="padding: 5px; margin-left: 10px; width: 100px;">
        </div>

        <div class="form-group">
            <label for="display_order" data-lang-key="displayOrder">顯示順序:</label>
            <select name="display_order" id="display_order" style="padding: 5px; margin-left: 10px;">
                <option value="newest" <?= ($display_order === 'newest') ? 'selected' : '' ?> data-lang-key="fromNewest">從最新開始</option>
                <option value="oldest" <?= ($display_order === 'oldest') ? 'selected' : '' ?> data-lang-key="fromOldest">從最舊開始</option>
            </select>
        </div>

        <div class="form-group">
            <button type="submit" data-lang-key="readLog" style="padding: 8px 20px; background-color: #2d4b23; color: white; border: none; border-radius: 3px; cursor: pointer;">读取日志</button>
        </div>
    </form>
</div>

<style>
    .form-container {
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
</style>

<?php

// 如果用户选择了站点，读取并显示日志
if ($selected_host && isset($hosts[$selected_host])) {
    try {
        $log_lines = read_remote_log($selected_host, $hosts[$selected_host], $max_lines, $display_order, $search_keyword);
        ?>

        <div class="log-results" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-top: 20px;">
            <h2><span data-lang-key="logFile">日志文件</span> (<?= $selected_host ?>)</h2>
            <p><span data-lang-key="totalLines">日誌總行數</span>: <?= $max_lines ?></p>
            <p><span data-lang-key="displayedLines">显示行数</span>: <?= count($log_lines) ?></p>

            <table border="1" style="width: 100%; border-collapse: collapse; margin-top: 15px;">
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 8px; text-align: left;" data-lang-key="lineNumber">行号</th>
                    <th style="padding: 8px; text-align: left;" data-lang-key="content">内容</th>
                </tr>
                <?php foreach ($log_lines as $i => $line): ?>
                    <?php $row_style = $i % 2 === 0 ? "background-color: #ffffff;" : "background-color: #f9f9f9;"; ?>
                    <tr style="<?= $row_style ?>">
                        <td style="padding: 8px; border: 1px solid #ddd; width: 60px; text-align: center;"><?= $i + 1 ?></td>
                        <td style="padding: 8px; border: 1px solid #ddd; font-family: monospace; font-size: 12px;"><?= htmlspecialchars($line) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <?php
    } catch (Exception $e) {
        ?>
        <div class="error-message" style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 5px; margin-top: 20px;">
            <strong data-lang-key="error">错误</strong>: <?= htmlspecialchars($e->getMessage()) ?>
        </div>
        <?php
    }
}
?>

<script>
    // 擴展多語言配置以包含此頁面特定的翻譯
    if (typeof translations !== 'undefined') {
        // 英文
        translations.en.selectSite = 'Select Site:';
        translations.en.searchKeyword = 'Search Keyword (Optional):';
        translations.en.displayLines = 'Display Lines:';
        translations.en.displayOrder = 'Display Order:';
        translations.en.fromNewest = 'From Newest';
        translations.en.fromOldest = 'From Oldest';
        translations.en.readLog = 'Read Log';
        translations.en.logFile = 'Log File';
        translations.en.totalLines = 'Total Lines';
        translations.en.displayedLines = 'Displayed Lines';
        translations.en.lineNumber = 'Line Number';
        translations.en.content = 'Content';
        translations.en.error = 'Error';

        // 简体中文
        translations.zhHans.selectSite = '选择站点:';
        translations.zhHans.searchKeyword = '搜索关键字 (可选):';
        translations.zhHans.displayLines = '显示行数:';
        translations.zhHans.displayOrder = '显示顺序:';
        translations.zhHans.fromNewest = '从最新开始';
        translations.zhHans.fromOldest = '从最旧开始';
        translations.zhHans.readLog = '读取日志';
        translations.zhHans.logFile = '日志文件';
        translations.zhHans.totalLines = '总行数';
        translations.zhHans.displayedLines = '显示行数';
        translations.zhHans.lineNumber = '行号';
        translations.zhHans.content = '内容';
        translations.zhHans.error = '错误';

        // 繁體中文
        translations.zhHant.selectSite = '選擇站點:';
        translations.zhHant.searchKeyword = '搜尋關鍵字 (可選):';
        translations.zhHant.displayLines = '顯示行數:';
        translations.zhHant.displayOrder = '顯示順序:';
        translations.zhHant.fromNewest = '從最新開始';
        translations.zhHant.fromOldest = '從最舊開始';
        translations.zhHant.readLog = '讀取日誌';
        translations.zhHant.logFile = '日誌檔案';
        translations.zhHant.totalLines = '總行數';
        translations.zhHant.displayedLines = '顯示行數';
        translations.zhHant.lineNumber = '行號';
        translations.zhHant.content = '內容';
        translations.zhHant.error = '錯誤';
    }
</script>

</body>
</html>
