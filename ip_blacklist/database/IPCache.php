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
            return $stmt->execute([
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
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Store batch query result for single IP (simplified format)
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
            return $stmt->execute([
                $ip, $isBlacklisted ? 1 : 0, $data['status'] ?? 'safe',
                $data['country'] ?? null, $data['countryName'] ?? null,
                $data['city'] ?? null, $data['isp'] ?? null,
                $data['riskScore'] ?? 0, $data['riskLevel'] ?? 'low',
                json_encode($data['riskFactors'] ?? []),
                json_encode($data['threatInfo'] ?? null),
                $data['providerCount'] ?? 0, $now, $now, $expiresAt
            ]);
        } catch (PDOException $e) {
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
     * Delete expired cache entries
     */
    public function cleanup() {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM ip_cache WHERE expires_at < ?");
            $stmt->execute([date('Y-m-d H:i:s')]);
            return $stmt->rowCount();
        } catch (PDOException $e) {
            return 0;
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
}

