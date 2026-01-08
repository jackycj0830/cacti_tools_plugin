# IP Blacklist Query System / 黑名單IP查詢系統

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

### Technical Features / 技術特性
- Real-time file reading (no database required)
- Multi-provider GeoIP with automatic fallback
- GeoIP caching (24-hour cache to reduce API calls)
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
└── data/
    ├── IP_From_Oversea.txt    # Blacklist file / 黑名單文件
    ├── geoip_cache.json       # GeoIP cache (auto-generated)
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

## 🔒 Security Notes / 安全注意事項

1. Ensure `data/` directory is not directly accessible via web
2. Consider adding authentication for production use
3. Rate limit API calls to prevent abuse
4. Regularly update the blacklist file

## 📞 Support / 支援

For issues or feature requests, contact the Cacti Tools team.

---

&copy; 2024-<?php echo date('Y'); ?> Cacti Tools | Powered by TPV IT Global Infrastructure Team

