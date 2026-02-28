import requests
import json
import urllib3

urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)

FAZ_IP = "172.16.0.4"
FAZ_TOKEN = "waxk81r3g9fmzps4nrup55gn4huq17qc"
FAZ_URL = f"https://{FAZ_IP}/jsonrpc"
FAZ_ADOM = "root"

headers = {
    "Authorization": f"Bearer {FAZ_TOKEN}",
    "Content-Type": "application/json",
}

paths_to_try = [
    f"/pm/config/adom/{FAZ_ADOM}/obj/report/layout",
    f"/cli/global/report/layout",
]

for url_path in paths_to_try:
    print(f"Trying {url_path}...")
    payload = {
        "id": 1,
        "jsonrpc": "2.0",
        "method": "get",
        "params": [{
            "url": url_path,
        }],
    }
    
    try:
        resp = requests.post(FAZ_URL, json=payload, headers=headers, verify=False)
        data = resp.json()
        if "error" not in data:
            print(f"SUCCESS with {url_path}:")
            # print up to 500 characters of the result to understand structure
            print(json.dumps(data.get("result", []), indent=2)[:500])
            print("...")
        else:
            print(f"Failed: {data['error'].get('message', '')}")
    except Exception as e:
        print(f"Error: {e}")
