import requests
import json
import base64
import urllib3

# Suppress SSL warnings for self-signed FAZ certs
urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)

FAZ_IP = "172.16.0.4"
TOKEN = "waxk81r3g9fmzps4nrup55gn4huq17qc"
URL = f"https://{FAZ_IP}/jsonrpc"

headers = {
    "Authorization": f"Bearer {TOKEN}",
    "Content-Type": "application/json"
}

def download_csv(report_id, filename):
    payload = {
        "id": 1,
        "method": "exec",
        "params": [{
            "url": f"/report/adom/root/generated/{report_id}/download",
            "data": {"format": "csv"}
        }]
    }
    response = requests.post(URL, json=payload, headers=headers, verify=False)
    # Extract the data field (usually base64)
    result = response.json().get('result', [{}])[0].get('data', '')
    if result:
        with open(f"{filename}.csv", "wb") as f:
            f.write(base64.b64decode(result))
        print(f"Downloaded: {filename}.csv")

# 1. Get List of Reports
list_payload = {
    "id": 1,
    "method": "get",
    "params": [{"url": "/report/adom/root/generated"}]
}

resp = requests.post(URL, json=list_payload, headers=headers, verify=False)
print(f"DEBUG - Raw Response: {resp.text}")
reports = resp.json().get('result', [{}])[0].get('data', [])

# 2. Filter for today's reports (Example: matches any from 2026-02-15)
for report in reports:
    if "2026-02-15" in report.get('name', ''):
        download_csv(report['tid'], report['name'])