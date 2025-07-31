<?php
/**
 * Page Template for Cacti Documentation
 * 
 * This template provides a consistent structure for all documentation pages
 * with multilingual support and navigation controls.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 */

// Include language management system if not already included
if (!class_exists('LanguageManager')) {
    require_once 'includes/language.php';
}

/**
 * Generate page header with language controls
 * 
 * @param string $pageTitle Page title key for translation
 * @param string $pageKey Page identifier for title lookup
 * @param bool $showBackButton Whether to show back button
 */
function generatePageHeader($pageTitle = '', $pageKey = '', $showBackButton = true) {
    global $languageManager;
    
    // Handle language change requests
    if (isset($_GET['lang'])) {
        $languageManager->setLanguage($_GET['lang']);
        // Redirect to remove language parameter from URL
        $currentUrl = strtok($_SERVER["REQUEST_URI"], '?');
        header("Location: $currentUrl");
        exit;
    }
    
    // Determine page title
    if (!empty($pageTitle)) {
        $title = $languageManager->getText($pageTitle, $pageTitle);
    } elseif (!empty($pageKey)) {
        $title = $languageManager->getPageTitle($pageKey);
    } else {
        $title = $languageManager->getPageTitle();
    }
    
    $currentLang = $languageManager->getCurrentLanguage();
    
    echo '<!DOCTYPE html>';
    echo '<html xmlns="http://www.w3.org/1999/xhtml" lang="' . $currentLang . '" xml:lang="' . $currentLang . '">';
    echo '<head>';
    echo '<meta charset="utf-8" />';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />';
    echo '<title>' . htmlspecialchars($title) . '</title>';
    echo '<link rel="stylesheet" href="Cacti-Github.css" />';
    
    // Include common styles
    generatePageStyles();
    
    echo '</head>';
    echo '<body>';
    
    // Language controls
    echo '<div class="language-controls">';
    echo $languageManager->generateLanguageSelector();
    echo '</div>';
    
    // Back button
    if ($showBackButton) {
        echo $languageManager->generateBackButton();
    }
}

/**
 * Generate common page styles
 */
function generatePageStyles() {
    echo '<style>';
    echo '/* Language selector styles */';
    echo '.language-controls {';
    echo '    position: fixed;';
    echo '    top: 10px;';
    echo '    right: 10px;';
    echo '    z-index: 1000;';
    echo '    background: rgba(255, 255, 255, 0.98);';
    echo '    padding: 10px 15px;';
    echo '    border-radius: 8px;';
    echo '    box-shadow: 0 4px 20px rgba(0,0,0,0.15);';
    echo '    border: 1px solid #e0e0e0;';
    echo '    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;';
    echo '    font-size: 14px;';
    echo '    backdrop-filter: blur(10px);';
    echo '    transition: all 0.3s ease;';
    echo '}';
    
    echo '.language-controls:hover {';
    echo '    box-shadow: 0 6px 25px rgba(0,0,0,0.2);';
    echo '    transform: translateY(-1px);';
    echo '}';
    
    echo '.language-controls label {';
    echo '    display: inline-block;';
    echo '    margin-right: 8px;';
    echo '    font-weight: 500;';
    echo '    color: #495057;';
    echo '}';
    
    echo '.language-controls select {';
    echo '    background: white;';
    echo '    border: 2px solid #e0e0e0;';
    echo '    border-radius: 6px;';
    echo '    padding: 6px 12px;';
    echo '    font-size: 14px;';
    echo '    font-weight: 500;';
    echo '    cursor: pointer;';
    echo '    min-width: 140px;';
    echo '    transition: all 0.3s ease;';
    echo '    outline: none;';
    echo '}';
    
    echo '.language-controls select:hover {';
    echo '    background: #f8f9fa;';
    echo '    border-color: #007cba;';
    echo '}';
    
    echo '.language-controls select:focus {';
    echo '    border-color: #007cba;';
    echo '    box-shadow: 0 0 0 3px rgba(0,124,186,0.1);';
    echo '}';
    
    echo '/* Back button styles */';
    echo '.back-button {';
    echo '    position: fixed;';
    echo '    top: 10px;';
    echo '    left: 10px;';
    echo '    z-index: 1000;';
    echo '}';
    
    echo '.back-button a {';
    echo '    background: linear-gradient(135deg, #007cba 0%, #005a87 100%);';
    echo '    color: white;';
    echo '    padding: 10px 15px;';
    echo '    border-radius: 6px;';
    echo '    text-decoration: none;';
    echo '    font-size: 14px;';
    echo '    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;';
    echo '    font-weight: 500;';
    echo '    display: inline-block;';
    echo '    transition: all 0.3s ease;';
    echo '    box-shadow: 0 2px 10px rgba(0,124,186,0.3);';
    echo '}';
    
    echo '.back-button a:hover {';
    echo '    background: linear-gradient(135deg, #005a87 0%, #004066 100%);';
    echo '    color: white;';
    echo '    text-decoration: none;';
    echo '    transform: translateY(-1px);';
    echo '    box-shadow: 0 4px 15px rgba(0,124,186,0.4);';
    echo '}';
    
    echo '/* Ensure page content is not obscured */';
    echo 'body {';
    echo '    padding-top: 60px;';
    echo '}';
    
    echo '/* Responsive design */';
    echo '@media (max-width: 768px) {';
    echo '    .language-controls {';
    echo '        top: 5px;';
    echo '        right: 5px;';
    echo '        padding: 8px 12px;';
    echo '    }';
    echo '    .back-button {';
    echo '        top: 5px;';
    echo '        left: 5px;';
    echo '    }';
    echo '    .language-controls select {';
    echo '        min-width: 120px;';
    echo '        font-size: 13px;';
    echo '        padding: 5px 8px;';
    echo '    }';
    echo '    .back-button a {';
    echo '        padding: 8px 12px;';
    echo '        font-size: 13px;';
    echo '    }';
    echo '    body {';
    echo '        padding-top: 55px;';
    echo '    }';
    echo '}';
    
    echo '@media (max-width: 480px) {';
    echo '    .language-controls {';
    echo '        padding: 6px 8px;';
    echo '    }';
    echo '    .language-controls label {';
    echo '        display: block;';
    echo '        margin-bottom: 5px;';
    echo '        margin-right: 0;';
    echo '    }';
    echo '    .language-controls select {';
    echo '        min-width: 100px;';
    echo '        font-size: 12px;';
    echo '    }';
    echo '    body {';
    echo '        padding-top: 70px;';
    echo '    }';
    echo '}';
    echo '</style>';
}

/**
 * Generate page footer with common scripts
 */
function generatePageFooter() {
    global $languageManager;
    
    echo '<hr />';
    echo '<p>' . $languageManager->getText('copyright') . '</p>';
    
    echo '<script type="text/javascript">';
    echo 'function changeLanguage(language) {';
    echo '    var currentUrl = window.location.pathname;';
    echo '    window.location.href = currentUrl + "?lang=" + language;';
    echo '}';
    
    echo 'document.addEventListener("DOMContentLoaded", function() {';
    echo '    console.log("Page loaded with language: ' . $languageManager->getCurrentLanguage() . '");';
    echo '});';
    echo '</script>';
    
    echo '</body>';
    echo '</html>';
}

/**
 * Helper function to create a complete page
 * 
 * @param string $pageTitle Page title
 * @param string $content Page content (HTML)
 * @param bool $showBackButton Whether to show back button
 */
function createPage($pageTitle, $content, $showBackButton = true) {
    generatePageHeader($pageTitle, '', $showBackButton);
    echo $content;
    generatePageFooter();
}
?>
