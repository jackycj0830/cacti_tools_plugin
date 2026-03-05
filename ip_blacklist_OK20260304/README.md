# IP Blacklist Query System / 黑名單IP查詢系統

**Version / 版本: v2.3.0** | **Last Updated / 最後更新: 2026-01-22**

## 📋 Overview / 概述

A web-based IP blacklist query system that allows real-time querying of blacklisted IP addresses from overseas sources.

基於Web的黑名單IP查詢系統，支持實時查詢海外惡意IP地址。

## ✨ Features / 功能

### Core Features / 核心功能
- **Single IP Query** - Query individual IP addresses with detailed results
- **CIDR Range Query** - Query entire network ranges (e.g., 192.168.0.0/24)
- **Enhanced Batch Query** - Query up to 50 IPs with full GeoIP lookups and risk analysis
  - Comprehensive table display with IP, Country, ISP, Risk Score, Risk Level, Threat Type
  - Progress indicator during batch processing
  - Rate limiting and caching for optimal API usage
  - Risk level statistics (High/Medium/Low) in summary
- **Multi-Provider GeoIP** - Automatic geolocation with 6 API providers and fallback support
- **Threat Intelligence** - Displays threat type, severity, and report history
- **Risk Assessment** - Scoring algorithm based on blacklist status, provider data availability, and country consensus
- **Query History** - Tracks last 100 queries with export functionality
- **Bilingual Support** - English and Chinese interface

### Fortigate CLI Command Generator / 防火牆指令產生器 (v2.3.0)
- **Two-Phase IP Blocking Workflow** - Complete firewall configuration generation
  - Phase 1: Create individual firewall address objects
  - Phase 2: Add addresses to firewall address group (optional)
- **Group Management UI** - Configure group assignment settings
  - Enable/disable group assignment with checkbox
  - Configurable group number (1-999, default: 18)
  - Dynamic group name preview (e.g., `Blacklist_Group_IPs_18`)
  - Uses `append member` command for safety (won't overwrite existing members)
- **Command Chunking** - Splits long member lists into chunks of 30 IPs to avoid CLI buffer overflow
- **Copy & Download** - One-click copy to clipboard or download as file

### External IP Lookups / 外部 IP 查詢 (v2.3.0)
- **Whois365** - Domain/IP WHOIS information lookup
- **Trend Micro** - Threat intelligence check
- **VirusTotal** - Multi-engine malware analysis

### Technical Features / 技術特性
- Real-time file reading for blacklist
- **Database Caching System** - SQLite/MySQL caching for query results
- **Cache-Busting** - Automatic reloading of updated JS/CSS assets
- Multi-provider GeoIP with automatic fallback
- GeoIP caching with configurable TTL (24-48 hours)
- Responsive design (mobile/desktop compatible)
- Export to JSON/CSV formats

## 📁 File Structure / 文件結構

```
ip_blacklist/
├── ip_blacklist.php    # Main web interface / 主界面
├── api.php             # Backend API / 後端API
├── README.md           # This file / 本文檔
├── assets/
│   ├── style.css       # Styles / 樣式
│   └── app.js          # Frontend JavaScript / 前端腳本
├── database/           # Database caching system (NEW!)
│   ├── db_config.php   # Database configuration
│   ├── IPCacheDB.php   # Database connection class
│   ├── IPCache.php     # Cache operations class
│   ├── schema.sql      # Database schema reference
│   └── ip_cache.db     # SQLite database (auto-created)
└── data/
    ├── IP_From_Oversea.txt    # Blacklist file / 黑名單文件
    ├── geoip_cache.json       # Legacy GeoIP cache
    └── query_history.json     # Query history (auto-generated)
```

## 🚀 Installation / 安裝

### Requirements / 系統要求
- Apache or Nginx web server
- PHP 7.4+ with the following extensions:
  - `json`
  - `fileinfo`
  - `allow_url_fopen` enabled

### Quick Start / 快速開始

1. **Copy files to web directory:**
   ```bash
   cp -r ip_blacklist/ /var/www/html/cacti_tools/
   ```

2. **Set permissions:**
   ```bash
   chmod 755 ip_blacklist/
   chmod 644 ip_blacklist/*.php
   chmod 777 ip_blacklist/data/
   ```

3. **Access via browser:**
   ```
   http://your-server/cacti_tools/ip_blacklist/ip_blacklist.php
   ```

## 🔧 Configuration / 配置

### Blacklist File / 黑名單文件
The blacklist is stored in `data/IP_From_Oversea.txt`. Format: one IP per line.

### GeoIP API Providers / GeoIP API 提供者

The system supports **6 GeoIP API providers** with automatic fallback:

| Provider | Free Tier | API Key Required | Default Status |
|----------|-----------|------------------|----------------|
| ip-api.com | 45 req/min | No | ✅ Enabled |
| ipapi.co | 1000 req/day | No | ✅ Enabled |
| ipinfo.io | 50K req/month | Optional | ✅ Enabled |
| ip-api.is | Unlimited | No | ✅ Enabled |
| ipgeolocation.io | 1000 req/day | Yes | ❌ Disabled |
| abstractapi.com | 20K req/month | Yes | ❌ Disabled |

#### Query Modes / 查詢模式

- **Fallback Mode** (default): Tries providers in priority order until one succeeds
- **Aggregate Mode**: Queries all providers and merges results for most complete data

#### Configure Providers / 配置提供者

Edit the `$GEOIP_PROVIDERS` array in `api.php`:

```php
// Enable a provider that requires API key
$GEOIP_PROVIDERS['ipgeolocation']['enabled'] = true;
$GEOIP_PROVIDERS['ipgeolocation']['apiKey'] = 'YOUR_API_KEY';

// Change provider priority (lower = higher priority)
$GEOIP_PROVIDERS['ipinfo']['priority'] = 1;

// Switch to aggregate mode
define('GEOIP_QUERY_MODE', 'aggregate');
```

#### Add Custom Provider / 添加自定義提供者

```php
$GEOIP_PROVIDERS['my-provider'] = [
    'enabled' => true,
    'name' => 'My Custom Provider',
    'url' => 'https://api.example.com/geoip/{IP}',
    'apiKey' => 'your-api-key',
    'apiKeyParam' => 'key',  // Query parameter name
    'priority' => 0,          // Highest priority
    'rateLimit' => 1000,
    'timeout' => 5,
    'description' => 'My custom GeoIP provider',
    'website' => 'https://example.com'
];
```

Then add a parser in the `parseGeoIPResponse()` function in `api.php`.

## 📖 API Usage / API使用

### Query Single IP
```
GET api.php?action=query&ip=192.227.217.239
```

### Query CIDR Range
```
GET api.php?action=query&ip=176.117.107.0/24
```

### Enhanced Batch Query (v1.6.0+)
```
POST api.php?action=batch
Body: ips=["192.168.1.1","8.8.8.8","..."]
```

**Response includes for each IP:**
- `ip` - IP address
- `blacklisted` - Boolean blacklist status
- `status` - "blocked" or "safe"
- `country` / `countryName` - Country code and name
- `city` - City name
- `isp` - Internet Service Provider
- `riskScore` - Calculated risk score (0-65)
- `riskLevel` - "high", "medium", or "low"
- `riskFactors` - Array of factors contributing to risk score
- `threatInfo` - Threat details for blacklisted IPs

**Summary statistics:**
- `total`, `blacklisted`, `safe` - Count statistics
- `highRisk`, `mediumRisk`, `lowRisk` - Risk level counts

**Note:** Limited to 50 IPs per batch for full GeoIP analysis with 100ms rate limiting.

### Get Statistics
```
GET api.php?action=stats
```

### Get History
```
GET api.php?action=history
```

### Get GeoIP Providers Info
```
GET api.php?action=providers
```

### Export Results
```
GET api.php?action=export&format=json
GET api.php?action=export&format=csv
```

### Cache Management (v2.1.0+)
```
GET api.php?action=cache_stats     # Get cache statistics
GET api.php?action=cache_cleanup   # Clean expired entries
GET api.php?action=cache_clear     # Clear all cache

# Skip cache for single query
GET api.php?action=query&ip=8.8.8.8&nocache=1
```

## � Fortigate CLI Command Generator / 防火牆指令產生器

### Two-Phase IP Blocking Workflow / 兩階段 IP 封鎖工作流程

The Fortigate CLI Command Generator creates ready-to-execute firewall configuration commands in two phases:

**Phase 1: Individual Address Objects / 個別地址物件**
- Creates individual firewall address objects for each IP
- Format: `Blacklist_IP_{IP_ADDRESS}/32`

**Phase 2: Group Assignment (Optional) / 群組分配（可選）**
- Adds all address objects to a firewall address group
- Uses `append member` command (safe - won't overwrite existing members)
- Group name format: `Blacklist_Group_IPs_XX` (XX = padded group number)

### Usage / 使用方法

1. Navigate to the "防火牆指令" (Fortigate CLI) tab
2. Enter IP addresses (one per line)
3. Configure prefix and subnet mask if needed
4. **Enable Group Assignment**: Check "將 IP 加入群組" to generate Phase 2 commands
5. **Set Group Number**: Configure the group number (1-999, default: 18)
6. Click "產生指令" (Generate CLI)
7. Copy or download the generated commands

### Example Output / 輸出範例

```
# ========================================
# Phase 1: Create individual firewall address objects
# ========================================
config firewall address
edit "Blacklist_IP_192.168.1.1/32"
set subnet 192.168.1.1 255.255.255.255
next
edit "Blacklist_IP_192.168.1.2/32"
set subnet 192.168.1.2 255.255.255.255
next
end

# ========================================
# Phase 2: Add addresses to firewall address group
# Group: Blacklist_Group_IPs_18
# ========================================
config firewall addrgrp
    edit "Blacklist_Group_IPs_18"
        append member "Blacklist_IP_192.168.1.1/32" "Blacklist_IP_192.168.1.2/32"
    next
end
```

### Safety Features / 安全特性
- Uses `append member` (not `set member`) to preserve existing group members
- Splits long member lists into chunks of 30 IPs to avoid CLI buffer overflow
- Customizable group number with real-time name preview

---

## �🗄️ Database Caching System / 資料庫快取系統

### Overview / 概述
The database caching system stores IP query results to reduce external API calls and improve performance. It supports both SQLite (default, zero-config) and MySQL.

### Setup / 設置

**SQLite (Default - No setup required)**
- The SQLite database is automatically created at `database/ip_cache.db`
- No configuration needed - works out of the box

**MySQL (For production environments)**
1. Create a MySQL database:
   ```sql
   CREATE DATABASE ip_blacklist CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
2. Edit `database/db_config.php`:
   ```php
   define('DB_TYPE', 'mysql');
   define('MYSQL_HOST', 'localhost');
   define('MYSQL_DATABASE', 'ip_blacklist');
   define('MYSQL_USERNAME', 'your_user');
   define('MYSQL_PASSWORD', 'your_password');
   ```

### Configuration Options / 配置選項

Edit `database/db_config.php` to customize:

| Setting | Default | Description |
|---------|---------|-------------|
| `DB_TYPE` | `sqlite` | Database type: `sqlite` or `mysql` |
| `CACHE_TTL_DEFAULT` | 86400 (24h) | Default cache lifetime |
| `CACHE_TTL_BLACKLISTED` | 43200 (12h) | TTL for blacklisted IPs (check more frequently) |
| `CACHE_TTL_SAFE` | 172800 (48h) | TTL for safe IPs (longer cache) |
| `CACHE_ENABLED` | true | Enable/disable caching entirely |
| `CACHE_CLEANUP_PROBABILITY` | 5 | Chance (%) to auto-cleanup on each request |

### Performance Benefits / 性能優勢

| Scenario | Without Cache | With Cache |
|----------|---------------|------------|
| Single IP Query | ~500ms (API calls) | ~5ms (database lookup) |
| Batch 50 IPs | ~8-10 seconds | <500ms (if all cached) |
| API Calls Saved | 0% | Up to 95%+ |

### Cache Statistics API Response
```json
{
  "success": true,
  "stats": {
    "totalCached": 1250,
    "activeCached": 1180,
    "byStatus": {"blocked": 450, "safe": 800},
    "byRiskLevel": {"high": 450, "medium": 120, "low": 680},
    "totalHits": 5420,
    "today": {"cache_hits": 230, "cache_misses": 45}
  }
}
```

### Maintenance / 維護

1. **Automatic Cleanup**: Expired entries are automatically removed (5% chance per request)
2. **Manual Cleanup**: Call `api.php?action=cache_cleanup` to remove all expired entries
3. **Clear All Cache**: Call `api.php?action=cache_clear` to reset the entire cache

## 🔒 Security Notes / 安全注意事項

1. Ensure `data/` and `database/` directories are not directly accessible via web
2. Consider adding authentication for production use
3. Rate limit API calls to prevent abuse
4. Regularly update the blacklist file
5. Protect database credentials in `db_config.php`

## 📞 Support / 支援

For issues or feature requests, contact the Cacti Tools team.

---

&copy; 2024-2026 Cacti Tools | Powered by TPV IT Global Infrastructure Team

