<?php
class LMStudioClient {
    private $apiUrl; // 基础URL，例如 http://host:port/v1
    public function __construct($apiUrl) { $this->apiUrl = rtrim($apiUrl, '/'); }

    private function doCurl($url, $method = 'GET', $payload = null, $timeout = 300) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); // 整体超时时间
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        }
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            error_log('LMStudio Curl Error: ' . curl_error($ch));
            curl_close($ch);
            return null;
        }
        curl_close($ch);
        return json_decode($result, true);
    }

    // 列出可用模型（假设 LM Studio 支持 /models 或 /models/list 端点，尝试两种）
    public function listModels($timeout = 15) {
        $res = $this->doCurl($this->apiUrl . '/models', 'GET', null, $timeout);
        if (!$res) $res = $this->doCurl($this->apiUrl . '/models/list', 'GET', null, $timeout);
        return $res;
    }

    /**
     * 发送对话
     * @param array $messages
     * @param string|null $model 指定模型
     */
    public function sendMessage(array $messages, $model = null, $timeout = 300) {
        // $timeout: 最大等待模型响应秒数（默认 300 秒）
        $payload = ['messages' => $messages];
        if ($model) $payload['model'] = $model;
        return $this->doCurl($this->apiUrl . '/chat/completions', 'POST', $payload, $timeout)
            ?: $this->doCurl($this->apiUrl, 'POST', $payload, $timeout); // 兼容旧路径
    }
}
