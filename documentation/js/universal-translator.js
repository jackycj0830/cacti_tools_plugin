/**
 * Universal Multilingual Translation System for Cacti Documentation
 * Automatically adds translation capability to any HTML page without manual editing
 *
 * Features:
 * - Supports English, Simplified Chinese, Traditional Chinese
 * - Real-time translation without page reload
 * - Persistent language selection across pages
 * - Responsive UI controls
 * - Comprehensive Cacti-specific terminology
 *
 * @author Cacti Tools Plugin Team
 * @version 2.0.0
 */

(function() {
    'use strict';

    // Prevent multiple initialization
    if (window.universalTranslatorInitialized) {
        return;
    }
    window.universalTranslatorInitialized = true;

    console.log('🌍 Universal Translator v2.0.0 initializing...');

    /**
     * Add responsive CSS styles for translation controls
     */
    function addTranslatorStyles() {
        if (document.getElementById('universal-translator-styles')) return;

        const style = document.createElement('style');
        style.id = 'universal-translator-styles';
        style.textContent = `
            /* Translation Control Panel Styles */
            .translator-controls {
                position: fixed;
                top: 10px;
                right: 10px;
                z-index: 10000;
                display: flex;
                gap: 10px;
                align-items: center;
                background: rgba(255, 255, 255, 0.98);
                padding: 8px 15px;
                border-radius: 8px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.15);
                border: 1px solid #e0e0e0;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
                font-size: 14px;
                backdrop-filter: blur(10px);
                transition: all 0.3s ease;
            }

            .translator-controls:hover {
                box-shadow: 0 6px 25px rgba(0,0,0,0.2);
                transform: translateY(-1px);
            }

            .translator-back-button {
                position: fixed;
                top: 10px;
                left: 10px;
                z-index: 10000;
                background: linear-gradient(135deg, #007cba 0%, #005a87 100%);
                color: white;
                border: none;
                padding: 8px 15px;
                border-radius: 6px;
                cursor: pointer;
                text-decoration: none;
                font-size: 14px;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
                font-weight: 500;
                display: none;
                transition: all 0.3s ease;
                box-shadow: 0 2px 10px rgba(0,124,186,0.3);
            }

            .translator-back-button:hover {
                background: linear-gradient(135deg, #005a87 0%, #004066 100%);
                color: white;
                text-decoration: none;
                transform: translateY(-1px);
                box-shadow: 0 4px 15px rgba(0,124,186,0.4);
            }

            .translator-language-selector {
                background: white;
                border: 2px solid #e0e0e0;
                border-radius: 6px;
                padding: 6px 12px;
                font-size: 14px;
                font-weight: 500;
                cursor: pointer;
                min-width: 140px;
                transition: all 0.3s ease;
                outline: none;
            }

            .translator-language-selector:hover {
                background: #f8f9fa;
                border-color: #007cba;
            }

            .translator-language-selector:focus {
                border-color: #007cba;
                box-shadow: 0 0 0 3px rgba(0,124,186,0.1);
            }

            .translator-status {
                font-size: 12px;
                font-weight: 500;
                margin-left: 8px;
                padding: 4px 8px;
                border-radius: 12px;
                transition: all 0.3s ease;
            }

            .translator-loading {
                color: #007cba;
                background: rgba(0,124,186,0.1);
            }

            .translator-ready {
                color: #28a745;
                background: rgba(40,167,69,0.1);
            }

            .translator-error {
                color: #dc3545;
                background: rgba(220,53,69,0.1);
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                .translator-controls {
                    top: 5px;
                    right: 5px;
                    padding: 6px 10px;
                    gap: 8px;
                }

                .translator-back-button {
                    top: 5px;
                    left: 5px;
                    padding: 6px 10px;
                    font-size: 13px;
                }

                .translator-language-selector {
                    min-width: 110px;
                    padding: 5px 8px;
                    font-size: 13px;
                }

                .translator-status {
                    font-size: 11px;
                    margin-left: 5px;
                    padding: 3px 6px;
                }
            }

            @media (max-width: 480px) {
                .translator-controls {
                    flex-direction: column;
                    gap: 5px;
                    padding: 8px;
                }

                .translator-status {
                    margin-left: 0;
                    margin-top: 2px;
                }
            }

            /* Ensure page content is not obscured */
            body {
                padding-top: 60px !important;
            }

            @media (max-width: 768px) {
                body {
                    padding-top: 55px !important;
                }
            }

            @media (max-width: 480px) {
                body {
                    padding-top: 80px !important;
                }
            }

            /* Translation animation effects */
            .translating {
                opacity: 0.8;
                transition: opacity 0.3s ease;
            }

            .translation-highlight {
                background: rgba(255, 235, 59, 0.3);
                transition: background 0.5s ease;
            }

            /* Elements to exclude from translation */
            .no-translate,
            [data-no-translate],
            .translator-controls,
            .translator-back-button {
                /* Keep original content */
            }

            /* Loading indicator */
            .translator-loading::after {
                content: '';
                display: inline-block;
                width: 12px;
                height: 12px;
                margin-left: 5px;
                border: 2px solid transparent;
                border-top: 2px solid currentColor;
                border-radius: 50%;
                animation: translator-spin 1s linear infinite;
            }

            @keyframes translator-spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    }

    /**
     * Add translation control panel with accessibility features
     * @returns {Object} References to selector and status elements
     */
    function addTranslatorControls() {
        if (document.getElementById('translator-controls')) return;

        // Create back button with accessibility
        const backButton = document.createElement('a');
        backButton.id = 'translator-back-button';
        backButton.className = 'translator-back-button';
        backButton.href = 'javascript:history.back()';
        backButton.innerHTML = '← <span data-i18n="back">Back</span>';
        backButton.style.display = 'none';
        backButton.setAttribute('aria-label', 'Go back to previous page');
        backButton.setAttribute('title', 'Go back to previous page');

        // Create main control panel
        const controls = document.createElement('div');
        controls.id = 'translator-controls';
        controls.className = 'translator-controls';
        controls.setAttribute('role', 'toolbar');
        controls.setAttribute('aria-label', 'Language translation controls');

        // Create language selector with accessibility
        const selector = document.createElement('select');
        selector.id = 'translator-language-selector';
        selector.className = 'translator-language-selector';
        selector.setAttribute('aria-label', 'Select language for translation');
        selector.innerHTML = `
            <option value="en">English</option>
            <option value="zh-cn">简体中文 (Simplified Chinese)</option>
            <option value="zh-tw">繁體中文 (Traditional Chinese)</option>
        `;

        // Create status indicator
        const status = document.createElement('span');
        status.id = 'translator-status';
        status.className = 'translator-status translator-loading';
        status.textContent = 'Initializing...';
        status.setAttribute('aria-live', 'polite');
        status.setAttribute('aria-label', 'Translation status');

        // Assemble control panel
        controls.appendChild(selector);
        controls.appendChild(status);

        // Insert controls at the beginning of body
        document.body.insertBefore(backButton, document.body.firstChild);
        document.body.insertBefore(controls, document.body.firstChild);

        // Show back button conditionally
        const currentPath = window.location.pathname.toLowerCase();
        const isMainPage = currentPath.endsWith('documentation.html') ||
                          currentPath.endsWith('/') ||
                          currentPath.includes('index.html');

        if (!isMainPage) {
            backButton.style.display = 'block';
        }

        // Add event listeners
        selector.addEventListener('change', function() {
            const selectedLang = this.value;
            console.log(`🔄 Language selector changed to: ${selectedLang}`);
            changeLanguage(selectedLang);
        });

        // Add keyboard navigation
        selector.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });

        backButton.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                history.back();
            }
        });

        console.log('🎛️ Translation controls added successfully');
        return { selector, status };
    }

    /**
     * Change language with comprehensive error handling and status updates
     * @param {string} lang - Target language code
     */
    function changeLanguage(lang) {
        console.log(`🔄 Changing language to: ${lang}`);

        const status = document.getElementById('translator-status');
        const startTime = performance.now();

        // Update status to loading
        if (status) {
            status.className = 'translator-status translator-loading';
            status.textContent = 'Translating...';
            status.setAttribute('aria-label', `Translating to ${getLanguageName(lang)}`);
        }

        try {
            // Save language selection
            localStorage.setItem('selectedLanguage', lang);

            // Add translating class to body for visual feedback
            document.body.classList.add('translating');

            // Use advanced auto-translator if available
            if (window.autoTranslator && typeof window.autoTranslator.setLanguage === 'function') {
                console.log('🤖 Using advanced auto-translator');
                window.autoTranslator.setLanguage(lang);
            } else {
                console.log('📝 Using basic translation fallback');
                basicTranslate(lang);
            }

            // Update HTML language attributes
            document.documentElement.lang = lang;
            document.documentElement.setAttribute('xml:lang', lang);

            // Update status after translation
            setTimeout(() => {
                const translationTime = performance.now() - startTime;

                if (status) {
                    status.className = 'translator-status translator-ready';
                    const statusText = getStatusText(lang);
                    status.textContent = statusText;
                    status.setAttribute('aria-label', `Translation complete. Current language: ${getLanguageName(lang)}`);
                }

                // Remove translating class
                document.body.classList.remove('translating');

                console.log(`✅ Language change completed in ${translationTime.toFixed(2)}ms`);
            }, 300);

        } catch (error) {
            console.error('❌ Error changing language:', error);

            if (status) {
                status.className = 'translator-status translator-error';
                status.textContent = 'Error';
                status.setAttribute('aria-label', 'Translation error occurred');
            }

            // Remove translating class on error
            document.body.classList.remove('translating');
        }
    }

    /**
     * Get human-readable language name
     * @param {string} lang - Language code
     * @returns {string} Language name
     */
    function getLanguageName(lang) {
        const names = {
            'en': 'English',
            'zh-cn': 'Simplified Chinese',
            'zh-tw': 'Traditional Chinese'
        };
        return names[lang] || lang;
    }

    /**
     * Get status text for language
     * @param {string} lang - Language code
     * @returns {string} Status text
     */
    function getStatusText(lang) {
        const statusTexts = {
            'en': 'Ready',
            'zh-cn': '就绪',
            'zh-tw': '就緒'
        };
        return statusTexts[lang] || 'Ready';
    }

    // 基本翻譯功能（當自動翻譯器不可用時）
    function basicTranslate(lang) {
        if (lang === 'en') {
            // 恢復原始文本
            restoreOriginalTexts();
            return;
        }

        // 基本詞彙翻譯
        const basicTranslations = {
            'zh-cn': {
                'Requirements': '系統要求',
                'Installation': '安裝',
                'Configuration': '配置',
                'Overview': '概述',
                'Settings': '設置',
                'Templates': '模板',
                'Devices': '設備',
                'Graphs': '圖形',
                'Data Sources': '數據源',
                'Management': '管理',
                'Automation': '自動化',
                'Table of Contents': '目錄',
                'Getting Started': '入門指南',
                'User Guide': '用戶指南',
                'Administrator Guide': '管理員指南',
                'Troubleshooting': '故障排除',
                'Known Issues': '已知問題',
                'Add': '添加',
                'Edit': '編輯',
                'Delete': '刪除',
                'Save': '保存',
                'Cancel': '取消',
                'Create': '創建',
                'Update': '更新',
                'Enable': '啟用',
                'Disable': '禁用',
                'Active': '活動',
                'Inactive': '非活動',
                'Online': '在線',
                'Offline': '離線',
                'Copyright (c) 2004-2024 The Cacti Group': '版權所有 (c) 2004-2024 Cacti 團隊'
            },
            'zh-tw': {
                'Requirements': '系統要求',
                'Installation': '安裝',
                'Configuration': '配置',
                'Overview': '概述',
                'Settings': '設定',
                'Templates': '範本',
                'Devices': '裝置',
                'Graphs': '圖形',
                'Data Sources': '資料來源',
                'Management': '管理',
                'Automation': '自動化',
                'Table of Contents': '目錄',
                'Getting Started': '入門指南',
                'User Guide': '使用者指南',
                'Administrator Guide': '管理員指南',
                'Troubleshooting': '故障排除',
                'Known Issues': '已知問題',
                'Add': '新增',
                'Edit': '編輯',
                'Delete': '刪除',
                'Save': '儲存',
                'Cancel': '取消',
                'Create': '建立',
                'Update': '更新',
                'Enable': '啟用',
                'Disable': '停用',
                'Active': '活動',
                'Inactive': '非活動',
                'Online': '線上',
                'Offline': '離線',
                'Copyright (c) 2004-2024 The Cacti Group': '版權所有 (c) 2004-2024 Cacti 團隊'
            }
        };

        const translations = basicTranslations[lang];
        if (!translations) return;

        // 翻譯文本內容
        translateTextContent(translations);
        
        // 翻譯頁面標題
        translatePageTitle(translations);
    }

    // 翻譯文本內容
    function translateTextContent(translations) {
        const walker = document.createTreeWalker(
            document.body,
            NodeFilter.SHOW_TEXT,
            {
                acceptNode: function(node) {
                    const element = node.parentElement;
                    if (!element) return NodeFilter.FILTER_REJECT;
                    
                    // 排除不需要翻譯的元素
                    if (element.matches('script, style, code, pre, .no-translate, [data-no-translate], .translator-controls')) {
                        return NodeFilter.FILTER_REJECT;
                    }
                    
                    const text = node.textContent.trim();
                    if (text.length === 0) return NodeFilter.FILTER_REJECT;
                    
                    return NodeFilter.FILTER_ACCEPT;
                }
            }
        );

        const textNodes = [];
        let node;
        while (node = walker.nextNode()) {
            textNodes.push(node);
        }

        textNodes.forEach(textNode => {
            const originalText = textNode.textContent;
            
            // 保存原始文本
            if (!textNode.hasAttribute('data-original-text')) {
                textNode.parentElement.setAttribute('data-original-text-' + Date.now(), originalText);
            }

            let translatedText = originalText;
            
            // 逐詞翻譯
            Object.keys(translations).forEach(key => {
                const regex = new RegExp(`\\b${key}\\b`, 'gi');
                translatedText = translatedText.replace(regex, translations[key]);
            });

            if (translatedText !== originalText) {
                textNode.textContent = translatedText;
            }
        });
    }

    // 翻譯頁面標題
    function translatePageTitle(translations) {
        const originalTitle = document.title;
        
        if (!document.documentElement.hasAttribute('data-original-title')) {
            document.documentElement.setAttribute('data-original-title', originalTitle);
        }

        let translatedTitle = originalTitle;
        Object.keys(translations).forEach(key => {
            const regex = new RegExp(`\\b${key}\\b`, 'gi');
            translatedTitle = translatedTitle.replace(regex, translations[key]);
        });

        document.title = translatedTitle;
    }

    // 恢復原始文本
    function restoreOriginalTexts() {
        // 恢復頁面標題
        const originalTitle = document.documentElement.getAttribute('data-original-title');
        if (originalTitle) {
            document.title = originalTitle;
        }

        // 恢復文本內容（這裡簡化處理，實際應用中可能需要更複雜的邏輯）
        location.reload();
    }

    // 初始化語言
    function initializeLanguage() {
        const savedLang = localStorage.getItem('selectedLanguage') || 'en';
        const selector = document.getElementById('translator-language-selector');
        
        if (selector) {
            selector.value = savedLang;
        }

        if (savedLang !== 'en') {
            setTimeout(() => changeLanguage(savedLang), 100);
        } else {
            const status = document.getElementById('translator-status');
            if (status) {
                status.className = 'translator-status translator-ready';
                status.textContent = 'Ready';
            }
        }
    }

    // 主初始化函數
    function initialize() {
        console.log('Universal Translator starting initialization...');
        
        // 添加樣式
        addTranslatorStyles();
        
        // 添加控制面板
        addTranslatorControls();
        
        // 嘗試加載自動翻譯器
        const autoTranslatorScript = document.createElement('script');
        autoTranslatorScript.src = 'js/auto-translator.js';
        autoTranslatorScript.onload = function() {
            console.log('Auto-translator loaded successfully');
            if (window.autoTranslator) {
                window.autoTranslator.init();
            }
            initializeLanguage();
        };
        autoTranslatorScript.onerror = function() {
            console.log('Auto-translator not available, using basic translation');
            initializeLanguage();
        };
        document.head.appendChild(autoTranslatorScript);
        
        console.log('Universal Translator initialized');
    }

    // 等待DOM加載完成
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initialize);
    } else {
        initialize();
    }

    // 導出全局函數
    window.changeLanguage = changeLanguage;

})();
