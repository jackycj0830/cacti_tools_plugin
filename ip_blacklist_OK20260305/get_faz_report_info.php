<?php
/**
 * get_faz_report_info.php
 * Replaces get_faz_report_info.py
 */

define('FAZ_IP', '172.16.0.4');
define('FAZ_TOKEN', 'waxk81r3g9fmzps4nrup55gn4huq17qc');
define('FAZ_URL', 'https://' . FAZ_IP . '/jsonrpc');
define('FAZ_ADOM', 'root');

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

$paths_to_try = [
    "/pm/config/adom/" . FAZ_ADOM . "/obj/report/layout",
    "/cli/global/report/layout",
];

foreach ($paths_to_try as $url_path) {
    echo "Trying {$url_path}...\n";
    $payload = [
        "id" => 1,
        "jsonrpc" => "2.0",
        "method" => "get",
        "params" => [[
            "url" => $url_path
        ]]
    ];
    
    try {
        $data = faz_api_request($payload);
        if (!isset($data['error'])) {
            echo "SUCCESS with {$url_path}:\n";
            echo substr(json_encode($data['result'] ?? [], JSON_PRETTY_PRINT), 0, 500) . "\n...\n";
        } else {
            echo "Failed: " . ($data['error']['message'] ?? '') . "\n";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
