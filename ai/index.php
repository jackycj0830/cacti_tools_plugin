<?php
/**
 * Cacti AI Tools Plugin 前端页面
 * Author: prompt-optimizer
 */
session_start();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>Cacti AI 对话助手</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="ai-chat-container">
    <h2>AI 智能对话助手</h2>
    <div style="text-align:right;margin-bottom:8px;">
        <a href="debug.php" target="_blank" style="color:#0078d7;text-decoration:underline;font-size:14px;">进入Debug页面</a>
    </div>
    <div id="chat-box"></div>
    <form id="chat-form">
        <select id="model-select" style="min-width:140px;margin-right:8px;">
            <option value="" disabled selected>加载模型列表...</option>
        </select>
        <input type="text" id="user-input" placeholder="请输入您的问题..." autocomplete="off" required />
        <button type="submit">发送</button>
    </form>
    <div id="error-msg"></div>
</div>
<script src="assets/app.js"></script>
</body>
</html>
