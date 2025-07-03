<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$err_msgs = [];
require_once '../thold/CONN/conn_mysql.php';

// 分頁設定
$page_sizes = [50, 100, 150, 200, 300];
$page_size = isset($_GET['page_size']) ? intval($_GET['page_size']) : 50;
if (!in_array($page_size, $page_sizes)) $page_size = 50;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;

// 取得所有裝置名稱，下拉式選單用
$devices = [];
$res = $conn->query("SELECT DISTINCT description FROM host ORDER BY description ASC");
while ($row = $res->fetch_assoc()) {
    if ($row['description'] != '') $devices[] = $row['description'];
}

// 取得篩選參數（下拉選單會帶入裝置名字串）
$device_keyword = isset($_GET['device_keyword']) ? trim($_GET['device_keyword']) : '';
$filter = isset($_GET['filter']) ? trim($_GET['filter']) : '';

// 組合 WHERE 條件（裝置名用來查 name_cache 關鍵字）
$where = [];
if ($device_keyword !== '') {
    $device_keyword_esc = $conn->real_escape_string($device_keyword);
    $where[] = "dt.name_cache LIKE '%$device_keyword_esc%'";
}
if ($filter !== '') {
    $filter_esc = $conn->real_escape_string($filter);
    $where[] = "(dt.name_cache LIKE '%$filter_esc%' OR h.description LIKE '%$filter_esc%')";
}
$where_sql = $where ? "WHERE " . implode(" AND ", $where) : "";

// 總筆數（分頁用）
$count_sql = "SELECT COUNT(*) FROM data_template_data dt LEFT JOIN host h ON dt.local_data_id = h.id $where_sql";
$total_graphs = ($conn->query($count_sql)->fetch_row())[0];

// 分頁計算
$total_pages = $total_graphs ? ceil($total_graphs / $page_size) : 1;
if ($page > $total_pages) $page = $total_pages;
$offset = ($page - 1) * $page_size;

// 主要查詢
$sql = "SELECT dt.id, dt.name_cache, dt.data_source_path, h.description AS host_desc
        FROM data_template_data dt
        LEFT JOIN host h ON dt.local_data_id = h.id
        $where_sql
        ORDER BY dt.id DESC
        LIMIT $offset, $page_size";
$res = $conn->query($sql);

// RRD 瀏覽連結
function generate_rrd_url($data_source_path) {
    if (preg_match('#(\d+)/(\d+)\.rrd$#', $data_source_path, $m)) {
        $file_path = "/var/lib/cacti/rra/{$m[1]}/{$m[2]}.rrd";
        $url_path = urlencode($file_path);
        return "rrd_viewer_daily.php?file={$url_path}";
    }
    return "#";
}
?>

<h2>RRD 檔案總覽</h2>
<form class="filter-form" method="get" style="margin-bottom:10px;">
    裝置：
    <select name="device_keyword">
        <option value="">全部裝置</option>
        <?php foreach ($devices as $desc): ?>
            <option value="<?= htmlspecialchars($desc) ?>" <?= ($desc === $device_keyword ? 'selected' : '') ?>>
                <?= htmlspecialchars($desc) ?>
            </option>
        <?php endforeach; ?>
    </select>
    關鍵字搜尋: <input type="text" name="filter" value="<?= htmlspecialchars($filter) ?>" placeholder="輸入關鍵字">
    每頁顯示:
    <select name="page_size">
        <?php foreach ($page_sizes as $size): ?>
            <option value="<?= $size ?>" <?= ($size == $page_size ? 'selected' : '') ?>><?= $size ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">查詢</button>
</form>

<table style="border-collapse:collapse;width:100%;">
    <tr>
        <th style="border:1px solid #aaa;padding:5px;">ID</th>
        <th style="border:1px solid #aaa;padding:5px;">Name Cache</th>
        <th style="border:1px solid #aaa;padding:5px;">Data Source Path</th>
        <th style="border:1px solid #aaa;padding:5px;">瀏覽 RRD</th>
    </tr>
    <?php while ($row = $res->fetch_assoc()): ?>
    <tr>
        <td style="border:1px solid #aaa;padding:5px;"><?= $row['id'] ?></td>
        <td style="border:1px solid #aaa;padding:5px;"><?= htmlspecialchars($row['name_cache']) ?></td>
        <td style="border:1px solid #aaa;padding:5px;"><?= htmlspecialchars($row['data_source_path']) ?></td>
        <td style="border:1px solid #aaa;padding:5px;">
            <?php $url = generate_rrd_url($row['data_source_path']); ?>
            <a href="<?= $url ?>" style="color:blue;font-weight:bold;" onclick="window.open(this.href,'_blank');return false;">瀏覽</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<div style='margin:10px 0'>
<?php
parse_str($_SERVER['QUERY_STRING'], $params);
for ($i = 1; $i <= $total_pages; $i++) {
    $params['page'] = $i;
    $params['page_size'] = $page_size;
    $url = '?' . http_build_query($params);
    if ($i == $page) {
        echo "<strong>{$i}</strong> ";
    } else {
        echo "<a href='{$url}'>{$i}</a> ";
    }
}
?>
</div>
<?php $conn->close(); ?>
