<?php
/**
 * Language Management System for Cacti Documentation
 * 
 * This class handles language detection, loading, and text retrieval
 * for the multilingual documentation system.
 * 
 * @package Cacti Documentation
 * @version 2.0.0
 * @author Cacti Tools Plugin Team
 */

class LanguageManager {
    
    private $currentLanguage = 'en';
    private $supportedLanguages = array('en', 'zh-cn', 'zh-tw');
    private $languageNames = array(
        'en' => 'English',
        'zh-cn' => '简体中文',
        'zh-tw' => '繁體中文'
    );
    private $translations = array();
    private $defaultLanguage = 'en';
    
    /**
     * Constructor - Initialize language system
     */
    public function __construct() {
        $this->detectLanguage();
        $this->loadLanguage($this->currentLanguage);
    }
    
    /**
     * Detect current language from various sources
     */
    private function detectLanguage() {
        // Priority order: URL parameter > Cookie > Session > Browser > Default
        
        // 1. Check URL parameter
        if (isset($_GET['lang']) && in_array($_GET['lang'], $this->supportedLanguages)) {
            $this->currentLanguage = $_GET['lang'];
            $this->setLanguageCookie($_GET['lang']);
            return;
        }
        
        // 2. Check cookie
        if (isset($_COOKIE['cacti_doc_lang']) && in_array($_COOKIE['cacti_doc_lang'], $this->supportedLanguages)) {
            $this->currentLanguage = $_COOKIE['cacti_doc_lang'];
            return;
        }
        
        // 3. Check session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['cacti_doc_lang']) && in_array($_SESSION['cacti_doc_lang'], $this->supportedLanguages)) {
            $this->currentLanguage = $_SESSION['cacti_doc_lang'];
            return;
        }
        
        // 4. Check browser language
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $browserLang = $this->parseBrowserLanguage($_SERVER['HTTP_ACCEPT_LANGUAGE']);
            if ($browserLang && in_array($browserLang, $this->supportedLanguages)) {
                $this->currentLanguage = $browserLang;
                return;
            }
        }
        
        // 5. Use default language
        $this->currentLanguage = $this->defaultLanguage;
    }
    
    /**
     * Parse browser Accept-Language header
     */
    private function parseBrowserLanguage($acceptLanguage) {
        $languages = explode(',', $acceptLanguage);
        foreach ($languages as $language) {
            $lang = trim(explode(';', $language)[0]);
            $lang = strtolower($lang);
            
            // Map common language codes
            $langMap = array(
                'zh-cn' => 'zh-cn',
                'zh-hans' => 'zh-cn',
                'zh-tw' => 'zh-tw',
                'zh-hant' => 'zh-tw',
                'zh' => 'zh-cn', // Default Chinese to simplified
                'en' => 'en',
                'en-us' => 'en',
                'en-gb' => 'en'
            );
            
            if (isset($langMap[$lang])) {
                return $langMap[$lang];
            }
        }
        
        return null;
    }
    
    /**
     * Load language file
     */
    private function loadLanguage($language) {
        $languageFile = __DIR__ . '/../languages/' . $language . '.php';
        
        if (file_exists($languageFile)) {
            include $languageFile;
            if (isset($lang) && is_array($lang)) {
                $this->translations = $lang;
            } else {
                // Fallback to English if language file is corrupted
                $this->loadFallbackLanguage();
            }
        } else {
            // Fallback to English if language file doesn't exist
            $this->loadFallbackLanguage();
        }
    }
    
    /**
     * Load fallback language (English)
     */
    private function loadFallbackLanguage() {
        $englishFile = __DIR__ . '/../languages/en.php';
        if (file_exists($englishFile)) {
            include $englishFile;
            if (isset($lang) && is_array($lang)) {
                $this->translations = $lang;
            }
        }
    }
    
    /**
     * Get translated text
     */
    public function getText($key, $default = null) {
        if (isset($this->translations[$key])) {
            return $this->translations[$key];
        }
        
        // If translation not found, try to load English as fallback
        if ($this->currentLanguage !== 'en') {
            $englishFile = __DIR__ . '/../languages/en.php';
            if (file_exists($englishFile)) {
                include $englishFile;
                if (isset($lang[$key])) {
                    return $lang[$key];
                }
            }
        }
        
        // Return default or key if no translation found
        return $default !== null ? $default : $key;
    }
    
    /**
     * Set language and save to cookie/session
     */
    public function setLanguage($language) {
        if (in_array($language, $this->supportedLanguages)) {
            $this->currentLanguage = $language;
            $this->loadLanguage($language);
            $this->setLanguageCookie($language);
            
            // Also save to session
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['cacti_doc_lang'] = $language;
        }
    }
    
    /**
     * Set language cookie
     */
    private function setLanguageCookie($language) {
        setcookie('cacti_doc_lang', $language, time() + (86400 * 30), '/'); // 30 days
    }
    
    /**
     * Get current language
     */
    public function getCurrentLanguage() {
        return $this->currentLanguage;
    }
    
    /**
     * Get supported languages
     */
    public function getSupportedLanguages() {
        return $this->supportedLanguages;
    }
    
    /**
     * Get language names
     */
    public function getLanguageNames() {
        return $this->languageNames;
    }
    
    /**
     * Get language name for specific language code
     */
    public function getLanguageName($language) {
        return isset($this->languageNames[$language]) ? $this->languageNames[$language] : $language;
    }
    
    /**
     * Generate language selector HTML
     */
    public function generateLanguageSelector($currentPage = '') {
        $html = '<div class="language-selector">';
        $html .= '<label for="language-select">' . $this->getText('language_selector_label') . ':</label>';
        $html .= '<select id="language-select" onchange="changeLanguage(this.value)">';
        
        foreach ($this->supportedLanguages as $langCode) {
            $selected = ($langCode === $this->currentLanguage) ? ' selected' : '';
            $langName = $this->getLanguageName($langCode);
            $html .= '<option value="' . $langCode . '"' . $selected . '>' . $langName . '</option>';
        }
        
        $html .= '</select>';
        $html .= '</div>';
        
        return $html;
    }
    
    /**
     * Generate back button HTML
     */
    public function generateBackButton($showOnMainPage = false) {
        // Don't show back button on main documentation page unless explicitly requested
        $currentPage = basename($_SERVER['PHP_SELF']);
        if (!$showOnMainPage && ($currentPage === 'documentation.php' || $currentPage === 'index.php')) {
            return '';
        }
        
        $html = '<div class="back-button">';
        $html .= '<a href="javascript:history.back()" class="btn-back">';
        $html .= $this->getText('back_button');
        $html .= '</a>';
        $html .= '</div>';
        
        return $html;
    }
    
    /**
     * Get page title based on current page
     */
    public function getPageTitle($page = '') {
        if (empty($page)) {
            $page = basename($_SERVER['PHP_SELF'], '.php');
        }
        
        $titleKey = 'page_title_' . str_replace('-', '_', $page);
        return $this->getText($titleKey, $this->getText('page_title_main'));
    }
}

/**
 * Global language manager instance
 */
$languageManager = new LanguageManager();

/**
 * Helper function to get translated text
 */
function __($key, $default = null) {
    global $languageManager;
    return $languageManager->getText($key, $default);
}

/**
 * Helper function to echo translated text
 */
function _e($key, $default = null) {
    echo __($key, $default);
}
?>
