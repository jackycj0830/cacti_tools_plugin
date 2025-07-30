<?php
require_once 'includes/lang_nav.php';

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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .page-header h1 {
            margin: 0;
            font-size: 1.8em;
        }
        .update-link {
            background-color: #6a8c55;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 3px;
        }
        .update-link:hover {
            background-color: #556b45;
        }
        .filter-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .form-group {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 10px;
        }
        .form-group label {
            font-weight: bold;
            margin-right: 5px;
        }
        .form-group select,
        .form-group input {
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
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
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .submit-btn {
            padding: 8px 20px;
            background-color: #2d4b23;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #1a2d15;
        }
    </style>
</head>
<body>
    <?php outputLangNav(true, 'index.php'); ?>

    <div class="page-header">
        <h1 data-lang-key="logKnowledge">Cacti Log Knowledge Base</h1>
        <a href="logs_content_kb_update.php" class="update-link" data-lang-key="updateKB">Update KB</a>
    </div>
    <form method="GET" class="filter-section">
        <div class="form-group">
            <label for="type" data-lang-key="type">Type:</label>
            <select name="type" id="type">
                <option value="ALL" <?= $type === 'ALL' ? 'selected' : '' ?>>ALL</option>
                <option value="Warnings" <?= $type === 'Warnings' ? 'selected' : '' ?>>Warnings</option>
                <option value="Errors" <?= $type === 'Errors' ? 'selected' : '' ?>>Errors</option>
                <option value="Debug" <?= $type === 'Debug' ? 'selected' : '' ?>>Debug</option>
            </select>
        </div>

        <div class="form-group">
            <label for="status" data-lang-key="logStatus">Log Status:</label>
            <select name="status" id="status">
                <option value="ALL" <?= $status === 'ALL' ? 'selected' : '' ?>>ALL</option>
                <option value="SYSTEM" <?= $status === 'SYSTEM' ? 'selected' : '' ?>>SYSTEM</option>
                <option value="POLLER" <?= $status === 'POLLER' ? 'selected' : '' ?>>POLLER</option>
                <option value="Thold" <?= $status === 'Thold' ? 'selected' : '' ?>>Thold</option>
                <option value="FlowView" <?= $status === 'FlowView' ? 'selected' : '' ?>>FlowView</option>
                <option value="Weathermap" <?= $status === 'Weathermap' ? 'selected' : '' ?>>Weathermap</option>
                <option value="Monitor" <?= $status === 'Monitor' ? 'selected' : '' ?>>Monitor</option>
            </select>
        </div>

        <div class="form-group">
            <label for="search" data-lang-key="search">Search:</label>
            <input type="text" name="search" id="search" value="<?= htmlspecialchars($search) ?>" style="width: 200px;">
        </div>

        <div class="form-group">
            <button type="submit" class="submit-btn" data-lang-key="searchBtn">Search</button>
        </div>
    </form>

    <?php if (count($filteredLogs) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th data-lang-key="type">Type</th>
                    <th data-lang-key="status">Status</th>
                    <th data-lang-key="messageEn">Message (EN)</th>
                    <th data-lang-key="messageZh">訊息 (ZH)</th>
                    <th data-lang-key="aiSolution">AI提供的解決方案</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($filteredLogs as $log): ?>
                    <tr>
                        <td><?= htmlspecialchars($log['type']) ?></td>
                        <td><?= htmlspecialchars($log['status']) ?></td>
                        <td style="max-width: 300px; word-wrap: break-word;"><?= htmlspecialchars($log['message_en']) ?></td>
                        <td style="max-width: 300px; word-wrap: break-word;"><?= htmlspecialchars($log['message_zh']) ?></td>
                        <td style="max-width: 400px; word-wrap: break-word;"><?= htmlspecialchars($log['ai_solution']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p data-lang-key="noLogsFound">No logs found.</p>
    <?php endif; ?>

    <script>
        // 擴展多語言配置
        if (typeof translations !== 'undefined') {
            // 英文
            translations.en.updateKB = 'Update KB';
            translations.en.type = 'Type:';
            translations.en.logStatus = 'Log Status:';
            translations.en.search = 'Search:';
            translations.en.searchBtn = 'Search';
            translations.en.status = 'Status';
            translations.en.messageEn = 'Message (EN)';
            translations.en.messageZh = 'Message (ZH)';
            translations.en.aiSolution = 'AI Solution';
            translations.en.noLogsFound = 'No logs found.';

            // 简体中文
            translations.zhHans.updateKB = '更新知识库';
            translations.zhHans.type = '类型:';
            translations.zhHans.logStatus = '日志状态:';
            translations.zhHans.search = '搜索:';
            translations.zhHans.searchBtn = '搜索';
            translations.zhHans.status = '状态';
            translations.zhHans.messageEn = '消息 (英文)';
            translations.zhHans.messageZh = '消息 (中文)';
            translations.zhHans.aiSolution = 'AI 解决方案';
            translations.zhHans.noLogsFound = '未找到日志。';

            // 繁體中文
            translations.zhHant.updateKB = '更新知識庫';
            translations.zhHant.type = '類型:';
            translations.zhHant.logStatus = '日誌狀態:';
            translations.zhHant.search = '搜尋:';
            translations.zhHant.searchBtn = '搜尋';
            translations.zhHant.status = '狀態';
            translations.zhHant.messageEn = '訊息 (英文)';
            translations.zhHant.messageZh = '訊息 (中文)';
            translations.zhHant.aiSolution = 'AI 解決方案';
            translations.zhHant.noLogsFound = '未找到日誌。';
        }
    </script>

</body>
</html>
