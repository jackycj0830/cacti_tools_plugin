<?php
/**
 * Batch HTML to PHP Converter for Cacti Documentation
 * 
 * This script converts HTML documentation files to PHP versions with multilingual support
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Configuration
$sourceDir = __DIR__;
$outputDir = __DIR__;

// List of HTML files to convert (excluding already converted ones)
$htmlFiles = [
    // Settings files
    'Settings-General.html',
    'Settings-Paths.html',
    'Settings-Device-Defaults.html',
    'Settings-Poller.html',
    'Settings-Data.html',
    'Settings-Visual.html',
    'Settings-Performance.html',
    'Settings-Spikes.html',
    'Settings-Mail-Reporting-DNS.html',
    'Settings-Auth-Local.html',
    'Settings-Auth-LDAP.html',
    'Settings-Auth-Basic.html',
    'Settings-Domains.html',
    
    // User management files
    'User-Management.html',
    'User-Group-Management.html',
    'User-Domains.html',
    
    // Utilities files
    'System-Utilities.html',
    'Data-Debug.html',
    'External-Links.html',
    
    // Reporting files
    'Reports-Admin.html',
    'Reports-User.html',
    'Reports-Items.html',
    'Reports-Preview.html',
    'Reports-Events.html',
    'Reports-Other-Options.html',
    
    // Advanced topics
    'Cacti-Log.html',
    'Command-Line-Scripts.html',
    'PHP-Script-Server.html',
    'Boost.html',
    'Frequently-Asked-Questions.html',
    'Variables.html',
    'RRDtool-Specific-Features.html',
    'RRDproxy.html',
    'Spikekill.html',
    'Debugging.html',
    'Version-Specific-Release-Notes.html'
];

/**
 * Convert HTML file to PHP with multilingual support
 */
function convertHtmlToPhp($htmlFile, $sourceDir, $outputDir) {
    $htmlPath = $sourceDir . '/' . $htmlFile;
    $phpFile = str_replace('.html', '.php', $htmlFile);
    $phpPath = $outputDir . '/' . $phpFile;
    
    if (!file_exists($htmlPath)) {
        echo "❌ HTML file not found: $htmlFile\n";
        return false;
    }
    
    if (file_exists($phpPath)) {
        echo "⚠️  PHP file already exists: $phpFile (skipping)\n";
        return false;
    }
    
    // Read HTML content
    $htmlContent = file_get_contents($htmlPath);
    
    // Extract title and main content
    $title = extractTitle($htmlContent);
    $bodyContent = extractBodyContent($htmlContent);
    
    // Generate translation key
    $translationKey = generateTranslationKey($phpFile);
    
    // Create PHP content
    $phpContent = generatePhpContent($title, $bodyContent, $translationKey, $phpFile);
    
    // Write PHP file
    if (file_put_contents($phpPath, $phpContent)) {
        echo "✅ Converted: $htmlFile -> $phpFile\n";
        return true;
    } else {
        echo "❌ Failed to write: $phpFile\n";
        return false;
    }
}

/**
 * Extract title from HTML content
 */
function extractTitle($htmlContent) {
    if (preg_match('/<title>(.*?)<\/title>/i', $htmlContent, $matches)) {
        return trim($matches[1]);
    }
    if (preg_match('/<h1[^>]*>(.*?)<\/h1>/i', $htmlContent, $matches)) {
        return trim(strip_tags($matches[1]));
    }
    return 'Cacti Documentation';
}

/**
 * Extract body content from HTML
 */
function extractBodyContent($htmlContent) {
    // Try to extract content between <body> tags
    if (preg_match('/<body[^>]*>(.*?)<\/body>/is', $htmlContent, $matches)) {
        return trim($matches[1]);
    }
    
    // If no body tags, try to extract main content
    if (preg_match('/<div[^>]*class="[^"]*content[^"]*"[^>]*>(.*?)<\/div>/is', $htmlContent, $matches)) {
        return trim($matches[1]);
    }
    
    // Fallback: return everything after DOCTYPE and before </html>
    $content = preg_replace('/^.*?<html[^>]*>/is', '', $htmlContent);
    $content = preg_replace('/<\/html>.*$/is', '', $content);
    $content = preg_replace('/<head>.*?<\/head>/is', '', $content);
    
    return trim($content);
}

/**
 * Generate translation key from filename
 */
function generateTranslationKey($phpFile) {
    $key = str_replace('.php', '', $phpFile);
    $key = strtolower($key);
    $key = str_replace('-', '_', $key);
    return $key;
}

/**
 * Generate PHP content with multilingual support
 */
function generatePhpContent($title, $bodyContent, $translationKey, $phpFile) {
    $pageTitle = ucwords(str_replace(['-', '_'], ' ', $translationKey));
    
    $phpContent = <<<PHP
<?php
/**
 * Cacti Documentation - $pageTitle
 * 
 * This page provides comprehensive information about $pageTitle in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('page_title_$translationKey', '$translationKey', true);
?>

$bodyContent

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
PHP;

    return $phpContent;
}

// Main execution
echo "🚀 Starting batch HTML to PHP conversion...\n\n";

$converted = 0;
$skipped = 0;
$failed = 0;

foreach ($htmlFiles as $htmlFile) {
    $result = convertHtmlToPhp($htmlFile, $sourceDir, $outputDir);
    if ($result === true) {
        $converted++;
    } elseif ($result === false && strpos($htmlFile, 'already exists') !== false) {
        $skipped++;
    } else {
        $failed++;
    }
}

echo "\n📊 Conversion Summary:\n";
echo "✅ Converted: $converted files\n";
echo "⚠️  Skipped: $skipped files\n";
echo "❌ Failed: $failed files\n";
echo "\n🎉 Batch conversion completed!\n";
?>
PHP;

    return $phpContent;
}

// Main execution
echo "🚀 Starting batch HTML to PHP conversion...\n\n";

$converted = 0;
$skipped = 0;
$failed = 0;

foreach ($htmlFiles as $htmlFile) {
    $result = convertHtmlToPhp($htmlFile, $sourceDir, $outputDir);
    if ($result === true) {
        $converted++;
    } elseif ($result === false && strpos($htmlFile, 'already exists') !== false) {
        $skipped++;
    } else {
        $failed++;
    }
}

echo "\n📊 Conversion Summary:\n";
echo "✅ Converted: $converted files\n";
echo "⚠️  Skipped: $skipped files\n";
echo "❌ Failed: $failed files\n";
echo "\n🎉 Batch conversion completed!\n";
?>
