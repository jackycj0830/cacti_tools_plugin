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
    python analyze_faz_ips.py --run-id <uuid>       # Skip FAZ, analyse from previous DB run
    python analyze_faz_ips.py --no-cache             # Skip cache, always query VT
    python analyze_faz_ips.py --cache-ttl 14         # Cache TTL in days (default 30)

Cache management:
    python analyze_faz_ips.py --cache-stats          # View cache contents
    python analyze_faz_ips.py --cache-purge          # Purge expired cache entries

Blacklist management:
    python analyze_faz_ips.py --blacklist-stats      # View all blacklisted IPs
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
import json
import os
import re
import sqlite3
import sys
import time
from datetime import datetime, timedelta

import requests
import urllib3

# ---------------------------------------------------------------------------
# Configuration
# ---------------------------------------------------------------------------

# VirusTotal Free API (v3)
VT_API_KEY = "4a8be222d7595073328d5aff0076fd5296d37637745007308da6569f06208e42"
#VT_API_KEY = "cc41a51907c23c2202471ac7d272f371d7a97918b296b5208fe35abce1e940fe"
VT_URL     = "https://www.virustotal.com/api/v3/ip_addresses"

# Free-tier rate limit: 4 requests / minute  ->  15 s between calls
VT_REQUEST_DELAY = 15

# SQLite DB settings
VT_CACHE_DB   = os.path.join(os.path.dirname(os.path.abspath(__file__)), "vt_cache.db")
VT_CACHE_TTL  = 30   # days before cached results are considered stale

# Suppress self-signed cert warnings
urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)

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

def get_last_faz_timestamp(devname=None):
    db_path = os.path.join(os.path.dirname(__file__), "vt_cache.db")
    try:
        conn = sqlite3.connect(db_path)
        c = conn.cursor()
        query = "SELECT MAX(timestamp) FROM faz_raw_events"
        params = ()
        if devname:
            query += " WHERE devname = ? OR faz_name = ?"
            params = (devname, devname)
        row = c.execute(query, params).fetchone()
        conn.close()
        if row and row[0]:
            return datetime.strptime(row[0], "%Y-%m-%d %H:%M:%S")
    except Exception:
        pass
    return None

def get_min_faz_timestamp(devname=None):
    db_path = os.path.join(os.path.dirname(__file__), "vt_cache.db")
    try:
        conn = sqlite3.connect(db_path)
        c = conn.cursor()
        query = "SELECT MIN(timestamp) FROM faz_raw_events"
        params = ()
        if devname:
            query += " WHERE devname = ? OR faz_name = ?"
            params = (devname, devname)
        row = c.execute(query, params).fetchone()
        conn.close()
        if row and row[0]:
            return datetime.strptime(row[0], "%Y-%m-%d %H:%M:%S")
    except Exception:
        pass
    return None

def faz_query_logs(faz_url, faz_token, faz_adom, filter_str, days_back=7, max_entries=500000, devname=None):
    """Query event logs directly from FAZ using JSON-RPC 2.0 API.

    Args:
        faz_url: Full URL to FAZ JSON-RPC API endpoint
        faz_token: Bearer token for FAZ API
        faz_adom: FAZ ADOM (usually 'root')
        filter_str: FAZ log filter string, e.g. "subtype == vpn && action == ssl-login-fail"
        days_back:  Used as fallback if db is empty (default 7 days)
        max_entries: Safety cap on total entries to fetch
        devname: The display name of the device being queried

    Returns:
        list of log entry dicts, or empty list on failure
    """
    today = datetime.now()
    
    last_ts = get_last_faz_timestamp(devname)
    min_ts = get_min_faz_timestamp(devname)
    target_start_dt = today - timedelta(days=days_back)
    
    end_dt = today

    if last_ts:
        if min_ts and target_start_dt < min_ts:
            # User wants a wider time window than we currently have in DB
            start_dt = target_start_dt
            end_dt = min_ts + timedelta(seconds=1) # Fetch up to the oldest event in DB
            print(f"[FAZ] Expanding sync window to cover {days_back} days. Fetching gap: {start_dt.strftime('%Y-%m-%d %H:%M:%S')} to {end_dt.strftime('%Y-%m-%d %H:%M:%S')}")
        else:
            # Only fetch delta since last sync
            start_dt = last_ts + timedelta(seconds=1)
            print(f"[FAZ] Last sync found. Fetching delta since: {start_dt.strftime('%Y-%m-%d %H:%M:%S')}")
    else:
        # Fallback to the full window if no DB exists
        start_dt = target_start_dt
        print(f"[FAZ] No previous sync found. Fetching full {days_back} days since: {start_dt.strftime('%Y-%m-%d %H:%M:%S')}")

    start = start_dt.strftime("%Y-%m-%dT%H:%M:%S")
    end   = end_dt.strftime("%Y-%m-%dT%H:%M:%S")

    headers_faz = {
        "Authorization": f"Bearer {faz_token}",
        "Content-Type":  "application/json",
    }

    # Step 1: Create search task
    search_payload = {
        "id": 1,
        "jsonrpc": "2.0",
        "method": "add",
        "params": [{
            "apiver": 3,
            "url": f"/logview/adom/{faz_adom}/logsearch",
            "logtype": "event",
            "time-order": "desc",
            "time-range": {"start": start, "end": end},
            "filter": filter_str,
            "limit": 1000,
            "ttl": 300,
        }],
    }
    try:
        resp = requests.post(faz_url, json=search_payload, headers=headers_faz,
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
    poll_delay = 2  # Start with 2s delay
    max_poll_delay = 16

    try:
        for attempt in range(300):         # up to ~10-20 min depending on backoff
            time.sleep(poll_delay)
            poll_payload = {
                "id": 2,
                "jsonrpc": "2.0",
                "method": "get",
                "params": [{
                    "apiver": 3,
                    "url": f"/logview/adom/{faz_adom}/logsearch/{tid}",
                    "limit": limit,
                    "offset": offset,
                }],
            }
            try:
                r2 = requests.post(faz_url, json=poll_payload, headers=headers_faz,
                                   verify=False, timeout=60)
                r2.raise_for_status()
                response_json = r2.json()
                r2_result = response_json.get("result", {})
            except Exception as e:
                print(f"[FAZ]   Poll error (attempt {attempt+1}): {e}")
                # Increment backoff even on error
                poll_delay = min(poll_delay * 2, max_poll_delay)
                continue

            if not isinstance(r2_result, dict):
                print(f"[FAZ]   Unexpected poll response: {response_json}")
                continue

            pct   = r2_result.get("percentage", 0)
            total = r2_result.get("total-lines", 0)
            data  = r2_result.get("data", [])
            
            raw_status = r2_result.get("status", "")
            if isinstance(raw_status, dict):
                status_msg = raw_status.get("message") or raw_status.get("Message")
                status = str(status_msg if status_msg else str(raw_status)).lower()
            else:
                status = str(raw_status).lower()

            new_records = 0
            if isinstance(data, list) and data:
                all_entries.extend(data)
                offset += len(data)
                new_records = len(data)

            if total > 0:
                print(f"[FAZ]   Poll {attempt+1}: {pct}% complete (fetched {len(all_entries)} of {total}) | Status: {status.title()}", flush=True)
            else:
                print(f"[FAZ]   Poll {attempt+1}: Fetching logs... ({len(all_entries)} records retrieved) | Status: {status.title()}", flush=True)

            # Backoff logic: if we got data or percentage increased, reset/reduce delay slightly
            # Otherwise, increase delay
            if new_records > 0 or pct > 0:
                poll_delay = max(2, poll_delay // 2)
            else:
                poll_delay = min(poll_delay * 2, max_poll_delay)

            is_done = pct >= 100 or status in ("done", "complete", "finished", "success") or "succeeded" in status
            
            if is_done:
                if total > 0 and len(all_entries) < total:
                    if new_records == 0:
                        print(f"[FAZ]   Warning: Expected {total} lines but server returned no more data. Stopping poll.")
                        break
                    continue # more pages
                
                if total == 0 and new_records > 0:
                    continue # keep fetching until empty page if total is unknown
                    
                break
                
            if status in ("error", "aborted", "timeout", "failed"):
                print(f"[FAZ]   Search task stopped prematurely due to status: {status}")
                break

            if len(all_entries) >= max_entries:
                print(f"[FAZ]   Reached max entries cap ({max_entries})")
                break
    finally:
        # Step 3: Delete search task to free resources
        delete_payload = {
            "id": 3,
            "jsonrpc": "2.0",
            "method": "delete",
            "params": [{
                "apiver": 3,
                "url": f"/logview/adom/{faz_adom}/logsearch/{tid}",
            }],
        }
        try:
            print(f"[FAZ]   Cleaning up search task (tid={tid}) ...")
            requests.post(faz_url, json=delete_payload, headers=headers_faz, verify=False, timeout=10)
        except Exception as e:
            print(f"[FAZ]   Failed to delete search task: {e}")

    return all_entries


def fetch_from_faz(days_back=7, target_device=None):
    """Full FAZ pipeline: query logs -> extract IPs -> save CSV."""
    import sqlite3
    db_path = os.path.join(os.path.dirname(__file__), "vt_cache.db")
    
    # Init DB and perform implicit migration if needed
    vtdb = VTDB() 
    
    try:
        conn = sqlite3.connect(db_path)
        c = conn.cursor()
        if target_device:
            devices = c.execute("SELECT ip, display_name, token FROM devices WHERE display_name = ?", (target_device,)).fetchall()
        else:
            devices = c.execute("SELECT ip, display_name, token FROM devices").fetchall()
        conn.close()
    except Exception as e:
        print(f"[FAZ] Error reading devices from database: {e}")
        return None

    if not devices:
        print("[FAZ] No devices configured in the database. Please add devices via the web UI.")
        return None

    print("=" * 60)
    print("  FortiAnalyzer SSLVPN Failed Login Query")
    print("=" * 60)

    all_raw_db_args = []
    
    for device in devices:
        ip, display_name, token = device
        faz_url = f"https://{ip}/jsonrpc"
        faz_adom = "root" # Hardcoded to root for now, could be made configurable later
        
        print(f"\n[FAZ] Connecting to {display_name} ({ip}) ...")

        entries = faz_query_logs(
            faz_url=faz_url,
            faz_token=token,
            faz_adom=faz_adom,
            filter_str="subtype == vpn && action == ssl-login-fail",
            days_back=days_back,
            devname=display_name,
        )

        if not entries:
            print(f"[FAZ] No log entries found for {display_name}.")
            continue

        print(f"[FAZ] Retrieved {len(entries)} NEW log entries for {display_name}.")

        # Step: Convert logs directly to DB list
        for entry in entries:
            remip = entry.get("remip", "")
            if remip and not is_private(remip):
                ts = f"{entry.get('date', '')} {entry.get('time', '')}".strip()
                # Try to format timestamp cleanly if FAZ gave full ISO
                if 'T' in ts: ts = ts.replace('T', ' ')
                raw_devname = entry.get("devname")
                devname = raw_devname if raw_devname and raw_devname.lower() != "unknown" else None
                
                if not devname:
                    raw_devid = entry.get("devid")
                    devname = raw_devid if raw_devid and raw_devid.lower() != "unknown" else None
                
                if not devname:
                    devname = display_name
                
                faz_name = display_name
                
                user = entry.get("user") or entry.get("xauthuser") or entry.get("unauthuser") or "Unknown"
                
                # If FAZ provided a devname, we often trust that over our internal display_name alias for grouped analysis
                all_raw_db_args.append((remip, ts, devname, faz_name, user))
                
    if not all_raw_db_args:
        print("[FAZ] No new public IP logs found across all devices.")
        return get_latest_run_id()

    print(f"\n[FAZ] Found {len(all_raw_db_args)} total new public IP events.")

    # Step: Database insertion of raw events
    try:
        import sqlite3
        import uuid
        db_path = os.path.join(os.path.dirname(__file__), "vt_cache.db")
        conn = sqlite3.connect(db_path)
        c = conn.cursor()
        
        c.execute("""
            CREATE TABLE IF NOT EXISTS faz_raw_events (
                ip TEXT,
                timestamp DATETIME,
                devname TEXT DEFAULT 'Unknown',
                faz_name TEXT DEFAULT 'Unknown',
                user TEXT DEFAULT 'Unknown',
                UNIQUE(ip, timestamp, devname)
            )
        """)
        c.execute("""
            CREATE TABLE IF NOT EXISTS ad_users_cache (
                username TEXT PRIMARY KEY,
                exists_in_ad INTEGER DEFAULT 0,
                locked_out INTEGER DEFAULT 0,
                lockout_time TEXT,
                password_expired INTEGER DEFAULT 0,
                pwd_last_set TEXT,
                last_logon TEXT,
                department TEXT,
                ad_site TEXT,
                office_phone TEXT
            )
        """)
        c.execute("""
            CREATE TABLE IF NOT EXISTS ad_sync_log (
                last_sync DATETIME
            )
        """)
        cur = c.execute("PRAGMA table_info(faz_raw_events)")
        columns = [col[1] for col in cur.fetchall()]
        if 'devname' not in columns:
            print("[DB] Migrating faz_raw_events to include 'devname'...")
            conn.executescript("""
                CREATE TABLE IF NOT EXISTS faz_raw_events_new (
                    ip TEXT,
                    timestamp DATETIME,
                    devname TEXT DEFAULT 'Unknown',
                    UNIQUE(ip, timestamp, devname)
                );
                INSERT INTO faz_raw_events_new (ip, timestamp) SELECT ip, timestamp FROM faz_raw_events;
                DROP TABLE faz_raw_events;
                ALTER TABLE faz_raw_events_new RENAME TO faz_raw_events;
            """)
            print("[DB] Migration complete.")
            
        if 'faz_name' not in columns:
            print("[DB] Migrating faz_raw_events to include 'faz_name'...")
            conn.executescript("""
                ALTER TABLE faz_raw_events ADD COLUMN faz_name TEXT DEFAULT 'Unknown';
            """)
            print("[DB] Migration for faz_name complete.")

        if 'user' not in columns:
            print("[DB] Migrating faz_raw_events to include 'user'...")
            conn.executescript("""
                ALTER TABLE faz_raw_events ADD COLUMN user TEXT DEFAULT 'Unknown';
            """)
            print("[DB] Migration for user complete.")

        # Insert raw delta events
        c.executemany("INSERT OR IGNORE INTO faz_raw_events (ip, timestamp, devname, faz_name, user) VALUES (?, ?, ?, ?, ?)", all_raw_db_args)
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
        print(f"     (Note: Summary includes all {total_events_in_window} events in DB over the last {days_back} days)")

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


# ---------------------------------------------------------------------------
# SQLite DB: Cache  +  Blacklist (permanent audit log)
# ---------------------------------------------------------------------------

class VTDB:
    """SQLite DB with two tables:

    1. vt_ip_cache   -- Temporary cache (auto-purged after TTL).
    2. vt_blacklist   -- Permanent audit log of all confirmed bad IPs.
                         NEVER auto-purged. Used for instant dedup.

    Lookup order:  blacklist -> cache -> VT API
    """

    def __init__(self, db_path=VT_CACHE_DB, ttl_days=VT_CACHE_TTL):
        self.db_path  = db_path
        self.ttl_days = ttl_days
        self.conn     = sqlite3.connect(db_path)
        self.conn.row_factory = sqlite3.Row
        self._create_tables()
        # Stats counters
        self.blacklist_hits = 0
        self.cache_hits     = 0
        self.api_misses     = 0

    def _create_tables(self):
        self.conn.executescript("""
            CREATE TABLE IF NOT EXISTS ad_users_cache (
                username TEXT PRIMARY KEY,
                exists_in_ad INTEGER DEFAULT 0,
                locked_out INTEGER DEFAULT 0,
                lockout_time TEXT,
                password_expired INTEGER DEFAULT 0,
                pwd_last_set TEXT,
                last_logon TEXT,
                department TEXT,
                ad_site TEXT,
                office_phone TEXT
            );

            CREATE TABLE IF NOT EXISTS ad_sync_log (
                last_sync DATETIME
            );
            
            CREATE TABLE IF NOT EXISTS vt_ip_cache (
                ip            TEXT PRIMARY KEY,
                result_json   TEXT NOT NULL,
                queried_at    TEXT NOT NULL,
                verdict       TEXT,
                malicious     INTEGER DEFAULT 0,
                suspicious    INTEGER DEFAULT 0,
                as_owner      TEXT,
                country       TEXT
            );

            CREATE TABLE IF NOT EXISTS vt_blacklist (
                ip            TEXT PRIMARY KEY,
                verdict       TEXT NOT NULL,
                malicious     INTEGER DEFAULT 0,
                suspicious    INTEGER DEFAULT 0,
                as_owner      TEXT,
                country       TEXT,
                network       TEXT,
                flagged_vendors TEXT,
                first_seen    TEXT NOT NULL,
                last_seen     TEXT NOT NULL,
                times_seen    INTEGER DEFAULT 1,
                result_json   TEXT
            );
            
            CREATE TABLE IF NOT EXISTS devices (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                ip TEXT NOT NULL,
                display_name TEXT NOT NULL,
                token TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS faz_raw_events (
                ip TEXT,
                timestamp DATETIME,
                devname TEXT DEFAULT 'Unknown',
                faz_name TEXT DEFAULT 'Unknown',
                user TEXT DEFAULT 'Unknown',
                UNIQUE(ip, timestamp, devname)
            );

            CREATE TABLE IF NOT EXISTS vt_pending_ips (
                ip TEXT PRIMARY KEY,
                added_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
        """)
        
        # Seed default legacy device if devices is empty
        cur = self.conn.execute("SELECT COUNT(*) FROM devices")
        if cur.fetchone()[0] == 0:
            print("[DB] Seeding default device from legacy config.")
            self.conn.execute("INSERT INTO devices (ip, display_name, token) VALUES ('172.16.0.4', 'Local-FortiGate', 'waxk81r3g9fmzps4nrup55gn4huq17qc')")
            
        try:
            cur = self.conn.execute("PRAGMA table_info(faz_raw_events)")
            columns = [col[1] for col in cur.fetchall()]
            if columns and 'devname' not in columns:
                self.conn.executescript("""
                    CREATE TABLE IF NOT EXISTS faz_raw_events_new (
                        ip TEXT,
                        timestamp DATETIME,
                        devname TEXT DEFAULT 'Unknown',
                        user TEXT DEFAULT 'Unknown',
                        UNIQUE(ip, timestamp, devname)
                    );
                    INSERT INTO faz_raw_events_new (ip, timestamp) SELECT ip, timestamp FROM faz_raw_events;
                    DROP TABLE faz_raw_events;
                    ALTER TABLE faz_raw_events_new RENAME TO faz_raw_events;
                """)
                
            if columns and 'faz_name' not in columns:
                self.conn.executescript("""
                    ALTER TABLE faz_raw_events ADD COLUMN faz_name TEXT DEFAULT 'Unknown';
                """)
                
            if columns and 'user' not in columns:
                self.conn.executescript("""
                    ALTER TABLE faz_raw_events ADD COLUMN user TEXT DEFAULT 'Unknown';
                """)
            
            # AD cache migration check
            cur = self.conn.execute("PRAGMA table_info(ad_users_cache)")
            ad_columns = [col[1] for col in cur.fetchall()]
            if ad_columns and 'locked_out' not in ad_columns:
                print("[DB] Migrating ad_users_cache to include detailed fields...")
                self.conn.executescript("""
                    ALTER TABLE ad_users_cache ADD COLUMN exists_in_ad INTEGER DEFAULT 0;
                    ALTER TABLE ad_users_cache ADD COLUMN locked_out INTEGER DEFAULT 0;
                    ALTER TABLE ad_users_cache ADD COLUMN lockout_time TEXT;
                    ALTER TABLE ad_users_cache ADD COLUMN password_expired INTEGER DEFAULT 0;
                    ALTER TABLE ad_users_cache ADD COLUMN pwd_last_set TEXT;
                    ALTER TABLE ad_users_cache ADD COLUMN last_logon TEXT;
                    ALTER TABLE ad_users_cache ADD COLUMN department TEXT;
                    ALTER TABLE ad_users_cache ADD COLUMN ad_site TEXT;
                    ALTER TABLE ad_users_cache ADD COLUMN office_phone TEXT;
                """)
        except Exception:
            pass
            
        self.conn.commit()

    # ---------------------------------------------------------------
    # Pending IPs (queue for quota limits)
    # ---------------------------------------------------------------

    def pending_add(self, ips):
        """Add list of IPs to pending queue."""
        now = datetime.now().isoformat()
        insert_args = [(ip, now) for ip in ips]
        self.conn.executemany(
            "INSERT OR IGNORE INTO vt_pending_ips (ip, added_at) VALUES (?, ?)", 
            insert_args
        )
        self.conn.commit()

    def pending_get_all(self):
        """Get all pending IPs ordered by oldest first."""
        rows = self.conn.execute("SELECT ip FROM vt_pending_ips ORDER BY added_at ASC").fetchall()
        return [r["ip"] for r in rows]

    def pending_remove(self, ip):
        """Remove an IP from the pending queue."""
        self.conn.execute("DELETE FROM vt_pending_ips WHERE ip = ?", (ip,))
        self.conn.commit()

    def pending_count(self):
        """Count pending IPs."""
        row = self.conn.execute("SELECT COUNT(*) FROM vt_pending_ips").fetchone()
        return row[0] if row else 0

    # ---------------------------------------------------------------
    # Blacklist (permanent, never auto-purged)
    # ---------------------------------------------------------------

    def blacklist_check(self, ip):
        """Return cached result dict from blacklist if found, else None."""
        row = self.conn.execute(
            "SELECT result_json, last_seen FROM vt_blacklist WHERE ip = ?",
            (ip,)
        ).fetchone()
        if row is None:
            return None
        # Update last_seen and times_seen
        self.conn.execute(
            "UPDATE vt_blacklist SET last_seen = ?, times_seen = times_seen + 1 "
            "WHERE ip = ?",
            (datetime.now().isoformat(), ip)
        )
        self.conn.commit()
        self.blacklist_hits += 1
        return json.loads(row["result_json"])

    def blacklist_add(self, ip, result):
        """Add an IP to the permanent blacklist."""
        vendors = result.get("flagged_vendors", [])
        vendor_str = "; ".join(
            f"{v['vendor']}({v['category']})" for v in vendors
        )
        now = datetime.now().isoformat()
        self.conn.execute("""
            INSERT OR REPLACE INTO vt_blacklist
                (ip, verdict, malicious, suspicious, as_owner, country,
                 network, flagged_vendors, first_seen, last_seen, times_seen,
                 result_json)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?)
        """, (
            ip,
            result.get("verdict", ""),
            result.get("malicious", 0),
            result.get("suspicious", 0),
            result.get("as_owner", ""),
            result.get("country", ""),
            result.get("network", ""),
            vendor_str,
            now, now,
            json.dumps(result, default=str),
        ))
        self.conn.commit()

    def blacklist_count(self):
        row = self.conn.execute("SELECT COUNT(*) FROM vt_blacklist").fetchone()
        return row[0] if row else 0

    def blacklist_list_all(self):
        rows = self.conn.execute(
            "SELECT ip, verdict, malicious, suspicious, as_owner, country, "
            "network, flagged_vendors, first_seen, last_seen, times_seen "
            "FROM vt_blacklist ORDER BY malicious DESC, last_seen DESC"
        ).fetchall()
        return [dict(r) for r in rows]

    # ---------------------------------------------------------------
    # Cache (temporary, auto-purged after TTL)
    # ---------------------------------------------------------------

    def cache_get(self, ip):
        """Return cached result dict if fresh, else None."""
        row = self.conn.execute(
            "SELECT result_json, queried_at FROM vt_ip_cache WHERE ip = ?",
            (ip,)
        ).fetchone()
        if row is None:
            self.api_misses += 1
            return None
        queried_at = datetime.fromisoformat(row["queried_at"])
        if datetime.now() - queried_at > timedelta(days=self.ttl_days):
            self.api_misses += 1
            return None   # Expired
        self.cache_hits += 1
        return json.loads(row["result_json"])

    def cache_put(self, ip, result):
        """Store a VT result dict in the cache."""
        self.conn.execute("""
            INSERT OR REPLACE INTO vt_ip_cache
                (ip, result_json, queried_at, verdict, malicious, suspicious,
                 as_owner, country)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        """, (
            ip,
            json.dumps(result, default=str),
            datetime.now().isoformat(),
            result.get("verdict", ""),
            result.get("malicious", 0),
            result.get("suspicious", 0),
            result.get("as_owner", ""),
            result.get("country", ""),
        ))
        self.conn.commit()

    def cache_count(self):
        row = self.conn.execute("SELECT COUNT(*) FROM vt_ip_cache").fetchone()
        return row[0] if row else 0

    def cache_purge_expired(self):
        """Delete cache entries older than TTL. Returns rows removed."""
        cutoff = (datetime.now() - timedelta(days=self.ttl_days)).isoformat()
        cur = self.conn.execute(
            "DELETE FROM vt_ip_cache WHERE queried_at < ?", (cutoff,)
        )
        removed = cur.rowcount
        self.conn.commit()
        return removed

    def faz_logs_purge_expired(self, days=28):
        """Delete raw FAZ events older than the specified retention period."""
        cutoff = (datetime.now() - timedelta(days=days)).strftime("%Y-%m-%d %H:%M:%S")
        cur = self.conn.execute(
            "DELETE FROM faz_raw_events WHERE timestamp < ?", (cutoff,)
        )
        removed = cur.rowcount
        self.conn.commit()
        return removed

    def cache_list_all(self):
        rows = self.conn.execute(
            "SELECT ip, queried_at, verdict, malicious, suspicious, "
            "as_owner, country FROM vt_ip_cache ORDER BY queried_at DESC"
        ).fetchall()
        return [dict(r) for r in rows]

    # ---------------------------------------------------------------
    # Shared helpers
    # ---------------------------------------------------------------

    def vacuum(self):
        self.conn.execute("VACUUM")

    def db_size_kb(self):
        try:
            return os.path.getsize(self.db_path) / 1024
        except OSError:
            return 0

    def auto_maintenance(self):
        """Run on startup: purge expired cache entries and VACUUM."""
        removed_cache = self.cache_purge_expired()
        removed_faz = self.faz_logs_purge_expired(days=28)
        if removed_cache > 0 or removed_faz > 0:
            self.vacuum()
            print(f"{CYAN}[DB] Auto-purged {removed_cache} VT cache entry(ies) and {removed_faz} FAZ records, "
                  f"DB size: {self.db_size_kb():.1f} KB{RESET}")

    def close(self):
        self.conn.close()


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
            try:
                error_code = resp.json().get("error", {}).get("code", "")
                if error_code == "QuotaExceededError":
                    return "QUOTA_EXCEEDED"
            except Exception:
                pass
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
            "valid_vt_result": True,
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
        "ip": ip, "valid_vt_result": False, "malicious": 0, "suspicious": 0, "undetected": 0,
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
    print(f"  IPs to check : {len(ips)} (Includes cache and blacklist matches)")
    cache_status = f"ON  (TTL={cache_ttl}d)" if db else "OFF"
    print(f"  Cache        : {cache_status}")
    bl_status = f"{db.blacklist_count()} known bad IPs" if db else "OFF"
    print(f"  Blacklist    : {bl_status}")
    print(f"  Rate limit   : 1 req / {VT_REQUEST_DELAY}s  (API calls only)")
    print("-" * 70)

    results = []
    api_calls_made = 0
    ips_to_fetch = []

    if db:
        pending_ips = db.pending_get_all()
        if pending_ips:
            print(f"\n{CYAN}[DB] Found {len(pending_ips)} pending IP(s) from previous interrupted run.{RESET}")
            new_ips = [ip for ip in ips if ip not in pending_ips]
            ips = pending_ips + new_ips
            db.conn.execute("DELETE FROM vt_pending_ips")
            db.conn.commit()

    # --- Phase 1: Silent Filtering (Blacklist & Cache) ---
    for ip in ips:
        found_locally = False
        if db:
            # Tier 1: Check blacklist (permanent, instant)
            bl_result = db.blacklist_check(ip)
            if bl_result is not None:
                results.append(bl_result)
                found_locally = True
                continue

            # Tier 2: Check cache (temporary, instant)
            cached_result = db.cache_get(ip)
            if cached_result is not None:
                results.append(cached_result)
                found_locally = True
                continue

        if not found_locally:
            ips_to_fetch.append(ip)

    fetch_count = len(ips_to_fetch)
    bl_hits = db.blacklist_hits if db else 0
    ch_hits = db.cache_hits if db else 0
    print(f"\n{CYAN}[Phase 1]{RESET} Checked {len(ips)} IPs: {bl_hits} Blacklisted, {ch_hits} Cached.")
    if fetch_count > 0:
        print(f"{CYAN}[Phase 2]{RESET} {fetch_count} IPs require VirusTotal API fetch.")
        print("-" * 70)
    else:
        print(f"{CYAN}[Phase 2]{RESET} All IPs found locally. Skipping API fetches.")

    # --- Phase 2: Query VT API (rate-limited timeline) ---
    for i, ip in enumerate(ips_to_fetch, 1):
        if api_calls_made > 0:
            print(f"  [{i:03}/{fetch_count:03}] {ip:<16} | {DIM}[WAITING {VT_REQUEST_DELAY}s...]{RESET}".ljust(60), end="\r", flush=True)
            time.sleep(VT_REQUEST_DELAY)

        print(f"  [{i:03}/{fetch_count:03}] {ip:<16} | {DIM}[FETCHING API...]{RESET}".ljust(60), end="\r", flush=True)
        result = vt_check_ip(ip)
        api_calls_made += 1

        # Handle rate limiting
        if result == "RATE_LIMIT":
            print(f"  [{i:03}/{fetch_count:03}] {ip:<16} | {DIM}[RATE LIMITED. WAITING 60s...]{RESET}".ljust(60), end="\r", flush=True)
            time.sleep(60)
            result = vt_check_ip(ip)
            api_calls_made += 1

        if result == "QUOTA_EXCEEDED":
            print() # Clear the end="\r" line
            print(f"\n{VERDICT_COLORS['MALICIOUS']}{BOLD}")
            print("=" * 70)
            print("  VIRUSTOTAL DAILY QUOTA EXCEEDED (500 requests/day)")
            print("=" * 70)
            print(f"  Quota resets at 00:00 UTC.")
            print(f"  Saving {fetch_count - i + 1} remaining IPs to database for the next run.")
            print("=" * 70 + RESET + "\n")
            if db:
                db.pending_add(ips_to_fetch[i-1:])
                # Update latest_stats.json to inform the UI
                stats_path = os.path.join(os.path.dirname(__file__), "web", "latest_stats.json")
                if os.path.exists(stats_path):
                    try:
                        with open(stats_path, 'r') as f:
                            stats = json.load(f)
                        stats["quota_exceeded"] = True
                        stats["pending_ips_count"] = fetch_count - i + 1
                        with open(stats_path, 'w') as f:
                            json.dump(stats, f)
                    except Exception as e:
                        pass
            break

        if result == "RATE_LIMIT" or result is None:
            verdict = "UNKNOWN"
            color = VERDICT_COLORS.get(verdict, "")
            print(f"  [{i:03}/{fetch_count:03}] {ip:<16} | {color}{verdict:<10}{RESET} | (Failed to fetch)".ljust(70))
            result = _empty_result(ip)
        else:
            verdict = classify(result)
            result["verdict"] = verdict

            # Store in DB (only if we got real data)
            if db and result.get("valid_vt_result"):
                db.cache_put(ip, result)
                # Auto-add to permanent blacklist if malicious or suspicious
                if verdict in ("MALICIOUS", "SUSPICIOUS"):
                    db.blacklist_add(ip, result)

            color = VERDICT_COLORS.get(verdict, "")
            m = result.get('malicious', 0)
            s = result.get('suspicious', 0)
            print(f"  [{i:03}/{fetch_count:03}] {ip:<16} | {color}{verdict:<10}{RESET} | (malicious={m} suspicious={s})".ljust(70))

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

def sync_ad_users_cache():
    """
    Run the PowerShell script to fetch all enabled AD accounts and cache them
    in the local SQLite database. Runs at most once every 12 hours.
    """
    db_path = os.path.join(os.path.dirname(__file__), "vt_cache.db")
    try:
        conn = sqlite3.connect(db_path)
        c = conn.cursor()
        
        c.execute("""
            CREATE TABLE IF NOT EXISTS ad_users_cache (
                username TEXT PRIMARY KEY
            )
        """)
        c.execute("""
            CREATE TABLE IF NOT EXISTS ad_sync_log (
                last_sync DATETIME
            )
        """)
        
        # Check last sync time
        c.execute("SELECT MAX(last_sync) FROM ad_sync_log")
        row = c.fetchone()
        last_sync_str = row[0] if row else None
        
        needs_sync = True
        if last_sync_str:
            last_sync_dt = datetime.strptime(last_sync_str, "%Y-%m-%d %H:%M:%S")
            if datetime.now() - last_sync_dt < timedelta(hours=12):
                needs_sync = False
                
        if not needs_sync:
            # print("[AD Cache] Sync ran within the last 12 hours. Skipping.")
            return

        print("[AD Cache] Syncing top targeted AD user profiles...", flush=True)
        
        # 1. Get Top 50 most failed users from faz_raw_events to sync their details
        c.execute("""
            SELECT user, COUNT(*) as count 
            FROM faz_raw_events 
            WHERE user != 'Unknown' AND user != '' 
            GROUP BY user 
            ORDER BY count DESC 
            LIMIT 50
        """)
        logged_users = [row[0] for row in c.fetchall()]
        
        if not logged_users:
            print("[AD Cache] No users found in logs to sync. Skipping.")
            return

        import subprocess
        script_path = os.path.join(os.path.dirname(__file__), "check_ad_users_adsi.ps1")
        
        # Syncing in batches if there are many users to avoid command line length limits
        batch_size = 50
        all_ad_data = []
        for i in range(0, len(logged_users), batch_size):
            batch = logged_users[i:i+batch_size]
            user_list_str = ",".join(batch)
            
            cmd = ['powershell', '-NoProfile', '-ExecutionPolicy', 'Bypass', '-File', script_path, '-UsernamesList', user_list_str]
            result = subprocess.run(cmd, capture_output=True, text=True, check=False)
            
            if result.returncode == 0 and result.stdout.strip():
                try:
                    batch_data = json.loads(result.stdout.strip())
                    if isinstance(batch_data, list):
                        all_ad_data.extend(batch_data)
                except json.JSONDecodeError:
                    pass
        
        if not all_ad_data:
            print("[AD Cache] Warning: No AD data could be retrieved.")
            return

        print(f"[AD Cache] Fetched {len(all_ad_data)} AD profiles. Updating database...")
        
        # Clear and rebuild cache for these users
        # We don't delete all users, just update/replace for the ones we just queried
        insert_sql = """
            INSERT OR REPLACE INTO ad_users_cache (
                username, exists_in_ad, locked_out, lockout_time, password_expired, 
                pwd_last_set, last_logon, department, ad_site, office_phone
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        """
        
        insert_data = []
        for u in all_ad_data:
            insert_data.append((
                u['Username'].strip().lower(),
                1 if u['Exists'] else 0,
                1 if (u['LockedOut'] is True or str(u['LockedOut']).lower() == 'true') else 0,
                u['LockoutTime'],
                1 if (u['PasswordExpired'] is True or str(u['PasswordExpired']).lower() == 'true') else 0,
                u['PwdLastSet'],
                u['LastLogon'],
                u['Department'],
                u['AdSite'],
                u['OfficePhone']
            ))
            
        c.executemany(insert_sql, insert_data)
        
        # Log this sync
        now_str = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
        c.execute("INSERT INTO ad_sync_log (last_sync) VALUES (?)", (now_str,))
        
        conn.commit()
        print("[AD Cache] Sync completed successfully.")
        
    except Exception as e:
        print(f"[AD Cache] Exception during AD sync: {e}")
    finally:
        if 'conn' in locals() and conn:
            conn.close()

def main():
    parser = argparse.ArgumentParser(
        description="Fetch FAZ SSLVPN reports & verify IPs via VirusTotal")
    parser.add_argument("--run-id", dest="run_id",
                        help="Run VT analysis against a past dataset already stored in the DB (skip FAZ download)")
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
    parser.add_argument("--device", dest="device", help="Specific device display_name to fetch logs from (e.g. FAZ_SPO)")
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

    # Override VT key from CLI
    global VT_API_KEY, HEADERS_VT
    if args.vt_key:
        VT_API_KEY = args.vt_key
        HEADERS_VT = {"x-apikey": VT_API_KEY}

    # Cap days at 28 to enforce maximum retention window
    if args.days > 28:
        print(f"[*] Limiting requested specific days from {args.days} to maximum of 28.")
        args.days = 28

    # Step 0: Refresh AD Username Cache periodically 
    sync_ad_users_cache()

    # Step 1: Get the IPs (from past run ID or fresh from FAZ)
    ips = []
    run_id = args.run_id

    if run_id:
        print(f"[*] Re-analysing existing DB Run ID: {run_id}")
    else:
        print("[*] Calling fetch_from_faz()...", flush=True)
        # Returns run_id (UUID string) if successful
        run_id = fetch_from_faz(days_back=args.days, target_device=args.device)
        if not run_id:
            print("\n[!] FAZ analysis failed.")
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

    print(f"\nExtracted {len(ips)} unique public IP(s) (>= 50 failed attempts):")
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


if __name__ == "__main__":
    main()
