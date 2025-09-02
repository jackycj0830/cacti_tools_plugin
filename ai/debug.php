<?php
/**
 * Cacti AI Tools Plugin Debug 页面
 * Author: prompt-optimizer
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$phpinfo = isset($_GET['phpinfo']);
$logPath = '/var/log/php-fpm/error.log'; // 可根据实际环境调整
$logContent = '';
if (file_exists($logPath)) {
    $logContent = file_get_contents($logPath);
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>AI插件 Debug 页面</title>
    <style>
        body { font-family: 'Microsoft YaHei', Arial, sans-serif; background: #f7f7f7; }
        .debug-container { width: 800px; margin: 40px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #ccc; padding: 24px; }
        h2 { margin-top: 0; }
        pre { background: #fafafa; border: 1px solid #eee; padding: 12px; max-height: 400px; overflow-y: auto; }
        .btn { padding: 6px 16px; background: #0078d7; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        .btn-link { background: none; color: #0078d7; text-decoration: underline; border: none; cursor: pointer; }
    </style>
</head>
<body>
<div class="debug-container">
    <h2>AI插件 Debug 页面</h2>
    <form method="get" style="margin-bottom:16px;">
        <button class="btn" type="submit" name="phpinfo" value="1">显示 PHP 环境信息</button>
    </form>
    <?php if ($phpinfo): ?>
        <div style="background:#fafafa;border:1px solid #eee;padding:12px;">
            <?php phpinfo(); ?>
        </div>
    <?php else: ?>
        <h3>PHP 错误日志（<?= htmlspecialchars($logPath) ?>）</h3>
        <pre><?= htmlspecialchars($logContent ?: '日志文件不存在或无内容。') ?></pre>
        <h3>常用排查建议</h3>
        <ul>
            <li>前端控制台查看 fetch 响应内容和状态码。</li>
            <li>后端开启错误显示，查看 PHP 错误日志。</li>
            <li>确认 Redis 扩展已启用：<code>php -m | grep redis</code></li>
            <li>确认 curl 可用：<code>php -m | grep curl</code></li>
            <li>可用 <code>curl api.php</code> 测试接口响应。</li>
        </ul>
    <?php endif; ?>
</div>
</body>
</html>
