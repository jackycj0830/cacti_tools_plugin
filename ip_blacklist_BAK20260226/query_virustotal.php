<?php
/**
 * VirusTotal Batch IP Query - Standalone Page
 * VirusTotal 批量IP信譽查詢工具 - 獨立頁面
 *
 * Uses VirusTotal API v3 to check IP reputation in batches of 4 (free tier: 4 req/min).
 * PHP backend acts as a proxy to avoid CORS issues and protect API key.
 *
 * @version 1.0.0
 */

// =====================================================
// PHP Backend Proxy for VirusTotal API v3
// =====================================================
if (isset($_GET['action'])) {
    header('Content-Type: application/json; charset=utf-8');

    // =================================================================
    // Helper function definitions — must be defined BEFORE action routing
    // so they are available when called by any action handler.
    // 輔助函式定義 — 必須在動作路由之前定義，確保任何處理器都能呼叫。
    // =================================================================

    /**
     * Helper: Get a PDO connection to MySQL using existing db_config
     */
    function getApiKeyPDO() {
        require_once __DIR__ . '/database/db_config.php';
        if (DB_TYPE !== 'mysql') {
            return null; // Database save only supported with MySQL
        }
        $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s',
            MYSQL_HOST, MYSQL_PORT, MYSQL_DATABASE, MYSQL_CHARSET);
        $pdo = new PDO($dsn, MYSQL_USERNAME, MYSQL_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        // Auto-create table if not exists
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
     * Save VT query result to ip_cache and ip_database tables.
     * Uses INSERT ... ON DUPLICATE KEY UPDATE to only update VT-specific columns,
     * preserving existing GeoIP/blacklist data if the IP already exists.
     * 將 VT 查詢結果寫入 ip_cache 和 ip_database 表。
     * 使用 ON DUPLICATE KEY UPDATE 僅更新 VT 欄位，不覆蓋已有的 GeoIP 資料。
     *
     * @param string $ip IP address
     * @param array $vtData Parsed VT result data
     * @return bool Whether the save was successful
     */
    function saveVTResultToCache($ip, array $vtData) {
        try {
            require_once __DIR__ . '/database/db_config.php';
            if (DB_TYPE !== 'mysql') {
                return false; // VT cache save only supported with MySQL for now
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

            $expiresAt = date('Y-m-d H:i:s', time() + 86400); // 24h TTL for VT results
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
            // DB failure should NOT prevent API response from returning
            // 資料庫寫入失敗不應阻止 API 回應返回
            error_log("VT cache save failed for IP {$ip}: " . $e->getMessage());
            return false;
        }
    }

    // =================================================================
    // Action Routing — all helper functions are now defined above
    // =================================================================

    if ($_GET['action'] === 'query') {
        $ip = isset($_POST['ip']) ? trim($_POST['ip']) : '';
        $apiKey = isset($_POST['api_key']) ? trim($_POST['api_key']) : '';

        // Validate inputs
        if (empty($apiKey)) {
            echo json_encode(['error' => true, 'message' => 'API Key is required / API Key 為必填']);
            exit;
        }
        if (empty($ip) || !filter_var($ip, FILTER_VALIDATE_IP)) {
            echo json_encode(['error' => true, 'message' => 'Invalid IP address / 無效的IP地址: ' . $ip]);
            exit;
        }

        // Call VirusTotal API v3
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

        // Handle cURL errors
        if ($response === false) {
            echo json_encode(['error' => true, 'message' => 'Network error / 網路錯誤: ' . $curlError]);
            exit;
        }

        // Handle HTTP errors
        if ($httpCode === 401) {
            echo json_encode(['error' => true, 'message' => 'Invalid API Key / 無效的API Key', 'http_code' => 401]);
            exit;
        }
        if ($httpCode === 429) {
            echo json_encode(['error' => true, 'message' => 'Rate limit exceeded. Please wait. / 已超過速率限制，請等待。', 'http_code' => 429]);
            exit;
        }
        if ($httpCode === 404) {
            echo json_encode(['error' => true, 'message' => 'IP not found in VirusTotal / VirusTotal 中找不到此IP', 'http_code' => 404]);
            exit;
        }
        if ($httpCode !== 200) {
            echo json_encode(['error' => true, 'message' => 'API error (HTTP ' . $httpCode . ') / API 錯誤', 'http_code' => $httpCode]);
            exit;
        }

        // Parse response
        $data = json_decode($response, true);
        if (!$data || !isset($data['data']['attributes']['last_analysis_stats'])) {
            echo json_encode(['error' => true, 'message' => 'Unexpected API response format / API 回應格式異常']);
            exit;
        }

        $stats = $data['data']['attributes']['last_analysis_stats'];
        $malicious = intval($stats['malicious'] ?? 0);
        $suspicious = intval($stats['suspicious'] ?? 0);
        $harmless = intval($stats['harmless'] ?? 0);
        $undetected = intval($stats['undetected'] ?? 0);
        $timeout = intval($stats['timeout'] ?? 0);
        $total = $malicious + $suspicious + $harmless + $undetected + $timeout;

        // Determine status
        $flagged = $malicious + $suspicious;
        $status = $flagged > 0 ? 'malicious' : 'safe';

        // Get additional info if available
        $attrs = $data['data']['attributes'];
        $country = $attrs['country'] ?? '';
        $asOwner = $attrs['as_owner'] ?? '';
        $network = $attrs['network'] ?? '';

        // Save VT result to ip_cache and ip_database tables
        // 將 VT 查詢結果寫入 ip_cache 和 ip_database 資料表
        $vtData = [
            'malicious' => $malicious,
            'suspicious' => $suspicious,
            'harmless' => $harmless,
            'undetected' => $undetected,
            'flagged' => $flagged,
            'total' => $total,
            'status' => $status,
            'country' => $country,
            'as_owner' => $asOwner,
            'network' => $network
        ];
        $dbSaved = saveVTResultToCache($ip, $vtData);

        echo json_encode([
            'error' => false,
            'ip' => $ip,
            'malicious' => $malicious,
            'suspicious' => $suspicious,
            'harmless' => $harmless,
            'undetected' => $undetected,
            'timeout' => $timeout,
            'total' => $total,
            'flagged' => $flagged,
            'status' => $status,
            'country' => $country,
            'as_owner' => $asOwner,
            'network' => $network,
            'vt_link' => 'https://www.virustotal.com/gui/ip-address/' . $ip,
            'db_saved' => $dbSaved
        ]);
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

            // Deactivate all existing keys for this service, then insert/update new one
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
                // Update usage stats
                $pdo->prepare("
                    UPDATE api_keys SET last_used_at = NOW(), usage_count = usage_count + 1
                    WHERE service_name = 'virustotal' AND api_key = ?
                ")->execute([$row['api_key']]);

                echo json_encode([
                    'error' => false,
                    'exists' => true,
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

            echo json_encode([
                'error' => false,
                'db_available' => true,
                'db_exists' => $count > 0
            ]);
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
    <title>VirusTotal Batch IP Query / VirusTotal 批量IP信譽查詢</title>
    <style>
        /* Base Styles */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f0f2f5;
            color: #333;
            line-height: 1.6;
        }
        .vt-container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .back-link {
            display: inline-block; margin-bottom: 20px;
            color: #667eea; text-decoration: none; font-weight: 500;
        }
        .back-link:hover { text-decoration: underline; }

        /* Header */
        .vt-header {
            text-align: center; padding: 30px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; border-radius: 12px; margin-bottom: 25px;
        }
        .vt-header h1 { margin: 0 0 10px 0; font-size: 2rem; }
        .vt-header p { margin: 0; opacity: 0.9; }

        /* Card Sections */
        .vt-section {
            background: white; border-radius: 12px; padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 25px;
        }
        .vt-section h3 { margin: 0 0 15px 0; color: #333; }

        /* API Key Section */
        .api-key-row {
            display: flex; gap: 12px; align-items: center; flex-wrap: wrap;
        }
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
        .api-key-toggle {
            display: flex; align-items: center; gap: 8px;
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

        /* Save options row */
        .api-key-save-options {
            display: flex; gap: 20px; align-items: center; flex-wrap: wrap; margin-top: 12px;
        }
        /* API Key Status Indicators */
        .api-key-status {
            display: flex; gap: 20px; align-items: center; flex-wrap: wrap;
            margin-top: 12px; padding: 10px 15px;
            background: #f8f9fa; border-radius: 8px; font-size: 0.88rem;
        }
        .status-item {
            display: flex; align-items: center; gap: 6px; white-space: nowrap;
        }
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

        /* Results Table */
        .results-section {
            background: white; border-radius: 12px; padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 25px; display: none;
        }
        .results-section.active { display: block; }
        .results-table-container { overflow-x: auto; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border: 2px solid #000; }
        .results-table {
            width: 100%; border-collapse: collapse; background: #fff; font-size: 0.9rem; border: 2px solid #000;
        }
        .results-table thead th {
            background: linear-gradient(135deg, #667eea, #4a90d9); color: #fff;
            padding: 12px 10px; text-align: left; font-weight: 600;
            white-space: nowrap; border: 1px solid #2c5aa0; border-bottom: 2px solid #000;
        }
        .results-table tbody td { padding: 10px; border: 1px solid #999; }
        .results-table tbody tr:hover { background: #f0f4f8; }
        .results-table .ip-cell { font-family: 'Consolas', 'Monaco', monospace; font-weight: 500; }

        /* Status badges */
        .badge-malicious {
            display: inline-block; padding: 4px 12px; border-radius: 12px;
            font-size: 0.8rem; font-weight: 600;
            background: #f8d7da; color: #721c24;
        }
        .badge-safe {
            display: inline-block; padding: 4px 12px; border-radius: 12px;
            font-size: 0.8rem; font-weight: 600;
            background: #d4edda; color: #155724;
        }
        .detection-ratio { font-family: 'Consolas', monospace; font-weight: 600; }
        .detection-ratio.high { color: #dc3545; }
        .detection-ratio.medium { color: #fd7e14; }
        .detection-ratio.low { color: #28a745; }
        .vt-link { color: #0d6efd; text-decoration: none; }
        .vt-link:hover { text-decoration: underline; }

        /* Summary Section */
        .results-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 20px; }
        .result-card {
            padding: 20px; border-radius: 10px; text-align: center;
        }
        .result-card .result-value { display: block; font-size: 2rem; font-weight: 700; }
        .result-card .result-label { display: block; font-size: 0.85rem; margin-top: 5px; }
        .result-card.total { background: #e8eaf6; color: #283593; }
        .result-card.malicious { background: #fde8e8; color: #c62828; }
        .result-card.suspicious { background: #fff3e0; color: #e65100; }
        .result-card.safe-card { background: #e8f5e9; color: #2e7d32; }

        /* Export buttons */
        .export-buttons { display: flex; gap: 15px; justify-content: center; margin-top: 20px; }
        .btn-export {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white; border: none; padding: 12px 30px; border-radius: 8px;
            font-size: 1rem; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-export:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(102,126,234,0.4); }

        /* Tab Navigation */
        .tab-nav {
            display: flex; gap: 0; margin-bottom: 25px;
            border-bottom: 3px solid #667eea;
            border-radius: 12px 12px 0 0;
            overflow: hidden;
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

        /* API Explanation Section */
        .api-explanation {
            margin-top: 20px; padding: 20px;
            background: #f0f4ff; border-radius: 10px;
            border-left: 4px solid #667eea;
        }
        .api-explanation h4 { margin: 0 0 12px 0; color: #333; font-size: 1.05rem; }
        .api-explanation ul {
            margin: 0; padding-left: 20px; list-style: none;
        }
        .api-explanation ul li {
            padding: 6px 0; position: relative; padding-left: 8px;
            font-size: 0.92rem; color: #444; line-height: 1.7;
        }
        .api-explanation ul li::before {
            content: '✦'; position: absolute; left: -14px; color: #667eea;
        }
        .api-explanation .comparison-table {
            width: 100%; border-collapse: collapse; margin-top: 15px;
            font-size: 0.88rem;
        }
        .api-explanation .comparison-table th {
            background: #667eea; color: white; padding: 10px 12px;
            text-align: left; font-weight: 600;
        }
        .api-explanation .comparison-table td {
            padding: 8px 12px; border-bottom: 1px solid #ddd;
        }
        .api-explanation .comparison-table tr:nth-child(even) { background: #f8f9ff; }
        .api-explanation .comparison-table .method-no { color: #dc3545; font-weight: 600; }
        .api-explanation .comparison-table .method-yes { color: #28a745; font-weight: 600; }

        /* Responsive */
        @media (max-width: 768px) {
            .progress-details { grid-template-columns: repeat(2, 1fr); }
            .results-grid { grid-template-columns: repeat(2, 1fr); }
            .api-key-row { flex-direction: column; }
            .tab-btn { font-size: 0.85rem; padding: 12px 16px; }
        }
    </style>
</head>
<body>
    <div class="vt-container">
        <a href="ip_blacklist.php" class="back-link">← 返回主頁 / Back to Main</a>

        <div class="vt-header">
            <h1>🦠 VirusTotal Batch IP Query</h1>
            <p>VirusTotal 批量IP信譽查詢 - 使用 VirusTotal API v3 檢查IP安全狀態</p>
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
        <div class="vt-section">
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
                ⚠️ 超過500個IP！免費版每日上限為500次請求。超出部分將無法查詢。<br>
                Warning: Over 500 IPs! Free tier daily limit is 500 requests.
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
                    <span class="detail-label">已查詢IP / Queried IPs:</span>
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

            <!-- Summary Cards -->
            <div class="results-grid">
                <div class="result-card total">
                    <span class="result-value" id="statTotal">0</span>
                    <span class="result-label">總查詢數 / Total Queried</span>
                </div>
                <div class="result-card malicious">
                    <span class="result-value" id="statMalicious">0</span>
                    <span class="result-label">惡意 / Malicious</span>
                </div>
                <div class="result-card suspicious">
                    <span class="result-value" id="statSuspicious">0</span>
                    <span class="result-label">可疑 / Suspicious</span>
                </div>
                <div class="result-card safe-card">
                    <span class="result-value" id="statSafe">0</span>
                    <span class="result-label">安全 / Safe</span>
                </div>
            </div>

            <!-- Results Table -->
            <div class="results-table-container">
                <table class="results-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>IP</th>
                            <th>偵測比率 / Detection</th>
                            <th>狀態 / Status</th>
                            <th>國家 / Country</th>
                            <th>網路 / Network</th>
                            <th>VirusTotal 連結</th>
                        </tr>
                    </thead>
                    <tbody id="resultsTableBody">
                    </tbody>
                </table>
            </div>

            <!-- Export Buttons -->
            <div class="export-buttons">
                <button class="btn-export" onclick="exportResults('csv')">📥 匯出CSV / Export CSV</button>
                <button class="btn-export" onclick="exportResults('json')">📥 匯出JSON / Export JSON</button>
            </div>
        </div>

        </div><!-- End Tab 1: tabQuery -->

        <!-- ===== Tab 2: API Settings & Info ===== -->
        <div class="tab-content" id="tabSettings">

        <!-- API Key Section -->
        <div class="vt-section">
            <h3>🔑 VirusTotal API Key</h3>
            <div class="api-key-row">
                <input type="password" id="apiKeyInput" class="api-key-input"
                       placeholder="輸入你的 VirusTotal API Key / Enter your API Key">
                <div class="api-key-toggle">
                    <button class="btn-toggle-visibility" onclick="toggleApiKeyVisibility()" title="顯示/隱藏 API Key">👁</button>
                </div>
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
        <div class="vt-section">
            <h3>📖 為什麼使用 API 而非網頁爬取？ / Why API instead of Web Scraping?</h3>
            <div class="api-explanation">
                <h4>🔬 技術分析 / Technical Analysis</h4>
                <ul>
                    <li><strong>SPA 架構：</strong>VirusTotal 網站是單頁應用程式（Single Page Application），頁面內容由 JavaScript 動態渲染。使用 PHP cURL 或 file_get_contents 只能取得空殼 HTML，無法取得實際偵測數據。<br>
                    <em>VirusTotal is an SPA — PHP fetches only an empty HTML shell, not the actual detection data.</em></li>
                    <li><strong>反爬蟲機制：</strong>VirusTotal 部署了進階的反爬蟲保護（包括 CAPTCHA 驗證、速率限制、IP 封鎖），直接爬取網頁極易被封鎖。<br>
                    <em>VirusTotal employs anti-scraping measures including CAPTCHAs, rate limiting, and IP blocking.</em></li>
                    <li><strong>需要登入：</strong>完整的偵測結果需要登入帳號才能檢視，匿名存取的資訊有限。<br>
                    <em>Full detection results require authentication; anonymous access provides limited data.</em></li>
                    <li><strong>服務條款：</strong>自動化爬取 VirusTotal 網頁違反其服務條款（ToS），可能導致帳號或 IP 被永久封鎖。<br>
                    <em>Automated scraping violates VirusTotal's Terms of Service and may result in permanent bans.</em></li>
                    <li><strong>API 更穩定可靠：</strong>官方 API 提供結構化 JSON 回應，格式穩定、版本化管理，不會因為前端改版而失效。<br>
                    <em>The official API provides stable, versioned JSON responses unaffected by frontend changes.</em></li>
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
                        <tr>
                            <td>取得偵測數據 / Get detection data</td>
                            <td class="method-no">✗ 無法取得（SPA 空殼）</td>
                            <td class="method-yes">✓ 結構化 JSON</td>
                        </tr>
                        <tr>
                            <td>穩定性 / Stability</td>
                            <td class="method-no">✗ 前端改版即失效</td>
                            <td class="method-yes">✓ 版本化 API，穩定可靠</td>
                        </tr>
                        <tr>
                            <td>合規性 / Compliance</td>
                            <td class="method-no">✗ 違反服務條款</td>
                            <td class="method-yes">✓ 官方授權使用</td>
                        </tr>
                        <tr>
                            <td>速率控制 / Rate control</td>
                            <td class="method-no">✗ 容易被封鎖</td>
                            <td class="method-yes">✓ 明確的速率限制</td>
                        </tr>
                        <tr>
                            <td>附加資訊 / Extra info</td>
                            <td class="method-no">✗ 需要複雜解析</td>
                            <td class="method-yes">✓ 國家、ASN、網路等</td>
                        </tr>
                        <tr>
                            <td>需要 API Key / Requires API Key</td>
                            <td>不需要（但無法運作）</td>
                            <td>需要（免費註冊）</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        </div><!-- End Tab 2: tabSettings -->

    </div>

    <script>
    // =====================================================
    // VirusTotal Batch IP Query Processing Script
    // VirusTotal 批量IP信譽查詢處理腳本
    // =====================================================

    // Configuration
    const BATCH_SIZE = 4;       // VT free tier: 4 requests per minute
    const DELAY_SECONDS = 60;   // 60 seconds between batches
    const DAILY_LIMIT = 500;    // VT free tier daily limit
    const REQUEST_GAP_MS = 500; // 500ms gap between individual requests within a batch

    // State variables
    let allIPs = [];
    let batches = [];
    let currentBatchIndex = 0;
    let isProcessing = false;
    let isPaused = false;
    let countdownInterval = null;
    let allResults = [];
    let totalProcessedCount = 0;

    // Statistics
    let stats = { total: 0, malicious: 0, suspicious: 0, safe: 0, errors: 0 };

    // DOM Elements
    const ipTextarea = document.getElementById('ipTextarea');
    const ipCountEl = document.getElementById('ipCount');
    const btnStart = document.getElementById('btnStart');
    const btnPause = document.getElementById('btnPause');
    const btnStop = document.getElementById('btnStop');
    const progressSection = document.getElementById('progressSection');
    const resultsSection = document.getElementById('resultsSection');
    const dailyWarning = document.getElementById('dailyWarning');

    // =====================================================
    // Tab Switching
    // =====================================================
    function switchTab(tab) {
        document.getElementById('tabQuery').classList.toggle('active', tab === 'query');
        document.getElementById('tabSettings').classList.toggle('active', tab === 'settings');
        document.getElementById('tabBtnQuery').classList.toggle('active', tab === 'query');
        document.getElementById('tabBtnSettings').classList.toggle('active', tab === 'settings');
    }

    // =====================================================
    // API Key Management
    // Fallback chain: 1) localStorage → 2) MySQL DB → 3) prompt user
    // =====================================================

    /**
     * Load API key with fallback chain on page init:
     * Priority 1: localStorage (instant, no network)
     * Priority 2: MySQL database (async fetch)
     * Priority 3: Empty — user must enter manually
     */
    (async function loadSavedApiKey() {
        const input = document.getElementById('apiKeyInput');

        // Priority 1: Try localStorage
        const localKey = localStorage.getItem('vt_api_key');
        if (localKey) {
            input.value = localKey;
        }

        // Priority 2: If localStorage empty, try MySQL database
        if (!localKey) {
            try {
                const resp = await fetch('query_virustotal.php?action=get_api_key_from_db');
                const data = await resp.json();
                if (!data.error && data.exists && data.api_key) {
                    input.value = data.api_key;
                }
            } catch (e) {
                // DB not available — silently continue
                console.warn('DB API key fetch failed:', e);
            }
        }

        // Refresh status indicators after loading
        refreshApiKeyStatus();
    })();

    /**
     * Get current API key from input field.
     * Also saves to localStorage and/or DB based on checkbox states.
     */
    function getApiKey() {
        const key = document.getElementById('apiKeyInput').value.trim();

        // Save to localStorage if checked (existing behavior preserved)
        if (document.getElementById('saveApiKey').checked && key) {
            localStorage.setItem('vt_api_key', key);
        }

        // Save to MySQL database if checked
        if (document.getElementById('saveApiKeyDB').checked && key) {
            saveApiKeyToDB(key);
        }

        return key;
    }

    /**
     * Save API key to MySQL via backend endpoint (async, fire-and-forget)
     */
    async function saveApiKeyToDB(key) {
        try {
            const resp = await fetch('query_virustotal.php?action=save_api_key_to_db', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ api_key: key })
            });
            const data = await resp.json();
            if (data.error) {
                console.warn('DB save failed:', data.message);
            }
            // Refresh status indicators after save
            refreshApiKeyStatus();
        } catch (e) {
            console.warn('DB save error:', e);
        }
    }

    /**
     * Refresh the visual status indicators for localStorage and MySQL
     */
    async function refreshApiKeyStatus() {
        const localIcon = document.getElementById('statusLocalIcon');
        const dbIcon = document.getElementById('statusDBIcon');

        // Check localStorage
        const localKey = localStorage.getItem('vt_api_key');
        if (localKey) {
            localIcon.textContent = '✓';
            localIcon.className = 'status-icon ok';
        } else {
            localIcon.textContent = '✗';
            localIcon.className = 'status-icon no';
        }

        // Check MySQL database
        try {
            const resp = await fetch('query_virustotal.php?action=check_api_key_exists');
            const data = await resp.json();
            if (!data.error && data.db_available && data.db_exists) {
                dbIcon.textContent = '✓';
                dbIcon.className = 'status-icon ok';
            } else {
                dbIcon.textContent = '✗';
                dbIcon.className = 'status-icon no';
            }
        } catch (e) {
            dbIcon.textContent = '✗';
            dbIcon.className = 'status-icon no';
        }
    }

    function toggleApiKeyVisibility() {
        const input = document.getElementById('apiKeyInput');
        const btn = event.currentTarget;
        if (input.type === 'password') {
            input.type = 'text';
            btn.textContent = '🔒';
        } else {
            input.type = 'password';
            btn.textContent = '👁';
        }
    }

    // =====================================================
    // IP Parsing and Validation
    // =====================================================
    ipTextarea.addEventListener('input', updateIPCount);

    function updateIPCount() {
        const ips = parseIPs(ipTextarea.value);
        ipCountEl.textContent = ips.length;
        const batchCount = Math.ceil(ips.length / BATCH_SIZE);
        document.querySelector('.batch-info').innerHTML =
            `每批處理 <strong>${BATCH_SIZE}</strong> 個IP，共 <strong>${batchCount}</strong> 批，批次間隔 <strong>${DELAY_SECONDS}</strong> 秒`;

        // Show daily limit warning
        dailyWarning.style.display = ips.length > DAILY_LIMIT ? 'block' : 'none';
    }

    function parseIPs(text) {
        return text.split(/[\n,;]+/)
            .map(ip => ip.trim())
            .filter(ip => ip && /^(\d{1,3}\.){3}\d{1,3}$/.test(ip));
    }

    // =====================================================
    // Processing Control
    // =====================================================
    function startProcessing() {
        const apiKey = getApiKey();
        if (!apiKey) {
            switchTab('settings');
            alert('請先設定 VirusTotal API Key / Please set your VirusTotal API Key first');
            document.getElementById('apiKeyInput').focus();
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
        stats = { total: 0, malicious: 0, suspicious: 0, safe: 0, errors: 0 };

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

    // =====================================================
    // Core Processing Functions
    // =====================================================
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

        // Process each IP in this batch sequentially
        for (let i = 0; i < batch.length; i++) {
            if (!isProcessing || isPaused) break;

            const ip = batch[i];
            document.getElementById('currentIP').textContent = ip;

            try {
                const result = await querySingleVT(ip);
                allResults.push(result);

                if (result.error) {
                    stats.errors++;
                    addLog(`  ❌ ${ip}: ${result.message}`, 'error');
                } else {
                    stats.total++;
                    if (result.status === 'malicious') {
                        stats.malicious++;
                        if (result.suspicious > 0) stats.suspicious++;
                    } else {
                        stats.safe++;
                    }
                    addLog(`  ✅ ${ip}: ${result.flagged}/${result.total} (${result.status === 'malicious' ? '惡意' : '安全'})`, result.status === 'malicious' ? 'error' : 'success');
                }

                totalProcessedCount++;
                updateProgress();
                appendResultRow(result, totalProcessedCount);

            } catch (err) {
                stats.errors++;
                totalProcessedCount++;
                const errResult = { error: true, ip: ip, message: err.message, status: 'error' };
                allResults.push(errResult);
                addLog(`  ❌ ${ip}: 網路錯誤 - ${err.message}`, 'error');
                appendResultRow(errResult, totalProcessedCount);
                updateProgress();
            }

            // Small gap between requests within a batch
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

    async function querySingleVT(ip) {
        const apiKey = getApiKey();
        const response = await fetch('query_virustotal.php?action=query', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `ip=${encodeURIComponent(ip)}&api_key=${encodeURIComponent(apiKey)}`
        });

        if (!response.ok) {
            throw new Error(`HTTP ${response.status}`);
        }

        return await response.json();
    }

    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    // =====================================================
    // Countdown Timer
    // =====================================================
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

    // =====================================================
    // Pause / Stop / Clear
    // =====================================================
    function togglePause() {
        isPaused = !isPaused;

        if (isPaused) {
            btnPause.textContent = '▶ 繼續 / Resume';
            updateStatus('paused', '已暫停 / Paused');
            addLog('⏸ 查詢已暫停', 'info');
            if (countdownInterval) {
                clearInterval(countdownInterval);
                countdownInterval = null;
            }
        } else {
            btnPause.textContent = '⏸ 暫停 / Pause';
            updateStatus('running', '查詢中...');
            addLog('▶ 查詢已繼續', 'info');
            processNextBatch();
        }
    }

    function stopProcessing() {
        if (confirm('確定要停止查詢嗎？已查詢的結果會保留。\nAre you sure you want to stop? Existing results will be kept.')) {
            isProcessing = false;
            isPaused = false;
            if (countdownInterval) {
                clearInterval(countdownInterval);
                countdownInterval = null;
            }
            addLog('⏹ 查詢已停止', 'error');
            finishProcessing();
        }
    }

    function finishProcessing() {
        isProcessing = false;
        isPaused = false;
        if (countdownInterval) {
            clearInterval(countdownInterval);
            countdownInterval = null;
        }

        btnStart.disabled = false;
        btnPause.style.display = 'none';
        btnStop.style.display = 'none';
        updateStatus('completed', '完成 / Completed');
        document.getElementById('countdown').textContent = '--';
        document.getElementById('currentIP').textContent = '--';

        // Show results section and update summary
        resultsSection.classList.add('active');
        updateSummary();

        addLog(`🎉 查詢完成！共查詢 ${stats.total} 個IP，${stats.malicious} 個惡意，${stats.safe} 個安全，${stats.errors} 個錯誤`, 'success');
    }

    // =====================================================
    // UI Update Functions
    // =====================================================
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

    function appendResultRow(result, index) {
        const tbody = document.getElementById('resultsTableBody');
        const tr = document.createElement('tr');

        if (result.error) {
            tr.innerHTML = `
                <td>${index}</td>
                <td class="ip-cell">${result.ip || '-'}</td>
                <td>-</td>
                <td><span class="badge-malicious">❌ 錯誤 / Error</span></td>
                <td>-</td>
                <td>${result.message || '-'}</td>
                <td>-</td>`;
        } else {
            const ratioClass = result.flagged >= 5 ? 'high' : (result.flagged >= 1 ? 'medium' : 'low');
            const statusBadge = result.status === 'malicious'
                ? '<span class="badge-malicious">🚫 惡意 / Malicious</span>'
                : '<span class="badge-safe">✅ 安全 / Safe</span>';

            tr.innerHTML = `
                <td>${index}</td>
                <td class="ip-cell">${result.ip}</td>
                <td><span class="detection-ratio ${ratioClass}">${result.flagged} / ${result.total}</span></td>
                <td>${statusBadge}</td>
                <td>${result.country || '-'}</td>
                <td>${result.as_owner || '-'}</td>
                <td><a href="${result.vt_link}" target="_blank" class="vt-link">🔗 查看詳情</a></td>`;
        }

        tbody.appendChild(tr);

        // Also update live summary
        updateSummary();
    }

    function updateSummary() {
        document.getElementById('statTotal').textContent = stats.total + stats.errors;
        document.getElementById('statMalicious').textContent = stats.malicious;
        document.getElementById('statSuspicious').textContent = stats.suspicious;
        document.getElementById('statSafe').textContent = stats.safe;
    }

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
        stats = { total: 0, malicious: 0, suspicious: 0, safe: 0, errors: 0 };
    }

    // =====================================================
    // Export Functions
    // =====================================================
    function exportResults(format) {
        if (allResults.length === 0) {
            alert('沒有可匯出的結果 / No results to export');
            return;
        }

        let content, filename, mimeType;
        const timestamp = new Date().toISOString().slice(0, 10);

        if (format === 'csv') {
            const headers = ['IP', 'Flagged', 'Total Vendors', 'Status', 'Malicious', 'Suspicious', 'Harmless', 'Undetected', 'Country', 'AS Owner', 'Network', 'VT Link'];
            const rows = allResults.map(r => {
                if (r.error) {
                    return [r.ip || '-', '-', '-', 'Error', '-', '-', '-', '-', '-', '-', '-', '-'];
                }
                return [
                    r.ip, r.flagged, r.total, r.status,
                    r.malicious, r.suspicious, r.harmless, r.undetected,
                    r.country || '-', r.as_owner || '-', r.network || '-', r.vt_link || '-'
                ];
            });
            content = '\uFEFF' + [headers, ...rows].map(r => r.map(c => `"${c}"`).join(',')).join('\n');
            filename = `virustotal_results_${timestamp}.csv`;
            mimeType = 'text/csv;charset=utf-8';
        } else {
            content = JSON.stringify({
                exportDate: new Date().toISOString(),
                statistics: stats,
                results: allResults.map(r => {
                    if (r.error) return { ip: r.ip, error: true, message: r.message };
                    return {
                        ip: r.ip, flagged: r.flagged, total: r.total, status: r.status,
                        malicious: r.malicious, suspicious: r.suspicious,
                        harmless: r.harmless, undetected: r.undetected,
                        country: r.country, as_owner: r.as_owner, network: r.network,
                        vt_link: r.vt_link
                    };
                })
            }, null, 2);
            filename = `virustotal_results_${timestamp}.json`;
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

    // Initialize
    updateIPCount();
    </script>
</body>
</html>
