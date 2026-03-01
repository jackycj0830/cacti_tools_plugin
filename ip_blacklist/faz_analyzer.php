<?php
/**
 * faz_analyzer.php
 * ================
 * PHP replacement for analyze_faz_ips.py
 *
 * 1. Download the latest "SSLVPN Failed Logins" from FortiAnalyzer (FAZ) via JSON-RPC.
 * 2. Extract unique IPs and verify each against the VirusTotal Free API v3.
 * 3. Cache VT results in MySQL `ip_cache` table.
 * 4. Permanently record confirmed malicious/suspicious IPs as blacklisted.
 *
 * Usage:
 *   php faz_analyzer.php                  # Default 7 days
 *   php faz_analyzer.php --days 14        # Custom day range
 */

// --- Load Database Layer (no HTTP side-effects) ---
require_once __DIR__ . '/database/IPCacheDB.php';

// ============================================================================
// CONFIGURATION
// ============================================================================
define('FAZ_IP', '172.16.0.4');
define('FAZ_TOKEN', 'waxk81r3g9fmzps4nrup55gn4huq17qc');
define('FAZ_URL', 'https://' . FAZ_IP . '/jsonrpc');
define('FAZ_ADOM', 'root');

define('VT_API_KEY', '4a8be222d7595073328d5aff0076fd5296d37637745007308da6569f06208e42');
define('VT_URL', 'https://www.virustotal.com/api/v3/ip_addresses');
define('VT_REQUEST_DELAY', 15);
define('VT_CACHE_TTL', 30); // days

// ============================================================================
// LOGGING
// ============================================================================
$logFile = __DIR__ . '/web/analysis_progress.log';
@file_put_contents($logFile, ""); // Clear

function logOutput($msg) {
    global $logFile;
    $line = $msg . "\n";
    echo $line;
    @file_put_contents($logFile, $line, FILE_APPEND);
    flush();
}

// ============================================================================
// PARSE CLI ARGUMENTS
// ============================================================================
$days_back = 7;
if (isset($argv)) {
    for ($i = 1; $i < count($argv); $i++) {
        if ($argv[$i] === '--days' && isset($argv[$i + 1])) {
            $days_back = intval($argv[$i + 1]);
            $i++;
        }
    }
}

// ============================================================================
// DATABASE INIT
// ============================================================================
logOutput("[*] Initializing PHP analysis script...");

$dbInstance = IPCacheDB::getInstance();
if (!$dbInstance->isConnected()) {
    logOutput("[Error] Failed to connect to database: " . ($dbInstance->getConnectionError() ?: 'Unknown error'));
    logOutput("[Error] Check MySQL is running and settings in database/db_config.php are correct.");
    logOutput("[Error] Current config: host=" . MYSQL_HOST . " port=" . MYSQL_PORT . " db=" . MYSQL_DATABASE);
    logOutput("Finished");
    exit(1);
}
$db = $dbInstance->getPDO();
logOutput("[DB] Connected to MySQL successfully.");

// Ensure FAZ tables exist in MySQL
try {
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
    logOutput("[DB] FAZ tables verified.");
} catch (Exception $e) {
    logOutput("[DB Warning] Table creation check: " . $e->getMessage());
}

// ============================================================================
// HELPER FUNCTIONS
// ============================================================================

function is_private_ip($ip) {
    return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE);
}

function get_last_faz_timestamp() {
    global $db;
    try {
        $stmt = $db->query("SELECT MAX(timestamp) as max_ts FROM faz_raw_events");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['max_ts'] ?? null;
    } catch (Exception $e) {
        return null;
    }
}

function get_min_faz_timestamp() {
    global $db;
    try {
        $stmt = $db->query("SELECT MIN(timestamp) as min_ts FROM faz_raw_events");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['min_ts'] ?? null;
    } catch (Exception $e) {
        return null;
    }
}

function faz_api_request($payload) {
    $ch = curl_init(FAZ_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . FAZ_TOKEN,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        logOutput("[FAZ] cURL error: " . curl_error($ch));
        curl_close($ch);
        return null;
    }
    curl_close($ch);
    return json_decode($response, true);
}

// ============================================================================
// FAZ LOG QUERY
// ============================================================================

function faz_query_logs($filter_str, $days_back = 7, $max_entries = 500000) {
    $today = new DateTime();
    $last_ts_str = get_last_faz_timestamp();
    $min_ts_str = get_min_faz_timestamp();
    $target_start_dt = (new DateTime())->modify("-{$days_back} days");

    if ($last_ts_str) {
        $last_ts = new DateTime($last_ts_str);
        if ($min_ts_str) {
            $min_ts = new DateTime($min_ts_str);
            if ($target_start_dt < $min_ts) {
                $start_dt = $target_start_dt;
                logOutput(sprintf("[FAZ] Expanding sync window to cover %d days. Fetching since: %s", $days_back, $start_dt->format('Y-m-d H:i:s')));
            } else {
                $start_dt = (clone $last_ts)->modify("+1 second");
                logOutput(sprintf("[FAZ] Last sync found. Fetching delta since: %s", $start_dt->format('Y-m-d H:i:s')));
            }
        } else {
            $start_dt = (clone $last_ts)->modify("+1 second");
            logOutput(sprintf("[FAZ] Last sync found. Delta since: %s", $start_dt->format('Y-m-d H:i:s')));
        }
    } else {
        $start_dt = $target_start_dt;
        logOutput(sprintf("[FAZ] No previous sync found. Fetching full %d days since: %s", $days_back, $start_dt->format('Y-m-d H:i:s')));
    }

    $start = $start_dt->format("Y-m-d\TH:i:s");
    $end = $today->format("Y-m-d\TH:i:s");

    $search_payload = [
        "id" => 1,
        "jsonrpc" => "2.0",
        "method" => "add",
        "params" => [[
            "apiver" => 3,
            "url" => "/logview/adom/" . FAZ_ADOM . "/logsearch",
            "logtype" => "event",
            "time-order" => "desc",
            "time-range" => ["start" => $start, "end" => $end],
            "filter" => $filter_str,
        ]]
    ];

    $d = faz_api_request($search_payload);
    if (!$d || isset($d['error'])) {
        logOutput("[FAZ] Search request failed.");
        return [];
    }

    $tid = $d['result']['tid'] ?? null;
    if (!$tid) {
        logOutput("[FAZ] No search task ID returned.");
        return [];
    }

    logOutput("[FAZ] Search task created (tid={$tid}), polling ...");

    $all_entries = [];
    $limit = 500;
    $offset = 0;

    for ($attempt = 1; $attempt <= 300; $attempt++) {
        sleep(2);
        $poll_payload = [
            "id" => 2,
            "jsonrpc" => "2.0",
            "method" => "get",
            "params" => [[
                "apiver" => 3,
                "url" => "/logview/adom/" . FAZ_ADOM . "/logsearch/{$tid}",
                "limit" => $limit,
                "offset" => $offset
            ]]
        ];

        $r2 = faz_api_request($poll_payload);
        $r2_result = $r2['result'] ?? null;
        if (!is_array($r2_result)) continue;

        $pct = $r2_result['percentage'] ?? 0;
        $total = $r2_result['total-lines'] ?? 0;
        $data = $r2_result['data'] ?? [];

        if (is_array($data) && count($data) > 0) {
            $all_entries = array_merge($all_entries, $data);
            $offset += count($data);
        }

        if ($total > 0) {
            logOutput(sprintf("[FAZ]   Poll %d: %d%% complete (fetched %d of %d)", $attempt, $pct, count($all_entries), $total));
        } else {
            logOutput(sprintf("[FAZ]   Poll %d: Fetching logs... (%d records)", $attempt, count($all_entries)));
        }

        if ($pct >= 100) {
            if ($total && count($all_entries) < $total) continue;
            break;
        }
        if (count($all_entries) >= $max_entries) {
            logOutput("[FAZ]   Reached max entries cap.");
            break;
        }
    }

    return $all_entries;
}

// ============================================================================
// FAZ PIPELINE: FETCH -> STORE -> AGGREGATE
// ============================================================================

function fetch_from_faz($days_back = 7) {
    global $db;

    logOutput("============================================================");
    logOutput("  FortiAnalyzer SSLVPN Failed Login Query");
    logOutput("============================================================");
    logOutput("[FAZ] Connecting to " . FAZ_IP . " (ADOM: " . FAZ_ADOM . ") ...");

    $entries = faz_query_logs("subtype == vpn && action == ssl-login-fail", $days_back);
    if (!$entries) {
        logOutput("[FAZ] No log entries found.");
        return null;
    }
    logOutput("[FAZ] Retrieved " . count($entries) . " log entries.");

    $raw_db_args = [];
    foreach ($entries as $entry) {
        $remip = $entry['remip'] ?? '';
        if ($remip && !is_private_ip($remip)) {
            $ts = trim(($entry['date'] ?? '') . ' ' . ($entry['time'] ?? ''));
            $ts = str_replace('T', ' ', $ts);
            $raw_db_args[] = [$remip, $ts];
        }
    }

    if (!$raw_db_args) {
        logOutput("[FAZ] No new public IP logs found.");
        return null;
    }
    logOutput("[FAZ] Found " . count($raw_db_args) . " new public IP events.");

    try {
        $inserted = 0;
        $db->beginTransaction();
        $stmt = $db->prepare("INSERT IGNORE INTO faz_raw_events (ip, timestamp) VALUES (?, ?)");
        foreach ($raw_db_args as $arg) {
            $stmt->execute([$arg[0], $arg[1]]);
            if ($stmt->rowCount() > 0) $inserted++;
        }
        $db->commit();
        logOutput("[DB] Synced {$inserted} new raw events.");

        // Purge old events (> 28 days)
        $purge_dt = (new DateTime())->modify("-28 days")->format("Y-m-d H:i:s");
        $stmt_del = $db->prepare("DELETE FROM faz_raw_events WHERE timestamp < ?");
        $stmt_del->execute([$purge_dt]);
        $pruned = $stmt_del->rowCount();
        if ($pruned > 0) logOutput("[DB] Purged {$pruned} FAZ events older than 28 days.");

        // Generate run ID and aggregate
        $run_id = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000, mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));

        $cutoff_dt = (new DateTime())->modify("-{$days_back} days")->format("Y-m-d H:i:s");

        $stmt_agg = $db->prepare("SELECT ip, COUNT(*) as cnt, MIN(timestamp) as mmin, MAX(timestamp) as mmax FROM faz_raw_events WHERE timestamp >= ? GROUP BY ip");
        $stmt_agg->execute([$cutoff_dt]);
        $agg_rows = $stmt_agg->fetchAll(PDO::FETCH_ASSOC);

        $MIN_ATTEMPTS = 50;
        $total_events = 0;
        $filtered_count = 0;
        $now_str = date('Y-m-d H:i:s');

        $db->beginTransaction();
        $stmt_ins = $db->prepare("INSERT INTO faz_logs (run_id, ip, count, first_seen, last_seen, imported_at) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($agg_rows as $row) {
            $total_events += $row['cnt'];
            if ($row['cnt'] >= $MIN_ATTEMPTS) {
                $filtered_count++;
                $stmt_ins->execute([$run_id, $row['ip'], $row['cnt'], $row['mmin'], $row['mmax'], $now_str]);
            }
        }
        $db->commit();

        logOutput("[DB] Run ID ({$run_id}): {$filtered_count} targets >= {$MIN_ATTEMPTS} attempts.");

        // Save stats for dashboard
        $stats = [
            "start_time" => (new DateTime())->modify("-{$days_back} days")->format("m-d H:i"),
            "end_time" => date("m-d H:i"),
            "total_logins" => $total_events,
            "unique_ips" => count($agg_rows),
            "filtered_ips" => $filtered_count
        ];
        @file_put_contents(__DIR__ . "/web/latest_stats.json", json_encode($stats));
        return $run_id;

    } catch (Exception $e) {
        if ($db->inTransaction()) $db->rollBack();
        logOutput("[DB Error] " . $e->getMessage());
        return null;
    }
}

// ============================================================================
// VIRUSTOTAL CHECK
// ============================================================================

function vt_check_ip($ip) {
    $url = VT_URL . '/' . $ip;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["x-apikey: " . VT_API_KEY]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $response = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($status_code == 429) return "RATE_LIMIT";
    if ($status_code == 401) { logOutput("[VT] ERROR: Invalid API key."); return null; }
    if ($status_code != 200) { logOutput("[VT] Unexpected status {$status_code} for {$ip}"); return null; }

    $data = json_decode($response, true);
    $attrs = $data['data']['attributes'] ?? [];
    $stats = $attrs['last_analysis_stats'] ?? [];

    $flagged_vendors = [];
    foreach ($attrs['last_analysis_results'] ?? [] as $vendor => $info) {
        $cat = $info['category'] ?? '';
        if (in_array($cat, ['malicious', 'suspicious'])) {
            $flagged_vendors[] = ["vendor" => $vendor, "category" => $cat, "result" => $info['result'] ?? 'N/A'];
        }
    }

    // Parse WHOIS
    $whois_raw = $attrs['whois'] ?? '';
    $whois_org = 'N/A';
    $whois_created = 'N/A';
    foreach (explode("\n", $whois_raw) as $line) {
        $lower = strtolower(trim($line));
        if ((strpos($lower, 'org:') === 0 || strpos($lower, 'organization:') === 0) && $whois_org === 'N/A') {
            $whois_org = trim(explode(":", $line, 2)[1] ?? '');
        } elseif (strpos($lower, 'created:') === 0 && $whois_created === 'N/A') {
            $whois_created = trim(explode(":", $line, 2)[1] ?? '');
        }
    }

    $last_analysis_ts = $attrs['last_analysis_date'] ?? 0;

    return [
        "ip" => $ip,
        "malicious" => $stats['malicious'] ?? 0,
        "suspicious" => $stats['suspicious'] ?? 0,
        "undetected" => $stats['undetected'] ?? 0,
        "harmless" => $stats['harmless'] ?? 0,
        "asn" => $attrs['asn'] ?? "N/A",
        "as_owner" => $attrs['as_owner'] ?? "N/A",
        "country" => $attrs['country'] ?? "N/A",
        "continent" => $attrs['continent'] ?? "N/A",
        "network" => $attrs['network'] ?? "N/A",
        "registry" => $attrs['regional_internet_registry'] ?? "N/A",
        "reputation" => $attrs['reputation'] ?? 0,
        "total_votes" => $attrs['total_votes'] ?? [],
        "flagged_vendors" => $flagged_vendors,
        "whois_org" => $whois_org,
        "whois_created" => $whois_created,
        "last_analysis" => $last_analysis_ts ? date('Y-m-d H:i', $last_analysis_ts) : 'N/A'
    ];
}

function classify($result) {
    if (!$result) return "UNKNOWN";
    $m = $result['malicious'] ?? 0;
    $s = $result['suspicious'] ?? 0;
    if ($m >= 3) return "MALICIOUS";
    if ($m >= 1 || $s >= 2) return "SUSPICIOUS";
    return "CLEAN";
}

// ============================================================================
// MAIN EXECUTION
// ============================================================================

// Phase 1: Fetch from FAZ
fetch_from_faz($days_back);

// Phase 2: VirusTotal analysis on high-frequency IPs
$cutoff_dt = (new DateTime())->modify("-{$days_back} days")->format("Y-m-d H:i:s");
$stmt = $db->prepare("SELECT ip FROM faz_raw_events WHERE timestamp >= ? GROUP BY ip HAVING COUNT(*) >= 50");
$stmt->execute([$cutoff_dt]);
$ips = $stmt->fetchAll(PDO::FETCH_COLUMN);

logOutput("\n======================================================================");
logOutput("  VirusTotal IP Analysis  (Free API + MySQL Cache)");
logOutput("======================================================================");
logOutput("  IPs to check : " . count($ips));
logOutput("  Cache TTL    : " . VT_CACHE_TTL . " day(s)");
logOutput("----------------------------------------------------------------------");

$api_calls = 0;
$cache_hits = 0;

foreach ($ips as $ix => $ip) {
    $num = $ix + 1;
    logOutput("\n==================================================");
    logOutput("  [{$num}/" . count($ips) . "] Checking {$ip}");
    logOutput("==================================================");

    // Check MySQL cache
    try {
        $stmtCache = $db->prepare("SELECT threat_info, expires_at FROM ip_cache WHERE ip_address = ?");
        $stmtCache->execute([$ip]);
        $cached = $stmtCache->fetch(PDO::FETCH_ASSOC);

        if ($cached && $cached['threat_info'] && (!$cached['expires_at'] || new DateTime($cached['expires_at']) > new DateTime())) {
            $result = json_decode($cached['threat_info'], true);
            if ($result) {
                $verdict = classify($result);
                $m = $result['malicious'] ?? 0;
                $s = $result['suspicious'] ?? 0;
                $h = $result['harmless'] ?? 0;
                logOutput("  Verdict : {$verdict} (malicious={$m}  suspicious={$s}  harmless={$h})  [CACHED]");
                $cache_hits++;
                continue;
            }
        }
    } catch (Exception $e) {
        // Cache lookup failed, proceed to API
    }

    // Rate limit
    if ($api_calls > 0) {
        logOutput("  (waiting " . VT_REQUEST_DELAY . "s for rate limit...)");
        sleep(VT_REQUEST_DELAY);
    }

    $result = vt_check_ip($ip);
    $api_calls++;

    if ($result === "RATE_LIMIT") {
        logOutput("  ... Rate limited. Waiting 60s ...");
        sleep(60);
        $result = vt_check_ip($ip);
        $api_calls++;
    }
    if ($result === "RATE_LIMIT" || !$result) {
        logOutput("  ... Could not retrieve data. Skipping.");
        continue;
    }

    $verdict = classify($result);
    $result['verdict'] = $verdict;
    $m = $result['malicious'];
    $s = $result['suspicious'];
    $h = $result['harmless'];
    $u = $result['undetected'];
    logOutput("  Verdict : {$verdict} (malicious={$m}  suspicious={$s}  harmless={$h})  [FRESH from API]");

    // Store in ip_cache
    $is_bl = in_array($verdict, ["MALICIOUS", "SUSPICIOUS"]) ? 1 : 0;
    $status = $is_bl ? "blocked" : "safe";
    $risk = $m >= 3 ? "high" : ($is_bl ? "medium" : "low");
    $ttl = $is_bl ? 3650 : VT_CACHE_TTL;
    $expires = (new DateTime())->modify("+{$ttl} days")->format("Y-m-d H:i:s");
    $threatJson = json_encode($result, JSON_UNESCAPED_UNICODE);
    $now = date('Y-m-d H:i:s');
    $note = $is_bl ? "FAZ Auto-Blocked: SSLVPN Brute Force" : "";
    $country = substr($result['country'] ?? '', 0, 10);

    try {
        $sql = "INSERT INTO ip_cache (
            ip_address, is_blacklisted, status, risk_level, country_code,
            threat_info, vt_malicious, vt_suspicious, vt_harmless, vt_undetected,
            vt_detection_flagged, vt_detection_total, vt_queried_at,
            created_at, updated_at, expires_at, hit_count, custom_note
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?
        ) ON DUPLICATE KEY UPDATE 
            is_blacklisted=VALUES(is_blacklisted),
            status=VALUES(status),
            risk_level=VALUES(risk_level),
            threat_info=VALUES(threat_info),
            vt_malicious=VALUES(vt_malicious),
            vt_suspicious=VALUES(vt_suspicious),
            vt_harmless=VALUES(vt_harmless),
            vt_undetected=VALUES(vt_undetected),
            vt_detection_flagged=VALUES(vt_detection_flagged),
            vt_detection_total=VALUES(vt_detection_total),
            vt_queried_at=NOW(),
            updated_at=NOW(),
            expires_at=VALUES(expires_at),
            custom_note=IF(custom_note IS NULL OR custom_note='', VALUES(custom_note), custom_note)";

        $stmtSave = $db->prepare($sql);
        $stmtSave->execute([
            $ip, $is_bl, $status, $risk, $country,
            $threatJson, $m, $s, $h, $u, $m + $s, $m + $s + $h + $u, $now,
            $now, $now, $expires, $note
        ]);
    } catch (Exception $e) {
        logOutput("  [DB] Cache save error: " . $e->getMessage());
    }

    // Print flagged vendors
    if (!empty($result['flagged_vendors'])) {
        logOutput("  Flagged by " . count($result['flagged_vendors']) . " vendor(s):");
        foreach ($result['flagged_vendors'] as $v) {
            logOutput("    [{$v['category']}] {$v['vendor']}: {$v['result']}");
        }
    }
}

// Final summary
logOutput("\n============================================================");
logOutput("  LOOKUP STATISTICS");
logOutput("  Cache hits  : {$cache_hits}");
logOutput("  API calls   : {$api_calls}");
logOutput("  Total IPs   : " . count($ips));
$saved_secs = $cache_hits * VT_REQUEST_DELAY;
logOutput("  Time saved  : ~{$saved_secs}s");
logOutput("============================================================");
logOutput("Finished");
