<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/**
 * Cacti AI Tools Plugin AJAX后端接口
 * Author: prompt-optimizer
 */

require_once __DIR__ . '/src/LMStudioClient.php';
require_once __DIR__ . '/src/SessionManager.php';
session_start();
header('Content-Type: application/json');

// 统一响应函数
function respond($data, $code = 200) {
    http_response_code($code);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

$rawInput = file_get_contents('php://input');
error_log('[AI api] RAW: ' . $rawInput);
$input = json_decode($rawInput, true);
if (!is_array($input)) respond(['error' => 'INVALID_JSON']);

$sessionId = session_id();
$action = $input['action'] ?? null;
if ($action === 'clear') {
    $session = new SessionManager();
    $session->clearSession($sessionId);
    respond(['cleared' => true, 'messages' => []]);
} elseif ($action === 'models') {
    $lmTmp = new LMStudioClient('http://172.16.15.112:1234/v1');
    $modelsRaw = $lmTmp->listModels();
    respond(['models' => $modelsRaw]);
} elseif ($action !== null) {
    respond(['error' => 'UNSUPPORTED_ACTION']);
}

$userMsg = isset($input['message']) ? trim($input['message']) : '';
if ($userMsg === '') respond(['error' => 'EMPTY_MESSAGE']);

// 简单速率限制（基于 session + 时间窗口）
if (!isset($_SESSION['ai_rate'])) $_SESSION['ai_rate'] = [];
$now = time();
$_SESSION['ai_rate'] = array_filter($_SESSION['ai_rate'], function($t) use ($now){ return $t > $now - 60; });
if (count($_SESSION['ai_rate']) >= 60) respond(['error' => 'RATE_LIMIT']);
$_SESSION['ai_rate'][] = $now;

$session = new SessionManager();
$data = $session->getSession($sessionId);
$messages = $data['messages'] ?? [];
if (count($messages) > 20) $messages = array_slice($messages, -20);
$model = isset($input['model']) ? trim($input['model']) : null;
$messages[] = ['role' => 'user', 'content' => mb_substr($userMsg, 0, 2000)];

$lm = new LMStudioClient('http://172.16.15.112:1234/v1');
$start = microtime(true);
$timeout = isset($input['timeout']) ? max(5, min(300, intval($input['timeout']))) : 300; // 允许前端指定 5-300 秒
$result = $lm->sendMessage($messages, $model, $timeout);
$duration = round((microtime(true) - $start) * 1000);
error_log('[AI api] duration=' . $duration . 'ms');

if ($result && isset($result['choices'][0]['message']['content'])) {
    $reply = $result['choices'][0]['message']['content'];
    $messages[] = ['role' => 'assistant', 'content' => $reply];
    $session->saveSession($sessionId, $messages);
    respond(['reply' => $reply, 'messages' => $messages, 'time_ms' => $duration]);
}
error_log('[AI api] model raw response: ' . json_encode($result));
respond(['error' => 'MODEL_FAILURE']);
