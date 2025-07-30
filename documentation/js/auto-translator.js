/**
 * Comprehensive Multilingual Translation System for Cacti Documentation
 * Supports automatic translation of any HTML content without manual editing
 * Languages: English (default), Simplified Chinese, Traditional Chinese
 *
 * @author Cacti Tools Plugin Team
 * @version 2.0.0
 */

class AutoTranslator {
    constructor() {
        this.currentLanguage = 'en';
        this.originalTexts = new Map(); // Store original text content
        this.translationCache = new Map(); // Translation cache for performance
        this.isTranslating = false;
        this.isInitialized = false;

        // Elements to exclude from translation
        this.excludeSelectors = [
            'script', 'style', 'code', 'pre', 'noscript',
            '.no-translate', '[data-no-translate]',
            'input', 'textarea', 'select', 'option',
            '.translator-controls', '.translator-back-button',
            '[contenteditable="true"]'
        ];

        // Initialize comprehensive translation dictionary
        this.initTranslationDictionary();

        // Performance monitoring
        this.performanceMetrics = {
            translationTime: 0,
            elementsProcessed: 0,
            cacheHits: 0
        };

        console.log('🌍 AutoTranslator v2.0.0 initialized');
    }

    /**
     * Initialize comprehensive translation dictionary
     * Covers Cacti-specific terms, UI elements, and technical documentation
     */
    initTranslationDictionary() {
        this.translations = {
            // === CORE SYSTEM TERMS ===
            'Requirements': { 'zh-cn': '系统要求', 'zh-tw': '系統要求' },
            'Installation': { 'zh-cn': '安装', 'zh-tw': '安裝' },
            'Configuration': { 'zh-cn': '配置', 'zh-tw': '配置' },
            'Overview': { 'zh-cn': '概述', 'zh-tw': '概述' },
            'Settings': { 'zh-cn': '设置', 'zh-tw': '設定' },
            'Templates': { 'zh-cn': '模板', 'zh-tw': '範本' },
            'Devices': { 'zh-cn': '设备', 'zh-tw': '裝置' },
            'Graphs': { 'zh-cn': '图形', 'zh-tw': '圖形' },
            'Data Sources': { 'zh-cn': '数据源', 'zh-tw': '資料來源' },
            'Management': { 'zh-cn': '管理', 'zh-tw': '管理' },
            'Automation': { 'zh-cn': '自动化', 'zh-tw': '自動化' },
            'Monitoring': { 'zh-cn': '监控', 'zh-tw': '監控' },
            'Performance': { 'zh-cn': '性能', 'zh-tw': '效能' },
            'Security': { 'zh-cn': '安全', 'zh-tw': '安全' },
            'Network': { 'zh-cn': '网络', 'zh-tw': '網路' },
            'Database': { 'zh-cn': '数据库', 'zh-tw': '資料庫' },
            'Server': { 'zh-cn': '服务器', 'zh-tw': '伺服器' },
            'System': { 'zh-cn': '系统', 'zh-tw': '系統' },
            'User': { 'zh-cn': '用户', 'zh-tw': '使用者' },
            'Group': { 'zh-cn': '组', 'zh-tw': '群組' },
            'Permission': { 'zh-cn': '权限', 'zh-tw': '權限' },
            'Authentication': { 'zh-cn': '认证', 'zh-tw': '認證' },
            'Authorization': { 'zh-cn': '授权', 'zh-tw': '授權' },

            // === CACTI SPECIFIC TERMS ===
            'Cacti': { 'zh-cn': 'Cacti', 'zh-tw': 'Cacti' },
            'RRDtool': { 'zh-cn': 'RRDtool', 'zh-tw': 'RRDtool' },
            'SNMP': { 'zh-cn': 'SNMP', 'zh-tw': 'SNMP' },
            'Poller': { 'zh-cn': '轮询器', 'zh-tw': '輪詢器' },
            'Spine': { 'zh-cn': 'Spine', 'zh-tw': 'Spine' },
            'Data Query': { 'zh-cn': '数据查询', 'zh-tw': '資料查詢' },
            'Data Input': { 'zh-cn': '数据输入', 'zh-tw': '資料輸入' },
            'Graph Template': { 'zh-cn': '图形模板', 'zh-tw': '圖形範本' },
            'Device Template': { 'zh-cn': '设备模板', 'zh-tw': '裝置範本' },
            'Data Source Template': { 'zh-cn': '数据源模板', 'zh-tw': '資料來源範本' },
            'Host': { 'zh-cn': '主机', 'zh-tw': '主機' },
            'Plugin': { 'zh-cn': '插件', 'zh-tw': '外掛' },
            'Threshold': { 'zh-cn': '阈值', 'zh-tw': '閾值' },
            'Alert': { 'zh-cn': '警报', 'zh-tw': '警報' },
            'Notification': { 'zh-cn': '通知', 'zh-tw': '通知' },
            'CDEF': { 'zh-cn': 'CDEF', 'zh-tw': 'CDEF' },
            'VDEF': { 'zh-cn': 'VDEF', 'zh-tw': 'VDEF' },
            'GPRINT': { 'zh-cn': 'GPRINT', 'zh-tw': 'GPRINT' },
            'Tree': { 'zh-cn': '树形结构', 'zh-tw': '樹狀結構' },
            'Site': { 'zh-cn': '站点', 'zh-tw': '站點' },
            'Aggregate': { 'zh-cn': '聚合', 'zh-tw': '聚合' },

            // === ACTION VERBS ===
            'Add': { 'zh-cn': '添加', 'zh-tw': '新增' },
            'Edit': { 'zh-cn': '编辑', 'zh-tw': '編輯' },
            'Delete': { 'zh-cn': '删除', 'zh-tw': '刪除' },
            'Remove': { 'zh-cn': '移除', 'zh-tw': '移除' },
            'Save': { 'zh-cn': '保存', 'zh-tw': '儲存' },
            'Cancel': { 'zh-cn': '取消', 'zh-tw': '取消' },
            'Create': { 'zh-cn': '创建', 'zh-tw': '建立' },
            'Update': { 'zh-cn': '更新', 'zh-tw': '更新' },
            'Configure': { 'zh-cn': '配置', 'zh-tw': '配置' },
            'Install': { 'zh-cn': '安装', 'zh-tw': '安裝' },
            'Upgrade': { 'zh-cn': '升级', 'zh-tw': '升級' },
            'Enable': { 'zh-cn': '启用', 'zh-tw': '啟用' },
            'Disable': { 'zh-cn': '禁用', 'zh-tw': '停用' },
            'Start': { 'zh-cn': '开始', 'zh-tw': '開始' },
            'Stop': { 'zh-cn': '停止', 'zh-tw': '停止' },
            'Restart': { 'zh-cn': '重启', 'zh-tw': '重新啟動' },
            'Import': { 'zh-cn': '导入', 'zh-tw': '匯入' },
            'Export': { 'zh-cn': '导出', 'zh-tw': '匯出' },
            'Copy': { 'zh-cn': '复制', 'zh-tw': '複製' },
            'Duplicate': { 'zh-cn': '复制', 'zh-tw': '複製' },
            'View': { 'zh-cn': '查看', 'zh-tw': '檢視' },
            'Browse': { 'zh-cn': '浏览', 'zh-tw': '瀏覽' },
            'Search': { 'zh-cn': '搜索', 'zh-tw': '搜尋' },
            'Filter': { 'zh-cn': '过滤', 'zh-tw': '篩選' },
            'Sort': { 'zh-cn': '排序', 'zh-tw': '排序' },
            'Refresh': { 'zh-cn': '刷新', 'zh-tw': '重新整理' },
            'Reset': { 'zh-cn': '重置', 'zh-tw': '重設' },
            'Clear': { 'zh-cn': '清除', 'zh-tw': '清除' },
            'Apply': { 'zh-cn': '应用', 'zh-tw': '套用' },
            'Submit': { 'zh-cn': '提交', 'zh-tw': '提交' },

            // === STATUS TERMS ===
            'Active': { 'zh-cn': '活动', 'zh-tw': '活動' },
            'Inactive': { 'zh-cn': '非活动', 'zh-tw': '非活動' },
            'Enabled': { 'zh-cn': '已启用', 'zh-tw': '已啟用' },
            'Disabled': { 'zh-cn': '已禁用', 'zh-tw': '已停用' },
            'Online': { 'zh-cn': '在线', 'zh-tw': '線上' },
            'Offline': { 'zh-cn': '离线', 'zh-tw': '離線' },
            'Running': { 'zh-cn': '运行中', 'zh-tw': '執行中' },
            'Stopped': { 'zh-cn': '已停止', 'zh-tw': '已停止' },
            'Connected': { 'zh-cn': '已连接', 'zh-tw': '已連線' },
            'Disconnected': { 'zh-cn': '已断开', 'zh-tw': '已斷線' },
            'Available': { 'zh-cn': '可用', 'zh-tw': '可用' },
            'Unavailable': { 'zh-cn': '不可用', 'zh-tw': '不可用' },
            'Success': { 'zh-cn': '成功', 'zh-tw': '成功' },
            'Failed': { 'zh-cn': '失败', 'zh-tw': '失敗' },
            'Error': { 'zh-cn': '错误', 'zh-tw': '錯誤' },
            'Warning': { 'zh-cn': '警告', 'zh-tw': '警告' },
            'Information': { 'zh-cn': '信息', 'zh-tw': '資訊' },
            'Notice': { 'zh-cn': '通知', 'zh-tw': '通知' },
            'Pending': { 'zh-cn': '待处理', 'zh-tw': '待處理' },
            'Processing': { 'zh-cn': '处理中', 'zh-tw': '處理中' },
            'Complete': { 'zh-cn': '完成', 'zh-tw': '完成' },
            'Incomplete': { 'zh-cn': '未完成', 'zh-tw': '未完成' },
            'Valid': { 'zh-cn': '有效', 'zh-tw': '有效' },
            'Invalid': { 'zh-cn': '无效', 'zh-tw': '無效' },
            'Unknown': { 'zh-cn': '未知', 'zh-tw': '未知' },

            // === COMMON PHRASES ===
            'Table of Contents': { 'zh-cn': '目录', 'zh-tw': '目錄' },
            'Getting Started': { 'zh-cn': '入门指南', 'zh-tw': '入門指南' },
            'Quick Start': { 'zh-cn': '快速开始', 'zh-tw': '快速開始' },
            'User Guide': { 'zh-cn': '用户指南', 'zh-tw': '使用者指南' },
            'Administrator Guide': { 'zh-cn': '管理员指南', 'zh-tw': '管理員指南' },
            'Installation Guide': { 'zh-cn': '安装指南', 'zh-tw': '安裝指南' },
            'Configuration Guide': { 'zh-cn': '配置指南', 'zh-tw': '配置指南' },
            'Troubleshooting': { 'zh-cn': '故障排除', 'zh-tw': '故障排除' },
            'Known Issues': { 'zh-cn': '已知问题', 'zh-tw': '已知問題' },
            'Release Notes': { 'zh-cn': '发布说明', 'zh-tw': '發布說明' },
            'Change Log': { 'zh-cn': '更改日志', 'zh-tw': '變更日誌' },
            'Documentation': { 'zh-cn': '文档', 'zh-tw': '文件' },
            'Help': { 'zh-cn': '帮助', 'zh-tw': '說明' },
            'Support': { 'zh-cn': '支持', 'zh-tw': '支援' },
            'Contact': { 'zh-cn': '联系', 'zh-tw': '聯絡' },
            'About': { 'zh-cn': '关于', 'zh-tw': '關於' },
            'Version': { 'zh-cn': '版本', 'zh-tw': '版本' },
            'License': { 'zh-cn': '许可证', 'zh-tw': '授權' },
            'Copyright': { 'zh-cn': '版权', 'zh-tw': '版權' },
            'Home': { 'zh-cn': '首页', 'zh-tw': '首頁' },
            'Back': { 'zh-cn': '返回', 'zh-tw': '返回' },
            'Next': { 'zh-cn': '下一步', 'zh-tw': '下一步' },
            'Previous': { 'zh-cn': '上一步', 'zh-tw': '上一步' },
            'Continue': { 'zh-cn': '继续', 'zh-tw': '繼續' },
            'Finish': { 'zh-cn': '完成', 'zh-tw': '完成' },
            'Close': { 'zh-cn': '关闭', 'zh-tw': '關閉' },
            'Open': { 'zh-cn': '打开', 'zh-tw': '開啟' },
            'Download': { 'zh-cn': '下载', 'zh-tw': '下載' },
            'Upload': { 'zh-cn': '上传', 'zh-tw': '上傳' },
            'Print': { 'zh-cn': '打印', 'zh-tw': '列印' },

            // === TECHNICAL TERMS ===
            'Interface': { 'zh-cn': '接口', 'zh-tw': '介面' },
            'Protocol': { 'zh-cn': '协议', 'zh-tw': '協定' },
            'Port': { 'zh-cn': '端口', 'zh-tw': '連接埠' },
            'IP Address': { 'zh-cn': 'IP地址', 'zh-tw': 'IP位址' },
            'Hostname': { 'zh-cn': '主机名', 'zh-tw': '主機名稱' },
            'Domain': { 'zh-cn': '域', 'zh-tw': '網域' },
            'URL': { 'zh-cn': 'URL', 'zh-tw': 'URL' },
            'Path': { 'zh-cn': '路径', 'zh-tw': '路徑' },
            'Directory': { 'zh-cn': '目录', 'zh-tw': '目錄' },
            'File': { 'zh-cn': '文件', 'zh-tw': '檔案' },
            'Folder': { 'zh-cn': '文件夹', 'zh-tw': '資料夾' },
            'Log': { 'zh-cn': '日志', 'zh-tw': '日誌' },
            'Event': { 'zh-cn': '事件', 'zh-tw': '事件' },
            'Process': { 'zh-cn': '进程', 'zh-tw': '程序' },
            'Service': { 'zh-cn': '服务', 'zh-tw': '服務' },
            'Application': { 'zh-cn': '应用程序', 'zh-tw': '應用程式' },
            'Module': { 'zh-cn': '模块', 'zh-tw': '模組' },
            'Component': { 'zh-cn': '组件', 'zh-tw': '元件' },
            'Function': { 'zh-cn': '功能', 'zh-tw': '功能' },
            'Feature': { 'zh-cn': '特性', 'zh-tw': '特性' },
            'Option': { 'zh-cn': '选项', 'zh-tw': '選項' },
            'Parameter': { 'zh-cn': '参数', 'zh-tw': '參數' },
            'Value': { 'zh-cn': '值', 'zh-tw': '值' },
            'Variable': { 'zh-cn': '变量', 'zh-tw': '變數' },
            'Constant': { 'zh-cn': '常量', 'zh-tw': '常數' },
            'Default': { 'zh-cn': '默认', 'zh-tw': '預設' },
            'Custom': { 'zh-cn': '自定义', 'zh-tw': '自訂' },
            'Automatic': { 'zh-cn': '自动', 'zh-tw': '自動' },
            'Manual': { 'zh-cn': '手动', 'zh-tw': '手動' },

            // === LONG PHRASES AND SENTENCES ===
            'Copyright (c) 2004-2024 The Cacti Group': {
                'zh-cn': '版权所有 (c) 2004-2024 Cacti 团队',
                'zh-tw': '版權所有 (c) 2004-2024 Cacti 團隊'
            },
            'Cacti is designed to be a complete graphing solution': {
                'zh-cn': 'Cacti 旨在成为完整的图形解决方案',
                'zh-tw': 'Cacti 旨在成為完整的圖形解決方案'
            },
            'Please see the official Cacti website for information, support, and updates': {
                'zh-cn': '请访问 Cacti 官方网站获取信息、支持和更新',
                'zh-tw': '請造訪 Cacti 官方網站獲取資訊、支援和更新'
            },
            'This section contains information on how to install and/or upgrade the Cacti system': {
                'zh-cn': '本节包含有关如何安装和/或升级 Cacti 系统的信息',
                'zh-tw': '本節包含有關如何安裝和/或升級 Cacti 系統的資訊'
            },
            'This section describes Cacti components and their purpose': {
                'zh-cn': '本节描述 Cacti 组件及其用途',
                'zh-tw': '本節描述 Cacti 元件及其用途'
            },
            'This section covers more advanced material': {
                'zh-cn': '本节涵盖更高级的内容',
                'zh-tw': '本節涵蓋更進階的內容'
            },
            'This section contains all Plugin development related information': {
                'zh-cn': '本节包含所有插件开发相关信息',
                'zh-tw': '本節包含所有外掛開發相關資訊'
            },
            'Cacti requires that the following software is installed on your system': {
                'zh-cn': 'Cacti 需要在您的系统上安装以下软件',
                'zh-tw': 'Cacti 需要在您的系統上安裝以下軟體'
            },
            'Web Server that supports PHP': {
                'zh-cn': '支持 PHP 的 Web 服务器',
                'zh-tw': '支援 PHP 的 Web 伺服器'
            },
            'Build environment when using spine': {
                'zh-cn': '使用 spine 时的构建环境',
                'zh-tw': '使用 spine 時的建置環境'
            },
            'RRDtool 1.3 or greater, 1.5+ recommended': {
                'zh-cn': 'RRDtool 1.3 或更高版本，推荐 1.5+',
                'zh-tw': 'RRDtool 1.3 或更高版本，推薦 1.5+'
            },
            'PHP 5.4 or greater, 5.5+ recommended': {
                'zh-cn': 'PHP 5.4 或更高版本，推荐 5.5+',
                'zh-tw': 'PHP 5.4 或更高版本，推薦 5.5+'
            },
            'MySQL 5.6 or MariaDB 5.5 or greater': {
                'zh-cn': 'MySQL 5.6 或 MariaDB 5.5 或更高版本',
                'zh-tw': 'MySQL 5.6 或 MariaDB 5.5 或更高版本'
            }
        };

        console.log(`📚 Translation dictionary initialized with ${Object.keys(this.translations).length} entries`);
    }

    // 獲取當前語言
    getCurrentLanguage() {
        return localStorage.getItem('selectedLanguage') || 'en';
    }

    // 設置語言
    setLanguage(lang) {
        this.currentLanguage = lang;
        localStorage.setItem('selectedLanguage', lang);
        this.translatePage();
    }

    /**
     * Translate individual text with intelligent matching and caching
     * @param {string} text - Text to translate
     * @param {string} targetLang - Target language code
     * @returns {string} Translated text
     */
    translateText(text, targetLang) {
        if (!text || targetLang === 'en') return text;

        const startTime = performance.now();

        // Trim and normalize text
        const normalizedText = text.trim();
        if (!normalizedText) return text;

        // Check cache first
        const cacheKey = `${normalizedText}_${targetLang}`;
        if (this.translationCache.has(cacheKey)) {
            this.performanceMetrics.cacheHits++;
            return this.translationCache.get(cacheKey);
        }

        // Exact match (highest priority)
        if (this.translations[normalizedText] && this.translations[normalizedText][targetLang]) {
            const translation = this.translations[normalizedText][targetLang];
            this.translationCache.set(cacheKey, translation);
            this.updatePerformanceMetrics(startTime);
            return translation;
        }

        // Case-insensitive exact match
        const lowerText = normalizedText.toLowerCase();
        for (const [key, value] of Object.entries(this.translations)) {
            if (key.toLowerCase() === lowerText && value[targetLang]) {
                const translation = value[targetLang];
                this.translationCache.set(cacheKey, translation);
                this.updatePerformanceMetrics(startTime);
                return translation;
            }
        }

        // Partial matching and word-by-word translation
        let translatedText = normalizedText;
        let hasChanges = false;

        // Sort keys by length (longest first) for better matching
        const sortedKeys = Object.keys(this.translations).sort((a, b) => b.length - a.length);

        for (const key of sortedKeys) {
            if (this.translations[key][targetLang]) {
                // Use word boundaries for better matching
                const regex = new RegExp(`\\b${this.escapeRegex(key)}\\b`, 'gi');
                const newText = translatedText.replace(regex, this.translations[key][targetLang]);
                if (newText !== translatedText) {
                    translatedText = newText;
                    hasChanges = true;
                }
            }
        }

        // Cache the result if there were changes
        if (hasChanges) {
            this.translationCache.set(cacheKey, translatedText);
        }

        this.updatePerformanceMetrics(startTime);
        return translatedText;
    }

    /**
     * Escape special regex characters
     * @param {string} string - String to escape
     * @returns {string} Escaped string
     */
    escapeRegex(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    /**
     * Update performance metrics
     * @param {number} startTime - Start time in milliseconds
     */
    updatePerformanceMetrics(startTime) {
        this.performanceMetrics.translationTime += performance.now() - startTime;
        this.performanceMetrics.elementsProcessed++;
    }

    // 檢查元素是否應該被翻譯
    shouldTranslateElement(element) {
        // 檢查排除選擇器
        for (let selector of this.excludeSelectors) {
            if (element.matches && element.matches(selector)) {
                return false;
            }
        }

        // 檢查父元素是否有排除標記
        let parent = element.parentElement;
        while (parent) {
            if (parent.hasAttribute('data-no-translate') || 
                parent.classList.contains('no-translate')) {
                return false;
            }
            parent = parent.parentElement;
        }

        return true;
    }

    /**
     * Translate entire page with performance optimization
     * @returns {Promise<void>}
     */
    async translatePage() {
        if (this.isTranslating) return;
        this.isTranslating = true;

        const targetLang = this.getCurrentLanguage();
        const startTime = performance.now();

        console.log(`🔄 Translating page to: ${targetLang}`);

        try {
            // Reset performance metrics
            this.performanceMetrics = {
                translationTime: 0,
                elementsProcessed: 0,
                cacheHits: 0
            };

            if (targetLang === 'en') {
                // Restore original texts for English
                this.restoreOriginalTexts();
            } else {
                // Translate page content
                await this.translateElements(targetLang);
            }

            // Update page title
            this.translatePageTitle(targetLang);

            // Update language selector
            this.updateLanguageSelector(targetLang);

            // Update HTML language attributes
            this.updateLanguageAttributes(targetLang);

            const totalTime = performance.now() - startTime;
            console.log(`✅ Translation completed in ${totalTime.toFixed(2)}ms`);
            console.log(`📊 Performance: ${this.performanceMetrics.elementsProcessed} elements, ${this.performanceMetrics.cacheHits} cache hits`);

        } catch (error) {
            console.error('❌ Translation error:', error);
        } finally {
            this.isTranslating = false;
        }
    }

    /**
     * Update HTML language attributes
     * @param {string} lang - Language code
     */
    updateLanguageAttributes(lang) {
        document.documentElement.lang = lang;
        document.documentElement.setAttribute('xml:lang', lang);
    }

    /**
     * Translate all elements on the page with intelligent filtering
     * @param {string} targetLang - Target language code
     * @returns {Promise<void>}
     */
    async translateElements(targetLang) {
        // Create optimized tree walker for text nodes
        const walker = document.createTreeWalker(
            document.body,
            NodeFilter.SHOW_TEXT,
            {
                acceptNode: (node) => {
                    const element = node.parentElement;
                    if (!element || !this.shouldTranslateElement(element)) {
                        return NodeFilter.FILTER_REJECT;
                    }

                    const text = node.textContent.trim();
                    // Filter out empty text, whitespace-only, and very short text
                    if (text.length === 0 || /^\s*$/.test(text) || text.length < 2) {
                        return NodeFilter.FILTER_REJECT;
                    }

                    // Skip text that looks like code or technical identifiers
                    if (/^[A-Z_][A-Z0-9_]*$/.test(text) || /^\d+(\.\d+)*$/.test(text)) {
                        return NodeFilter.FILTER_REJECT;
                    }

                    return NodeFilter.FILTER_ACCEPT;
                }
            }
        );

        // Collect all text nodes first
        const textNodes = [];
        let node;
        while (node = walker.nextNode()) {
            textNodes.push(node);
        }

        console.log(`🔍 Found ${textNodes.length} text nodes to translate`);

        // Process text nodes in batches for better performance
        const batchSize = 50;
        for (let i = 0; i < textNodes.length; i += batchSize) {
            const batch = textNodes.slice(i, i + batchSize);

            for (const textNode of batch) {
                try {
                    const originalText = textNode.textContent;

                    // Store original text if not already stored
                    if (!this.originalTexts.has(textNode)) {
                        this.originalTexts.set(textNode, originalText);
                    }

                    // Translate text
                    const translatedText = this.translateText(originalText, targetLang);
                    if (translatedText !== originalText) {
                        textNode.textContent = translatedText;
                    }
                } catch (error) {
                    console.warn('Error translating text node:', error);
                }
            }

            // Allow UI to update between batches
            if (i + batchSize < textNodes.length) {
                await new Promise(resolve => setTimeout(resolve, 1));
            }
        }

        // Translate element attributes
        await this.translateAttributes(targetLang);

        console.log(`✅ Translated ${textNodes.length} text elements`);
    }

    // 翻譯特定屬性
    translateAttributes(targetLang) {
        // 翻譯 title 屬性
        const elementsWithTitle = document.querySelectorAll('[title]');
        elementsWithTitle.forEach(element => {
            if (!this.shouldTranslateElement(element)) return;
            
            const originalTitle = element.getAttribute('title');
            if (!element.hasAttribute('data-original-title')) {
                element.setAttribute('data-original-title', originalTitle);
            }
            
            const translatedTitle = this.translateText(originalTitle, targetLang);
            element.setAttribute('title', translatedTitle);
        });

        // 翻譯 placeholder 屬性
        const elementsWithPlaceholder = document.querySelectorAll('[placeholder]');
        elementsWithPlaceholder.forEach(element => {
            if (!this.shouldTranslateElement(element)) return;
            
            const originalPlaceholder = element.getAttribute('placeholder');
            if (!element.hasAttribute('data-original-placeholder')) {
                element.setAttribute('data-original-placeholder', originalPlaceholder);
            }
            
            const translatedPlaceholder = this.translateText(originalPlaceholder, targetLang);
            element.setAttribute('placeholder', translatedPlaceholder);
        });
    }

    // 恢復原始文本
    restoreOriginalTexts() {
        // 恢復文本節點
        this.originalTexts.forEach((originalText, textNode) => {
            if (textNode.parentNode) {
                textNode.textContent = originalText;
            }
        });

        // 恢復屬性
        document.querySelectorAll('[data-original-title]').forEach(element => {
            element.setAttribute('title', element.getAttribute('data-original-title'));
        });

        document.querySelectorAll('[data-original-placeholder]').forEach(element => {
            element.setAttribute('placeholder', element.getAttribute('data-original-placeholder'));
        });
    }

    // 翻譯頁面標題
    translatePageTitle(targetLang) {
        const originalTitle = document.title;
        
        if (!document.hasAttribute('data-original-title')) {
            document.documentElement.setAttribute('data-original-title', originalTitle);
        }

        if (targetLang === 'en') {
            const originalTitle = document.documentElement.getAttribute('data-original-title');
            if (originalTitle) {
                document.title = originalTitle;
            }
        } else {
            const translatedTitle = this.translateText(originalTitle, targetLang);
            document.title = translatedTitle;
        }
    }

    // 更新語言選擇器
    updateLanguageSelector(targetLang) {
        const selector = document.getElementById('languageSelector');
        if (selector) {
            selector.value = targetLang;
        }
    }

    // 初始化
    init() {
        // 設置當前語言
        this.currentLanguage = this.getCurrentLanguage();
        
        // 如果不是英文，立即翻譯
        if (this.currentLanguage !== 'en') {
            setTimeout(() => this.translatePage(), 100);
        }

        // 監聽動態內容變化
        this.observeContentChanges();
        
        console.log('AutoTranslator initialized with language:', this.currentLanguage);
    }

    // 監聽內容變化
    observeContentChanges() {
        const observer = new MutationObserver((mutations) => {
            let shouldRetranslate = false;
            
            mutations.forEach((mutation) => {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    // 檢查是否有新的文本內容
                    for (let node of mutation.addedNodes) {
                        if (node.nodeType === Node.TEXT_NODE || 
                            (node.nodeType === Node.ELEMENT_NODE && node.textContent.trim())) {
                            shouldRetranslate = true;
                            break;
                        }
                    }
                }
            });

            if (shouldRetranslate && this.currentLanguage !== 'en') {
                setTimeout(() => this.translatePage(), 100);
            }
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
}

// 全局翻譯器實例
window.autoTranslator = new AutoTranslator();
