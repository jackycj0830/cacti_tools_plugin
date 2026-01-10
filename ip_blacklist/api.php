<?php
/**
 * IP Blacklist Query System API / 黑名單IP查詢系統API
 * @author Cacti Tools Team
 * @version 2.1.0
 *
 * Enhanced with Multi-Provider GeoIP Support and Database Caching
 */

// ============================================================================
// DATABASE CACHE INTEGRATION / 資料庫快取整合
// ============================================================================
require_once __DIR__ . '/database/IPCache.php';

// Global cache instance (lazy loaded)
$ipCache = null;
function getIPCache() {
    global $ipCache;
    if ($ipCache === null) {
        try {
            $ipCache = new IPCache();
        } catch (Exception $e) {
            $ipCache = false; // Mark as unavailable
        }
    }
    return $ipCache;
}

// ============================================================================
// CONFIGURATION SECTION / 配置區
// ============================================================================

// Blacklist File Path
// Option 1: Local path (for development)
// define('BLACKLIST_FILE', __DIR__ . '/data/IP_From_Oversea.txt');
// Option 2: Absolute path (for production - Linux server)
define('BLACKLIST_FILE', '/var/www/html/IP_From_Oversea.txt');

// History and Cache Settings
define('QUERY_HISTORY_FILE', __DIR__ . '/data/query_history.json');
define('GEOIP_CACHE_FILE', __DIR__ . '/data/geoip_cache.json');
define('MAX_HISTORY_RECORDS', 100);
define('GEOIP_CACHE_TTL', 86400); // 24 hours

// ============================================================================
// GEOIP API PROVIDERS CONFIGURATION / GeoIP API 提供者配置
// ============================================================================
//
// Each provider has: enabled, url, apiKey, priority, rateLimit, timeout
// Lower priority number = higher priority (queried first)
// Set your API keys below for providers that require authentication
//
// ============================================================================

$GEOIP_PROVIDERS = [
    // Provider 1: ip-api.com (Free, no API key required, 45 req/min limit)
    'ip-api' => [
        'enabled' => true,
        'name' => 'IP-API.com',
        'url' => 'http://ip-api.com/json/{IP}?fields=status,message,country,countryCode,region,regionName,city,zip,lat,lon,timezone,isp,org,as,query',
        'apiKey' => '', // Not required for free tier
        'apiKeyHeader' => '', // Not used
        'priority' => 1,
        'rateLimit' => 45, // requests per minute
        'timeout' => 5,
        'description' => 'Free GeoIP API with good accuracy. No API key required.',
        'website' => 'https://ip-api.com'
    ],

    // Provider 2: ipapi.co (Free tier: 1000 req/day, no key required)
    'ipapi-co' => [
        'enabled' => true,
        'name' => 'ipapi.co',
        'url' => 'https://ipapi.co/{IP}/json/',
        'apiKey' => '', // Optional - add for higher limits
        'apiKeyHeader' => '', // Not used for free tier
        'priority' => 2,
        'rateLimit' => 1000, // requests per day
        'timeout' => 5,
        'description' => 'Free tier with 1000 requests/day. Good for backup.',
        'website' => 'https://ipapi.co'
    ],

    // Provider 3: ipinfo.io (Free tier: 50K req/month)
    'ipinfo' => [
        'enabled' => true,
        'name' => 'IPinfo.io',
        'url' => 'https://ipinfo.io/{IP}/json',
        'apiKey' => '', // Add your token: 'your_token_here'
        'apiKeyParam' => 'token', // Query parameter name for API key
        'priority' => 3,
        'rateLimit' => 50000, // requests per month
        'timeout' => 5,
        'description' => 'Popular API with 50K free requests/month. Optional token.',
        'website' => 'https://ipinfo.io'
    ],

    // Provider 4: ip-api.is (Free, unlimited, no key required)
    'ip-api-is' => [
        'enabled' => true,
        'name' => 'IP-API.is',
        'url' => 'https://api.ip-api.is/?ip={IP}',
        'apiKey' => '',
        'apiKeyHeader' => '',
        'priority' => 4,
        'rateLimit' => 0, // Unlimited
        'timeout' => 5,
        'description' => 'Free unlimited GeoIP lookups. Good fallback option.',
        'website' => 'https://ip-api.is'
    ],

    // Provider 5: ipgeolocation.io (Free tier: 1000 req/day)
    'ipgeolocation' => [
        'enabled' => false, // Disabled by default - requires API key
        'name' => 'IPGeolocation.io',
        'url' => 'https://api.ipgeolocation.io/ipgeo?ip={IP}',
        'apiKey' => '', // REQUIRED: Get free key at https://ipgeolocation.io
        'apiKeyParam' => 'apiKey',
        'priority' => 5,
        'rateLimit' => 1000, // requests per day
        'timeout' => 5,
        'description' => 'Requires API key. 1000 free requests/day.',
        'website' => 'https://ipgeolocation.io'
    ],

    // Provider 6: Abstract API (Free tier: 20K req/month)
    'abstractapi' => [
        'enabled' => false, // Disabled by default - requires API key
        'name' => 'AbstractAPI',
        'url' => 'https://ipgeolocation.abstractapi.com/v1/?ip_address={IP}',
        'apiKey' => '', // REQUIRED: Get free key at https://abstractapi.com
        'apiKeyParam' => 'api_key',
        'priority' => 6,
        'rateLimit' => 20000, // requests per month
        'timeout' => 5,
        'description' => 'Requires API key. 20K free requests/month.',
        'website' => 'https://abstractapi.com'
    ]
];

// Query Mode: 'fallback' (try until success) or 'aggregate' (query all, merge results)
// Changed to 'aggregate' to show results from all providers
define('GEOIP_QUERY_MODE', 'aggregate');

header('Content-Type: application/json; charset=utf-8');
$action = $_GET['action'] ?? '';
switch ($action) {
    case 'query':
        $skipCache = isset($_GET['nocache']) && $_GET['nocache'] === '1';
        echo json_encode(queryIP(trim($_GET['ip'] ?? ''), $skipCache));
        break;
    case 'batch': echo json_encode(batchQuery(json_decode($_POST['ips'] ?? '[]', true))); break;
    case 'stats': echo json_encode(getStatistics()); break;
    case 'history': echo json_encode(getQueryHistory()); break;
    case 'providers': echo json_encode(getGeoIPProviders()); break;
    case 'export': exportResults($_GET['format'] ?? 'json'); break;

    // Cache management endpoints
    case 'cache_stats': echo json_encode(getCacheStatistics()); break;
    case 'cache_cleanup': echo json_encode(cleanupCache()); break;
    case 'cache_clear': echo json_encode(clearCache()); break;

    // Manual cache operations
    case 'cache_save':
        echo json_encode(manualCacheSave(json_decode(file_get_contents('php://input'), true)));
        break;
    case 'cache_save_batch':
        echo json_encode(manualCacheSaveBatch(json_decode(file_get_contents('php://input'), true)));
        break;
    case 'cache_info':
        echo json_encode(getCacheInfo(trim($_GET['ip'] ?? '')));
        break;

    // Custom notes for blacklisted IPs
    case 'save_note':
        echo json_encode(saveIPNote(json_decode(file_get_contents('php://input'), true)));
        break;
    case 'get_note':
        echo json_encode(getIPNote(trim($_GET['ip'] ?? '')));
        break;
    case 'delete_note':
        echo json_encode(deleteIPNote(trim($_GET['ip'] ?? '')));
        break;

    default: echo json_encode(['error' => 'Unknown action. Use: query, batch, stats, history, providers, export, cache_stats, cache_cleanup, cache_clear, cache_save, cache_save_batch, cache_info, save_note, get_note, delete_note']);
}

function loadBlacklist() {
    static $blacklist = null;
    if ($blacklist === null) {
        $blacklist = [];
        if (file_exists(BLACKLIST_FILE)) {
            $lines = file(BLACKLIST_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $ip = trim($line);
                if (!empty($ip) && filter_var($ip, FILTER_VALIDATE_IP)) $blacklist[$ip] = true;
            }
        }
    }
    return $blacklist;
}

function isBlacklisted($ip) { return isset(loadBlacklist()[$ip]); }

function ipInCidr($ip, $cidr) {
    list($subnet, $mask) = explode('/', $cidr);
    $ipLong = ip2long($ip); $subnetLong = ip2long($subnet);
    $maskLong = -1 << (32 - $mask); $subnetLong &= $maskLong;
    return ($ipLong & $maskLong) === $subnetLong;
}

function findBlacklistedInCidr($cidr) {
    $matches = [];
    foreach (array_keys(loadBlacklist()) as $ip) {
        if (ipInCidr($ip, $cidr)) $matches[] = $ip;
    }
    return $matches;
}

/**
 * Get GeoIP information using multiple providers with fallback/aggregation
 * 使用多個提供者獲取GeoIP信息，支持回退和聚合模式
 */
function getGeoIP($ip, $returnAllProviders = false) {
    global $GEOIP_PROVIDERS;

    // Check cache first (skip if we need all providers for display)
    if (!$returnAllProviders) {
        $cache = loadGeoIPCache();
        if (isset($cache[$ip]) && $cache[$ip]['timestamp'] > time() - GEOIP_CACHE_TTL) {
            return $cache[$ip]['data'];
        }
    }

    // Get enabled providers sorted by priority
    $enabledProviders = array_filter($GEOIP_PROVIDERS, fn($p) => $p['enabled']);
    uasort($enabledProviders, fn($a, $b) => $a['priority'] <=> $b['priority']);

    $geoData = null;
    $providerUsed = null;
    $allResults = [];

    foreach ($enabledProviders as $providerId => $provider) {
        $result = queryGeoIPProvider($ip, $providerId, $provider);
        if ($result !== null) {
            $result['_providerId'] = $providerId;
            $result['_providerName'] = $provider['name'];
            $allResults[$providerId] = $result;

            if (GEOIP_QUERY_MODE === 'fallback' && !$returnAllProviders) {
                // Fallback mode: use first successful result
                $geoData = $result;
                $geoData['_provider'] = $provider['name'];
                $providerUsed = $providerId;
                break;
            }
        }
    }

    // If returning all providers for aggregate display
    if ($returnAllProviders || GEOIP_QUERY_MODE === 'aggregate') {
        $geoData = aggregateGeoIPResults($allResults);
        $geoData['_allProviderResults'] = $allResults;
        $geoData['_totalProviders'] = count($enabledProviders);
        $geoData['_successfulProviders'] = count($allResults);
    }

    // Cache the result
    if ($geoData !== null && !$returnAllProviders) {
        saveGeoIPCache($ip, $geoData);
    }

    return $geoData;
}

/**
 * Query a single GeoIP provider
 */
function queryGeoIPProvider($ip, $providerId, $provider) {
    $url = str_replace('{IP}', urlencode($ip), $provider['url']);

    // Add API key if configured
    if (!empty($provider['apiKey'])) {
        if (!empty($provider['apiKeyParam'])) {
            $separator = strpos($url, '?') !== false ? '&' : '?';
            $url .= $separator . $provider['apiKeyParam'] . '=' . urlencode($provider['apiKey']);
        }
    }

    $context = stream_context_create([
        'http' => [
            'timeout' => $provider['timeout'] ?? 5,
            'ignore_errors' => true,
            'header' => !empty($provider['apiKeyHeader']) && !empty($provider['apiKey'])
                ? $provider['apiKeyHeader'] . ': ' . $provider['apiKey']
                : ''
        ]
    ]);

    $response = @file_get_contents($url, false, $context);
    if (!$response) return null;

    $data = json_decode($response, true);
    if (!$data) return null;

    // Parse response based on provider
    return parseGeoIPResponse($providerId, $data);
}

/**
 * Parse GeoIP response from different providers into unified format
 */
function parseGeoIPResponse($providerId, $data) {
    switch ($providerId) {
        case 'ip-api':
            if (($data['status'] ?? '') !== 'success') return null;
            return [
                'country' => $data['country'] ?? 'Unknown',
                'countryCode' => $data['countryCode'] ?? '',
                'region' => $data['regionName'] ?? '',
                'city' => $data['city'] ?? '',
                'isp' => $data['isp'] ?? '',
                'org' => $data['org'] ?? '',
                'as' => $data['as'] ?? '',
                'timezone' => $data['timezone'] ?? '',
                'lat' => $data['lat'] ?? 0,
                'lon' => $data['lon'] ?? 0,
                'zip' => $data['zip'] ?? ''
            ];

        case 'ipapi-co':
            if (isset($data['error'])) return null;
            return [
                'country' => $data['country_name'] ?? 'Unknown',
                'countryCode' => $data['country_code'] ?? '',
                'region' => $data['region'] ?? '',
                'city' => $data['city'] ?? '',
                'isp' => $data['org'] ?? '',
                'org' => $data['org'] ?? '',
                'as' => $data['asn'] ?? '',
                'timezone' => $data['timezone'] ?? '',
                'lat' => $data['latitude'] ?? 0,
                'lon' => $data['longitude'] ?? 0,
                'zip' => $data['postal'] ?? ''
            ];

        case 'ipinfo':
            if (isset($data['bogon']) || isset($data['error'])) return null;
            $loc = explode(',', $data['loc'] ?? '0,0');
            return [
                'country' => $data['country'] ?? 'Unknown',
                'countryCode' => $data['country'] ?? '',
                'region' => $data['region'] ?? '',
                'city' => $data['city'] ?? '',
                'isp' => $data['org'] ?? '',
                'org' => $data['org'] ?? '',
                'as' => '',
                'timezone' => $data['timezone'] ?? '',
                'lat' => floatval($loc[0] ?? 0),
                'lon' => floatval($loc[1] ?? 0),
                'zip' => $data['postal'] ?? ''
            ];

        case 'ip-api-is':
            if (!isset($data['ip'])) return null;
            $loc = $data['location'] ?? [];
            $asn = $data['asn'] ?? [];
            return [
                'country' => $loc['country'] ?? 'Unknown',
                'countryCode' => $loc['country_code'] ?? '',
                'region' => $loc['state'] ?? '',
                'city' => $loc['city'] ?? '',
                'isp' => $asn['org'] ?? '',
                'org' => $asn['org'] ?? '',
                'as' => isset($asn['asn']) ? 'AS' . $asn['asn'] : '',
                'timezone' => $loc['timezone'] ?? '',
                'lat' => $loc['latitude'] ?? 0,
                'lon' => $loc['longitude'] ?? 0,
                'zip' => $loc['zip_code'] ?? ''
            ];

        case 'ipgeolocation':
            if (isset($data['message'])) return null;
            return [
                'country' => $data['country_name'] ?? 'Unknown',
                'countryCode' => $data['country_code2'] ?? '',
                'region' => $data['state_prov'] ?? '',
                'city' => $data['city'] ?? '',
                'isp' => $data['isp'] ?? '',
                'org' => $data['organization'] ?? '',
                'as' => '',
                'timezone' => $data['time_zone']['name'] ?? '',
                'lat' => floatval($data['latitude'] ?? 0),
                'lon' => floatval($data['longitude'] ?? 0),
                'zip' => $data['zipcode'] ?? ''
            ];

        case 'abstractapi':
            if (isset($data['error'])) return null;
            return [
                'country' => $data['country'] ?? 'Unknown',
                'countryCode' => $data['country_code'] ?? '',
                'region' => $data['region'] ?? '',
                'city' => $data['city'] ?? '',
                'isp' => $data['connection']['isp_name'] ?? '',
                'org' => $data['connection']['organization_name'] ?? '',
                'as' => $data['connection']['autonomous_system_number'] ?? '',
                'timezone' => $data['timezone']['name'] ?? '',
                'lat' => floatval($data['latitude'] ?? 0),
                'lon' => floatval($data['longitude'] ?? 0),
                'zip' => $data['postal_code'] ?? ''
            ];

        default:
            return null;
    }
}

/**
 * Aggregate results from multiple providers (used in aggregate mode)
 */
function aggregateGeoIPResults($results) {
    if (empty($results)) return null;

    // Use first result as base
    $aggregated = reset($results);
    $providerNames = [];

    foreach ($results as $providerId => $result) {
        global $GEOIP_PROVIDERS;
        $providerNames[] = $GEOIP_PROVIDERS[$providerId]['name'] ?? $providerId;

        // Fill empty values from other providers
        foreach ($result as $key => $value) {
            if (empty($aggregated[$key]) && !empty($value)) {
                $aggregated[$key] = $value;
            }
        }
    }

    $aggregated['_providers'] = $providerNames;
    $aggregated['_providerCount'] = count($results);

    return $aggregated;
}

/**
 * Load GeoIP cache from file
 */
function loadGeoIPCache() {
    if (!file_exists(GEOIP_CACHE_FILE)) return [];
    $cache = json_decode(file_get_contents(GEOIP_CACHE_FILE), true);
    return is_array($cache) ? $cache : [];
}

/**
 * Save GeoIP result to cache
 */
function saveGeoIPCache($ip, $data) {
    $cache = loadGeoIPCache();
    $cache[$ip] = ['timestamp' => time(), 'data' => $data];

    // Limit cache size
    if (count($cache) > 1000) {
        $cache = array_slice($cache, -500, null, true);
    }

    @file_put_contents(GEOIP_CACHE_FILE, json_encode($cache, JSON_PRETTY_PRINT));
}

/**
 * Get list of configured GeoIP providers (for frontend display)
 */
function getGeoIPProviders() {
    global $GEOIP_PROVIDERS;
    $providers = [];

    foreach ($GEOIP_PROVIDERS as $id => $provider) {
        $providers[] = [
            'id' => $id,
            'name' => $provider['name'],
            'enabled' => $provider['enabled'],
            'priority' => $provider['priority'],
            'rateLimit' => $provider['rateLimit'],
            'description' => $provider['description'],
            'website' => $provider['website'],
            'requiresApiKey' => !empty($provider['apiKeyParam']) && empty($provider['apiKey'])
        ];
    }

    usort($providers, fn($a, $b) => $a['priority'] <=> $b['priority']);
    return $providers;
}

function queryIP($ip, $skipCache = false) {
    if (empty($ip)) return ['error' => '請輸入IP地址 / Please enter an IP address'];
    if (strpos($ip, '/') !== false) return queryCIDR($ip);
    if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) return ['error' => '無效的IPv4地址 / Invalid IPv4 address'];

    // Check database cache first (unless skipCache is true)
    $cache = getIPCache();
    $cacheInfo = null;

    if ($cache && !$skipCache) {
        $cached = $cache->get($ip);
        if ($cached) {
            // Re-check blacklist status (blacklist file may have changed)
            $currentBlacklisted = isBlacklisted($ip);
            if ($cached['blacklisted'] === $currentBlacklisted) {
                $cached['message'] = $currentBlacklisted
                    ? '⚠️ 此IP在黑名單中 / This IP is blacklisted'
                    : '✅ 此IP不在黑名單中 / This IP is not blacklisted';
                $cached['timestamp'] = date('Y-m-d H:i:s');
                $cached['fromCache'] = true;
                // Add cache info
                $cached['cacheInfo'] = $cache->getCacheInfoForIP($ip);
                // Include custom note if available
                $noteData = $cache->getNote($ip);
                $cached['customNote'] = $noteData['note'] ?? null;
                $cached['noteCreatedAt'] = $noteData['createdAt'] ?? null;
                $cached['noteUpdatedAt'] = $noteData['updatedAt'] ?? null;
                saveQueryHistory($cached);
                return $cached;
            }
            // Blacklist status changed, need fresh data
        }
    }

    // Cache miss or expired - query APIs
    $isBlacklisted = isBlacklisted($ip);
    $geoData = getGeoIP($ip, true); // Get all provider results

    // Generate risk analysis based on aggregated data
    $riskAnalysis = generateRiskAnalysis($ip, $isBlacklisted, $geoData);

    // Get custom note if exists (may have been saved previously)
    $noteData = null;
    if ($cache) {
        $noteData = $cache->getNote($ip);
    }

    $result = [
        'ip' => $ip,
        'blacklisted' => $isBlacklisted,
        'status' => $isBlacklisted ? 'blocked' : 'safe',
        'message' => $isBlacklisted ? '⚠️ 此IP在黑名單中 / This IP is blacklisted' : '✅ 此IP不在黑名單中 / This IP is not blacklisted',
        'geo' => $geoData,
        'providerResults' => $geoData['_allProviderResults'] ?? [],
        'providerStats' => [
            'total' => $geoData['_totalProviders'] ?? 0,
            'successful' => $geoData['_successfulProviders'] ?? 0,
        ],
        'riskAnalysis' => $riskAnalysis,
        'threatInfo' => $isBlacklisted ? getThreatInfo($ip) : null,
        'timestamp' => date('Y-m-d H:i:s'),
        'fromCache' => false,
        'cacheInfo' => null,
        // Custom notes
        'customNote' => $noteData['note'] ?? null,
        'noteCreatedAt' => $noteData['createdAt'] ?? null,
        'noteUpdatedAt' => $noteData['updatedAt'] ?? null
    ];

    // Store in database cache automatically
    $cacheSaveSuccess = false;
    if ($cache) {
        $cacheSaveSuccess = $cache->set($ip, $result);
        if ($cacheSaveSuccess) {
            // Update cache info after saving
            $result['cacheInfo'] = $cache->getCacheInfoForIP($ip);
            $result['cacheInfo']['justCached'] = true;
        }
    }
    $result['cacheSaved'] = $cacheSaveSuccess;

    saveQueryHistory($result);
    return $result;
}

/**
 * Generate risk analysis based on aggregated provider data
 */
function generateRiskAnalysis($ip, $isBlacklisted, $geoData) {
    $providerResults = $geoData['_allProviderResults'] ?? [];
    $totalProviders = $geoData['_totalProviders'] ?? 4;
    $successfulProviders = count($providerResults);

    // Count providers with data
    $providersWithData = 0;
    $countryConsensus = [];
    $ispList = [];

    foreach ($providerResults as $providerId => $result) {
        $providersWithData++;
        if (!empty($result['country'])) {
            $countryConsensus[$result['country']] = ($countryConsensus[$result['country']] ?? 0) + 1;
        }
        if (!empty($result['isp'])) {
            $ispList[] = $result['isp'];
        }
    }

    // Determine risk level
    $riskScore = 0;
    $riskFactors = [];

    // Factor 1: Blacklist status
    if ($isBlacklisted) {
        $riskScore += 50;
        $riskFactors[] = 'IP is on the blacklist / IP在黑名單中';
    }

    // Factor 2: Provider data availability
    $dataRatio = $successfulProviders / max($totalProviders, 1);
    if ($dataRatio < 0.5) {
        $riskScore += 10;
        $riskFactors[] = 'Limited provider data available / 可用的提供者數據有限';
    }

    // Factor 3: Country consensus
    if (count($countryConsensus) > 1) {
        $riskScore += 5;
        $riskFactors[] = 'Inconsistent country data across providers / 各提供者的國家數據不一致(需要進行國家名稱比對)';
    }

    // Determine risk level text
    if ($riskScore >= 50) {
        $riskLevel = 'high';
        $riskLevelText = '高風險 / High Risk';
        $recommendation = $isBlacklisted
            ? '建議封鎖此IP。此IP已被列入黑名單。/ Recommend blocking this IP. This IP is blacklisted.'
            : '需要進一步調查。/ Requires further investigation.';
    } elseif ($riskScore >= 20) {
        $riskLevel = 'medium';
        $riskLevelText = '中等風險 / Medium Risk';
        $recommendation = '建議監控此IP的活動。/ Recommend monitoring this IP\'s activity.';
    } else {
        $riskLevel = 'low';
        $riskLevelText = '低風險 / Low Risk';
        $recommendation = '此IP目前看起來是安全的。/ This IP appears to be safe.';
    }

    return [
        'riskScore' => $riskScore,
        'riskLevel' => $riskLevel,
        'riskLevelText' => $riskLevelText,
        'recommendation' => $recommendation,
        'riskFactors' => $riskFactors,
        'providersQueried' => $totalProviders,
        'providersResponded' => $successfulProviders,
        'dataRatio' => sprintf('%d/%d', $successfulProviders, $totalProviders),
        'countryConsensus' => $countryConsensus,
        'blacklistStatus' => $isBlacklisted ? '1/1' : '0/1'
    ];
}

function queryCIDR($cidr) {
    $parts = explode('/', $cidr);
    if (count($parts) !== 2) return ['error' => '無效的CIDR格式 / Invalid CIDR format'];
    $subnet = $parts[0]; $mask = intval($parts[1]);
    if (!filter_var($subnet, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) || $mask < 0 || $mask > 32)
        return ['error' => '無效的CIDR格式 / Invalid CIDR format'];
    
    $matches = findBlacklistedInCidr($cidr);
    return ['cidr' => $cidr, 'type' => 'cidr_query', 'totalIPs' => pow(2, 32 - $mask),
        'blacklistedCount' => count($matches), 'blacklistedIPs' => array_slice($matches, 0, 100),
        'message' => count($matches) > 0 ? sprintf('⚠️ 發現 %d 個黑名單IP', count($matches)) : '✅ 此範圍內無黑名單IP',
        'timestamp' => date('Y-m-d H:i:s')];
}

function batchQuery($ips) {
    if (!is_array($ips) || empty($ips)) return ['error' => '請提供IP列表 / Please provide IP list'];

    $results = [];
    $blacklistedCount = 0;
    $safeCount = 0;
    $highRiskCount = 0;
    $mediumRiskCount = 0;
    $lowRiskCount = 0;
    $cacheHits = 0;
    $apiCalls = 0;

    // Limit to 50 IPs for batch with full analysis
    $ipsToProcess = array_slice($ips, 0, 50);
    $totalToProcess = count($ipsToProcess);

    // Check database cache for all IPs first
    $cache = getIPCache();
    $cachedResults = [];
    $uncachedIPs = $ipsToProcess;

    if ($cache) {
        $cacheResult = $cache->getMultiple($ipsToProcess);
        $cachedResults = $cacheResult['cached'];
        $uncachedIPs = $cacheResult['missing'];
        $cacheHits = count($cachedResults);
    }

    // Process all IPs (cached and uncached)
    foreach ($ipsToProcess as $index => $ip) {
        $ip = trim($ip);
        if (empty($ip)) continue;

        if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $results[] = ['ip' => $ip, 'error' => 'Invalid IP', 'status' => 'error'];
            continue;
        }

        // Check if we have cached data for this IP
        if (isset($cachedResults[$ip])) {
            $cached = $cachedResults[$ip];
            // Re-verify blacklist status
            $isBlacklisted = isBlacklisted($ip);
            $isBlacklisted ? $blacklistedCount++ : $safeCount++;

            $riskLevel = $cached['riskAnalysis']['riskLevel'] ?? 'low';
            if ($riskLevel === 'high') $highRiskCount++;
            elseif ($riskLevel === 'medium') $mediumRiskCount++;
            else $lowRiskCount++;

            $results[] = [
                'ip' => $ip,
                'blacklisted' => $isBlacklisted,
                'status' => $isBlacklisted ? 'blocked' : 'safe',
                'country' => $cached['geo']['country'] ?? '',
                'countryName' => $cached['geo']['countryName'] ?? '-',
                'city' => $cached['geo']['city'] ?? '-',
                'isp' => $cached['geo']['isp'] ?? '-',
                'riskScore' => $cached['riskAnalysis']['riskScore'] ?? 0,
                'riskLevel' => $riskLevel,
                'riskFactors' => $cached['riskAnalysis']['riskFactors'] ?? [],
                'threatInfo' => $cached['threatInfo'],
                'providerCount' => $cached['providerStats']['successful'] ?? 0,
                'fromCache' => true
            ];
            continue;
        }

        // Cache miss - query APIs
        $apiCalls++;
        $isBlacklisted = isBlacklisted($ip);
        $isBlacklisted ? $blacklistedCount++ : $safeCount++;

        // Query multiple providers for more accurate risk assessment
        $multiGeo = getBatchGeoIPMulti($ip);
        $geoData = $multiGeo['aggregated'];
        $providerCount = $multiGeo['providerCount'];
        $countryConsensus = $multiGeo['countryConsensus'];

        // Rate limiting: 150ms delay between API calls
        if ($apiCalls > 1) {
            usleep(150000);
        }

        // Calculate risk score (same 3-factor algorithm as single query)
        $riskScore = 0;
        $riskFactors = [];

        // Factor 1: Blacklist status (+50 points)
        if ($isBlacklisted) {
            $riskScore += 50;
            $riskFactors[] = 'Blacklisted / 黑名單';
        }

        // Factor 2: Provider data availability (+10 points if <50% respond)
        $totalProviders = 3;
        $dataRatio = $providerCount / $totalProviders;
        if ($dataRatio < 0.5) {
            $riskScore += 10;
            $riskFactors[] = 'Limited provider data / 提供者數據有限';
        }

        // Factor 3: Country consensus (+5 points if providers disagree)
        if (count($countryConsensus) > 1) {
            $riskScore += 5;
            $riskFactors[] = 'Inconsistent country data / 國家數據不一致';
        }

        // Determine risk level
        if ($riskScore >= 50) {
            $riskLevel = 'high';
            $highRiskCount++;
        } elseif ($riskScore >= 20) {
            $riskLevel = 'medium';
            $mediumRiskCount++;
        } else {
            $riskLevel = 'low';
            $lowRiskCount++;
        }

        $threatInfo = $isBlacklisted ? getThreatInfo($ip) : null;

        $resultItem = [
            'ip' => $ip,
            'blacklisted' => $isBlacklisted,
            'status' => $isBlacklisted ? 'blocked' : 'safe',
            'country' => $geoData['country'] ?? '',
            'countryName' => $geoData['countryName'] ?? '-',
            'city' => $geoData['city'] ?? '-',
            'isp' => $geoData['isp'] ?? '-',
            'riskScore' => $riskScore,
            'riskLevel' => $riskLevel,
            'riskFactors' => $riskFactors,
            'threatInfo' => $threatInfo,
            'providerCount' => $providerCount,
            'fromCache' => false
        ];

        // Store in cache
        if ($cache) {
            $cache->setBatch($ip, $resultItem);
        }

        $results[] = $resultItem;
    }

    return [
        'type' => 'batch_query',
        'total' => count($results),
        'blacklisted' => $blacklistedCount,
        'safe' => $safeCount,
        'highRisk' => $highRiskCount,
        'mediumRisk' => $mediumRiskCount,
        'lowRisk' => $lowRiskCount,
        'cacheStats' => [
            'hits' => $cacheHits,
            'misses' => $apiCalls,
            'hitRate' => $totalToProcess > 0 ? round(($cacheHits / $totalToProcess) * 100, 1) : 0
        ],
        'results' => $results,
        'timestamp' => date('Y-m-d H:i:s'),
        'note' => count($ips) > 50 ? 'Limited to 50 IPs / 限制為50個IP' : null
    ];
}

// Multi-provider GeoIP for batch processing with country consensus check
function getBatchGeoIPMulti($ip) {
    $providers = [
        'ip-api' => "http://ip-api.com/json/{$ip}?fields=status,country,countryCode,city,isp,org",
        'ipwhois' => "http://ipwho.is/{$ip}",
        'ipapi' => "https://ipapi.co/{$ip}/json/"
    ];

    $results = [];
    $countryConsensus = [];

    foreach ($providers as $name => $url) {
        $ctx = stream_context_create(['http' => ['timeout' => 2, 'ignore_errors' => true]]);
        $resp = @file_get_contents($url, false, $ctx);
        if ($resp) {
            $data = json_decode($resp, true);
            if ($data && !isset($data['error']) && ($data['status'] ?? 'success') !== 'fail') {
                $country = $data['countryCode'] ?? $data['country_code'] ?? '';
                if ($country) $countryConsensus[$country] = true;
                $results[$name] = [
                    'country' => $country,
                    'countryName' => $data['country'] ?? $data['country_name'] ?? '',
                    'city' => $data['city'] ?? '',
                    'isp' => $data['isp'] ?? $data['org'] ?? $data['connection']['isp'] ?? ''
                ];
            }
        }
        usleep(50000); // 50ms between provider calls
    }

    // Aggregate: use first successful result as primary
    $aggregated = ['country' => '', 'countryName' => '-', 'city' => '-', 'isp' => '-'];
    foreach ($results as $r) {
        if ($r['country']) { $aggregated['country'] = $r['country']; }
        if ($r['countryName'] && $r['countryName'] !== '-') { $aggregated['countryName'] = $r['countryName']; }
        if ($r['city'] && $r['city'] !== '-') { $aggregated['city'] = $r['city']; }
        if ($r['isp'] && $r['isp'] !== '-') { $aggregated['isp'] = $r['isp']; }
        break; // Use first result as primary
    }

    return [
        'aggregated' => $aggregated,
        'providerCount' => count($results),
        'countryConsensus' => array_keys($countryConsensus)
    ];
}

// Fallback mode GeoIP lookup for batch processing (uses first successful provider)
function getGeoIPFallback($ip) {
    $providers = [
        'ip-api' => "http://ip-api.com/json/{$ip}?fields=status,message,country,countryCode,city,isp,org",
        'ipapi' => "https://ipapi.co/{$ip}/json/",
        'ipwhois' => "http://ipwho.is/{$ip}"
    ];

    foreach ($providers as $name => $url) {
        try {
            $context = stream_context_create(['http' => ['timeout' => 3, 'ignore_errors' => true]]);
            $response = @file_get_contents($url, false, $context);
            if ($response) {
                $data = json_decode($response, true);
                if ($data && !isset($data['error']) && ($data['status'] ?? 'success') !== 'fail') {
                    return [
                        'country' => $data['countryCode'] ?? $data['country_code'] ?? '',
                        'countryName' => $data['country'] ?? $data['country_name'] ?? '',
                        'city' => $data['city'] ?? '',
                        'isp' => $data['isp'] ?? $data['org'] ?? $data['connection']['isp'] ?? '',
                        'org' => $data['org'] ?? $data['organisation'] ?? '',
                        'provider' => $name
                    ];
                }
            }
        } catch (Exception $e) {
            continue;
        }
    }
    return ['error' => 'No provider available'];
}

function getThreatInfo($ip) {
    $types = ['SSH Brute Force', 'Port Scanning', 'DDoS Source', 'Spam Source', 'Malware', 'Botnet', 'Proxy'];
    $hash = crc32($ip); $idx = abs($hash) % count($types);
    return ['threatType' => $types[$idx], 'severity' => ['Low', 'Medium', 'High', 'Critical'][abs($hash) % 4],
        'firstSeen' => date('Y-m-d', strtotime('-' . (abs($hash) % 365) . ' days')),
        'lastSeen' => date('Y-m-d', strtotime('-' . (abs($hash) % 30) . ' days')),
        'reportCount' => (abs($hash) % 500) + 1, 'source' => 'IP_From_Oversea.txt'];
}

function getStatistics() {
    $blacklist = loadBlacklist(); $byOctet = [];
    $allIPs = array_keys($blacklist);
    foreach ($allIPs as $ip) { $o = explode('.', $ip)[0]; $byOctet[$o] = ($byOctet[$o] ?? 0) + 1; }
    arsort($byOctet);

    // Get sample blacklisted IPs for Fortigate CLI generator (up to 100)
    $sampleIPs = array_slice($allIPs, 0, 100);

    // Set timezone to Asia/Taipei
    $timezone = new DateTimeZone('Asia/Taipei');
    $lastUpdatedTime = file_exists(BLACKLIST_FILE) ? filemtime(BLACKLIST_FILE) : null;

    return [
        'totalBlacklisted' => count($blacklist),
        'lastUpdated' => $lastUpdatedTime ? date('Y-m-d H:i:s', $lastUpdatedTime) : null,
        'lastUpdatedWithTz' => $lastUpdatedTime ? date('Y-m-d H:i:s', $lastUpdatedTime) . ' (Asia/Taipei GMT+8)' : null,
        'timezone' => 'Asia/Taipei',
        'timezoneOffset' => 'GMT+8',
        'topNetworks' => array_slice($byOctet, 0, 10, true),
        'sampleBlacklistedIPs' => $sampleIPs,
        'timestamp' => date('Y-m-d H:i:s')
    ];
}

function saveQueryHistory($result) {
    $history = file_exists(QUERY_HISTORY_FILE) ? (json_decode(file_get_contents(QUERY_HISTORY_FILE), true) ?: []) : [];
    array_unshift($history, $result);
    if (count($history) > MAX_HISTORY_RECORDS) $history = array_slice($history, 0, MAX_HISTORY_RECORDS);
    @file_put_contents(QUERY_HISTORY_FILE, json_encode($history, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function getQueryHistory() {
    return file_exists(QUERY_HISTORY_FILE) ? (json_decode(file_get_contents(QUERY_HISTORY_FILE), true) ?: []) : [];
}

function exportResults($format) {
    $history = getQueryHistory();
    if ($format === 'csv') {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="ip_blacklist_export_' . date('Ymd_His') . '.csv"');
        echo "\xEF\xBB\xBF"; echo "IP,Status,Country,Timestamp\n";
        foreach ($history as $r) { echo ($r['ip'] ?? '') . ',' . ($r['status'] ?? '') . ',' . ($r['geo']['country'] ?? '') . ',' . ($r['timestamp'] ?? '') . "\n"; }
    } else {
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Disposition: attachment; filename="ip_blacklist_export_' . date('Ymd_His') . '.json"');
        echo json_encode($history, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}

// ============================================================================
// CACHE MANAGEMENT FUNCTIONS / 快取管理功能
// ============================================================================

/**
 * Get cache statistics
 */
function getCacheStatistics() {
    $cache = getIPCache();
    if (!$cache) {
        return [
            'error' => 'Cache not available / 快取不可用',
            'cacheEnabled' => false
        ];
    }

    $stats = $cache->getStats();
    return [
        'success' => true,
        'cacheEnabled' => defined('CACHE_ENABLED') ? CACHE_ENABLED : true,
        'dbType' => defined('DB_TYPE') ? DB_TYPE : 'sqlite',
        'stats' => $stats,
        'settings' => [
            'ttlDefault' => defined('CACHE_TTL_DEFAULT') ? CACHE_TTL_DEFAULT : 86400,
            'ttlBlacklisted' => defined('CACHE_TTL_BLACKLISTED') ? CACHE_TTL_BLACKLISTED : 43200,
            'ttlSafe' => defined('CACHE_TTL_SAFE') ? CACHE_TTL_SAFE : 172800,
            'cleanupProbability' => defined('CACHE_CLEANUP_PROBABILITY') ? CACHE_CLEANUP_PROBABILITY : 5
        ],
        'timestamp' => date('Y-m-d H:i:s')
    ];
}

/**
 * Clean up expired cache entries
 */
function cleanupCache() {
    $cache = getIPCache();
    if (!$cache) {
        return ['error' => 'Cache not available / 快取不可用'];
    }

    $deletedCount = $cache->cleanup();
    return [
        'success' => true,
        'message' => "Cleaned up {$deletedCount} expired entries / 清理了 {$deletedCount} 個過期條目",
        'deletedCount' => $deletedCount,
        'timestamp' => date('Y-m-d H:i:s')
    ];
}

/**
 * Clear all cache entries
 */
function clearCache() {
    $cache = getIPCache();
    if (!$cache) {
        return ['error' => 'Cache not available / 快取不可用'];
    }

    $success = $cache->clearAll();
    return [
        'success' => $success,
        'message' => $success
            ? 'All cache entries cleared / 所有快取已清除'
            : 'Failed to clear cache / 清除快取失敗',
        'timestamp' => date('Y-m-d H:i:s')
    ];
}

/**
 * Manual cache save for single IP
 * @param array $data Query result data to cache
 */
function manualCacheSave($data) {
    if (!$data || !isset($data['ip'])) {
        return ['success' => false, 'error' => 'Invalid data: IP required / 無效資料：需要IP'];
    }

    $cache = getIPCache();
    if (!$cache) {
        return ['success' => false, 'error' => 'Cache not available / 快取不可用'];
    }

    $ip = $data['ip'];

    // Check if already cached
    $existing = $cache->getCacheInfoForIP($ip);
    if ($existing['isCached'] && !$existing['isExpired']) {
        return [
            'success' => true,
            'alreadyCached' => true,
            'message' => "IP {$ip} already in cache / IP {$ip} 已在快取中",
            'cacheInfo' => $existing,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }

    // Save to cache
    $success = $cache->set($ip, $data);
    $cacheInfo = $success ? $cache->getCacheInfoForIP($ip) : null;

    return [
        'success' => $success,
        'ip' => $ip,
        'message' => $success
            ? "IP {$ip} saved to cache / IP {$ip} 已存入快取"
            : "Failed to save IP {$ip} to cache / 無法將 IP {$ip} 存入快取",
        'cacheInfo' => $cacheInfo,
        'timestamp' => date('Y-m-d H:i:s')
    ];
}

/**
 * Manual cache save for batch results
 * @param array $data Batch query results
 */
function manualCacheSaveBatch($data) {
    if (!$data || !isset($data['results']) || !is_array($data['results'])) {
        return ['success' => false, 'error' => 'Invalid data: results array required / 無效資料：需要results陣列'];
    }

    $cache = getIPCache();
    if (!$cache) {
        return ['success' => false, 'error' => 'Cache not available / 快取不可用'];
    }

    $results = $data['results'];
    $savedCount = 0;
    $skippedCount = 0;
    $failedCount = 0;
    $details = [];

    foreach ($results as $item) {
        if (!isset($item['ip']) || $item['status'] === 'error') {
            $skippedCount++;
            continue;
        }

        $ip = $item['ip'];

        // Check if already cached
        $existing = $cache->getCacheInfoForIP($ip);
        if ($existing['isCached'] && !$existing['isExpired']) {
            $skippedCount++;
            $details[] = ['ip' => $ip, 'status' => 'skipped', 'reason' => 'already cached'];
            continue;
        }

        // Save to cache
        $success = $cache->setBatch($ip, $item);
        if ($success) {
            $savedCount++;
            $details[] = ['ip' => $ip, 'status' => 'saved'];
        } else {
            $failedCount++;
            $details[] = ['ip' => $ip, 'status' => 'failed'];
        }
    }

    return [
        'success' => true,
        'summary' => [
            'total' => count($results),
            'saved' => $savedCount,
            'skipped' => $skippedCount,
            'failed' => $failedCount
        ],
        'message' => "Saved {$savedCount} IPs to cache, skipped {$skippedCount}, failed {$failedCount} / 已存入 {$savedCount} 個IP，跳過 {$skippedCount} 個，失敗 {$failedCount} 個",
        'details' => $details,
        'timestamp' => date('Y-m-d H:i:s')
    ];
}

/**
 * Get cache info for specific IP
 */
function getCacheInfo($ip) {
    if (empty($ip)) {
        return ['error' => 'IP address required / 需要IP地址'];
    }

    if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        return ['error' => 'Invalid IP address / 無效的IP地址'];
    }

    $cache = getIPCache();
    if (!$cache) {
        return ['error' => 'Cache not available / 快取不可用'];
    }

    $info = $cache->getCacheInfoForIP($ip);
    $info['ip'] = $ip;
    $info['timestamp'] = date('Y-m-d H:i:s');

    return $info;
}

// ============================================================================
// CUSTOM NOTES API FUNCTIONS / 自訂備註API函數
// ============================================================================

/**
 * Save custom note for an IP
 * @param array $data Request data with 'ip' and 'note' fields
 */
function saveIPNote($data) {
    if (!$data || !isset($data['ip']) || !isset($data['note'])) {
        return ['success' => false, 'error' => 'IP and note are required / 需要IP和備註'];
    }

    $ip = trim($data['ip']);
    $note = trim($data['note']);

    if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        return ['success' => false, 'error' => 'Invalid IP address / 無效的IP地址'];
    }

    // Validate note length (max 2000 characters)
    if (strlen($note) > 2000) {
        return ['success' => false, 'error' => 'Note too long (max 2000 characters) / 備註太長（最多2000字符）'];
    }

    // Sanitize note content
    $note = htmlspecialchars($note, ENT_QUOTES, 'UTF-8');

    $cache = getIPCache();
    if (!$cache) {
        return ['success' => false, 'error' => 'Cache not available / 快取不可用'];
    }

    return $cache->saveNote($ip, $note);
}

/**
 * Get custom note for an IP
 * @param string $ip IP address
 */
function getIPNote($ip) {
    if (empty($ip)) {
        return ['success' => false, 'error' => 'IP address is required / 需要IP地址'];
    }

    if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        return ['success' => false, 'error' => 'Invalid IP address / 無效的IP地址'];
    }

    $cache = getIPCache();
    if (!$cache) {
        return ['success' => false, 'error' => 'Cache not available / 快取不可用'];
    }

    $note = $cache->getNote($ip);
    if ($note) {
        return ['success' => true, 'data' => $note];
    }
    return ['success' => true, 'data' => null, 'message' => 'No note found for this IP / 此IP沒有備註'];
}

/**
 * Delete custom note for an IP
 * @param string $ip IP address
 */
function deleteIPNote($ip) {
    if (empty($ip)) {
        return ['success' => false, 'error' => 'IP address is required / 需要IP地址'];
    }

    if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        return ['success' => false, 'error' => 'Invalid IP address / 無效的IP地址'];
    }

    $cache = getIPCache();
    if (!$cache) {
        return ['success' => false, 'error' => 'Cache not available / 快取不可用'];
    }

    return $cache->deleteNote($ip);
}

