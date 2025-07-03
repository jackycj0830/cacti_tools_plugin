<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$err_msgs = [];
require_once '../thold/CONN/conn_mysql.php';

// 取得分頁參數
$page_sizes = [50, 100, 150, 200, 300];
$page_size = isset($_GET['page_size']) ? intval($_GET['page_size']) : 50;
if (!in_array($page_size, $page_sizes)) $page_size = 50;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;

// Step 1. 取得所有 Device
$devices = [];
$res = $conn->query("SELECT id, description FROM host ORDER BY description ASC");
if ($res === false) {
    $err_msgs[] = "Device SQL查詢失敗: " . $conn->error;
} else {
    while ($row = $res->fetch_assoc()) {
        $devices[] = $row;
    }
}
$device_id = isset($_GET['device_id']) ? intval($_GET['device_id']) : 0;

// Step 2. 取得圖表數量（分頁用）
$count_sql = "SELECT COUNT(*) FROM graph_local gl";
if ($device_id) {
    $count_sql .= " WHERE gl.host_id = $device_id";
}
$count_res = $conn->query($count_sql);
$total_graphs = ($count_res && ($row = $count_res->fetch_row())) ? intval($row[0]) : 0;

// 計算分頁
$total_pages = $total_graphs ? ceil($total_graphs / $page_size) : 1;
if ($page > $total_pages) $page = $total_pages;
$offset = ($page - 1) * $page_size;

// Step 3. 取得目前分頁的 Graphs
$graphs = [];
$sql = "SELECT gl.id, gl.graph_template_id, gtg.title_cache, gl.host_id, h.description AS device_name
        FROM graph_local gl
        LEFT JOIN graph_templates_graph gtg ON gl.graph_template_id = gtg.graph_template_id
        LEFT JOIN host h ON gl.host_id = h.id";
if ($device_id) {
    $sql .= " WHERE gl.host_id = $device_id";
}
$sql .= " ORDER BY h.description ASC, gtg.title_cache ASC, gl.id ASC";
$sql .= " LIMIT $offset, $page_size";
$res = $conn->query($sql);
if ($res === false) {
    $err_msgs[] = "Graph SQL查詢失敗: " . $conn->error;
} else {
    while ($row = $res->fetch_assoc()) {
        $graphs[] = [
            'id' => $row['id'],
            'graph_template_id' => $row['graph_template_id'],
            'title_cache' => $row['title_cache'],
            'host_id' => $row['host_id'],
            'device_name' => $row['device_name']
        ];
    }
}

// Step 4. 取得 RRD 資料（如有 graph_id）
$graph_id = isset($_GET['graph_id']) ? intval($_GET['graph_id']) : 0;
$rrdfile = '';
$rrd_data = [];
if ($graph_id) {
    $res = $conn->query("SELECT rrd_path FROM graph_local WHERE id=$graph_id");
    if ($res === false) {
        $err_msgs[] = "RRD SQL查詢失敗: " . $conn->error;
    } else if ($row = $res->fetch_assoc()) {
        $rrdfile = $row['rrd_path'];
        if (!$rrdfile) {
            $err_msgs[] = "查到的RRD檔案路徑是空值。";
        } else if (!file_exists($rrdfile)) {
            $err_msgs[] = "RRD檔案不存在: " . htmlspecialchars($rrdfile);
        } else {
            $cmd = 'rrdtool fetch ' . escapeshellarg($rrdfile) . ' AVERAGE --start -1d 2>&1';
            @exec($cmd, $output, $retval);
            if ($retval !== 0) {
                $err_msgs[] = "rrdtool fetch 執行失敗。指令: $cmd，返回碼: $retval，輸出: " . implode("\n", $output);
            } else {
                $rrd_data = array_slice($output, -10); // 取最後10筆
            }
        }
    } else {
        $err_msgs[] = "查無對應的Graph記錄。";
    }
}
$conn->close();

function build_query($params, $replace = []) {
    $final = array_merge($params, $replace);
    return http_build_query($final);
}

?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>Cacti RRD 圖/檔案瀏覽工具</title>
    <style>
        body { font-family: "微軟正黑體", Arial, sans-serif; background: #f9f9f9; }
        .container { width: 980px; margin: 40px auto; background: #fff; padding: 25px 30px; border-radius: 10px; }
        select, button { padding: 4px 7px; }
        code { color: #196; }
        .rrd-link { margin: 14px 0 8px 0; }
        pre { background: #f4f4f4; border-radius: 6px; padding: 8px; }
        .error { color: red; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #eee; padding: 6px 8px; }
        th { background: #f1f1f1; }
        tr.selected { background: #e2ffe2; }
        tr:hover { background: #f8fce0; }
        .pagination { margin: 18px 0; text-align: center; }
        .pagination a, .pagination span {
            margin: 0 3px; padding: 4px 9px; border-radius: 4px; text-decoration: none;
            border: 1px solid #d7d7d7; color: #555; display: inline-block;
        }
        .pagination a:hover { background: #f3ffe2; }
        .pagination .active { background: #e2ffe2; border-color: #9dc799; font-weight: bold; color: #3b5; }
    </style>
</head>
<body>
<div class="container">
    <h2>RRD 圖/數據快速瀏覽工具 (匿名訪問)</h2>

    <!-- 顯示所有錯誤訊息 -->
    <?php if (count($err_msgs) > 0): ?>
        <div class="error">
            <?php foreach ($err_msgs as $msg): ?>
                <?= nl2br(htmlspecialchars($msg)) ?><br>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="get" action="rrd_graph_viewer.php" style="display:flex;gap:2em;align-items:center;">
        <div>
            <label>裝置篩選：</label>
            <select name="device_id" onchange="this.form.submit()">
                <option value="">-- 所有裝置 --</option>
                <?php foreach ($devices as $dev): ?>
                    <option value="<?= $dev['id'] ?>" <?= $device_id==$dev['id']?'selected':'' ?>>
                        <?= htmlspecialchars($dev['description']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label>每頁顯示：</label>
            <select name="page_size" onchange="this.form.submit()">
                <?php foreach ($page_sizes as $size): ?>
                    <option value="<?= $size ?>" <?= $page_size==$size?'selected':'' ?>><?= $size ?></option>
                <?php endforeach; ?>
            </select>
            筆
        </div>
        <!-- 保持 page = 1, 不然切換篩選或 page_size 會亂跳頁 -->
        <input type="hidden" name="page" value="1">
    </form>
    <div class="pagination">
        <?php
        $base_params = [
            'device_id' => $device_id,
            'page_size' => $page_size
        ];
        $display_range = 2;
        // 第一頁
        if ($page > 1) {
            echo '<a href="?' . build_query($base_params, ['page'=>1]) . '">&laquo; 首頁</a>';
            echo '<a href="?' . build_query($base_params, ['page'=>($page-1)]) . '">&lt; 上一頁</a>';
        }
        for ($i = max(1, $page-$display_range); $i <= min($total_pages, $page+$display_range); $i++) {
            if ($i == $page) {
                echo '<span class="active">'.$i.'</span>';
            } else {
                echo '<a href="?' . build_query($base_params, ['page'=>$i]) . '">'.$i.'</a>';
            }
        }
        if ($page < $total_pages) {
            echo '<a href="?' . build_query($base_params, ['page'=>($page+1)]) . '">下一頁 &gt;</a>';
            echo '<a href="?' . build_query($base_params, ['page'=>$total_pages]) . '">末頁 &raquo;</a>';
        }
        ?>
    </div>

    <table>
        <tr>
            <th>裝置名稱</th>
            <th>圖表標題</th>
            <th>Graph ID</th>
            <th>動作</th>
        </tr>
        <?php foreach ($graphs as $g): ?>
        <tr<?= ($graph_id==$g['id']?' class="selected"':'') ?>>
            <td><?= htmlspecialchars($g['device_name']) ?></td>
            <td><?= htmlspecialchars($g['title_cache'] ?: '無標題') ?></td>
            <td><?= $g['id'] ?></td>
            <td>
                <a href="rrd_graph_viewer.php?<?= build_query([
                    'graph_id'=>$g['id'],
                    'device_id'=>$device_id,
                    'page'=>$page,
                    'page_size'=>$page_size
                ]) ?>">瀏覽資料</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($graphs)): ?>
        <tr><td colspan="4" style="text-align:center;color:#888;">無資料</td></tr>
        <?php endif; ?>
    </table>

    <div class="pagination">
        <?php
        // 再顯示一次分頁（頁尾）
        if ($page > 1) {
            echo '<a href="?' . build_query($base_params, ['page'=>1]) . '">&laquo; 首頁</a>';
            echo '<a href="?' . build_query($base_params, ['page'=>($page-1)]) . '">&lt; 上一頁</a>';
        }
        for ($i = max(1, $page-$display_range); $i <= min($total_pages, $page+$display_range); $i++) {
            if ($i == $page) {
                echo '<span class="active">'.$i.'</span>';
            } else {
                echo '<a href="?' . build_query($base_params, ['page'=>$i]) . '">'.$i.'</a>';
            }
        }
        if ($page < $total_pages) {
            echo '<a href="?' . build_query($base_params, ['page'=>($page+1)]) . '">下一頁 &gt;</a>';
            echo '<a href="?' . build_query($base_params, ['page'=>$total_pages]) . '">末頁 &raquo;</a>';
        }
        ?>
    </div>

    <?php if ($graph_id && $rrdfile): ?>
        <div class="rrd-link">
            <b>RRD 檔案：</b>
            <code><?= htmlspecialchars($rrdfile) ?></code>
        </div>
        <h4>近期 RRD 數據（10 筆）：</h4>
        <pre><?php
        if (!empty($rrd_data)) {
            echo htmlspecialchars(implode("\n", $rrd_data));
        } else {
            echo "無法讀取 RRD 資料。";
        }
        ?></pre>
    <?php endif; ?>
</div>
</body>
</html>
