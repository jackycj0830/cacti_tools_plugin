<?php
/**
 * Block_IP Dashboard — API endpoint
 * Serves data from vt_cache.db and FAZ CSV files as JSON
 */

ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$DB_PATH = realpath(__DIR__ . '/../vt_cache.db');
$PROJECT_DIR = realpath(__DIR__ . '/..');

if (!$DB_PATH || !file_exists($DB_PATH)) {
    http_response_code(500);
    echo json_encode(['error' => 'Database not found']);
    exit;
}

$db = new SQLite3($DB_PATH, SQLITE3_OPEN_READONLY);
$action = $_GET['action'] ?? 'stats';

switch ($action) {

    case 'stats':
        $stats = [];
        $r = $db->querySingle("SELECT COUNT(*) FROM vt_ip_cache", false);
        $stats['total_cached'] = $r;
        $stats['total_blacklisted'] = $db->querySingle("SELECT COUNT(*) FROM vt_blacklist WHERE malicious >= 3", false);
        $stats['bl_last_7d'] = $db->querySingle("SELECT COUNT(*) FROM vt_blacklist WHERE malicious >= 3 AND last_seen >= datetime('now', '-7 days')", false);
        $stats['bl_last_30d'] = $db->querySingle("SELECT COUNT(*) FROM vt_blacklist WHERE malicious >= 3 AND last_seen >= datetime('now', '-30 days')", false);
        
        $stats['malicious_gte3'] = $stats['total_blacklisted'];
        $r = $db->querySingle("SELECT COUNT(*) FROM vt_ip_cache WHERE verdict = 'MALICIOUS'", false);
        $stats['malicious_all'] = $r;
        $r = $db->querySingle("SELECT COUNT(*) FROM vt_ip_cache WHERE verdict = 'SUSPICIOUS'", false);
        $stats['suspicious_all'] = $r;
        $r = $db->querySingle("SELECT COUNT(*) FROM vt_ip_cache WHERE verdict = 'CLEAN'", false);
        $stats['clean_all'] = $r;

        $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
        $times = $db->querySingle("SELECT datetime('now', 'localtime', '-$days days') as cutoff, datetime('now', 'localtime') as now_local", true);
        $cutoff_dt = $times['cutoff'];
        $now_local = $times['now_local'];
        
        // Find actual min timestamp in the DB
        $minRow = $db->querySingle("SELECT MIN(timestamp) as min_ts FROM faz_raw_events", true);
        $min_ts = $minRow['min_ts'] ?? $now_local;
        
        $actual_start = $cutoff_dt;
        $stats['is_partial'] = false;
        if ($min_ts > $cutoff_dt) {
            $actual_start = $min_ts;
            $stats['is_partial'] = true;
        }
        
        // 1. Calculate dynamic window based on faz_raw_events
        $row = $db->querySingle("SELECT COUNT(*), COUNT(DISTINCT ip) FROM faz_raw_events WHERE timestamp >= '$cutoff_dt'", true);
        if ($row) {
             $stats['faz_total_logins'] = $row['COUNT(*)'];
             $stats['faz_unique_ips']   = $row['COUNT(DISTINCT ip)'];
             
             // Count targeted IPs (>= 50 attempts) within the window
             $targetRow = $db->querySingle("
                SELECT COUNT(*) FROM (
                    SELECT ip FROM faz_raw_events 
                    WHERE timestamp >= '$cutoff_dt' 
                    GROUP BY ip HAVING COUNT(*) >= 50
                )
             ", false);
             $stats['faz_ip_count'] = $targetRow ?: 0;
             $stats['faz_start'] = substr($actual_start, 5, 11);
             $stats['faz_end']   = substr($now_local, 5, 11);
        } else {
             $stats['faz_total_logins'] = 0;
             $stats['faz_unique_ips']   = 0;
             $stats['faz_ip_count']     = 0;
             $stats['faz_start']        = substr($actual_start, 5, 11);
             $stats['faz_end']          = substr($now_local, 5, 11);
        }

        // 2. Count Active Blacklist (>= 3 malicious) corresponding to targeted IPs
        $blRow = $db->querySingle("
            SELECT COUNT(DISTINCT b.ip) 
            FROM vt_blacklist b 
            JOIN (
                SELECT ip FROM faz_raw_events 
                WHERE timestamp >= '$cutoff_dt' 
                GROUP BY ip HAVING COUNT(*) >= 50
            ) f ON b.ip = f.ip
            WHERE b.malicious >= 3
        ", false);
        $stats['run_blacklisted'] = $blRow ?: 0;
        
        // 3. Fallbacks
        $stats['faz_csv'] = null;
        $stats['faz_date'] = '';
        echo json_encode($stats);
        break;

    case 'blacklist':
        $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
        $cutoff_dt = $db->querySingle("SELECT datetime('now', 'localtime', '-$days days')");
        $minMal = intval($_GET['min_mal'] ?? 3);
        $rows = [];
        
        $stmt = $db->prepare("
            SELECT b.ip, b.verdict, b.malicious, b.suspicious, b.as_owner, b.country, b.network, b.flagged_vendors, b.first_seen, b.last_seen, b.times_seen 
            FROM vt_blacklist b 
            JOIN (
                SELECT ip FROM faz_raw_events 
                WHERE timestamp >= :cutoff 
                GROUP BY ip HAVING COUNT(*) >= 50
            ) f ON b.ip = f.ip 
            WHERE b.malicious >= :min_mal 
            ORDER BY b.malicious DESC, b.suspicious DESC
        ");
        $stmt->bindValue(':cutoff', $cutoff_dt, SQLITE3_TEXT);
        $stmt->bindValue(':min_mal', $minMal, SQLITE3_INTEGER);
        $result = $stmt->execute();
        
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = $row;
        }
        echo json_encode($rows);
        break;

    case 'cache':
        $limit = intval($_GET['limit'] ?? 100);
        $rows = [];
        $result = $db->query("SELECT ip, verdict, malicious, suspicious, as_owner, country, queried_at FROM vt_ip_cache ORDER BY queried_at DESC LIMIT $limit");
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = $row;
        }
        echo json_encode($rows);
        break;

    case 'faz':
        $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
        $cutoff_dt = $db->querySingle("SELECT datetime('now', 'localtime', '-$days days')");
        $rows = [];
        
        $stmt = $db->prepare("
            SELECT ip, COUNT(*) as count, MAX(timestamp) as last_seen 
            FROM faz_raw_events 
            WHERE timestamp >= :cutoff 
            GROUP BY ip HAVING count >= 50
            ORDER BY count DESC
        ");
        $stmt->bindValue(':cutoff', $cutoff_dt, SQLITE3_TEXT);
        $result = $stmt->execute();
        
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = [
                'ip' => $row['ip'], 
                'count' => $row['count'],
                'last_seen' => $row['last_seen']
            ];
        }
        echo json_encode($rows);
        break;

    case 'country_stats':
        $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
        $cutoff_dt = $db->querySingle("SELECT datetime('now', 'localtime', '-$days days')");
        $rows = [];
        
        $stmt = $db->prepare("
            SELECT IFNULL(v.country, 'Unknown') as country, SUM(f.fail_count) as total_fails
            FROM (
                SELECT ip, COUNT(*) as fail_count 
                FROM faz_raw_events 
                WHERE timestamp >= :cutoff 
                GROUP BY ip
            ) f
            LEFT JOIN vt_ip_cache v ON f.ip = v.ip
            GROUP BY IFNULL(v.country, 'Unknown')
            ORDER BY total_fails DESC
        ");
        $stmt->bindValue(':cutoff', $cutoff_dt, SQLITE3_TEXT);
        $result = $stmt->execute();
        
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = [
                'country' => $row['country'],
                'total_fails' => $row['total_fails']
            ];
        }
        echo json_encode($rows);
        break;

    case 'country_timeline':
        $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
        $cutoff_dt = $db->querySingle("SELECT datetime('now', 'localtime', '-$days days')");
        
        // 1. Get Top 10 Countries
        $stmt = $db->prepare("
            SELECT IFNULL(v.country, 'Unknown') as country, COUNT(*) as total
            FROM faz_raw_events f
            LEFT JOIN vt_ip_cache v ON f.ip = v.ip
            WHERE f.timestamp >= :cutoff
            GROUP BY country
            ORDER BY total DESC
            LIMIT 10
        ");
        $stmt->bindValue(':cutoff', $cutoff_dt, SQLITE3_TEXT);
        $res = $stmt->execute();
        $top_countries = [];
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $top_countries[] = $row['country'];
        }

        if (empty($top_countries)) {
            echo json_encode(['labels' => [], 'datasets' => []]);
            break;
        }

        // 2. Get timeline data for these countries
        $in_clause = "'" . implode("','", $top_countries) . "'";
        $bucket_expr = $days <= 2 ? "strftime('%Y-%m-%d %H:00', f.timestamp)" : "date(f.timestamp)";
        
        $stmt2 = $db->prepare("
            SELECT 
                IFNULL(v.country, 'Unknown') as country, 
                $bucket_expr as bucket,
                COUNT(*) as count
            FROM faz_raw_events f
            LEFT JOIN vt_ip_cache v ON f.ip = v.ip
            WHERE f.timestamp >= :cutoff AND IFNULL(v.country, 'Unknown') IN ($in_clause)
            GROUP BY country, bucket
            ORDER BY bucket ASC
        ");
        $stmt2->bindValue(':cutoff', $cutoff_dt, SQLITE3_TEXT);
        $res2 = $stmt2->execute();
        
        $timeline = [];
        $buckets_set = [];
        while ($row = $res2->fetchArray(SQLITE3_ASSOC)) {
            $c = $row['country'];
            $b = $row['bucket'];
            $timeline[$c][$b] = $row['count'];
            $buckets_set[$b] = true;
        }
        
        // Sort buckets chronologically
        $all_buckets = array_keys($buckets_set);
        sort($all_buckets);
        
        // Format for Chart.js
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

$db->close();


