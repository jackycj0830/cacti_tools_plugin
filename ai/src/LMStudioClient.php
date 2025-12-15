<?php
class LMStudioClient {
    private $apiUrl; // 基础URL，例如 http://host:port/v1
    public function __construct($apiUrl) { $this->apiUrl = rtrim($apiUrl, '/'); }

    private function doCurl($url, $method = 'GET', $payload = null) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
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
    public function listModels() {
        $res = $this->doCurl($this->apiUrl . '/models');
        if (!$res) $res = $this->doCurl($this->apiUrl . '/models/list');
        return $res;
    }

    /**
     * 发送对话
     * @param array $messages
     * @param string|null $model 指定模型
     */
    public function sendMessage(array $messages, $model = null) {
        $payload = ['messages' => $messages];
        if ($model) $payload['model'] = $model;
        return $this->doCurl($this->apiUrl . '/chat/completions', 'POST', $payload)
            ?: $this->doCurl($this->apiUrl, 'POST', $payload); // 兼容旧路径
    }
}
