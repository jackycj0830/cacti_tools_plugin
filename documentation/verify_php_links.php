<?php
/**
 * Verify PHP Links in documentation.php
 * 
 * This script verifies that all links in documentation.php have been
 * successfully converted from HTML to PHP format.
 */

echo "🔍 Verifying PHP Links in documentation.php...\n\n";

// Read the documentation.php file
$content = file_get_contents('documentation.php');

if (!$content) {
    echo "❌ Error: Could not read documentation.php\n";
    exit(1);
}

// Check for any remaining HTML links
$htmlLinks = [];
if (preg_match_all('/href="([^"]+\.html)"/', $content, $matches)) {
    $htmlLinks = $matches[1];
}

// Count PHP links
$phpLinks = [];
if (preg_match_all('/href="([^"]+\.php)"/', $content, $matches)) {
    $phpLinks = $matches[1];
}

// Count external links (http/https)
$externalLinks = [];
if (preg_match_all('/href="(https?:\/\/[^"]+)"/', $content, $matches)) {
    $externalLinks = $matches[1];
}

echo "📊 LINK ANALYSIS RESULTS\n";
echo "========================\n\n";

echo "🔗 PHP Links Found: " . count($phpLinks) . "\n";
echo "🌐 External Links Found: " . count($externalLinks) . "\n";
echo "⚠️  HTML Links Remaining: " . count($htmlLinks) . "\n\n";

if (count($htmlLinks) > 0) {
    echo "❌ REMAINING HTML LINKS:\n";
    echo "========================\n";
    foreach ($htmlLinks as $link) {
        echo "  • $link\n";
    }
    echo "\n";
} else {
    echo "✅ SUCCESS: No HTML links found!\n";
    echo "All links have been successfully converted to PHP format.\n\n";
}

echo "📋 PHP LINKS SUMMARY:\n";
echo "=====================\n";

// Categorize PHP links
$categories = [
    'Settings' => [],
    'User Management' => [],
    'Reports' => [],
    'How-To' => [],
    'Plugin' => [],
    'Standards' => [],
    'Other' => []
];

foreach ($phpLinks as $link) {
    if (strpos($link, 'Settings-') === 0) {
        $categories['Settings'][] = $link;
    } elseif (strpos($link, 'User-') === 0) {
        $categories['User Management'][] = $link;
    } elseif (strpos($link, 'Reports-') === 0) {
        $categories['Reports'][] = $link;
    } elseif (strpos($link, 'How-To-') === 0) {
        $categories['How-To'][] = $link;
    } elseif (strpos($link, 'Plugin-') === 0 || strpos($link, 'Creating-Plugins') === 0) {
        $categories['Plugin'][] = $link;
    } elseif (strpos($link, 'Standards-') === 0) {
        $categories['Standards'][] = $link;
    } else {
        $categories['Other'][] = $link;
    }
}

foreach ($categories as $category => $links) {
    if (count($links) > 0) {
        echo "\n📁 $category (" . count($links) . " files):\n";
        foreach ($links as $link) {
            echo "  ✓ $link\n";
        }
    }
}

echo "\n🌐 EXTERNAL LINKS:\n";
echo "=================\n";
foreach ($externalLinks as $link) {
    echo "  🔗 $link\n";
}

echo "\n📈 CONVERSION STATISTICS:\n";
echo "=========================\n";
echo "Total Internal Links: " . count($phpLinks) . "\n";
echo "Total External Links: " . count($externalLinks) . "\n";
echo "Total Links: " . (count($phpLinks) + count($externalLinks)) . "\n";

if (count($htmlLinks) === 0) {
    echo "\n🎉 CONVERSION COMPLETE!\n";
    echo "======================\n";
    echo "✅ All HTML links successfully converted to PHP\n";
    echo "✅ Documentation system fully updated\n";
    echo "✅ Ready for multilingual PHP-based navigation\n";
} else {
    echo "\n⚠️  CONVERSION INCOMPLETE\n";
    echo "========================\n";
    echo "❌ " . count($htmlLinks) . " HTML links still need conversion\n";
    echo "🔧 Please update remaining links manually\n";
}

echo "\n✨ Link verification completed!\n";
?>
