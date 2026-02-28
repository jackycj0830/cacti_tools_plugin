# Block_IP Project — Progress Report
**Last Updated: 2026-02-18 16:30 (Conversation: ea3db831)**

## Project Status: PHASE 2 COMPLETE — FAZ Direct Log Query Working

### What This Project Does
1. Queries SSLVPN brute-force login events **directly from FAZ event logs** via JSON-RPC 2.0 API
2. Filters for IPs with **≥ 50 failed attempts** in the last 24 hours
3. Verifies each IP against VirusTotal (VT) Free API v3 with detailed analysis
4. Uses a local SQLite DB with **3-tier dedup** to minimize API calls:
   - **Tier 1: Permanent Blacklist** — known bad IPs, never expires
   - **Tier 2: Cache** — full VT results, 30-day TTL
   - **Tier 3: VT API** — queried only when IP not found locally
5. Produces detailed security reports with per-vendor verdicts, WHOIS, SSL cert info

---

## Files in This Project

| File | Purpose | Status |
|------|---------|--------|
| `analyze_faz_ips.py` | **Main script** — FAZ log query + VT analysis + cache + blacklist | ✅ WORKING |
| `web/index.php` | **Dashboard** — Visual overview of workflow, stats, and IP tables | ✅ WORKING |
| `web/api.php` | **Backend API** — Serves data from SQLite and CSV to dashboard | ✅ PHP 8.4 OK |
| `vt_cache.db` | SQLite DB: `vt_ip_cache` (30d TTL) + `vt_blacklist` (permanent) | ✅ ACTIVE |
| `SSLVPN_Failed_Logins_*.csv` | Auto-generated CSV from FAZ log query | Generated daily |

---

## Web Dashboard (Added 2026-02-19)

### Features
- **Real-time Stats**: Malicious vs Suspicious vs Clean IP breakdowns.
- **Workflow Visualization**: Status of the FAZ → Filter → VT → Blacklist pipeline.
- **Interactive Tables**: Searchable history of VT cache and permanent blacklist.
- **Auto-Refresh**: Pulls latest data from `api.php`.

### Platform Notes (Environment Fixes)
- **PHP 8.4 Support**: The API is fixed for PHP 8.4 (`fgetcsv` parameter updates and `display_errors` suppression).
- **Chrome/Antigravity**: Fixed browser initialization by setting the `HOME` environment variable persistent in the Windows registry.

---

## CLI & Dashboard Quick Reference

```bash
# 1. Start the PHP server (runs the dashboard)
php -S localhost:8080 -t web

# 2. Run the daily analysis (FAZ -> VT)
python analyze_faz_ips.py

# 3. View the dashboard
# Open http://localhost:8080 in Chrome
```

---

## Completed Work

### Phase 1 (Conversation 6c4ff382)
1. Full VT API v3 integration — per-vendor verdicts, WHOIS, CIDR
2. SQLite cache (30-day TTL) and Permanent blacklist implementation
3. 3-tier dedup logic — Blacklist → Cache → API

### Phase 2 (Conversation ea3db831)
1. **Fixed FAZ API authentication** — Bearer token + JSON-RPC 2.0 (`apiver: 3`)
2. **Direct log query** — Switched from report downloads to real-time log search
3. Verified end-to-end flow from FAZ to local CSV

### Phase 3 (Conversation 11363015)
1. **Web Dashboard** — Created PHP/JS dashboard with workflow and stat cards
2. **PHP 8.4 Compatibility** — Fixed API to handle new security/deprecation standards
3. **Environment Fix** — Resolved Chrome initialization issue (missing `$HOME` var)

---

## Suggested Next Phase

- **Firewall automation**: Auto-generate FortiGate address objects from blacklist
- **Scheduled execution**: Windows Task Scheduler to run `analyze_faz_ips.py` daily
- **Email alerting**: Send summary when new MALICIOUS IPs are detected
