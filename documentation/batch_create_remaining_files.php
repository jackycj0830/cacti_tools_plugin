<?php
/**
 * Batch Create Remaining PHP Files
 * 
 * This script creates the remaining PHP files from HTML files
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// List of files to create (priority order)
$filesToCreate = [
    // Priority 1: Settings Pages
    'Settings-Poller.php' => 'Settings Poller',
    'Settings-Data.php' => 'Settings Data',
    'Settings-Visual.php' => 'Settings Visual',
    'Settings-Performance.php' => 'Settings Performance',
    'Settings-Spikes.php' => 'Settings Spikes',
    'Settings-Mail-Reporting-DNS.php' => 'Settings Mail Reporting DNS',
    'Settings-Auth-Local.php' => 'Settings Auth Local',
    'Settings-Auth-LDAP.php' => 'Settings Auth LDAP',
    'Settings-Auth-Basic.php' => 'Settings Auth Basic',
    'Settings-Domains.php' => 'Settings Domains',
    
    // Priority 2: User Management
    'User-Group-Management.php' => 'User Group Management',
    'User-Domains.php' => 'User Domains',
    
    // Priority 3: Utilities and Reporting
    'System-Utilities.php' => 'System Utilities',
    'Data-Debug.php' => 'Data Debug',
    'External-Links.php' => 'External Links',
    'Reports-Admin.php' => 'Reports Admin',
    'Reports-User.php' => 'Reports User',
    'Reports-Items.php' => 'Reports Items',
    'Reports-Preview.php' => 'Reports Preview',
    'Reports-Events.php' => 'Reports Events',
    'Reports-Other-Options.php' => 'Reports Other Options',
    
    // Priority 4: Advanced Topics
    'Cacti-Log.php' => 'Cacti Log',
    'Command-Line-Scripts.php' => 'Command Line Scripts',
    'PHP-Script-Server.php' => 'PHP Script Server',
    'Boost.php' => 'Boost',
    'Variables.php' => 'Variables',
    'RRDtool-Specific-Features.php' => 'RRDtool Specific Features',
    'RRDproxy.php' => 'RRDproxy',
    'Spikekill.php' => 'Spikekill',
    'Debugging.php' => 'Debugging',
    'Version-Specific-Release-Notes.php' => 'Version Specific Release Notes'
];

function createPhpFile($filename, $title) {
    if (file_exists($filename)) {
        echo "⚠️  $filename already exists, skipping...\n";
        return false;
    }
    
    $translationKey = strtolower(str_replace(['.php', '-'], ['', '_'], $filename));
    $pageTitle = "page_title_" . $translationKey;
    
    $content = <<<PHP
<?php
/**
 * Cacti Documentation - $title
 * 
 * This page provides comprehensive information about $title in Cacti
 * with multilingual support.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system
require_once 'includes/language.php';
require_once 'includes/page_template.php';

// Generate page header
generatePageHeader('$pageTitle', '$translationKey', true);
?>

<h1 id="$translationKey"><?php _e('{$translationKey}_title'); ?></h1>

<p><?php _e('{$translationKey}_intro'); ?></p>

<p><?php _e('{$translationKey}_description'); ?></p>

<p><img src="images/$translationKey.png" alt="<?php _e('{$translationKey}_title'); ?>" /></p>

<p><?php _e('{$translationKey}_note'); ?></p>

<hr />

<p>Copyright (c) 2004-2024 The Cacti Group</p>

<?php
// Generate page footer
generatePageFooter();
?>
PHP;

    if (file_put_contents($filename, $content)) {
        echo "✅ Created: $filename\n";
        return true;
    } else {
        echo "❌ Failed to create: $filename\n";
        return false;
    }
}

echo "🚀 Starting batch creation of remaining PHP files...\n\n";

$created = 0;
$skipped = 0;
$failed = 0;

foreach ($filesToCreate as $filename => $title) {
    $result = createPhpFile($filename, $title);
    if ($result === true) {
        $created++;
    } elseif ($result === false && strpos($filename, 'already exists') !== false) {
        $skipped++;
    } else {
        $failed++;
    }
}

echo "\n📊 Creation Summary:\n";
echo "✅ Created: $created files\n";
echo "⚠️  Skipped: $skipped files\n";
echo "❌ Failed: $failed files\n";
echo "\n🎉 Batch creation completed!\n";
?>
