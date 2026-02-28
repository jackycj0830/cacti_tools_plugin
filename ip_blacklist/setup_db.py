import sqlite3
import os

db_path = os.path.join(os.path.dirname(__file__), 'vt_cache.db')
print(f"Connecting to database at {db_path}")

try:
    conn = sqlite3.connect(db_path)
    c = conn.cursor()
    c.executescript("""
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
    CREATE INDEX IF NOT EXISTS idx_faz_logs_ip ON faz_logs(ip);
    CREATE INDEX IF NOT EXISTS idx_faz_logs_imported_at ON faz_logs(imported_at);
    """)
    conn.commit()
    conn.close()
    print("Table faz_logs created successfully.")
except Exception as e:
    print(f"Error creating table: {e}")
