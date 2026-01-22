-- ============================================================================
-- IP Blacklist Query System - Database Schema
-- Version: 1.0.0
-- Description: SQLite/MySQL compatible schema for IP query caching
-- ============================================================================

-- ============================================================================
-- IP Cache Table - Stores cached IP query results
-- ============================================================================
CREATE TABLE IF NOT EXISTS ip_cache (
    ip_address VARCHAR(45) PRIMARY KEY,
    
    -- Blacklist Status
    is_blacklisted BOOLEAN DEFAULT 0,
    status VARCHAR(20) DEFAULT 'safe',
    
    -- GeoIP Information (aggregated from providers)
    country_code VARCHAR(10),
    country_name VARCHAR(100),
    city VARCHAR(100),
    region VARCHAR(100),
    isp VARCHAR(255),
    org VARCHAR(255),
    asn VARCHAR(50),
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    timezone VARCHAR(50),
    
    -- Risk Analysis Data
    risk_score INTEGER DEFAULT 0,
    risk_level VARCHAR(20) DEFAULT 'low',
    risk_factors TEXT,
    
    -- Threat Information (JSON)
    threat_info TEXT,
    
    -- Provider Data (JSON - stores all provider results)
    provider_results TEXT,
    providers_queried INTEGER DEFAULT 0,
    providers_responded INTEGER DEFAULT 0,
    
    -- Cache Metadata
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME,
    hit_count INTEGER DEFAULT 0,

    -- Custom Notes/Annotations for blacklisted IPs
    custom_note TEXT,
    note_created_at DATETIME,
    note_updated_at DATETIME,

    -- Indexes
    INDEX idx_expires (expires_at),
    INDEX idx_status (status),
    INDEX idx_risk_level (risk_level),
    INDEX idx_country (country_code)
);

-- ============================================================================
-- Cache Statistics Table - Tracks cache performance
-- ============================================================================
CREATE TABLE IF NOT EXISTS cache_stats (
    id INTEGER PRIMARY KEY AUTO_INCREMENT,
    stat_date DATE UNIQUE,
    total_queries INTEGER DEFAULT 0,
    cache_hits INTEGER DEFAULT 0,
    cache_misses INTEGER DEFAULT 0,
    api_calls_saved INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================================
-- API Rate Limit Tracking Table
-- ============================================================================
CREATE TABLE IF NOT EXISTS api_rate_limits (
    provider_id VARCHAR(50) PRIMARY KEY,
    provider_name VARCHAR(100),
    calls_today INTEGER DEFAULT 0,
    calls_this_minute INTEGER DEFAULT 0,
    last_call_at DATETIME,
    reset_daily_at DATETIME,
    reset_minute_at DATETIME
);

-- ============================================================================
-- IP Database (Archive) Table - Stores archived IP data from expired cache
-- ============================================================================
CREATE TABLE IF NOT EXISTS ip_database (
    ip_address VARCHAR(45) PRIMARY KEY,

    -- Blacklist Status
    is_blacklisted BOOLEAN DEFAULT 0,
    status VARCHAR(20) DEFAULT 'safe',

    -- GeoIP Information
    country_code VARCHAR(10),
    country_name VARCHAR(100),
    city VARCHAR(100),
    region VARCHAR(100),
    isp VARCHAR(255),
    org VARCHAR(255),
    asn VARCHAR(50),
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    timezone VARCHAR(50),

    -- Risk Analysis Data
    risk_score INTEGER DEFAULT 0,
    risk_level VARCHAR(20) DEFAULT 'low',
    risk_factors TEXT,

    -- Threat Information (JSON)
    threat_info TEXT,

    -- Provider Data
    provider_results TEXT,
    providers_queried INTEGER DEFAULT 0,
    providers_responded INTEGER DEFAULT 0,

    -- Archive Metadata
    original_created_at DATETIME,
    original_expires_at DATETIME,
    archived_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    total_hit_count INTEGER DEFAULT 0,

    -- Custom Notes
    custom_note TEXT,
    note_created_at DATETIME,
    note_updated_at DATETIME,

    -- Indexes
    INDEX idx_archive_status (status),
    INDEX idx_archive_risk (risk_level),
    INDEX idx_archive_country (country_code),
    INDEX idx_archive_date (archived_at),
    INDEX idx_archive_blacklisted (is_blacklisted)
);

-- ============================================================================
-- SQLite-specific version (no AUTO_INCREMENT, uses AUTOINCREMENT)
-- ============================================================================
-- For SQLite, run these instead:
--
-- CREATE TABLE IF NOT EXISTS ip_cache (
--     ip_address TEXT PRIMARY KEY,
--     is_blacklisted INTEGER DEFAULT 0,
--     status TEXT DEFAULT 'safe',
--     country_code TEXT,
--     country_name TEXT,
--     city TEXT,
--     region TEXT,
--     isp TEXT,
--     org TEXT,
--     asn TEXT,
--     latitude REAL,
--     longitude REAL,
--     timezone TEXT,
--     risk_score INTEGER DEFAULT 0,
--     risk_level TEXT DEFAULT 'low',
--     risk_factors TEXT,
--     threat_info TEXT,
--     provider_results TEXT,
--     providers_queried INTEGER DEFAULT 0,
--     providers_responded INTEGER DEFAULT 0,
--     created_at TEXT DEFAULT CURRENT_TIMESTAMP,
--     updated_at TEXT DEFAULT CURRENT_TIMESTAMP,
--     expires_at TEXT,
--     hit_count INTEGER DEFAULT 0,
--     custom_note TEXT,
--     note_created_at TEXT,
--     note_updated_at TEXT
-- );
--
-- CREATE INDEX idx_expires ON ip_cache(expires_at);
-- CREATE INDEX idx_status ON ip_cache(status);
-- CREATE INDEX idx_risk_level ON ip_cache(risk_level);
-- CREATE INDEX idx_country ON ip_cache(country_code);

-- ============================================================================
-- Migration SQL for existing databases
-- ============================================================================
-- Run these ALTER statements to add custom notes columns to existing tables:
--
-- MySQL:
-- ALTER TABLE ip_cache ADD COLUMN custom_note TEXT;
-- ALTER TABLE ip_cache ADD COLUMN note_created_at DATETIME;
-- ALTER TABLE ip_cache ADD COLUMN note_updated_at DATETIME;
--
-- SQLite:
-- ALTER TABLE ip_cache ADD COLUMN custom_note TEXT;
-- ALTER TABLE ip_cache ADD COLUMN note_created_at TEXT;
-- ALTER TABLE ip_cache ADD COLUMN note_updated_at TEXT;

