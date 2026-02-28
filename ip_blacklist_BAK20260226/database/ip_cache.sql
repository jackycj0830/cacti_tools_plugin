-- --------------------------------------------------------
-- 主機:                           172.17.32.17
-- 伺服器版本:                        10.5.22-MariaDB - MariaDB Server
-- 伺服器作業系統:                      Linux
-- HeidiSQL 版本:                  12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- 傾印  資料表 ip_blacklist.ip_cache 結構
CREATE TABLE IF NOT EXISTS `ip_cache` (
  `ip_address` varchar(45) NOT NULL,
  `is_blacklisted` tinyint(1) DEFAULT 0,
  `status` varchar(20) DEFAULT 'safe',
  `country_code` varchar(10) DEFAULT NULL,
  `country_name` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `isp` varchar(255) DEFAULT NULL,
  `org` varchar(255) DEFAULT NULL,
  `asn` varchar(50) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `timezone` varchar(50) DEFAULT NULL,
  `risk_score` int(11) DEFAULT 0,
  `risk_level` varchar(20) DEFAULT 'low',
  `risk_factors` text DEFAULT NULL,
  `threat_info` text DEFAULT NULL,
  `provider_results` text DEFAULT NULL,
  `providers_queried` int(11) DEFAULT 0,
  `providers_responded` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  `expires_at` datetime DEFAULT NULL,
  `hit_count` int(11) DEFAULT 0,
  `custom_note` text DEFAULT NULL,
  `note_created_at` datetime DEFAULT NULL,
  `note_updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`ip_address`),
  KEY `idx_expires` (`expires_at`),
  KEY `idx_status` (`status`),
  KEY `idx_risk_level` (`risk_level`),
  KEY `idx_country` (`country_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 正在傾印表格  ip_blacklist.ip_cache 的資料：~3 rows (近似值)
INSERT INTO `ip_cache` (`ip_address`, `is_blacklisted`, `status`, `country_code`, `country_name`, `city`, `region`, `isp`, `org`, `asn`, `latitude`, `longitude`, `timezone`, `risk_score`, `risk_level`, `risk_factors`, `threat_info`, `provider_results`, `providers_queried`, `providers_responded`, `created_at`, `updated_at`, `expires_at`, `hit_count`, `custom_note`, `note_created_at`, `note_updated_at`) VALUES
	('178.22.24.212', 1, 'blocked', 'RU', NULL, 'Moscow', 'Moscow', 'Galeon LLC', 'Galeon LLC', 'AS209290 Galeon LLC', 55.74870000, 37.61870000, 'Europe/Moscow', 55, 'high', '["IP is on the blacklist \\/ IP\\u5728\\u9ed1\\u540d\\u55ae\\u4e2d","Inconsistent country data across providers \\/ \\u5404\\u63d0\\u4f9b\\u8005\\u7684\\u570b\\u5bb6\\u6578\\u64da\\u4e0d\\u4e00\\u81f4(\\u9700\\u8981\\u9032\\u884c\\u570b\\u5bb6\\u540d\\u7a31\\u6bd4\\u5c0d)"]', '{"threatType":"Proxy","severity":"Medium","firstSeen":"2025-03-03","lastSeen":"2025-12-28","reportCount":154,"source":"IP_From_Oversea.txt"}', '{"ip-api":{"country":"Russia","countryCode":"RU","region":"Moscow","city":"Moscow","isp":"Galeon LLC","org":"Galeon LLC","as":"AS209290 Galeon LLC","timezone":"Europe\\/Moscow","lat":55.7487,"lon":37.6187,"zip":"127474","_providerId":"ip-api","_providerName":"IP-API.com"},"ipinfo":{"country":"RU","countryCode":"RU","region":"Moscow","city":"Moscow","isp":"AS209290 Galeon LLC","org":"AS209290 Galeon LLC","as":"","timezone":"Europe\\/Moscow","lat":55.752,"lon":37.6178,"zip":"101000","_providerId":"ipinfo","_providerName":"IPinfo.io"}}', 4, 2, '2026-01-10 22:09:39', '2026-01-10 22:09:39', '2026-01-11 10:09:39', 0, NULL, NULL, NULL),
	('192.227.217.239', 1, 'blocked', 'US', NULL, 'Buffalo', 'New York', 'HostPapa', 'AS36352 HostPapa', 'AS36352 HostPapa', 42.88640000, -78.87840000, 'America/New_York', 55, 'high', '["IP is on the blacklist \\/ IP\\u5728\\u9ed1\\u540d\\u55ae\\u4e2d","Inconsistent country data across providers \\/ \\u5404\\u63d0\\u4f9b\\u8005\\u7684\\u570b\\u5bb6\\u6578\\u64da\\u4e0d\\u4e00\\u81f4(\\u9700\\u8981\\u9032\\u884c\\u570b\\u5bb6\\u540d\\u7a31\\u6bd4\\u5c0d)"]', '{"threatType":"Botnet","severity":"Medium","firstSeen":"2025-05-15","lastSeen":"2026-01-05","reportCount":406,"source":"IP_From_Oversea.txt"}', '{"ip-api":{"country":"United States","countryCode":"US","region":"New York","city":"Buffalo","isp":"HostPapa","org":"","as":"AS36352 HostPapa","timezone":"America\\/New_York","lat":42.8864,"lon":-78.8784,"zip":"14205","_providerId":"ip-api","_providerName":"IP-API.com"},"ipinfo":{"country":"US","countryCode":"US","region":"New York","city":"Buffalo","isp":"AS36352 HostPapa","org":"AS36352 HostPapa","as":"","timezone":"America\\/New_York","lat":42.8865,"lon":-78.8784,"zip":"14202","_providerId":"ipinfo","_providerName":"IPinfo.io"}}', 4, 2, '2026-01-10 22:09:16', '2026-01-10 22:09:16', '2026-01-11 10:09:16', 0, NULL, NULL, NULL),
	('193.143.1.33', 1, 'blocked', 'RU', NULL, 'Moscow', 'Moscow', 'Proton66 OOO', 'Proton66 OOO', 'AS198953 Proton66 OOO', 55.74870000, 37.61870000, 'Europe/Moscow', 55, 'high', '["IP is on the blacklist \\/ IP\\u5728\\u9ed1\\u540d\\u55ae\\u4e2d","Inconsistent country data across providers \\/ \\u5404\\u63d0\\u4f9b\\u8005\\u7684\\u570b\\u5bb6\\u6578\\u64da\\u4e0d\\u4e00\\u81f4(\\u9700\\u8981\\u9032\\u884c\\u570b\\u5bb6\\u540d\\u7a31\\u6bd4\\u5c0d)"]', '{"threatType":"Port Scanning","severity":"Critical","firstSeen":"2025-09-09","lastSeen":"2025-12-28","reportCount":44,"source":"IP_From_Oversea.txt"}', '{"ip-api":{"country":"Russia","countryCode":"RU","region":"Moscow","city":"Moscow","isp":"Proton66 OOO","org":"Proton66 OOO","as":"AS198953 Proton66 OOO","timezone":"Europe\\/Moscow","lat":55.7487,"lon":37.6187,"zip":"127474","_providerId":"ip-api","_providerName":"IP-API.com"},"ipinfo":{"country":"RU","countryCode":"RU","region":"St.-Petersburg","city":"Saint Petersburg","isp":"AS198953 Proton66 OOO","org":"AS198953 Proton66 OOO","as":"","timezone":"Europe\\/Moscow","lat":59.9386,"lon":30.3141,"zip":"195213","_providerId":"ipinfo","_providerName":"IPinfo.io"}}', 4, 2, '2026-01-10 22:10:46', '2026-01-10 22:10:46', '2026-01-11 10:10:46', 26, '測試1234', '2026-01-11 00:48:31', '2026-01-11 00:48:31');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
