-- ============================================================================
-- IP Blacklist System - Complete MySQL Schema
-- ============================================================================
-- This file creates ALL required tables for the ip_blacklist system.
-- Run this against your MySQL server to initialize the database.
--
-- Usage:
--   mysql -u root -p ip_blacklist < faz_mysql_schema.sql
-- ============================================================================

-- 1. IP Cache table (VT results + blacklist status)
--    Replaces the old vt_cache.db SQLite tables (vt_ip_cache, vt_blacklist)
CREATE TABLE IF NOT EXISTS ip_cache (
    ip_address VARCHAR(45) PRIMARY KEY,
    is_blacklisted BOOLEAN DEFAULT 0,
    status VARCHAR(20) DEFAULT 'safe',
    country_code VARCHAR(10),
    country_name VARCHAR(100),
    city VARCHAR(100),
    region VARCHAR(100),
    isp VARCHAR(255),
    org VARCHAR(255),
    asn VARCHAR(50),
    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8),
    timezone VARCHAR(50),
    risk_score INTEGER DEFAULT 0,
    risk_level VARCHAR(20) DEFAULT 'low',
    risk_factors TEXT,
    threat_info TEXT,
    provider_results TEXT,
    providers_queried INTEGER DEFAULT 0,
    providers_responded INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    expires_at DATETIME,
    hit_count INTEGER DEFAULT 0,
    custom_note TEXT,
    note_created_at DATETIME,
    note_updated_at DATETIME,
    vt_malicious INT DEFAULT NULL,
    vt_suspicious INT DEFAULT NULL,
    vt_harmless INT DEFAULT NULL,
    vt_undetected INT DEFAULT NULL,
    vt_detection_flagged INT DEFAULT NULL,
    vt_detection_total INT DEFAULT NULL,
    vt_link VARCHAR(255) DEFAULT NULL,
    vt_queried_at DATETIME DEFAULT NULL,
    INDEX idx_expires (expires_at),
    INDEX idx_status (status),
    INDEX idx_risk_level (risk_level),
    INDEX idx_country (country_code),
    INDEX idx_blacklisted (is_blacklisted)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Cache Statistics
CREATE TABLE IF NOT EXISTS cache_stats (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    stat_date DATE UNIQUE,
    total_queries INTEGER DEFAULT 0,
    cache_hits INTEGER DEFAULT 0,
    cache_misses INTEGER DEFAULT 0,
    api_calls_saved INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. IP Archive Database (archived historical records)
CREATE TABLE IF NOT EXISTS ip_database (
    ip_address VARCHAR(45) PRIMARY KEY,
    is_blacklisted BOOLEAN DEFAULT 0,
    status VARCHAR(20) DEFAULT 'safe',
    country_code VARCHAR(10),
    country_name VARCHAR(100),
    city VARCHAR(100),
    region VARCHAR(100),
    isp VARCHAR(255),
    org VARCHAR(255),
    asn VARCHAR(50),
    latitude DECIMAL(10,8),
    longitude DECIMAL(11,8),
    timezone VARCHAR(50),
    risk_score INTEGER DEFAULT 0,
    risk_level VARCHAR(20) DEFAULT 'low',
    risk_factors TEXT,
    threat_info TEXT,
    provider_results TEXT,
    providers_queried INTEGER DEFAULT 0,
    providers_responded INTEGER DEFAULT 0,
    original_created_at DATETIME,
    original_expires_at DATETIME,
    archived_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_hit_count INTEGER DEFAULT 0,
    custom_note TEXT,
    note_created_at DATETIME,
    note_updated_at DATETIME,
    vt_malicious INT DEFAULT NULL,
    vt_suspicious INT DEFAULT NULL,
    vt_harmless INT DEFAULT NULL,
    vt_undetected INT DEFAULT NULL,
    vt_detection_flagged INT DEFAULT NULL,
    vt_detection_total INT DEFAULT NULL,
    vt_link VARCHAR(255) DEFAULT NULL,
    vt_queried_at DATETIME DEFAULT NULL,
    INDEX idx_archive_status (status),
    INDEX idx_archive_risk (risk_level),
    INDEX idx_archive_country (country_code),
    INDEX idx_archive_date (archived_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. FAZ Raw Events (replaces faz_raw_events from vt_cache.db SQLite)
--    Stores individual SSLVPN failed login events from FortiAnalyzer
CREATE TABLE IF NOT EXISTS faz_raw_events (
    ip VARCHAR(45) NOT NULL,
    timestamp DATETIME NOT NULL,
    UNIQUE KEY unique_ip_ts (ip, timestamp),
    INDEX idx_ts (timestamp),
    INDEX idx_ip (ip)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. FAZ Logs (replaces faz_logs from vt_cache.db SQLite)
--    Stores aggregated run summaries
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
