<?php
/**
 * Get_FAZ_Black_IP_CSV.php
 * Replaces Get_FAZ_Black_IP_CSV.py
 * Downloads the latest reports from FAZ as CSV.
 */

define('FAZ_IP', '172.16.0.4');
define('FAZ_TOKEN', 'waxk81r3g9fmzps4nrup55gn4huq17qc');
define('FAZ_URL', 'https://' . FAZ_IP . '/jsonrpc');

function faz_api_request($payload) {
    $ch = curl_init(FAZ_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . FAZ_TOKEN,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

function download_csv($report_id, $filename) {
    $payload = [
        "id" => 1,
        "method" => "exec",
        "params" => [[
            "url" => "/report/adom/root/generated/{$report_id}/download",
            "data" => ["format" => "csv"]
        ]]
    ];
    $response = faz_api_request($payload);
    $result = $response['result'][0]['data'] ?? '';
    if ($result) {
        file_put_contents("{$filename}.csv", base64_decode($result));
        echo "Downloaded: {$filename}.csv\n";
    }
}

// 1. Get List of Reports
$list_payload = [
    "id" => 1,
    "method" => "get",
    "params" => [["url" => "/report/adom/root/generated"]]
];
$resp = faz_api_request($list_payload);
echo "DEBUG - Raw Response retrieved.\n";
$reports = $resp['result'][0]['data'] ?? [];

// 2. Filter for today's reports (Example logic, can just download all or loop)
$today = date('Y-m-d');
foreach ($reports as $report) {
    if (strpos($report['name'] ?? '', $today) !== false) { // Match current date
        download_csv($report['tid'], $report['name']);
    }
}
