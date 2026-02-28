import sqlite3
db_path = r'vt_cache.db'
conn = sqlite3.connect(db_path)
c = conn.cursor()
min_ts = c.execute("SELECT MIN(timestamp) FROM faz_raw_events").fetchone()[0]
max_ts = c.execute("SELECT MAX(timestamp) FROM faz_raw_events").fetchone()[0]
cnt = c.execute("SELECT COUNT(*) FROM faz_raw_events").fetchone()[0]
print(f"DB Range: {min_ts} to {max_ts}, Count: {cnt}")
conn.close()
