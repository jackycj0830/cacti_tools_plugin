import subprocess
import time
import os
from datetime import datetime

# Configuration
TOTAL_RUNS = 6
INTERVAL_MINUTES = 30
LOG_DIR = "stability_tests"
SCRIPT_NAME = "analyze_faz_ips.py"

if not os.path.exists(LOG_DIR):
    os.makedirs(LOG_DIR)

print(f"[*] Starting stability test: {TOTAL_RUNS} runs every {INTERVAL_MINUTES} minutes.")

for i in range(1, TOTAL_RUNS + 1):
    timestamp = datetime.now().strftime("%Y%m%d_%H%M%S")
    log_file = os.path.join(LOG_DIR, f"run_{i}_{timestamp}.log")
    
    print(f"\n[Run {i}/{TOTAL_RUNS}] Started at {datetime.now().strftime('%H:%M:%S')}")
    print(f"[*] Logging to: {log_file}")
    
    # Run the analysis script
    try:
        with open(log_file, "w", encoding="utf-8") as f:
            # We use --days-back 7 or whatever is default to ensure we get a decent amount of logs
            process = subprocess.Popen(
                ["python", SCRIPT_NAME],
                stdout=subprocess.PIPE,
                stderr=subprocess.STDOUT,
                text=True,
                encoding="utf-8"
            )
            
            # Read output in real-time and write to log file
            for line in process.stdout:
                f.write(line)
                f.flush()
                # Also print key status lines to console for monitoring
                if "[FAZ]   Poll" in line or "[FAZ]   Cleaning up" in line or "Success" in line:
                    print(f"    {line.strip()}")
            
            process.wait()
            
        if process.returncode == 0:
            print(f"[Run {i}/{TOTAL_RUNS}] Completed successfully.")
        else:
            print(f"[Run {i}/{TOTAL_RUNS}] Failed with return code {process.returncode}.")
            
    except Exception as e:
        print(f"[Run {i}/{TOTAL_RUNS}] Error occurred: {e}")

    if i < TOTAL_RUNS:
        print(f"[*] Waiting {INTERVAL_MINUTES} minutes before next run...")
        time.sleep(INTERVAL_MINUTES * 60)

print("\n[*] Stability test finished.")
