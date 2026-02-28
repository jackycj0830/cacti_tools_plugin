# Block_IP Project Handover Guide

## 🚀 Quick Start

1. **Start the Dashboard**:
   ```bash
   php -S localhost:8080 -t web
   ```
2. **Run Daily Analysis**:
   ```bash
   python analyze_faz_ips.py
   ```
3. **View Results**:
   Open `http://localhost:8080` in Chrome to see the visual report.

---

## 🛠️ System Maintenance

### Environment Variables
The Antigravity browser tool requires the `HOME` environment variable to be set. This has been applied permanently to the registry for the current user.
- **Variable**: `HOME`
- **Value**: `C:\Users\Double.lin`

### PHP Compatibility
This project uses **PHP 8.4**. The backend (`web/api.php`) has been optimized to:
- Suppress deprecation warnings that could corrupt JSON data.
- Explicitly handle `fgetcsv` parameters for security.
- Disable `display_errors` in production to ensure clean API responses.

---

## 📁 Key Project Files

- **`analyze_faz_ips.py`**: The core logic engine. Connects to FAZ, filters logs, and checks VirusTotal.
- **`web/`**: Contains the dashboard frontend (`index.php`) and API backend (`api.php`).
- **`vt_cache.db`**: SQLite database storing the 30-day cache and the permanent security blacklist.
- **`PROGRESS_REPORT.md`**: Detailed history of the project phases and technical fixes.

---

## 📊 Dashboard Overview

The dashboard provides a visual confirmation of the security workflow:

![Dashboard Populations](/C:/Users/Double.lin/.gemini/antigravity/brain/11363015-7ab8-4bd7-a53c-90d70274fa9e/dashboard_fixed_final_1771435777926.png)

### Key Metrics
- **Malicious**: IPs flagged by ≥ 3 vendors (Permanently blacklisted).
- **Suspicious**: IPs with 1-2 flags (Requires monitoring).
- **Clean**: No vendor hits.

---

## 📝 Troubleshooting

| Issue | Solution |
|-------|----------|
| Dashboard stuck "Loading" | Check terminal for PHP errors. Ensure `vt_cache.db` exists in the root. |
| Chrome won't open | Verify `HOME` environment variable: `[System.Environment]::GetEnvironmentVariable("HOME", "User")` |
| No FAZ data | Ensure `analyze_faz_ips.py` has run at least once today to generate the CSV. |
