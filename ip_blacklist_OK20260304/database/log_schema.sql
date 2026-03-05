-- ============================================================
-- Log Table Schema for Bulk IP Blacklist + VirusTotal Query
-- File: ip_blacklist/database/log_schema.sql
-- Created: 2026-02-18
-- Description: MySQL table for storing query logs
-- ============================================================

-- Create log table (MySQL)
CREATE TABLE IF NOT EXISTS `log` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `log_time` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `log_level` VARCHAR(20) NOT NULL COMMENT 'info, warning, error, debug',
    `source` VARCHAR(50) NOT NULL COMMENT 'blacklist, virustotal, system',
    `ip_address` VARCHAR(45) DEFAULT NULL COMMENT 'Related IP address (if applicable)',
    `message` TEXT NOT NULL COMMENT 'Log message',
    `details` JSON DEFAULT NULL COMMENT 'Additional structured data (JSON)',
    INDEX `idx_log_time` (`log_time`),
    INDEX `idx_log_level` (`log_level`),
    INDEX `idx_log_source` (`source`),
    INDEX `idx_log_ip` (`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
COMMENT='Query activity logs for bulk_query_virustotal.php';

-- Note: This table is automatically created by getLogPDO() in
-- bulk_query_virustotal.php on first use. This script is provided
-- for manual deployment or pre-provisioning.

