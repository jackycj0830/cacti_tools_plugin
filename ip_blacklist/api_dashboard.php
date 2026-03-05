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

function getTestIPs() {
    return [
        ['ip' => '103.152.220.10', 'country' => 'CN', 'attempts' => 200], // China - high
        ['ip' => '45.148.10.25',   'country' => 'RU', 'attempts' => 150], // Russia - high
        ['ip' => '185.220.101.5',  'country' => 'DE', 'attempts' => 80],  // Germany - medium
        ['ip' => '193.142.146.30', 'country' => 'NL', 'attempts' => 120], // Netherlands - high
        ['ip' => '91.241.19.50',   'country' => 'UA', 'attempts' => 60],  // Ukraine - medium
        ['ip' => '103.75.201.15',  'country' => 'VN', 'attempts' => 90],  // Vietnam - medium
        ['ip' => '156.146.56.20',  'country' => 'US', 'attempts' => 30],  // USA - below threshold
        ['ip' => '41.77.209.100',  'country' => 'NG', 'attempts' => 10],  // Nigeria - below threshold
        ['ip' => '5.188.206.14',   'country' => 'RU', 'attempts' => 180], // Russia - high
        ['ip' => '176.111.174.8',  'country' => 'RU', 'attempts' => 100], // Russia - medium
    ];
}

function loadDashTestData()
{
    try {
        ensureFazTables();
        $db = getDashDB();
        if (!$db) return ['error' => 'Database not available'];

        $testIPs = getTestIPs();
        $totalEvents = 0;
        
        $insertSQL = DB_TYPE === 'sqlite'
            ? "INSERT OR IGNORE INTO faz_raw_events (ip, timestamp) VALUES (?, ?)"
            : "INSERT IGNORE INTO faz_raw_events (ip, timestamp) VALUES (?, ?)";
        $stmt = $db->prepare($insertSQL);
        
        $db->beginTransaction();
        foreach ($testIPs as $ipData) {
            $ip = $ipData['ip'];
            $attempts = $ipData['attempts'];
            for ($i = 0; $i < $attempts; $i++) {
                $randomSec = rand(0, 7 * 24 * 3600);
                $ts = date('Y-m-d H:i:s', time() - $randomSec);
                $stmt->execute([$ip, $ts]);
                $totalEvents++;
            }
        }
        
        // Also ensure archive data is there for country mapping
        $archiveSQL = DB_TYPE === 'sqlite'
            ? "INSERT OR IGNORE INTO ip_database (ip_address, is_blacklisted, status, country_code, country_name, risk_score, risk_level, archived_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
            : "INSERT IGNORE INTO ip_database (ip_address, is_blacklisted, status, country_code, country_name, risk_score, risk_level, archived_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtArchive = $db->prepare($archiveSQL);
        
        $countries = ['CN' => 'China', 'RU' => 'Russia', 'DE' => 'Germany', 'NL' => 'Netherlands', 'UA' => 'Ukraine', 'VN' => 'Vietnam', 'US' => 'United States', 'NG' => 'Nigeria'];
        foreach ($testIPs as $ipData) {
            $isBlacklisted = $ipData['attempts'] >= 50 ? 1 : 0;
            $riskLevel = $ipData['attempts'] >= 100 ? 'high' : ($ipData['attempts'] >= 50 ? 'medium' : 'low');
            $stmtArchive->execute([
                $ipData['ip'], $isBlacklisted, $isBlacklisted ? 'blocked' : 'safe',
                $ipData['country'], $countries[$ipData['country']] ?? 'Unknown',
                min(100, $ipData['attempts']), $riskLevel, date('Y-m-d H:i:s')
            ]);
        }

        // Also mock ip_cache
        $cacheSQL = DB_TYPE === 'sqlite'
            ? "INSERT OR REPLACE INTO ip_cache (ip_address, is_blacklisted, status, risk_level, country_code, vt_malicious, vt_suspicious, created_at, updated_at, expires_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            : "INSERT INTO ip_cache (ip_address, is_blacklisted, status, risk_level, country_code, vt_malicious, vt_suspicious, created_at, updated_at, expires_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE vt_malicious=VALUES(vt_malicious), is_blacklisted=VALUES(is_blacklisted), status=VALUES(status)";
        $stmtCache = $db->prepare($cacheSQL);
        
        $now = date('Y-m-d H:i:s');
        $expires = date('Y-m-d H:i:s', time() + 86400 * 30);
        
        foreach ($testIPs as $ipData) {
            if ($ipData['attempts'] >= 50) {
                // Mock some malicious results (>= 3 for "Blacklist")
                $m = rand(0, 1) ? rand(3, 10) : rand(1, 2);
                $stmtCache->execute([
                    $ipData['ip'], ($m >= 3 ? 1 : 0), ($m >= 3 ? 'blocked' : 'safe'),
                    ($m >= 3 ? 'high' : 'low'), $ipData['country'], $m, rand(1, 5),
                    $now, $now, $expires
                ]);
            }
        }

        $db->commit();
        return ['success' => true, 'total_events' => $totalEvents];
    } catch (Exception $e) {
        if (isset($db) && $db->inTransaction()) $db->rollBack();
        return ['success' => false, 'error' => $e->getMessage()];
    }
}

function clearDashTestData()
{
    try {
        $db = getDashDB();
        if (!$db) return ['error' => 'Database not available'];
        
        $testIPs = getTestIPs();
        $testIpList = array_column($testIPs, 'ip');
        $inClause = rtrim(str_repeat('?,', count($testIpList)), ',');
        
        $db->beginTransaction();
        $db->prepare("DELETE FROM faz_raw_events WHERE ip IN ($inClause)")->execute($testIpList);
        $db->prepare("DELETE FROM faz_logs WHERE ip IN ($inClause)")->execute($testIpList);
        $db->prepare("DELETE FROM ip_cache WHERE ip_address IN ($inClause)")->execute($testIpList);
        $db->prepare("DELETE FROM ip_database WHERE ip_address IN ($inClause)")->execute($testIpList);
        $db->commit();
        
        return ['success' => true];
    } catch (Exception $e) {
        if (isset($db) && $db->inTransaction()) $db->rollBack();
        return ['success' => false, 'error' => $e->getMessage()];
    }
}

// ============================================================================
// NEW DASHBOARD FUNCTIONS (Phase 2 - ported from Block_IP_20260305)
// DB-agnostic: uses PDO, no SQLite3-specific API
// ============================================================================

/**
 * Helper: Build device name filter clause using fgt_mapping.
 * Returns [string $whereClause, array $bindParams] for existing PDO stmt.
 * If devname is null → no filter. If mapped → devname IN (...) clause.
 */
function getDashDeviceFilter($db, $devname) {
    if (!$devname || $devname === 'all' || $devname === '') {
        return ['', []];
    }

    // Look up fgt_mapping for display_name
    try {
        $stmt = $db->prepare("SELECT fgt_name FROM fgt_mapping WHERE display_name = ?");
        $stmt->execute([$devname]);
        $fgtNames = $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (Exception $e) {
        $fgtNames = [];
    }

    if (!empty($fgtNames)) {
        $inClause = rtrim(str_repeat('?,', count($fgtNames)), ',');
        return [" AND devname IN ($inClause)", $fgtNames];
    } else {
        // Fallback: direct match on either faz_name or devname
        return [" AND (faz_name = ? OR devname = ?)", [$devname, $devname]];
    }
}

/**
 * Helper: Build fgt_mapping lookup array [fgt_name => ['display' => ..., 'sort' => ...]]
 */
function getDashAllMappings($db) {
    $mappings = [];
    try {
        $res = $db->query("SELECT fgt_name, display_name, sort_order FROM fgt_mapping");
        while ($rm = $res->fetch(PDO::FETCH_ASSOC)) {
            $mappings[$rm['fgt_name']] = [
                'display' => $rm['display_name'],
                'sort'    => (int) $rm['sort_order']
            ];
        }
    } catch (Exception $e) {}
    return $mappings;
}

/**
 * Helper: Format a comma-separated devname string using fgt_mapping display names.
 */
function dashFormatTargetDevices($devicesStr, $allMappings) {
    if (empty($devicesStr)) return 'Unknown';
    $devs = explode(',', $devicesStr);
    $mapped = [];
    foreach ($devs as $d) {
        $d = trim($d);
        if (isset($allMappings[$d])) {
            $mapped[] = ['name' => $allMappings[$d]['display'], 'sort' => $allMappings[$d]['sort']];
        } else {
            $mapped[] = ['name' => $d, 'sort' => 999999];
        }
    }
    usort($mapped, function($a, $b) {
        return $a['sort'] !== $b['sort'] ? $a['sort'] - $b['sort'] : strcasecmp($a['name'], $b['name']);
    });
    return implode(', ', array_unique(array_column($mapped, 'name')));
}

/**
 * Helper: Format duration from two timestamp strings.
 */
function dashFormatDuration($minTs, $maxTs, $useHtml = false) {
    if (empty($minTs) || empty($maxTs)) return '0m';
    $t1 = strtotime($minTs);
    $t2 = strtotime($maxTs);
    $diff = max(0, $t2 - $t1);
    $d = floor($diff / 86400);
    $h = floor(($diff % 86400) / 3600);
    $m = floor(($diff % 3600) / 60);
    $parts = [];
    if ($d > 0) $parts[] = "{$d}d";
    if ($h > 0 || $d > 0) $parts[] = "{$h}h";
    if (empty($parts)) $parts[] = "{$m}m";
    $timeStr = implode(' ', $parts);
    $d1 = date('m-d', $t1);
    $d2 = date('m-d', $t2);
    $sep = $useHtml ? '<br>' : ' ';
    return "{$timeStr}{$sep}({$d1} ~ {$d2})";
}

// ----------------------------------------------------------------
// getDashDevices — returns list of display names for device filter dropdown
// ----------------------------------------------------------------
function getDashDevices($params) {
    try {
        $db = getDashDB();
        if (!$db) return [];
        $rows = [];
        // Try getting distinct display_name from fgt_mapping
        try {
            $res = $db->query("SELECT DISTINCT display_name FROM fgt_mapping ORDER BY sort_order ASC, display_name ASC");
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                if (!empty($row['display_name'])) $rows[] = $row['display_name'];
            }
        } catch (Exception $e) {}
        // Also grab unmapped devnames from logs
        try {
            $res = $db->query("SELECT DISTINCT devname FROM faz_raw_events WHERE devname NOT IN (SELECT fgt_name FROM fgt_mapping) AND devname != 'Unknown' ORDER BY devname ASC");
            while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                $rows[] = $row['devname'];
            }
        } catch (Exception $e) {}
        return array_values(array_unique($rows));
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

// ----------------------------------------------------------------
// getDashDeviceStats — fail counts per device (for bar chart)
// ----------------------------------------------------------------
function getDashDeviceStats($params) {
    try {
        ensureFazTables();
        $days    = isset($params['days']) ? intval($params['days']) : 7;
        $devname = $params['devname'] ?? '';
        $db = getDashDB();
        if (!$db) return [];

        $cutoff = getCutoffDatetime($db, $days);
        [$devFilter, $devBinds] = getDashDeviceFilter($db, $devname);
        $allMappings = getDashAllMappings($db);

        $sql = "SELECT devname, COUNT(*) as fail_count FROM faz_raw_events WHERE timestamp >= ? $devFilter GROUP BY devname ORDER BY fail_count DESC";
        $stmt = $db->prepare($sql);
        $stmt->execute(array_merge([$cutoff], $devBinds));

        $rows = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dn    = $row['devname'];
            $label = isset($allMappings[$dn]) ? $allMappings[$dn]['display'] : $dn;
            $rows[] = ['devname' => $label, 'fail_count' => (int)$row['fail_count']];
        }
        return $rows;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

// ----------------------------------------------------------------
// getDashDeviceTimeline — device × day pivot table
// ----------------------------------------------------------------
function getDashDeviceTimeline($params) {
    try {
        ensureFazTables();
        $days    = isset($params['days']) ? intval($params['days']) : 7;
        $devname = $params['devname'] ?? '';
        $db = getDashDB();
        if (!$db) return ['days' => [], 'devices' => []];

        $cutoff = getCutoffDatetime($db, $days);
        [$devFilter, $devBinds] = getDashDeviceFilter($db, $devname);
        $allMappings = getDashAllMappings($db);

        // DB-agnostic date extraction via PHP (substring of timestamp)
        $sql = "SELECT devname, timestamp, COUNT(*) as count FROM faz_raw_events WHERE timestamp >= ? $devFilter GROUP BY devname, timestamp ORDER BY timestamp ASC";
        $stmt = $db->prepare($sql);
        $stmt->execute(array_merge([$cutoff], $devBinds));

        $timeline = [];
        $daysSet  = [];
        $totals   = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $dn    = $row['devname'];
            $label = isset($allMappings[$dn]) ? $allMappings[$dn]['display'] : $dn;
            $day   = substr($row['timestamp'], 0, 10); // YYYY-MM-DD
            $c     = (int) $row['count'];
            $timeline[$label][$day] = ($timeline[$label][$day] ?? 0) + $c;
            $daysSet[$day] = true;
            $totals[$label] = ($totals[$label] ?? 0) + $c;
        }

        $allDays = array_keys($daysSet);
        sort($allDays);
        arsort($totals);

        $devicesData = [];
        foreach ($totals as $label => $total) {
            $rowData = [];
            foreach ($allDays as $d) {
                $rowData[$d] = $timeline[$label][$d] ?? 0;
            }
            $devicesData[] = ['name' => $label, 'data' => $rowData, 'total' => $total];
        }

        return ['days' => $allDays, 'devices' => $devicesData];
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

// ----------------------------------------------------------------
// getDashUserTimeline — Top 10 users × device bar chart data
// ----------------------------------------------------------------
function getDashUserTimeline($params) {
    try {
        ensureFazTables();
        $days    = isset($params['days']) ? intval($params['days']) : 7;
        $devname = $params['devname'] ?? '';
        $db = getDashDB();
        if (!$db) return ['labels' => [], 'datasets' => []];

        $cutoff = getCutoffDatetime($db, $days);
        [$devFilter, $devBinds] = getDashDeviceFilter($db, $devname);

        // Check if 'user' column exists in faz_raw_events
        try {
            $check = $db->query("SELECT user FROM faz_raw_events LIMIT 0");
        } catch (Exception $e) {
            return ['labels' => [], 'datasets' => [], 'note' => 'user column not in faz_raw_events'];
        }

        // Top 10 users
        $sql = "SELECT user, COUNT(*) as total FROM faz_raw_events WHERE timestamp >= ? $devFilter AND user IS NOT NULL AND user != '' AND user != 'Unknown' GROUP BY user ORDER BY total DESC LIMIT 10";
        $stmt = $db->prepare($sql);
        $stmt->execute(array_merge([$cutoff], $devBinds));
        $topUsers = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (empty($topUsers)) return ['labels' => [], 'datasets' => []];

        // Breakdown by device
        $inClause = rtrim(str_repeat('?,', count($topUsers)), ',');
        $sql2 = "SELECT user, devname, COUNT(*) as count FROM faz_raw_events WHERE timestamp >= ? $devFilter AND user IN ($inClause) GROUP BY user, devname";
        $stmt2 = $db->prepare($sql2);
        $stmt2->execute(array_merge([$cutoff], $devBinds, $topUsers));

        $breakdown  = [];
        $devicesSet = [];
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $breakdown[$row['user']][$row['devname']] = (int)$row['count'];
            $devicesSet[$row['devname']] = true;
        }

        $allDevices = array_keys($devicesSet);
        sort($allDevices);

        $datasets = [];
        foreach ($allDevices as $d) {
            $data = [];
            foreach ($topUsers as $u) {
                $data[] = $breakdown[$u][$d] ?? 0;
            }
            $datasets[] = ['label' => $d, 'data' => $data];
        }

        return ['labels' => $topUsers, 'datasets' => $datasets];
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

// ----------------------------------------------------------------
// getDashAdStatus — Top 5 AD Users under attack (joined with ad_users_cache)
// ----------------------------------------------------------------
function getDashAdStatus($params) {
    try {
        ensureFazTables();
        $days    = isset($params['days']) ? intval($params['days']) : 7;
        $devname = $params['devname'] ?? '';
        $db = getDashDB();
        if (!$db) return [];

        $cutoff = getCutoffDatetime($db, $days);
        [$devFilter, $devBinds] = getDashDeviceFilter($db, $devname);
        $allMappings = getDashAllMappings($db);

        // Check if ad_users_cache table exists
        try {
            $db->query("SELECT 1 FROM ad_users_cache LIMIT 0");
        } catch (Exception $e) {
            return ['error' => 'ad_users_cache table not found - run AD sync first'];
        }

        $sql = "
            SELECT f.user, COUNT(*) as fail_count, MIN(f.timestamp) as min_ts, MAX(f.timestamp) as last_seen,
                   GROUP_CONCAT(DISTINCT f.devname) as target_devices,
                   a.locked_out, a.lockout_time, a.password_expired, a.pwd_last_set, a.last_logon as ad_last_logon,
                   a.department, a.ad_site, a.office_phone
            FROM faz_raw_events f
            JOIN ad_users_cache a ON LOWER(f.user) = LOWER(a.username)
            WHERE f.timestamp >= ? $devFilter
                AND f.user IS NOT NULL AND f.user != '' AND f.user != 'Unknown'
                AND a.exists_in_ad = 1
            GROUP BY f.user
            ORDER BY fail_count DESC
            LIMIT 5
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute(array_merge([$cutoff], $devBinds));

        $adUsers = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $parts = [];
            if (!empty($row['ad_site']) && $row['ad_site'] !== 'N/A') $parts[] = $row['ad_site'];
            if (!empty($row['department']) && $row['department'] !== 'N/A') $parts[] = $row['department'];
            if (!empty($row['office_phone']) && $row['office_phone'] !== 'N/A') $parts[] = $row['office_phone'];

            $adUsers[] = [
                'Username'          => $row['user'],
                'fail_count'        => (int) $row['fail_count'],
                'target_devices'    => dashFormatTargetDevices($row['target_devices'], $allMappings),
                'duration'          => dashFormatDuration($row['min_ts'], $row['last_seen'], true),
                'ExistsInAD'        => 'Yes',
                'OU_Dept'           => empty($parts) ? 'N/A' : implode(' / ', $parts),
                'LockedOut'         => ($row['locked_out'] == 1) ? 'True' : 'False',
                'PasswordExpired'   => ($row['password_expired'] == 1) ? 'True' : 'False',
                'LastPasswordChange' => $row['pwd_last_set'] ?: 'N/A',
                'LastLogon'         => $row['ad_last_logon'] ?: 'N/A',
            ];
        }
        return $adUsers;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

// ----------------------------------------------------------------
// getDashNonAdStatus — Top 10 Non-AD Users under attack
// ----------------------------------------------------------------
function getDashNonAdStatus($params) {
    try {
        ensureFazTables();
        $days    = isset($params['days']) ? intval($params['days']) : 7;
        $devname = $params['devname'] ?? '';
        $db = getDashDB();
        if (!$db) return [];

        $cutoff = getCutoffDatetime($db, $days);
        [$devFilter, $devBinds] = getDashDeviceFilter($db, $devname);
        $allMappings = getDashAllMappings($db);

        // Check if ad_users_cache table exists
        $hasAdCache = true;
        try {
            $db->query("SELECT 1 FROM ad_users_cache LIMIT 0");
        } catch (Exception $e) {
            $hasAdCache = false;
        }

        if ($hasAdCache) {
            $sql = "
                SELECT t.user, t.fail_count, t.min_ts, t.last_seen, t.target_devices
                FROM (
                    SELECT user, COUNT(*) as fail_count, MIN(timestamp) as min_ts, MAX(timestamp) as last_seen,
                           GROUP_CONCAT(DISTINCT devname) as target_devices
                    FROM faz_raw_events
                    WHERE timestamp >= ? $devFilter
                        AND user IS NOT NULL AND user != '' AND user != 'Unknown'
                    GROUP BY user
                    ORDER BY fail_count DESC
                    LIMIT 50
                ) t
                LEFT JOIN ad_users_cache a ON LOWER(t.user) = LOWER(a.username)
                WHERE (a.username IS NULL OR a.exists_in_ad = 0)
                ORDER BY t.fail_count DESC
                LIMIT 10
            ";
        } else {
            // No AD cache — just return top users
            $sql = "
                SELECT user, COUNT(*) as fail_count, MIN(timestamp) as min_ts, MAX(timestamp) as last_seen,
                       GROUP_CONCAT(DISTINCT devname) as target_devices
                FROM faz_raw_events
                WHERE timestamp >= ? $devFilter
                    AND user IS NOT NULL AND user != '' AND user != 'Unknown'
                GROUP BY user
                ORDER BY fail_count DESC
                LIMIT 10
            ";
        }

        $stmt = $db->prepare($sql);
        $stmt->execute(array_merge([$cutoff], $devBinds));

        $nonAdUsers = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $nonAdUsers[] = [
                'Username'       => $row['user'],
                'fail_count'     => (int) $row['fail_count'],
                'target_devices' => dashFormatTargetDevices($row['target_devices'], $allMappings),
                'duration'       => dashFormatDuration($row['min_ts'], $row['last_seen'], true),
            ];
        }
        return $nonAdUsers;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

// ----------------------------------------------------------------
// saveDashCsv — saves CSV content to a temp file, returns a one-time ID
// ----------------------------------------------------------------
function saveDashCsv($params) {
    $csv      = $_POST['csv_content'] ?? '';
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $_POST['filename'] ?? 'export.csv');
    if (empty($csv)) {
        return ['error' => 'No CSV content received.'];
    }
    $tmpDir = sys_get_temp_dir();
    $id     = bin2hex(random_bytes(8));
    $path   = $tmpDir . DIRECTORY_SEPARATOR . 'ibl_csv_' . $id . '.csv';
    if (file_put_contents($path, $csv) === false) {
        return ['error' => 'Failed to write temp file.'];
    }
    // Store filename mapping in a small JSON sidecar
    file_put_contents($path . '.meta', json_encode(['filename' => $filename, 'ts' => time()]));
    return ['id' => $id];
}

// ----------------------------------------------------------------
// downloadDashCsv — streams a saved temp CSV file for download
// ----------------------------------------------------------------
function downloadDashCsv($params) {
    $id   = preg_replace('/[^a-f0-9]/', '', $params['id'] ?? '');
    if (empty($id)) {
        http_response_code(400);
        echo 'Missing id';
        exit;
    }
    $path     = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'ibl_csv_' . $id . '.csv';
    $metaPath = $path . '.meta';
    if (!file_exists($path)) {
        http_response_code(404);
        echo 'File not found or expired.';
        exit;
    }
    $filename = 'export.csv';
    if (file_exists($metaPath)) {
        $meta     = json_decode(file_get_contents($metaPath), true);
        $filename = $meta['filename'] ?? 'export.csv';
    }
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . filesize($path));
    readfile($path);
    @unlink($path);
    @unlink($metaPath);
    exit;
}
