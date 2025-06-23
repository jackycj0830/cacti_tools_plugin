<?php
// 載入 Log 資料
$logs = json_decode(file_get_contents('logs.json'), true);

// 獲取查詢參數
$type = $_GET['type'] ?? 'ALL';
$status = $_GET['status'] ?? 'ALL';
$search = $_GET['search'] ?? '';

// 過濾 Log 資料
$filteredLogs = array_filter($logs, function ($log) use ($type, $status, $search) {
    $matchesType = ($type === 'ALL') || ($log['type'] === $type);
    $matchesStatus = ($status === 'ALL') || ($log['status'] === $status);
    $matchesSearch = empty($search) || stripos($log['message_en'], $search) !== false || stripos($log['message_zh'], $search) !== false || stripos($log['ai_solution'], $search) !== false;
    return $matchesType && $matchesStatus && $matchesSearch;
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cacti Log Knowledge Base</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .filter-section { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1>Cacti Log Knowledge Base</h1><a href="logs_content_kb_update.php" target="_self">Update KB</a>
    <form method="GET" class="filter-section">
        <label for="type">Type:</label>
        <select name="type" id="type">
            <option value="ALL" <?= $type === 'ALL' ? 'selected' : '' ?>>ALL</option>
            <option value="Warnings" <?= $type === 'Warnings' ? 'selected' : '' ?>>Warnings</option>
            <option value="Errors" <?= $type === 'Errors' ? 'selected' : '' ?>>Errors</option>
            <option value="Debug" <?= $type === 'Debug' ? 'selected' : '' ?>>Debug</option>
        </select>

        <label for="status">Log Status:</label>
        <select name="status" id="status">
            <option value="ALL" <?= $status === 'ALL' ? 'selected' : '' ?>>ALL</option>
            <option value="SYSTEM" <?= $status === 'SYSTEM' ? 'selected' : '' ?>>SYSTEM</option>
            <option value="POLLER" <?= $status === 'POLLER' ? 'selected' : '' ?>>POLLER</option>
            <option value="Thold" <?= $status === 'Thold' ? 'selected' : '' ?>>Thold</option>
            <option value="FlowView" <?= $status === 'FlowView' ? 'selected' : '' ?>>FlowView</option>
            <option value="Weathermap" <?= $status === 'Weathermap' ? 'selected' : '' ?>>Weathermap</option>
            <option value="Monitor" <?= $status === 'Monitor' ? 'selected' : '' ?>>Monitor</option>
        </select>

        <label for="search">Search:</label>
        <input type="text" name="search" id="search" value="<?= htmlspecialchars($search) ?>">

        <button type="submit">Search</button>
    </form>

    <?php if (count($filteredLogs) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Message (EN)</th>
                    <th>訊息 (ZH)</th>
                    <th>AI提供的解決方案</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filteredLogs as $log): ?>
                    <tr>
                        <td><?= htmlspecialchars($log['type']) ?></td>
                        <td><?= htmlspecialchars($log['status']) ?></td>
                        <td><?= htmlspecialchars($log['message_en']) ?></td>
                        <td><?= htmlspecialchars($log['message_zh']) ?></td>
                        <td><?= htmlspecialchars($log['ai_solution']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No logs found.</p>
    <?php endif; ?>
</body>
</html>
