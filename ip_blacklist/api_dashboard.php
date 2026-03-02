<?php
/**
 * Security Dashboard API functions for ip_blacklist
 * Supports both SQLite (dev) and MySQL (production)
 *
 * Called from api.php via:
 *   dash_stats, dash_blacklist, dash_faz, dash_country, dash_country_timeline
 */

require_once __DIR__ . '/database/IPCacheDB.php';

/**
 * Helper: Get DB PDO or null if not connected.
 */
function getDashDB() {
    $instance = IPCacheDB::getInstance();
    if (!$instance->isConnected()) {
        return null;
    }
    try {
        return $instance->getPDO();
    } catch (Exception $e) {
        return null;
    }
}

/**
 * Helper: Check if FAZ tables exist; if not, create them (DB-agnostic).
 */
function ensureFazTables() {
    static $checked = false;
    if ($checked) return;
    $db = getDashDB();
    if (!$db) { $checked = true; return; }
    try {
        if (DB_TYPE === 'sqlite') {
            $db->exec("
                CREATE TABLE IF NOT EXISTS faz_raw_events (
                    ip TEXT NOT NULL,
                    timestamp DATETIME NOT NULL,
                    UNIQUE(ip, timestamp)
                );
            ");
            $db->exec("
                CREATE TABLE IF NOT EXISTS faz_logs (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    run_id TEXT NOT NULL,
                    ip TEXT NOT NULL,
                    count INTEGER NOT NULL,
                    first_seen TEXT NOT NULL,
                    last_seen TEXT NOT NULL,
                    imported_at DATETIME DEFAULT CURRENT_TIMESTAMP
                );
            ");
        } else {
            $db->exec("
                CREATE TABLE IF NOT EXISTS faz_raw_events (
                    ip VARCHAR(45) NOT NULL,
                    timestamp DATETIME NOT NULL,
                    UNIQUE KEY unique_ip_ts (ip, timestamp),
                    INDEX idx_ts (timestamp)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");
            $db->exec("
                CREATE TABLE IF NOT EXISTS faz_logs (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    run_id VARCHAR(50) NOT NULL,
                    ip VARCHAR(45) NOT NULL,
                    count INT NOT NULL,
                    first_seen DATETIME NOT NULL,
                    last_seen DATETIME NOT NULL,
                    imported_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                    INDEX idx_run_id (run_id),
                    INDEX idx_ip (ip)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");
        }
        $checked = true;
    } catch (Exception $e) {
        // Silently ignore — tables may already exist
        $checked = true;
    }
}

/**
 * Helper: Get cutoff datetime string (DB-agnostic).
 * Returns a datetime string for $days ago.
 */
function getCutoffDatetime($db, $days) {
    // Use PHP to calculate cutoff - works for both SQLite and MySQL
    $cutoff = (new DateTime())->modify("-{$days} days")->format('Y-m-d H:i:s');
    return $cutoff;
}

/**
 * Helper: Get current datetime from PHP (DB-agnostic).
 */
function getNowDatetime() {
    return date('Y-m-d H:i:s');
}

function getDashStats($params)
{
    try {
        ensureFazTables();
        $days = isset($params['days']) ? intval($params['days']) : 7;
        $db = getDashDB();
        if (!$db) return ['error' => 'Database not available: ' . (IPCacheDB::getInstance()->getConnectionError() ?: 'DB connection failed')];

        $stats = [];
        $stats['total_cached'] = (int) $db->query("SELECT COUNT(*) FROM ip_database")->fetchColumn();

        // Count blacklisted entries
        try {
            $stats['total_blacklisted'] = (int) $db->query("SELECT COUNT(*) FROM ip_cache WHERE is_blacklisted = 1 AND vt_malicious >= 3")->fetchColumn();
        } catch (Exception $e) {
            $stats['total_blacklisted'] = 0;
        }

        // Dynamic window from faz_raw_events (DB-agnostic)
        $cutoff_dt = getCutoffDatetime($db, $days);
        $now_local = getNowDatetime();

        $stmtMin = $db->query("SELECT MIN(timestamp) as min_ts FROM faz_raw_events");
        $minRow = $stmtMin->fetch(PDO::FETCH_ASSOC);
        $min_ts = $minRow['min_ts'] ?? $now_local;

        $actual_start = $cutoff_dt;
        $stats['is_partial'] = false;
        if ($min_ts && $min_ts > $cutoff_dt) {
            $actual_start = $min_ts;
            $stats['is_partial'] = true;
        }

        $stmtCounts = $db->prepare("SELECT COUNT(*) as cnt, COUNT(DISTINCT ip) as ips FROM faz_raw_events WHERE timestamp >= ?");
        $stmtCounts->execute([$cutoff_dt]);
        $row = $stmtCounts->fetch(PDO::FETCH_ASSOC);

        if ($row && $row['cnt'] > 0) {
            $stats['faz_total_logins'] = (int) $row['cnt'];
            $stats['faz_unique_ips'] = (int) $row['ips'];

            $stmtTarget = $db->prepare("SELECT ip FROM faz_raw_events WHERE timestamp >= ? GROUP BY ip HAVING COUNT(*) >= 50");
            $stmtTarget->execute([$cutoff_dt]);
            $targetIps = $stmtTarget->fetchAll(PDO::FETCH_COLUMN);

            $stats['faz_ip_count'] = count($targetIps);
            $stats['faz_start'] = substr($actual_start, 5, 11);
            $stats['faz_end'] = substr($now_local, 5, 11);

            if (empty($targetIps)) {
                $stats['run_blacklisted'] = 0;
            } else {
                $inClause = rtrim(str_repeat('?,', count($targetIps)), ',');
                $stmtBl = $db->prepare("SELECT COUNT(DISTINCT ip_address) FROM ip_cache WHERE is_blacklisted = 1 AND vt_malicious >= 3 AND ip_address IN ($inClause)");
                $stmtBl->execute($targetIps);
                $stats['run_blacklisted'] = (int) $stmtBl->fetchColumn();
            }
        } else {
            $stats['faz_total_logins'] = 0;
            $stats['faz_unique_ips'] = 0;
            $stats['faz_ip_count'] = 0;
            $stats['faz_start'] = substr($actual_start, 5, 11);
            $stats['faz_end'] = substr($now_local, 5, 11);
            $stats['run_blacklisted'] = 0;
        }

        return $stats;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function getDashBlacklist($params)
{
    try {
        ensureFazTables();
        $days = isset($params['days']) ? intval($params['days']) : 7;
        $db = IPCacheDB::getInstance()->getPDO();

        $cutoff_dt = getCutoffDatetime($db, $days);

        // Get target IPs (>= 50 failed logins) from faz_raw_events
        $stmtTarget = $db->prepare("SELECT ip FROM faz_raw_events WHERE timestamp >= ? GROUP BY ip HAVING COUNT(*) >= 50");
        $stmtTarget->execute([$cutoff_dt]);
        $targetIps = $stmtTarget->fetchAll(PDO::FETCH_COLUMN);

        if (empty($targetIps)) return [];

        $inClause = rtrim(str_repeat('?,', count($targetIps)), ',');
        $stmt = $db->prepare("
            SELECT ip_address, country_code, vt_malicious, vt_suspicious,
                   vt_harmless, vt_undetected, vt_detection_flagged, vt_detection_total,
                   risk_level, threat_info, vt_queried_at
            FROM ip_cache 
            WHERE is_blacklisted = 1 AND vt_malicious >= 3 AND ip_address IN ($inClause)
            ORDER BY vt_malicious DESC
        ");
        $stmt->execute($targetIps);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Map DB column names to what the frontend expects
        $results = [];
        foreach ($rows as $r) {
            $m = (int)($r['vt_malicious'] ?? 0);
            $s = (int)($r['vt_suspicious'] ?? 0);
            $results[] = [
                'ip' => $r['ip_address'],
                'country' => $r['country_code'] ?: 'Unknown',
                'malicious' => $m,
                'suspicious' => $s,
                'verdict' => $m >= 3 ? 'MALICIOUS' : ($s > 0 ? 'SUSPICIOUS' : 'CLEAN'),
                'risk_level' => $r['risk_level'] ?? 'unknown',
                'vt_queried_at' => $r['vt_queried_at'] ?? null,
            ];
        }
        return $results;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function getDashFaz($params)
{
    try {
        ensureFazTables();
        $days = isset($params['days']) ? intval($params['days']) : 7;
        $db = IPCacheDB::getInstance()->getPDO();

        $cutoff_dt = getCutoffDatetime($db, $days);

        $stmt = $db->prepare("
            SELECT ip, COUNT(*) as count, MAX(timestamp) as last_seen 
            FROM faz_raw_events 
            WHERE timestamp >= ? 
            GROUP BY ip HAVING COUNT(*) >= 50
            ORDER BY count DESC
        ");
        $stmt->execute([$cutoff_dt]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function getDashCountry($params)
{
    try {
        ensureFazTables();
        $days = isset($params['days']) ? intval($params['days']) : 7;
        $db = IPCacheDB::getInstance()->getPDO();

        $cutoff_dt = getCutoffDatetime($db, $days);

        $stmt = $db->prepare("SELECT ip, COUNT(*) as fail_count FROM faz_raw_events WHERE timestamp >= ? GROUP BY ip");
        $stmt->execute([$cutoff_dt]);

        $ipFails = [];
        $ipList = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ipFails[$row['ip']] = (int) $row['fail_count'];
            $ipList[] = $row['ip'];
        }

        if (empty($ipList)) return [];

        $chunkedIps = array_chunk($ipList, 1000);
        $countryMap = [];

        foreach ($chunkedIps as $chunk) {
            $inClause = rtrim(str_repeat('?,', count($chunk)), ',');
            // Check ip_database first, then fall back to ip_cache
            $stmtMap = $db->prepare("SELECT ip_address, country_code FROM ip_database WHERE ip_address IN ($inClause)");
            $stmtMap->execute($chunk);
            while ($row = $stmtMap->fetch(PDO::FETCH_ASSOC)) {
                $countryMap[$row['ip_address']] = $row['country_code'] ?: 'Unknown';
            }
            // Fill in from ip_cache for any missing
            $missing = array_diff($chunk, array_keys($countryMap));
            if (!empty($missing)) {
                $inClause2 = rtrim(str_repeat('?,', count($missing)), ',');
                $stmtMap2 = $db->prepare("SELECT ip_address, country_code FROM ip_cache WHERE ip_address IN ($inClause2)");
                $stmtMap2->execute(array_values($missing));
                while ($row = $stmtMap2->fetch(PDO::FETCH_ASSOC)) {
                    $countryMap[$row['ip_address']] = $row['country_code'] ?: 'Unknown';
                }
            }
        }

        $countryFails = [];
        foreach ($ipFails as $ip => $fails) {
            $country = $countryMap[$ip] ?? 'Unknown';
            $countryFails[$country] = ($countryFails[$country] ?? 0) + $fails;
        }

        $results = [];
        foreach ($countryFails as $c => $f) {
            $results[] = ['country' => $c, 'total_fails' => $f];
        }

        return $results;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function getDashCountryTimeline($params)
{
    try {
        ensureFazTables();
        $days = isset($params['days']) ? intval($params['days']) : 7;
        $db = IPCacheDB::getInstance()->getPDO();

        $cutoff_dt = getCutoffDatetime($db, $days);

        // Get IP->country map
        $stmt = $db->prepare("SELECT ip, COUNT(*) as fail_count FROM faz_raw_events WHERE timestamp >= ? GROUP BY ip");
        $stmt->execute([$cutoff_dt]);

        $ipFails = [];
        $ipList = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ipFails[$row['ip']] = (int) $row['fail_count'];
            $ipList[] = $row['ip'];
        }

        if (empty($ipList)) {
            return ['labels' => [], 'datasets' => []];
        }

        $chunkedIps = array_chunk($ipList, 1000);
        $countryMap = [];
        foreach ($chunkedIps as $chunk) {
            $inClause = rtrim(str_repeat('?,', count($chunk)), ',');
            $stmtMap = $db->prepare("SELECT ip_address, country_code FROM ip_database WHERE ip_address IN ($inClause)");
            $stmtMap->execute($chunk);
            while ($row = $stmtMap->fetch(PDO::FETCH_ASSOC)) {
                $countryMap[$row['ip_address']] = $row['country_code'] ?: 'Unknown';
            }
            $missing = array_diff($chunk, array_keys($countryMap));
            if (!empty($missing)) {
                $inClause2 = rtrim(str_repeat('?,', count($missing)), ',');
                $stmtMap2 = $db->prepare("SELECT ip_address, country_code FROM ip_cache WHERE ip_address IN ($inClause2)");
                $stmtMap2->execute(array_values($missing));
                while ($row = $stmtMap2->fetch(PDO::FETCH_ASSOC)) {
                    $countryMap[$row['ip_address']] = $row['country_code'] ?: 'Unknown';
                }
            }
        }

        // Get top 10 countries
        $countryFails = [];
        foreach ($ipFails as $ip => $fails) {
            $country = $countryMap[$ip] ?? 'Unknown';
            $countryFails[$country] = ($countryFails[$country] ?? 0) + $fails;
        }

        arsort($countryFails);
        $topCountries = array_slice(array_keys($countryFails), 0, 10);

        if (empty($topCountries)) {
            return ['labels' => [], 'datasets' => []];
        }

        // Get timeline data - use DB-agnostic date bucketing via PHP
        // For SQLite: strftime works; for MySQL: DATE_FORMAT works
        // Instead, do bucketing in PHP for portability
        $stmt3 = $db->prepare("
            SELECT ip, timestamp, COUNT(*) as count 
            FROM faz_raw_events 
            WHERE timestamp >= ? 
            GROUP BY ip, timestamp
        ");
        $stmt3->execute([$cutoff_dt]);

        $timeline = [];
        $buckets_set = [];
        while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
            $c = $countryMap[$row['ip']] ?? 'Unknown';
            // PHP-side bucketing
            if ($days <= 2) {
                $b = substr($row['timestamp'], 0, 13) . ':00'; // YYYY-MM-DD HH:00
            } else {
                $b = substr($row['timestamp'], 0, 10); // YYYY-MM-DD
            }

            if (in_array($c, $topCountries)) {
                $timeline[$c][$b] = ($timeline[$c][$b] ?? 0) + $row['count'];
                $buckets_set[$b] = true;
            }
        }

        $all_buckets = array_keys($buckets_set);
        sort($all_buckets);

        $datasets = [];
        foreach ($topCountries as $c) {
            $data = [];
            foreach ($all_buckets as $b) {
                $data[] = $timeline[$c][$b] ?? 0;
            }
            $datasets[] = ['label' => $c, 'data' => $data];
        }

        return ['labels' => $all_buckets, 'datasets' => $datasets];
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
