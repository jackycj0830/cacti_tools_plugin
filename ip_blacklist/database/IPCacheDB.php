<?php
/**
 * IP Blacklist Query System - Database Cache Manager
 * @version 1.0.0
 * 
 * Handles all database operations for IP caching.
 */

require_once __DIR__ . '/db_config.php';

class IPCacheDB {
    private static $instance = null;
    private $pdo = null;
    private $initialized = false;

    private function __construct() {
        $this->connect();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect() {
        try {
            if (DB_TYPE === 'sqlite') {
                $this->pdo = new PDO('sqlite:' . SQLITE_DB_PATH);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo->exec('PRAGMA journal_mode=WAL');
                $this->pdo->exec('PRAGMA synchronous=NORMAL');
            } else {
                $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=%s',
                    MYSQL_HOST, MYSQL_PORT, MYSQL_DATABASE, MYSQL_CHARSET);
                $this->pdo = new PDO($dsn, MYSQL_USERNAME, MYSQL_PASSWORD, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            }
            $this->initializeDatabase();
        } catch (PDOException $e) {
            $this->logError('Connection failed: ' . $e->getMessage());
            throw $e;
        }
    }

    private function initializeDatabase() {
        if ($this->initialized) return;
        
        $sql = DB_TYPE === 'sqlite' ? $this->getSQLiteSchema() : $this->getMySQLSchema();
        
        try {
            $statements = array_filter(array_map('trim', explode(';', $sql)));
            foreach ($statements as $stmt) {
                if (!empty($stmt)) {
                    $this->pdo->exec($stmt);
                }
            }
            $this->initialized = true;
        } catch (PDOException $e) {
            $this->logError('Schema init failed: ' . $e->getMessage());
        }
    }

    private function getSQLiteSchema() {
        return "
            CREATE TABLE IF NOT EXISTS ip_cache (
                ip_address TEXT PRIMARY KEY,
                is_blacklisted INTEGER DEFAULT 0,
                status TEXT DEFAULT 'safe',
                country_code TEXT, country_name TEXT, city TEXT, region TEXT,
                isp TEXT, org TEXT, asn TEXT,
                latitude REAL, longitude REAL, timezone TEXT,
                risk_score INTEGER DEFAULT 0, risk_level TEXT DEFAULT 'low',
                risk_factors TEXT, threat_info TEXT, provider_results TEXT,
                providers_queried INTEGER DEFAULT 0, providers_responded INTEGER DEFAULT 0,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP,
                updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
                expires_at TEXT, hit_count INTEGER DEFAULT 0
            );
            CREATE INDEX IF NOT EXISTS idx_expires ON ip_cache(expires_at);
            CREATE INDEX IF NOT EXISTS idx_status ON ip_cache(status);
            CREATE TABLE IF NOT EXISTS cache_stats (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                stat_date TEXT UNIQUE, total_queries INTEGER DEFAULT 0,
                cache_hits INTEGER DEFAULT 0, cache_misses INTEGER DEFAULT 0,
                api_calls_saved INTEGER DEFAULT 0,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP
            )
        ";
    }

    private function getMySQLSchema() {
        return "
            CREATE TABLE IF NOT EXISTS ip_cache (
                ip_address VARCHAR(45) PRIMARY KEY,
                is_blacklisted BOOLEAN DEFAULT 0, status VARCHAR(20) DEFAULT 'safe',
                country_code VARCHAR(10), country_name VARCHAR(100),
                city VARCHAR(100), region VARCHAR(100),
                isp VARCHAR(255), org VARCHAR(255), asn VARCHAR(50),
                latitude DECIMAL(10,8), longitude DECIMAL(11,8), timezone VARCHAR(50),
                risk_score INTEGER DEFAULT 0, risk_level VARCHAR(20) DEFAULT 'low',
                risk_factors TEXT, threat_info TEXT, provider_results TEXT,
                providers_queried INTEGER DEFAULT 0, providers_responded INTEGER DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                expires_at DATETIME, hit_count INTEGER DEFAULT 0,
                INDEX idx_expires (expires_at), INDEX idx_status (status)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            CREATE TABLE IF NOT EXISTS cache_stats (
                id INTEGER PRIMARY KEY AUTO_INCREMENT,
                stat_date DATE UNIQUE, total_queries INTEGER DEFAULT 0,
                cache_hits INTEGER DEFAULT 0, cache_misses INTEGER DEFAULT 0,
                api_calls_saved INTEGER DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";
    }

    public function getPDO() { return $this->pdo; }

    private function logError($msg) {
        if (CACHE_LOG_ENABLED) {
            $log = sprintf("[%s] ERROR: %s\n", date('Y-m-d H:i:s'), $msg);
            @file_put_contents(CACHE_LOG_FILE, $log, FILE_APPEND);
        }
    }

    // Prevent cloning
    private function __clone() {}
    public function __wakeup() { throw new Exception("Cannot unserialize"); }
}

