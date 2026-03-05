-- ============================================================================
-- IP Blacklist Query System - VirusTotal Fields Migration
-- Version: 2.7.0
-- Description: Add VirusTotal-specific columns to ip_cache and ip_database
-- ============================================================================
-- This script adds 8 new columns to store VirusTotal API query results.
-- Run this on existing databases. New installations will auto-create via IPCacheDB.php.
-- ============================================================================

-- ============================================================================
-- MySQL: ALTER TABLE ip_database — Add VirusTotal fields (archive table)
-- ============================================================================
ALTER TABLE ip_database ADD COLUMN vt_malicious INT DEFAULT NULL COMMENT 'VT: malicious vendor count';
ALTER TABLE ip_database ADD COLUMN vt_suspicious INT DEFAULT NULL COMMENT 'VT: suspicious vendor count';
ALTER TABLE ip_database ADD COLUMN vt_harmless INT DEFAULT NULL COMMENT 'VT: harmless vendor count';
ALTER TABLE ip_database ADD COLUMN vt_undetected INT DEFAULT NULL COMMENT 'VT: undetected vendor count';
ALTER TABLE ip_database ADD COLUMN vt_detection_flagged INT DEFAULT NULL COMMENT 'VT: flagged count (malicious + suspicious)';
ALTER TABLE ip_database ADD COLUMN vt_detection_total INT DEFAULT NULL COMMENT 'VT: total vendors queried';
ALTER TABLE ip_database ADD COLUMN vt_link VARCHAR(255) DEFAULT NULL COMMENT 'VT: VirusTotal report URL';
ALTER TABLE ip_database ADD COLUMN vt_queried_at DATETIME DEFAULT NULL COMMENT 'VT: last query timestamp';

-- ============================================================================
-- SQLite: ALTER TABLE ip_database — Add VirusTotal fields (archive table)
-- ============================================================================
-- ALTER TABLE ip_database ADD COLUMN vt_malicious INTEGER DEFAULT NULL;
-- ALTER TABLE ip_database ADD COLUMN vt_suspicious INTEGER DEFAULT NULL;
-- ALTER TABLE ip_database ADD COLUMN vt_harmless INTEGER DEFAULT NULL;
-- ALTER TABLE ip_database ADD COLUMN vt_undetected INTEGER DEFAULT NULL;
-- ALTER TABLE ip_database ADD COLUMN vt_detection_flagged INTEGER DEFAULT NULL;
-- ALTER TABLE ip_database ADD COLUMN vt_detection_total INTEGER DEFAULT NULL;
-- ALTER TABLE ip_database ADD COLUMN vt_link TEXT DEFAULT NULL;
-- ALTER TABLE ip_database ADD COLUMN vt_queried_at TEXT DEFAULT NULL;

-- ============================================================================
-- Column Mapping Reference (VT API → ip_cache)
-- ============================================================================
-- VT API Field            → New Column              → Description
-- ──────────────────────────────────────────────────────────────────────
-- malicious               → vt_malicious            → Malicious detection count
-- suspicious              → vt_suspicious            → Suspicious detection count
-- harmless                → vt_harmless              → Harmless detection count
-- undetected              → vt_undetected            → Undetected vendor count
-- flagged (mal+sus)       → vt_detection_flagged     → Total flagged vendors
-- total (all vendors)     → vt_detection_total       → Total vendors queried
-- vt_link (generated)     → vt_link                  → VirusTotal report URL
-- (query timestamp)       → vt_queried_at            → When VT was last queried
--
-- Existing columns reused for VT data (only on INSERT, not overwritten on UPDATE):
-- VT country              → country_code             → 2-letter country code
-- VT as_owner             → org                      → AS organization name
-- VT network              → asn                      → Network CIDR (e.g. 1.2.3.0/24)
-- VT status               → status                   → 'malicious' or 'safe'
-- ============================================================================

