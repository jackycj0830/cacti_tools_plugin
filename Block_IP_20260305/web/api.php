<?php
/**
 * Block_IP Dashboard — API endpoint
 * Serves data from vt_cache.db exclusively
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
$faz_name = isset($_GET['devname']) && $_GET['devname'] !== 'all' && $_GET['devname'] !== '' ? $_GET['devname'] : null;

// Global Device Mapping Resolution
$fgt_names_filter = null;
if ($faz_name) {
    $stmtM = $db->prepare("SELECT fgt_name FROM fgt_mapping WHERE display_name = :name");
    $stmtM->bindValue(':name', $faz_name, SQLITE3_TEXT);
    $resM = $stmtM->execute();
    $names = [];
    while ($rm = $resM->fetchArray(SQLITE3_ASSOC)) {
        $names[] = "'" . SQLite3::escapeString($rm['fgt_name']) . "'";
    }
    if (!empty($names)) {
        $fgt_names_filter = "devname IN (" . implode(',', $names) . ")";
    } else {
        // Fallback to direct match (either faz_name or devname)
        $escaped = SQLite3::escapeString($faz_name);
        $fgt_names_filter = "(faz_name = '$escaped' OR devname = '$escaped')";
    }
}

// Fetch all mappings once to map back and sort
$allMappings = [];
$resM2 = $db->query("SELECT fgt_name, display_name, sort_order FROM fgt_mapping");
while($rm = $resM2->fetchArray(SQLITE3_ASSOC)) {
    $allMappings[$rm['fgt_name']] = [
        'display' => $rm['display_name'],
        'sort' => intval($rm['sort_order'])
    ];
}

// Helper to map and sort target devices
$formatTargetDevices = function($devicesStr) use ($allMappings) {
    if (empty($devicesStr)) return 'Unknown';
    $devs = explode(',', $devicesStr);
    $mapped = [];
    foreach ($devs as $d) {
        $d = trim($d);
        if (isset($allMappings[$d])) {
            $mapped[] = [
                'name' => $allMappings[$d]['display'],
                'sort' => $allMappings[$d]['sort']
            ];
        } else {
            $mapped[] = [
                'name' => $d,
                'sort' => 999999 // Unmapped at the end
            ];
        }
    }
    // Sort by sort_order, then by name
    usort($mapped, function($a, $b) {
        $sortA = (int)$a['sort'];
        $sortB = (int)$b['sort'];
        if ($sortA !== $sortB) return $sortA - $sortB;
        return strcasecmp($a['name'], $b['name']);
    });
    
    $names = array_map(function($x) { return $x['name']; }, $mapped);
    // Remove duplicates (e.g. if multiple fgt_names map to same display_name)
    return implode(', ', array_unique($names));
};

switch ($action) {

    case 'devices':
        $rows = [];
        // Get mapped display names
        $res = $db->query("SELECT DISTINCT display_name FROM fgt_mapping ORDER BY display_name ASC");
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = $row['display_name'];
        }
        // Also get unique devnames from logs that aren't mapped yet
        $res = $db->query("SELECT DISTINCT devname FROM faz_raw_events WHERE devname NOT IN (SELECT fgt_name FROM fgt_mapping) AND devname != 'Unknown' ORDER BY devname ASC");
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = $row['devname'];
        }
        echo json_encode(array_values(array_unique($rows)));
        break;

    case 'device_stats':
        $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
        $cutoff_dt = $db->querySingle("SELECT datetime('now', 'localtime', '-$days days')");
        $rows = [];
        
        $devFilter = $fgt_names_filter ? " AND $fgt_names_filter" : "";

        $stmt = $db->prepare("
            SELECT devname, COUNT(*) as fail_count 
            FROM faz_raw_events 
            WHERE timestamp >= :cutoff $devFilter
            GROUP BY devname
            ORDER BY fail_count DESC
        ");
        $stmt->bindValue(':cutoff', $cutoff_dt, SQLITE3_TEXT);
        $result = $stmt->execute();
        
        // Get all mappings once to map back
        $mappingsArr = [];
        $resM2 = $db->query("SELECT fgt_name, display_name FROM fgt_mapping");
        while($rm = $resM2->fetchArray(SQLITE3_ASSOC)) {
            $mappingsArr[$rm['fgt_name']] = $rm['display_name'];
        }

        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $dn = $row['devname'];
            $label = isset($mappingsArr[$dn]) ? $mappingsArr[$dn] : $dn;
            $rows[] = [
                'devname' => $label,
                'fail_count' => $row['fail_count']
            ];
        }
        echo json_encode($rows);
        break;

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
        $minEvents = isset($_GET['min_events']) ? intval($_GET['min_events']) : 50;
        $minMal = isset($_GET['min_mal']) ? intval($_GET['min_mal']) : 3;
        
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
        $query1 = "SELECT COUNT(*), COUNT(DISTINCT ip) as unique_ips, MAX(timestamp) as max_ts FROM faz_raw_events WHERE timestamp >= '$cutoff_dt'";
        if ($faz_name) {
            // Check mapping
            $stmtM = $db->prepare("SELECT fgt_name FROM fgt_mapping WHERE display_name = :name");
            $stmtM->bindValue(':name', $faz_name, SQLITE3_TEXT);
            $resM = $stmtM->execute();
            $fgtNames = [];
            while($rm = $resM->fetchArray(SQLITE3_ASSOC)) $fgtNames[] = "'" . SQLite3::escapeString($rm['fgt_name']) . "'";
            
            if (!empty($fgtNames)) {
                $query1 .= " AND devname IN (" . implode(',', $fgtNames) . ")";
            } else {
                $query1 .= " AND (faz_name = '" . SQLite3::escapeString($faz_name) . "' OR devname = '" . SQLite3::escapeString($faz_name) . "')";
            }
        }
        
        $row = $db->querySingle($query1, true);
        if ($row && $row['COUNT(*)'] > 0) {
             $stats['faz_total_logins'] = $row['COUNT(*)'];
             $stats['faz_unique_ips']   = $row['unique_ips'];
             $actual_end = !empty($row['max_ts']) ? $row['max_ts'] : $now_local;
             
             // Count targeted IPs (>= threshold attempts) within the window
             $query2 = "SELECT COUNT(*) FROM (SELECT ip FROM faz_raw_events WHERE timestamp >= '$cutoff_dt'";
             if ($faz_name) {
                 $query2 .= " AND faz_name = '" . SQLite3::escapeString($faz_name) . "'";
             }
             $query2 .= " GROUP BY ip HAVING COUNT(*) >= $minEvents)";
             
             $targetRow = $db->querySingle($query2, false);
             $stats['faz_ip_count'] = $targetRow ?: 0;
             $stats['faz_start'] = substr($actual_start, 5, 11);
             $stats['faz_end']   = substr($actual_end, 5, 11);
        } else {
             $stats['faz_total_logins'] = 0;
             $stats['faz_unique_ips']   = 0;
             $stats['faz_ip_count']     = 0;
             $stats['faz_start']        = substr($actual_start, 5, 11);
             $stats['faz_end']          = substr($now_local, 5, 11);
        }

        // 2. Count Active Blacklist (>= threshold malicious) corresponding to targeted IPs
        $query3 = "
            SELECT COUNT(DISTINCT b.ip) 
            FROM vt_blacklist b 
            JOIN (
                SELECT ip FROM faz_raw_events 
                WHERE timestamp >= '$cutoff_dt'";
        if ($faz_name) {
            $query3 .= " AND faz_name = '" . SQLite3::escapeString($faz_name) . "'";
        }
        $query3 .= " GROUP BY ip HAVING COUNT(*) >= $minEvents) f ON b.ip = f.ip
            WHERE b.malicious >= $minMal";
        $blRow = $db->querySingle($query3, false);
        $stats['run_blacklisted'] = $blRow ?: 0;
        
        // 3. Fallbacks
        $stats['faz_date'] = '';
        echo json_encode($stats);
        break;

    case 'blacklist':
        $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
        $cutoff_dt = $db->querySingle("SELECT datetime('now', 'localtime', '-$days days')");
        $minEvents = intval($_GET['min_events'] ?? 50);
        $minMal = intval($_GET['min_mal'] ?? 3);
        $rows = [];
        
        $devFilter = $fgt_names_filter ? " AND $fgt_names_filter" : "";
        $stmt = $db->prepare("
            SELECT 
                b.ip, b.verdict, b.malicious, b.suspicious, b.as_owner, b.country, b.network, b.flagged_vendors, b.first_seen, b.last_seen, b.times_seen,
                f.fail_count, f.min_ts, f.max_ts, f.target_devices, f.targeted_users
            FROM vt_blacklist b 
            JOIN (
                SELECT 
                    ip, 
                    COUNT(*) as fail_count,
                    MIN(timestamp) as min_ts,
                    MAX(timestamp) as max_ts,
                    GROUP_CONCAT(DISTINCT devname) as target_devices,
                    GROUP_CONCAT(DISTINCT NULLIF(user, 'Unknown')) as targeted_users
                FROM faz_raw_events 
                WHERE timestamp >= :cutoff $devFilter
                GROUP BY ip HAVING COUNT(*) >= :min_events
            ) f ON b.ip = f.ip 
            WHERE b.malicious >= :min_mal 
            ORDER BY f.fail_count DESC, b.malicious DESC
        ");
        $stmt->bindValue(':cutoff', $cutoff_dt, SQLITE3_TEXT);
        if ($faz_name) $stmt->bindValue(':faz_name', $faz_name, SQLITE3_TEXT);
        $stmt->bindValue(':min_events', $minEvents, SQLITE3_INTEGER);
        $stmt->bindValue(':min_mal', $minMal, SQLITE3_INTEGER);
        $result = $stmt->execute();
        
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            // Calculate Duration
            $duration = "0m";
            if (!empty($row['min_ts']) && !empty($row['max_ts'])) {
                $t1 = strtotime($row['min_ts']);
                $t2 = strtotime($row['max_ts']);
                $diff = max(0, $t2 - $t1);
                
                $d = floor($diff / 86400);
                $h = floor(($diff % 86400) / 3600);
                $m = floor(($diff % 3600) / 60);
                
                $parts = [];
                if ($d > 0) $parts[] = "{$d}d";
                if ($h > 0 || $d > 0) $parts[] = "{$h}h";
                if (empty($parts)) $parts[] = "{$m}m";
                $time_str = implode(" ", $parts);
                $d1 = date("m-d", $t1);
                $d2 = date("m-d", $t2);
                $duration = "{$time_str} ({$d1} ~ {$d2})";
            }
            $row['duration'] = $duration;
            $row['target_devices'] = $formatTargetDevices($row['target_devices']);
            $rows[] = $row;
        }

        // --- AD Account Filtering Logic ---
        $all_users = [];
        foreach ($rows as $r) {
            if (!empty($r['targeted_users'])) {
                $parts = explode(',', $r['targeted_users']);
                foreach ($parts as $p) {
                    $u = str_replace("\0", "", trim($p));
                    if ($u !== '' && $u !== 'Unknown') {
                        $all_users[$u] = true;
                    }
                }
            }
        }
        
        $valid_ad_users = [];
        if (!empty($all_users)) {
            $user_list = array_keys($all_users);
            
            $placeholders = [];
            foreach ($user_list as $u) {
                $placeholders[] = "'" . SQLite3::escapeString(strtolower($u)) . "'";
            }
            $in_clause = implode(',', $placeholders);
            
            $sql = "SELECT username FROM ad_users_cache WHERE username IN ($in_clause)";
            if ($res = $db->query($sql)) {
                while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
                    $valid_ad_users[$row['username']] = true;
                }
            }
        }

        foreach ($rows as &$r) {
            if (!empty($r['targeted_users'])) {
                $filtered = [];
                $parts = explode(',', $r['targeted_users']);
                foreach ($parts as $p) {
                    $u = str_replace("\0", "", trim($p));
                    if (isset($valid_ad_users[strtolower($u)])) {
                        $filtered[] = $u;
                    }
                }
                sort($filtered, SORT_STRING | SORT_FLAG_CASE);
                $r['targeted_users'] = empty($filtered) ? '0' : implode(',', $filtered);
            } else {
                $r['targeted_users'] = '0';
            }
        }
        unset($r); // unset reference
        // --- End AD Filtering ---

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
        $minEvents = intval($_GET['min_events'] ?? 50);
        $rows = [];
        
        $devFilter = $fgt_names_filter ? " AND $fgt_names_filter" : "";
        $stmt = $db->prepare("
            SELECT ip, COUNT(*) as count, MIN(timestamp) as min_ts, MAX(timestamp) as last_seen, GROUP_CONCAT(DISTINCT devname) as target_devices
            FROM faz_raw_events 
            WHERE timestamp >= :cutoff $devFilter
            GROUP BY ip HAVING count >= :min_events
            ORDER BY count DESC
        ");
        $stmt->bindValue(':cutoff', $cutoff_dt, SQLITE3_TEXT);
        if ($faz_name) $stmt->bindValue(':faz_name', $faz_name, SQLITE3_TEXT);
        $stmt->bindValue(':min_events', $minEvents, SQLITE3_INTEGER);
        $result = $stmt->execute();
        
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $duration = "0m";
            if (!empty($row['min_ts']) && !empty($row['last_seen'])) {
                $t1 = strtotime($row['min_ts']);
                $t2 = strtotime($row['last_seen']);
                $diff = max(0, $t2 - $t1);
                
                $d = floor($diff / 86400);
                $h = floor(($diff % 86400) / 3600);
                $m = floor(($diff % 3600) / 60);
                
                $parts = [];
                if ($d > 0) $parts[] = "{$d}d";
                if ($h > 0 || $d > 0) $parts[] = "{$h}h";
                if (empty($parts)) $parts[] = "{$m}m";
                $time_str = implode(" ", $parts);
                $d1 = date("m-d", $t1);
                $d2 = date("m-d", $t2);
                $duration = "{$time_str} ({$d1} ~ {$d2})";
            }

            $rows[] = [
                'ip' => $row['ip'], 
                'count' => $row['count'],
                'last_seen' => $row['last_seen'],
                'duration' => $duration,
                'target_devices' => $formatTargetDevices($row['target_devices'])
            ];
        }
        echo json_encode($rows);
        break;

    case 'country_stats':
        $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
        $cutoff_dt = $db->querySingle("SELECT datetime('now', 'localtime', '-$days days')");
        $rows = [];
        
        $devFilter = $fgt_names_filter ? " AND $fgt_names_filter" : "";
        $stmt = $db->prepare("
            SELECT IFNULL(v.country, 'Unknown') as country, SUM(f.fail_count) as total_fails
            FROM (
                SELECT ip, COUNT(*) as fail_count 
                FROM faz_raw_events 
                WHERE timestamp >= :cutoff $devFilter
                GROUP BY ip
            ) f
            LEFT JOIN vt_ip_cache v ON f.ip = v.ip
            GROUP BY IFNULL(v.country, 'Unknown')
            ORDER BY total_fails DESC
        ");
        $stmt->bindValue(':cutoff', $cutoff_dt, SQLITE3_TEXT);
        if ($faz_name) $stmt->bindValue(':faz_name', $faz_name, SQLITE3_TEXT);
        $result = $stmt->execute();
        
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = [
                'country' => $row['country'],
                'total_fails' => $row['total_fails']
            ];
        }
        echo json_encode($rows);
        break;

    case 'user_timeline':
        $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
        $cutoff_dt = $db->querySingle("SELECT datetime('now', 'localtime', '-$days days')");
        
        $devFilter = $fgt_names_filter ? " AND $fgt_names_filter" : "";
        // 1. Get Top 10 Users
        $stmt = $db->prepare("
            SELECT user, COUNT(*) as total
            FROM faz_raw_events
            WHERE timestamp >= :cutoff $devFilter
            GROUP BY user
            ORDER BY total DESC
            LIMIT 10
        ");
        $stmt->bindValue(':cutoff', $cutoff_dt, SQLITE3_TEXT);
        if ($faz_name) $stmt->bindValue(':faz_name', $faz_name, SQLITE3_TEXT);
        $res = $stmt->execute();
        $top_users = [];
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $top_users[] = $row['user'];
        }

        if (empty($top_users)) {
            echo json_encode(['labels' => [], 'datasets' => []]);
            break;
        }

        // 2. Get breakdown by device for these users
        $in_clause = "'" . implode("','", array_map(function($u) { return SQLite3::escapeString($u); }, $top_users)) . "'";
        
        $stmt2 = $db->prepare("
            SELECT 
                user, 
                devname,
                COUNT(*) as count
            FROM faz_raw_events
            WHERE timestamp >= :cutoff $devFilter AND user IN ($in_clause)
            GROUP BY user, devname
        ");
        $stmt2->bindValue(':cutoff', $cutoff_dt, SQLITE3_TEXT);
        if ($faz_name) $stmt2->bindValue(':faz_name', $faz_name, SQLITE3_TEXT);
        $res2 = $stmt2->execute();
        
        $breakdown = [];
        $devices_set = [];
        while ($row = $res2->fetchArray(SQLITE3_ASSOC)) {
            $u = $row['user'];
            $d = $row['devname'];
            $breakdown[$u][$d] = $row['count'];
            $devices_set[$d] = true;
        }
        
        $all_devices = array_keys($devices_set);
        sort($all_devices);
        
        // Format for Chart.js
        $datasets = [];
        foreach ($all_devices as $d) {
            $data = [];
            foreach ($top_users as $u) {
                $data[] = isset($breakdown[$u][$d]) ? $breakdown[$u][$d] : 0;
            }
            $datasets[] = [
                'label' => $d,
                'data' => $data
            ];
        }
        
        echo json_encode([
            'labels' => $top_users,
            'datasets' => $datasets
        ]);
        break;

    case 'ad_status':
        $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
        $cutoff_dt = $db->querySingle("SELECT datetime('now', 'localtime', '-$days days')");
        
        $devFilter = $fgt_names_filter ? " AND f.$fgt_names_filter" : "";
        
        $stmt = $db->prepare("
            SELECT f.user, COUNT(*) as fail_count, MIN(f.timestamp) as min_ts, MAX(f.timestamp) as last_seen, 
                   GROUP_CONCAT(DISTINCT f.devname) as target_devices,
                   a.locked_out, a.lockout_time, a.password_expired, a.pwd_last_set, a.last_logon as ad_last_logon,
                   a.department, a.ad_site, a.office_phone
            FROM faz_raw_events f
            JOIN ad_users_cache a ON LOWER(f.user) = LOWER(a.username)
            WHERE f.timestamp >= :cutoff $devFilter
                AND f.user != 'Unknown' 
                AND f.user != ''
                AND a.exists_in_ad = 1
            GROUP BY f.user
            ORDER BY fail_count DESC
            LIMIT 5
        ");
        $stmt->bindValue(':cutoff', $cutoff_dt, SQLITE3_TEXT);
        if ($faz_name) $stmt->bindValue(':faz_name', $faz_name, SQLITE3_TEXT);
        $res = $stmt->execute();
        
        $ad_users = [];
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $duration = "0m";
            if (!empty($row['min_ts']) && !empty($row['last_seen'])) {
                $t1 = strtotime($row['min_ts']);
                $t2 = strtotime($row['last_seen']);
                $diff = max(0, $t2 - $t1);
                
                $d = floor($diff / 86400);
                $h = floor(($diff % 86400) / 3600);
                $m = floor(($diff % 3600) / 60);
                
                $parts = [];
                if ($d > 0) $parts[] = "{$d}d";
                if ($h > 0 || $d > 0) $parts[] = "{$h}h";
                if (empty($parts)) $parts[] = "{$m}m";
                $time_str = implode(" ", $parts);
                
                $d1 = date("m-d", $t1);
                $d2 = date("m-d", $t2);
                $duration = "{$time_str}<br>({$d1} ~ {$d2})";
            }

            $parts = [];
            if (!empty($row['ad_site']) && $row['ad_site'] !== 'N/A') $parts[] = $row['ad_site'];
            if (!empty($row['department']) && $row['department'] !== 'N/A') $parts[] = $row['department'];
            if (!empty($row['office_phone']) && $row['office_phone'] !== 'N/A') $parts[] = $row['office_phone'];

            $devices = !empty($row['target_devices']) ? explode(',', $row['target_devices']) : [];
            sort($devices);
            $target_devices_sorted = implode(',', $devices);

            $ad_users[] = [
                'Username' => $row['user'],
                'fail_count' => $row['fail_count'],
                'target_devices' => $formatTargetDevices($row['target_devices']),
                'duration' => $duration,
                'ExistsInAD' => 'Yes',
                'OU_Dept' => empty($parts) ? 'N/A' : implode(' / ', $parts),
                'LockedOut' => ($row['locked_out'] == 1) ? 'True' : 'False',
                'PasswordExpired' => ($row['password_expired'] == 1) ? 'True' : 'False',
                'LastPasswordChange' => $row['pwd_last_set'] ?: 'N/A',
                'LastLogon' => $row['ad_last_logon'] ?: 'N/A'
            ];
        }

        echo json_encode($ad_users);
        break;

    case 'non_ad_status':
        $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
        $cutoff_dt = $db->querySingle("SELECT datetime('now', 'localtime', '-$days days')");
        
        $devFilter = $fgt_names_filter ? " AND $fgt_names_filter" : "";
        
        // Performance optimization: Find top targets first, then filter AD status
        $stmt = $db->prepare("
            SELECT t.user, t.fail_count, t.min_ts, t.last_seen, t.target_devices
            FROM (
                SELECT user, COUNT(*) as fail_count, MIN(timestamp) as min_ts, MAX(timestamp) as last_seen,
                       GROUP_CONCAT(DISTINCT devname) as target_devices
                FROM faz_raw_events
                WHERE timestamp >= :cutoff $devFilter
                    AND user != 'Unknown' 
                    AND user != ''
                GROUP BY user
                ORDER BY fail_count DESC
                LIMIT 50
            ) t
            LEFT JOIN ad_users_cache a ON LOWER(t.user) = LOWER(a.username)
            WHERE (a.username IS NULL OR a.exists_in_ad = 0)
            ORDER BY t.fail_count DESC
            LIMIT 10
        ");
        $stmt->bindValue(':cutoff', $cutoff_dt, SQLITE3_TEXT);
        if ($faz_name) $stmt->bindValue(':faz_name', $faz_name, SQLITE3_TEXT);
        $res = $stmt->execute();
        
        $non_ad_users = [];
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $duration = "0m";
            if (!empty($row['min_ts']) && !empty($row['last_seen'])) {
                $t1 = strtotime($row['min_ts']);
                $t2 = strtotime($row['last_seen']);
                $diff = max(0, $t2 - $t1);
                
                $d = floor($diff / 86400);
                $h = floor(($diff % 86400) / 3600);
                $m = floor(($diff % 3600) / 60);
                
                $parts = [];
                if ($d > 0) $parts[] = "{$d}d";
                if ($h > 0 || $d > 0) $parts[] = "{$h}h";
                if (empty($parts)) $parts[] = "{$m}m";
                $time_str = implode(" ", $parts);
                
                $d1 = date("m-d", $t1);
                $d2 = date("m-d", $t2);
                $duration = "{$time_str}<br>({$d1} ~ {$d2})";
            }

            $devices = !empty($row['target_devices']) ? explode(',', $row['target_devices']) : [];
            sort($devices);
            $target_devices_sorted = implode(',', $devices);

            $non_ad_users[] = [
                'Username' => $row['user'],
                'fail_count' => $row['fail_count'],
                'target_devices' => $formatTargetDevices($row['target_devices']),
                'duration' => $duration
            ];
        }

        echo json_encode($non_ad_users);
        break;

    case 'country_timeline':
        $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
        $cutoff_dt = $db->querySingle("SELECT datetime('now', 'localtime', '-$days days')");
        
        $devFilter = $fgt_names_filter ? " AND f.$fgt_names_filter" : "";
        // 1. Get Top 10 Countries
        $stmt = $db->prepare("
            SELECT IFNULL(v.country, 'Unknown') as country, COUNT(*) as total
            FROM faz_raw_events f
            LEFT JOIN vt_ip_cache v ON f.ip = v.ip
            WHERE f.timestamp >= :cutoff $devFilter
            GROUP BY country
            ORDER BY total DESC
            LIMIT 10
        ");
        $stmt->bindValue(':cutoff', $cutoff_dt, SQLITE3_TEXT);
        if ($faz_name) $stmt->bindValue(':faz_name', $faz_name, SQLITE3_TEXT);
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
            WHERE f.timestamp >= :cutoff $devFilter AND IFNULL(v.country, 'Unknown') IN ($in_clause)
            GROUP BY country, bucket
            ORDER BY bucket ASC
        ");
        $stmt2->bindValue(':cutoff', $cutoff_dt, SQLITE3_TEXT);
        if ($faz_name) $stmt2->bindValue(':faz_name', $faz_name, SQLITE3_TEXT);
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

    case 'device_timeline':
        $days = isset($_GET['days']) ? intval($_GET['days']) : 7;
        $cutoff_dt = $db->querySingle("SELECT datetime('now', 'localtime', '-$days days')");
        
        $devFilter = $fgt_names_filter ? " AND $fgt_names_filter" : "";
        
        // 1. Get counts grouped by device and day
        $stmt = $db->prepare("
            SELECT 
                devname, 
                date(timestamp) as day, 
                COUNT(*) as count
            FROM faz_raw_events
            WHERE timestamp >= :cutoff $devFilter
            GROUP BY devname, day
            ORDER BY day ASC
        ");
        $stmt->bindValue(':cutoff', $cutoff_dt, SQLITE3_TEXT);
        if ($faz_name) $stmt->bindValue(':faz_name', $faz_name, SQLITE3_TEXT);
        $res = $stmt->execute();
        
        $timeline = [];
        $days_set = [];
        $device_totals = [];
        
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $dn = $row['devname'];
            $label = isset($allMappings[$dn]) ? $allMappings[$dn]['display'] : $dn;
            $d = $row['day'];
            $c = intval($row['count']);
            
            $timeline[$label][$d] = $c;
            $days_set[$d] = true;
            $device_totals[$label] = ($device_totals[$label] ?? 0) + $c;
        }
        
        $all_days = array_keys($days_set);
        sort($all_days);
        
        // Sort devices by total count descending
        arsort($device_totals);
        
        $devices_data = [];
        foreach ($device_totals as $label => $total) {
            $row_data = [];
            foreach ($all_days as $d) {
                $row_data[$d] = $timeline[$label][$d] ?? 0;
            }
            $devices_data[] = [
                'name' => $label,
                'data' => $row_data,
                'total' => $total
            ];
        }
        
        echo json_encode([
            'days' => $all_days,
            'devices' => $devices_data
        ]);
        break;

    case 'save_csv':
        $csv = $_POST['csv_content'] ?? '';
        $filename = $_POST['filename'] ?? 'export.csv';
        if (empty($csv)) {
            echo json_encode(['error' => 'No CSV content received in POST.']);
            exit;
        }
        
        $tempDbPath = __DIR__ . '/temp_export.db';
        try {
            $tDb = new SQLite3($tempDbPath);
            $tDb->exec("CREATE TABLE IF NOT EXISTS exports (id TEXT PRIMARY KEY, content TEXT, filename TEXT, created_at INTEGER)");
            $tDb->exec("DELETE FROM exports WHERE created_at < " . (time() - 3600));
            
            $id = bin2hex(random_bytes(16));
            $stmt = $tDb->prepare("INSERT INTO exports (id, content, filename, created_at) VALUES (:id, :content, :filename, :created_at)");
            $stmt->bindValue(':id', $id, SQLITE3_TEXT);
            $stmt->bindValue(':content', $csv, SQLITE3_TEXT);
            $stmt->bindValue(':filename', $filename, SQLITE3_TEXT);
            $stmt->bindValue(':created_at', time(), SQLITE3_INTEGER);
            $stmt->execute();
            
            echo json_encode(['id' => $id]);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
        }
        exit;

    case 'download_csv':
        $id = $_GET['id'] ?? '';
        if (empty($id)) {
            http_response_code(400);
            echo "Missing download ID";
            exit;
        }
        
        $tempDbPath = __DIR__ . '/temp_export.db';
        if (!file_exists($tempDbPath)) {
            http_response_code(404);
            echo "Export storage not found";
            exit;
        }
        
        try {
            $tDb = new SQLite3($tempDbPath, SQLITE3_OPEN_READONLY);
            $stmt = $tDb->prepare("SELECT content, filename FROM exports WHERE id = :id");
            $stmt->bindValue(':id', $id, SQLITE3_TEXT);
            $res = $stmt->execute();
            $row = $res->fetchArray(SQLITE3_ASSOC);
            
            if (!$row) {
                http_response_code(404);
                echo "Export expired or not found";
                exit;
            }
            
            // Forces download with absolute clean headers
            header('Content-Description: File Transfer');
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . basename($row['filename']) . '"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . strlen($row['content']));
            
            echo $row['content'];
        } catch (Exception $e) {
            http_response_code(500);
            echo "Database error during download: " . $e->getMessage();
        }
        exit;

    default:
        echo json_encode(['error' => 'Unknown action']);
}

$db->close();


