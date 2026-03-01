<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/database/IPCache.php';

echo "=== Testing Archive Stats ===\n\n";

try {
    $c = new IPCache();
    echo "IPCache created OK\n";
    
    // Test archive_stats
    $stats = $c->getArchiveStats();
    echo "\n--- archive_stats ---\n";
    echo json_encode($stats, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    
    // Test archive_stats_detailed
    $detailed = $c->getArchiveStatsDetailed();
    echo "\n--- archive_stats_detailed ---\n";
    if (isset($detailed['error'])) {
        echo "ERROR: " . $detailed['error'] . "\n";
    } else {
        echo "Keys: " . implode(', ', array_keys($detailed)) . "\n";
        echo "Total Archived: " . ($detailed['totalArchived'] ?? 'N/A') . "\n";
    }
    
    // Test archive_countries
    $countries = $c->getArchiveCountries();
    echo "\n--- archive_countries ---\n";
    if (isset($countries['error'])) {
        echo "ERROR: " . $countries['error'] . "\n";
    } else {
        echo json_encode($countries, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    }
    
} catch (Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
