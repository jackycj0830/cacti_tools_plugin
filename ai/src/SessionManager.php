<?php
class SessionManager {
    private $redis;              // Redis 实例
    private $useRedis = false;   // 是否使用 Redis
    private $ttl = 1800;         // 30分钟自动清理
    private $fileDir;            // 文件回退目录

    public function __construct() {
        $this->fileDir = __DIR__ . '/../data/sessions';
        if (!is_dir($this->fileDir)) {
            @mkdir($this->fileDir, 0775, true);
        }

        // 优先尝试 Redis
        if (class_exists('Redis')) {
            $this->redis = new Redis();
            $retries = 2;
            while ($retries >= 0) {
                try {
                    $this->redis->connect('127.0.0.1', 6379, 0.5);
                    $this->useRedis = true;
                    break;
                } catch (\Exception $e) {
                    $retries--;
                    usleep(150000);
                    if ($retries < 0) {
                        error_log('[SessionManager] Redis连接失败，使用文件存储回退: ' . $e->getMessage());
                        $this->useRedis = false;
                    }
                }
            }
        } else {
            error_log('[SessionManager] Redis 扩展未安装，使用文件存储。');
        }
    }

    /**
     * 获取会话
     */
    public function getSession($sessionId) {
        if ($this->useRedis) {
            $data = $this->redis->get($sessionId);
            if ($data) return json_decode($data, true);
            return ['messages' => []];
        }
        $file = $this->filePath($sessionId);
        if (is_file($file)) {
            $data = json_decode(@file_get_contents($file), true);
            if ($data && isset($data['expire']) && $data['expire'] < time()) {
                @unlink($file);
                return ['messages' => []];
            }
            return $data ?: ['messages' => []];
        }
        return ['messages' => []];
    }

    /**
     * 保存会话
     */
    public function saveSession($sessionId, $messages) {
        $payload = ['messages' => $messages];
        if ($this->useRedis) {
            $this->redis->setex($sessionId, $this->ttl, json_encode($payload));
            return;
        }
        $data = $payload + ['expire' => time() + $this->ttl];
        @file_put_contents($this->filePath($sessionId), json_encode($data, JSON_UNESCAPED_UNICODE));
        $this->gc();
    }

    /**
     * 清理会话
     */
    public function clearSession($sessionId) {
        if ($this->useRedis) {
            $this->redis->del($sessionId);
            return;
        }
        $file = $this->filePath($sessionId);
        if (is_file($file)) @unlink($file);
    }

    /** 文件路径 */
    private function filePath($sessionId) {
        return $this->fileDir . '/' . preg_replace('/[^A-Za-z0-9_-]/', '_', $sessionId) . '.json';
    }

    /** 简单 GC */
    private function gc() {
        if (mt_rand(1, 50) !== 1) return; // 2% 触发概率
        foreach (glob($this->fileDir . '/*.json') as $file) {
            $data = json_decode(@file_get_contents($file), true);
            if (!$data || (isset($data['expire']) && $data['expire'] < time())) {
                @unlink($file);
            }
        }
    }
}
