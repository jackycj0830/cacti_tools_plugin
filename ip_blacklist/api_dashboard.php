<?php
/**
 * Security Dashboard API functions for ip_blacklist
 * Integrates MySQL (Blacklist/Cache/FAZ state)
 */

require_once __DIR__ . '/database/IPCacheDB.php'; // For MySQL

function getDashStats($params)
{
    try {
        $days = isset($params['days']) ? intval($params['days']) : 7;
        $db = IPCacheDB::getInstance()->getPDO(); // MySQL

        $stats = [];
        $stats['total_cached'] = $db->query("SELECT COUNT(*) FROM ip_database")->fetchColumn();
        $stats['total_blacklisted'] = $db->query("SELECT COUNT(*) FROM ip_cache WHERE is_blacklisted = 1 AND vt_malicious >= 3")->fetchColumn();

        $stmt = $db->query("SELECT DATE_SUB(NOW(), INTERVAL $days DAY) as cutoff, NOW() as now_local");
        $times = $stmt->fetch();
        $cutoff_dt = $times['cutoff'];
        $now_local = $times['now_local'];

        $stmtMin = $db->query("SELECT MIN(timestamp) as min_ts FROM faz_raw_events");
        $minRow = $stmtMin->fetch();
        $min_ts = $minRow['min_ts'] ?? $now_local;

        $actual_start = $cutoff_dt;
        $stats['is_partial'] = false;
        if ($min_ts > $cutoff_dt) {
            $actual_start = $min_ts;
            $stats['is_partial'] = true;
        }

        $stmtCounts = $db->prepare("SELECT COUNT(*) as exact_count, COUNT(DISTINCT ip) as distinct_ips FROM faz_raw_events WHERE timestamp >= :cutoff");
        $stmtCounts->execute(['cutoff' => $cutoff_dt]);
        $row = $stmtCounts->fetch();

        if ($row && $row['exact_count'] > 0) {
            $stats['faz_total_logins'] = $row['exact_count'];
            $stats['faz_unique_ips'] = $row['distinct_ips'];

            // Get targeted IPs (>= 50 attempts) array
            $stmtTarget = $db->prepare("SELECT ip FROM faz_raw_events WHERE timestamp >= :cutoff GROUP BY ip HAVING COUNT(*) >= 50");
            $stmtTarget->execute(['cutoff' => $cutoff_dt]);
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
                $stats['run_blacklisted'] = $stmtBl->fetchColumn();
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
        $days = isset($params['days']) ? intval($params['days']) : 7;
        $minMal = intval($params['min_mal'] ?? 3);
        $db = IPCacheDB::getInstance()->getPDO();

        $stmtCutoff = $db->query("SELECT DATE_SUB(NOW(), INTERVAL $days DAY) as cutoff");
        $cutoff_dt = $stmtCutoff->fetchColumn();

        $stmtTarget = $db->prepare("SELECT ip FROM faz_raw_events WHERE timestamp >= :cutoff GROUP BY ip HAVING COUNT(*) >= 50");
        $stmtTarget->execute(['cutoff' => $cutoff_dt]);
        $targetIps = $stmtTarget->fetchAll(PDO::FETCH_COLUMN);

        if (empty($targetIps)) return [];

        // Modify query to retrieve from ip_cache instead of vt_blacklist matching the old format
        $inClause = rtrim(str_repeat('?,', count($targetIps)), ',');
        $stmt = $db->prepare("
            SELECT ip_address as ip, 
                   IF(risk_level='high', 'MALICIOUS', IF(is_blacklisted=1, 'SUSPICIOUS', 'CLEAN')) as verdict,
                   vt_malicious as malicious, 
                   vt_suspicious as suspicious, 
                   org as as_owner, 
                   country_code as country, 
                   '' as network, 
                   threat_info as flagged_vendors, 
                   created_at as first_seen, 
                   updated_at as last_seen, 
                   hit_count as times_seen
            FROM ip_cache 
            WHERE is_blacklisted = 1 AND vt_malicious >= ? AND ip_address IN ($inClause)
            ORDER BY vt_malicious DESC, vt_suspicious DESC
        ");

        $sqlParams = array_merge([$minMal], $targetIps);
        $stmt->execute($sqlParams);
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as &$r) {
            $ti = json_decode($r['flagged_vendors'], true);
            $fv = [];
            if ($ti && isset($ti['flagged_vendors'])) {
                foreach ($ti['flagged_vendors'] as $vendor) {
                    $fv[] = $vendor['vendor'] . '(' . $vendor['category'] . ')';
                }
            }
            $r['flagged_vendors'] = implode('; ', $fv);
        }

        return $results;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function getDashFaz($params)
{
    try {
        $days = isset($params['days']) ? intval($params['days']) : 7;
        $db = IPCacheDB::getInstance()->getPDO();

        $stmtCutoff = $db->query("SELECT DATE_SUB(NOW(), INTERVAL $days DAY) as cutoff");
        $cutoff_dt = $stmtCutoff->fetchColumn();

        $stmt = $db->prepare("
            SELECT ip, COUNT(*) as count, MAX(timestamp) as last_seen 
            FROM faz_raw_events 
            WHERE timestamp >= :cutoff 
            GROUP BY ip HAVING count >= 50
            ORDER BY count DESC
        ");
        $stmt->execute(['cutoff' => $cutoff_dt]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function getDashCountry($params)
{
    try {
        $days = isset($params['days']) ? intval($params['days']) : 7;
        $db = IPCacheDB::getInstance()->getPDO();

        $stmtCutoff = $db->query("SELECT DATE_SUB(NOW(), INTERVAL $days DAY) as cutoff");
        $cutoff_dt = $stmtCutoff->fetchColumn();

        $stmt = $db->prepare("
            SELECT ip, COUNT(*) as fail_count 
            FROM faz_raw_events 
            WHERE timestamp >= :cutoff 
            GROUP BY ip
        ");
        $stmt->execute(['cutoff' => $cutoff_dt]);

        $ipFails = [];
        $ipList = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ipFails[$row['ip']] = $row['fail_count'];
            $ipList[] = $row['ip'];
        }

        if (empty($ipList)) return [];

        $chunkedIps = array_chunk($ipList, 1000);
        $countryMap = [];

        foreach ($chunkedIps as $chunk) {
            $inClause = rtrim(str_repeat('?,', count($chunk)), ',');
            $stmtMap = $db->prepare("SELECT ip_address, country_code AS country FROM ip_database WHERE ip_address IN ($inClause)");
            $stmtMap->execute($chunk);
            while ($row = $stmtMap->fetch(PDO::FETCH_ASSOC)) {
                $countryMap[$row['ip_address']] = $row['country'] ? $row['country'] : 'Unknown';
            }
        }

        $countryFails = [];
        foreach ($ipFails as $ip => $fails) {
            $country = isset($countryMap[$ip]) ? $countryMap[$ip] : 'Unknown';
            if (!isset($countryFails[$country])) {
                $countryFails[$country] = 0;
            }
            $countryFails[$country] += $fails;
        }

        $results = [];
        foreach ($countryFails as $c => $f) {
            $results[] = [
                'country' => $c,
                'total_fails' => $f
            ];
        }

        return $results;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

function getDashCountryTimeline($params)
{
    try {
        $days = isset($params['days']) ? intval($params['days']) : 7;
        $db = IPCacheDB::getInstance()->getPDO();

        $stmtCutoff = $db->query("SELECT DATE_SUB(NOW(), INTERVAL $days DAY) as cutoff");
        $cutoff_dt = $stmtCutoff->fetchColumn();

        $stmt = $db->prepare("
            SELECT ip, COUNT(*) as fail_count 
            FROM faz_raw_events 
            WHERE timestamp >= :cutoff 
            GROUP BY ip
        ");
        $stmt->execute(['cutoff' => $cutoff_dt]);

        $ipFails = [];
        $ipList = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $ipFails[$row['ip']] = $row['fail_count'];
            $ipList[] = $row['ip'];
        }

        if (empty($ipList)) {
            return ['labels' => [], 'datasets' => []];
        }

        $chunkedIps = array_chunk($ipList, 1000);
        $countryMap = [];

        foreach ($chunkedIps as $chunk) {
            $inClause = rtrim(str_repeat('?,', count($chunk)), ',');
            $stmtMap = $db->prepare("SELECT ip_address, country_code AS country FROM ip_database WHERE ip_address IN ($inClause)");
            $stmtMap->execute($chunk);
            while ($row = $stmtMap->fetch(PDO::FETCH_ASSOC)) {
                $countryMap[$row['ip_address']] = $row['country'] ? $row['country'] : 'Unknown';
            }
        }

        $countryFails = [];
        foreach ($ipFails as $ip => $fails) {
            $country = isset($countryMap[$ip]) ? $countryMap[$ip] : 'Unknown';
            if (!isset($countryFails[$country])) {
                $countryFails[$country] = 0;
            }
            $countryFails[$country] += $fails;
        }

        arsort($countryFails);
        $topCountries = array_slice(array_keys($countryFails), 0, 10);

        if (empty($topCountries)) {
            return ['labels' => [], 'datasets' => []];
        }

        $bucket_expr = $days <= 2 ? "DATE_FORMAT(timestamp, '%Y-%m-%d %H:00')" : "DATE(timestamp)";

        $stmt3 = $db->prepare("
            SELECT ip, $bucket_expr as bucket, COUNT(*) as count 
            FROM faz_raw_events 
            WHERE timestamp >= :cutoff 
            GROUP BY ip, bucket
            ORDER BY bucket ASC
        ");
        $stmt3->execute(['cutoff' => $cutoff_dt]);

        $timeline = [];
        $buckets_set = [];
        while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
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

        $all_buckets = array_keys($buckets_set);
        sort($all_buckets);

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
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
