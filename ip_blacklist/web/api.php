<?php
/**
 * Block_IP Dashboard — API endpoint
 * Serves data from MySQL `ip_blacklist` database as JSON.
 * Replaces the old SQLite-based version.
 */

ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

// Load the database connection from the parent directory's config
require_once __DIR__ . '/../database/IPCacheDB.php';

$dbInstance = IPCacheDB::getInstance();
if (!$dbInstance->isConnected()) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . ($dbInstance->getConnectionError() ?: 'MySQL server not available. Check that MySQL is running and db_config.php settings are correct.')]);
    exit;
}
$db = $dbInstance->getPDO();

$action = $_GET['action'] ?? 'stats';

switch ($action) {

    case 'stats':
        $stats = [];
        $days = isset($_GET['days']) ? intval($_GET['days']) : 7;

        // Cache / Blacklist counts from ip_cache table
        $stmt = $db->query("SELECT COUNT(*) FROM ip_cache");
        $stats['total_cached'] = (int) $stmt->fetchColumn();

        $stmt = $db->query("SELECT COUNT(*) FROM ip_cache WHERE is_blacklisted = 1 AND vt_malicious >= 3");
        $stats['total_blacklisted'] = (int) $stmt->fetchColumn();

        // VT verdict counts
        $stmt = $db->query("SELECT COUNT(*) FROM ip_cache WHERE risk_level = 'high'");
        $stats['malicious_gte3'] = (int) $stmt->fetchColumn();
        $stats['malicious_all'] = $stats['malicious_gte3'];

        $stmt = $db->query("SELECT COUNT(*) FROM ip_cache WHERE risk_level = 'medium'");
        $stats['suspicious_all'] = (int) $stmt->fetchColumn();

        $stmt = $db->query("SELECT COUNT(*) FROM ip_cache WHERE risk_level = 'low'");
        $stats['clean_all'] = (int) $stmt->fetchColumn();

        // Dynamic window from faz_raw_events
        $stmtCutoff = $db->query("SELECT DATE_SUB(NOW(), INTERVAL $days DAY) as cutoff, NOW() as now_local");
        $times = $stmtCutoff->fetch(PDO::FETCH_ASSOC);
        $cutoff_dt = $times['cutoff'];
        $now_local = $times['now_local'];

        $stmtMin = $db->query("SELECT MIN(timestamp) as min_ts FROM faz_raw_events");
        $minRow = $stmtMin->fetch(PDO::FETCH_ASSOC);
        $min_ts = $minRow['min_ts'] ?? $now_local;

        $actual_start = $cutoff_dt;
        $stats['is_partial'] = false;
        if ($min_ts && $min_ts > $cutoff_dt) {
            $actual_start = $min_ts;
            $stats['is_partial'] = true;
        }

        // FAZ event counts
        $stmt = $db->prepare("SELECT COUNT(*) as cnt, COUNT(DISTINCT ip) as ips FROM faz_raw_events WHERE timestamp >= ?");
        $stmt->execute([$cutoff_dt]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && $row['cnt'] > 0) {
            $stats['faz_total_logins'] = (int) $row['cnt'];
            $stats['faz_unique_ips'] = (int) $row['ips'];

            // Targeted IPs (>= 50 attempts)
            $stmtTarget = $db->prepare("SELECT COUNT(*) FROM (SELECT ip FROM faz_raw_events WHERE timestamp >= ? GROUP BY ip HAVING COUNT(*) >= 50) sub");
            $stmtTarget->execute([$cutoff_dt]);
            $stats['faz_ip_count'] = (int) $stmtTarget->fetchColumn();

            $stats['faz_start'] = substr($actual_start, 5, 11);
            $stats['faz_end'] = substr($now_local, 5, 11);

            // Active Blacklist for targeted IPs
            $stmtTargetIps = $db->prepare("SELECT ip FROM faz_raw_events WHERE timestamp >= ? GROUP BY ip HAVING COUNT(*) >= 50");
            $stmtTargetIps->execute([$cutoff_dt]);
            $targetIps = $stmtTargetIps->fetchAll(PDO::FETCH_COLUMN);

            if (!empty($targetIps)) {
                $inClause = rtrim(str_repeat('?,', count($targetIps)), ',');
                $stmtBl = $db->prepare("SELECT COUNT(DISTINCT ip_address) FROM ip_cache WHERE is_blacklisted = 1 AND vt_malicious >= 3 AND ip_address IN ($inClause)");
                $stmtBl->execute($targetIps);
                $stats['run_blacklisted'] = (int) $stmtBl->fetchColumn();
            } else {
                $stats['run_blacklisted'] = 0;
            }
        } else {
            $stats['faz_total_logins'] = 0;
            $stats['faz_unique_ips'] = 0;
            $stats['faz_ip_count'] = 0;
            $stats['faz_start'] = substr($actual_start, 5, 11);
            $stats['faz_end'] = substr($now_local, 5, 11);
            $stats['run_blacklisted'] = 0;
        }

        $stats['bl_last_7d'] = $stats['total_blacklisted'];
        $stats['bl_last_30d'] = $stats['total_blacklisted'];
        $stats['faz_csv'] = null;
        $stats['faz_date'] = '';
        echo json_encode($stats);
        break;

    case 'blacklist':
        $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
        $minMal = intval($_GET['min_mal'] ?? 3);

        $stmtCutoff = $db->query("SELECT DATE_SUB(NOW(), INTERVAL $days DAY) as cutoff");
        $cutoff_dt = $stmtCutoff->fetchColumn();

        // Get target IPs
        $stmtTarget = $db->prepare("SELECT ip FROM faz_raw_events WHERE timestamp >= ? GROUP BY ip HAVING COUNT(*) >= 50");
        $stmtTarget->execute([$cutoff_dt]);
        $targetIps = $stmtTarget->fetchAll(PDO::FETCH_COLUMN);

        if (empty($targetIps)) {
            echo json_encode([]);
            break;
        }

        $inClause = rtrim(str_repeat('?,', count($targetIps)), ',');
        $stmt = $db->prepare("
            SELECT ip_address as ip, 
                   IF(risk_level='high', 'MALICIOUS', IF(is_blacklisted=1, 'SUSPICIOUS', 'CLEAN')) as verdict,
                   COALESCE(vt_malicious, 0) as malicious, 
                   COALESCE(vt_suspicious, 0) as suspicious, 
                   COALESCE(org, isp, '') as as_owner, 
                   COALESCE(country_code, '') as country, 
                   '' as network, 
                   COALESCE(threat_info, '') as flagged_vendors_raw, 
                   created_at as first_seen, 
                   updated_at as last_seen, 
                   hit_count as times_seen
            FROM ip_cache 
            WHERE is_blacklisted = 1 AND vt_malicious >= ? AND ip_address IN ($inClause)
            ORDER BY vt_malicious DESC, vt_suspicious DESC
        ");
        $sqlParams = array_merge([$minMal], $targetIps);
        $stmt->execute($sqlParams);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Parse flagged_vendors from threat_info JSON
        foreach ($rows as &$r) {
            $ti = json_decode($r['flagged_vendors_raw'], true);
            $fv = [];
            if ($ti && isset($ti['flagged_vendors'])) {
                foreach ($ti['flagged_vendors'] as $vendor) {
                    $fv[] = ($vendor['vendor'] ?? '') . '(' . ($vendor['category'] ?? '') . ')';
                }
            }
            $r['flagged_vendors'] = implode('; ', $fv);
            unset($r['flagged_vendors_raw']);
        }

        echo json_encode($rows);
        break;

    case 'cache':
        $limit = intval($_GET['limit'] ?? 100);
        $stmt = $db->prepare("SELECT ip_address as ip, risk_level as verdict, COALESCE(vt_malicious,0) as malicious, COALESCE(vt_suspicious,0) as suspicious, COALESCE(org,isp,'') as as_owner, COALESCE(country_code,'') as country, vt_queried_at as queried_at FROM ip_cache ORDER BY updated_at DESC LIMIT ?");
        $stmt->execute([$limit]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'faz':
        $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
        $stmtCutoff = $db->query("SELECT DATE_SUB(NOW(), INTERVAL $days DAY) as cutoff");
        $cutoff_dt = $stmtCutoff->fetchColumn();

        $stmt = $db->prepare("
            SELECT ip, COUNT(*) as count, MAX(timestamp) as last_seen 
            FROM faz_raw_events 
            WHERE timestamp >= ? 
            GROUP BY ip HAVING count >= 50
            ORDER BY count DESC
        ");
        $stmt->execute([$cutoff_dt]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'country_stats':
        $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
        $stmtCutoff = $db->query("SELECT DATE_SUB(NOW(), INTERVAL $days DAY) as cutoff");
        $cutoff_dt = $stmtCutoff->fetchColumn();

        // Join faz_raw_events with ip_cache/ip_database for country mapping
        $stmt = $db->prepare("
            SELECT COALESCE(d.country_code, c.country_code, 'Unknown') as country, COUNT(*) as total_fails
            FROM faz_raw_events f
            LEFT JOIN ip_database d ON f.ip = d.ip_address
            LEFT JOIN ip_cache c ON f.ip = c.ip_address
            WHERE f.timestamp >= ?
            GROUP BY country
            ORDER BY total_fails DESC
        ");
        $stmt->execute([$cutoff_dt]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        break;

    case 'country_timeline':
        $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
        $stmtCutoff = $db->query("SELECT DATE_SUB(NOW(), INTERVAL $days DAY) as cutoff");
        $cutoff_dt = $stmtCutoff->fetchColumn();

        // 1. Get Top 10 Countries
        $stmt = $db->prepare("
            SELECT COALESCE(d.country_code, c.country_code, 'Unknown') as country, COUNT(*) as total
            FROM faz_raw_events f
            LEFT JOIN ip_database d ON f.ip = d.ip_address
            LEFT JOIN ip_cache c ON f.ip = c.ip_address
            WHERE f.timestamp >= ?
            GROUP BY country
            ORDER BY total DESC
            LIMIT 10
        ");
        $stmt->execute([$cutoff_dt]);
        $top_countries = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (empty($top_countries)) {
            echo json_encode(['labels' => [], 'datasets' => []]);
            break;
        }

        // Build country map for all IPs
        $stmtMap = $db->prepare("
            SELECT DISTINCT f.ip, COALESCE(d.country_code, c.country_code, 'Unknown') as country
            FROM faz_raw_events f
            LEFT JOIN ip_database d ON f.ip = d.ip_address
            LEFT JOIN ip_cache c ON f.ip = c.ip_address
            WHERE f.timestamp >= ?
        ");
        $stmtMap->execute([$cutoff_dt]);
        $countryMap = [];
        while ($row = $stmtMap->fetch(PDO::FETCH_ASSOC)) {
            $countryMap[$row['ip']] = $row['country'];
        }

        // 2. Get timeline data
        $bucket_expr = $days <= 2 ? "DATE_FORMAT(f.timestamp, '%Y-%m-%d %H:00')" : "DATE(f.timestamp)";

        $stmt2 = $db->prepare("
            SELECT f.ip, $bucket_expr as bucket, COUNT(*) as count
            FROM faz_raw_events f
            WHERE f.timestamp >= ?
            GROUP BY f.ip, bucket
            ORDER BY bucket ASC
        ");
        $stmt2->execute([$cutoff_dt]);

        $timeline = [];
        $buckets_set = [];
        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $c = $countryMap[$row['ip']] ?? 'Unknown';
            $b = $row['bucket'];

            if (in_array($c, $top_countries)) {
                if (!isset($timeline[$c][$b])) {
                    $timeline[$c][$b] = 0;
                }
                $timeline[$c][$b] += $row['count'];
                $buckets_set[$b] = true;
            }
        }

        $all_buckets = array_keys($buckets_set);
        sort($all_buckets);

        $datasets = [];
        foreach ($top_countries as $c) {
            $data = [];
            foreach ($all_buckets as $b) {
                $data[] = isset($timeline[$c][$b]) ? $timeline[$c][$b] : 0;
            }
            $datasets[] = [
                'label' => $c,
                'data' => $data
            ];
        }

        echo json_encode([
            'labels' => $all_buckets,
            'datasets' => $datasets
        ]);
        break;

    default:
        echo json_encode(['error' => 'Unknown action']);
}
