<?php
/**
 * IP Blacklist Query System - Cache Operations
 * @version 1.0.0
 * 
 * High-level cache operations for IP query results.
 */

require_once __DIR__ . '/IPCacheDB.php';

class IPCache {
    private $db;
    private $pdo;

    public function __construct() {
        $this->db = IPCacheDB::getInstance();
        $this->pdo = $this->db->getPDO();
        $this->maybeCleanup();
    }

    /**
     * Get cached IP data if available and not expired
     * @param string $ip IP address
     * @return array|null Cached data or null if not found/expired
     */
    public function get($ip) {
        if (!CACHE_ENABLED) return null;
        
        try {
            $sql = "SELECT * FROM ip_cache WHERE ip_address = ? AND expires_at > ?";
            $now = date('Y-m-d H:i:s');
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$ip, $now]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                // Update hit count
                $this->pdo->prepare("UPDATE ip_cache SET hit_count = hit_count + 1 WHERE ip_address = ?")
                    ->execute([$ip]);
                $this->recordCacheHit();
                return $this->rowToResult($row);
            }
            
            $this->recordCacheMiss();
            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Get multiple IPs from cache
     * @param array $ips Array of IP addresses
     * @return array ['cached' => [...], 'missing' => [...]]
     */
    public function getMultiple(array $ips) {
        if (!CACHE_ENABLED || empty($ips)) {
            return ['cached' => [], 'missing' => $ips];
        }

        $cached = [];
        $missing = [];
        $now = date('Y-m-d H:i:s');

        try {
            $placeholders = str_repeat('?,', count($ips) - 1) . '?';
            $sql = "SELECT * FROM ip_cache WHERE ip_address IN ($placeholders) AND expires_at > ?";
            $params = array_merge($ips, [$now]);
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $foundIps = [];
            foreach ($rows as $row) {
                $foundIps[$row['ip_address']] = true;
                $cached[$row['ip_address']] = $this->rowToResult($row);
            }

            foreach ($ips as $ip) {
                if (!isset($foundIps[$ip])) {
                    $missing[] = $ip;
                }
            }

            // Update hit counts
            if (!empty($cached)) {
                $this->pdo->prepare("UPDATE ip_cache SET hit_count = hit_count + 1 
                    WHERE ip_address IN ($placeholders)")->execute(array_keys($cached));
                $this->recordCacheHit(count($cached));
            }
            if (!empty($missing)) {
                $this->recordCacheMiss(count($missing));
            }

        } catch (PDOException $e) {
            return ['cached' => [], 'missing' => $ips];
        }

        return ['cached' => $cached, 'missing' => $missing];
    }

    /**
     * Store IP query result in cache
     * Also archives to ip_database for permanent storage
     * 同時將數據歸檔到 ip_database 進行永久存儲
     *
     * @param string $ip IP address
     * @param array $data Query result data
     * @return bool Success
     */
    public function set($ip, array $data) {
        if (!CACHE_ENABLED) return false;

        $isBlacklisted = $data['blacklisted'] ?? false;
        $ttl = $isBlacklisted ? CACHE_TTL_BLACKLISTED : CACHE_TTL_SAFE;
        $expiresAt = date('Y-m-d H:i:s', time() + $ttl);
        $now = date('Y-m-d H:i:s');

        try {
            $sql = DB_TYPE === 'sqlite'
                ? "INSERT OR REPLACE INTO ip_cache "
                : "REPLACE INTO ip_cache ";
            $sql .= "(ip_address, is_blacklisted, status, country_code, country_name,
                city, region, isp, org, asn, latitude, longitude, timezone,
                risk_score, risk_level, risk_factors, threat_info, provider_results,
                providers_queried, providers_responded, created_at, updated_at, expires_at, hit_count)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";

            $geo = $data['geo'] ?? [];
            $risk = $data['riskAnalysis'] ?? [];

            $stmt = $this->pdo->prepare($sql);
            $cacheResult = $stmt->execute([
                $ip, $isBlacklisted ? 1 : 0, $data['status'] ?? 'safe',
                $geo['countryCode'] ?? $geo['country'] ?? null, $geo['countryName'] ?? null,
                $geo['city'] ?? null, $geo['region'] ?? null,
                $geo['isp'] ?? null, $geo['org'] ?? null, $geo['as'] ?? null,
                $geo['lat'] ?? null, $geo['lon'] ?? null, $geo['timezone'] ?? null,
                $risk['riskScore'] ?? 0, $risk['riskLevel'] ?? 'low',
                json_encode($risk['riskFactors'] ?? []),
                json_encode($data['threatInfo'] ?? null),
                json_encode($data['providerResults'] ?? []),
                $data['providerStats']['total'] ?? 0, $data['providerStats']['successful'] ?? 0,
                $now, $now, $expiresAt
            ]);

            // Also archive to permanent ip_database table
            // 同時歸檔到永久 ip_database 表
            if ($cacheResult) {
                $archiveData = [
                    'is_blacklisted' => $isBlacklisted ? 1 : 0,
                    'status' => $data['status'] ?? 'safe',
                    'country_code' => $geo['countryCode'] ?? $geo['country'] ?? null,
                    'country_name' => $geo['countryName'] ?? null,
                    'city' => $geo['city'] ?? null,
                    'region' => $geo['region'] ?? null,
                    'isp' => $geo['isp'] ?? null,
                    'org' => $geo['org'] ?? null,
                    'asn' => $geo['as'] ?? null,
                    'latitude' => $geo['lat'] ?? null,
                    'longitude' => $geo['lon'] ?? null,
                    'timezone' => $geo['timezone'] ?? null,
                    'risk_score' => $risk['riskScore'] ?? 0,
                    'risk_level' => $risk['riskLevel'] ?? 'low',
                    'risk_factors' => json_encode($risk['riskFactors'] ?? []),
                    'threat_info' => json_encode($data['threatInfo'] ?? null),
                    'provider_results' => json_encode($data['providerResults'] ?? []),
                    'providers_queried' => $data['providerStats']['total'] ?? 0,
                    'providers_responded' => $data['providerStats']['successful'] ?? 0,
                    'created_at' => $now,
                    'expires_at' => $expiresAt
                ];
                $this->archiveToDatabase($ip, $archiveData);
            }

            return $cacheResult;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Store batch query result for single IP (simplified format)
     * Also archives to ip_database for permanent storage
     * 同時將數據歸檔到 ip_database 進行永久存儲
     *
     * @param string $ip IP address
     * @param array $data Query result data (simplified batch format)
     * @return bool Success
     */
    public function setBatch($ip, array $data) {
        if (!CACHE_ENABLED) return false;

        $isBlacklisted = $data['blacklisted'] ?? false;
        $ttl = $isBlacklisted ? CACHE_TTL_BLACKLISTED : CACHE_TTL_SAFE;
        $expiresAt = date('Y-m-d H:i:s', time() + $ttl);
        $now = date('Y-m-d H:i:s');

        try {
            $sql = DB_TYPE === 'sqlite'
                ? "INSERT OR REPLACE INTO ip_cache "
                : "REPLACE INTO ip_cache ";
            $sql .= "(ip_address, is_blacklisted, status, country_code, country_name,
                city, isp, risk_score, risk_level, risk_factors, threat_info,
                providers_responded, created_at, updated_at, expires_at, hit_count)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";

            $stmt = $this->pdo->prepare($sql);
            $cacheResult = $stmt->execute([
                $ip, $isBlacklisted ? 1 : 0, $data['status'] ?? 'safe',
                $data['country'] ?? null, $data['countryName'] ?? null,
                $data['city'] ?? null, $data['isp'] ?? null,
                $data['riskScore'] ?? 0, $data['riskLevel'] ?? 'low',
                json_encode($data['riskFactors'] ?? []),
                json_encode($data['threatInfo'] ?? null),
                $data['providerCount'] ?? 0, $now, $now, $expiresAt
            ]);

            // Also archive to permanent ip_database table
            // 同時歸檔到永久 ip_database 表
            if ($cacheResult) {
                $archiveData = [
                    'is_blacklisted' => $isBlacklisted ? 1 : 0,
                    'status' => $data['status'] ?? 'safe',
                    'country_code' => $data['country'] ?? null,
                    'country_name' => $data['countryName'] ?? null,
                    'city' => $data['city'] ?? null,
                    'region' => null, // Not available in batch format
                    'isp' => $data['isp'] ?? null,
                    'org' => null, // Not available in batch format
                    'asn' => null, // Not available in batch format
                    'latitude' => null, // Not available in batch format
                    'longitude' => null, // Not available in batch format
                    'timezone' => null, // Not available in batch format
                    'risk_score' => $data['riskScore'] ?? 0,
                    'risk_level' => $data['riskLevel'] ?? 'low',
                    'risk_factors' => json_encode($data['riskFactors'] ?? []),
                    'threat_info' => json_encode($data['threatInfo'] ?? null),
                    'provider_results' => '[]', // Not available in batch format
                    'providers_queried' => 0,
                    'providers_responded' => $data['providerCount'] ?? 0,
                    'created_at' => $now,
                    'expires_at' => $expiresAt
                ];
                $this->archiveToDatabase($ip, $archiveData);
            }

            return $cacheResult;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Archive IP data to permanent ip_database table
     * This method writes query results to the permanent archive for long-term analysis
     * 將IP數據歸檔到永久ip_database表中，用於長期分析
     *
     * @param string $ip IP address
     * @param array $archiveData Normalized data array for archiving
     * @return bool Success
     */
    private function archiveToDatabase($ip, array $archiveData) {
        try {
            $now = date('Y-m-d H:i:s');

            // Check if IP already exists in archive
            $checkSql = "SELECT ip_address, original_created_at, original_expires_at, total_hit_count, custom_note, note_created_at, note_updated_at FROM ip_database WHERE ip_address = ?";
            $checkStmt = $this->pdo->prepare($checkSql);
            $checkStmt->execute([$ip]);
            $existing = $checkStmt->fetch(\PDO::FETCH_ASSOC);

            if ($existing) {
                // UPDATE existing record - preserve original timestamps, increment hit count, keep notes
                $sql = "UPDATE ip_database SET
                    is_blacklisted = ?, status = ?,
                    country_code = ?, country_name = ?, city = ?, region = ?,
                    isp = ?, org = ?, asn = ?,
                    latitude = ?, longitude = ?, timezone = ?,
                    risk_score = ?, risk_level = ?, risk_factors = ?,
                    threat_info = ?, provider_results = ?,
                    providers_queried = ?, providers_responded = ?,
                    archived_at = ?, total_hit_count = total_hit_count + 1
                    WHERE ip_address = ?";

                $stmt = $this->pdo->prepare($sql);
                return $stmt->execute([
                    $archiveData['is_blacklisted'] ?? 0,
                    $archiveData['status'] ?? 'safe',
                    $archiveData['country_code'] ?? null,
                    $archiveData['country_name'] ?? null,
                    $archiveData['city'] ?? null,
                    $archiveData['region'] ?? null,
                    $archiveData['isp'] ?? null,
                    $archiveData['org'] ?? null,
                    $archiveData['asn'] ?? null,
                    $archiveData['latitude'] ?? null,
                    $archiveData['longitude'] ?? null,
                    $archiveData['timezone'] ?? null,
                    $archiveData['risk_score'] ?? 0,
                    $archiveData['risk_level'] ?? 'low',
                    $archiveData['risk_factors'] ?? '[]',
                    $archiveData['threat_info'] ?? 'null',
                    $archiveData['provider_results'] ?? '[]',
                    $archiveData['providers_queried'] ?? 0,
                    $archiveData['providers_responded'] ?? 0,
                    $now,
                    $ip
                ]);
            } else {
                // INSERT new record
                $sql = DB_TYPE === 'sqlite'
                    ? "INSERT OR REPLACE INTO ip_database "
                    : "REPLACE INTO ip_database ";
                $sql .= "(ip_address, is_blacklisted, status,
                    country_code, country_name, city, region,
                    isp, org, asn, latitude, longitude, timezone,
                    risk_score, risk_level, risk_factors,
                    threat_info, provider_results,
                    providers_queried, providers_responded,
                    original_created_at, original_expires_at, archived_at, total_hit_count)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";

                $stmt = $this->pdo->prepare($sql);
                return $stmt->execute([
                    $ip,
                    $archiveData['is_blacklisted'] ?? 0,
                    $archiveData['status'] ?? 'safe',
                    $archiveData['country_code'] ?? null,
                    $archiveData['country_name'] ?? null,
                    $archiveData['city'] ?? null,
                    $archiveData['region'] ?? null,
                    $archiveData['isp'] ?? null,
                    $archiveData['org'] ?? null,
                    $archiveData['asn'] ?? null,
                    $archiveData['latitude'] ?? null,
                    $archiveData['longitude'] ?? null,
                    $archiveData['timezone'] ?? null,
                    $archiveData['risk_score'] ?? 0,
                    $archiveData['risk_level'] ?? 'low',
                    $archiveData['risk_factors'] ?? '[]',
                    $archiveData['threat_info'] ?? 'null',
                    $archiveData['provider_results'] ?? '[]',
                    $archiveData['providers_queried'] ?? 0,
                    $archiveData['providers_responded'] ?? 0,
                    $archiveData['created_at'] ?? $now,
                    $archiveData['expires_at'] ?? null,
                    $now
                ]);
            }
        } catch (\PDOException $e) {
            // Log error but don't fail the main cache operation
            error_log("Archive to database failed for IP {$ip}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Convert database row to result array
     */
    private function rowToResult(array $row) {
        $isBlacklisted = (bool)$row['is_blacklisted'];
        $riskScore = (int)$row['risk_score'];
        $riskLevel = $row['risk_level'] ?? 'low';
        $providersQueried = (int)$row['providers_queried'];
        $providersResponded = (int)$row['providers_responded'];

        // Regenerate display fields for risk analysis (not stored in DB)
        $riskLevelText = $this->getRiskLevelText($riskLevel);
        $recommendation = $this->getRecommendation($riskLevel, $isBlacklisted);

        return [
            'ip' => $row['ip_address'],
            'blacklisted' => $isBlacklisted,
            'status' => $row['status'],
            'geo' => [
                'country' => $row['country_code'],
                'countryCode' => $row['country_code'],
                'countryName' => $row['country_name'],
                'city' => $row['city'],
                'region' => $row['region'],
                'isp' => $row['isp'],
                'org' => $row['org'],
                'as' => $row['asn'],
                'lat' => $row['latitude'],
                'lon' => $row['longitude'],
                'timezone' => $row['timezone']
            ],
            'riskAnalysis' => [
                'riskScore' => $riskScore,
                'riskLevel' => $riskLevel,
                'riskLevelText' => $riskLevelText,
                'recommendation' => $recommendation,
                'riskFactors' => json_decode($row['risk_factors'] ?? '[]', true) ?: [],
                'providersQueried' => $providersQueried,
                'providersResponded' => $providersResponded,
                'dataRatio' => sprintf('%d/%d', $providersResponded, $providersQueried),
                'blacklistStatus' => $isBlacklisted ? '1/1' : '0/1'
            ],
            'threatInfo' => json_decode($row['threat_info'] ?? 'null', true),
            'providerResults' => json_decode($row['provider_results'] ?? '[]', true) ?: [],
            'providerStats' => [
                'total' => $providersQueried,
                'successful' => $providersResponded
            ],
            'cached' => true,
            'cacheHits' => (int)$row['hit_count'],
            'cachedAt' => $row['created_at'],
            'expiresAt' => $row['expires_at'],
            // Custom notes for blacklisted IPs
            'customNote' => $row['custom_note'] ?? null,
            'noteCreatedAt' => $row['note_created_at'] ?? null,
            'noteUpdatedAt' => $row['note_updated_at'] ?? null
        ];
    }

    /**
     * Get risk level text based on risk level
     */
    private function getRiskLevelText($riskLevel) {
        switch ($riskLevel) {
            case 'high':
                return '高風險 / High Risk';
            case 'medium':
                return '中等風險 / Medium Risk';
            case 'low':
            default:
                return '低風險 / Low Risk';
        }
    }

    /**
     * Get recommendation based on risk level and blacklist status
     */
    private function getRecommendation($riskLevel, $isBlacklisted) {
        if ($riskLevel === 'high') {
            return $isBlacklisted
                ? '建議封鎖此IP。此IP已被列入黑名單。/ Recommend blocking this IP. This IP is blacklisted.'
                : '需要進一步調查。/ Requires further investigation.';
        } elseif ($riskLevel === 'medium') {
            return '建議監控此IP的活動。/ Recommend monitoring this IP\'s activity.';
        } else {
            return '此IP目前看起來是安全的。/ This IP appears to be safe.';
        }
    }

    /**
     * Save or update custom note for an IP
     * @param string $ip IP address
     * @param string $note Custom note text
     * @return array Result with success status and message
     */
    public function saveNote($ip, $note) {
        if (empty($ip)) {
            return ['success' => false, 'error' => 'IP address is required'];
        }

        $now = date('Y-m-d H:i:s');
        $note = trim($note);

        try {
            // Check if IP exists in cache
            $stmt = $this->pdo->prepare("SELECT ip_address, custom_note, note_created_at FROM ip_cache WHERE ip_address = ?");
            $stmt->execute([$ip]);
            $existing = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existing) {
                // Update existing record
                $noteCreatedAt = $existing['note_created_at'] ?? $now;
                $stmt = $this->pdo->prepare("UPDATE ip_cache SET custom_note = ?, note_created_at = ?, note_updated_at = ? WHERE ip_address = ?");
                $stmt->execute([$note, $noteCreatedAt, $now, $ip]);
            } else {
                // Insert new record with note only
                $stmt = $this->pdo->prepare("INSERT INTO ip_cache (ip_address, custom_note, note_created_at, note_updated_at) VALUES (?, ?, ?, ?)");
                $stmt->execute([$ip, $note, $now, $now]);
            }

            return [
                'success' => true,
                'ip' => $ip,
                'note' => $note,
                'noteCreatedAt' => $existing['note_created_at'] ?? $now,
                'noteUpdatedAt' => $now,
                'message' => 'Note saved successfully / 備註已成功儲存'
            ];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Get custom note for an IP
     * @param string $ip IP address
     * @return array|null Note data or null if not found
     */
    public function getNote($ip) {
        if (empty($ip)) {
            return null;
        }

        try {
            $stmt = $this->pdo->prepare("SELECT custom_note, note_created_at, note_updated_at FROM ip_cache WHERE ip_address = ?");
            $stmt->execute([$ip]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row && !empty($row['custom_note'])) {
                return [
                    'ip' => $ip,
                    'note' => $row['custom_note'],
                    'createdAt' => $row['note_created_at'],
                    'updatedAt' => $row['note_updated_at']
                ];
            }
            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Delete custom note for an IP
     * @param string $ip IP address
     * @return array Result with success status
     */
    public function deleteNote($ip) {
        if (empty($ip)) {
            return ['success' => false, 'error' => 'IP address is required'];
        }

        try {
            $stmt = $this->pdo->prepare("UPDATE ip_cache SET custom_note = NULL, note_created_at = NULL, note_updated_at = NULL WHERE ip_address = ?");
            $stmt->execute([$ip]);
            return [
                'success' => true,
                'ip' => $ip,
                'message' => 'Note deleted successfully / 備註已成功刪除'
            ];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => 'Database error: ' . $e->getMessage()];
        }
    }

    /**
     * Archive expired cache entries to ip_database before deletion
     * @return int Number of records archived
     */
    public function archiveExpired() {
        try {
            $now = date('Y-m-d H:i:s');

            // Get expired records first
            $selectSql = "SELECT * FROM ip_cache WHERE expires_at < ?";
            $stmt = $this->pdo->prepare($selectSql);
            $stmt->execute([$now]);
            $expiredRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($expiredRows)) {
                return 0;
            }

            $archived = 0;
            foreach ($expiredRows as $row) {
                if ($this->archiveRecord($row)) {
                    $archived++;
                }
            }

            return $archived;
        } catch (PDOException $e) {
            $this->logError('Archive failed: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Archive a single cache record to ip_database
     * @param array $row Cache record
     * @return bool Success
     */
    private function archiveRecord(array $row) {
        try {
            $sql = DB_TYPE === 'sqlite'
                ? "INSERT OR REPLACE INTO ip_database "
                : "REPLACE INTO ip_database ";
            $sql .= "(ip_address, is_blacklisted, status, country_code, country_name,
                city, region, isp, org, asn, latitude, longitude, timezone,
                risk_score, risk_level, risk_factors, threat_info, provider_results,
                providers_queried, providers_responded, original_created_at, original_expires_at,
                archived_at, total_hit_count, custom_note, note_created_at, note_updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $row['ip_address'],
                $row['is_blacklisted'] ?? 0,
                $row['status'] ?? 'safe',
                $row['country_code'] ?? null,
                $row['country_name'] ?? null,
                $row['city'] ?? null,
                $row['region'] ?? null,
                $row['isp'] ?? null,
                $row['org'] ?? null,
                $row['asn'] ?? null,
                $row['latitude'] ?? null,
                $row['longitude'] ?? null,
                $row['timezone'] ?? null,
                $row['risk_score'] ?? 0,
                $row['risk_level'] ?? 'low',
                $row['risk_factors'] ?? null,
                $row['threat_info'] ?? null,
                $row['provider_results'] ?? null,
                $row['providers_queried'] ?? 0,
                $row['providers_responded'] ?? 0,
                $row['created_at'] ?? null,
                $row['expires_at'] ?? null,
                date('Y-m-d H:i:s'),
                $row['hit_count'] ?? 0,
                $row['custom_note'] ?? null,
                $row['note_created_at'] ?? null,
                $row['note_updated_at'] ?? null
            ]);
        } catch (PDOException $e) {
            $this->logError('Archive record failed for ' . $row['ip_address'] . ': ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete expired cache entries (archives first)
     * @return array ['archived' => int, 'deleted' => int]
     */
    public function cleanup() {
        try {
            // First, archive expired records
            $archived = $this->archiveExpired();

            // Then delete expired records from cache
            $stmt = $this->pdo->prepare("DELETE FROM ip_cache WHERE expires_at < ?");
            $stmt->execute([date('Y-m-d H:i:s')]);
            $deleted = $stmt->rowCount();

            return ['archived' => $archived, 'deleted' => $deleted];
        } catch (PDOException $e) {
            $this->logError('Cleanup failed: ' . $e->getMessage());
            return ['archived' => 0, 'deleted' => 0];
        }
    }

    /**
     * Maybe run cleanup based on probability
     */
    private function maybeCleanup() {
        if (CACHE_CLEANUP_ENABLED && rand(1, 100) <= CACHE_CLEANUP_PROBABILITY) {
            $this->cleanup();
        }
    }

    /**
     * Log error message
     */
    private function logError($msg) {
        if (defined('CACHE_LOG_ENABLED') && CACHE_LOG_ENABLED) {
            $log = sprintf("[%s] ERROR: %s\n", date('Y-m-d H:i:s'), $msg);
            @file_put_contents(CACHE_LOG_FILE, $log, FILE_APPEND);
        }
    }

    /**
     * Get cache statistics
     */
    public function getStats() {
        try {
            $stats = [];

            // Total cached
            $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM ip_cache");
            $stats['totalCached'] = (int)$stmt->fetch()['total'];

            // Active (not expired)
            $stmt = $this->pdo->prepare("SELECT COUNT(*) as active FROM ip_cache WHERE expires_at > ?");
            $stmt->execute([date('Y-m-d H:i:s')]);
            $stats['activeCached'] = (int)$stmt->fetch()['active'];

            // By status
            $stmt = $this->pdo->query("SELECT status, COUNT(*) as cnt FROM ip_cache GROUP BY status");
            $stats['byStatus'] = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

            // By risk level
            $stmt = $this->pdo->query("SELECT risk_level, COUNT(*) as cnt FROM ip_cache GROUP BY risk_level");
            $stats['byRiskLevel'] = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

            // Total hits
            $stmt = $this->pdo->query("SELECT SUM(hit_count) as hits FROM ip_cache");
            $stats['totalHits'] = (int)($stmt->fetch()['hits'] ?? 0);

            // Today's stats
            $today = date('Y-m-d');
            $stmt = $this->pdo->prepare("SELECT * FROM cache_stats WHERE stat_date = ?");
            $stmt->execute([$today]);
            $todayStats = $stmt->fetch();
            $stats['today'] = $todayStats ?: ['cache_hits' => 0, 'cache_misses' => 0, 'total_queries' => 0];

            return $stats;
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Clear all cache
     */
    public function clearAll() {
        try {
            $this->pdo->exec("DELETE FROM ip_cache");
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Get cache info for a specific IP (without returning full data)
     * @param string $ip IP address
     * @return array|null Cache metadata
     */
    public function getCacheInfoForIP($ip) {
        try {
            $sql = "SELECT ip_address, created_at, updated_at, expires_at, hit_count FROM ip_cache WHERE ip_address = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$ip]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $now = time();
                $expiresAt = strtotime($row['expires_at']);
                $createdAt = strtotime($row['created_at']);
                $remainingSeconds = max(0, $expiresAt - $now);

                return [
                    'isCached' => true,
                    'createdAt' => $row['created_at'],
                    'updatedAt' => $row['updated_at'],
                    'expiresAt' => $row['expires_at'],
                    'hitCount' => (int)$row['hit_count'],
                    'isExpired' => $expiresAt < $now,
                    'remainingSeconds' => $remainingSeconds,
                    'remainingHuman' => $this->formatDuration($remainingSeconds),
                    'ageSeconds' => $now - $createdAt,
                    'ageHuman' => $this->formatDuration($now - $createdAt)
                ];
            }

            return [
                'isCached' => false,
                'message' => 'IP not in cache / IP不在快取中'
            ];
        } catch (PDOException $e) {
            return ['isCached' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Format seconds into human-readable duration
     */
    private function formatDuration($seconds) {
        if ($seconds < 60) return $seconds . '秒';
        if ($seconds < 3600) return floor($seconds / 60) . '分鐘';
        if ($seconds < 86400) return floor($seconds / 3600) . '小時 ' . floor(($seconds % 3600) / 60) . '分鐘';
        return floor($seconds / 86400) . '天 ' . floor(($seconds % 86400) / 3600) . '小時';
    }

    /**
     * Check if IP exists in cache (without fetching data)
     */
    public function exists($ip) {
        try {
            $sql = "SELECT 1 FROM ip_cache WHERE ip_address = ? AND expires_at > ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$ip, date('Y-m-d H:i:s')]);
            return $stmt->fetch() !== false;
        } catch (PDOException $e) {
            return false;
        }
    }

    private function recordCacheHit($count = 1) {
        $this->updateDailyStats('cache_hits', $count);
    }

    private function recordCacheMiss($count = 1) {
        $this->updateDailyStats('cache_misses', $count);
    }

    private function updateDailyStats($field, $count = 1) {
        try {
            $today = date('Y-m-d');
            $sql = DB_TYPE === 'sqlite'
                ? "INSERT OR IGNORE INTO cache_stats (stat_date, total_queries) VALUES (?, 0)"
                : "INSERT IGNORE INTO cache_stats (stat_date, total_queries) VALUES (?, 0)";
            $this->pdo->prepare($sql)->execute([$today]);

            $sql = "UPDATE cache_stats SET {$field} = {$field} + ?, total_queries = total_queries + ? WHERE stat_date = ?";
            $this->pdo->prepare($sql)->execute([$count, $count, $today]);
        } catch (PDOException $e) {
            // Ignore stats errors
        }
    }

    // ============================================================================
    // LOCAL DATABASE (ARCHIVE) QUERY METHODS / 本地數據庫（歸檔）查詢方法
    // ============================================================================

    /**
     * Query local database (archived data) by IP address
     * @param string $ip IP address
     * @return array|null Archived data or null if not found
     */
    public function queryLocal($ip) {
        if (empty($ip)) return null;

        try {
            $sql = "SELECT * FROM ip_database WHERE ip_address = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$ip]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                return $this->archiveRowToResult($row);
            }
            return null;
        } catch (PDOException $e) {
            $this->logError('Local query failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Search local database (archived data) with filters
     * @param array $filters Search filters (ip, dateFrom, dateTo, country, riskLevel, status)
     * @param int $limit Max results (default 100)
     * @param int $offset Offset for pagination (default 0)
     * @return array Search results with pagination info
     */
    public function searchLocal(array $filters = [], $limit = 100, $offset = 0) {
        try {
            $where = [];
            $params = [];

            // IP filter (partial match)
            if (!empty($filters['ip'])) {
                $where[] = "ip_address LIKE ?";
                $params[] = '%' . $filters['ip'] . '%';
            }

            // Date range filter (based on archived_at)
            if (!empty($filters['dateFrom'])) {
                $where[] = "archived_at >= ?";
                $params[] = $filters['dateFrom'] . ' 00:00:00';
            }
            if (!empty($filters['dateTo'])) {
                $where[] = "archived_at <= ?";
                $params[] = $filters['dateTo'] . ' 23:59:59';
            }

            // Country filter
            if (!empty($filters['country'])) {
                $where[] = "country_code = ?";
                $params[] = $filters['country'];
            }

            // Risk level filter
            if (!empty($filters['riskLevel'])) {
                $where[] = "risk_level = ?";
                $params[] = $filters['riskLevel'];
            }

            // Blacklist status filter
            if (isset($filters['status']) && $filters['status'] !== '') {
                if ($filters['status'] === 'blocked') {
                    $where[] = "is_blacklisted = 1";
                } elseif ($filters['status'] === 'safe') {
                    $where[] = "is_blacklisted = 0";
                }
            }

            // Build WHERE clause
            $whereClause = empty($where) ? "" : "WHERE " . implode(" AND ", $where);

            // Get total count
            $countSql = "SELECT COUNT(*) as total FROM ip_database {$whereClause}";
            $stmt = $this->pdo->prepare($countSql);
            $stmt->execute($params);
            $total = (int)$stmt->fetch()['total'];

            // Get results with pagination
            $limit = min(max(1, (int)$limit), 500); // Max 500 results
            $offset = max(0, (int)$offset);

            $sql = "SELECT * FROM ip_database {$whereClause} ORDER BY archived_at DESC LIMIT ? OFFSET ?";
            $params[] = $limit;
            $params[] = $offset;

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $results = [];
            foreach ($rows as $row) {
                $results[] = $this->archiveRowToResult($row);
            }

            return [
                'success' => true,
                'total' => $total,
                'count' => count($results),
                'limit' => $limit,
                'offset' => $offset,
                'hasMore' => ($offset + count($results)) < $total,
                'results' => $results
            ];
        } catch (PDOException $e) {
            $this->logError('Local search failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Search failed: ' . $e->getMessage(),
                'results' => []
            ];
        }
    }

    /**
     * Get statistics for archived data
     * @return array Archive statistics
     */
    public function getArchiveStats() {
        try {
            $stats = [];

            // Total archived
            $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM ip_database");
            $stats['totalArchived'] = (int)$stmt->fetch()['total'];

            // By status
            $stmt = $this->pdo->query("SELECT status, COUNT(*) as cnt FROM ip_database GROUP BY status");
            $stats['byStatus'] = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

            // By risk level
            $stmt = $this->pdo->query("SELECT risk_level, COUNT(*) as cnt FROM ip_database GROUP BY risk_level");
            $stats['byRiskLevel'] = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

            // By country (top 10)
            $stmt = $this->pdo->query("SELECT country_code, COUNT(*) as cnt FROM ip_database WHERE country_code IS NOT NULL GROUP BY country_code ORDER BY cnt DESC LIMIT 10");
            $stats['topCountries'] = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

            // Unique country count
            $stmt = $this->pdo->query("SELECT COUNT(DISTINCT country_code) as cnt FROM ip_database WHERE country_code IS NOT NULL");
            $stats['countryCount'] = (int)$stmt->fetch()['cnt'];

            // Blacklisted count
            $stmt = $this->pdo->query("SELECT COUNT(*) as cnt FROM ip_database WHERE is_blacklisted = 1");
            $stats['blacklistedCount'] = (int)$stmt->fetch()['cnt'];

            // Total hits (from archived records)
            $stmt = $this->pdo->query("SELECT SUM(total_hit_count) as hits FROM ip_database");
            $stats['totalHits'] = (int)($stmt->fetch()['hits'] ?? 0);

            // Date range of archived data
            $stmt = $this->pdo->query("SELECT MIN(archived_at) as oldest, MAX(archived_at) as newest FROM ip_database");
            $dateRange = $stmt->fetch();
            $stats['dateRange'] = [
                'oldest' => $dateRange['oldest'],
                'newest' => $dateRange['newest']
            ];

            return $stats;
        } catch (PDOException $e) {
            $this->logError('Archive stats failed: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Get region code for a country code
     * Maps ISO 3166-1 alpha-2 country codes to regions: EU, AM, APAC
     * @param string $countryCode Two-letter country code
     * @return string Region code (EU, AM, APAC, or OTHER)
     */
    private function getRegionForCountry($countryCode) {
        // EU (Europe) - European countries
        $euCountries = [
            'AL', 'AD', 'AT', 'BY', 'BE', 'BA', 'BG', 'HR', 'CY', 'CZ',
            'DK', 'EE', 'FI', 'FR', 'DE', 'GR', 'HU', 'IS', 'IE', 'IT',
            'XK', 'LV', 'LI', 'LT', 'LU', 'MT', 'MD', 'MC', 'ME', 'NL',
            'MK', 'NO', 'PL', 'PT', 'RO', 'RU', 'SM', 'RS', 'SK', 'SI',
            'ES', 'SE', 'CH', 'UA', 'GB', 'VA', 'AX', 'FO', 'GI', 'GG',
            'IM', 'JE', 'SJ'
        ];

        // AM (Americas) - North, Central, South America, Caribbean
        $amCountries = [
            'AI', 'AG', 'AR', 'AW', 'BS', 'BB', 'BZ', 'BM', 'BO', 'BQ',
            'BR', 'VG', 'CA', 'KY', 'CL', 'CO', 'CR', 'CU', 'CW', 'DM',
            'DO', 'EC', 'SV', 'FK', 'GF', 'GL', 'GD', 'GP', 'GT', 'GY',
            'HT', 'HN', 'JM', 'MQ', 'MX', 'MS', 'NI', 'PA', 'PY', 'PE',
            'PR', 'BL', 'KN', 'LC', 'MF', 'PM', 'VC', 'SX', 'SR', 'TT',
            'TC', 'US', 'VI', 'UY', 'VE'
        ];

        // APAC (Asia-Pacific) - Asia, Pacific Islands, Oceania
        $apacCountries = [
            'AF', 'AM', 'AZ', 'BH', 'BD', 'BT', 'BN', 'KH', 'CN', 'CX',
            'CC', 'CK', 'FJ', 'PF', 'GU', 'HK', 'IN', 'ID', 'IR', 'IQ',
            'IL', 'JP', 'JO', 'KZ', 'KW', 'KG', 'LA', 'LB', 'MO', 'MY',
            'MV', 'MH', 'FM', 'MN', 'MM', 'NR', 'NP', 'NC', 'NZ', 'NU',
            'NF', 'KP', 'MP', 'OM', 'PK', 'PW', 'PS', 'PG', 'PH', 'PN',
            'QA', 'SA', 'SG', 'SB', 'KR', 'LK', 'SY', 'TW', 'TJ', 'TH',
            'TL', 'TK', 'TO', 'TM', 'TV', 'AE', 'UZ', 'VU', 'VN', 'WF',
            'WS', 'YE', 'AU', 'GE', 'TR'
        ];

        $cc = strtoupper($countryCode);

        if (in_array($cc, $euCountries)) return 'EU';
        if (in_array($cc, $amCountries)) return 'AM';
        if (in_array($cc, $apacCountries)) return 'APAC';

        return 'OTHER';
    }

    /**
     * Get region name for display
     * @param string $regionCode Region code (EU, AM, APAC)
     * @return array Region name in English and Chinese
     */
    private function getRegionName($regionCode) {
        $regions = [
            'EU' => ['en' => 'Europe', 'zh' => '歐洲'],
            'AM' => ['en' => 'Americas', 'zh' => '美洲'],
            'APAC' => ['en' => 'Asia-Pacific', 'zh' => '亞太地區'],
            'OTHER' => ['en' => 'Other', 'zh' => '其他']
        ];
        return $regions[$regionCode] ?? $regions['OTHER'];
    }

    /**
     * Get detailed archive statistics for charts and visualizations
     * @return array Detailed statistics with distributions for all dimensions
     */
    public function getArchiveStatsDetailed() {
        try {
            $stats = [];

            // Basic counts
            $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM ip_database");
            $stats['totalArchived'] = (int)$stmt->fetch()['total'];

            $stmt = $this->pdo->query("SELECT COUNT(*) as cnt FROM ip_database WHERE is_blacklisted = 1");
            $stats['blacklistedCount'] = (int)$stmt->fetch()['cnt'];

            // Country distribution (top 20) with region classification
            $stmt = $this->pdo->query("
                SELECT country_code, country_name, COUNT(*) as count
                FROM ip_database
                WHERE country_code IS NOT NULL AND country_code != ''
                GROUP BY country_code, country_name
                ORDER BY count DESC
                LIMIT 20
            ");
            $countryData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Add region to each country
            foreach ($countryData as &$country) {
                $region = $this->getRegionForCountry($country['country_code']);
                $regionName = $this->getRegionName($region);
                $country['region'] = $region;
                $country['region_name_en'] = $regionName['en'];
                $country['region_name_zh'] = $regionName['zh'];
            }
            $stats['countryDistribution'] = $countryData;

            // Region distribution (aggregate by region)
            $stmt = $this->pdo->query("
                SELECT country_code, COUNT(*) as count
                FROM ip_database
                WHERE country_code IS NOT NULL AND country_code != ''
                GROUP BY country_code
            ");
            $allCountries = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $regionStats = [
                'EU' => ['code' => 'EU', 'name_en' => 'Europe', 'name_zh' => '歐洲', 'count' => 0, 'countries' => 0],
                'AM' => ['code' => 'AM', 'name_en' => 'Americas', 'name_zh' => '美洲', 'count' => 0, 'countries' => 0],
                'APAC' => ['code' => 'APAC', 'name_en' => 'Asia-Pacific', 'name_zh' => '亞太地區', 'count' => 0, 'countries' => 0],
                'OTHER' => ['code' => 'OTHER', 'name_en' => 'Other', 'name_zh' => '其他', 'count' => 0, 'countries' => 0]
            ];

            foreach ($allCountries as $country) {
                $region = $this->getRegionForCountry($country['country_code']);
                $regionStats[$region]['count'] += (int)$country['count'];
                $regionStats[$region]['countries']++;
            }

            // Calculate percentages
            $totalRegionCount = array_sum(array_column($regionStats, 'count'));
            foreach ($regionStats as &$region) {
                $region['percentage'] = $totalRegionCount > 0
                    ? round(($region['count'] / $totalRegionCount) * 100, 1)
                    : 0;
            }

            // Sort by count descending and convert to indexed array
            uasort($regionStats, fn($a, $b) => $b['count'] - $a['count']);
            $stats['regionDistribution'] = array_values($regionStats);

            // City distribution (top 20)
            $stmt = $this->pdo->query("
                SELECT city, country_code, COUNT(*) as count
                FROM ip_database
                WHERE city IS NOT NULL AND city != '' AND city != '-'
                GROUP BY city, country_code
                ORDER BY count DESC
                LIMIT 20
            ");
            $stats['cityDistribution'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // ISP distribution (top 20)
            $stmt = $this->pdo->query("
                SELECT isp, COUNT(*) as count
                FROM ip_database
                WHERE isp IS NOT NULL AND isp != '' AND isp != '-'
                GROUP BY isp
                ORDER BY count DESC
                LIMIT 20
            ");
            $stats['ispDistribution'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Risk level distribution
            $stmt = $this->pdo->query("
                SELECT risk_level, COUNT(*) as count
                FROM ip_database
                GROUP BY risk_level
            ");
            $stats['riskLevelDistribution'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Risk score distribution (grouped into ranges)
            $stmt = $this->pdo->query("
                SELECT
                    CASE
                        WHEN risk_score >= 80 THEN '80-100'
                        WHEN risk_score >= 60 THEN '60-79'
                        WHEN risk_score >= 40 THEN '40-59'
                        WHEN risk_score >= 20 THEN '20-39'
                        ELSE '0-19'
                    END as score_range,
                    COUNT(*) as count
                FROM ip_database
                GROUP BY score_range
                ORDER BY score_range DESC
            ");
            $stats['riskScoreDistribution'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Threat type distribution (parse from threat_info JSON)
            $stmt = $this->pdo->query("SELECT threat_info FROM ip_database WHERE threat_info IS NOT NULL AND threat_info != 'null'");
            $threatTypes = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $threatInfo = json_decode($row['threat_info'], true);
                if ($threatInfo && isset($threatInfo['threatType'])) {
                    $type = $threatInfo['threatType'];
                    if (!isset($threatTypes[$type])) {
                        $threatTypes[$type] = 0;
                    }
                    $threatTypes[$type]++;
                }
            }
            arsort($threatTypes);
            $stats['threatTypeDistribution'] = array_slice(
                array_map(fn($type, $count) => ['threatType' => $type, 'count' => $count],
                    array_keys($threatTypes), array_values($threatTypes)),
                0, 20
            );

            // Unique counts
            $stmt = $this->pdo->query("SELECT COUNT(DISTINCT country_code) as cnt FROM ip_database WHERE country_code IS NOT NULL");
            $stats['countryCount'] = (int)$stmt->fetch()['cnt'];

            $stmt = $this->pdo->query("SELECT COUNT(DISTINCT city) as cnt FROM ip_database WHERE city IS NOT NULL AND city != '' AND city != '-'");
            $stats['cityCount'] = (int)$stmt->fetch()['cnt'];

            $stmt = $this->pdo->query("SELECT COUNT(DISTINCT isp) as cnt FROM ip_database WHERE isp IS NOT NULL AND isp != '' AND isp != '-'");
            $stats['ispCount'] = (int)$stmt->fetch()['cnt'];

            return $stats;
        } catch (PDOException $e) {
            $this->logError('Archive detailed stats failed: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Convert archived database row to result array
     * @param array $row Database row
     * @return array Formatted result with archived flag
     */
    private function archiveRowToResult(array $row) {
        $isBlacklisted = (bool)$row['is_blacklisted'];
        $riskScore = (int)$row['risk_score'];
        $riskLevel = $row['risk_level'] ?? 'low';
        $providersQueried = (int)$row['providers_queried'];
        $providersResponded = (int)$row['providers_responded'];

        // Regenerate display fields for risk analysis
        $riskLevelText = $this->getRiskLevelText($riskLevel);
        $recommendation = $this->getRecommendation($riskLevel, $isBlacklisted);

        return [
            'ip' => $row['ip_address'],
            'blacklisted' => $isBlacklisted,
            'status' => $row['status'],
            'geo' => [
                'country' => $row['country_code'],
                'countryCode' => $row['country_code'],
                'countryName' => $row['country_name'],
                'city' => $row['city'],
                'region' => $row['region'],
                'isp' => $row['isp'],
                'org' => $row['org'],
                'as' => $row['asn'],
                'lat' => $row['latitude'],
                'lon' => $row['longitude'],
                'timezone' => $row['timezone']
            ],
            'riskAnalysis' => [
                'riskScore' => $riskScore,
                'riskLevel' => $riskLevel,
                'riskLevelText' => $riskLevelText,
                'recommendation' => $recommendation,
                'riskFactors' => json_decode($row['risk_factors'] ?? '[]', true) ?: [],
                'providersQueried' => $providersQueried,
                'providersResponded' => $providersResponded,
                'dataRatio' => sprintf('%d/%d', $providersResponded, $providersQueried),
                'blacklistStatus' => $isBlacklisted ? '1/1' : '0/1'
            ],
            'threatInfo' => json_decode($row['threat_info'] ?? 'null', true),
            'providerResults' => json_decode($row['provider_results'] ?? '[]', true) ?: [],
            'providerStats' => [
                'total' => $providersQueried,
                'successful' => $providersResponded
            ],
            // Archive-specific fields
            'archived' => true,
            'archivedAt' => $row['archived_at'],
            'originalCreatedAt' => $row['original_created_at'],
            'originalExpiresAt' => $row['original_expires_at'],
            'totalHitCount' => (int)$row['total_hit_count'],
            // Custom notes
            'customNote' => $row['custom_note'] ?? null,
            'noteCreatedAt' => $row['note_created_at'] ?? null,
            'noteUpdatedAt' => $row['note_updated_at'] ?? null
        ];
    }

    /**
     * Get list of unique countries in archive
     * @return array Country codes and names
     */
    public function getArchiveCountries() {
        try {
            $sql = "SELECT DISTINCT country_code, country_name FROM ip_database
                    WHERE country_code IS NOT NULL
                    ORDER BY country_name";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Get blacklisted IPs grouped by country with IP list
     * 獲取按國家分組的黑名單IP及其IP列表
     *
     * @param int $limit Maximum number of countries to return (default 10)
     * @return array Countries with IP counts and IP lists
     */
    public function getCountryIPRanges($limit = 10) {
        try {
            // First get top countries by blacklisted IP count
            $sql = "SELECT
                        country_code,
                        country_name,
                        COUNT(*) as ip_count
                    FROM ip_database
                    WHERE is_blacklisted = 1
                        AND country_code IS NOT NULL
                        AND country_code != ''
                    GROUP BY country_code, country_name
                    ORDER BY ip_count DESC
                    LIMIT ?";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([(int)$limit]);
            $countries = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // For each country, get the IP addresses
            $result = [];
            foreach ($countries as $country) {
                $ipSql = "SELECT ip_address
                          FROM ip_database
                          WHERE is_blacklisted = 1
                              AND country_code = ?
                          ORDER BY ip_address
                          LIMIT 100"; // Limit IPs per country to prevent huge responses

                $ipStmt = $this->pdo->prepare($ipSql);
                $ipStmt->execute([$country['country_code']]);
                $ips = $ipStmt->fetchAll(PDO::FETCH_COLUMN);

                // Convert IPs to ranges/CIDR notation where possible
                $ipRanges = $this->convertIPsToRanges($ips);

                $result[] = [
                    'country_code' => $country['country_code'],
                    'country_name' => $country['country_name'] ?? $country['country_code'],
                    'ip_count' => (int)$country['ip_count'],
                    'ip_ranges' => $ipRanges,
                    'sample_ips' => array_slice($ips, 0, 10) // First 10 IPs as samples
                ];
            }

            return $result;
        } catch (PDOException $e) {
            $this->logError('Get country IP ranges failed: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Convert a list of IPs to ranges/CIDR notation where possible
     * 將IP列表轉換為範圍/CIDR表示法
     *
     * @param array $ips List of IP addresses
     * @return array IP ranges in CIDR or range format
     */
    private function convertIPsToRanges(array $ips) {
        if (empty($ips)) return [];

        // Convert IPs to integers for sorting and grouping
        $ipInts = [];
        foreach ($ips as $ip) {
            $int = ip2long($ip);
            if ($int !== false) {
                $ipInts[$int] = $ip;
            }
        }
        ksort($ipInts);

        $ranges = [];
        $rangeStart = null;
        $rangeEnd = null;
        $prevInt = null;

        foreach ($ipInts as $int => $ip) {
            if ($rangeStart === null) {
                $rangeStart = $int;
                $rangeEnd = $int;
            } elseif ($int === $prevInt + 1) {
                // Consecutive IP, extend range
                $rangeEnd = $int;
            } else {
                // Gap found, save current range and start new one
                $ranges[] = $this->formatIPRange($rangeStart, $rangeEnd);
                $rangeStart = $int;
                $rangeEnd = $int;
            }
            $prevInt = $int;
        }

        // Don't forget the last range
        if ($rangeStart !== null) {
            $ranges[] = $this->formatIPRange($rangeStart, $rangeEnd);
        }

        return $ranges;
    }

    /**
     * Format an IP range as CIDR or range notation
     * @param int $start Start IP as integer
     * @param int $end End IP as integer
     * @return string Formatted range
     */
    private function formatIPRange($start, $end) {
        $startIP = long2ip($start);
        $endIP = long2ip($end);

        if ($start === $end) {
            // Single IP
            return $startIP;
        }

        $count = $end - $start + 1;

        // Check if it's a valid CIDR block
        $cidr = $this->rangeToCIDR($start, $end);
        if ($cidr) {
            return $cidr;
        }

        // Otherwise return as range
        return "{$startIP} - {$endIP} ({$count} IPs)";
    }

    /**
     * Try to convert IP range to CIDR notation
     * @param int $start Start IP as integer
     * @param int $end End IP as integer
     * @return string|null CIDR notation or null if not a valid CIDR block
     */
    private function rangeToCIDR($start, $end) {
        $count = $end - $start + 1;

        // Check if count is a power of 2
        if (($count & ($count - 1)) !== 0) {
            return null;
        }

        // Calculate prefix length
        $prefix = 32 - (int)log($count, 2);

        // Verify the start address is aligned to the CIDR block
        $mask = ~((1 << (32 - $prefix)) - 1);
        if (($start & $mask) !== $start) {
            return null;
        }

        return long2ip($start) . '/' . $prefix;
    }
}

