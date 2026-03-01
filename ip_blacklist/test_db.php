<?php
/**
 * Database Connection Test Script
 * 測試 MySQL/SQLite 連接及表結構
 */

require_once __DIR__ . '/database/IPCacheDB.php';

echo "=================================\n";
echo " IP Blacklist DB Connection Test\n";
echo "=================================\n\n";

echo "DB Type: " . DB_TYPE . "\n";
if (DB_TYPE === 'mysql') {
    echo "MySQL Host: " . MYSQL_HOST . "\n";
    echo "MySQL Port: " . MYSQL_PORT . "\n";
    echo "MySQL DB:   " . MYSQL_DATABASE . "\n";
    echo "MySQL User: " . MYSQL_USERNAME . "\n";
} else {
    echo "SQLite Path: " . SQLITE_DB_PATH . "\n";
}
echo "\n";

$inst = IPCacheDB::getInstance();
if ($inst->isConnected()) {
    echo "✅ Database connected successfully!\n\n";
    $pdo = $inst->getPDO();
    
    // Show tables
    if (DB_TYPE === 'mysql') {
        $stmt = $pdo->query("SHOW TABLES");
    } else {
        $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name");
    }
    
    echo "Tables found:\n";
    $count = 0;
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        echo "  ✓ " . $row[0] . "\n";
        $count++;
    }
    echo "\nTotal: {$count} tables\n";
    
    // Quick data check
    echo "\n--- Data Summary ---\n";
    try {
        $c1 = $pdo->query("SELECT COUNT(*) FROM ip_cache")->fetchColumn();
        echo "ip_cache:       {$c1} records\n";
    } catch (Exception $e) {
        echo "ip_cache:       (error: " . $e->getMessage() . ")\n";
    }
    try {
        $c2 = $pdo->query("SELECT COUNT(*) FROM ip_database")->fetchColumn();
        echo "ip_database:    {$c2} records\n";
    } catch (Exception $e) {
        echo "ip_database:    (error: " . $e->getMessage() . ")\n";
    }
    try {
        $c3 = $pdo->query("SELECT COUNT(*) FROM faz_raw_events")->fetchColumn();
        echo "faz_raw_events: {$c3} records\n";
    } catch (Exception $e) {
        echo "faz_raw_events: (error: " . $e->getMessage() . ")\n";
    }
    try {
        $c4 = $pdo->query("SELECT COUNT(*) FROM faz_logs")->fetchColumn();
        echo "faz_logs:       {$c4} records\n";
    } catch (Exception $e) {
        echo "faz_logs:       (error: " . $e->getMessage() . ")\n";
    }
    
    echo "\n✅ All checks passed!\n";
} else {
    echo "❌ Connection FAILED\n";
    echo "Error: " . $inst->getConnectionError() . "\n\n";
    
    if (DB_TYPE === 'mysql') {
        echo "Troubleshooting:\n";
        echo "  1. Is MySQL/MariaDB service running? Check: net start mysql\n";
        echo "  2. Can you connect manually? mysql -u " . MYSQL_USERNAME . " -p -h " . MYSQL_HOST . "\n";
        echo "  3. Does the database exist? CREATE DATABASE IF NOT EXISTS " . MYSQL_DATABASE . ";\n";
        echo "  4. Are the credentials correct in database/db_config.php?\n\n";
        echo "Quick fix for local testing: change DB_TYPE to 'sqlite' in database/db_config.php\n";
    }
}
