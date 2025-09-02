# Cacti AI Tools Plugin

## 目录结构
```
ai/
├── plugin.php
├── setup.php
├── index.php
├── api.php
├── src/
│   ├── LMStudioClient.php
│   └── SessionManager.php
├── assets/

# Cacti AI Tools Plugin

## 目录结构
```
ai/
├── plugin.php
├── setup.php
├── index.php
├── api.php
├── src/
│   ├── LMStudioClient.php   # 使用 PHP curl 实现，无需 Guzzle
│   └── SessionManager.php   # 使用 PHP Redis 扩展实现，无需 Predis
├── assets/
│   ├── style.css
│   └── app.js
└── README.md
```

## 安装与环境要求
1. 将 `ai` 目录复制到 Cacti 插件目录下。
2. 在 Cacti 后台安装插件，自动注册菜单。
3. 配置 LM Studio API 地址（默认 http://172.16.15.112:1234/v1），如需 API Key 可在 `src/LMStudioClient.php` 设置。
4. 服务器需已安装并启用 PHP Redis 扩展（php_redis.dll），并确保 Redis 服务已启动（默认 127.0.0.1:6379）。
5. 访问插件页面，体验 AI 多轮对话。

## 功能说明
- 支持多轮对话，所有会话状态仅存储于服务器 Redis。
- 前端 AJAX 调用后端接口，页面响应时间低于 2 秒。
- 后端通过 curl 调用 LM Studio API，支持速率限制与错误处理。
- 会话自动过期清理，防止内存泄漏。

## API调用流程
1. 用户输入问题，前端通过 AJAX 发送至 `api.php`。
2. 后端读取会话历史，追加新消息。
3. 使用 curl 向 LM Studio API 发送多轮对话请求。
4. 获取回复后，存入 Redis 并返回前端。
5. 前端实时刷新对话内容。

## 对话状态存储结构（JSON示例）
```
{
  "session_id": "PHPSESSID_xxx",
  "messages": [
    {"role": "user", "content": "Cacti如何集成AI？"},
    {"role": "assistant", "content": "可通过插件调用LM Studio API实现。"}
  ]
}
```

## 性能与安全
- API速率限制：每分钟不超过60次，前端可加节流。
- 所有输入后端校验，防止XSS/SQL注入。
- 会话仅存储于Redis，前端不暴露敏感信息。
- 过期会话自动清理，防止内存泄漏。

## 维护建议
- 定期关注 LM Studio API 速率限制变化。
- 关注 Cacti 社区插件结构与权限模型更新。
- 可扩展支持 API Key、异常熔断等高级功能。
