<?php
/**
 * Security Dashboard API functions for ip_blacklist
 * Integrates SQLite (FAZ state) and MySQL (Blacklist/Cache)
 */

require_once __DIR__ . '/database/IPCacheDB.php'; // For MySQL

// Path to the Python scripts SQLite database
define('FAZ_SQLITE_DB', realpath(__DIR__ . '/../Block_IP_20260223/vt_cache.db'));

/**
 * Gets the SQLite connection for FAZ raw events
 */
function getFazDb()
{
    if (!file_exists(FAZ_SQLITE_DB)) {
        return null;
    }
    return new SQLite3(FAZ_SQLITE_DB, SQLITE3_OPEN_READONLY);
}

function getDashStats($params)
{
    try {
        $days = isset($params['days']) ? intval($params['days']) : 7;

        $fazDb = getFazDb();
        $db = IPCacheDB::getInstance()->getPDO(); // MySQL

        $stats = [];

        // MySQL queries
        $stats['total_cached'] = $db->query("SELECT COUNT(*) FROM ip_database")->fetchColumn();
        $stats['total_blacklisted'] = $db->query("SELECT COUNT(*) FROM vt_blacklist WHERE malicious >= 3")->fetchColumn();

        if ($fazDb) {
            $times = $fazDb->querySingle("SELECT datetime('now', 'localtime', '-$days days') as cutoff, datetime('now', 'localtime') as now_local", true);
            $cutoff_dt = $times['cutoff'];
            $now_local = $times['now_local'];

            $minRow = $fazDb->querySingle("SELECT MIN(timestamp) as min_ts FROM faz_raw_events", true);
            $min_ts = $minRow['min_ts'] ?? $now_local;

            $actual_start = $cutoff_dt;
            $stats['is_partial'] = false;
            if ($min_ts > $cutoff_dt) {
                $actual_start = $min_ts;
                $stats['is_partial'] = true;
            }

            $row = $fazDb->querySingle("SELECT COUNT(*), COUNT(DISTINCT ip) FROM faz_raw_events WHERE timestamp >= '$cutoff_dt'", true);
            if ($row) {
                $stats['faz_total_logins'] = $row['COUNT(*)'];
                $stats['faz_unique_ips'] = $row['COUNT(DISTINCT ip)'];

                // Get targeted IPs (>= 50 attempts) array
                $res = $fazDb->query("SELECT ip FROM faz_raw_events WHERE timestamp >= '$cutoff_dt' GROUP BY ip HAVING COUNT(*) >= 50");
                $targetIps = [];
                while ($r = $res->fetchArray(SQLITE3_ASSOC)) {
                    $targetIps[] = $r['ip'];
                }

                $stats['faz_ip_count'] = count($targetIps);
                $stats['faz_start'] = substr($actual_start, 5, 11);
                $stats['faz_end'] = substr($now_local, 5, 11);

                // Active Blacklist corresponding to targeted IPs
                if (empty($targetIps)) {
                    $stats['run_blacklisted'] = 0;
                }
                else {
                    $inClause = rtrim(str_repeat('?,', count($targetIps)), ',');
                    $stmt = $db->prepare("SELECT COUNT(DISTINCT ip) FROM vt_blacklist WHERE malicious >= 3 AND ip IN ($inClause)");
                    $stmt->execute($targetIps);
                    $stats['run_blacklisted'] = $stmt->fetchColumn();
                }
            }
            else {
                $stats['faz_total_logins'] = 0;
                $stats['faz_unique_ips'] = 0;
                $stats['faz_ip_count'] = 0;
                $stats['faz_start'] = substr($actual_start, 5, 11);
                $stats['faz_end'] = substr($now_local, 5, 11);
                $stats['run_blacklisted'] = 0;
            }
        }
        else {
            $stats['error'] = 'FAZ DB not found';
            $stats['faz_total_logins'] = 0;
            $stats['faz_unique_ips'] = 0;
            $stats['faz_ip_count'] = 0;
            $stats['run_blacklisted'] = 0;
        }

        return $stats;
    }
    catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function getDashBlacklist($params)
{
    try {
        $days = isset($params['days']) ? intval($params['days']) : 7;
        $minMal = intval($params['min_mal'] ?? 3);

        $fazDb = getFazDb();
        if (!$fazDb)
            return ['error' => 'FAZ DB missing'];
        $db = IPCacheDB::getInstance()->getPDO();

        $cutoff_dt = $fazDb->querySingle("SELECT datetime('now', 'localtime', '-$days days')");

        // Step 1: Get target IPs
        $res = $fazDb->query("SELECT ip FROM faz_raw_events WHERE timestamp >= '$cutoff_dt' GROUP BY ip HAVING COUNT(*) >= 50");
        $targetIps = [];
        while ($r = $res->fetchArray(SQLITE3_ASSOC)) {
            $targetIps[] = $r['ip'];
        }

        if (empty($targetIps))
            return [];

        // Step 2: Query MySQL
        $inClause = rtrim(str_repeat('?,', count($targetIps)), ',');
        $stmt = $db->prepare("
            SELECT ip, verdict, malicious, suspicious, as_owner, country, network, flagged_vendors, first_seen, last_seen, times_seen 
            FROM vt_blacklist 
            WHERE malicious >= ? AND ip IN ($inClause)
            ORDER BY malicious DESC, suspicious DESC
        ");

        $sqlParams = array_merge([$minMal], $targetIps);
        $stmt->execute($sqlParams);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function getDashFaz($params)
{
    try {
        $days = isset($params['days']) ? intval($params['days']) : 7;
        $fazDb = getFazDb();
        if (!$fazDb)
            return ['error' => 'FAZ DB missing'];

        $cutoff_dt = $fazDb->querySingle("SELECT datetime('now', 'localtime', '-$days days')");
        $rows = [];

        $stmt = $fazDb->prepare("
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
        return $rows;
    }
    catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function getDashCountry($params)
{
    try {
        $days = isset($params['days']) ? intval($params['days']) : 7;

        $fazDb = getFazDb();
        if (!$fazDb)
            return ['error' => 'FAZ DB missing'];
        $db = IPCacheDB::getInstance()->getPDO();

        $cutoff_dt = $fazDb->querySingle("SELECT datetime('now', 'localtime', '-$days days')");

        // Step 1: Map all IP fails and gather them
        $stmt = $fazDb->prepare("
            SELECT ip, COUNT(*) as fail_count 
            FROM faz_raw_events 
            WHERE timestamp >= :cutoff 
            GROUP BY ip
        ");
        $stmt->bindValue(':cutoff', $cutoff_dt, SQLITE3_TEXT);
        $result = $stmt->execute();

        $ipFails = [];
        $ipList = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $ipFails[$row['ip']] = $row['fail_count'];
            $ipList[] = $row['ip'];
        }

        if (empty($ipList))
            return [];

        // Step 2: Grab country mapping from MySQL ip_database
        // Note: country info is stored in geoip_data as JSON
        $chunkedIps = array_chunk($ipList, 1000); // chunk to avoid hitting SQL parameter limit
        $countryMap = [];

        foreach ($chunkedIps as $chunk) {
            $inClause = rtrim(str_repeat('?,', count($chunk)), ',');
            $stmt = $db->prepare("SELECT ip_address, country_code AS country FROM ip_database WHERE ip_address IN ($inClause)");
            $stmt->execute($chunk);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $countryMap[$row['ip_address']] = $row['country'] ? $row['country'] : 'Unknown';
            }
        }

        // Step 3: Aggregate fails by country
        $countryFails = [];
        foreach ($ipFails as $ip => $fails) {
            $country = isset($countryMap[$ip]) ? $countryMap[$ip] : 'Unknown';
            if (!isset($countryFails[$country])) {
                $countryFails[$country] = 0;
            }
            $countryFails[$country] += $fails;
        }

        // Format for output
        $results = [];
        foreach ($countryFails as $c => $f) {
            $results[] = [
                'country' => $c,
                'total_fails' => $f
            ];
        }

        return $results;
    }
    catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function getDashCountryTimeline($params)
{
    try {
        $days = isset($params['days']) ? intval($params['days']) : 7;

        $fazDb = getFazDb();
        if (!$fazDb)
            return ['error' => 'FAZ DB missing'];
        $db = IPCacheDB::getInstance()->getPDO();

        $cutoff_dt = $fazDb->querySingle("SELECT datetime('now', 'localtime', '-$days days')");

        // 1. Map all IP fails and gather them to find top 10 countries
        $stmt = $fazDb->prepare("
            SELECT ip, COUNT(*) as fail_count 
            FROM faz_raw_events 
            WHERE timestamp >= :cutoff 
            GROUP BY ip
        ");
        $stmt->bindValue(':cutoff', $cutoff_dt, SQLITE3_TEXT);
        $result = $stmt->execute();

        $ipFails = [];
        $ipList = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $ipFails[$row['ip']] = $row['fail_count'];
            $ipList[] = $row['ip'];
        }

        if (empty($ipList)) {
            return ['labels' => [], 'datasets' => []];
        }

        // Grab country mapping from MySQL
        $chunkedIps = array_chunk($ipList, 1000);
        $countryMap = [];

        foreach ($chunkedIps as $chunk) {
            $inClause = rtrim(str_repeat('?,', count($chunk)), ',');
            $stmt2 = $db->prepare("SELECT ip_address, country_code AS country FROM ip_database WHERE ip_address IN ($inClause)");
            $stmt2->execute($chunk);
            while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                $countryMap[$row['ip_address']] = $row['country'] ? $row['country'] : 'Unknown';
            }
        }

        // Aggregate fails by country
        $countryFails = [];
        foreach ($ipFails as $ip => $fails) {
            $country = isset($countryMap[$ip]) ? $countryMap[$ip] : 'Unknown';
            if (!isset($countryFails[$country])) {
                $countryFails[$country] = 0;
            }
            $countryFails[$country] += $fails;
        }

        // Get Top 10 Countries
        arsort($countryFails);
        $topCountries = array_slice(array_keys($countryFails), 0, 10);

        if (empty($topCountries)) {
            return ['labels' => [], 'datasets' => []];
        }

        // 2. Get timeline data for these top 10 countries
        $bucket_expr = $days <= 2 ? "strftime('%Y-%m-%d %H:00', timestamp)" : "date(timestamp)";

        $stmt3 = $fazDb->prepare("
            SELECT ip, $bucket_expr as bucket, COUNT(*) as count 
            FROM faz_raw_events 
            WHERE timestamp >= :cutoff 
            GROUP BY ip, bucket
            ORDER BY bucket ASC
        ");
        $stmt3->bindValue(':cutoff', $cutoff_dt, SQLITE3_TEXT);
        $res3 = $stmt3->execute();

        $timeline = [];
        $buckets_set = [];
        while ($row = $res3->fetchArray(SQLITE3_ASSOC)) {
            $ip = $row['ip'];
            $b = $row['bucket'];
            $c = isset($countryMap[$ip]) ? $countryMap[$ip] : 'Unknown';

            if (in_array($c, $topCountries)) {
                if (!isset($timeline[$c][$b])) {
                    $timeline[$c][$b] = 0;
                }
                $timeline[$c][$b] += $row['count'];
                $buckets_set[$b] = true;
            }
        }

        // Sort buckets chronologically
        $all_buckets = array_keys($buckets_set);
        sort($all_buckets);

        // Format for Chart.js
        $datasets = [];
        foreach ($topCountries as $c) {
            $data = [];
            foreach ($all_buckets as $b) {
                $data[] = isset($timeline[$c][$b]) ? $timeline[$c][$b] : 0;
            }
            $datasets[] = [
                'label' => $c,
                'data' => $data
            ];
        }

        return [
            'labels' => $all_buckets,
            'datasets' => $datasets
        ];
    }
    catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
