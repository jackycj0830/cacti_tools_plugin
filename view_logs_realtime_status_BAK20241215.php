<!-- 添加按钮 -->
<div style="position: fixed; bottom: 10px; right: 10px; z-index: 9999;">
    <button id="versionInfoButton" style="padding: 10px 20px; background-color: #dfdfdf; color: black; border: none; border-radius: 5px; cursor: pointer;">
        Version Info
    </button>
</div>

<!-- 创建弹出层 -->
<div id="versionInfoPopup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80%; max-width: 600px; background: white; border: 1px solid #ccc; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); border-radius: 10px; z-index: 2000; padding: 20px;">
    <div style="text-align: right;">
        <button id="closePopupButton" style="background: none; border: none; font-size: 18px; cursor: pointer;">&times;</button>
    </div>
    <pre style="white-space: pre-wrap; word-wrap: break-word;">
 +-------------------------------------------------------------------------+
 | Cacti Log Viewer Version Information                                    |
 +-------------------------------------------------------------------------+
 | Customized PHP Pages (By Jacky Zou, editor)  v.1.0.0_20241211           |
 |   v.1.0.0_20241211: 初階測試版本。                                       |
 |                     功能需求：                                           |
 |                     1. 查看所有Site日誌文件列表                           |
 |                     2. 選擇Site日誌文件並顯示內容                         |
 |                     3. 搜索Site日誌文件中的關鍵字                         |
 |                     4. 顯示版本信息                                      |
 +-------------------------------------------------------------------------+
 | Original Author:                                                        |
 |   Cacti Log Viewer v1.0.0 (2024-12-08)                                  |
 |   Author: Jacky Zou                                                     |
 |   Email: jacky.zou@tpv-tech.com                                         |
 |   Website: https://www.cacti.net/                                       |
 +-------------------------------------------------------------------------+
 | Disclaimer:                                                             |
 |   This script is provided as is without any warranty. Use it at your own|
 |   risk. The author is not responsible for any damages or losses caused  |
 |   by the use of this script.                                            |    
 +-------------------------------------------------------------------------+
    </pre>
</div>

<!-- JavaScript 实现逻辑 -->
<script>
    document.getElementById("versionInfoButton").addEventListener("click", function() {
        document.getElementById("versionInfoPopup").style.display = "block";
    });

    document.getElementById("closePopupButton").addEventListener("click", function() {
        document.getElementById("versionInfoPopup").style.display = "none";
    });

    // 关闭弹窗时检测点击到窗口外的事件
    window.addEventListener("click", function(event) {
        const popup = document.getElementById("versionInfoPopup");
        if (event.target === popup) {
            popup.style.display = "none";
        }
    });
</script>
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
function read_remote_log($host_name, $config, $max_lines, $keyword = null) {
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

    return $output;
}

// 处理用户输入
$selected_host = isset($_GET['host']) ? $_GET['host'] : null;
$search_keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;
$max_lines = isset($_GET['max_lines']) ? intval($_GET['max_lines']) : 500;
$max_lines = min($max_lines, 5000); // 限制最大行数

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
echo "<input type='number' name='max_lines' value='{$max_lines}' min='1' max='5000'>";
echo "<button type='submit'>读取日志</button>";
echo "</form>";

// 如果用户选择了站点，读取并显示日志
if ($selected_host && isset($hosts[$selected_host])) {
    try {
        $log_lines = read_remote_log($selected_host, $hosts[$selected_host], $max_lines, $search_keyword);

        echo "<h2>日志文件 ({$selected_host})</h2>";
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
