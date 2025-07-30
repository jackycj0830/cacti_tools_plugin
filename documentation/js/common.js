// Common functionality for all documentation pages
// This script should be included in all documentation pages

// Function to add language support and navigation to any page
function initializeDocumentationPage() {
    // Add CSS styles if not already present
    if (!document.getElementById('doc-common-styles')) {
        const style = document.createElement('style');
        style.id = 'doc-common-styles';
        style.textContent = `
            /* Language selector and navigation styles */
            .header-controls {
                position: fixed;
                top: 10px;
                right: 10px;
                z-index: 1000;
                display: flex;
                gap: 10px;
                align-items: center;
            }
            
            .back-button {
                position: fixed;
                top: 10px;
                left: 10px;
                z-index: 1000;
                background: #007cba;
                color: white;
                border: none;
                padding: 8px 12px;
                border-radius: 4px;
                cursor: pointer;
                text-decoration: none;
                font-size: 14px;
                display: block;
            }
            
            .back-button:hover {
                background: #005a87;
                color: white;
                text-decoration: none;
            }
            
            .language-selector {
                background: white;
                border: 1px solid #ccc;
                border-radius: 4px;
                padding: 5px 10px;
                font-size: 14px;
                cursor: pointer;
            }
            
            .language-selector:hover {
                background: #f5f5f5;
            }
            
            body {
                padding-top: 50px;
            }
        `;
        document.head.appendChild(style);
    }

    // Add navigation controls if not already present
    if (!document.getElementById('backButton')) {
        // Add back button
        const backButton = document.createElement('a');
        backButton.href = 'javascript:history.back()';
        backButton.className = 'back-button';
        backButton.id = 'backButton';
        backButton.innerHTML = '<span data-i18n="back">← Back</span>';
        document.body.insertBefore(backButton, document.body.firstChild);

        // Add language selector
        const headerControls = document.createElement('div');
        headerControls.className = 'header-controls';
        headerControls.innerHTML = `
            <select class="language-selector" id="languageSelector" onchange="changeLanguage()">
                <option value="en">English</option>
                <option value="zh-cn">简体中文</option>
                <option value="zh-tw">繁體中文</option>
            </select>
        `;
        document.body.insertBefore(headerControls, document.body.firstChild);
    }

    // Initialize language
    initializeLanguage();
}

// Function to change language
function changeLanguage() {
    const selector = document.getElementById('languageSelector');
    if (selector) {
        const selectedLang = selector.value;
        console.log('Language changed to:', selectedLang); // Debug log

        // Use setLanguage function which handles storage and events
        setLanguage(selectedLang);
    }
}

// Function to initialize language
function initializeLanguage() {
    const savedLang = localStorage.getItem('selectedLanguage') || 'en';
    console.log('Initializing with saved language:', savedLang); // Debug log

    const selector = document.getElementById('languageSelector');
    if (selector) {
        selector.value = savedLang;
    }

    // Load the language
    loadLanguage(savedLang);

    // Listen for storage changes (for cross-tab/frame synchronization)
    window.addEventListener('storage', function(e) {
        if (e.key === 'selectedLanguage' && e.newValue) {
            console.log('Storage event detected, changing language to:', e.newValue);
            const selector = document.getElementById('languageSelector');
            if (selector) {
                selector.value = e.newValue;
            }
            loadLanguage(e.newValue);
        }
    });
}

// Auto-initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeDocumentationPage();
});

// Function to add translation support to any element
function addTranslation(element, key, lang = null) {
    if (!lang) {
        lang = getCurrentLanguage();
    }
    
    if (translations[lang] && translations[lang][key]) {
        element.textContent = translations[lang][key];
    }
    
    // Add data-i18n attribute for future updates
    element.setAttribute('data-i18n', key);
}

// Function to translate page title
function translatePageTitle(titleKey) {
    const lang = getCurrentLanguage();
    if (translations[lang] && translations[lang][titleKey]) {
        document.title = translations[lang][titleKey];
    }
}

// Function to add common page translations
function addCommonTranslations() {
    // Add common translation keys that might be used across pages
    const commonKeys = {
        'en': {
            'requirements': 'Requirements',
            'installation': 'Installation',
            'configuration': 'Configuration',
            'troubleshooting': 'Troubleshooting',
            'examples': 'Examples',
            'overview': 'Overview',
            'getting_started': 'Getting Started',
            'advanced': 'Advanced',
            'reference': 'Reference',
            'home': 'Home',
            'documentation': 'Documentation',
            'next': 'Next',
            'previous': 'Previous',
            'contents': 'Contents'
        },
        'zh-cn': {
            'requirements': '系统要求',
            'installation': '安装',
            'configuration': '配置',
            'troubleshooting': '故障排除',
            'examples': '示例',
            'overview': '概述',
            'getting_started': '入门指南',
            'advanced': '高级',
            'reference': '参考',
            'home': '首页',
            'documentation': '文档',
            'next': '下一页',
            'previous': '上一页',
            'contents': '目录'
        },
        'zh-tw': {
            'requirements': '系統要求',
            'installation': '安裝',
            'configuration': '配置',
            'troubleshooting': '故障排除',
            'examples': '範例',
            'overview': '概述',
            'getting_started': '入門指南',
            'advanced': '進階',
            'reference': '參考',
            'home': '首頁',
            'documentation': '文件',
            'next': '下一頁',
            'previous': '上一頁',
            'contents': '目錄'
        }
    };

    // Merge common translations with existing translations
    Object.keys(commonKeys).forEach(lang => {
        if (!translations[lang]) {
            translations[lang] = {};
        }
        Object.assign(translations[lang], commonKeys[lang]);
    });
}
