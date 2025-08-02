<?php
/**
 * Check HTML to PHP Conversion Status
 * 
 * This script checks which HTML files have been converted to PHP
 * and provides a status report.
 */

echo "🔍 Checking HTML to PHP Conversion Status...\n\n";

// Get all HTML files
$htmlFiles = glob('*.html');
$phpFiles = glob('*.php');

// Remove system files from PHP list
$systemPhpFiles = [
    'batch_convert_html_to_php.php',
    'batch_create_remaining_files.php', 
    'convert_to_php.php',
    'check_conversion_status.php',
    'test-multilingual-system.php',
    'documentation.php'
];

$documentationPhpFiles = array_diff($phpFiles, $systemPhpFiles);

echo "📊 CONVERSION STATUS SUMMARY\n";
echo "============================\n\n";

echo "📁 Total HTML files: " . count($htmlFiles) . "\n";
echo "📄 Total PHP files (documentation): " . count($documentationPhpFiles) . "\n";
echo "🔧 System PHP files: " . count($systemPhpFiles) . "\n\n";

// Check which HTML files have PHP equivalents
$converted = [];
$notConverted = [];

foreach ($htmlFiles as $htmlFile) {
    $phpFile = str_replace('.html', '.php', $htmlFile);
    if (in_array($phpFile, $documentationPhpFiles)) {
        $converted[] = $htmlFile;
    } else {
        $notConverted[] = $htmlFile;
    }
}

echo "✅ CONVERTED FILES (" . count($converted) . " files):\n";
echo "=====================================\n";
foreach ($converted as $file) {
    echo "  ✓ " . str_replace('.html', '', $file) . "\n";
}

echo "\n🔄 NOT YET CONVERTED (" . count($notConverted) . " files):\n";
echo "=========================================\n";
foreach ($notConverted as $file) {
    echo "  ⏳ " . str_replace('.html', '', $file) . "\n";
}

$conversionRate = round((count($converted) / count($htmlFiles)) * 100, 1);
echo "\n📈 CONVERSION PROGRESS: {$conversionRate}%\n";

// Progress bar
$barLength = 50;
$filledLength = round(($conversionRate / 100) * $barLength);
$bar = str_repeat('█', $filledLength) . str_repeat('░', $barLength - $filledLength);
echo "Progress: [{$bar}] {$conversionRate}%\n\n";

echo "🎯 NEXT PRIORITY FILES TO CONVERT:\n";
echo "==================================\n";

$priorityFiles = [
    'Settings-Auth-Local.html',
    'Settings-Auth-LDAP.html', 
    'Settings-Auth-Basic.html',
    'Settings-Domains.html',
    'User-Group-Management.html',
    'System-Utilities.html',
    'Data-Debug.html',
    'External-Links.html',
    'Reports-Admin.html',
    'Reports-User.html'
];

foreach ($priorityFiles as $file) {
    if (in_array($file, $notConverted)) {
        echo "  🎯 " . str_replace('.html', '', $file) . "\n";
    }
}

echo "\n✨ Conversion status check completed!\n";
?>
