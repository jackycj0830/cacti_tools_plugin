<?php
/**
 * IP Blacklist Query System - Database Configuration
 * @version 1.0.0
 * 
 * Configure your database connection settings here.
 * Supports both SQLite (default) and MySQL.
 */

// ============================================================================
// DATABASE TYPE SELECTION
// ============================================================================
// Options: 'sqlite' (for local dev) or 'mysql' (for production)
// To override locally, create db_config_local.php with: define('DB_TYPE', 'sqlite');
if (file_exists(__DIR__ . '/db_config_local.php')) {
    require_once __DIR__ . '/db_config_local.php';
}
if (!defined('DB_TYPE')) {
    define('DB_TYPE', 'mysql');
}

// ============================================================================
// SQLITE CONFIGURATION (Default - No setup required)
// ============================================================================
define('SQLITE_DB_PATH', __DIR__ . '/ip_cache.db');

// ============================================================================
// MYSQL CONFIGURATION (For production environments)
// ============================================================================
define('MYSQL_HOST', 'localhost');
define('MYSQL_PORT', 3306);
define('MYSQL_DATABASE', 'ip_blacklist');
define('MYSQL_USERNAME', 'root');
define('MYSQL_PASSWORD', 'c@Ct1Vser');
define('MYSQL_CHARSET', 'utf8mb4');

// ============================================================================
// CACHE SETTINGS
// ============================================================================
// Cache TTL (Time To Live) in seconds
define('CACHE_TTL_DEFAULT', 86400);      // 24 hours for normal IPs
define('CACHE_TTL_BLACKLISTED', 43200);  // 12 hours for blacklisted IPs (check more frequently)
define('CACHE_TTL_SAFE', 172800);        // 48 hours for confirmed safe IPs

// Auto-cleanup settings
define('CACHE_CLEANUP_ENABLED', true);
define('CACHE_CLEANUP_PROBABILITY', 5);  // 5% chance to run cleanup on each request

// ============================================================================
// PERFORMANCE SETTINGS
// ============================================================================
define('CACHE_ENABLED', true);           // Set to false to disable caching entirely
define('CACHE_BATCH_SIZE', 100);         // Max IPs to cache in single transaction

// ============================================================================
// LOGGING SETTINGS
// ============================================================================
define('CACHE_LOG_ENABLED', true);
define('CACHE_LOG_FILE', __DIR__ . '/cache_log.txt');

