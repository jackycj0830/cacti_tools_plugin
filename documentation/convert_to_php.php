<?php
/**
 * HTML to PHP Conversion Script for Cacti Documentation
 * 
 * This script converts existing HTML files to PHP files with multilingual support.
 * It adds the necessary PHP includes and language functions.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

class HtmlToPhpConverter {
    
    private $sourceDir;
    private $backupDir;
    private $processedFiles = array();
    private $skippedFiles = array();
    private $errorFiles = array();
    
    public function __construct($sourceDir = '.') {
        $this->sourceDir = realpath($sourceDir);
        $this->backupDir = $this->sourceDir . '/backup_html_' . date('Ymd_His');
        
        // Create backup directory
        if (!is_dir($this->backupDir)) {
            mkdir($this->backupDir, 0755, true);
        }
    }
    
    /**
     * Convert all HTML files to PHP
     */
    public function convertAll() {
        echo "=== HTML to PHP Conversion Script ===\n";
        echo "Source Directory: {$this->sourceDir}\n";
        echo "Backup Directory: {$this->backupDir}\n\n";
        
        $htmlFiles = glob($this->sourceDir . '/*.html');
        
        if (empty($htmlFiles)) {
            echo "No HTML files found in the source directory.\n";
            return;
        }
        
        echo "Found " . count($htmlFiles) . " HTML files to convert.\n\n";
        
        foreach ($htmlFiles as $htmlFile) {
            $this->convertFile($htmlFile);
        }
        
        $this->printSummary();
    }
    
    /**
     * Convert a single HTML file to PHP
     */
    private function convertFile($htmlFile) {
        $filename = basename($htmlFile);
        $phpFile = str_replace('.html', '.php', $htmlFile);
        
        echo "Processing: $filename ... ";
        
        try {
            // Skip if already converted
            if (file_exists($phpFile)) {
                echo "SKIPPED (PHP file already exists)\n";
                $this->skippedFiles[] = $filename;
                return;
            }
            
            // Create backup
            copy($htmlFile, $this->backupDir . '/' . $filename);
            
            // Read HTML content
            $content = file_get_contents($htmlFile);
            
            if ($content === false) {
                throw new Exception("Could not read file");
            }
            
            // Convert to PHP
            $phpContent = $this->convertHtmlToPhp($content, $filename);
            
            // Write PHP file
            if (file_put_contents($phpFile, $phpContent) === false) {
                throw new Exception("Could not write PHP file");
            }
            
            echo "SUCCESS\n";
            $this->processedFiles[] = $filename;
            
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "\n";
            $this->errorFiles[] = $filename;
        }
    }
    
    /**
     * Convert HTML content to PHP with multilingual support
     */
    private function convertHtmlToPhp($content, $filename) {
        // Determine if this is the main documentation page
        $isMainPage = (strpos($filename, 'documentation') !== false);
        
        // Extract title from HTML
        $title = $this->extractTitle($content);
        $pageKey = $this->generatePageKey($filename);
        
        // Generate PHP header
        $phpHeader = $this->generatePhpHeader($title, $pageKey, $isMainPage);
        
        // Extract body content
        $bodyContent = $this->extractBodyContent($content);
        
        // Add language function calls to common elements
        $bodyContent = $this->addLanguageFunctions($bodyContent);
        
        // Generate PHP footer
        $phpFooter = $this->generatePhpFooter();
        
        return $phpHeader . $bodyContent . $phpFooter;
    }
    
    /**
     * Extract title from HTML
     */
    private function extractTitle($content) {
        if (preg_match('/<title[^>]*>(.*?)<\/title>/i', $content, $matches)) {
            return trim(strip_tags($matches[1]));
        }
        return 'Cacti Documentation';
    }
    
    /**
     * Generate page key from filename
     */
    private function generatePageKey($filename) {
        $key = str_replace('.html', '', $filename);
        $key = strtolower($key);
        $key = str_replace(array('-', '_'), '_', $key);
        return $key;
    }
    
    /**
     * Extract body content from HTML
     */
    private function extractBodyContent($content) {
        // Remove HTML, HEAD, and BODY tags
        $content = preg_replace('/<\?xml[^>]*>/i', '', $content);
        $content = preg_replace('/<!DOCTYPE[^>]*>/i', '', $content);
        $content = preg_replace('/<html[^>]*>/i', '', $content);
        $content = preg_replace('/<\/html>/i', '', $content);
        $content = preg_replace('/<head[^>]*>.*?<\/head>/is', '', $content);
        $content = preg_replace('/<body[^>]*>/i', '', $content);
        $content = preg_replace('/<\/body>/i', '', $content);
        
        // Remove existing language controls and scripts
        $content = preg_replace('/<div[^>]*class="[^"]*language[^"]*"[^>]*>.*?<\/div>/is', '', $content);
        $content = preg_replace('/<div[^>]*class="[^"]*back[^"]*"[^>]*>.*?<\/div>/is', '', $content);
        $content = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $content);
        $content = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $content);
        
        return trim($content);
    }
    
    /**
     * Add language function calls to common elements and convert HTML links to PHP
     */
    private function addLanguageFunctions($content) {
        // First, convert all HTML links to PHP links
        $content = $this->convertHtmlLinksToPhp($content);

        // Replace common text patterns with language functions
        $replacements = array(
            '/\bRequirements\b/' => '<?php _e("requirements"); ?>',
            '/\bInstallation\b/' => '<?php _e("installation"); ?>',
            '/\bConfiguration\b/' => '<?php _e("configuration"); ?>',
            '/\bOverview\b/' => '<?php _e("overview"); ?>',
            '/\bManagement\b/' => '<?php _e("management"); ?>',
            '/\bDevices\b/' => '<?php _e("devices"); ?>',
            '/\bGraphs\b/' => '<?php _e("graphs"); ?>',
            '/\bData Sources\b/' => '<?php _e("data_sources"); ?>',
            '/\bTemplates\b/' => '<?php _e("templates"); ?>',
            '/\bAutomation\b/' => '<?php _e("automation"); ?>',
            '/\bSettings\b/' => '<?php _e("settings"); ?>',
            '/\bCopyright \(c\) 2004-2024 The Cacti Group\b/' => '<?php _e("copyright"); ?>'
        );

        foreach ($replacements as $pattern => $replacement) {
            $content = preg_replace($pattern, $replacement, $content);
        }

        return $content;
    }

    /**
     * Convert HTML links to PHP links
     */
    private function convertHtmlLinksToPhp($content) {
        // Convert .html links to .php links
        $content = preg_replace('/href="([^"]+)\.html"/', 'href="$1.php"', $content);

        // Convert specific common links
        $linkReplacements = array(
            'documentation.html' => 'documentation.php',
            'Requirements.html' => 'Requirements.php',
            'Navigating-The-User-Interface.html' => 'Navigating-The-User-Interface.php'
        );

        foreach ($linkReplacements as $oldLink => $newLink) {
            $content = str_replace($oldLink, $newLink, $content);
        }

        return $content;
    }
    
    /**
     * Generate PHP header
     */
    private function generatePhpHeader($title, $pageKey, $isMainPage) {
        $showBackButton = $isMainPage ? 'false' : 'true';
        
        return "<?php\n" .
               "/**\n" .
               " * Cacti Documentation Page: $title\n" .
               " * \n" .
               " * This page has been converted to PHP with multilingual support.\n" .
               " * \n" .
               " * @package Cacti Documentation\n" .
               " * @version 2.0.0\n" .
               " */\n\n" .
               "// Include language management system\n" .
               "require_once 'includes/language.php';\n" .
               "require_once 'includes/page_template.php';\n\n" .
               "// Generate page header\n" .
               "generatePageHeader('page_title_$pageKey', '$pageKey', $showBackButton);\n" .
               "?>\n\n";
    }
    
    /**
     * Generate PHP footer
     */
    private function generatePhpFooter() {
        return "\n\n<?php\n" .
               "// Generate page footer\n" .
               "generatePageFooter();\n" .
               "?>";
    }
    
    /**
     * Print conversion summary
     */
    private function printSummary() {
        echo "\n=== Conversion Summary ===\n";
        echo "Processed: " . count($this->processedFiles) . " files\n";
        echo "Skipped: " . count($this->skippedFiles) . " files\n";
        echo "Errors: " . count($this->errorFiles) . " files\n";
        echo "Backup created in: {$this->backupDir}\n\n";
        
        if (!empty($this->processedFiles)) {
            echo "Successfully converted files:\n";
            foreach ($this->processedFiles as $file) {
                echo "  ✓ $file\n";
            }
            echo "\n";
        }
        
        if (!empty($this->skippedFiles)) {
            echo "Skipped files:\n";
            foreach ($this->skippedFiles as $file) {
                echo "  - $file\n";
            }
            echo "\n";
        }
        
        if (!empty($this->errorFiles)) {
            echo "Files with errors:\n";
            foreach ($this->errorFiles as $file) {
                echo "  ✗ $file\n";
            }
            echo "\n";
        }
        
        echo "Conversion complete!\n";
        echo "\nNext steps:\n";
        echo "1. Test the converted PHP files in a web browser\n";
        echo "2. Add more specific translations to the language files\n";
        echo "3. Update any hardcoded links to point to .php files\n";
        echo "4. Configure your web server to serve PHP files\n";
    }
}

// Run the converter if this script is executed directly
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'])) {
    $converter = new HtmlToPhpConverter();
    $converter->convertAll();
}
?>
