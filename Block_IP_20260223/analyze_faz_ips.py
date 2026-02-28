"""

analyze_faz_ips.py
==================
1. Download the latest "SSLVPN Failed Logins" CSV report from FortiAnalyzer (FAZ).
2. Extract unique IPs and verify each one against the VirusTotal Free API v3.
3. Cache VT results in a local SQLite DB to save API quota (30-day TTL).
4. Permanently record confirmed malicious/suspicious IPs in a blacklist table
   for audit history and instant deduplication.
5. Produce a detailed terminal report with per-vendor verdicts, WHOIS, SSL cert
   info, network CIDR, and overall classification.

Lookup order:  Blacklist (instant) -> Cache (instant) -> VT API (15s/req)

Usage:
    python analyze_faz_ips.py                       # Fetch from FAZ + VT analysis
    python analyze_faz_ips.py --csv <file.csv>      # Skip FAZ, analyse existing CSV
    python analyze_faz_ips.py --csv <file.csv> -o results.csv  # Save results
    python analyze_faz_ips.py --no-cache             # Skip cache, always query VT
    python analyze_faz_ips.py --cache-ttl 14         # Cache TTL in days (default 30)

Cache management:
    python analyze_faz_ips.py --cache-stats          # View cache contents
    python analyze_faz_ips.py --cache-purge          # Purge expired cache entries

Blacklist management:
    python analyze_faz_ips.py --blacklist-stats      # View all blacklisted IPs
    python analyze_faz_ips.py --blacklist-export bl.csv  # Export blacklist to CSV
"""

import sys
import os

# Redirect stdout to a file for PHP tailing, while keeping console output
class OutputLogger(object):
    def __init__(self, filename):
        self.terminal = sys.stdout
        self.log = open(filename, "w", encoding="utf-8", buffering=1) # Line buffered

    def write(self, message):
        self.terminal.write(message)
        self.log.write(message)
        self.log.flush() # Force flush to file

    def flush(self):
        self.terminal.flush()
        self.log.flush()

# Set up logging to web/analysis_progress.log
log_file = os.path.join(os.path.dirname(__file__), "web", "analysis_progress.log")
sys.stdout = OutputLogger(log_file)

print("[*] Initializing analysis script...", flush=True)
import argparse
import csv
import json
import os
import re
import sqlite3
import sys
import time
from datetime import datetime, timedelta

import requests
import urllib3
try:
    import pymysql
except ImportError:
    print("Please install pymysql: pip install pymysql")
    sys.exit(1)

# ---------------------------------------------------------------------------
# Configuration
# ---------------------------------------------------------------------------
FAZ_IP    = "172.16.0.4"
FAZ_TOKEN = "waxk81r3g9fmzps4nrup55gn4huq17qc"        # Working token
FAZ_URL   = f"https://{FAZ_IP}/jsonrpc"
FAZ_ADOM  = "root"

# VirusTotal Free API (v3)
VT_API_KEY = "4a8be222d7595073328d5aff0076fd5296d37637745007308da6569f06208e42"
VT_URL     = "https://www.virustotal.com/api/v3/ip_addresses"

# Free-tier rate limit: 4 requests / minute  ->  15 s between calls
VT_REQUEST_DELAY = 15

# SQLite DB settings (for local FAZ pulling state)
VT_CACHE_DB   = os.path.join(os.path.dirname(os.path.abspath(__file__)), "vt_cache.db")
VT_CACHE_TTL  = 30   # days before cached results are considered stale

# Integration with ip_blacklist central database
MYSQL_HOST = "localhost"
MYSQL_PORT = 3306
MYSQL_USER = "root"
MYSQL_PASS = "c@Ct1Vser"
MYSQL_DB   = "ip_blacklist"

# Suppress self-signed cert warnings
urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)

HEADERS_FAZ = {
    "Authorization": f"Bearer {FAZ_TOKEN}",
    "Content-Type":  "application/json",
}

HEADERS_VT = {
    "x-apikey": VT_API_KEY,
}

# ---------------------------------------------------------------------------
# IP classification helpers
# ---------------------------------------------------------------------------
PRIVATE_PREFIXES = ("10.", "172.16.", "172.17.", "172.18.", "172.19.",
                    "172.20.", "172.21.", "172.22.", "172.23.",
                    "172.24.", "172.25.", "172.26.", "172.27.",
                    "172.28.", "172.29.", "172.30.", "172.31.",
                    "192.168.", "127.", "0.")

def is_private(ip):
    return any(ip.startswith(p) for p in PRIVATE_PREFIXES)

# ---------------------------------------------------------------------------
# FAZ helpers  (JSON-RPC 2.0 direct log query via Bearer token)
# ---------------------------------------------------------------------------

def get_last_faz_timestamp():
    db_path = os.path.join(os.path.dirname(__file__), "vt_cache.db")
    try:
        conn = sqlite3.connect(db_path)
        c = conn.cursor()
        row = c.execute("SELECT MAX(timestamp) FROM faz_raw_events").fetchone()
        conn.close()
        if row and row[0]:
            return datetime.strptime(row[0], "%Y-%m-%d %H:%M:%S")
    except Exception:
        pass
    return None

def get_min_faz_timestamp():
    db_path = os.path.join(os.path.dirname(__file__), "vt_cache.db")
    try:
        conn = sqlite3.connect(db_path)
        c = conn.cursor()
        row = c.execute("SELECT MIN(timestamp) FROM faz_raw_events").fetchone()
        conn.close()
        if row and row[0]:
            return datetime.strptime(row[0], "%Y-%m-%d %H:%M:%S")
    except Exception:
        pass
    return None

def faz_query_logs(filter_str, days_back=7, max_entries=500000):
    """Query event logs directly from FAZ using JSON-RPC 2.0 API.

    Args:
        filter_str: FAZ log filter string, e.g. "subtype == vpn && action == ssl-login-fail"
        days_back:  Used as fallback if db is empty (default 7 days)
        max_entries: Safety cap on total entries to fetch

    Returns:
        list of log entry dicts, or empty list on failure
    """
    today = datetime.now()
    
    last_ts = get_last_faz_timestamp()
    min_ts = get_min_faz_timestamp()
    target_start_dt = today - timedelta(days=days_back)
    
    if last_ts:
        if min_ts and target_start_dt < min_ts:
            # User wants a wider time window than we currently have in DB
            start_dt = target_start_dt
            print(f"[FAZ] Expanding sync window to cover {days_back} days. Fetching since: {start_dt.strftime('%Y-%m-%d %H:%M:%S')}")
        else:
            # Only fetch delta since last sync
            start_dt = last_ts + timedelta(seconds=1)
            print(f"[FAZ] Last sync found. Fetching delta since: {start_dt.strftime('%Y-%m-%d %H:%M:%S')}")
    else:
        # Fallback to the full window if no DB exists
        start_dt = target_start_dt
        print(f"[FAZ] No previous sync found. Fetching full {days_back} days since: {start_dt.strftime('%Y-%m-%d %H:%M:%S')}")

    start = start_dt.strftime("%Y-%m-%dT%H:%M:%S")
    end   = today.strftime("%Y-%m-%dT%H:%M:%S")

    # Step 1: Create search task
    search_payload = {
        "id": 1,
        "jsonrpc": "2.0",
        "method": "add",
        "params": [{
            "apiver": 3,
            "url": f"/logview/adom/{FAZ_ADOM}/logsearch",
            "logtype": "event",
            "time-order": "desc",
            "time-range": {"start": start, "end": end},
            "filter": filter_str,
        }],
    }
    try:
        resp = requests.post(FAZ_URL, json=search_payload, headers=HEADERS_FAZ,
                             verify=False, timeout=30)
        resp.raise_for_status()
        d = resp.json()
    except Exception as e:
        print(f"[FAZ] Search request failed: {e}")
        return []

    if "error" in d:
        print(f"[FAZ] Search error: {d['error']}")
        return []

    result = d.get("result", {})
    tid = result.get("tid") if isinstance(result, dict) else None
    if not tid:
        print(f"[FAZ] No search task ID returned: {d}")
        return []

    print(f"[FAZ] Search task created (tid={tid}), polling ...")

    # Step 2: Poll for results
    all_entries = []
    limit = 500
    offset = 0

    for attempt in range(300):         # up to ~10 min
        time.sleep(2)
        poll_payload = {
            "id": 2,
            "jsonrpc": "2.0",
            "method": "get",
            "params": [{
                "apiver": 3,
                "url": f"/logview/adom/{FAZ_ADOM}/logsearch/{tid}",
                "limit": limit,
                "offset": offset,
            }],
        }
        try:
            r2 = requests.post(FAZ_URL, json=poll_payload, headers=HEADERS_FAZ,
                               verify=False, timeout=60)
            r2_result = r2.json().get("result", {})
        except Exception as e:
            print(f"[FAZ]   Poll error: {e}")
            continue

        if not isinstance(r2_result, dict):
            continue

        pct   = r2_result.get("percentage", 0)
        total = r2_result.get("total-lines", 0)
        data  = r2_result.get("data", [])

        if isinstance(data, list) and data:
            all_entries.extend(data)
            offset += len(data)

        if total > 0:
            print(f"[FAZ]   Poll {attempt+1}: {pct}% complete (fetched {len(all_entries)} of {total})", flush=True)
        else:
            print(f"[FAZ]   Poll {attempt+1}: Fetching logs... ({len(all_entries)} records retrieved)", flush=True)

        if pct >= 100:
            if total and len(all_entries) < total:
                continue        # still more pages to fetch
            break

        if len(all_entries) >= max_entries:
            print(f"[FAZ]   Reached max entries cap ({max_entries})")
            break

    return all_entries


def fetch_from_faz(days_back=7):
    """Full FAZ pipeline: query logs -> extract IPs -> save CSV."""
    print("=" * 60)
    print("  FortiAnalyzer SSLVPN Failed Login Query")
    print("=" * 60)

    print(f"\n[FAZ] Connecting to {FAZ_IP} (ADOM: {FAZ_ADOM}) ...")

    entries = faz_query_logs(
        filter_str="subtype == vpn && action == ssl-login-fail",
        days_back=days_back,
    )

    if not entries:
        print("[FAZ] No log entries found.")
        return None

    print(f"[FAZ] Retrieved {len(entries)} log entries.")

    print(f"[FAZ] Retrieved {len(entries)} NEW log entries.")

    if not entries:
        print("[FAZ] Up to date. No new records to sync.")
        return get_latest_run_id()

    # Step: Convert logs directly to DB list
    raw_db_args = []
    for entry in entries:
        remip = entry.get("remip", "")
        if remip and not is_private(remip):
            ts = f"{entry.get('date', '')} {entry.get('time', '')}".strip()
            # Try to format timestamp cleanly if FAZ gave full ISO
            if 'T' in ts: ts = ts.replace('T', ' ')
            raw_db_args.append((remip, ts))
            
    if not raw_db_args:
        print("[FAZ] No new public IP logs found.")
        return get_latest_run_id()

    print(f"[FAZ] Found {len(raw_db_args)} new public IP events.")

    # Step: Database insertion of raw events
    try:
        import sqlite3
        import uuid
        db_path = os.path.join(os.path.dirname(__file__), "vt_cache.db")
        conn = sqlite3.connect(db_path)
        c = conn.cursor()
        
        # Insert raw delta events
        c.executemany("INSERT OR IGNORE INTO faz_raw_events (ip, timestamp) VALUES (?, ?)", raw_db_args)
        raw_inserted = c.rowcount
        print(f"[DB] Synced {raw_inserted} new raw events to local database.")

        # Prune raw events older than 28 days
        purge_dt = datetime.now() - timedelta(days=28)
        c.execute("DELETE FROM faz_raw_events WHERE timestamp < ?", (purge_dt.strftime("%Y-%m-%d %H:%M:%S"),))
        pruned_count = c.rowcount
        if pruned_count > 0:
            print(f"[DB] Auto-purged {pruned_count} FAZ raw events older than 28 days.")
        
        # Legacy compatibility: Generate Run ID and summary stats based on sliding window
        run_id = str(uuid.uuid4())
        MIN_ATTEMPTS = 50
        
        # Calculate stats for the last 'days_back' days to act as the primary targeted list
        cutoff_dt = datetime.now() - timedelta(days=days_back)
        cutoff_str = cutoff_dt.strftime("%Y-%m-%d %H:%M:%S")
        
        agg_rows = c.execute('''
            SELECT ip, COUNT(*), MIN(timestamp), MAX(timestamp) 
            FROM faz_raw_events 
            WHERE timestamp >= ?
            GROUP BY ip
        ''', (cutoff_str,)).fetchall()
        
        insert_args = []
        now_str = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
        total_unique_ips = len(agg_rows)
        filtered_count = 0
        total_events_in_window = 0
        
        for ip, count, f_seen, l_seen in agg_rows:
            total_events_in_window += count
            if count >= MIN_ATTEMPTS:
                filtered_count += 1
                insert_args.append((run_id, ip, count, f_seen, l_seen, now_str))
                
        c.executemany("INSERT INTO faz_logs (run_id, ip, count, first_seen, last_seen, imported_at) VALUES (?, ?, ?, ?, ?, ?)", insert_args)
        conn.commit()
        conn.close()
        
        print(f"[DB] Generated new Run ID ({run_id}) summarizing {filtered_count} targets >= {MIN_ATTEMPTS} attempts.")

    except Exception as e:
        print(f"[DB Error] Failed to sync to database: {e}")
        return None
    
    # Save stats for dashboard
    import json
    stats = {
        "start_time": cutoff_dt.strftime("%m-%d %H:%M"),
        "end_time": datetime.now().strftime("%m-%d %H:%M"),
        "total_logins": total_events_in_window,
        "unique_ips": total_unique_ips,
        "filtered_ips": filtered_count
    }
    stats_path = os.path.join(os.path.dirname(__file__), "web", "latest_stats.json")
    with open(stats_path, "w") as f:
        json.dump(stats, f)

    return run_id

def get_latest_run_id():
    db_path = os.path.join(os.path.dirname(__file__), "vt_cache.db")
    import sqlite3
    try:
        conn = sqlite3.connect(db_path)
        c = conn.cursor()
        row = c.execute("SELECT run_id FROM faz_logs ORDER BY imported_at DESC LIMIT 1").fetchone()
        conn.close()
        return row[0] if row else None
    except Exception:
        return None



# ---------------------------------------------------------------------------
# IP extraction
# ---------------------------------------------------------------------------

IP_PATTERN = re.compile(
    r"\b(?:(?:25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}"
    r"(?:25[0-5]|2[0-4]\d|[01]?\d\d?)\b"
)


def extract_ips_from_csv(filepath):
    """Extract unique public IPs from a CSV file."""
    ips = set()
    with open(filepath, "r", encoding="utf-8", errors="replace") as f:
        for line in f:
            for match in IP_PATTERN.findall(line):
                if not is_private(match):
                    ips.add(match)
    return sorted(ips)


# ---------------------------------------------------------------------------
# SQLite DB: Cache  +  Blacklist (permanent audit log)
# ---------------------------------------------------------------------------

class VTDB:
    """Dual-DB implementation:
    1. Local SQLite: faz_raw_events for tracking VPN login attempts.
    2. Central MySQL (`ip_blacklist` DB): stores cached logic and permanent blocks.
    
    Lookup order: blacklist (MySQL) -> cache (MySQL) -> VT API -> insert MySQL
    """

    def __init__(self, db_path=VT_CACHE_DB, ttl_days=VT_CACHE_TTL):
        self.sqlite_path = db_path
        self.ttl_days = ttl_days
        self.sqlite_conn = sqlite3.connect(db_path)
        self.sqlite_conn.row_factory = sqlite3.Row
        self._init_sqlite()
        
        # MySQL Connection
        self.mysql_conn = None
        try:
            self.mysql_conn = pymysql.connect(
                host=MYSQL_HOST,
                port=MYSQL_PORT,
                user=MYSQL_USER,
                password=MYSQL_PASS,
                database=MYSQL_DB,
                charset='utf8mb4',
                cursorclass=pymysql.cursors.DictCursor,
                autocommit=True
            )
        except Exception as e:
            err_msg = str(e).encode('ascii', 'ignore').decode('ascii')
            print(f"[VTDB] Failed to connect to central MySQL DB: {err_msg}")
        
        self.blacklist_hits = 0
        self.cache_hits = 0
        self.api_misses = 0

    def _init_sqlite(self):
        self.sqlite_conn.executescript('''
            CREATE TABLE IF NOT EXISTS faz_raw_events (
                ip TEXT,
                timestamp DATETIME,
                UNIQUE(ip, timestamp)
            );
            CREATE TABLE IF NOT EXISTS faz_logs (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                run_id TEXT,
                ip TEXT,
                count INTEGER,
                first_seen TEXT,
                last_seen TEXT,
                imported_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
            CREATE INDEX IF NOT EXISTS idx_faz_logs_run_id ON faz_logs(run_id);
        ''')
        self.sqlite_conn.commit()

    def _execute_mysql(self, query, args=(), fetchone=False, fetchall=False):
        if not self.mysql_conn: return None
        try:
            with self.mysql_conn.cursor() as cur:
                cur.execute(query, args)
                if fetchone: return cur.fetchone()
                if fetchall: return cur.fetchall()
            return cur.rowcount
        except Exception as e:
            print(f"[MySQL Error] {e}")
            return None

    # ---------------------------------------------------------------
    # Blacklist mapping to ip_cache where is_blacklisted = 1
    # ---------------------------------------------------------------
    def blacklist_check(self, ip):
        row = self._execute_mysql(
            "SELECT threat_info FROM ip_cache WHERE ip_address = %s AND is_blacklisted = 1",
            (ip,), fetchone=True
        )
        if row and row.get("threat_info"):
            self._execute_mysql(
                "UPDATE ip_cache SET hit_count = hit_count + 1, updated_at = NOW() WHERE ip_address = %s",
                (ip,)
            )
            self.blacklist_hits += 1
            try:
                return json.loads(row["threat_info"])
            except Exception:
                pass
        return None

    def blacklist_add(self, ip, result):
        pass # Handled uniformly in cache_put

    def blacklist_count(self):
        row = self._execute_mysql("SELECT COUNT(*) as c FROM ip_cache WHERE is_blacklisted = 1", fetchone=True)
        return row['c'] if row else 0

    def blacklist_list_all(self):
        rows = self._execute_mysql("SELECT * FROM ip_cache WHERE is_blacklisted = 1 ORDER BY updated_at DESC", fetchall=True)
        mapped = []
        if not rows: return mapped
        for r in rows:
            try: res = json.loads(r.get("threat_info", "{}"))
            except: res = {}
            # Format flag vendors list to string
            fv = res.get("flagged_vendors", [])
            fv_str = "; ".join(f"{v['vendor']}({v['category']})" for v in fv)
            mapped.append({
                "ip": r["ip_address"],
                "verdict": "MALICIOUS" if r["risk_level"] == "high" else "SUSPICIOUS",
                "malicious": r.get("vt_malicious", 0) or 0,
                "suspicious": r.get("vt_suspicious", 0) or 0,
                "as_owner": res.get("as_owner", "N/A"),
                "country": r["country_code"] or "??",
                "first_seen": str(r["created_at"]),
                "last_seen": str(r["updated_at"]),
                "times_seen": r["hit_count"],
                "flagged_vendors": fv_str
            })
        return mapped

    def blacklist_export_csv(self, output_path):
        entries = self.blacklist_list_all()
        if not entries:
            print("  Blacklist is empty.")
            return
        fieldnames = ["ip", "verdict", "malicious", "suspicious", "as_owner", "country", "first_seen", "last_seen", "times_seen", "flagged_vendors"]
        with open(output_path, "w", newline="", encoding="utf-8") as f:
            writer = csv.DictWriter(f, fieldnames=fieldnames, extrasaction="ignore")
            writer.writeheader()
            for e in entries:
                writer.writerow(e)
        print(f"  Exported {len(entries)} IP(s) -> {output_path}")

    # ---------------------------------------------------------------
    # Cache (is_blacklisted = 0 in MySQL)
    # ---------------------------------------------------------------
    def cache_get(self, ip):
        row = self._execute_mysql(
            "SELECT threat_info, expires_at FROM ip_cache WHERE ip_address = %s AND is_blacklisted = 0",
            (ip,), fetchone=True
        )
        if row and row.get("threat_info"):
            expires_at = row["expires_at"]
            if expires_at and expires_at < datetime.now():
                self.api_misses += 1
                return None
            self.cache_hits += 1
            self._execute_mysql(
                "UPDATE ip_cache SET hit_count = hit_count + 1, updated_at = NOW() WHERE ip_address = %s",
                (ip,)
            )
            try: return json.loads(row["threat_info"])
            except: pass
        self.api_misses += 1
        return None

    def cache_put(self, ip, result):
        m = result.get("malicious", 0)
        s = result.get("suspicious", 0)
        h = result.get("harmless", 0)
        u = result.get("undetected", 0)
        total = m + s + h + u
        flagged = m + s
        
        is_bl = 1 if result.get("verdict") in ("MALICIOUS", "SUSPICIOUS") else 0
        status = "blocked" if is_bl else "safe"
        risk_level = "high" if m >= 3 else ("medium" if is_bl else "low")
        country = result.get("country", "")
        if len(country) > 10: country = country[:10]
        
        threat_json = json.dumps(result, default=str)
        now = datetime.now()
        ttl = 3650 if is_bl else self.ttl_days
        expires_at = now + timedelta(days=ttl)
        note = "FAZ Auto-Blocked: SSLVPN Brute Force" if is_bl else ""

        query = '''
            INSERT INTO ip_cache (
                ip_address, is_blacklisted, status, risk_level, country_code,
                threat_info, vt_malicious, vt_suspicious, vt_harmless, vt_undetected,
                vt_detection_flagged, vt_detection_total, vt_queried_at, 
                created_at, updated_at, expires_at, hit_count, custom_note
            ) VALUES (
                %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, NOW(), NOW(), NOW(), %s, 1, %s
            ) ON DUPLICATE KEY UPDATE 
                is_blacklisted=VALUES(is_blacklisted),
                status=VALUES(status),
                risk_level=VALUES(risk_level),
                threat_info=VALUES(threat_info),
                vt_malicious=VALUES(vt_malicious),
                vt_suspicious=VALUES(vt_suspicious),
                vt_harmless=VALUES(vt_harmless),
                vt_undetected=VALUES(vt_undetected),
                vt_detection_flagged=VALUES(vt_detection_flagged),
                vt_detection_total=VALUES(vt_detection_total),
                vt_queried_at=NOW(),
                updated_at=NOW(),
                expires_at=VALUES(expires_at),
                custom_note=IF(custom_note IS NULL OR custom_note='', VALUES(custom_note), custom_note)
        '''
        self._execute_mysql(query, (
            ip, is_bl, status, risk_level, country, threat_json,
            m, s, h, u, flagged, total, expires_at, note
        ))

    def cache_count(self):
        row = self._execute_mysql("SELECT COUNT(*) as c FROM ip_cache WHERE is_blacklisted = 0", fetchone=True)
        return row['c'] if row else 0

    def cache_purge_expired(self):
        return self._execute_mysql("DELETE FROM ip_cache WHERE expires_at < NOW() AND is_blacklisted = 0") or 0

    def faz_logs_purge_expired(self, days=28):
        cutoff = (datetime.now() - timedelta(days=days)).strftime("%Y-%m-%d %H:%M:%S")
        cur = self.sqlite_conn.execute("DELETE FROM faz_raw_events WHERE timestamp < ?", (cutoff,))
        removed = cur.rowcount
        self.sqlite_conn.commit()
        return removed

    def cache_list_all(self):
        rows = self._execute_mysql("SELECT * FROM ip_cache WHERE is_blacklisted = 0 ORDER BY updated_at DESC", fetchall=True)
        mapped = []
        if not rows: return mapped
        for r in rows:
            try: res = json.loads(r.get("threat_info", "{}"))
            except: res = {}
            mapped.append({
                "ip": r["ip_address"],
                "queried_at": str(r["vt_queried_at"]),
                "verdict": "CLEAN",
                "malicious": r.get("vt_malicious", 0) or 0,
                "suspicious": r.get("vt_suspicious", 0) or 0,
                "as_owner": res.get("as_owner", "N/A"),
                "country": r["country_code"] or "??"
            })
        return mapped

    # ---------------------------------------------------------------
    # Shared helpers
    # ---------------------------------------------------------------
    def vacuum(self):
        self.sqlite_conn.execute("VACUUM")

    def db_size_kb(self):
        try: return os.path.getsize(self.sqlite_path) / 1024
        except OSError: return 0

    def auto_maintenance(self):
        removed_cache = self.cache_purge_expired() or 0
        removed_faz = self.faz_logs_purge_expired(days=28)
        self.vacuum()
        print(f"\\033[96m[DB] Purged {removed_cache} MySQL stale entries, {removed_faz} local FAZ records.\\033[0m")

    def close(self):
        if self.mysql_conn: self.mysql_conn.close()
        self.sqlite_conn.close()


# ---------------------------------------------------------------------------
# VirusTotal helpers  (Enhanced with full API data)
# ---------------------------------------------------------------------------

def vt_check_ip(ip):
    """
    Query VirusTotal API v3 for an IP address.
    Returns a comprehensive dict with all valuable fields.
    """
    url = f"{VT_URL}/{ip}"
    try:
        resp = requests.get(url, headers=HEADERS_VT, timeout=30)

        if resp.status_code == 429:
            return "RATE_LIMIT"

        if resp.status_code == 401:
            print("[VT] ERROR: Invalid API key.")
            return None

        if resp.status_code != 200:
            print(f"[VT] Unexpected status {resp.status_code} for {ip}")
            return None

        attrs = resp.json().get("data", {}).get("attributes", {})
        stats = attrs.get("last_analysis_stats", {})

        # --- Per-vendor verdicts (malicious + suspicious only) ---
        flagged_vendors = []
        all_results = attrs.get("last_analysis_results", {})
        for vendor, info in sorted(all_results.items()):
            cat = info.get("category", "")
            if cat in ("malicious", "suspicious"):
                flagged_vendors.append({
                    "vendor": vendor,
                    "category": cat,
                    "result": info.get("result", "N/A"),
                })

        # --- WHOIS extraction ---
        whois_raw = attrs.get("whois", "")
        whois_org = ""
        whois_created = ""
        if whois_raw:
            for line in whois_raw.split("\n"):
                lower = line.lower().strip()
                if lower.startswith("org:") and not whois_org:
                    whois_org = line.split(":", 1)[1].strip()
                elif lower.startswith("organization:") and not whois_org:
                    whois_org = line.split(":", 1)[1].strip()
                elif lower.startswith("created:") and not whois_created:
                    whois_created = line.split(":", 1)[1].strip()

        # --- SSL Certificate ---
        cert = attrs.get("last_https_certificate", {})
        cert_cn = cert.get("subject", {}).get("CN", "N/A") if cert else "N/A"
        cert_issuer = cert.get("issuer", {}).get("O", "N/A") if cert else "N/A"
        cert_valid_until = cert.get("validity", {}).get("not_after", "N/A") if cert else "N/A"
        cert_san = cert.get("extensions", {}).get("subject_alternative_name", []) if cert else []

        # Check if cert is expired
        cert_expired = False
        if cert_valid_until and cert_valid_until != "N/A":
            try:
                for fmt in ("%Y-%m-%d %H:%M:%S", "%Y-%m-%dT%H:%M:%S"):
                    try:
                        exp_date = datetime.strptime(cert_valid_until, fmt)
                        cert_expired = exp_date < datetime.now()
                        break
                    except ValueError:
                        continue
            except Exception:
                pass

        # --- Last analysis date ---
        last_analysis_ts = attrs.get("last_analysis_date", 0)
        last_analysis_str = ""
        if last_analysis_ts:
            try:
                last_analysis_str = datetime.fromtimestamp(last_analysis_ts).strftime("%Y-%m-%d %H:%M")
            except Exception:
                last_analysis_str = str(last_analysis_ts)

        return {
            "ip":             ip,
            # Detection stats
            "malicious":      stats.get("malicious", 0),
            "suspicious":     stats.get("suspicious", 0),
            "undetected":     stats.get("undetected", 0),
            "harmless":       stats.get("harmless", 0),
            # Network
            "asn":            attrs.get("asn", "N/A"),
            "as_owner":       attrs.get("as_owner", "N/A"),
            "country":        attrs.get("country", "N/A"),
            "continent":      attrs.get("continent", "N/A"),
            "network":        attrs.get("network", "N/A"),
            "registry":       attrs.get("regional_internet_registry", "N/A"),
            # Reputation
            "reputation":     attrs.get("reputation", 0),
            "total_votes":    attrs.get("total_votes", {}),
            # Flagged vendors
            "flagged_vendors": flagged_vendors,
            # WHOIS
            "whois_org":      whois_org if whois_org else "N/A",
            "whois_created":  whois_created if whois_created else "N/A",
            # SSL Certificate
            "cert_cn":        cert_cn,
            "cert_issuer":    cert_issuer,
            "cert_valid_until": cert_valid_until,
            "cert_expired":   cert_expired,
            "cert_san":       cert_san[:5],
            # Freshness
            "last_analysis":  last_analysis_str,
            # JARM
            "jarm":           attrs.get("jarm", "N/A"),
        }

    except requests.exceptions.RequestException as e:
        print(f"[VT] Connection error for {ip}: {e}")
        return None


def classify(result):
    """Return a verdict string based on VT detection counts."""
    if result is None:
        return "UNKNOWN"
    m = result.get("malicious", 0)
    s = result.get("suspicious", 0)
    if m >= 3:
        return "MALICIOUS"
    elif m >= 1 or s >= 2:
        return "SUSPICIOUS"
    else:
        return "CLEAN"


VERDICT_COLORS = {
    "MALICIOUS":  "\033[91m",   # Red
    "SUSPICIOUS": "\033[93m",   # Yellow
    "CLEAN":      "\033[92m",   # Green
    "UNKNOWN":    "\033[90m",   # Grey
}
RESET  = "\033[0m"
BOLD   = "\033[1m"
DIM    = "\033[2m"
CYAN   = "\033[96m"
MAGENTA = "\033[95m"


def _empty_result(ip):
    """Return a blank result dict for an IP that couldn't be checked."""
    return {
        "ip": ip, "malicious": 0, "suspicious": 0, "undetected": 0,
        "harmless": 0, "asn": "N/A", "as_owner": "N/A", "country": "N/A",
        "continent": "N/A", "network": "N/A", "registry": "N/A",
        "reputation": 0, "total_votes": {}, "flagged_vendors": [],
        "whois_org": "N/A", "whois_created": "N/A",
        "cert_cn": "N/A", "cert_issuer": "N/A", "cert_valid_until": "N/A",
        "cert_expired": False, "cert_san": [], "last_analysis": "N/A",
        "jarm": "N/A",
    }


def _print_ip_detail(result, source_tag=""):
    """Print detailed VT analysis for one IP result."""
    verdict = result["verdict"]
    color   = VERDICT_COLORS.get(verdict, "")
    m = result["malicious"]
    s = result["suspicious"]
    h = result["harmless"]

    # --- Quick verdict line ---
    print(f"\n  Verdict : {color}{BOLD}{verdict}{RESET}  "
          f"(malicious={m}  suspicious={s}  clean={h})  {source_tag}")

    # --- Network info ---
    print(f"\n  {DIM}--- Network ---{RESET}")
    print(f"  ASN      : {result['asn']}  ({result['as_owner']})")
    print(f"  Country  : {result['country']} / {result['continent']}")
    print(f"  Network  : {result['network']}")
    print(f"  Registry : {result['registry']}")

    # --- WHOIS ---
    print(f"\n  {DIM}--- WHOIS ---{RESET}")
    print(f"  Org      : {result['whois_org']}")
    print(f"  Created  : {result['whois_created']}")

    # --- SSL Certificate ---
    print(f"\n  {DIM}--- SSL Certificate ---{RESET}")
    expired_tag = f"  {VERDICT_COLORS['MALICIOUS']}[EXPIRED]{RESET}" if result.get("cert_expired") else ""
    print(f"  CN       : {result['cert_cn']}")
    print(f"  Issuer   : {result['cert_issuer']}")
    print(f"  Expires  : {result['cert_valid_until']}{expired_tag}")
    if result.get("cert_san"):
        print(f"  SANs     : {', '.join(result['cert_san'])}")

    # --- Freshness ---
    print(f"\n  {DIM}--- Analysis ---{RESET}")
    print(f"  Last VT scan : {result['last_analysis']}")
    print(f"  Reputation   : {result['reputation']}")

    # --- Per-vendor verdicts ---
    flagged = result.get("flagged_vendors", [])
    if flagged:
        print(f"\n  {DIM}--- Flagged by {len(flagged)} vendor(s) ---{RESET}")
        for v in flagged:
            cat = v["category"]
            cat_color = VERDICT_COLORS.get("MALICIOUS") if cat == "malicious" else VERDICT_COLORS.get("SUSPICIOUS")
            print(f"    {cat_color}[{cat.upper():>10}]{RESET}"
                  f"  {v['vendor']}: {v['result']}")
    else:
        print(f"\n  {VERDICT_COLORS['CLEAN']}No vendors flagged this IP.{RESET}")


def analyze_ips_with_vt(ips, use_cache=True, cache_ttl=VT_CACHE_TTL):
    """Run VirusTotal analysis on a list of IPs. Returns list of result dicts.

    3-tier lookup:  Blacklist (permanent) -> Cache (TTL) -> VT API
    """
    if VT_API_KEY == "YOUR_VIRUSTOTAL_API_KEY":
        print("\n[VT] WARNING: No VirusTotal API key configured.")
        print("     Set VT_API_KEY in the script, or pass --vt-key <key>.")
        print("     Skipping VirusTotal analysis.\n")
        return []

    # --- Initialise DB ---
    db = None
    if use_cache:
        db = VTDB(db_path=VT_CACHE_DB, ttl_days=cache_ttl)
        db.auto_maintenance()   # purge stale cache entries on every run
        print(f"\n{CYAN}[DB] SQLite: {VT_CACHE_DB}{RESET}")
        print(f"{CYAN}[DB] Cache TTL: {cache_ttl} day(s)  |  "
              f"Cache: {db.cache_count()} IP(s)  |  "
              f"Blacklist: {db.blacklist_count()} IP(s)  |  "
              f"Size: {db.db_size_kb():.1f} KB{RESET}")

    print("\n" + "=" * 70)
    print("  VirusTotal IP Analysis  (Free API + Cache + Blacklist)")
    print("=" * 70)
    print(f"  IPs to check : {len(ips)}")
    cache_status = f"ON  (TTL={cache_ttl}d)" if db else "OFF"
    print(f"  Cache        : {cache_status}")
    bl_status = f"{db.blacklist_count()} known bad IPs" if db else "OFF"
    print(f"  Blacklist    : {bl_status}")
    print(f"  Rate limit   : 1 req / {VT_REQUEST_DELAY}s  (API calls only)")
    print("-" * 70)

    results = []
    api_calls_made = 0

    for i, ip in enumerate(ips, 1):
        print(f"\n{'='*50}")
        print(f"  [{i}/{len(ips)}] Checking {BOLD}{ip}{RESET}")
        print(f"{'='*50}")

        # --- Tier 1: Check blacklist (permanent, instant) ---
        if db:
            bl_result = db.blacklist_check(ip)
            if bl_result is not None:
                source_tag = f"{MAGENTA}[BLACKLISTED]{RESET}"
                _print_ip_detail(bl_result, source_tag)
                results.append(bl_result)
                continue

        # --- Tier 2: Check cache (temporary, instant) ---
        if db:
            cached_result = db.cache_get(ip)
            if cached_result is not None:
                source_tag = f"{CYAN}[CACHED]{RESET}"
                _print_ip_detail(cached_result, source_tag)
                results.append(cached_result)
                continue

        # --- Tier 3: Query VT API (rate-limited) ---
        if api_calls_made > 0:
            print(f"  {DIM}(waiting {VT_REQUEST_DELAY}s for rate limit...){RESET}")
            time.sleep(VT_REQUEST_DELAY)

        result = vt_check_ip(ip)
        api_calls_made += 1

        # Handle rate limiting
        if result == "RATE_LIMIT":
            print("  ... Rate limited. Waiting 60s ...")
            time.sleep(60)
            result = vt_check_ip(ip)
            api_calls_made += 1

        if result == "RATE_LIMIT" or result is None:
            print("  ... Could not retrieve data. Skipping.")
            result = _empty_result(ip)

        verdict = classify(result)
        result["verdict"] = verdict

        # Store in DB (only if we got real data)
        if db and result.get("as_owner") != "N/A":
            db.cache_put(ip, result)
            # Auto-add to permanent blacklist if malicious or suspicious
            if verdict in ("MALICIOUS", "SUSPICIOUS"):
                db.blacklist_add(ip, result)

        source_tag = f"{VERDICT_COLORS['SUSPICIOUS']}[FRESH from API]{RESET}"
        _print_ip_detail(result, source_tag)
        results.append(result)

    # --- DB summary ---
    if db:
        total_lookups = db.blacklist_hits + db.cache_hits + db.api_misses
        saved_secs = (db.blacklist_hits + db.cache_hits) * VT_REQUEST_DELAY
        print(f"\n{'='*60}")
        print(f"  {BOLD}LOOKUP STATISTICS{RESET}")
        print(f"  {MAGENTA}Blacklist hits : {db.blacklist_hits}{RESET}")
        print(f"  {CYAN}Cache hits     : {db.cache_hits}{RESET}")
        print(f"  API calls    : {api_calls_made}")
        print(f"  Time saved   : ~{saved_secs}s  "
              f"({db.blacklist_hits + db.cache_hits}/{total_lookups} "
              f"lookups served locally)")
        print(f"  Blacklist    : {db.blacklist_count()} total known bad IP(s)")
        print(f"  Cache        : {db.cache_count()} cached IP(s)")
        print(f"  DB size      : {db.db_size_kb():.1f} KB")
        print(f"{'='*60}")
        db.close()

    return results


# ---------------------------------------------------------------------------
# Reporting
# ---------------------------------------------------------------------------

def print_summary(ips, results):
    """Print a summary table of findings."""
    print("\n\n" + "=" * 80)
    print("  FINAL SECURITY ANALYSIS RESULTS")
    print("=" * 80)
    print(f"  Total unique public IPs analysed : {len(ips)}")

    if not results:
        print("  (VirusTotal analysis was skipped)")
        print("\n  Extracted IPs:")
        for ip in ips:
            print(f"    - {ip}")
        print("=" * 80)
        return

    malicious_ips   = [r for r in results if r["verdict"] == "MALICIOUS"]
    suspicious_ips  = [r for r in results if r["verdict"] == "SUSPICIOUS"]
    clean_ips       = [r for r in results if r["verdict"] == "CLEAN"]

    print(f"  {VERDICT_COLORS['MALICIOUS']}MALICIOUS  : {len(malicious_ips)}{RESET}")
    print(f"  {VERDICT_COLORS['SUSPICIOUS']}SUSPICIOUS : {len(suspicious_ips)}{RESET}")
    print(f"  {VERDICT_COLORS['CLEAN']}CLEAN      : {len(clean_ips)}{RESET}")

    # --- Summary Table ---
    print("\n" + "-" * 80)
    header = (f"  {'IP':<18} {'Verdict':<11} {'Mal':>4} {'Sus':>4} "
              f"{'Cln':>4}  {'AS Owner':<22} {'CC':>2}  {'Network':<18}")
    print(header)
    print("  " + "-" * 76)

    for r in sorted(results, key=lambda x: x["malicious"], reverse=True):
        v = r["verdict"]
        color = VERDICT_COLORS.get(v, "")
        print(f"  {r['ip']:<18} {color}{v:<11}{RESET} "
              f"{r['malicious']:>4} {r['suspicious']:>4} {r['harmless']:>4}  "
              f"{r['as_owner']:<22} {r['country']:>2}  {r['network']:<18}")

    # --- Subnet analysis ---
    print("\n" + "-" * 80)
    print(f"  {BOLD}SUBNET ANALYSIS{RESET}")
    networks = {}
    for r in results:
        net = r.get("network", "N/A")
        if net != "N/A":
            networks.setdefault(net, []).append(r)
    for net, members in sorted(networks.items(), key=lambda x: len(x[1]), reverse=True):
        if len(members) > 1:
            member_ips = ", ".join(m["ip"] for m in members)
            owner = members[0]["as_owner"]
            print(f"  {net:<20} ({owner}) -> {len(members)} IPs: {member_ips}")
    if not any(len(v) > 1 for v in networks.values()):
        print("  No overlapping subnets found.")

    # --- SSL Certificate red flags ---
    expired_certs = [r for r in results if r.get("cert_expired")]
    if expired_certs:
        print(f"\n  {BOLD}SSL CERTIFICATE RED FLAGS{RESET}")
        for r in expired_certs:
            print(f"  {VERDICT_COLORS['MALICIOUS']}[EXPIRED]{RESET}  "
                  f"{r['ip']:<18} CN={r['cert_cn']}  "
                  f"(expired: {r['cert_valid_until']})")

    print("\n" + "=" * 80)

    # --- Action recommendation ---
    if malicious_ips:
        print(f"\n  {VERDICT_COLORS['MALICIOUS']}{BOLD}"
              f"!! RECOMMENDED: Block the following IPs on the firewall !!{RESET}")
        for r in malicious_ips:
            vendors = ", ".join(v["vendor"] for v in r.get("flagged_vendors", [])
                               if v["category"] == "malicious")
            print(f"    -> {r['ip']:<18} {r['malicious']} vendors flagged: {vendors}")

    if suspicious_ips:
        print(f"\n  {VERDICT_COLORS['SUSPICIOUS']}{BOLD}"
              f"!! CONSIDER blocking these SUSPICIOUS IPs !!{RESET}")
        for r in suspicious_ips:
            vendors = ", ".join(v["vendor"] for v in r.get("flagged_vendors", []))
            print(f"    -> {r['ip']:<18} flagged by: {vendors}")


def save_results_csv(results, output_path):
    """Save detailed analysis results to CSV."""
    if not results:
        return
    fieldnames = [
        "ip", "verdict", "malicious", "suspicious", "undetected", "harmless",
        "asn", "as_owner", "country", "continent", "network", "registry",
        "reputation", "whois_org", "whois_created",
        "cert_cn", "cert_issuer", "cert_valid_until", "cert_expired",
        "cert_san", "last_analysis", "jarm",
        "flagged_vendors_list",
    ]
    with open(output_path, "w", newline="", encoding="utf-8") as f:
        writer = csv.DictWriter(f, fieldnames=fieldnames, extrasaction="ignore")
        writer.writeheader()
        for r in results:
            row = {k: r.get(k, "") for k in fieldnames}
            row["cert_san"] = "; ".join(r.get("cert_san", []))
            vendors = r.get("flagged_vendors", [])
            row["flagged_vendors_list"] = "; ".join(
                f"{v['vendor']}({v['category']})" for v in vendors
            )
            writer.writerow(row)
    print(f"\n  Results saved -> {output_path}")


# ---------------------------------------------------------------------------
# CLI management commands
# ---------------------------------------------------------------------------

def cmd_cache_stats(cache_ttl):
    """Show cache contents and statistics."""
    db = VTDB(db_path=VT_CACHE_DB, ttl_days=cache_ttl)
    entries = db.cache_list_all()
    total = db.cache_count()
    size_kb = db.db_size_kb()

    print("=" * 70)
    print(f"  VT CACHE STATISTICS")
    print("=" * 70)
    print(f"  DB file    : {VT_CACHE_DB}")
    print(f"  DB size    : {size_kb:.1f} KB")
    print(f"  Cache IPs  : {total}")
    print(f"  Blacklist  : {db.blacklist_count()} IP(s)")
    print(f"  TTL        : {cache_ttl} day(s)")

    if entries:
        now = datetime.now()
        fresh = sum(1 for e in entries
                    if now - datetime.fromisoformat(e["queried_at"])
                    <= timedelta(days=cache_ttl))
        expired = total - fresh
        print(f"  Fresh      : {fresh}")
        print(f"  Expired    : {expired}")

        print("\n" + "-" * 70)
        print(f"  {'IP':<18} {'Verdict':<11} {'Mal':>4} {'Sus':>4} "
              f"{'AS Owner':<22} {'CC':>2}  {'Queried At':<19}  Age")
        print("  " + "-" * 66)

        for e in entries:
            queried = datetime.fromisoformat(e["queried_at"])
            age = now - queried
            age_str = f"{age.days}d {age.seconds//3600}h"
            is_expired = age > timedelta(days=cache_ttl)
            tag = f" {VERDICT_COLORS['MALICIOUS']}(EXP){RESET}" if is_expired else ""
            v = e.get("verdict", "N/A")
            color = VERDICT_COLORS.get(v, "")
            print(f"  {e['ip']:<18} {color}{v:<11}{RESET} "
                  f"{e.get('malicious',0):>4} {e.get('suspicious',0):>4} "
                  f"{(e.get('as_owner','') or 'N/A'):<22} "
                  f"{(e.get('country','') or '??'):>2}  "
                  f"{queried.strftime('%Y-%m-%d %H:%M:%S')}  {age_str}{tag}")

    print("=" * 70)
    db.close()


def cmd_cache_purge(cache_ttl):
    """Purge expired entries and VACUUM the DB."""
    db = VTDB(db_path=VT_CACHE_DB, ttl_days=cache_ttl)
    removed = db.cache_purge_expired()
    db.vacuum()
    after = db.cache_count()
    size_after = db.db_size_kb()

    print("=" * 50)
    print(f"  CACHE PURGE COMPLETE")
    print("=" * 50)
    print(f"  Removed   : {removed} expired cache entry(ies)")
    print(f"  Remaining : {after} cached IP(s)")
    print(f"  Blacklist : {db.blacklist_count()} IP(s) (untouched)")
    print(f"  DB size   : {size_before:.1f} KB -> {size_after:.1f} KB")
    print("=" * 50)
    db.close()


def cmd_blacklist_stats():
    """Show all blacklisted IPs."""
    db = VTDB(db_path=VT_CACHE_DB)
    entries = db.blacklist_list_all()
    total = db.blacklist_count()

    print("=" * 80)
    print(f"  {MAGENTA}{BOLD}PERMANENT BLACKLIST  (audit history){RESET}")
    print("=" * 80)
    print(f"  DB file         : {VT_CACHE_DB}")
    print(f"  DB size         : {db.db_size_kb():.1f} KB")
    print(f"  Blacklisted IPs : {total}")

    if entries:
        print("\n" + "-" * 80)
        print(f"  {'IP':<18} {'Verdict':<11} {'Mal':>4} {'Sus':>4} "
              f"{'AS Owner':<20} {'CC':>2}  {'First Seen':<12} "
              f"{'Last Seen':<12} {'#':>3}")
        print("  " + "-" * 76)

        for e in entries:
            v = e.get("verdict", "N/A")
            color = VERDICT_COLORS.get(v, "")
            first = e.get("first_seen", "")[:10]
            last = e.get("last_seen", "")[:10]
            times = e.get("times_seen", 1)
            print(f"  {e['ip']:<18} {color}{v:<11}{RESET} "
                  f"{e.get('malicious',0):>4} {e.get('suspicious',0):>4} "
                  f"{(e.get('as_owner','') or 'N/A'):<20} "
                  f"{(e.get('country','') or '??'):>2}  "
                  f"{first:<12} {last:<12} {times:>3}")

        # Vendor breakdown
        print(f"\n  {BOLD}FLAGGED VENDORS{RESET}")
        for e in entries:
            fv = e.get("flagged_vendors", "")
            if fv:
                print(f"  {e['ip']:<18} {fv}")

    print("=" * 80)
    db.close()


# ---------------------------------------------------------------------------
# Main
# ---------------------------------------------------------------------------

def main():
    parser = argparse.ArgumentParser(
        description="Fetch FAZ SSLVPN reports & verify IPs via VirusTotal")
    parser.add_argument("--csv", dest="csv_file",
                        help="Path to an existing CSV file (skip FAZ download)")
    parser.add_argument("--output", "-o", dest="output",
                        help="Save VT results to a CSV file")
    parser.add_argument("--vt-key", dest="vt_key",
                        help="VirusTotal API key (overrides built-in)")
    parser.add_argument("--days", dest="days", type=int, default=7,
                        help="Filter FAZ logs by the last N days (default: 7)")
    parser.add_argument("--no-cache", dest="no_cache", action="store_true",
                        help="Disable local SQLite cache, always query VT API")
    parser.add_argument("--cache-ttl", dest="cache_ttl", type=int,
                        default=VT_CACHE_TTL,
                        help=f"Cache TTL in days (default: {VT_CACHE_TTL})")
    parser.add_argument("--cache-stats", dest="cache_stats", action="store_true",
                        help="Show cache contents and exit")
    parser.add_argument("--cache-purge", dest="cache_purge", action="store_true",
                        help="Purge expired cache entries and exit")
    parser.add_argument("--blacklist-stats", dest="blacklist_stats",
                        action="store_true",
                        help="Show permanent blacklist and exit")
    parser.add_argument("--blacklist-export", dest="blacklist_export",
                        metavar="FILE",
                        help="Export blacklist to CSV file and exit")
    args = parser.parse_args()

    # --- Management commands (run and exit) ---
    if args.cache_stats:
        cmd_cache_stats(args.cache_ttl)
        return
    if args.cache_purge:
        cmd_cache_purge(args.cache_ttl)
        return
    if args.blacklist_stats:
        cmd_blacklist_stats()
        return
    if args.blacklist_export:
        db = VTDB(db_path=VT_CACHE_DB)
        db.blacklist_export_csv(args.blacklist_export)
        db.close()
        return

    # Override VT key from CLI
    global VT_API_KEY, HEADERS_VT
    if args.vt_key:
        VT_API_KEY = args.vt_key
        HEADERS_VT = {"x-apikey": VT_API_KEY}

    # Cap days at 28 to enforce maximum retention window
    if args.days > 28:
        print(f"[*] Limiting requested specific days from {args.days} to maximum of 28.")
        args.days = 28

    # Step 1: Get the CSV
    csv_or_run_id = args.csv_file
    ips = []

    if csv_or_run_id:
        if not os.path.isfile(csv_or_run_id):
            print(f"Error: file not found: {csv_or_run_id}")
            sys.exit(1)
        print(f"Using existing CSV: {csv_or_run_id}")
        ips = extract_ips_from_csv(csv_or_run_id)
    else:
        print("[*] Calling fetch_from_faz()...", flush=True)
        # Returns run_id (UUID string) if successful
        run_id = fetch_from_faz(days_back=args.days)
        if not run_id:
            print("\n[!] FAZ download failed. You can also run with --csv <file>.")
            sys.exit(1)
        
        # Extract IPs from DB
        try:
            import sqlite3
            db_path = os.path.join(os.path.dirname(__file__), "vt_cache.db")
            conn = sqlite3.connect(db_path)
            c = conn.cursor()
            c.execute("SELECT ip FROM faz_logs WHERE run_id = ?", (run_id,))
            rows = c.fetchall() # list of tuples
            ips = [r[0] for r in rows]
            conn.close()
        except Exception as e:
            print(f"Error reading IPs from DB: {e}")
            sys.exit(1)

    if not ips:
        print("No public IPs found.")
        sys.exit(0)

    print(f"\nExtracted {len(ips)} unique public IP(s):")
    for ip in ips:
        print(f"  - {ip}")

    # Step 3: VirusTotal analysis (3-tier: blacklist -> cache -> API)
    results = analyze_ips_with_vt(
        ips,
        use_cache=not args.no_cache,
        cache_ttl=args.cache_ttl,
    )

    # Step 4: Summary
    print_summary(ips, results)

    # Step 5: Optional CSV export
    if args.output and results:
        save_results_csv(results, args.output)


if __name__ == "__main__":
    main()
