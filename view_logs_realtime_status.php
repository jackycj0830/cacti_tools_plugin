
<title>Cacti Log Viewer Realtime Status</title>
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
$selected_host = isset($_GET['host']) ? $_GET['host'] : null;
$search_keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;
$max_lines = isset($_GET['max_lines']) ? intval($_GET['max_lines']) : 5000;
$max_lines = min($max_lines, 50000); // 限制最大行數為 50000
$display_order = isset($_GET['display_order']) ? $_GET['display_order'] : 'newest';

// 显示主机选择表单
echo "<h1>Cacti Log Viewer (SSH 实时连接)</h1>";
echo "<form method='GET'>";
echo "<label for='host'>选择站点:</label>";
echo "<select name='host'>";
foreach (array_keys($hosts) as $host) {
    $selected = ($selected_host === $host) ? "selected" : "";
    echo "<option value='{$host}' {$selected}>{$host}</option>";
}
echo "</select>";
echo "<label for='keyword'>搜索关键字 (可选):</label>";
echo "<input type='text' name='keyword' value='" . htmlspecialchars($search_keyword) . "' maxlength='150' size='100'>";
echo "<label for='max_lines'>显示行数:</label>";
echo "<input type='number' name='max_lines' value='{$max_lines}' min='1' max='50000'>";
echo "<label for='display_order'>顯示順序:</label>";
echo "<select name='display_order'>";
echo "<option value='newest'" . ($display_order === 'newest' ? ' selected' : '') . ">從最新開始</option>";
echo "<option value='oldest'" . ($display_order === 'oldest' ? ' selected' : '') . ">從最舊開始</option>";
echo "</select>";
echo "<button type='submit'>读取日志</button>";
echo "</form>";

// 如果用户选择了站点，读取并显示日志
if ($selected_host && isset($hosts[$selected_host])) {
    try {
        $log_lines = read_remote_log($selected_host, $hosts[$selected_host], $max_lines, $display_order, $search_keyword);

        echo "<h2>日志文件 ({$selected_host})</h2>";
        echo "<p>日誌總行數: $max_lines</p>";
        echo "<p>显示行数: " . count($log_lines) . "</p>";

        echo "<table border='1' style='width: 100%; border-collapse: collapse;'>";
        echo "<tr style='background-color: #f2f2f2;'><th>行号</th><th>内容</th></tr>";
        foreach ($log_lines as $i => $line) {
            $row_style = $i % 2 === 0 ? "background-color: #ffffff;" : "background-color: #f9f9f9;";
            echo "<tr style='{$row_style}'><td>" . ($i + 1) . "</td><td>" . htmlspecialchars($line) . "</td></tr>";
        }
        echo "</table>";
    } catch (Exception $e) {
        echo "<p>错误: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>
