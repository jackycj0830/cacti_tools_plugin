-- ============================================================================
-- VirusTotal API Key Storage - Database Schema
-- Version: 1.0.0
-- Database: ip_blacklist (existing)
-- Description: Stores VirusTotal API keys for shared/persistent access
-- ============================================================================

-- ============================================================================
-- API Keys Table - Stores API keys with metadata
-- ============================================================================
CREATE TABLE IF NOT EXISTS api_keys (
    id INT AUTO_INCREMENT PRIMARY KEY,

    -- Key identification
    service_name VARCHAR(50) NOT NULL DEFAULT 'virustotal'
        COMMENT 'Service identifier (e.g. virustotal, abuseipdb)',
    key_label VARCHAR(100) DEFAULT NULL
        COMMENT 'Optional user-defined label for the key',

    -- API key value (encrypted or plain — production should encrypt)
    api_key VARCHAR(255) NOT NULL
        COMMENT 'The actual API key string',

    -- Status & metadata
    is_active TINYINT(1) NOT NULL DEFAULT 1
        COMMENT '1=active, 0=disabled',
    last_used_at DATETIME DEFAULT NULL
        COMMENT 'Timestamp of last successful usage',
    usage_count INT NOT NULL DEFAULT 0
        COMMENT 'Total number of times this key has been used',

    -- Timestamps
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Indexes
    INDEX idx_service (service_name),
    INDEX idx_active (is_active),
    UNIQUE KEY uk_service_key (service_name, api_key(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
  COMMENT='Stores API keys for external services (VirusTotal, etc.)';

