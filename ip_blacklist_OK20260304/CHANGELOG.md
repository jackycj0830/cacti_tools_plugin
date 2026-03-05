# Changelog / 變更日誌

All notable changes to the IP Blacklist Query System will be documented in this file.

本文檔記錄 IP 黑名單查詢系統的所有重要變更。

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

---

## [v2.3.0] - 2026-01-22

### Added / 新增功能
- **Fortigate CLI Two-Phase Workflow** - Enhanced CLI generator with group management support
  - Phase 1: Create individual firewall address objects (`config firewall address`)
  - Phase 2: Add addresses to firewall address group (`config firewall addrgrp`)
  - 兩階段防火牆指令產生器：建立個別地址物件 + 群組管理
- **Group Management UI** - New group management section with:
  - Enable/disable checkbox for group assignment / 啟用/停用群組分配核取方塊
  - Configurable group number (1-999) with default value 18 / 可配置群組編號
  - Dynamic group name preview (e.g., `Blacklist_Group_IPs_18`) / 動態群組名稱預覽
  - Uses `append member` command for safety (won't overwrite existing members) / 使用 append member 指令安全添加
- **External IP Lookup Buttons** - Quick access to external threat intelligence services:
  - Whois365 (blue gradient) - Domain/IP WHOIS information
  - Trend Micro (red gradient) - Threat intelligence check
  - VirusTotal (green gradient) - Multi-engine malware analysis
  - 外部 IP 查詢按鈕：Whois365、趨勢科技、VirusTotal
- **Enhanced Note Editor** - Full-featured resizable text editor:
  - Toolbar with font size and color controls / 工具列含字體大小和顏色控制
  - Expand/collapse functionality / 展開/收合功能
  - Character counter with warning at limit / 字數計數器含上限警告
  - Resize observer for dimension display / 尺寸變化監測顯示

### Changed / 變更
- **Cache-Busting Implementation** - Added timestamp-based cache-busting to JS/CSS includes
  - Forces browser to reload latest version of static assets
  - 快取破壞機制：強制瀏覽器載入最新版本的靜態資源
- **Note Display Area** - Updated to fixed default dimensions (500px × 200px)
- **Note Textarea** - Increased dimensions to 500px width × 300px height
- **CSS Styling** - New group management section with light blue gradient styling

### Fixed / 修復
- Fixed checkbox state detection in group assignment feature / 修復群組分配功能的核取方塊狀態偵測
- Fixed Phase 2 command generation when checkbox is enabled / 修復啟用核取方塊時的 Phase 2 指令產生
- Fixed cached query results showing "undefined" in risk analysis section / 修復快取查詢結果在風險分析區顯示 "undefined"

---

## [v2.2.0] - 2026-01-10

### Added / 新增功能
- Custom notes/annotations for blacklisted IPs / 黑名單IP自訂備註功能
- Add, edit, and delete notes for any blacklisted IP / 新增、編輯、刪除任何黑名單IP的備註
- Notes stored in database with creation and update timestamps / 備註存儲在資料庫中

### Changed / 變更
- Note character limit (2000 characters) with live counter / 備註字符限制含即時計數器
- Bilingual UI for all note-related features / 所有備註相關功能的雙語UI
- Notes persist even when cache expires / 備註在快取過期後仍保留

---

## [v2.1.0] - 2026-01-10

### Added / 新增功能
- Cache status display in query results (From Cache / Fresh Query)
- Cache info section showing creation time, expiration, remaining time, hit count
- Manual "Save to Cache" button for single query results
- Manual "Save All to Cache" button for batch query results
- Cache hit statistics display in batch results

---

## [v2.0.0] - 2026-01-10

### Added / 新增功能
- Database caching system (SQLite/MySQL) for IP query results
- Cache management API endpoints (stats, cleanup, clear)
- Configurable TTL for different IP statuses
- Cache hit/miss statistics in batch query results

### Changed / 變更
- Significantly reduced API calls through intelligent caching
- Faster query response times for cached IPs (~5ms vs ~500ms)

---

## [v1.7.0] - 2026-01-08

### Added / 新增功能
- Multi-provider GeoIP for batch queries with country consensus check
- Sorting capability for batch results table
- Filtering by status and risk level

---

## [v1.6.0] - 2026-01-08

### Added / 新增功能
- Enhanced batch query with GeoIP lookups and risk analysis
- Comprehensive batch results table with IP, Country, ISP, Risk Score
- Progress indicator during batch processing

---

## [v1.5.0] - 2026-01-08

### Added / 新增功能
- Risk Assessment Methodology documentation panel
- Version History tab with changelog

---

## [v1.4.0] - 2026-01-07

### Added / 新增功能
- Fortigate CLI Command Generator
- Copy to clipboard and download file functionality

---

## [v1.3.0] - 2026-01-06

### Added / 新增功能
- Aggregated GeoIP display from multiple providers
- Risk assessment algorithm with scoring system

---

## [v1.2.0] - 2026-01-05

### Added / 新增功能
- Multi-provider GeoIP API support (4 providers)
- Fallback and aggregate query modes

---

## [v1.1.0] - 2026-01-03

### Added / 新增功能
- CIDR range query support
- Batch query functionality
- Query history tracking
- Export to JSON/CSV

---

## [v1.0.0] - 2026-01-01

### Initial Release / 首次發布
- IP blacklist query functionality
- GeoIP location lookup
- Threat information display
- Bilingual interface (English/Chinese)
- Statistics dashboard

---

© 2024-2026 Cacti Tools | Powered by TPV IT Global Infrastructure Team

