<?php
/**
 * Bulk IP Query + VirusTotal - Combined Standalone Page
 * 批量IP查詢 + VirusTotal 信譽查詢 整合工具 - 獨立頁面
 *
 * Combines blacklist query (bulk_query.php) and VirusTotal query (query_virustotal.php)
 * into a single unified interface with dual query capability.
 *
 * - Batch size: 4 IPs per batch (VT free tier: 4 req/min)
 * - Batch delay: 60 seconds between batches
 * - Dual write: Results saved to ip_cache + ip_database
 * - Logging: All operations logged to `log` table
 *
 * @version 1.0.0
 */

// =====================================================
// PHP Backend - API Proxy & Helper Functions
// =====================================================
if (isset($_GET['action'])) {
    header('Content-Type: application/json; charset=utf-8');

    // =================================================================
    // Helper function definitions — must be defined BEFORE action routing
    // so they are available when called by any action handler.
    // 輔助函式定義 — 必須在動作路由之前定義，避免 HTTP 500 錯誤。
    // =================================================================

    /**
     * Helper: Get a PDO connection to MySQL using existing db_config
     */
    function getApiKeyPDO() {
        require_once __DIR__ . '/database/db_config.php';
        if (DB_TYPE !== 'mysql') {
            return null;
        }
        $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s',
            MYSQL_HOST, MYSQL_PORT, MYSQL_DATABASE, MYSQL_CHARSET);
        $pdo = new PDO($dsn, MYSQL_USERNAME, MYSQL_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        $pdo->exec("CREATE TABLE IF NOT EXISTS api_keys (
            id INT AUTO_INCREMENT PRIMARY KEY,
            service_name VARCHAR(50) NOT NULL DEFAULT 'virustotal',
            key_label VARCHAR(100) DEFAULT NULL,
            api_key VARCHAR(255) NOT NULL,
            is_active TINYINT(1) NOT NULL DEFAULT 1,
            last_used_at DATETIME DEFAULT NULL,
            usage_count INT NOT NULL DEFAULT 0,
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_service (service_name),
            INDEX idx_active (is_active),
            UNIQUE KEY uk_service_key (service_name, api_key(191))
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        return $pdo;
    }

    /**
     * Helper: Get a PDO connection for logging
     */
    function getLogPDO() {
        require_once __DIR__ . '/database/db_config.php';
        if (DB_TYPE !== 'mysql') {
            return null;
        }
        $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s',
            MYSQL_HOST, MYSQL_PORT, MYSQL_DATABASE, MYSQL_CHARSET);
        $pdo = new PDO($dsn, MYSQL_USERNAME, MYSQL_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        $pdo->exec("CREATE TABLE IF NOT EXISTS log (
            id INT AUTO_INCREMENT PRIMARY KEY,
            log_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            log_level VARCHAR(20) NOT NULL,
            source VARCHAR(50) NOT NULL,
            ip_address VARCHAR(45) DEFAULT NULL,
            message TEXT NOT NULL,
            details JSON DEFAULT NULL,
            INDEX idx_time (log_time),
            INDEX idx_level (log_level),
            INDEX idx_source (source)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        return $pdo;
    }

    /**
     * Write a log entry to the `log` table.
     * Fail-safe: errors are silently caught so they don't break the response.
     */
    function writeLog($level, $source, $message, $ip = null, $details = null) {
        try {
            $pdo = getLogPDO();
            if (!$pdo) return false;
            $stmt = $pdo->prepare("INSERT INTO log (log_level, source, ip_address, message, details) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$level, $source, $ip, $message, $details ? json_encode($details) : null]);
            return true;
        } catch (Exception $e) {
            error_log("Log write failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Save VT query result to ip_cache and ip_database tables.
     * Uses INSERT ... ON DUPLICATE KEY UPDATE to only update VT-specific columns,
     * preserving existing GeoIP/blacklist data if the IP already exists.
     *
     * @param string $ip IP address
     * @param array $vtData Parsed VT result data
     * @return bool Whether the save was successful
     */
    function saveVTResultToCache($ip, array $vtData) {
        try {
            require_once __DIR__ . '/database/db_config.php';
            if (DB_TYPE !== 'mysql') {
                return false;
            }
            $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s',
                MYSQL_HOST, MYSQL_PORT, MYSQL_DATABASE, MYSQL_CHARSET);
            $pdo = new PDO($dsn, MYSQL_USERNAME, MYSQL_PASSWORD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

            $now = date('Y-m-d H:i:s');
            $vtLink = 'https://www.virustotal.com/gui/ip-address/' . $ip;

            // --- Write to ip_cache (INSERT or UPDATE VT fields only) ---
            $sql = "INSERT INTO ip_cache
                (ip_address, status, country_code, org, asn,
                 vt_malicious, vt_suspicious, vt_harmless, vt_undetected,
                 vt_detection_flagged, vt_detection_total, vt_link, vt_queried_at,
                 created_at, updated_at, expires_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    vt_malicious = VALUES(vt_malicious),
                    vt_suspicious = VALUES(vt_suspicious),
                    vt_harmless = VALUES(vt_harmless),
                    vt_undetected = VALUES(vt_undetected),
                    vt_detection_flagged = VALUES(vt_detection_flagged),
                    vt_detection_total = VALUES(vt_detection_total),
                    vt_link = VALUES(vt_link),
                    vt_queried_at = VALUES(vt_queried_at),
                    updated_at = VALUES(updated_at)";


            $expiresAt = date('Y-m-d H:i:s', time() + 86400);
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $ip,
                $vtData['status'] ?? 'safe',
                $vtData['country'] ?? null,
                $vtData['as_owner'] ?? null,
                $vtData['network'] ?? null,
                $vtData['malicious'] ?? 0,
                $vtData['suspicious'] ?? 0,
                $vtData['harmless'] ?? 0,
                $vtData['undetected'] ?? 0,
                $vtData['flagged'] ?? 0,
                $vtData['total'] ?? 0,
                $vtLink,
                $now,
                $now, $now, $expiresAt
            ]);

            // --- Write to ip_database archive table (same pattern) ---
            $archiveSql = "INSERT INTO ip_database
                (ip_address, status, country_code, org, asn,
                 vt_malicious, vt_suspicious, vt_harmless, vt_undetected,
                 vt_detection_flagged, vt_detection_total, vt_link, vt_queried_at,
                 original_created_at, archived_at, total_hit_count)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)
                ON DUPLICATE KEY UPDATE
                    vt_malicious = VALUES(vt_malicious),
                    vt_suspicious = VALUES(vt_suspicious),
                    vt_harmless = VALUES(vt_harmless),
                    vt_undetected = VALUES(vt_undetected),
                    vt_detection_flagged = VALUES(vt_detection_flagged),
                    vt_detection_total = VALUES(vt_detection_total),
                    vt_link = VALUES(vt_link),
                    vt_queried_at = VALUES(vt_queried_at),
                    archived_at = VALUES(archived_at),
                    total_hit_count = total_hit_count + 1";

            $archiveStmt = $pdo->prepare($archiveSql);
            $archiveStmt->execute([
                $ip,
                $vtData['status'] ?? 'safe',
                $vtData['country'] ?? null,
                $vtData['as_owner'] ?? null,
                $vtData['network'] ?? null,
                $vtData['malicious'] ?? 0,
                $vtData['suspicious'] ?? 0,
                $vtData['harmless'] ?? 0,
                $vtData['undetected'] ?? 0,
                $vtData['flagged'] ?? 0,
                $vtData['total'] ?? 0,
                $vtLink,
                $now,
                $now, $now
            ]);

            return true;
        } catch (Exception $e) {
            error_log("VT cache save failed for IP {$ip}: " . $e->getMessage());
            return false;
        }
    }

    // =================================================================
    // Action Routing — all helper functions are now defined above
    // =================================================================

    // ----- query_vt: VirusTotal API v3 proxy with logging -----
    if ($_GET['action'] === 'query_vt') {
        $ip = isset($_POST['ip']) ? trim($_POST['ip']) : '';
        $apiKey = isset($_POST['api_key']) ? trim($_POST['api_key']) : '';

        if (empty($apiKey)) {
            echo json_encode(['error' => true, 'message' => 'API Key is required / API Key 為必填']);
            exit;
        }
        if (empty($ip) || !filter_var($ip, FILTER_VALIDATE_IP)) {
            echo json_encode(['error' => true, 'message' => 'Invalid IP address / 無效的IP地址: ' . $ip]);
            exit;
        }

        writeLog('info', 'virustotal', "VT query start: {$ip}", $ip);

        $url = 'https://www.virustotal.com/api/v3/ip_addresses/' . urlencode($ip);
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => [
                'x-apikey: ' . $apiKey,
                'Accept: application/json'
            ],
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            writeLog('error', 'virustotal', "Network error: {$curlError}", $ip);
            echo json_encode(['error' => true, 'message' => 'Network error / 網路錯誤: ' . $curlError]);
            exit;
        }
        if ($httpCode === 401) {
            writeLog('error', 'virustotal', 'Invalid API Key', $ip, ['http_code' => 401]);
            echo json_encode(['error' => true, 'message' => 'Invalid API Key / 無效的API Key', 'http_code' => 401]);
            exit;
        }
        if ($httpCode === 429) {
            writeLog('warning', 'virustotal', 'Rate limit exceeded', $ip, ['http_code' => 429]);
            echo json_encode(['error' => true, 'message' => 'Rate limit exceeded / 已超過速率限制', 'http_code' => 429]);
            exit;
        }
        if ($httpCode === 404) {
            writeLog('warning', 'virustotal', 'IP not found in VT', $ip, ['http_code' => 404]);
            echo json_encode(['error' => true, 'message' => 'IP not found in VirusTotal / VT 中找不到此IP', 'http_code' => 404]);
            exit;
        }
        if ($httpCode !== 200) {
            writeLog('error', 'virustotal', "API error HTTP {$httpCode}", $ip, ['http_code' => $httpCode]);
            echo json_encode(['error' => true, 'message' => 'API error (HTTP ' . $httpCode . ')', 'http_code' => $httpCode]);
            exit;
        }

        $data = json_decode($response, true);
        if (!$data || !isset($data['data']['attributes']['last_analysis_stats'])) {
            writeLog('error', 'virustotal', 'Unexpected API response format', $ip);
            echo json_encode(['error' => true, 'message' => 'Unexpected API response format / API 回應格式異常']);
            exit;
        }

        $statsVT = $data['data']['attributes']['last_analysis_stats'];
        $malicious = intval($statsVT['malicious'] ?? 0);
        $suspicious = intval($statsVT['suspicious'] ?? 0);
        $harmless = intval($statsVT['harmless'] ?? 0);
        $undetected = intval($statsVT['undetected'] ?? 0);
        $timeout = intval($statsVT['timeout'] ?? 0);
        $total = $malicious + $suspicious + $harmless + $undetected + $timeout;
        $flagged = $malicious + $suspicious;
        $vtStatus = $flagged > 0 ? 'malicious' : 'safe';

        $attrs = $data['data']['attributes'];
        $country = $attrs['country'] ?? '';
        $asOwner = $attrs['as_owner'] ?? '';
        $network = $attrs['network'] ?? '';

        $vtData = [
            'malicious' => $malicious, 'suspicious' => $suspicious,
            'harmless' => $harmless, 'undetected' => $undetected,
            'flagged' => $flagged, 'total' => $total,
            'status' => $vtStatus, 'country' => $country,
            'as_owner' => $asOwner, 'network' => $network
        ];
        $dbSaved = saveVTResultToCache($ip, $vtData);

        writeLog($vtStatus === 'malicious' ? 'warning' : 'success', 'virustotal',
            "VT result: {$flagged}/{$total} ({$vtStatus})", $ip,
            ['flagged' => $flagged, 'total' => $total, 'db_saved' => $dbSaved]);

        echo json_encode([
            'error' => false, 'ip' => $ip,
            'malicious' => $malicious, 'suspicious' => $suspicious,
            'harmless' => $harmless, 'undetected' => $undetected,
            'timeout' => $timeout, 'total' => $total,
            'flagged' => $flagged, 'status' => $vtStatus,
            'country' => $country, 'as_owner' => $asOwner, 'network' => $network,
            'vt_link' => 'https://www.virustotal.com/gui/ip-address/' . $ip,
            'db_saved' => $dbSaved
        ]);
        exit;
    }

    // ----- write_log: Generic log writing endpoint for JS -----
    if ($_GET['action'] === 'write_log') {
        $input = json_decode(file_get_contents('php://input'), true);
        $level = trim($input['level'] ?? 'info');
        $source = trim($input['source'] ?? 'system');
        $message = trim($input['message'] ?? '');
        $ip = isset($input['ip']) ? trim($input['ip']) : null;
        $details = $input['details'] ?? null;

        if (empty($message)) {
            echo json_encode(['error' => true, 'message' => 'Message is required']);
            exit;
        }
        $ok = writeLog($level, $source, $message, $ip, $details);
        echo json_encode(['error' => false, 'logged' => $ok]);
        exit;
    }

    // ----- save_api_key_to_db: Save API key to MySQL -----
    if ($_GET['action'] === 'save_api_key_to_db') {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $apiKey = trim($input['api_key'] ?? '');
            $label  = trim($input['label'] ?? '');

            if (empty($apiKey)) {
                echo json_encode(['error' => true, 'message' => 'API Key is required / API Key 為必填']);
                exit;
            }

            $pdo = getApiKeyPDO();
            if (!$pdo) {
                echo json_encode(['error' => true, 'message' => 'MySQL not configured / MySQL 未設定']);
                exit;
            }

            $pdo->beginTransaction();
            $pdo->prepare("UPDATE api_keys SET is_active = 0 WHERE service_name = 'virustotal'")->execute();

            $stmt = $pdo->prepare("
                INSERT INTO api_keys (service_name, api_key, key_label, is_active)
                VALUES ('virustotal', :key, :label, 1)
                ON DUPLICATE KEY UPDATE
                    key_label = VALUES(key_label),
                    is_active = 1,
                    updated_at = CURRENT_TIMESTAMP
            ");
            $stmt->execute([':key' => $apiKey, ':label' => $label ?: null]);
            $pdo->commit();

            writeLog('info', 'system', 'API Key saved to database');
            echo json_encode(['error' => false, 'message' => 'API Key saved to database / API Key 已儲存至資料庫']);
        } catch (Exception $e) {
            if (isset($pdo) && $pdo->inTransaction()) $pdo->rollBack();
            echo json_encode(['error' => true, 'message' => 'Database error: ' . $e->getMessage()]);
        }
        exit;
    }

    // ----- get_api_key_from_db: Retrieve active API key from MySQL -----
    if ($_GET['action'] === 'get_api_key_from_db') {
        try {
            $pdo = getApiKeyPDO();
            if (!$pdo) {
                echo json_encode(['error' => false, 'exists' => false, 'message' => 'MySQL not configured']);
                exit;
            }

            $stmt = $pdo->prepare("
                SELECT api_key, key_label, last_used_at, usage_count, updated_at
                FROM api_keys
                WHERE service_name = 'virustotal' AND is_active = 1
                ORDER BY updated_at DESC LIMIT 1
            ");
            $stmt->execute();
            $row = $stmt->fetch();

            if ($row) {
                $pdo->prepare("
                    UPDATE api_keys SET last_used_at = NOW(), usage_count = usage_count + 1
                    WHERE service_name = 'virustotal' AND api_key = ?
                ")->execute([$row['api_key']]);

                echo json_encode([
                    'error' => false, 'exists' => true,
                    'api_key' => $row['api_key'],
                    'label' => $row['key_label'],
                    'last_used' => $row['last_used_at'],
                    'usage_count' => intval($row['usage_count']) + 1,
                    'updated_at' => $row['updated_at']
                ]);
            } else {
                echo json_encode(['error' => false, 'exists' => false]);
            }
        } catch (Exception $e) {
            echo json_encode(['error' => true, 'message' => 'Database error: ' . $e->getMessage()]);
        }
        exit;
    }

    // ----- check_api_key_exists: Check if API key exists in MySQL -----
    if ($_GET['action'] === 'check_api_key_exists') {
        try {
            $pdo = getApiKeyPDO();
            if (!$pdo) {
                echo json_encode(['error' => false, 'db_exists' => false, 'db_available' => false]);
                exit;
            }

            $stmt = $pdo->prepare("
                SELECT COUNT(*) as cnt FROM api_keys
                WHERE service_name = 'virustotal' AND is_active = 1
            ");
            $stmt->execute();
            $count = intval($stmt->fetchColumn());

            echo json_encode(['error' => false, 'db_available' => true, 'db_exists' => $count > 0]);
        } catch (Exception $e) {
            echo json_encode(['error' => false, 'db_available' => false, 'db_exists' => false]);
        }
        exit;
    }

    // Unknown action
    echo json_encode(['error' => true, 'message' => 'Unknown action']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk IP Blacklist + VirusTotal Query / 批量IP黑名單+VT查詢</title>
    <style>
        /* Base Styles */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f0f2f5; color: #333; line-height: 1.6;
        }
        .bv-container { max-width: 1400px; margin: 0 auto; padding: 20px; }
        .back-link {
            display: inline-block; margin-bottom: 20px;
            color: #667eea; text-decoration: none; font-weight: 500;
        }
        .back-link:hover { text-decoration: underline; }

        /* Header */
        .bv-header {
            text-align: center; padding: 30px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; border-radius: 12px; margin-bottom: 25px;
        }
        .bv-header h1 { margin: 0 0 10px 0; font-size: 2rem; }
        .bv-header p { margin: 0; opacity: 0.9; }

        /* Tab Navigation */
        .tab-nav {
            display: flex; gap: 0; margin-bottom: 25px;
            border-bottom: 3px solid #667eea;
            border-radius: 12px 12px 0 0; overflow: hidden;
        }
        .tab-btn {
            flex: 1; padding: 16px 24px; border: none;
            background: #e8eaf6; color: #555;
            font-size: 1rem; font-weight: 600; cursor: pointer;
            transition: background 0.3s, color 0.3s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .tab-btn:first-child { border-radius: 12px 0 0 0; }
        .tab-btn:last-child { border-radius: 0 12px 0 0; }
        .tab-btn:hover:not(.active) { background: #d1d5f0; }
        .tab-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .tab-btn .tab-icon { font-size: 1.2rem; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }

        /* Card Sections */
        .bv-section {
            background: white; border-radius: 12px; padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 25px;
        }
        .bv-section h3 { margin: 0 0 15px 0; color: #333; }

        /* API Key Section */
        .api-key-row { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
        .api-key-input {
            flex: 1; min-width: 250px; padding: 12px 15px;
            border: 2px solid #e0e0e0; border-radius: 8px; font-size: 14px;
            font-family: 'Consolas', monospace; transition: border-color 0.3s;
        }
        .api-key-input:focus { outline: none; border-color: #667eea; }
        .api-key-save-label {
            display: flex; align-items: center; gap: 6px;
            font-size: 0.9rem; color: #666; cursor: pointer; white-space: nowrap;
        }
        .btn-toggle-visibility {
            background: #e9ecef; border: none; padding: 10px 14px;
            border-radius: 8px; cursor: pointer; font-size: 1rem;
        }
        .api-key-hint {
            margin-top: 12px; padding: 12px 15px;
            background: #fff3cd; border-radius: 8px; font-size: 0.85rem; color: #856404;
        }
        .api-key-hint a { color: #0d6efd; }
        .api-key-save-options { display: flex; gap: 20px; align-items: center; flex-wrap: wrap; margin-top: 12px; }
        .api-key-status {
            display: flex; gap: 20px; align-items: center; flex-wrap: wrap;
            margin-top: 12px; padding: 10px 15px;
            background: #f8f9fa; border-radius: 8px; font-size: 0.88rem;
        }
        .status-item { display: flex; align-items: center; gap: 6px; white-space: nowrap; }
        .status-icon { font-size: 1.1rem; }
        .status-icon.ok { color: #28a745; }
        .status-icon.no { color: #dc3545; }
        .status-label { color: #555; }

        /* IP Textarea */
        .ip-textarea {
            width: 100%; height: 200px; padding: 15px;
            border: 2px solid #e0e0e0; border-radius: 8px;
            font-family: 'Consolas', monospace; font-size: 14px;
            resize: vertical; transition: border-color 0.3s;
        }
        .ip-textarea:focus { outline: none; border-color: #667eea; }
        .input-info {
            display: flex; justify-content: space-between; align-items: center;
            margin-top: 15px; padding: 10px 15px; background: #f8f9fa; border-radius: 8px;
        }
        .ip-count { font-weight: 600; color: #667eea; }
        .batch-info { color: #666; font-size: 0.9rem; }
        .daily-warning {
            margin-top: 10px; padding: 10px 15px;
            background: #f8d7da; border-radius: 8px; color: #721c24;
            font-size: 0.9rem; display: none;
        }

        /* Control Buttons */
        .control-buttons { display: flex; gap: 15px; margin-top: 20px; flex-wrap: wrap; }
        .btn-start {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white; border: none; padding: 15px 40px; border-radius: 8px;
            font-size: 1.1rem; font-weight: 600; cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-start:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(40,167,69,0.4); }
        .btn-start:disabled { background: #ccc; cursor: not-allowed; }
        .btn-pause {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            color: white; border: none; padding: 15px 30px; border-radius: 8px;
            font-size: 1rem; font-weight: 600; cursor: pointer;
        }
        .btn-stop {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white; border: none; padding: 15px 30px; border-radius: 8px;
            font-size: 1rem; font-weight: 600; cursor: pointer;
        }
        .btn-clear {
            background: #6c757d; color: white; border: none;
            padding: 15px 30px; border-radius: 8px; font-size: 1rem; cursor: pointer;
        }

        /* Progress Section */
        .progress-section {
            background: white; border-radius: 12px; padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 25px; display: none;
        }
        .progress-section.active { display: block; }
        .progress-header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;
        }
        .progress-title { font-size: 1.2rem; font-weight: 600; color: #333; }
        .progress-status { padding: 8px 16px; border-radius: 20px; font-weight: 500; font-size: 0.9rem; }
        .status-running { background: #d4edda; color: #155724; }
        .status-paused { background: #fff3cd; color: #856404; }
        .status-completed { background: #cce5ff; color: #004085; }
        .status-error { background: #f8d7da; color: #721c24; }

        /* Progress Bar */
        .progress-bar-container {
            position: relative; height: 30px; background: #e9ecef;
            border-radius: 15px; overflow: hidden; margin-bottom: 20px;
        }
        .progress-bar {
            height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px; transition: width 0.5s ease; width: 0%;
        }
        .progress-percent {
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%); font-weight: 600; color: #333;
        }
        .progress-details { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px; }
        .detail-item { background: #f8f9fa; padding: 15px; border-radius: 8px; text-align: center; }
        .detail-label { display: block; font-size: 0.85rem; color: #666; margin-bottom: 5px; }
        .detail-value { display: block; font-size: 1.3rem; font-weight: 600; color: #333; }
        .countdown { color: #dc3545 !important; }

        /* Batch Results Log */
        .batch-results {
            max-height: 200px; overflow-y: auto; background: #f8f9fa;
            border-radius: 8px; padding: 15px;
            font-family: 'Consolas', monospace; font-size: 0.9rem;
        }
        .batch-log { padding: 4px 0; border-bottom: 1px solid #eee; }
        .batch-log.success { color: #155724; }
        .batch-log.error { color: #721c24; }
        .batch-log.info { color: #004085; }

        /* Results Section */
        .results-section {
            background: white; border-radius: 12px; padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 25px; display: none;
        }
        .results-section.active { display: block; }
        .results-section h3 { margin: 0 0 20px 0; color: #333; }

        /* Stats Group Row */
        .stats-group { margin-bottom: 20px; }
        .stats-group-title {
            font-size: 0.95rem; font-weight: 600; color: #555;
            margin-bottom: 10px; padding-left: 5px;
            border-left: 3px solid #667eea; padding-left: 10px;
        }
        .stats-group-title.vt { border-left-color: #764ba2; }

        /* Blacklist Stats Grid - 6 columns */
        .bl-stats-grid {
            display: grid; grid-template-columns: repeat(6, 1fr);
            gap: 12px; margin-bottom: 15px;
        }
        /* VT Stats Grid - 4 columns */
        .vt-stats-grid {
            display: grid; grid-template-columns: repeat(4, 1fr);
            gap: 12px; margin-bottom: 15px;
        }
        .result-card {
            padding: 18px 12px; border-radius: 10px; text-align: center;
            border-left: 4px solid #667eea; background: #f8f9fa;
        }
        .result-card .result-value { display: block; font-size: 1.8rem; font-weight: 700; color: #333; }
        .result-card .result-label { display: block; font-size: 0.8rem; color: #666; margin-top: 5px; }
        .result-card.blacklisted { border-left-color: #dc3545; background: #fff5f5; }
        .result-card.bl-safe { border-left-color: #28a745; background: #f0fff4; }
        .result-card.high-risk { border-left-color: #dc3545; background: #fff5f5; }
        .result-card.medium-risk { border-left-color: #ffc107; background: #fffdf0; }
        .result-card.low-risk { border-left-color: #28a745; background: #f0fff4; }
        .result-card.total { background: #e8eaf6; border-left-color: #283593; }
        .result-card.vt-malicious { border-left-color: #c62828; background: #fde8e8; }
        .result-card.vt-suspicious { border-left-color: #e65100; background: #fff3e0; }
        .result-card.vt-safe { border-left-color: #2e7d32; background: #e8f5e9; }

        /* Cache Stats */
        .cache-stats {
            background: #e8f4fd; padding: 18px; border-radius: 10px; margin-bottom: 20px;
        }
        .cache-stats h4 { margin: 0 0 12px 0; color: #004085; font-size: 0.95rem; }
        .cache-info { display: flex; gap: 30px; flex-wrap: wrap; }
        .cache-info span { color: #333; font-size: 0.9rem; }
        .cache-info strong { color: #667eea; }

        /* Combined Results Table */
        .results-table-container {
            overflow-x: auto; border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1); border: 2px solid #000;
        }
        .results-table {
            width: 100%; border-collapse: collapse; background: #fff;
            font-size: 0.85rem; border: 2px solid #000;
        }
        .results-table thead th {
            background: linear-gradient(135deg, #667eea, #4a90d9); color: #fff;
            padding: 10px 8px; text-align: left; font-weight: 600;
            white-space: nowrap; border: 1px solid #2c5aa0; border-bottom: 2px solid #000;
        }
        .results-table tbody td { padding: 8px; border: 1px solid #999; vertical-align: middle; }
        .results-table tbody tr:hover { background: #f0f4f8; }
        .results-table .ip-cell { font-family: 'Consolas', monospace; font-weight: 500; white-space: nowrap; }

        /* Badges */
        .badge-bl-yes {
            display: inline-block; padding: 3px 10px; border-radius: 12px;
            font-size: 0.78rem; font-weight: 600; background: #f8d7da; color: #721c24;
        }
        .badge-bl-no {
            display: inline-block; padding: 3px 10px; border-radius: 12px;
            font-size: 0.78rem; font-weight: 600; background: #d4edda; color: #155724;
        }
        .badge-risk-high { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 600; background: #f8d7da; color: #721c24; }
        .badge-risk-medium { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 600; background: #fff3cd; color: #856404; }
        .badge-risk-low { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 0.75rem; font-weight: 600; background: #d4edda; color: #155724; }
        .badge-vt-malicious {
            display: inline-block; padding: 3px 10px; border-radius: 12px;
            font-size: 0.78rem; font-weight: 600; background: #f8d7da; color: #721c24;
        }
        .badge-vt-safe {
            display: inline-block; padding: 3px 10px; border-radius: 12px;
            font-size: 0.78rem; font-weight: 600; background: #d4edda; color: #155724;
        }
        .badge-vt-error {
            display: inline-block; padding: 3px 10px; border-radius: 12px;
            font-size: 0.78rem; font-weight: 600; background: #e2e3e5; color: #383d41;
        }
        .detection-ratio { font-family: 'Consolas', monospace; font-weight: 600; }
        .detection-ratio.high { color: #dc3545; }
        .detection-ratio.medium { color: #fd7e14; }
        .detection-ratio.low { color: #28a745; }
        .ext-link { color: #0d6efd; text-decoration: none; font-size: 0.82rem; white-space: nowrap; }
        .ext-link:hover { text-decoration: underline; }

        /* Export buttons */
        .export-buttons { display: flex; gap: 15px; justify-content: center; margin-top: 20px; }
        .btn-export {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; border: none; padding: 12px 30px; border-radius: 8px;
            font-size: 1rem; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-export:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(102,126,234,0.4); }

        /* API Explanation Section */
        .api-explanation {
            margin-top: 20px; padding: 20px;
            background: #f0f4ff; border-radius: 10px; border-left: 4px solid #667eea;
        }
        .api-explanation h4 { margin: 0 0 12px 0; color: #333; font-size: 1.05rem; }
        .api-explanation ul { margin: 0; padding-left: 20px; list-style: none; }
        .api-explanation ul li {
            padding: 6px 0; position: relative; padding-left: 8px;
            font-size: 0.92rem; color: #444; line-height: 1.7;
        }
        .api-explanation ul li::before { content: '✦'; position: absolute; left: -14px; color: #667eea; }
        .api-explanation .comparison-table {
            width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 0.88rem;
        }
        .api-explanation .comparison-table th {
            background: #667eea; color: white; padding: 10px 12px; text-align: left; font-weight: 600;
        }
        .api-explanation .comparison-table td { padding: 8px 12px; border-bottom: 1px solid #ddd; }
        .api-explanation .comparison-table tr:nth-child(even) { background: #f8f9ff; }
        .api-explanation .comparison-table .method-no { color: #dc3545; font-weight: 600; }
        .api-explanation .comparison-table .method-yes { color: #28a745; font-weight: 600; }

        /* Responsive */
        @media (max-width: 992px) {
            .bl-stats-grid { grid-template-columns: repeat(3, 1fr); }
            .vt-stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .progress-details { grid-template-columns: repeat(2, 1fr); }
            .bl-stats-grid { grid-template-columns: repeat(2, 1fr); }
            .vt-stats-grid { grid-template-columns: repeat(2, 1fr); }
            .api-key-row { flex-direction: column; }
            .tab-btn { font-size: 0.85rem; padding: 12px 16px; }
        }
        @media (max-width: 576px) {
            .bl-stats-grid { grid-template-columns: 1fr; }
            .vt-stats-grid { grid-template-columns: 1fr; }
            .progress-details { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="bv-container">
        <a href="ip_blacklist.php" class="back-link">← 返回主頁 / Back to Main</a>

        <div class="bv-header">
            <h1>📦🦠 Bulk IP Blacklist + VirusTotal Query</h1>
            <p>批量IP黑名單 + VirusTotal 信譽查詢整合工具 — 一次輸入，雙重查詢</p>
        </div>

        <!-- Tab Navigation -->
        <div class="tab-nav">
            <button class="tab-btn active" onclick="switchTab('query')" id="tabBtnQuery">
                <span class="tab-icon">🔍</span> 查詢工具 / Query Tool
            </button>
            <button class="tab-btn" onclick="switchTab('settings')" id="tabBtnSettings">
                <span class="tab-icon">⚙️</span> API 設定與說明 / API Settings & Info
            </button>
        </div>

        <!-- ===== Tab 1: Query Tool ===== -->
        <div class="tab-content active" id="tabQuery">

        <!-- IP Input Section -->
        <div class="bv-section">
            <h3>📝 輸入IP列表 / Enter IP List</h3>
            <textarea id="ipTextarea" class="ip-textarea" placeholder="每行輸入一個IP地址，例如：
178.20.210.172
109.94.217.176
88.151.112.136

Enter one IP address per line..."></textarea>
            <div class="input-info">
                <span class="ip-count">IP數量 / IP Count: <span id="ipCount">0</span></span>
                <span class="batch-info">每批處理 <strong>4</strong> 個IP，批次間隔 <strong>60</strong> 秒</span>
            </div>
            <div class="daily-warning" id="dailyWarning">
                ⚠️ 超過500個IP！VT免費版每日上限為500次請求。超出部分VT將無法查詢。<br>
                Warning: Over 500 IPs! VT free tier daily limit is 500 requests.
            </div>
            <div class="control-buttons">
                <button id="btnStart" class="btn-start" onclick="startProcessing()">▶ 開始查詢 / Start Query</button>
                <button id="btnPause" class="btn-pause" onclick="togglePause()" style="display:none;">⏸ 暫停 / Pause</button>
                <button id="btnStop" class="btn-stop" onclick="stopProcessing()" style="display:none;">⏹ 停止 / Stop</button>
                <button id="btnClear" class="btn-clear" onclick="clearAll()">🗑 清除 / Clear</button>
            </div>
        </div>

        <!-- Progress Section -->
        <div class="progress-section" id="progressSection">
            <div class="progress-header">
                <span class="progress-title">📊 查詢進度 / Query Progress</span>
                <span class="progress-status status-running" id="progressStatus">查詢中...</span>
            </div>
            <div class="progress-bar-container">
                <div class="progress-bar" id="progressBar"></div>
                <span class="progress-percent" id="progressPercent">0%</span>
            </div>
            <div class="progress-details">
                <div class="detail-item">
                    <span class="detail-label">當前批次 / Current Batch:</span>
                    <span class="detail-value" id="currentBatch">0 / 0</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">已處理IP / Processed IPs:</span>
                    <span class="detail-value" id="processedIPs">0</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">下批倒數 / Next Batch In:</span>
                    <span class="detail-value countdown" id="countdown">--</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">目前IP / Current IP:</span>
                    <span class="detail-value" id="currentIP" style="font-size:0.9rem;">--</span>
                </div>
            </div>
            <div class="batch-results" id="batchResults"></div>
        </div>

        <!-- Results Section -->
        <div class="results-section" id="resultsSection">
            <h3>📈 查詢結果 / Query Results</h3>

            <!-- Blacklist Stats -->
            <div class="stats-group">
                <div class="stats-group-title">🛡️ 黑名單統計 / Blacklist Statistics</div>
                <div class="bl-stats-grid">
                    <div class="result-card total"><span class="result-value" id="blTotal">0</span><span class="result-label">總處理數 / Total</span></div>
                    <div class="result-card blacklisted"><span class="result-value" id="blBlacklisted">0</span><span class="result-label">黑名單 / Blacklisted</span></div>
                    <div class="result-card bl-safe"><span class="result-value" id="blSafe">0</span><span class="result-label">安全 / Safe</span></div>
                    <div class="result-card high-risk"><span class="result-value" id="blHighRisk">0</span><span class="result-label">高風險 / High Risk</span></div>
                    <div class="result-card medium-risk"><span class="result-value" id="blMediumRisk">0</span><span class="result-label">中風險 / Medium Risk</span></div>
                    <div class="result-card low-risk"><span class="result-value" id="blLowRisk">0</span><span class="result-label">低風險 / Low Risk</span></div>
                </div>
            </div>

            <!-- VT Stats -->
            <div class="stats-group">
                <div class="stats-group-title vt">🦠 VirusTotal 統計 / VT Statistics</div>
                <div class="vt-stats-grid">
                    <div class="result-card total"><span class="result-value" id="vtTotal">0</span><span class="result-label">總查詢數 / Total Queried</span></div>
                    <div class="result-card vt-malicious"><span class="result-value" id="vtMalicious">0</span><span class="result-label">惡意 / Malicious</span></div>
                    <div class="result-card vt-suspicious"><span class="result-value" id="vtSuspicious">0</span><span class="result-label">可疑 / Suspicious</span></div>
                    <div class="result-card vt-safe"><span class="result-value" id="vtSafe">0</span><span class="result-label">安全 / Safe</span></div>
                </div>
            </div>

            <!-- Cache Stats -->
            <div class="cache-stats">
                <h4>💾 快取統計 / Cache Statistics</h4>
                <div class="cache-info">
                    <span>快取命中 / Cache Hits: <strong id="cacheHits">0</strong></span>
                    <span>API 呼叫 / API Calls: <strong id="apiCalls">0</strong></span>
                    <span>命中率 / Hit Rate: <strong id="cacheHitRate">0%</strong></span>
                </div>
            </div>

            <!-- Combined Results Table -->
            <div class="results-table-container">
                <table class="results-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>IP</th>
                            <th>黑名單 / Blacklist</th>
                            <th>風險等級 / Risk</th>
                            <th>VT 偵測 / Detection</th>
                            <th>VT 狀態 / Status</th>
                            <th>國家 / Country</th>
                            <th>ISP / Org</th>
                            <th>連結 / Links</th>
                        </tr>
                    </thead>
                    <tbody id="resultsTableBody"></tbody>
                </table>
            </div>

            <!-- Export Buttons -->
            <div class="export-buttons">
                <button class="btn-export" onclick="exportResults('csv')">📥 匯出 CSV / Export CSV</button>
                <button class="btn-export" onclick="exportResults('json')">📥 匯出 JSON / Export JSON</button>
            </div>
        </div>

        </div><!-- End Tab 1 (tabQuery) -->

        <!-- ===== Tab 2: API Settings & Info ===== -->
        <div class="tab-content" id="tabSettings">

        <!-- API Key Section -->
        <div class="bv-section">
            <h3>🔑 VirusTotal API Key</h3>
            <div class="api-key-row">
                <input type="password" id="apiKeyInput" class="api-key-input"
                       placeholder="輸入你的 VirusTotal API Key / Enter your API Key">
                <button class="btn-toggle-visibility" onclick="toggleApiKeyVisibility()" title="顯示/隱藏 API Key">👁</button>
            </div>
            <!-- Save option checkboxes -->
            <div class="api-key-save-options">
                <label class="api-key-save-label">
                    <input type="checkbox" id="saveApiKey" checked>
                    💾 儲存到瀏覽器 / Save to Browser (localStorage)
                </label>
                <label class="api-key-save-label">
                    <input type="checkbox" id="saveApiKeyDB">
                    🗄️ 儲存到資料庫 / Save to Database (MySQL)
                </label>
            </div>
            <!-- Storage status indicators -->
            <div class="api-key-status" id="apiKeyStatus">
                <div class="status-item">
                    <span class="status-icon no" id="statusLocalIcon">✗</span>
                    <span class="status-label">瀏覽器 / localStorage</span>
                </div>
                <div class="status-item">
                    <span class="status-icon no" id="statusDBIcon">✗</span>
                    <span class="status-label">資料庫 / MySQL</span>
                </div>
            </div>
            <div class="api-key-hint">
                💡 <strong>如何取得 API Key / How to get an API Key:</strong><br>
                1. 前往 <a href="https://www.virustotal.com/gui/join-us" target="_blank">virustotal.com</a> 免費註冊帳號<br>
                2. 登入後前往 <a href="https://www.virustotal.com/gui/my-apikey" target="_blank">我的API金鑰</a> 頁面<br>
                3. 複製你的 API Key 貼到上方欄位<br>
                ⚠️ 免費版限制：每分鐘 4 次請求，每日 500 次請求 / Free tier: 4 req/min, 500 req/day
            </div>
        </div>

        <!-- API Explanation Section -->
        <div class="bv-section">
            <h3>📖 為什麼使用 API 而非網頁爬取？ / Why API instead of Web Scraping?</h3>
            <div class="api-explanation">
                <h4>🔬 技術分析 / Technical Analysis</h4>
                <ul>
                    <li><strong>SPA 架構：</strong>VirusTotal 網站是單頁應用程式（SPA），PHP cURL 只能取得空殼 HTML，無法取得實際偵測數據。<br>
                    <em>VirusTotal is an SPA — PHP fetches only an empty HTML shell, not actual detection data.</em></li>
                    <li><strong>反爬蟲機制：</strong>VirusTotal 部署了 CAPTCHA、速率限制、IP 封鎖等反爬蟲保護。<br>
                    <em>Anti-scraping: CAPTCHAs, rate limiting, and IP blocking.</em></li>
                    <li><strong>需要登入：</strong>完整偵測結果需要登入帳號，匿名存取資訊有限。<br>
                    <em>Full results require authentication; anonymous access is limited.</em></li>
                    <li><strong>服務條款：</strong>自動化爬取違反 VirusTotal ToS，可能導致永久封鎖。<br>
                    <em>Automated scraping violates ToS and may result in permanent bans.</em></li>
                    <li><strong>API 穩定可靠：</strong>官方 API 提供結構化 JSON，版本化管理，不受前端改版影響。<br>
                    <em>Official API: stable, versioned JSON responses unaffected by frontend changes.</em></li>
                </ul>
            </div>
            <div class="api-explanation" style="margin-top: 15px;">
                <h4>📊 方案比較 / Approach Comparison</h4>
                <table class="comparison-table">
                    <thead>
                        <tr>
                            <th>比較項目 / Criteria</th>
                            <th>❌ HTML 爬取 / Scraping</th>
                            <th>✅ API v3</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>取得偵測數據</td><td class="method-no">✗ SPA 空殼</td><td class="method-yes">✓ 結構化 JSON</td></tr>
                        <tr><td>穩定性</td><td class="method-no">✗ 前端改版即失效</td><td class="method-yes">✓ 版本化 API</td></tr>
                        <tr><td>合規性</td><td class="method-no">✗ 違反 ToS</td><td class="method-yes">✓ 官方授權</td></tr>
                        <tr><td>速率控制</td><td class="method-no">✗ 容易被封鎖</td><td class="method-yes">✓ 明確速率限制</td></tr>
                        <tr><td>附加資訊</td><td class="method-no">✗ 需複雜解析</td><td class="method-yes">✓ 國家、ASN 等</td></tr>
                        <tr><td>需要 API Key</td><td>不需要（但無法運作）</td><td>需要（免費註冊）</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        </div><!-- End Tab 2: tabSettings -->

    </div><!-- End bv-container -->

    <script>
    // =========================================================
    // Configuration
    // =========================================================
    const BATCH_SIZE = 4;          // 4 IPs per batch (VT free tier: 4 req/min)
    const DELAY_SECONDS = 60;      // 60 seconds between batches
    const DAILY_LIMIT = 500;       // VT free daily limit
    const REQUEST_GAP_MS = 500;    // 500ms gap between individual VT requests

    // =========================================================
    // State Variables
    // =========================================================
    let allIPs = [];
    let batches = [];
    let currentBatchIndex = 0;
    let isProcessing = false;
    let isPaused = false;
    let countdownInterval = null;
    let totalProcessedCount = 0;
    let allResults = [];           // Combined results array

    // Dual statistics
    let stats = {
        // Blacklist stats
        blTotal: 0, blBlacklisted: 0, blSafe: 0,
        blHighRisk: 0, blMediumRisk: 0, blLowRisk: 0,
        cacheHits: 0, apiCalls: 0,
        // VT stats
        vtTotal: 0, vtMalicious: 0, vtSuspicious: 0, vtSafe: 0, vtErrors: 0
    };

    // DOM References
    const ipTextarea = document.getElementById('ipTextarea');
    const btnStart = document.getElementById('btnStart');
    const btnPause = document.getElementById('btnPause');
    const btnStop = document.getElementById('btnStop');
    const progressSection = document.getElementById('progressSection');
    const resultsSection = document.getElementById('resultsSection');

    // =========================================================
    // Tab Switching
    // =========================================================
    function switchTab(tab) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));

        if (tab === 'query') {
            document.getElementById('tabQuery').classList.add('active');
            document.getElementById('tabBtnQuery').classList.add('active');
        } else {
            document.getElementById('tabSettings').classList.add('active');
            document.getElementById('tabBtnSettings').classList.add('active');
        }
    }

    // =========================================================
    // API Key Management
    // =========================================================

    /**
     * Fallback chain: 1) localStorage → 2) MySQL → 3) empty
     */
    function getApiKey() {
        const inputVal = document.getElementById('apiKeyInput').value.trim();
        if (inputVal) return inputVal;
        const stored = localStorage.getItem('vt_api_key');
        if (stored) return stored;
        return '';
    }

    // Load saved API key on page load (IIFE)
    (async function loadSavedApiKey() {
        // 1. Try localStorage
        const localKey = localStorage.getItem('vt_api_key');
        if (localKey) {
            document.getElementById('apiKeyInput').value = localKey;
        } else {
            // 2. Try MySQL
            try {
                const resp = await fetch('bulk_query_virustotal.php?action=get_api_key_from_db');
                const data = await resp.json();
                if (!data.error && data.api_key) {
                    document.getElementById('apiKeyInput').value = data.api_key;
                }
            } catch (e) { /* silent */ }
        }
        refreshApiKeyStatus();
    })();

    async function refreshApiKeyStatus() {
        // Check localStorage
        const localKey = localStorage.getItem('vt_api_key');
        const localIcon = document.getElementById('statusLocalIcon');
        if (localKey) {
            localIcon.textContent = '✓'; localIcon.className = 'status-icon ok';
        } else {
            localIcon.textContent = '✗'; localIcon.className = 'status-icon no';
        }
        // Check MySQL
        const dbIcon = document.getElementById('statusDBIcon');
        try {
            const resp = await fetch('bulk_query_virustotal.php?action=check_api_key_exists');
            const data = await resp.json();
            if (data.exists) {
                dbIcon.textContent = '✓'; dbIcon.className = 'status-icon ok';
            } else {
                dbIcon.textContent = '✗'; dbIcon.className = 'status-icon no';
            }
        } catch (e) {
            dbIcon.textContent = '✗'; dbIcon.className = 'status-icon no';
        }
    }

    function toggleApiKeyVisibility() {
        const input = document.getElementById('apiKeyInput');
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    /** Save API key to selected storages */
    async function saveApiKey() {
        const key = document.getElementById('apiKeyInput').value.trim();
        if (!key) return;

        // Save to localStorage if checked
        if (document.getElementById('saveApiKey').checked) {
            localStorage.setItem('vt_api_key', key);
        }
        // Save to MySQL if checked
        if (document.getElementById('saveApiKeyDB').checked) {
            try {
                await fetch('bulk_query_virustotal.php?action=save_api_key_to_db', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `api_key=${encodeURIComponent(key)}`
                });
            } catch (e) { /* silent */ }
        }
        refreshApiKeyStatus();
    }

    // Auto-save on input change (debounced)
    let saveTimeout = null;
    document.getElementById('apiKeyInput').addEventListener('input', () => {
        clearTimeout(saveTimeout);
        saveTimeout = setTimeout(saveApiKey, 1000);
    });

    // =========================================================
    // IP Count & Parsing
    // =========================================================
    function updateIPCount() {
        const ips = parseIPs(ipTextarea.value);
        document.getElementById('ipCount').textContent = ips.length;
        const warning = document.getElementById('dailyWarning');
        warning.style.display = ips.length > DAILY_LIMIT ? 'block' : 'none';
    }
    ipTextarea.addEventListener('input', updateIPCount);

    function parseIPs(text) {
        return text.split('\n')
            .map(line => line.trim())
            .filter(line => /^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/.test(line));
    }

    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    // =========================================================
    // Start Processing
    // =========================================================
    function startProcessing() {
        // Check API key
        const apiKey = getApiKey();
        if (!apiKey) {
            alert('請先設定 VirusTotal API Key！\nPlease set your VirusTotal API Key first!');
            switchTab('settings');
            return;
        }

        allIPs = parseIPs(ipTextarea.value);
        if (allIPs.length === 0) {
            alert('請輸入有效的IP地址 / Please enter valid IP addresses');
            return;
        }

        // Remove duplicates
        allIPs = [...new Set(allIPs)];

        // Split into batches
        batches = [];
        for (let i = 0; i < allIPs.length; i += BATCH_SIZE) {
            batches.push(allIPs.slice(i, i + BATCH_SIZE));
        }

        // Reset state
        currentBatchIndex = 0;
        isProcessing = true;
        isPaused = false;
        allResults = [];
        totalProcessedCount = 0;
        stats = {
            blTotal: 0, blBlacklisted: 0, blSafe: 0,
            blHighRisk: 0, blMediumRisk: 0, blLowRisk: 0,
            cacheHits: 0, apiCalls: 0,
            vtTotal: 0, vtMalicious: 0, vtSuspicious: 0, vtSafe: 0, vtErrors: 0
        };

        // Update UI
        btnStart.disabled = true;
        btnPause.style.display = 'inline-block';
        btnStop.style.display = 'inline-block';
        progressSection.classList.add('active');
        resultsSection.classList.remove('active');
        document.getElementById('batchResults').innerHTML = '';
        document.getElementById('resultsTableBody').innerHTML = '';
        updateProgress();

        addLog(`🚀 開始查詢 ${allIPs.length} 個IP（去重後），共 ${batches.length} 批`, 'info');

        // Start processing
        processNextBatch();
    }

    // =========================================================
    // Core Dual-Query Processing
    // =========================================================
    async function processNextBatch() {
        if (!isProcessing || currentBatchIndex >= batches.length) {
            finishProcessing();
            return;
        }
        if (isPaused) return;

        const batch = batches[currentBatchIndex];
        const batchNum = currentBatchIndex + 1;
        const totalBatches = batches.length;

        updateStatus('running', `查詢中 批次 ${batchNum}/${totalBatches}...`);
        addLog(`⏳ 開始處理批次 ${batchNum}/${totalBatches} (${batch.length} IPs)...`, 'info');

        // ---- Step 1: Blacklist Query via api.php?action=batch ----
        let blResults = {};
        try {
            const blResponse = await fetch('api.php?action=batch', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'ips=' + encodeURIComponent(JSON.stringify(batch))
            });
            const blData = await blResponse.json();

            if (!blData.error && blData.results) {
                // Index results by IP for easy lookup
                blData.results.forEach(r => { blResults[r.ip] = r; });

                // Update blacklist stats from batch response
                stats.blTotal += (blData.total || 0);
                stats.blBlacklisted += (blData.blacklisted || 0);
                stats.blSafe += (blData.safe || 0);
                stats.blHighRisk += (blData.highRisk || 0);
                stats.blMediumRisk += (blData.mediumRisk || 0);
                stats.blLowRisk += (blData.lowRisk || 0);
                if (blData.cacheStats) {
                    stats.cacheHits += (blData.cacheStats.hits || 0);
                    stats.apiCalls += (blData.cacheStats.misses || 0);
                }

                addLog(`  🛡️ 黑名單結果: ${blData.blacklisted || 0} 黑名單, ${blData.safe || 0} 安全`, 'info');

                // Log blacklist results to database
                try {
                    await fetch('bulk_query_virustotal.php?action=write_log', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        body: `level=info&source=blacklist&message=${encodeURIComponent('Batch ' + batchNum + ': ' + blData.blacklisted + ' blacklisted, ' + blData.safe + ' safe')}&details=${encodeURIComponent(JSON.stringify({batch: batchNum, ips: batch}))}`
                    });
                } catch (e) { /* silent log failure */ }
            } else {
                addLog(`  ⚠️ 黑名單查詢失敗: ${blData.message || 'Unknown error'}`, 'error');
            }
        } catch (err) {
            addLog(`  ❌ 黑名單查詢網路錯誤: ${err.message}`, 'error');
        }

        // ---- Step 2: VT Query for each IP in batch ----
        for (let i = 0; i < batch.length; i++) {
            if (!isProcessing || isPaused) break;

            const ip = batch[i];
            document.getElementById('currentIP').textContent = ip;
            const blResult = blResults[ip] || null;
            let vtResult = null;

            try {
                vtResult = await querySingleVT(ip);
                stats.vtTotal++;
                if (vtResult.error) {
                    stats.vtErrors++;
                    addLog(`  🦠 ${ip}: VT 錯誤 - ${vtResult.message}`, 'error');
                } else {
                    if (vtResult.status === 'malicious') {
                        stats.vtMalicious++;
                        if (vtResult.suspicious > 0) stats.vtSuspicious++;
                    } else {
                        stats.vtSafe++;
                    }
                    addLog(`  🦠 ${ip}: VT ${vtResult.flagged}/${vtResult.total} (${vtResult.status === 'malicious' ? '惡意' : '安全'})`, vtResult.status === 'malicious' ? 'error' : 'success');
                }
            } catch (err) {
                stats.vtErrors++;
                stats.vtTotal++;
                vtResult = { error: true, ip: ip, message: err.message, status: 'error' };
                addLog(`  ❌ ${ip}: VT 網路錯誤 - ${err.message}`, 'error');
            }

            // Combine results and add to table
            const combined = { ip, bl: blResult, vt: vtResult };
            allResults.push(combined);
            totalProcessedCount++;
            updateProgress();
            appendResultRow(totalProcessedCount, blResult, vtResult, ip);
            updateAllStats();

            // Small gap between VT requests within a batch
            if (i < batch.length - 1 && isProcessing && !isPaused) {
                await sleep(REQUEST_GAP_MS);
            }
        }

        currentBatchIndex++;
        updateProgress();

        // If more batches, wait before next
        if (currentBatchIndex < batches.length && isProcessing && !isPaused) {
            addLog(`⏰ 等待 ${DELAY_SECONDS} 秒後處理下一批...`, 'info');
            startCountdown(DELAY_SECONDS);
        } else if (!isPaused) {
            finishProcessing();
        }
    }

    // =========================================================
    // Single VT Query Helper
    // =========================================================
    async function querySingleVT(ip) {
        const apiKey = getApiKey();
        const response = await fetch('bulk_query_virustotal.php?action=query_vt', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `ip=${encodeURIComponent(ip)}&api_key=${encodeURIComponent(apiKey)}`
        });
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        return await response.json();
    }

    // =========================================================
    // Countdown Timer
    // =========================================================
    function startCountdown(seconds) {
        let remaining = seconds;
        document.getElementById('countdown').textContent = remaining + 's';

        countdownInterval = setInterval(() => {
            remaining--;
            document.getElementById('countdown').textContent = remaining + 's';

            if (remaining <= 0) {
                clearInterval(countdownInterval);
                countdownInterval = null;
                document.getElementById('countdown').textContent = '--';
                if (!isPaused && isProcessing) {
                    processNextBatch();
                }
            }
        }, 1000);
    }

    // =========================================================
    // Pause / Stop / Finish
    // =========================================================
    function togglePause() {
        isPaused = !isPaused;
        if (isPaused) {
            btnPause.textContent = '▶ 繼續 / Resume';
            updateStatus('paused', '已暫停 / Paused');
            addLog('⏸ 查詢已暫停', 'info');
            if (countdownInterval) { clearInterval(countdownInterval); countdownInterval = null; }
        } else {
            btnPause.textContent = '⏸ 暫停 / Pause';
            updateStatus('running', '查詢中...');
            addLog('▶ 查詢已繼續', 'info');
            processNextBatch();
        }
    }

    function stopProcessing() {
        if (confirm('確定要停止查詢嗎？已查詢的結果會保留。\nStop? Existing results will be kept.')) {
            isProcessing = false;
            isPaused = false;
            if (countdownInterval) { clearInterval(countdownInterval); countdownInterval = null; }
            addLog('⏹ 查詢已停止', 'error');
            finishProcessing();
        }
    }

    function finishProcessing() {
        isProcessing = false;
        isPaused = false;
        if (countdownInterval) { clearInterval(countdownInterval); countdownInterval = null; }

        btnStart.disabled = false;
        btnPause.style.display = 'none';
        btnStop.style.display = 'none';
        updateStatus('completed', '完成 / Completed');
        document.getElementById('countdown').textContent = '--';
        document.getElementById('currentIP').textContent = '--';

        resultsSection.classList.add('active');
        updateAllStats();

        const totalIPs = allResults.length;
        addLog(`🎉 完成！共處理 ${totalIPs} IP — 黑名單: ${stats.blBlacklisted} 黑名單/${stats.blSafe} 安全 | VT: ${stats.vtMalicious} 惡意/${stats.vtSafe} 安全/${stats.vtErrors} 錯誤`, 'success');
    }

    // =========================================================
    // UI Update Functions
    // =========================================================
    function updateProgress() {
        const totalIPs = allIPs.length;
        const percent = totalIPs > 0 ? Math.round((totalProcessedCount / totalIPs) * 100) : 0;
        document.getElementById('progressBar').style.width = percent + '%';
        document.getElementById('progressPercent').textContent = percent + '%';
        document.getElementById('currentBatch').textContent = `${Math.min(currentBatchIndex + 1, batches.length)} / ${batches.length}`;
        document.getElementById('processedIPs').textContent = `${totalProcessedCount} / ${totalIPs}`;
    }

    function updateStatus(status, text) {
        const el = document.getElementById('progressStatus');
        el.textContent = text;
        el.className = 'progress-status status-' + status;
    }

    function addLog(message, type = 'info') {
        const container = document.getElementById('batchResults');
        const log = document.createElement('div');
        log.className = 'batch-log ' + type;
        log.textContent = `[${new Date().toLocaleTimeString()}] ${message}`;
        container.appendChild(log);
        container.scrollTop = container.scrollHeight;
    }

    function updateAllStats() {
        // Blacklist stats
        document.getElementById('blTotal').textContent = stats.blTotal;
        document.getElementById('blBlacklisted').textContent = stats.blBlacklisted;
        document.getElementById('blSafe').textContent = stats.blSafe;
        document.getElementById('blHighRisk').textContent = stats.blHighRisk;
        document.getElementById('blMediumRisk').textContent = stats.blMediumRisk;
        document.getElementById('blLowRisk').textContent = stats.blLowRisk;
        // VT stats
        document.getElementById('vtTotal').textContent = stats.vtTotal;
        document.getElementById('vtMalicious').textContent = stats.vtMalicious;
        document.getElementById('vtSuspicious').textContent = stats.vtSuspicious;
        document.getElementById('vtSafe').textContent = stats.vtSafe;
        // Cache stats
        document.getElementById('cacheHits').textContent = stats.cacheHits;
        document.getElementById('apiCalls').textContent = stats.apiCalls;
        const totalCache = stats.cacheHits + stats.apiCalls;
        document.getElementById('cacheHitRate').textContent = totalCache > 0
            ? Math.round((stats.cacheHits / totalCache) * 100) + '%' : '0%';
    }

    // =========================================================
    // Append Combined Result Row
    // =========================================================
    function appendResultRow(index, blResult, vtResult, ip) {
        const tbody = document.getElementById('resultsTableBody');
        const tr = document.createElement('tr');

        // Blacklist columns
        let blStatusHtml = '<span class="badge-vt-error">N/A</span>';
        let riskHtml = '-';
        let country = '-';
        let isp = '-';
        let blLink = '';

        if (blResult) {
            blStatusHtml = blResult.blacklisted
                ? '<span class="badge-bl-yes">🚫 黑名單</span>'
                : '<span class="badge-bl-no">✅ 安全</span>';

            const rl = (blResult.riskLevel || '').toLowerCase();
            if (rl === 'high') riskHtml = '<span class="badge-risk-high">高 High</span>';
            else if (rl === 'medium') riskHtml = '<span class="badge-risk-medium">中 Medium</span>';
            else riskHtml = '<span class="badge-risk-low">低 Low</span>';

            country = blResult.countryName || blResult.country || '-';
            isp = blResult.isp || '-';
            blLink = `<a href="ip_blacklist.php?ip=${encodeURIComponent(ip)}" target="_blank" class="ext-link">🛡️ 詳情</a>`;
        }

        // VT columns
        let vtDetectionHtml = '-';
        let vtStatusHtml = '<span class="badge-vt-error">N/A</span>';
        let vtLink = '';

        if (vtResult && !vtResult.error) {
            const flagged = vtResult.flagged || 0;
            const total = vtResult.total || 0;
            const ratioClass = flagged >= 5 ? 'high' : (flagged >= 1 ? 'medium' : 'low');
            vtDetectionHtml = `<span class="detection-ratio ${ratioClass}">${flagged} / ${total}</span>`;

            vtStatusHtml = vtResult.status === 'malicious'
                ? '<span class="badge-vt-malicious">🚫 惡意</span>'
                : '<span class="badge-vt-safe">✅ 安全</span>';

            if (vtResult.vt_link) {
                vtLink = `<a href="${vtResult.vt_link}" target="_blank" class="ext-link">🦠 VT</a>`;
            }
            // Use VT country/ISP if blacklist didn't provide
            if (country === '-' && vtResult.country) country = vtResult.country;
            if (isp === '-' && vtResult.as_owner) isp = vtResult.as_owner;
        } else if (vtResult && vtResult.error) {
            vtStatusHtml = `<span class="badge-vt-error">❌ ${vtResult.message || 'Error'}</span>`;
        }

        const linksHtml = [blLink, vtLink].filter(Boolean).join(' ');

        tr.innerHTML = `
            <td>${index}</td>
            <td class="ip-cell">${ip}</td>
            <td>${blStatusHtml}</td>
            <td>${riskHtml}</td>
            <td>${vtDetectionHtml}</td>
            <td>${vtStatusHtml}</td>
            <td>${country}</td>
            <td>${isp}</td>
            <td>${linksHtml || '-'}</td>`;

        tbody.appendChild(tr);
    }

    // =========================================================
    // Clear All
    // =========================================================
    function clearAll() {
        if (isProcessing) {
            alert('請先停止查詢 / Please stop querying first');
            return;
        }
        ipTextarea.value = '';
        updateIPCount();
        progressSection.classList.remove('active');
        resultsSection.classList.remove('active');
        allResults = [];
        document.getElementById('resultsTableBody').innerHTML = '';
        stats = {
            blTotal: 0, blBlacklisted: 0, blSafe: 0,
            blHighRisk: 0, blMediumRisk: 0, blLowRisk: 0,
            cacheHits: 0, apiCalls: 0,
            vtTotal: 0, vtMalicious: 0, vtSuspicious: 0, vtSafe: 0, vtErrors: 0
        };
        updateAllStats();
    }

    // =========================================================
    // Export Functions
    // =========================================================
    function exportResults(format) {
        if (allResults.length === 0) {
            alert('沒有可匯出的結果 / No results to export');
            return;
        }

        let content, filename, mimeType;
        const timestamp = new Date().toISOString().slice(0, 10);

        if (format === 'csv') {
            const headers = ['IP', 'Blacklisted', 'Risk Level', 'Risk Score', 'VT Flagged', 'VT Total', 'VT Status', 'Country', 'City', 'ISP'];
            const rows = allResults.map(r => {
                const bl = r.bl || {};
                const vt = r.vt || {};
                return [
                    r.ip,
                    bl.blacklisted ? 'Yes' : 'No',
                    bl.riskLevel || '-',
                    bl.riskScore || '-',
                    vt.error ? 'Error' : (vt.flagged || 0),
                    vt.error ? '-' : (vt.total || 0),
                    vt.error ? 'Error' : (vt.status || '-'),
                    bl.countryName || bl.country || vt.country || '-',
                    bl.city || '-',
                    bl.isp || vt.as_owner || '-'
                ];
            });
            content = '\uFEFF' + [headers, ...rows].map(r => r.map(c => `"${c}"`).join(',')).join('\n');
            filename = `bulk_bl_vt_results_${timestamp}.csv`;
            mimeType = 'text/csv;charset=utf-8';
        } else {
            content = JSON.stringify({
                exportDate: new Date().toISOString(),
                statistics: stats,
                results: allResults.map(r => ({
                    ip: r.ip,
                    blacklist: r.bl ? {
                        blacklisted: r.bl.blacklisted, riskLevel: r.bl.riskLevel,
                        riskScore: r.bl.riskScore, country: r.bl.countryName || r.bl.country,
                        city: r.bl.city, isp: r.bl.isp
                    } : null,
                    virustotal: r.vt ? (r.vt.error ? { error: true, message: r.vt.message } : {
                        flagged: r.vt.flagged, total: r.vt.total, status: r.vt.status,
                        malicious: r.vt.malicious, suspicious: r.vt.suspicious,
                        harmless: r.vt.harmless, country: r.vt.country,
                        as_owner: r.vt.as_owner, vt_link: r.vt.vt_link
                    }) : null
                }))
            }, null, 2);
            filename = `bulk_bl_vt_results_${timestamp}.json`;
            mimeType = 'application/json';
        }

        const blob = new Blob([content], { type: mimeType });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        a.click();
        URL.revokeObjectURL(url);
    }

    // =========================================================
    // Initialize
    // =========================================================
    updateIPCount();
    </script>
</body>
</html>