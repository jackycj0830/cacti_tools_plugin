<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== Test Local Database Query ===\n\n";

// Test 1: Include files
echo "1. Loading IPCache...\n";
try {
    require_once __DIR__ . '/database/IPCache.php';
    echo "   OK\n\n";
} catch (Exception $e) {
    echo "   FAILED: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Test 2: Create IPCache
echo "2. Creating IPCache instance...\n";
try {
    $cache = new IPCache();
    echo "   OK\n\n";
} catch (Exception $e) {
    echo "   FAILED: " . $e->getMessage() . "\n";
    echo "   This means IPCacheDB::getPDO() threw an exception.\n";
    echo "   Check if DB_TYPE='" . DB_TYPE . "' and connection settings are correct.\n\n";
    
    // Try to diagnose directly
    echo "   Checking IPCacheDB directly...\n";
    $db = IPCacheDB::getInstance();
    echo "   isConnected: " . ($db->isConnected() ? 'YES' : 'NO') . "\n";
    echo "   connectionError: " . ($db->getConnectionError() ?: 'none') . "\n\n";
    exit(1);
}

// Test 3: Check ip_database table
echo "3. Checking ip_database table...\n";
try {
    $db = IPCacheDB::getInstance();
    $pdo = $db->getPDO();
    
    if (DB_TYPE === 'sqlite') {
        $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='ip_database'");
    } else {
        $stmt = $pdo->query("SHOW TABLES LIKE 'ip_database'");
    }
    $exists = $stmt->fetch();
    echo "   Table exists: " . ($exists ? 'YES' : 'NO') . "\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as cnt FROM ip_database");
    $count = $stmt->fetch()['cnt'];
    echo "   Record count: {$count}\n\n";
} catch (Exception $e) {
    echo "   FAILED: " . $e->getMessage() . "\n\n";
}

// Test 4: Query a specific IP
echo "4. Testing queryLocal()...\n";
try {
    // Get first IP from database if any
    $pdo = IPCacheDB::getInstance()->getPDO();
    $stmt = $pdo->query("SELECT ip_address FROM ip_database LIMIT 1");
    $firstRow = $stmt->fetch();
    
    if ($firstRow) {
        $testIP = $firstRow['ip_address'];
        echo "   Test IP: {$testIP}\n";
        $result = $cache->queryLocal($testIP);
        if ($result) {
            echo "   Found! Keys: " . implode(', ', array_keys($result)) . "\n";
            echo "   status: " . ($result['status'] ?? 'N/A') . "\n";
            echo "   blacklisted: " . ($result['blacklisted'] ? 'YES' : 'NO') . "\n";
        } else {
            echo "   NOT FOUND (but IP exists in table!)\n";
        }
    } else {
        echo "   No records in ip_database to test with.\n";
    }
    echo "\n";
} catch (Exception $e) {
    echo "   FAILED: " . $e->getMessage() . "\n\n";
}

// Test 5: Test searchLocal
echo "5. Testing searchLocal()...\n";
try {
    $result = $cache->searchLocal([], 10, 0);
    echo "   success: " . ($result['success'] ? 'YES' : 'NO') . "\n";
    echo "   total: " . ($result['total'] ?? 'N/A') . "\n";
    echo "   count: " . ($result['count'] ?? 'N/A') . "\n";
    if (!empty($result['error'])) {
        echo "   error: " . $result['error'] . "\n";
    }
    echo "\n";
} catch (Exception $e) {
    echo "   FAILED: " . $e->getMessage() . "\n\n";
}

// Test 6: Test getArchiveStats
echo "6. Testing getArchiveStats()...\n";
try {
    $stats = $cache->getArchiveStats();
    if (isset($stats['error'])) {
        echo "   ERROR: " . $stats['error'] . "\n";
    } else {
        echo "   totalArchived: " . ($stats['totalArchived'] ?? 'N/A') . "\n";
        echo "   blacklistedCount: " . ($stats['blacklistedCount'] ?? 'N/A') . "\n";
        echo "   countryCount: " . ($stats['countryCount'] ?? 'N/A') . "\n";
    }
    echo "\n";
} catch (Exception $e) {
    echo "   FAILED: " . $e->getMessage() . "\n\n";
}

// Test 7: Test API endpoint via direct function call
echo "7. Testing api.php functions...\n";
try {
    require_once __DIR__ . '/api_dashboard.php';
    echo "   api_dashboard.php loaded OK\n";
    
    $dashDB = getDashDB();
    echo "   getDashDB(): " . ($dashDB ? 'OK' : 'NULL') . "\n";
} catch (Exception $e) {
    echo "   FAILED: " . $e->getMessage() . "\n";
}

echo "\n=== All tests complete ===\n";
echo "DB_TYPE: " . DB_TYPE . "\n";
