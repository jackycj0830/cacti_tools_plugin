/**
 * IP Blacklist Query System - Frontend JavaScript
 * 黑名單IP查詢系統 - 前端腳本
 */

const API_URL = 'api.php';
let currentLang = 'zh';

const i18n = {
    zh: {
        total_blacklisted: '黑名單IP總數',
        last_updated: '最後更新',
        single_query: '單一查詢',
        batch_query: '批量查詢',
        history: '查詢歷史',
        geoip_apis: 'GeoIP APIs',
        query: '查詢',
        refresh: '刷新',
        quick_test: '快速測試:',
        loading: '查詢中...',
        no_results: '無查詢結果',
        geo_info: '地理位置',
        threat_info: '威脅情報',
        country: '國家',
        region: '地區',
        city: '城市',
        isp: 'ISP',
        org: '組織',
        threat_type: '威脅類型',
        severity: '嚴重程度',
        first_seen: '首次發現',
        last_seen: '最近發現',
        report_count: '舉報次數',
        total: '總計',
        blocked: '已封鎖',
        safe: '安全',
        ip: 'IP地址',
        status: '狀態',
        timestamp: '查詢時間',
        cidr_range: 'CIDR範圍',
        blacklisted_ips: '黑名單IP列表',
        provider: '提供者',
        priority: '優先順序',
        rate_limit: '請求限制',
        enabled: '已啟用',
        disabled: '已停用',
        requires_key: '需要API金鑰',
        geo_source: '數據來源',
        // New translations for aggregated display
        providers_responded: '個提供者已回應',
        provider_details: '各提供者詳細數據',
        show_details: '顯示詳情',
        hide_details: '隱藏詳情',
        no_provider_data: '無提供者數據',
        no_response: '無回應',
        risk_assessment: '風險評估',
        blacklist_check: '黑名單檢查',
        providers_data: '提供者數據',
        recommendation: '建議',
        risk_factors: '風險因素',
        high_risk: '高風險',
        medium_risk: '中等風險',
        low_risk: '低風險',
        // Fortigate CLI translations
        fortigate_cli: '防火牆指令',
        input_ips: '輸入 IP 地址',
        address_prefix: '地址名稱前綴',
        subnet_mask: '子網掩碼',
        generate_cli: '產生指令',
        clear: '清除',
        load_blacklist: '載入黑名單 IP',
        generated_commands: '產生的指令',
        ips_processed: '個 IP 已處理',
        copy_to_clipboard: '複製到剪貼簿',
        download_file: '下載檔案',
        validation_errors: '驗證錯誤',
        usage_tips: '使用提示',
        tip_1: '輸入的 IP 地址會自動驗證，無效的 IP 會被忽略',
        tip_2: '產生的指令可直接貼入 Fortigate CLI 執行',
        tip_3: '建議先在測試環境驗證指令後再應用至生產環境',
        tip_4: '點擊「載入黑名單 IP」可自動載入系統中的黑名單 IP',
        copied_success: '已複製到剪貼簿！',
        no_valid_ips: '未找到有效的 IP 地址',
        invalid_ip_format: '無效的 IP 格式',
        // Group management translations
        group_management: '群組管理',
        enable_group_assignment: '將 IP 加入群組',
        group_number: '群組編號',
        group_name_preview: '群組名稱預覽',
        group_tip: '使用 append member 指令，不會覆蓋現有成員',
        // Risk methodology and version history
        risk_methodology: '風險評估說明',
        version_history: '版本歷史',
        // Cache translations
        cache_info: '快取資訊',
        from_cache: '來自快取',
        fresh_query: '新鮮查詢',
        save_to_cache: '存入快取',
        save_all_to_cache: '全部存入快取',
        cached_at: '快取時間',
        expires_at: '過期時間',
        remaining_time: '剩餘時間',
        cache_hits: '快取命中',
        not_cached: '未快取',
        already_cached: '已在快取中',
        cache_saved: '已存入快取',
        cache_save_failed: '快取存入失敗',
        saving_to_cache: '存入快取中...',
        // Custom notes translations
        custom_notes: '自訂備註',
        add_note: '新增備註',
        edit_note: '編輯備註',
        save_note: '儲存備註',
        delete_note: '刪除備註',
        cancel: '取消',
        note_placeholder: '在此輸入關於此黑名單IP的備註...',
        no_notes_yet: '尚無備註',
        note_created: '建立於',
        note_updated: '更新於',
        saving_note: '儲存中...',
        deleting_note: '刪除中...',
        note_saved: '備註已儲存',
        note_deleted: '備註已刪除',
        note_save_failed: '備註儲存失敗',
        note_delete_failed: '備註刪除失敗',
        confirm_delete_note: '確定要刪除此備註嗎？',
        note_editor: '備註編輯器',
        expand_editor: '展開編輯器',
        collapse_editor: '收合編輯器',
        clear_content: '清除內容',
        confirm_clear_content: '確定要清除所有內容嗎？',
        drag_to_resize: '拖曳調整大小',
        characters: '字元',
        font_size: '字體大小',
        font_color: '字體顏色',
        select_color: '選擇顏色',
        // External lookup translations
        external_lookups: '外部查詢',
        check_on_whois365: '在 Whois365 檢查',
        check_on_trendmicro: '在 Trend Micro 檢查',
        check_on_virustotal: '在 VirusTotal 檢查',
        // Local database (archive) translations
        local_database: '本地數據查詢',
        archive_statistics: '歸檔統計',
        total_archived: '總歸檔數',
        blacklisted_archived: '黑名單IP',
        high_risk_archived: '高風險',
        countries_archived: '國家數',
        search_filters: '搜尋篩選',
        ip_address: 'IP 地址',
        all_countries: '所有國家',
        all_levels: '所有等級',
        all_status: '所有狀態',
        date_from: '開始日期',
        date_to: '結束日期',
        search: '搜尋',
        clear_filters: '清除篩選',
        quick_lookup: '快速查詢',
        lookup: '查詢',
        search_results: '搜尋結果',
        records_found: '筆記錄',
        previous: '上一頁',
        next: '下一頁',
        ip_details: 'IP 詳情',
        archived_data: '歷史數據',
        no_archived_records: '本地數據庫中沒有找到符合條件的記錄',
        no_results_hint: '嘗試調整搜尋條件或等待更多數據被歸檔',
        original_cached: '原始快取時間',
        original_expired: '原始過期時間',
        archived_at: '歸檔時間',
        total_hits: '總命中次數',
        searching: '搜尋中...',
        // Local batch query translations
        local_batch_query: '本地批量查詢',
        processing_local_batch: '處理本地批量查詢...',
        archive_query: '歸檔數據查詢',
        not_found: '未找到',
        not_in_archive: '歸檔數據庫中無此IP記錄',
        found: '已找到',
        // Chart translations
        show_charts: '顯示圖表分析',
        hide_charts: '隱藏圖表分析',
        data_visualization: '數據可視化分析',
        country_distribution: '國家分布',
        city_distribution: '城市分布',
        isp_distribution: 'ISP分布',
        risk_level_distribution: '風險等級分布',
        risk_score_distribution: '風險評分分布',
        threat_type_distribution: '威脅類型分布',
        top_rankings: 'TOP 排名',
        rank: '排名',
        count: '數量',
        percentage: '百分比',
        no_data: '暫無數據',
        loading_charts: '載入圖表中...',
        refresh_charts: '刷新圖表',
        high_risk: '高風險',
        medium_risk: '中風險',
        low_risk: '低風險',
        unknown_risk: '未知',
        // Chart export translations
        export_chart: '匯出圖表',
        export_as_image: '匯出為圖片',
        download_chart: '下載圖表',
        export_success: '圖表已成功匯出',
        export_failed: '圖表匯出失敗',
        // Geo map translations
        geo_map_title: '全球黑名單IP分布圖',
        geo_map_subtitle: '依國家顯示黑名單IP數量',
        geo_map_no_data: '暫無地理分布數據',
        geo_map_loading: '載入地圖中...',
        ip_count: 'IP數量',
        // Country IP ranges translations
        country_ip_ranges_title: '國家黑名單IP範圍',
        country_ip_ranges_subtitle: '顯示各國家的黑名單IP數量及IP範圍',
        country_legend: '國家IP數量',
        ip_ranges: 'IP範圍',
        blacklisted_ips: '黑名單IP數量',
        // Regional distribution translations
        region_distribution_title: '區域分布統計',
        region_distribution_subtitle: '依區域顯示黑名單IP分布',
        all_regions: '全部',
        region_eu: '歐洲',
        region_am: '美洲',
        region_apac: '亞太地區',
        region_other: '其他',
        region: '區域',
        countries_count: '國家數'
    },
    en: {
        total_blacklisted: 'Total Blacklisted',
        last_updated: 'Last Updated',
        single_query: 'Single Query',
        batch_query: 'Batch Query',
        history: 'History',
        geoip_apis: 'GeoIP APIs',
        query: 'Query',
        refresh: 'Refresh',
        quick_test: 'Quick Test:',
        loading: 'Loading...',
        no_results: 'No results',
        geo_info: 'GeoIP Info',
        threat_info: 'Threat Info',
        country: 'Country',
        region: 'Region',
        city: 'City',
        isp: 'ISP',
        org: 'Organization',
        threat_type: 'Threat Type',
        severity: 'Severity',
        first_seen: 'First Seen',
        last_seen: 'Last Seen',
        report_count: 'Reports',
        total: 'Total',
        blocked: 'Blocked',
        safe: 'Safe',
        ip: 'IP Address',
        status: 'Status',
        timestamp: 'Time',
        cidr_range: 'CIDR Range',
        blacklisted_ips: 'Blacklisted IPs',
        provider: 'Provider',
        priority: 'Priority',
        rate_limit: 'Rate Limit',
        enabled: 'Enabled',
        disabled: 'Disabled',
        requires_key: 'Requires API Key',
        geo_source: 'Data Source',
        // New translations for aggregated display
        providers_responded: 'providers responded',
        provider_details: 'Provider Details',
        show_details: 'Show Details',
        hide_details: 'Hide Details',
        no_provider_data: 'No provider data available',
        no_response: 'No response',
        risk_assessment: 'Risk Assessment',
        blacklist_check: 'Blacklist Check',
        providers_data: 'Providers Data',
        recommendation: 'Recommendation',
        risk_factors: 'Risk Factors',
        high_risk: 'High Risk',
        medium_risk: 'Medium Risk',
        low_risk: 'Low Risk',
        // Fortigate CLI translations
        fortigate_cli: 'Fortigate CLI',
        input_ips: 'Input IP Addresses',
        address_prefix: 'Address Name Prefix',
        subnet_mask: 'Subnet Mask',
        generate_cli: 'Generate CLI',
        clear: 'Clear',
        load_blacklist: 'Load Blacklist IPs',
        generated_commands: 'Generated Commands',
        ips_processed: 'IPs processed',
        copy_to_clipboard: 'Copy to Clipboard',
        download_file: 'Download File',
        validation_errors: 'Validation Errors',
        usage_tips: 'Usage Tips',
        tip_1: 'Invalid IP addresses will be automatically filtered out',
        tip_2: 'Generated commands can be pasted directly into Fortigate CLI',
        tip_3: 'Test commands in a lab environment before applying to production',
        tip_4: 'Click "Load Blacklist IPs" to automatically load system blacklist IPs',
        copied_success: 'Copied to clipboard!',
        no_valid_ips: 'No valid IP addresses found',
        invalid_ip_format: 'Invalid IP format',
        // Group management translations
        group_management: 'Group Management',
        enable_group_assignment: 'Add IPs to Group',
        group_number: 'Group Number',
        group_name_preview: 'Group Name Preview',
        group_tip: 'Uses append member command, will not overwrite existing members',
        // Risk methodology and version history
        risk_methodology: 'Risk Methodology',
        version_history: 'Version History',
        // Cache translations
        cache_info: 'Cache Info',
        from_cache: 'From Cache',
        fresh_query: 'Fresh Query',
        save_to_cache: 'Save to Cache',
        save_all_to_cache: 'Save All to Cache',
        cached_at: 'Cached At',
        expires_at: 'Expires At',
        remaining_time: 'Remaining Time',
        cache_hits: 'Cache Hits',
        not_cached: 'Not Cached',
        already_cached: 'Already Cached',
        cache_saved: 'Saved to Cache',
        cache_save_failed: 'Failed to Save to Cache',
        saving_to_cache: 'Saving to cache...',
        // Custom notes translations
        custom_notes: 'Custom Notes',
        add_note: 'Add Note',
        edit_note: 'Edit Note',
        save_note: 'Save Note',
        delete_note: 'Delete Note',
        cancel: 'Cancel',
        note_placeholder: 'Enter your notes about this blacklisted IP here...',
        no_notes_yet: 'No notes yet',
        note_created: 'Created',
        note_updated: 'Updated',
        saving_note: 'Saving...',
        deleting_note: 'Deleting...',
        note_saved: 'Note saved',
        note_deleted: 'Note deleted',
        note_save_failed: 'Failed to save note',
        note_delete_failed: 'Failed to delete note',
        confirm_delete_note: 'Are you sure you want to delete this note?',
        note_editor: 'Note Editor',
        expand_editor: 'Expand Editor',
        collapse_editor: 'Collapse Editor',
        clear_content: 'Clear Content',
        confirm_clear_content: 'Are you sure you want to clear all content?',
        drag_to_resize: 'Drag to resize',
        characters: 'characters',
        font_size: 'Font Size',
        font_color: 'Font Color',
        select_color: 'Select color',
        // External lookup translations
        external_lookups: 'External Lookups',
        check_on_whois365: 'Check on Whois365',
        check_on_trendmicro: 'Check on Trend Micro',
        check_on_virustotal: 'Check on VirusTotal',
        // Local database (archive) translations
        local_database: 'Local Database',
        archive_statistics: 'Archive Statistics',
        total_archived: 'Total Archived',
        blacklisted_archived: 'Blacklisted IPs',
        high_risk_archived: 'High Risk',
        countries_archived: 'Countries',
        search_filters: 'Search Filters',
        ip_address: 'IP Address',
        all_countries: 'All Countries',
        all_levels: 'All Levels',
        all_status: 'All Status',
        date_from: 'From Date',
        date_to: 'To Date',
        search: 'Search',
        clear_filters: 'Clear Filters',
        quick_lookup: 'Quick Lookup',
        lookup: 'Lookup',
        search_results: 'Search Results',
        records_found: 'records found',
        previous: 'Previous',
        next: 'Next',
        ip_details: 'IP Details',
        archived_data: 'Archived Data',
        no_archived_records: 'No matching records found in local database',
        no_results_hint: 'Try adjusting your search criteria or wait for more data to be archived',
        original_cached: 'Original Cached',
        original_expired: 'Original Expired',
        archived_at: 'Archived At',
        total_hits: 'Total Hits',
        searching: 'Searching...',
        // Local batch query translations
        local_batch_query: 'Local Batch Query',
        processing_local_batch: 'Processing local batch query...',
        archive_query: 'Archive Query',
        not_found: 'Not Found',
        not_in_archive: 'IP not found in archive database',
        found: 'Found',
        // Chart translations
        show_charts: 'Show Charts',
        hide_charts: 'Hide Charts',
        data_visualization: 'Data Visualization',
        country_distribution: 'Country Distribution',
        city_distribution: 'City Distribution',
        isp_distribution: 'ISP Distribution',
        risk_level_distribution: 'Risk Level Distribution',
        risk_score_distribution: 'Risk Score Distribution',
        threat_type_distribution: 'Threat Type Distribution',
        top_rankings: 'TOP Rankings',
        rank: 'Rank',
        count: 'Count',
        percentage: 'Percentage',
        no_data: 'No Data',
        loading_charts: 'Loading charts...',
        refresh_charts: 'Refresh Charts',
        high_risk: 'High Risk',
        medium_risk: 'Medium Risk',
        low_risk: 'Low Risk',
        unknown_risk: 'Unknown',
        // Chart export translations
        export_chart: 'Export Chart',
        export_as_image: 'Export as Image',
        download_chart: 'Download Chart',
        export_success: 'Chart exported successfully',
        export_failed: 'Chart export failed',
        // Geo map translations
        geo_map_title: 'Global Blacklist IP Distribution',
        geo_map_subtitle: 'Blacklist IP Count by Country',
        geo_map_no_data: 'No geographic distribution data',
        geo_map_loading: 'Loading map...',
        ip_count: 'IP Count',
        // Country IP ranges translations
        country_ip_ranges_title: 'Top Countries with Blacklisted IP Ranges',
        country_ip_ranges_subtitle: 'Shows blacklisted IP count and ranges by country',
        country_legend: 'Country IP Count',
        ip_ranges: 'IP Ranges',
        blacklisted_ips: 'Blacklisted IPs',
        // Regional distribution translations
        region_distribution_title: 'Regional Distribution',
        region_distribution_subtitle: 'Blacklist IP distribution by region',
        all_regions: 'All',
        region_eu: 'Europe',
        region_am: 'Americas',
        region_apac: 'Asia-Pacific',
        region_other: 'Other',
        region: 'Region',
        countries_count: 'Countries'
    }
};

function t(key) { return i18n[currentLang][key] || key; }

function setLang(lang) {
    currentLang = lang;
    document.getElementById('btn-en').classList.toggle('active', lang === 'en');
    document.getElementById('btn-zh').classList.toggle('active', lang === 'zh');
    document.querySelectorAll('[data-i18n]').forEach(el => {
        el.textContent = t(el.dataset.i18n);
    });
}

function switchTab(tab) {
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.panel').forEach(p => p.classList.add('hidden'));
    document.querySelector(`[onclick="switchTab('${tab}')"]`).classList.add('active');
    document.getElementById(`${tab}Panel`).classList.remove('hidden');
    if (tab === 'history') loadHistory();
    if (tab === 'geoapi') loadGeoAPIProviders();
    if (tab === 'localdb') {
        loadArchiveStats();
        loadArchiveCountries();
        // Ensure charts container is hidden by default when tab is first accessed
        initializeChartsContainerState();
    }
}

/**
 * Initialize charts container to hidden state
 * Called when Local Data Query tab is first accessed
 */
function initializeChartsContainerState() {
    const container = document.getElementById('archiveChartsContainer');
    const btn = document.getElementById('chartsToggleBtn');

    if (container && !container.dataset.initialized) {
        // Mark as initialized to avoid repeated initialization
        container.dataset.initialized = 'true';

        // Ensure hidden state
        container.classList.add('hidden');
        container.style.display = 'none';

        // Ensure button shows correct text
        if (btn) {
            btn.innerHTML = `📊 <span data-i18n="show_charts">${t('show_charts')}</span> / Show Charts ▼`;
        }

        console.log('initializeChartsContainerState: Charts container initialized to HIDDEN state');
    }
}

function showLoading(containerId) {
    document.getElementById(containerId).innerHTML = `<div class="loading">${t('loading')}</div>`;
}

function showError(containerId, message) {
    document.getElementById(containerId).innerHTML = `<div class="error">${message}</div>`;
}

async function loadStats() {
    try {
        const response = await fetch(`${API_URL}?action=stats`);
        const data = await response.json();
        document.getElementById('totalBlacklisted').textContent = data.totalBlacklisted || 0;
        // Display timestamp with timezone information on two lines
        const lastUpdatedEl = document.getElementById('lastUpdated');
        if (data.lastUpdated) {
            // Use innerHTML to render the <br> tag for line break
            lastUpdatedEl.innerHTML = `${data.lastUpdated}<br><span class="timezone-info"><font color="#000000">(Asia/Taipei GMT+8)</font></span>`;
        } else {
            lastUpdatedEl.textContent = '-';
        }
    } catch (e) { console.error('Failed to load stats:', e); }
}

function testIP(ip) {
    document.getElementById('ipInput').value = ip;
    querySingleIP();
}

async function querySingleIP() {
    const ip = document.getElementById('ipInput').value.trim();
    if (!ip) return;

    showLoading('singleResult');
    try {
        const response = await fetch(`${API_URL}?action=query&ip=${encodeURIComponent(ip)}`);
        const data = await response.json();
        if (data.error) {
            showError('singleResult', data.error);
            return;
        }
        document.getElementById('singleResult').innerHTML = data.type === 'cidr_query'
            ? renderCIDRResult(data) : renderSingleResult(data);
    } catch (e) { showError('singleResult', e.message); }
}

// Store last query result for manual caching
let lastQueryResult = null;

function renderSingleResult(data) {
    // Store for manual caching
    lastQueryResult = data;

    const geo = data.geo || {};
    const threat = data.threatInfo || {};
    const providerResults = data.providerResults || {};
    const riskAnalysis = data.riskAnalysis || {};
    const providerStats = data.providerStats || {};

    // Render cache status
    const cacheStatusHtml = renderCacheStatus(data);

    // Render provider results
    const providerResultsHtml = renderProviderResults(providerResults);

    // Render risk analysis
    const riskAnalysisHtml = renderRiskAnalysis(riskAnalysis, data.blacklisted);

    return `
        <div class="result-card ${data.status}">
            <div class="result-header">
                <span class="result-ip">${data.ip}</span>
                <span class="result-status ${data.status}">${data.status.toUpperCase()}</span>
                ${cacheStatusHtml}
            </div>
            <div class="result-message">${data.message}</div>

            <!-- Cache Info Section -->
            ${renderCacheInfoSection(data)}

            <!-- External Lookup Section -->
            ${renderExternalLookupSection(data.ip)}

            <!-- Risk Analysis Summary -->
            ${riskAnalysisHtml}

            <!-- Aggregated GeoIP Info -->
            <div class="result-details">
                <div class="detail-group aggregated-geo">
                    <h4>📍 ${t('geo_info')} <span class="provider-count">${providerStats.successful || 0}/${providerStats.total || 4} ${t('providers_responded')}</span></h4>
                    <p><strong>${t('country')}:</strong> ${geo.country || '-'} ${geo.countryCode ? '(' + geo.countryCode + ')' : ''}</p>
                    <p><strong>${t('region')}:</strong> ${geo.region || '-'}</p>
                    <p><strong>${t('city')}:</strong> ${geo.city || '-'}</p>
                    <p><strong>${t('isp')}:</strong> ${geo.isp || '-'}</p>
                    <p><strong>${t('org')}:</strong> ${geo.org || '-'}</p>
                </div>
                ${data.blacklisted ? `
                <div class="detail-group threat-group">
                    <h4>⚠️ ${t('threat_info')}</h4>
                    <p><strong>${t('threat_type')}:</strong> ${threat.threatType || '-'}</p>
                    <p><strong>${t('severity')}:</strong> <span style="color:${getSeverityColor(threat.severity)}">${threat.severity || '-'}</span></p>
                    <p><strong>${t('first_seen')}:</strong> ${threat.firstSeen || '-'}</p>
                    <p><strong>${t('last_seen')}:</strong> ${threat.lastSeen || '-'}</p>
                    <p><strong>${t('report_count')}:</strong> ${threat.reportCount || '-'}</p>
                </div>` : ''}
            </div>

            <!-- Custom Notes Section for Blacklisted IPs -->
            ${data.blacklisted ? renderCustomNotesSection(data) : ''}

            <!-- Individual Provider Results -->
            <div class="provider-results-section">
                <h4>📡 ${t('provider_details')} <span class="toggle-btn" onclick="toggleProviderDetails(this)">▼ ${t('show_details')}</span></h4>
                <div class="provider-results-container" style="display:none;">
                    ${providerResultsHtml}
                </div>
            </div>
        </div>`;
}

/**
 * Render individual provider results
 */
function renderProviderResults(providerResults) {
    if (!providerResults || Object.keys(providerResults).length === 0) {
        return `<div class="no-provider-data">${t('no_provider_data')}</div>`;
    }

    const providerOrder = ['ip-api', 'ipapi-co', 'ipinfo', 'ip-api-is'];
    const providerCards = [];

    for (const providerId of providerOrder) {
        const result = providerResults[providerId];
        if (result) {
            providerCards.push(`
                <div class="provider-card">
                    <div class="provider-card-header">
                        <span class="provider-name">${result._providerName || providerId}</span>
                        <span class="provider-status success">✓</span>
                    </div>
                    <div class="provider-card-body">
                        <p><strong>${t('country')}:</strong> ${result.country || '-'} ${result.countryCode ? '(' + result.countryCode + ')' : ''}</p>
                        <p><strong>${t('region')}:</strong> ${result.region || '-'}</p>
                        <p><strong>${t('city')}:</strong> ${result.city || '-'}</p>
                        <p><strong>${t('isp')}:</strong> ${result.isp || '-'}</p>
                    </div>
                </div>
            `);
        } else {
            // Provider didn't respond
            const providerNames = {'ip-api': 'IP-API.com', 'ipapi-co': 'ipapi.co', 'ipinfo': 'IPinfo.io', 'ip-api-is': 'IP-API.is'};
            providerCards.push(`
                <div class="provider-card no-response">
                    <div class="provider-card-header">
                        <span class="provider-name">${providerNames[providerId] || providerId}</span>
                        <span class="provider-status failed">✗</span>
                    </div>
                    <div class="provider-card-body">
                        <p class="no-data">${t('no_response')}</p>
                    </div>
                </div>
            `);
        }
    }

    return `<div class="provider-cards-grid">${providerCards.join('')}</div>`;
}

/**
 * Render cache status badge in header
 */
function renderCacheStatus(data) {
    if (data.fromCache) {
        return `<span class="cache-badge from-cache" title="${t('from_cache')}">💾 ${t('from_cache')}</span>`;
    } else if (data.cacheSaved) {
        return `<span class="cache-badge just-cached" title="${t('cache_saved')}">✓ ${t('cache_saved')}</span>`;
    } else {
        return `<span class="cache-badge fresh" title="${t('fresh_query')}">🔄 ${t('fresh_query')}</span>`;
    }
}

/**
 * Render cache info section with details and manual save button
 */
function renderCacheInfoSection(data) {
    const cacheInfo = data.cacheInfo || {};

    let cacheDetailsHtml = '';
    let actionButtonHtml = '';

    if (cacheInfo.isCached) {
        cacheDetailsHtml = `
            <div class="cache-details">
                <p><strong>${t('cached_at')}:</strong> ${cacheInfo.createdAt || '-'}</p>
                <p><strong>${t('expires_at')}:</strong> ${cacheInfo.expiresAt || '-'}</p>
                <p><strong>${t('remaining_time')}:</strong> ${cacheInfo.remainingHuman || '-'}</p>
                <p><strong>${t('cache_hits')}:</strong> ${cacheInfo.hitCount || 0}</p>
            </div>
        `;
        actionButtonHtml = `<span class="already-cached">✓ ${t('already_cached')}</span>`;
    } else {
        cacheDetailsHtml = `<p class="not-cached-msg">${t('not_cached')}</p>`;
        actionButtonHtml = `
            <button class="cache-save-btn" onclick="saveToCache()" id="singleCacheSaveBtn">
                💾 ${t('save_to_cache')}
            </button>
        `;
    }

    return `
        <div class="cache-info-section">
            <h4>💾 ${t('cache_info')}</h4>
            <div class="cache-info-content">
                ${cacheDetailsHtml}
                <div class="cache-action">
                    ${actionButtonHtml}
                    <span id="cacheSaveStatus" class="cache-save-status"></span>
                </div>
            </div>
        </div>
    `;
}

/**
 * Render external lookup buttons section
 * @param {string} ip - The IP address to look up
 * @returns {string} HTML for external lookup section
 */
function renderExternalLookupSection(ip) {
    // Extract base IP for CIDR ranges (e.g., "192.168.1.0/24" -> "192.168.1.0")
    const baseIp = ip.includes('/') ? ip.split('/')[0] : ip;

    const whois365Url = `https://whois365.com/tw/ip/${encodeURIComponent(baseIp)}`;
    const trendMicroUrl = `https://servicecentral.trendmicro.com/zh-tw/ers/ip-lookup/?ip=${encodeURIComponent(baseIp)}`;
    const virusTotalUrl = `https://www.virustotal.com/gui/ip-address/${encodeURIComponent(baseIp)}`;

    return `
        <div class="external-lookup-section">
            <h4>🔍 ${t('external_lookups')}</h4>
            <div class="external-lookup-buttons">
                <a href="${whois365Url}" target="_blank" rel="noopener noreferrer" class="external-lookup-btn whois365-btn">
                    🌐 ${t('check_on_whois365')}
                </a>
                <a href="${trendMicroUrl}" target="_blank" rel="noopener noreferrer" class="external-lookup-btn trendmicro-btn">
                    🛡️ ${t('check_on_trendmicro')}
                </a>
                <a href="${virusTotalUrl}" target="_blank" rel="noopener noreferrer" class="external-lookup-btn virustotal-btn">
                    🦠 ${t('check_on_virustotal')}
                </a>
            </div>
        </div>
    `;
}

/**
 * Save current query result to cache manually
 */
async function saveToCache() {
    if (!lastQueryResult || !lastQueryResult.ip) {
        return;
    }

    const btn = document.getElementById('singleCacheSaveBtn');
    const statusSpan = document.getElementById('cacheSaveStatus');

    if (btn) {
        btn.disabled = true;
        btn.textContent = t('saving_to_cache');
    }

    try {
        const response = await fetch(`${API_URL}?action=cache_save`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(lastQueryResult)
        });
        const result = await response.json();

        if (result.success) {
            if (btn) {
                btn.textContent = `✓ ${t('cache_saved')}`;
                btn.classList.add('saved');
            }
            if (statusSpan) {
                statusSpan.textContent = result.message;
                statusSpan.className = 'cache-save-status success';
            }
            // Update cache info display
            if (result.cacheInfo) {
                lastQueryResult.cacheInfo = result.cacheInfo;
            }
        } else {
            if (btn) {
                btn.disabled = false;
                btn.textContent = `💾 ${t('save_to_cache')}`;
            }
            if (statusSpan) {
                statusSpan.textContent = result.error || t('cache_save_failed');
                statusSpan.className = 'cache-save-status error';
            }
        }
    } catch (e) {
        if (btn) {
            btn.disabled = false;
            btn.textContent = `💾 ${t('save_to_cache')}`;
        }
        if (statusSpan) {
            statusSpan.textContent = e.message;
            statusSpan.className = 'cache-save-status error';
        }
    }
}

// ============================================================================
// CUSTOM NOTES FUNCTIONS / 自訂備註功能
// ============================================================================

/**
 * Render custom notes section for blacklisted IPs
 */
function renderCustomNotesSection(data) {
    const ip = data.ip;
    const note = data.customNote || '';
    const noteCreatedAt = data.noteCreatedAt || '';
    const noteUpdatedAt = data.noteUpdatedAt || '';

    const hasNote = note && note.trim().length > 0;

    return `
        <div class="custom-notes-section detail-group">
            <h4>📝 ${t('custom_notes')}
                <span class="note-toggle-btn" onclick="toggleNoteEditor('${ip}')">
                    ${hasNote ? `✏️ ${t('edit_note')}` : `➕ ${t('add_note')}`}
                </span>
            </h4>

            <!-- Display existing note -->
            <div id="noteDisplay-${ip}" class="note-display ${hasNote ? '' : 'hidden'}">
                ${hasNote ? `
                    <div class="note-content">${note}</div>
                    <div class="note-metadata">
                        <span>${t('note_created')}: ${formatDateTime(noteCreatedAt)}</span>
                        ${noteUpdatedAt && noteUpdatedAt !== noteCreatedAt ?
                            `<span> | ${t('note_updated')}: ${formatDateTime(noteUpdatedAt)}</span>` : ''}
                    </div>
                ` : `<p class="no-note-message">${t('no_notes_yet')}</p>`}
            </div>

            <!-- Enhanced Note Editor (hidden by default) -->
            <div id="noteEditor-${ip}" class="note-editor-container hidden">
                <!-- Editor Toolbar -->
                <div class="note-editor-toolbar">
                    <div class="toolbar-left">
                        <span class="toolbar-title">📝 ${t('note_editor')}</span>
                    </div>
                    <div class="toolbar-center">
                        <!-- Font Size Control -->
                        <div class="toolbar-control">
                            <label>${t('font_size')}:</label>
                            <select id="fontSize-${ip}" onchange="changeEditorFontSize('${ip}')" class="toolbar-select">
                                <option value="12">12px</option>
                                <option value="14">14px</option>
                                <option value="16" selected>16px</option>
                                <option value="18">18px</option>
                                <option value="20">20px</option>
                                <option value="24">24px</option>
                                <option value="28">28px</option>
                                <option value="32">32px</option>
                            </select>
                        </div>
                        <!-- Font Color Control -->
                        <div class="toolbar-control">
                            <label>${t('font_color')}:</label>
                            <input type="color" id="fontColor-${ip}" value="#333333" onchange="changeEditorFontColor('${ip}')" class="toolbar-color-picker" title="${t('select_color')}">
                        </div>
                    </div>
                    <div class="toolbar-right">
                        <button type="button" class="toolbar-btn" onclick="expandNoteEditor('${ip}')" title="${t('expand_editor')}">
                            <span id="expandIcon-${ip}">⛶</span>
                        </button>
                        <button type="button" class="toolbar-btn" onclick="clearNoteEditor('${ip}')" title="${t('clear_content')}">
                            🗑️
                        </button>
                    </div>
                </div>

                <!-- Resizable Editor Area -->
                <div id="editorWrapper-${ip}" class="note-editor-wrapper">
                    <textarea
                        id="noteText-${ip}"
                        class="note-editor-textarea"
                        placeholder="${t('note_placeholder')}"
                        maxlength="2000"
                        style="width: 550px; height: 100px; min-width: 550px; min-height: 100px;"
                    >${note}</textarea>
                    <div class="resize-handle" title="${t('drag_to_resize')}">
                        <span>⋮⋮</span>
                    </div>
                </div>

                <!-- Editor Footer -->
                <div class="note-editor-footer">
                    <div class="char-counter">
                        <span id="charCount-${ip}">${note.length}</span>/2000 ${t('characters')}
                    </div>
                    <div class="editor-dimensions" id="editorDimensions-${ip}">
                        500 × 300 px
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="note-actions">
                    <button class="btn btn-primary btn-sm" onclick="saveNote('${ip}')">
                        💾 ${t('save_note')}
                    </button>
                    <button class="btn btn-secondary btn-sm" onclick="cancelNoteEdit('${ip}')">
                        ✖ ${t('cancel')}
                    </button>
                    ${hasNote ? `
                    <button class="btn btn-danger btn-sm" onclick="deleteNote('${ip}')">
                        🗑️ ${t('delete_note')}
                    </button>` : ''}
                </div>

                <!-- Status Message -->
                <div id="noteStatus-${ip}" class="note-status"></div>
            </div>
        </div>
    `;
}

/**
 * Toggle note editor visibility
 */
function toggleNoteEditor(ip) {
    const display = document.getElementById(`noteDisplay-${ip}`);
    const editor = document.getElementById(`noteEditor-${ip}`);
    const textarea = document.getElementById(`noteText-${ip}`);

    if (display && editor) {
        display.classList.toggle('hidden');
        editor.classList.toggle('hidden');

        // Initialize editor when showing
        if (!editor.classList.contains('hidden') && textarea) {
            textarea.focus();
            updateNoteCharCount(ip);
            // Add input listener for character count
            textarea.oninput = () => updateNoteCharCount(ip);
            // Initialize resize observer
            initEditorResizeObserver(ip);
            // Update initial dimensions display
            updateEditorDimensions(ip);
        }
    }
}

/**
 * Initialize resize observer for editor
 */
function initEditorResizeObserver(ip) {
    const textarea = document.getElementById(`noteText-${ip}`);
    if (!textarea || textarea._resizeObserverInitialized) return;

    // Use ResizeObserver if available
    if (typeof ResizeObserver !== 'undefined') {
        const observer = new ResizeObserver(() => {
            updateEditorDimensions(ip);
        });
        observer.observe(textarea);
        textarea._resizeObserverInitialized = true;
    }
}

/**
 * Update editor dimensions display
 */
function updateEditorDimensions(ip) {
    const textarea = document.getElementById(`noteText-${ip}`);
    const dimensionsSpan = document.getElementById(`editorDimensions-${ip}`);
    if (textarea && dimensionsSpan) {
        const width = textarea.offsetWidth;
        const height = textarea.offsetHeight;
        dimensionsSpan.textContent = `${width} × ${height} px`;
    }
}

/**
 * Expand/collapse note editor to fullscreen
 */
function expandNoteEditor(ip) {
    const wrapper = document.getElementById(`editorWrapper-${ip}`);
    const textarea = document.getElementById(`noteText-${ip}`);
    const icon = document.getElementById(`expandIcon-${ip}`);

    if (wrapper && textarea) {
        const isExpanded = wrapper.classList.toggle('expanded');
        if (icon) {
            icon.textContent = isExpanded ? '⛶' : '⛶';
            icon.title = isExpanded ? t('collapse_editor') : t('expand_editor');
        }
        // Update dimensions display
        setTimeout(() => updateEditorDimensions(ip), 100);
    }
}

/**
 * Clear note editor content
 */
function clearNoteEditor(ip) {
    const textarea = document.getElementById(`noteText-${ip}`);
    if (textarea && confirm(t('confirm_clear_content'))) {
        textarea.value = '';
        updateNoteCharCount(ip);
        textarea.focus();
    }
}

/**
 * Change editor font size
 */
function changeEditorFontSize(ip) {
    const textarea = document.getElementById(`noteText-${ip}`);
    const fontSizeSelect = document.getElementById(`fontSize-${ip}`);
    if (textarea && fontSizeSelect) {
        textarea.style.fontSize = fontSizeSelect.value + 'px';
    }
}

/**
 * Change editor font color
 */
function changeEditorFontColor(ip) {
    const textarea = document.getElementById(`noteText-${ip}`);
    const fontColorInput = document.getElementById(`fontColor-${ip}`);
    if (textarea && fontColorInput) {
        textarea.style.color = fontColorInput.value;
    }
}

/**
 * Update character count for note textarea
 */
function updateNoteCharCount(ip) {
    const textarea = document.getElementById(`noteText-${ip}`);
    const countSpan = document.getElementById(`charCount-${ip}`);
    if (textarea && countSpan) {
        const count = textarea.value.length;
        countSpan.textContent = count;
        // Add warning color when approaching limit
        if (count > 1800) {
            countSpan.classList.add('char-warning');
        } else {
            countSpan.classList.remove('char-warning');
        }
    }
}

/**
 * Cancel note editing
 */
function cancelNoteEdit(ip) {
    const display = document.getElementById(`noteDisplay-${ip}`);
    const editor = document.getElementById(`noteEditor-${ip}`);
    const textarea = document.getElementById(`noteText-${ip}`);
    const wrapper = document.getElementById(`editorWrapper-${ip}`);

    // Reset textarea to original value
    if (textarea && lastQueryResult && lastQueryResult.customNote !== undefined) {
        textarea.value = lastQueryResult.customNote || '';
    }

    // Reset expanded state
    if (wrapper) {
        wrapper.classList.remove('expanded');
    }

    if (display && editor) {
        display.classList.remove('hidden');
        editor.classList.add('hidden');
    }
}

/**
 * Save custom note for an IP
 */
async function saveNote(ip) {
    const textarea = document.getElementById(`noteText-${ip}`);
    const statusDiv = document.getElementById(`noteStatus-${ip}`);

    if (!textarea) return;

    const note = textarea.value.trim();

    try {
        statusDiv.textContent = t('saving_note');
        statusDiv.className = 'note-status saving';

        const response = await fetch(`${API_URL}?action=save_note`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ ip, note })
        });
        const result = await response.json();

        if (result.success) {
            statusDiv.textContent = result.message || t('note_saved');
            statusDiv.className = 'note-status success';

            // Update lastQueryResult
            if (lastQueryResult && lastQueryResult.ip === ip) {
                lastQueryResult.customNote = note;
                lastQueryResult.noteCreatedAt = result.noteCreatedAt;
                lastQueryResult.noteUpdatedAt = result.noteUpdatedAt;
            }

            // Refresh display after short delay
            setTimeout(() => {
                toggleNoteEditor(ip);
                // Refresh the note display content
                const display = document.getElementById(`noteDisplay-${ip}`);
                if (display) {
                    if (note) {
                        display.innerHTML = `
                            <div class="note-content">${note}</div>
                            <div class="note-metadata">
                                <span>${t('note_created')}: ${formatDateTime(result.noteCreatedAt)}</span>
                                ${result.noteUpdatedAt ? `<span> | ${t('note_updated')}: ${formatDateTime(result.noteUpdatedAt)}</span>` : ''}
                            </div>
                        `;
                        display.classList.remove('hidden');
                    } else {
                        display.innerHTML = `<p class="no-note-message">${t('no_notes_yet')}</p>`;
                    }
                }
            }, 1000);
        } else {
            statusDiv.textContent = result.error || t('note_save_failed');
            statusDiv.className = 'note-status error';
        }
    } catch (e) {
        statusDiv.textContent = e.message;
        statusDiv.className = 'note-status error';
    }
}

/**
 * Delete custom note for an IP
 */
async function deleteNote(ip) {
    if (!confirm(t('confirm_delete_note'))) {
        return;
    }

    const statusDiv = document.getElementById(`noteStatus-${ip}`);

    try {
        statusDiv.textContent = t('deleting_note');
        statusDiv.className = 'note-status saving';

        const response = await fetch(`${API_URL}?action=delete_note&ip=${encodeURIComponent(ip)}`);
        const result = await response.json();

        if (result.success) {
            statusDiv.textContent = result.message || t('note_deleted');
            statusDiv.className = 'note-status success';

            // Update lastQueryResult
            if (lastQueryResult && lastQueryResult.ip === ip) {
                lastQueryResult.customNote = null;
                lastQueryResult.noteCreatedAt = null;
                lastQueryResult.noteUpdatedAt = null;
            }

            // Clear and refresh display
            const textarea = document.getElementById(`noteText-${ip}`);
            if (textarea) textarea.value = '';

            setTimeout(() => {
                toggleNoteEditor(ip);
                const display = document.getElementById(`noteDisplay-${ip}`);
                if (display) {
                    display.innerHTML = `<p class="no-note-message">${t('no_notes_yet')}</p>`;
                }
            }, 1000);
        } else {
            statusDiv.textContent = result.error || t('note_delete_failed');
            statusDiv.className = 'note-status error';
        }
    } catch (e) {
        statusDiv.textContent = e.message;
        statusDiv.className = 'note-status error';
    }
}

/**
 * Format datetime string for display
 */
function formatDateTime(dateStr) {
    if (!dateStr) return '-';
    try {
        const date = new Date(dateStr);
        return date.toLocaleString(currentLang === 'zh' ? 'zh-TW' : 'en-US');
    } catch {
        return dateStr;
    }
}

/**
 * Render risk analysis section
 */
function renderRiskAnalysis(riskAnalysis, isBlacklisted) {
    if (!riskAnalysis || !riskAnalysis.riskLevel) {
        return '';
    }

    const riskColors = { high: '#dc3545', medium: '#ffc107', low: '#28a745' };
    const riskColor = riskColors[riskAnalysis.riskLevel] || '#666';

    const factorsHtml = (riskAnalysis.riskFactors || []).map(f => `<li>${f}</li>`).join('');

    return `
        <div class="risk-analysis-panel ${riskAnalysis.riskLevel}">
            <div class="risk-header">
                <div class="risk-score-display">
                    <span class="risk-label">${t('risk_assessment')}</span>
                    <span class="risk-level" style="color: ${riskColor}">${riskAnalysis.riskLevelText}</span>
                </div>
                <div class="risk-stats">
                    <div class="risk-stat">
                        <span class="stat-label">${t('blacklist_check')}</span>
                        <span class="stat-value ${isBlacklisted ? 'blocked' : 'safe'}">${riskAnalysis.blacklistStatus}</span>
                    </div>
                    <div class="risk-stat">
                        <span class="stat-label">${t('providers_data')}</span>
                        <span class="stat-value">${riskAnalysis.dataRatio}</span>
                    </div>
                </div>
            </div>
            <div class="risk-recommendation">
                <strong>💡 ${t('recommendation')}:</strong> ${riskAnalysis.recommendation}
            </div>
            ${factorsHtml ? `
            <div class="risk-factors">
                <strong>${t('risk_factors')}:</strong>
                <ul>${factorsHtml}</ul>
            </div>` : ''}
        </div>
    `;
}

/**
 * Toggle provider details visibility
 */
function toggleProviderDetails(btn) {
    const container = btn.parentElement.nextElementSibling;
    const isHidden = container.style.display === 'none';
    container.style.display = isHidden ? 'block' : 'none';
    btn.textContent = isHidden ? `▲ ${t('hide_details')}` : `▼ ${t('show_details')}`;
}

function getSeverityColor(severity) {
    const colors = { Low: '#28a745', Medium: '#ffc107', High: '#fd7e14', Critical: '#dc3545' };
    return colors[severity] || '#666';
}

function renderCIDRResult(data) {
    const ipsHtml = data.blacklistedIPs.length > 0
        ? data.blacklistedIPs.map(ip => `<div>${ip}</div>`).join('')
        : `<div>${t('no_results')}</div>`;
    return `
        <div class="result-card ${data.blacklistedCount > 0 ? 'blocked' : 'safe'}">
            <div class="result-header">
                <span class="result-ip">${data.cidr}</span>
                <span class="result-status ${data.blacklistedCount > 0 ? 'blocked' : 'safe'}">
                    ${data.blacklistedCount > 0 ? 'FOUND' : 'CLEAN'}
                </span>
            </div>
            <div class="result-message">${data.message}</div>
            <div class="result-details">
                <div class="detail-group">
                    <h4>📊 ${t('cidr_range')}</h4>
                    <p><strong>Total IPs:</strong> ${data.totalIPs.toLocaleString()}</p>
                    <p><strong>Blacklisted:</strong> ${data.blacklistedCount}</p>
                </div>
                ${data.blacklistedCount > 0 ? `
                <div class="detail-group">
                    <h4>🚫 ${t('blacklisted_ips')}</h4>
                    <div class="cidr-ips">${ipsHtml}</div>
                </div>` : ''}
            </div>
        </div>`;
}

async function queryBatchIP() {
    const text = document.getElementById('batchInput').value.trim();
    if (!text) return;

    const ips = text.split('\n').map(ip => ip.trim()).filter(ip => ip);

    // Show progress indicator
    document.getElementById('batchResult').innerHTML = `
        <div class="batch-progress">
            <div class="progress-spinner"></div>
            <div class="progress-text">
                <span data-i18n="processing_batch">Processing batch query...</span>
                <br><small>${ips.length} IPs (max 50 with GeoIP analysis)</small>
            </div>
        </div>`;

    try {
        const response = await fetch(`${API_URL}?action=batch`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `ips=${encodeURIComponent(JSON.stringify(ips))}`
        });
        const data = await response.json();
        if (data.error) {
            showError('batchResult', data.error);
            return;
        }
        document.getElementById('batchResult').innerHTML = renderBatchResult(data);
    } catch (e) { showError('batchResult', e.message); }
}

// Store batch results globally for sorting/filtering
let batchResultsData = null;

function renderBatchResult(data) {
    batchResultsData = data;
    return renderBatchResultWithFilter(data, 'all', 'ip', 'asc');
}

function renderBatchResultWithFilter(data, filter, sortBy, sortDir) {
    const getRiskBadge = (level) => {
        const labels = { high: '🔴 High', medium: '🟡 Medium', low: '🟢 Low' };
        return `<span class="risk-badge ${level}">${labels[level] || level}</span>`;
    };

    // Filter results
    let filtered = data.results.filter(r => {
        if (filter === 'all') return true;
        if (filter === 'blocked') return r.blacklisted;
        if (filter === 'safe') return !r.blacklisted && !r.error;
        if (filter === 'high') return r.riskLevel === 'high';
        if (filter === 'medium') return r.riskLevel === 'medium';
        if (filter === 'low') return r.riskLevel === 'low';
        return true;
    });

    // Sort results
    filtered.sort((a, b) => {
        let valA, valB;
        switch (sortBy) {
            case 'ip':
                valA = a.ip.split('.').map(n => n.padStart(3, '0')).join('');
                valB = b.ip.split('.').map(n => n.padStart(3, '0')).join('');
                break;
            case 'status':
                valA = a.blacklisted ? 1 : 0;
                valB = b.blacklisted ? 1 : 0;
                break;
            case 'country':
                valA = a.countryName || a.country || '';
                valB = b.countryName || b.country || '';
                break;
            case 'city':
                valA = a.city || '';
                valB = b.city || '';
                break;
            case 'score':
                valA = a.riskScore || 0;
                valB = b.riskScore || 0;
                break;
            case 'risk':
                const riskOrder = { high: 3, medium: 2, low: 1 };
                valA = riskOrder[a.riskLevel] || 0;
                valB = riskOrder[b.riskLevel] || 0;
                break;
            default:
                valA = a.ip;
                valB = b.ip;
        }
        if (valA < valB) return sortDir === 'asc' ? -1 : 1;
        if (valA > valB) return sortDir === 'asc' ? 1 : -1;
        return 0;
    });

    const tableRows = filtered.map(r => {
        if (r.error) {
            return `<tr class="error-row" data-status="error" data-risk="">
                <td class="ip-cell">${r.ip}</td>
                <td colspan="7" class="error-cell">${r.error}</td>
            </tr>`;
        }
        const threatType = r.threatInfo?.threatType || '-';
        const cityName = r.city || '-';
        return `<tr class="${r.status}-row" data-status="${r.status}" data-risk="${r.riskLevel}">
            <td class="ip-cell">${r.ip}</td>
            <td><span class="status-badge ${r.status}">${r.blacklisted ? '🚫 BLOCKED' : '✅ SAFE'}</span></td>
            <td>${r.countryName || r.country || '-'}</td>
            <td class="city-cell">${cityName}</td>
            <td class="isp-cell" title="${r.isp}">${(r.isp || '-').substring(0, 25)}${(r.isp || '').length > 25 ? '...' : ''}</td>
            <td class="score-cell">${r.riskScore}</td>
            <td>${getRiskBadge(r.riskLevel)}</td>
            <td class="threat-cell">${threatType}</td>
        </tr>`;
    }).join('');

    const getSortIcon = (col) => {
        if (sortBy !== col) return '↕';
        return sortDir === 'asc' ? '↑' : '↓';
    };

    return `
        <div class="batch-summary-enhanced">
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <tr>
                    <td class="batch-stat-card total" onclick="filterBatchResults('all')" style="width: 16.6%; text-align: center; padding: 10px; cursor: pointer;">
                        <div class="stat-icon">📊</div>
                        <div class="stat-content">
                            <div class="stat-number">${data.total}</div>
                            <div class="stat-label">${t('total')}</div>
                        </div>
                    </td>
                    <td class="batch-stat-card blocked" onclick="filterBatchResults('blocked')" style="width: 16.6%; text-align: center; padding: 10px; cursor: pointer;">
                        <div class="stat-icon">🚫</div>
                        <div class="stat-content">
                            <div class="stat-number">${data.blacklisted}</div>
                            <div class="stat-label">${t('blocked')}</div>
                        </div>
                    </td>
                    <td class="batch-stat-card safe" onclick="filterBatchResults('safe')" style="width: 16.6%; text-align: center; padding: 10px; cursor: pointer;">
                        <div class="stat-icon">✅</div>
                        <div class="stat-content">
                            <div class="stat-number">${data.safe}</div>
                            <div class="stat-label">${t('safe')}</div>
                        </div>
                    </td>
                    <td class="batch-stat-card high-risk" onclick="filterBatchResults('high')" style="width: 16.6%; text-align: center; padding: 10px; cursor: pointer;">
                        <div class="stat-icon">🔴</div>
                        <div class="stat-content">
                            <div class="stat-number">${data.highRisk || 0}</div>
                            <div class="stat-label">High Risk</div>
                        </div>
                    </td>
                    <td class="batch-stat-card medium-risk" onclick="filterBatchResults('medium')" style="width: 16.6%; text-align: center; padding: 10px; cursor: pointer;">
                        <div class="stat-icon">🟡</div>
                        <div class="stat-content">
                            <div class="stat-number">${data.mediumRisk || 0}</div>
                            <div class="stat-label">Medium</div>
                        </div>
                    </td>
                    <td class="batch-stat-card low-risk" onclick="filterBatchResults('low')" style="width: 16.6%; text-align: center; padding: 10px; cursor: pointer;">
                        <div class="stat-icon">🟢</div>
                        <div class="stat-content">
                            <div class="stat-number">${data.lowRisk || 0}</div>
                            <div class="stat-label">Low Risk</div>
                        </div>
                    </td>
                </tr>
            </table>
            </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="batch-filter-bar">
            <span class="filter-label">Filter:</span>
            <select id="batchFilter" onchange="applyBatchFilter()">
                <option value="all" ${filter === 'all' ? 'selected' : ''}>All Results</option>
                <option value="blocked" ${filter === 'blocked' ? 'selected' : ''}>Blocked Only</option>
                <option value="safe" ${filter === 'safe' ? 'selected' : ''}>Safe Only</option>
                <option value="high" ${filter === 'high' ? 'selected' : ''}>High Risk</option>
                <option value="medium" ${filter === 'medium' ? 'selected' : ''}>Medium Risk</option>
                <option value="low" ${filter === 'low' ? 'selected' : ''}>Low Risk</option>
            </select>
            <span class="filter-count">(${filtered.length} of ${data.total})</span>
            <div class="batch-cache-actions">
                ${renderBatchCacheInfo(data)}
                <button class="cache-save-btn batch-cache-btn" onclick="saveAllToCache()" id="batchCacheSaveBtn">
                    💾 ${t('save_all_to_cache')}
                </button>
                <span id="batchCacheSaveStatus" class="cache-save-status"></span>
            </div>
        </div>
        ${data.note ? `<div class="batch-note">⚠️ ${data.note}</div>` : ''}
        <div>
            <table id="batchTable" border="1" style="border-collapse: collapse; border: 1px solid #000; width: 100%;">
                <thead>
                    <tr>
                        <th class="sortable" onclick="sortBatchResults('ip')" style="border: 1px solid #000; width: 12%;">${t('ip')} ${getSortIcon('ip')}</th>
                        <th class="sortable" onclick="sortBatchResults('status')" style="border: 1px solid #000; width: 11%;">${t('status')} ${getSortIcon('status')}</th>
                        <th class="sortable" onclick="sortBatchResults('country')" style="border: 1px solid #000; width: 12%;">${t('country')} ${getSortIcon('country')}</th>
                        <th class="sortable" onclick="sortBatchResults('city')" style="border: 1px solid #000; width: 12%;">${t('city')} ${getSortIcon('city')}</th>
                        <th style="border: 1px solid #000; width: 15%;">ISP</th>
                        <th class="sortable" onclick="sortBatchResults('score')" style="border: 1px solid #000; width: 8%;">Score ${getSortIcon('score')}</th>
                        <th class="sortable" onclick="sortBatchResults('risk')" style="border: 1px solid #000; width: 10%;">Risk ${getSortIcon('risk')}</th>
                        <th style="border: 1px solid #000; width: 20%;">Threat Type</th>
                    </tr>
                </thead>
                <tbody>${tableRows}</tbody>
            </table>
        </div>
        <div class="batch-timestamp">
            <small>Query Time: ${data.timestamp}</small>
        </div>`;
}

// Current sort/filter state
let batchSortBy = 'ip';
let batchSortDir = 'asc';
let batchFilter = 'all';

function sortBatchResults(column) {
    if (batchSortBy === column) {
        batchSortDir = batchSortDir === 'asc' ? 'desc' : 'asc';
    } else {
        batchSortBy = column;
        batchSortDir = 'asc';
    }
    if (batchResultsData) {
        document.getElementById('batchResult').innerHTML =
            renderBatchResultWithFilter(batchResultsData, batchFilter, batchSortBy, batchSortDir);
    }
}

function filterBatchResults(filter) {
    batchFilter = filter;
    if (batchResultsData) {
        document.getElementById('batchResult').innerHTML =
            renderBatchResultWithFilter(batchResultsData, batchFilter, batchSortBy, batchSortDir);
    }
}

function applyBatchFilter() {
    const filter = document.getElementById('batchFilter').value;
    filterBatchResults(filter);
}

/**
 * Render batch cache info summary
 */
function renderBatchCacheInfo(data) {
    const cacheStats = data.cacheStats || {};
    const hits = cacheStats.hits || 0;
    const misses = cacheStats.misses || 0;
    const hitRate = cacheStats.hitRate || 0;

    if (hits === 0 && misses === 0) {
        return '';
    }

    return `
        <span class="batch-cache-stats">
            💾 ${t('cache_hits')}: ${hits}/${hits + misses} (${hitRate}%)
        </span>
    `;
}

/**
 * Save all batch results to cache
 */
async function saveAllToCache() {
    if (!batchResultsData || !batchResultsData.results) {
        return;
    }

    const btn = document.getElementById('batchCacheSaveBtn');
    const statusSpan = document.getElementById('batchCacheSaveStatus');

    if (btn) {
        btn.disabled = true;
        btn.textContent = t('saving_to_cache');
    }

    try {
        const response = await fetch(`${API_URL}?action=cache_save_batch`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(batchResultsData)
        });
        const result = await response.json();

        if (result.success) {
            const summary = result.summary || {};
            if (btn) {
                btn.textContent = `✓ ${summary.saved} ${t('cache_saved')}`;
                btn.classList.add('saved');
            }
            if (statusSpan) {
                statusSpan.textContent = result.message;
                statusSpan.className = 'cache-save-status success';
            }
        } else {
            if (btn) {
                btn.disabled = false;
                btn.textContent = `💾 ${t('save_all_to_cache')}`;
            }
            if (statusSpan) {
                statusSpan.textContent = result.error || t('cache_save_failed');
                statusSpan.className = 'cache-save-status error';
            }
        }
    } catch (e) {
        if (btn) {
            btn.disabled = false;
            btn.textContent = `💾 ${t('save_all_to_cache')}`;
        }
        if (statusSpan) {
            statusSpan.textContent = e.message;
            statusSpan.className = 'cache-save-status error';
        }
    }
}

async function loadHistory() {
    showLoading('historyResult');
    try {
        const response = await fetch(`${API_URL}?action=history`);
        const data = await response.json();
        if (!Array.isArray(data) || data.length === 0) {
            document.getElementById('historyResult').innerHTML = `<div class="loading">${t('no_results')}</div>`;
            return;
        }
        document.getElementById('historyResult').innerHTML = renderHistory(data);
    } catch (e) { showError('historyResult', e.message); }
}

function renderHistory(data) {
    const rows = data.slice(0, 50).map(r => `
        <tr class="${r.status || ''}">
            <td style="font-family: monospace;">${r.ip || r.cidr || '-'}</td>
            <td><span class="result-status ${r.status || ''}">${(r.status || 'N/A').toUpperCase()}</span></td>
            <td>${r.geo?.country || '-'}</td>
            <td>${r.timestamp || '-'}</td>
        </tr>
    `).join('');

    return `
        <table class="history-table">
            <thead>
                <tr>
                    <th>${t('ip')}</th>
                    <th>${t('status')}</th>
                    <th>${t('country')}</th>
                    <th>${t('timestamp')}</th>
                </tr>
            </thead>
            <tbody>${rows}</tbody>
        </table>`;
}

function exportHistory(format) {
    window.open(`${API_URL}?action=export&format=${format}`, '_blank');
}

/**
 * Load and display GeoIP API providers information
 */
async function loadGeoAPIProviders() {
    const container = document.getElementById('geoapiProviders');
    container.innerHTML = `<div class="loading">${t('loading')}</div>`;

    try {
        const response = await fetch(`${API_URL}?action=providers`);
        const providers = await response.json();

        if (!Array.isArray(providers) || providers.length === 0) {
            container.innerHTML = `<div class="error">No providers configured</div>`;
            return;
        }

        container.innerHTML = renderGeoAPIProviders(providers);
    } catch (e) {
        container.innerHTML = `<div class="error">Failed to load providers: ${e.message}</div>`;
    }
}

/**
 * Render GeoIP providers table
 */
function renderGeoAPIProviders(providers) {
    const rows = providers.map(p => `
        <tr class="${p.enabled ? 'enabled' : 'disabled'}">
            <td>
                <strong>${p.name}</strong>
                ${p.requiresApiKey ? '<span class="badge warning">🔑</span>' : ''}
            </td>
            <td class="priority-cell">#${p.priority}</td>
            <td>
                <span class="status-badge ${p.enabled ? 'active' : 'inactive'}">
                    ${p.enabled ? '✓ ' + t('enabled') : '✗ ' + t('disabled')}
                </span>
            </td>
            <td>${formatRateLimit(p.rateLimit)}</td>
            <td class="desc-cell">${p.description}</td>
            <td>
                <a href="${p.website}" target="_blank" class="provider-link">🔗</a>
            </td>
        </tr>
    `).join('');

    return `
        <table class="providers-table">
            <thead>
                <tr>
                    <th>${t('provider')}</th>
                    <th>${t('priority')}</th>
                    <th>${t('status')}</th>
                    <th>${t('rate_limit')}</th>
                    <th>Description</th>
                    <th>Link</th>
                </tr>
            </thead>
            <tbody>${rows}</tbody>
        </table>
        <p class="providers-note">
            <em>Providers are queried in priority order. Lower number = higher priority.</em>
        </p>`;
}

/**
 * Format rate limit for display
 */
function formatRateLimit(limit) {
    if (!limit || limit === 0) return 'Unlimited';
    if (limit >= 50000) return `${(limit/1000).toFixed(0)}K/month`;
    if (limit >= 1000) return `${(limit/1000).toFixed(0)}K/day`;
    return `${limit}/min`;
}

// ============================================
// Fortigate CLI Command Generator Functions
// ============================================

/**
 * Validate IPv4 address format
 */
function isValidIPv4(ip) {
    const ipv4Regex = /^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
    return ipv4Regex.test(ip.trim());
}

/**
 * Parse IP input and validate each IP
 */
function parseAndValidateIPs(input) {
    const lines = input.split('\n');
    const validIPs = [];
    const invalidIPs = [];

    lines.forEach((line, index) => {
        const ip = line.trim();
        if (ip === '') return; // Skip empty lines

        if (isValidIPv4(ip)) {
            // Avoid duplicates
            if (!validIPs.includes(ip)) {
                validIPs.push(ip);
            }
        } else {
            invalidIPs.push({ line: index + 1, ip: ip });
        }
    });

    return { validIPs, invalidIPs };
}

/**
 * Update group name preview based on group number
 */
function updateGroupPreview() {
    var groupNumberEl = document.getElementById('fortigateGroupNumber');
    var previewEl = document.getElementById('groupNamePreview');

    if (groupNumberEl && previewEl) {
        var num = groupNumberEl.value || '18';
        var paddedNum = String(num).padStart(2, '0');
        previewEl.textContent = 'Blacklist_Group_IPs_' + paddedNum;
    }
}

/**
 * Check if group assignment is enabled
 */
function isGroupAssignmentEnabled() {
    var checkbox = document.getElementById('enableGroupAssignment');
    if (checkbox) {
        return checkbox.checked === true;
    }
    return false;
}

/**
 * Get current group number
 */
function getGroupNumber() {
    var input = document.getElementById('fortigateGroupNumber');
    if (input && input.value) {
        return input.value;
    }
    return '18';
}

/**
 * Generate Fortigate CLI commands
 */
function generateFortigateCLI() {
    var input = document.getElementById('fortigateIpInput').value;
    var prefix = document.getElementById('fortigatePrefix').value || 'Blacklist_IP_';
    var subnetMask = document.getElementById('fortigateSubnetMask').value || '255.255.255.255';

    // Get group management settings using helper functions
    var enableGroup = isGroupAssignmentEnabled();
    var groupNumber = getGroupNumber();

    // Debug logging
    console.log('=== Fortigate CLI Generator Debug ===');
    console.log('enableGroup:', enableGroup);
    console.log('groupNumber:', groupNumber);

    var result = parseAndValidateIPs(input);
    var validIPs = result.validIPs;
    var invalidIPs = result.invalidIPs;

    // Show validation errors if any
    var validationDiv = document.getElementById('fortigateValidation');
    var errorsUl = document.getElementById('fortigateErrors');

    if (invalidIPs.length > 0) {
        errorsUl.innerHTML = invalidIPs.map(function(err) {
            return '<li>' + t('invalid_ip_format') + ': Line ' + err.line + ' - "' + err.ip + '"</li>';
        }).join('');
        validationDiv.style.display = 'block';
    } else {
        validationDiv.style.display = 'none';
    }

    // Show output section
    var outputSection = document.getElementById('fortigateOutputSection');
    var outputTextarea = document.getElementById('fortigateOutput');
    var ipCountSpan = document.getElementById('fortigateIpCount');

    if (validIPs.length === 0) {
        outputSection.style.display = 'block';
        outputTextarea.value = '# ' + t('no_valid_ips');
        ipCountSpan.textContent = '0';
        return;
    }

    // Determine CIDR suffix based on subnet mask
    var cidrSuffix = '/32';
    if (subnetMask === '255.255.255.0') {
        cidrSuffix = '/24';
    } else if (subnetMask === '255.255.0.0') {
        cidrSuffix = '/16';
    }

    // Build commands string
    var commands = '';
    var addressNames = [];

    // ========================================
    // Phase 1: Individual address objects
    // ========================================
    commands += '# ========================================\n';
    commands += '# Phase 1: Create individual firewall address objects\n';
    commands += '# ========================================\n';
    commands += 'config firewall address\n';

    for (var i = 0; i < validIPs.length; i++) {
        var ip = validIPs[i];
        var addressName = prefix + ip + cidrSuffix;
        addressNames.push(addressName);
        commands += '    edit "' + addressName + '"\n';
        commands += '        set subnet ' + ip + ' ' + subnetMask + '\n';
        commands += '    next\n';
    }

    commands += 'end\n';

    // ========================================
    // Phase 2: Group assignment (if enabled)
    // ========================================
    console.log('Phase 2 - enableGroup value:', enableGroup, 'type:', typeof enableGroup);
    console.log('Phase 2 - addressNames count:', addressNames.length);

    if (enableGroup && addressNames.length > 0) {
        console.log('>>> Generating Phase 2 commands...');

        var paddedGroupNumber = String(groupNumber).padStart(2, '0');
        var groupName = 'Blacklist_Group_IPs_' + paddedGroupNumber;
        var MEMBERS_PER_COMMAND = 30;

        commands += '\n';
        commands += '# ========================================\n';
        commands += '# Phase 2: Add addresses to firewall address group\n';
        commands += '# Group: ' + groupName + '\n';
        commands += '# ========================================\n';
        commands += 'config firewall addrgrp\n';
        commands += '    edit "' + groupName + '"\n';

        // Split address names into chunks
        for (var j = 0; j < addressNames.length; j += MEMBERS_PER_COMMAND) {
            var chunk = addressNames.slice(j, j + MEMBERS_PER_COMMAND);
            var memberList = chunk.map(function(name) {
                return '"' + name + '"';
            }).join(' ');
            commands += '        append member ' + memberList + '\n';
        }

        commands += '    next\n';
        commands += 'end\n';

        console.log('>>> Phase 2 commands generated successfully');
    } else {
        console.log('>>> Phase 2 SKIPPED. enableGroup=' + enableGroup + ', addressNames.length=' + addressNames.length);
    }

    // Display output
    outputSection.style.display = 'block';
    outputTextarea.value = commands;
    ipCountSpan.textContent = String(validIPs.length);

    // Clear copy status
    document.getElementById('fortigateCopyStatus').textContent = '';

    console.log('=== CLI Generation Complete ===');
}

/**
 * Clear Fortigate input and output
 */
function clearFortigateInput() {
    document.getElementById('fortigateIpInput').value = '';
    document.getElementById('fortigateOutput').value = '';
    document.getElementById('fortigateOutputSection').style.display = 'none';
    document.getElementById('fortigateValidation').style.display = 'none';
    document.getElementById('fortigateCopyStatus').textContent = '';
    document.getElementById('fortigateIpCount').textContent = '0';
}

/**
 * Load blacklisted IPs from the system
 */
async function loadBlacklistedIPs() {
    try {
        const response = await fetch('api.php?action=stats');
        const data = await response.json();

        if (data.sampleBlacklistedIPs && data.sampleBlacklistedIPs.length > 0) {
            // Load sample IPs (up to 100)
            const ips = data.sampleBlacklistedIPs.slice(0, 100);
            document.getElementById('fortigateIpInput').value = ips.join('\n');
        } else {
            // Fallback: query for some known blacklisted IPs
            alert(currentLang === 'zh'
                ? '無法載入黑名單 IP。請手動輸入 IP 地址。'
                : 'Unable to load blacklist IPs. Please enter IP addresses manually.');
        }
    } catch (error) {
        console.error('Error loading blacklist IPs:', error);
        alert(currentLang === 'zh'
            ? '載入黑名單 IP 時發生錯誤'
            : 'Error loading blacklist IPs');
    }
}

/**
 * Copy Fortigate CLI commands to clipboard
 */
async function copyFortigateCLI() {
    const output = document.getElementById('fortigateOutput').value;
    const statusDiv = document.getElementById('fortigateCopyStatus');

    try {
        await navigator.clipboard.writeText(output);
        statusDiv.textContent = t('copied_success');
        statusDiv.className = 'copy-status success';

        // Clear status after 3 seconds
        setTimeout(() => {
            statusDiv.textContent = '';
            statusDiv.className = 'copy-status';
        }, 3000);
    } catch (error) {
        // Fallback for older browsers
        const textarea = document.getElementById('fortigateOutput');
        textarea.select();
        document.execCommand('copy');
        statusDiv.textContent = t('copied_success');
        statusDiv.className = 'copy-status success';
    }
}

/**
 * Download Fortigate CLI commands as a file
 */
function downloadFortigateCLI() {
    const output = document.getElementById('fortigateOutput').value;
    if (!output) return;

    const blob = new Blob([output], { type: 'text/plain' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `fortigate_blacklist_${new Date().toISOString().slice(0,10)}.txt`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
}

// ============================================================================
// LOCAL DATABASE (ARCHIVE) BATCH QUERY FUNCTIONS
// 本地數據庫（歸檔）批量查詢功能
// ============================================================================

// Store local batch results globally for sorting/filtering
let localBatchResultsData = null;
let localBatchSortBy = 'ip';
let localBatchSortDir = 'asc';
let localBatchFilter = 'all';

/**
 * Load archive statistics
 */
async function loadArchiveStats() {
    try {
        const response = await fetch(`${API_URL}?action=archive_stats`);
        const data = await response.json();

        if (data.success && data.stats) {
            // Map backend camelCase field names to DOM elements
            // totalArchived -> Total archived records
            document.getElementById('archiveTotalRecords').textContent = data.stats.totalArchived || 0;
            // blacklistedCount -> Blacklisted IP count
            document.getElementById('archiveBlacklisted').textContent = data.stats.blacklistedCount || 0;
            // byRiskLevel.high -> High risk count (from nested object)
            const highRiskCount = data.stats.byRiskLevel?.high || 0;
            document.getElementById('archiveHighRisk').textContent = highRiskCount;
            // countryCount -> Unique countries count
            document.getElementById('archiveCountries').textContent = data.stats.countryCount || 0;
        } else {
            document.getElementById('archiveTotalRecords').textContent = '0';
            document.getElementById('archiveBlacklisted').textContent = '0';
            document.getElementById('archiveHighRisk').textContent = '0';
            document.getElementById('archiveCountries').textContent = '0';
        }
    } catch (error) {
        console.error('Failed to load archive stats:', error);
    }
}

/**
 * Query multiple IPs from local archive database (batch mode)
 * Similar to queryBatchIP() but queries from ip_database table
 */
async function queryLocalBatch() {
    const text = document.getElementById('localdbInput').value.trim();
    if (!text) return;

    const ips = text.split('\n').map(ip => ip.trim()).filter(ip => ip);

    // Show progress indicator
    document.getElementById('localdbResult').innerHTML = `
        <div class="batch-progress">
            <div class="progress-spinner"></div>
            <div class="progress-text">
                <span data-i18n="processing_local_batch">${t('processing_local_batch')}</span>
                <br><small>${ips.length} IPs (${t('archive_query')})</small>
            </div>
        </div>`;

    try {
        const response = await fetch(`${API_URL}?action=local_batch`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `ips=${encodeURIComponent(JSON.stringify(ips))}`
        });
        const data = await response.json();
        if (data.error) {
            showError('localdbResult', data.error);
            return;
        }
        document.getElementById('localdbResult').innerHTML = renderLocalBatchResult(data);
    } catch (e) {
        showError('localdbResult', e.message);
    }
}

/**
 * Render local batch query results
 */
function renderLocalBatchResult(data) {
    localBatchResultsData = data;
    localBatchSortBy = 'ip';
    localBatchSortDir = 'asc';
    localBatchFilter = 'all';
    return renderLocalBatchResultWithFilter(data, 'all', 'ip', 'asc');
}

/**
 * Render local batch results with filter and sorting
 */
function renderLocalBatchResultWithFilter(data, filter, sortBy, sortDir) {
    const getRiskBadge = (level) => {
        const labels = { high: '🔴 High', medium: '🟡 Medium', low: '🟢 Low', unknown: '⚪ N/A' };
        return `<span class="risk-badge ${level}">${labels[level] || labels.unknown}</span>`;
    };

    // Filter results
    let filtered = data.results.filter(r => {
        if (filter === 'all') return true;
        if (filter === 'blocked') return r.blacklisted;
        if (filter === 'safe') return !r.blacklisted && !r.error && !r.notFound;
        if (filter === 'not_found') return r.notFound;
        if (filter === 'high') return r.riskLevel === 'high';
        if (filter === 'medium') return r.riskLevel === 'medium';
        if (filter === 'low') return r.riskLevel === 'low';
        return true;
    });

    // Sort results
    filtered.sort((a, b) => {
        let valA, valB;
        switch (sortBy) {
            case 'ip':
                valA = a.ip.split('.').map(n => n.padStart(3, '0')).join('');
                valB = b.ip.split('.').map(n => n.padStart(3, '0')).join('');
                break;
            case 'status':
                valA = a.notFound ? 2 : (a.blacklisted ? 1 : 0);
                valB = b.notFound ? 2 : (b.blacklisted ? 1 : 0);
                break;
            case 'country':
                valA = a.countryName || a.country || '';
                valB = b.countryName || b.country || '';
                break;
            case 'city':
                valA = a.city || '';
                valB = b.city || '';
                break;
            case 'score':
                valA = a.riskScore || 0;
                valB = b.riskScore || 0;
                break;
            case 'risk':
                const riskOrder = { high: 3, medium: 2, low: 1, unknown: 0 };
                valA = riskOrder[a.riskLevel] || 0;
                valB = riskOrder[b.riskLevel] || 0;
                break;
            default:
                valA = a.ip;
                valB = b.ip;
        }
        if (valA < valB) return sortDir === 'asc' ? -1 : 1;
        if (valA > valB) return sortDir === 'asc' ? 1 : -1;
        return 0;
    });

    const tableRows = filtered.map(r => {
        if (r.error) {
            return `<tr class="error-row" data-status="error" data-risk="">
                <td class="ip-cell">${r.ip} <span class="archived-badge-mini">📁</span></td>
                <td colspan="7" class="error-cell">${r.error}</td>
            </tr>`;
        }
        if (r.notFound) {
            return `<tr class="not-found-row" data-status="not_found" data-risk="">
                <td class="ip-cell">${r.ip} <span class="archived-badge-mini">📁</span></td>
                <td><span class="status-badge not-found">❓ ${t('not_found')}</span></td>
                <td colspan="6" class="not-found-cell">${t('not_in_archive')}</td>
            </tr>`;
        }
        const threatType = r.threatInfo?.threatType || '-';
        const cityName = r.city || '-';
        return `<tr class="${r.status}-row" data-status="${r.status}" data-risk="${r.riskLevel}">
            <td class="ip-cell">${r.ip} <span class="archived-badge-mini" title="${t('archived_data')}">📁</span></td>
            <td><span class="status-badge ${r.status}">${r.blacklisted ? '🚫 BLOCKED' : '✅ SAFE'}</span></td>
            <td>${r.countryName || r.country || '-'}</td>
            <td class="city-cell">${cityName}</td>
            <td class="isp-cell" title="${r.isp}">${(r.isp || '-').substring(0, 25)}${(r.isp || '').length > 25 ? '...' : ''}</td>
            <td class="score-cell">${r.riskScore}</td>
            <td>${getRiskBadge(r.riskLevel)}</td>
            <td class="threat-cell">${threatType}</td>
        </tr>`;
    }).join('');

    const getSortIcon = (col) => {
        if (sortBy !== col) return '↕';
        return sortDir === 'asc' ? '↑' : '↓';
    };

    return `
        <div class="local-batch-header">
            <span class="archived-badge">📁 ${t('archived_data')}</span>
        </div>
        <div class="batch-summary-enhanced">
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <tr>
                    <td class="batch-stat-card total" onclick="filterLocalBatchResults('all')" style="width: 14.2%; text-align: center; padding: 10px; cursor: pointer;">
                        <div class="stat-icon">📊</div>
                        <div class="stat-content">
                            <div class="stat-number">${data.total}</div>
                            <div class="stat-label">${t('total')}</div>
                        </div>
                    </td>
                    <td class="batch-stat-card found" onclick="filterLocalBatchResults('all')" style="width: 14.2%; text-align: center; padding: 10px; cursor: pointer;">
                        <div class="stat-icon">✔️</div>
                        <div class="stat-content">
                            <div class="stat-number">${data.found}</div>
                            <div class="stat-label">${t('found')}</div>
                        </div>
                    </td>
                    <td class="batch-stat-card blocked" onclick="filterLocalBatchResults('blocked')" style="width: 14.2%; text-align: center; padding: 10px; cursor: pointer;">
                        <div class="stat-icon">🚫</div>
                        <div class="stat-content">
                            <div class="stat-number">${data.blacklisted}</div>
                            <div class="stat-label">${t('blocked')}</div>
                        </div>
                    </td>
                    <td class="batch-stat-card safe" onclick="filterLocalBatchResults('safe')" style="width: 14.2%; text-align: center; padding: 10px; cursor: pointer;">
                        <div class="stat-icon">✅</div>
                        <div class="stat-content">
                            <div class="stat-number">${data.safe}</div>
                            <div class="stat-label">${t('safe')}</div>
                        </div>
                    </td>
                    <td class="batch-stat-card high-risk" onclick="filterLocalBatchResults('high')" style="width: 14.2%; text-align: center; padding: 10px; cursor: pointer;">
                        <div class="stat-icon">🔴</div>
                        <div class="stat-content">
                            <div class="stat-number">${data.highRisk || 0}</div>
                            <div class="stat-label">High Risk</div>
                        </div>
                    </td>
                    <td class="batch-stat-card medium-risk" onclick="filterLocalBatchResults('medium')" style="width: 14.2%; text-align: center; padding: 10px; cursor: pointer;">
                        <div class="stat-icon">🟡</div>
                        <div class="stat-content">
                            <div class="stat-number">${data.mediumRisk || 0}</div>
                            <div class="stat-label">Medium</div>
                        </div>
                    </td>
                    <td class="batch-stat-card not-found-stat" onclick="filterLocalBatchResults('not_found')" style="width: 14.2%; text-align: center; padding: 10px; cursor: pointer;">
                        <div class="stat-icon">❓</div>
                        <div class="stat-content">
                            <div class="stat-number">${data.notFound || 0}</div>
                            <div class="stat-label">${t('not_found')}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="batch-filter-bar">
            <span class="filter-label">Filter:</span>
            <select id="localBatchFilter" onchange="applyLocalBatchFilter()">
                <option value="all" ${filter === 'all' ? 'selected' : ''}>All Results</option>
                <option value="blocked" ${filter === 'blocked' ? 'selected' : ''}>Blocked Only</option>
                <option value="safe" ${filter === 'safe' ? 'selected' : ''}>Safe Only</option>
                <option value="high" ${filter === 'high' ? 'selected' : ''}>High Risk</option>
                <option value="medium" ${filter === 'medium' ? 'selected' : ''}>Medium Risk</option>
                <option value="low" ${filter === 'low' ? 'selected' : ''}>Low Risk</option>
                <option value="not_found" ${filter === 'not_found' ? 'selected' : ''}>Not Found</option>
            </select>
            <span class="filter-count">(${filtered.length} of ${data.total})</span>
        </div>
        ${data.note ? `<div class="batch-note">⚠️ ${data.note}</div>` : ''}
        <div>
            <table id="localBatchTable" class="batch-results-table" border="1" style="border-collapse: collapse; border: 1px solid #000; width: 100%;">
                <thead>
                    <tr>
                        <th class="sortable" onclick="sortLocalBatchResults('ip')" style="border: 1px solid #000; width: 12%;">${t('ip')} ${getSortIcon('ip')}</th>
                        <th class="sortable" onclick="sortLocalBatchResults('status')" style="border: 1px solid #000; width: 11%;">${t('status')} ${getSortIcon('status')}</th>
                        <th class="sortable" onclick="sortLocalBatchResults('country')" style="border: 1px solid #000; width: 12%;">${t('country')} ${getSortIcon('country')}</th>
                        <th class="sortable" onclick="sortLocalBatchResults('city')" style="border: 1px solid #000; width: 12%;">${t('city')} ${getSortIcon('city')}</th>
                        <th style="border: 1px solid #000; width: 15%;">ISP</th>
                        <th class="sortable" onclick="sortLocalBatchResults('score')" style="border: 1px solid #000; width: 8%;">Score ${getSortIcon('score')}</th>
                        <th class="sortable" onclick="sortLocalBatchResults('risk')" style="border: 1px solid #000; width: 10%;">Risk ${getSortIcon('risk')}</th>
                        <th style="border: 1px solid #000; width: 20%;">Threat Type</th>
                    </tr>
                </thead>
                <tbody>${tableRows}</tbody>
            </table>
        </div>
        <div class="batch-timestamp">
            <small>${t('archive_query')} | Query Time: ${data.timestamp}</small>
        </div>`;
}

/**
 * Sort local batch results by column
 */
function sortLocalBatchResults(column) {
    if (localBatchSortBy === column) {
        localBatchSortDir = localBatchSortDir === 'asc' ? 'desc' : 'asc';
    } else {
        localBatchSortBy = column;
        localBatchSortDir = 'asc';
    }
    if (localBatchResultsData) {
        document.getElementById('localdbResult').innerHTML =
            renderLocalBatchResultWithFilter(localBatchResultsData, localBatchFilter, localBatchSortBy, localBatchSortDir);
    }
}

/**
 * Filter local batch results
 */
function filterLocalBatchResults(filter) {
    localBatchFilter = filter;
    if (localBatchResultsData) {
        document.getElementById('localdbResult').innerHTML =
            renderLocalBatchResultWithFilter(localBatchResultsData, localBatchFilter, localBatchSortBy, localBatchSortDir);
    }
}

/**
 * Apply filter from dropdown
 */
function applyLocalBatchFilter() {
    const filter = document.getElementById('localBatchFilter').value;
    filterLocalBatchResults(filter);
}

// ============================================
// Archive Charts - Interactive Visualizations
// ============================================

// Chart instances storage
let archiveCharts = {
    country: null,
    city: null,
    isp: null,
    riskLevel: null,
    riskScore: null,
    threatType: null,
    countryIPRanges: null,
    regionDistribution: null
};

// Current region filter for geo map
let currentRegionFilter = 'all';

// Chart data storage
let archiveChartsData = null;

// Chart sort states
let chartSortStates = {
    country: { by: 'count', dir: 'desc' },
    city: { by: 'count', dir: 'desc' },
    isp: { by: 'count', dir: 'desc' },
    threat: { by: 'count', dir: 'desc' }
};

// Chart color palettes
const chartColors = {
    primary: ['#4e79a7', '#f28e2c', '#e15759', '#76b7b2', '#59a14f', '#edc949', '#af7aa1', '#ff9da7', '#9c755f', '#bab0ab'],
    riskLevels: {
        high: '#dc3545',
        medium: '#fd7e14',
        low: '#28a745',
        unknown: '#6c757d'
    },
    scoreRanges: {
        '80-100': '#dc3545',
        '60-79': '#fd7e14',
        '40-59': '#ffc107',
        '20-39': '#20c997',
        '0-19': '#28a745'
    },
    regions: {
        EU: '#667eea',
        AM: '#f5576c',
        APAC: '#4facfe',
        OTHER: '#6c757d'
    }
};

// TOP ranking badges
const rankBadges = ['🥇', '🥈', '🥉', '🏅', '🏅'];

// Google Charts state / 谷歌圖表狀態
let googleChartsLoaded = false;
let geoMapChart = null;

/**
 * Initialize Google Charts / 初始化谷歌圖表
 */
function initGoogleCharts() {
    if (typeof google !== 'undefined' && google.charts) {
        google.charts.load('current', {
            packages: ['geochart'],
            mapsApiKey: '' // Optional: Add your Google Maps API key for better functionality
        });
        google.charts.setOnLoadCallback(function() {
            googleChartsLoaded = true;
            console.log('Google Charts loaded successfully');
            // Render geo map if data is available
            if (archiveChartsData && archiveChartsData.countryDistribution) {
                renderGeoMap();
            }
        });
    } else {
        console.warn('Google Charts library not loaded');
    }
}

/**
 * Toggle archive charts visibility
 */
function toggleArchiveCharts() {
    const container = document.getElementById('archiveChartsContainer');
    const btn = document.getElementById('chartsToggleBtn');

    if (!container) {
        console.error('toggleArchiveCharts: Container not found!');
        return;
    }
    if (!btn) {
        console.error('toggleArchiveCharts: Button not found!');
        return;
    }

    const isHidden = container.classList.contains('hidden');
    console.log('toggleArchiveCharts: Current state isHidden =', isHidden);

    if (isHidden) {
        // Show charts
        container.classList.remove('hidden');
        container.style.display = 'block';
        btn.innerHTML = `📊 <span data-i18n="hide_charts">${t('hide_charts')}</span> / Hide Charts ▲`;
        loadArchiveChartsData();
        console.log('toggleArchiveCharts: Charts now VISIBLE');
    } else {
        // Hide charts
        container.classList.add('hidden');
        container.style.display = 'none';
        btn.innerHTML = `📊 <span data-i18n="show_charts">${t('show_charts')}</span> / Show Charts ▼`;
        console.log('toggleArchiveCharts: Charts now HIDDEN');
    }
}

/**
 * Refresh archive charts
 */
function refreshArchiveCharts() {
    loadArchiveChartsData();
}

/**
 * Load archive charts data from API
 */
async function loadArchiveChartsData() {
    try {
        // Show loading state
        document.querySelectorAll('.chart-wrapper canvas').forEach(canvas => {
            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        });

        const response = await fetch(`${API_URL}?action=archive_stats_detailed`);
        const data = await response.json();

        if (data.success && data.stats) {
            archiveChartsData = data.stats;
            renderAllCharts();
        } else {
            console.error('Failed to load chart data:', data.error);
        }
    } catch (error) {
        console.error('Error loading archive charts data:', error);
    }
}

/**
 * Render all charts / 渲染所有圖表
 */
function renderAllCharts() {
    if (!archiveChartsData) return;

    renderCountryChart();
    renderCityChart();
    renderISPChart();
    renderRiskLevelChart();
    renderRiskScoreChart();
    renderThreatTypeChart();

    // Render regional distribution chart / 渲染區域分布圖表
    renderRegionalDistributionChart();

    // Render geo map (requires Google Charts) / 渲染地理圖（需要谷歌圖表）
    renderGeoMap();

    // Render country IP ranges chart / 渲染國家IP範圍圖表
    renderCountryIPRangesChart();
}


/**
 * Render country distribution chart
 */
function renderCountryChart() {
    const data = archiveChartsData.countryDistribution || [];
    if (data.length === 0) {
        document.getElementById('countryTop5').innerHTML = `<div class="no-data">${t('no_data')}</div>`;
        return;
    }

    // Sort data - ensure count is a number for proper sorting
    const sortState = chartSortStates.country;
    const sortedData = [...data].sort((a, b) => {
        const diff = sortState.by === 'count' ? Number(b.count) - Number(a.count) : a.country_code.localeCompare(b.country_code);
        return sortState.dir === 'desc' ? diff : -diff;
    });

    const labels = sortedData.slice(0, 10).map(d => d.country_name || d.country_code);
    const values = sortedData.slice(0, 10).map(d => Number(d.count));
    // Calculate total from ALL data, not just top 10, for accurate percentages
    const total = data.reduce((sum, d) => sum + Number(d.count), 0);

    // Destroy existing chart
    if (archiveCharts.country) archiveCharts.country.destroy();

    const ctx = document.getElementById('countryChart').getContext('2d');
    archiveCharts.country = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: t('count'),
                data: values,
                backgroundColor: chartColors.primary,
                borderRadius: 4
            }]
        },
        options: getBarChartOptions()
    });

    // Render TOP 5
    renderTop5(sortedData.slice(0, 5), 'countryTop5', 'country_name', 'country_code', total);
}

/**
 * Render city distribution chart
 */
function renderCityChart() {
    const data = archiveChartsData.cityDistribution || [];
    if (data.length === 0) {
        document.getElementById('cityTop5').innerHTML = `<div class="no-data">${t('no_data')}</div>`;
        return;
    }

    // Sort data - ensure count is a number for proper sorting
    const sortState = chartSortStates.city;
    const sortedData = [...data].sort((a, b) => {
        const diff = sortState.by === 'count' ? Number(b.count) - Number(a.count) : a.city.localeCompare(b.city);
        return sortState.dir === 'desc' ? diff : -diff;
    });

    const labels = sortedData.slice(0, 10).map(d => `${d.city} (${d.country_code})`);
    const values = sortedData.slice(0, 10).map(d => Number(d.count));
    // Calculate total from ALL data, not just top 10, for accurate percentages
    const total = data.reduce((sum, d) => sum + Number(d.count), 0);

    if (archiveCharts.city) archiveCharts.city.destroy();

    const ctx = document.getElementById('cityChart').getContext('2d');
    archiveCharts.city = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: t('count'),
                data: values,
                backgroundColor: chartColors.primary,
                borderRadius: 4
            }]
        },
        options: getBarChartOptions()
    });

    renderTop5(sortedData.slice(0, 5).map(d => ({...d, displayName: `${d.city} (${d.country_code})`})), 'cityTop5', 'displayName', 'city', total);
}

/**
 * Render ISP distribution chart
 */
function renderISPChart() {
    const data = archiveChartsData.ispDistribution || [];
    if (data.length === 0) {
        document.getElementById('ispTop5').innerHTML = `<div class="no-data">${t('no_data')}</div>`;
        return;
    }

    // Sort data - ensure count is a number for proper sorting
    const sortState = chartSortStates.isp;
    const sortedData = [...data].sort((a, b) => {
        const diff = sortState.by === 'count' ? Number(b.count) - Number(a.count) : a.isp.localeCompare(b.isp);
        return sortState.dir === 'desc' ? diff : -diff;
    });

    const labels = sortedData.slice(0, 10).map(d => d.isp.length > 20 ? d.isp.substring(0, 20) + '...' : d.isp);
    const values = sortedData.slice(0, 10).map(d => Number(d.count));
    // Calculate total from ALL data, not just top 10, for accurate percentages
    const total = data.reduce((sum, d) => sum + Number(d.count), 0);

    if (archiveCharts.isp) archiveCharts.isp.destroy();

    const ctx = document.getElementById('ispChart').getContext('2d');
    archiveCharts.isp = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: t('count'),
                data: values,
                backgroundColor: chartColors.primary,
                borderRadius: 4
            }]
        },
        options: getBarChartOptions()
    });

    renderTop5(sortedData.slice(0, 5), 'ispTop5', 'isp', 'isp', total);
}


/**
 * Render risk level distribution chart (Pie)
 */
function renderRiskLevelChart() {
    const data = archiveChartsData.riskLevelDistribution || [];
    if (data.length === 0) {
        document.getElementById('riskLevelLegend').innerHTML = `<div class="no-data">${t('no_data')}</div>`;
        return;
    }

    const levelMap = { high: t('high_risk'), medium: t('medium_risk'), low: t('low_risk'), unknown: t('unknown_risk') };
    const colorMap = chartColors.riskLevels;

    const labels = data.map(d => levelMap[d.risk_level] || d.risk_level);
    const values = data.map(d => d.count);
    const colors = data.map(d => colorMap[d.risk_level] || '#6c757d');
    const total = values.reduce((a, b) => a + b, 0);

    if (archiveCharts.riskLevel) archiveCharts.riskLevel.destroy();

    const ctx = document.getElementById('riskLevelChart').getContext('2d');
    archiveCharts.riskLevel = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: colors,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: (ctx) => `${ctx.label}: ${ctx.raw} (${((ctx.raw / total) * 100).toFixed(1)}%)`
                    }
                }
            }
        }
    });

    // Render custom legend
    const legendHtml = data.map(d => {
        const label = levelMap[d.risk_level] || d.risk_level;
        const color = colorMap[d.risk_level] || '#6c757d';
        const pct = ((d.count / total) * 100).toFixed(1);
        return `<div class="legend-item">
            <span class="legend-color" style="background: ${color}"></span>
            <span class="legend-label">${label}</span>
            <span class="legend-value">${d.count} (${pct}%)</span>
        </div>`;
    }).join('');
    document.getElementById('riskLevelLegend').innerHTML = legendHtml;
}

/**
 * Render risk score distribution chart
 */
function renderRiskScoreChart() {
    const data = archiveChartsData.riskScoreDistribution || [];
    if (data.length === 0) {
        document.getElementById('riskScoreTop5').innerHTML = `<div class="no-data">${t('no_data')}</div>`;
        return;
    }

    // Sort by score range
    const rangeOrder = ['80-100', '60-79', '40-59', '20-39', '0-19'];
    const sortedData = [...data].sort((a, b) => rangeOrder.indexOf(a.score_range) - rangeOrder.indexOf(b.score_range));

    const labels = sortedData.map(d => d.score_range);
    const values = sortedData.map(d => d.count);
    const colors = sortedData.map(d => chartColors.scoreRanges[d.score_range] || '#6c757d');
    const total = values.reduce((a, b) => a + b, 0);

    if (archiveCharts.riskScore) archiveCharts.riskScore.destroy();

    const ctx = document.getElementById('riskScoreChart').getContext('2d');
    archiveCharts.riskScore = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: t('count'),
                data: values,
                backgroundColor: colors,
                borderRadius: 4
            }]
        },
        options: {
            ...getBarChartOptions(),
            indexAxis: 'y'
        }
    });

    // Render score summary
    const summaryHtml = sortedData.map(d => {
        const pct = ((d.count / total) * 100).toFixed(1);
        const color = chartColors.scoreRanges[d.score_range] || '#6c757d';
        return `<div class="score-item">
            <span class="score-range" style="color: ${color}">${d.score_range}</span>
            <span class="score-count">${d.count} (${pct}%)</span>
        </div>`;
    }).join('');
    document.getElementById('riskScoreTop5').innerHTML = summaryHtml;
}

/**
 * Render threat type distribution chart
 */
function renderThreatTypeChart() {
    const data = archiveChartsData.threatTypeDistribution || [];
    if (data.length === 0) {
        document.getElementById('threatTypeTop5').innerHTML = `<div class="no-data">${t('no_data')}</div>`;
        return;
    }

    // Sort data - ensure count is a number for proper sorting
    const sortState = chartSortStates.threat;
    const sortedData = [...data].sort((a, b) => {
        const diff = sortState.by === 'count' ? Number(b.count) - Number(a.count) : (a.threatType || '').localeCompare(b.threatType || '');
        return sortState.dir === 'desc' ? diff : -diff;
    });

    const labels = sortedData.slice(0, 10).map(d => d.threatType || 'Unknown');
    const values = sortedData.slice(0, 10).map(d => Number(d.count));
    // Calculate total from ALL data, not just top 10, for accurate percentages
    const total = data.reduce((sum, d) => sum + Number(d.count), 0);

    if (archiveCharts.threatType) archiveCharts.threatType.destroy();

    const ctx = document.getElementById('threatTypeChart').getContext('2d');
    archiveCharts.threatType = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: t('count'),
                data: values,
                backgroundColor: chartColors.primary,
                borderRadius: 4
            }]
        },
        options: {
            ...getBarChartOptions(),
            indexAxis: 'y'
        }
    });

    renderTop5(sortedData.slice(0, 5), 'threatTypeTop5', 'threatType', 'threatType', total);
}

/**
 * Render global geo map / 渲染全球地理分布圖
 * Uses Google GeoChart to display blacklisted IP distribution by country
 * 使用谷歌 GeoChart 顯示黑名單 IP 的國家分布
 */
function renderGeoMap() {
    const loadingEl = document.getElementById('geoMapLoading');
    const noDataEl = document.getElementById('geoMapNoData');
    const mapEl = document.getElementById('blackIpGeoMap');

    console.log('renderGeoMap called - googleChartsLoaded:', googleChartsLoaded);

    // Check if Google Charts is loaded
    if (!googleChartsLoaded) {
        console.log('Waiting for Google Charts to load...');
        return;
    }

    // Check if map element exists and is visible
    if (!mapEl) {
        console.error('Geo map container element not found');
        return;
    }

    // Get country distribution data
    let data = archiveChartsData?.countryDistribution || [];
    console.log('Geo map data (unfiltered):', data.length, 'countries');

    // Apply region filter if set
    if (currentRegionFilter !== 'all') {
        data = data.filter(item => item.region === currentRegionFilter);
        console.log('Geo map data (filtered by', currentRegionFilter + '):', data.length, 'countries');
    }

    // Handle no data case
    if (data.length === 0) {
        if (loadingEl) loadingEl.style.display = 'none';
        if (noDataEl) noDataEl.classList.remove('hidden');
        if (mapEl) mapEl.style.display = 'none';
        console.log('No geo data available');
        return;
    }

    // Hide loading, show map
    if (loadingEl) loadingEl.style.display = 'none';
    if (noDataEl) noDataEl.classList.add('hidden');
    if (mapEl) mapEl.style.display = 'block';

    try {
        // Prepare data for Google GeoChart
        // Format: [['Country', 'IP Count'], ['US', 100], ['CN', 50], ...]
        const geoData = new google.visualization.DataTable();
        geoData.addColumn('string', 'Country');
        geoData.addColumn('number', t('ip_count'));

        // Add data rows using country codes
        // Note: count must be converted to Number as PDO returns strings
        let rowsAdded = 0;
        data.forEach(item => {
            if (item.country_code && item.country_code.length === 2) {
                const countValue = Number(item.count);
                if (!isNaN(countValue) && countValue > 0) {
                    geoData.addRow([item.country_code.toUpperCase(), countValue]);
                    rowsAdded++;
                }
            }
        });

        console.log('GeoChart data rows added:', rowsAdded, 'of', data.length);

        // If no valid rows, show no data message
        if (rowsAdded === 0) {
            if (loadingEl) loadingEl.style.display = 'none';
            if (noDataEl) noDataEl.classList.remove('hidden');
            if (mapEl) mapEl.style.display = 'none';
            console.log('No valid geo data to display');
            return;
        }

        // Chart options with red gradient (matching risk colors)
        const options = {
            colorAxis: {
                colors: ['#fee5d9', '#fcae91', '#fb6a4a', chartColors.riskLevels.high] // Light to dark red
            },
            backgroundColor: '#fafbfc',
            datalessRegionColor: '#e8e8e8',
            defaultColor: '#e8e8e8',
            legend: {
                textStyle: {
                    color: '#333',
                    fontSize: 12
                }
            },
            tooltip: {
                textStyle: {
                    color: '#333'
                },
                showColorCode: true
            },
            keepAspectRatio: true,
            width: '100%',
            height: 450
        };

        // Create and draw the chart
        geoMapChart = new google.visualization.GeoChart(mapEl);
        geoMapChart.draw(geoData, options);

        console.log('Geo map rendered successfully with', rowsAdded, 'countries');

        // Populate the legend table with country data
        populateGeoMapLegend(data);

        // Add resize handler for responsive behavior
        if (!window.geoMapResizeHandler) {
            window.geoMapResizeHandler = true;
            window.addEventListener('resize', debounce(function() {
                if (geoMapChart && archiveChartsData?.countryDistribution) {
                    renderGeoMap();
                }
            }, 250));
        }
    } catch (error) {
        console.error('Error rendering geo map:', error);
        if (loadingEl) loadingEl.style.display = 'none';
        if (noDataEl) {
            noDataEl.classList.remove('hidden');
            noDataEl.querySelector('span:last-child').textContent = t('export_failed');
        }
    }
}

/**
 * Debounce function for resize handling / 防抖函數用於調整大小處理
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

/**
 * Get country flag emoji from country code
 * 從國家代碼獲取國旗表情符號
 * @param {string} countryCode Two-letter country code (ISO 3166-1 alpha-2)
 * @returns {string} Flag emoji or default flag
 */
function getCountryFlag(countryCode) {
    if (!countryCode || countryCode.length !== 2) return '🏴';
    const codePoints = countryCode.toUpperCase().split('').map(char => 127397 + char.charCodeAt(0));
    return String.fromCodePoint(...codePoints);
}

/**
 * Render country IP ranges chart / 渲染國家IP範圍圖表
 * Fetches data from API and renders horizontal bar chart with IP ranges breakdown
 */
async function renderCountryIPRangesChart() {
    const chartCanvas = document.getElementById('countryIPRangesChart');
    const breakdownContainer = document.getElementById('ipRangesBreakdown');

    if (!chartCanvas || !breakdownContainer) {
        console.log('Country IP ranges chart elements not found');
        return;
    }

    // Show loading state
    breakdownContainer.innerHTML = `
        <div class="breakdown-loading">
            <div class="loading-spinner"></div>
            <span data-i18n="loading">${t('loading')}</span>
        </div>
    `;

    try {
        const response = await fetch(`${API_URL}?action=country_ip_ranges&limit=10`);
        const result = await response.json();

        if (!result.success || !result.data || result.data.length === 0) {
            breakdownContainer.innerHTML = `<div class="no-data">${t('no_data')}</div>`;
            return;
        }

        const data = result.data;

        // Prepare chart data
        const labels = data.map(d => getCountryFlag(d.country_code) + ' ' + (d.country_name || d.country_code));
        const values = data.map(d => Number(d.count));

        // Destroy existing chart
        if (archiveCharts.countryIPRanges) {
            archiveCharts.countryIPRanges.destroy();
        }

        // Create horizontal bar chart
        const ctx = chartCanvas.getContext('2d');
        archiveCharts.countryIPRanges = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: t('blacklisted_ips'),
                    data: values,
                    backgroundColor: chartColors.primary,
                    borderColor: chartColors.primaryBorder,
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                indexAxis: 'y', // Horizontal bar chart
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${t('count')}: ${context.raw.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: { precision: 0 },
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    y: {
                        grid: { display: false }
                    }
                }
            }
        });

        // Render IP ranges breakdown
        renderIPRangesBreakdown(data);

    } catch (error) {
        console.error('Error rendering country IP ranges chart:', error);
        breakdownContainer.innerHTML = `<div class="no-data">${t('export_failed')}</div>`;
    }
}

/**
 * Render IP ranges breakdown / 渲染IP範圍分解
 * @param {Array} data Country IP ranges data
 */
function renderIPRangesBreakdown(data) {
    const container = document.getElementById('ipRangesBreakdown');
    if (!container) return;

    let html = '<div class="breakdown-list">';

    data.forEach(country => {
        const flag = getCountryFlag(country.country_code);
        const ranges = country.ip_ranges || [];
        const displayRanges = ranges.slice(0, 20); // Limit to 20 ranges for display
        const hasMore = ranges.length > 20;

        html += `
            <div class="breakdown-item">
                <div class="breakdown-header">
                    <span class="country-flag">${flag}</span>
                    <span class="country-name">${country.country_name || country.country_code}</span>
                    <span class="country-count">${Number(country.count).toLocaleString()} IPs</span>
                </div>
                <div class="breakdown-ranges">
                    ${displayRanges.map(range => `<span class="ip-range">${range}</span>`).join('')}
                    ${hasMore ? `<span class="ip-range" style="background:#fef3cd;color:#856404;border-color:#ffeeba;">+${ranges.length - 20} more</span>` : ''}
                </div>
            </div>
        `;
    });

    html += '</div>';
    container.innerHTML = html;
}

/**
 * Refresh country IP ranges chart / 刷新國家IP範圍圖表
 */
async function refreshCountryIPRanges() {
    await renderCountryIPRangesChart();
}

/**
 * Render regional distribution pie chart / 渲染區域分布餅圖
 * Shows blacklisted IP distribution across EU, AM, APAC regions
 */
function renderRegionalDistributionChart() {
    const chartCanvas = document.getElementById('regionDistributionChart');
    if (!chartCanvas) {
        console.log('Regional distribution chart canvas not found');
        return;
    }

    // Get region distribution data from cached data
    const data = archiveChartsData?.regionDistribution || [];

    if (data.length === 0) {
        console.log('No region distribution data available');
        return;
    }

    // Update region stat cards
    data.forEach(region => {
        const countEl = document.getElementById(`regionCount${region.code}`);
        const percentEl = document.getElementById(`regionPercent${region.code}`);

        if (countEl) {
            countEl.textContent = Number(region.count).toLocaleString();
        }
        if (percentEl) {
            percentEl.textContent = `${region.percentage}% (${region.countries} ${t('countries_count')})`;
        }
    });

    // Destroy existing chart if it exists
    if (archiveCharts.regionDistribution) {
        archiveCharts.regionDistribution.destroy();
    }

    // Prepare chart data
    const labels = data.map(d => currentLang === 'zh' ? d.name_zh : d.name_en);
    const values = data.map(d => Number(d.count));
    const colors = data.map(d => chartColors.regions[d.code] || chartColors.regions.OTHER);

    // Create doughnut chart
    const ctx = chartCanvas.getContext('2d');
    archiveCharts.regionDistribution = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: colors,
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 15,
                        font: { size: 12 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const region = data[context.dataIndex];
                            const count = Number(region.count).toLocaleString();
                            const countries = region.countries;
                            return `${context.label}: ${count} IPs (${region.percentage}%) - ${countries} ${t('countries_count')}`;
                        }
                    }
                }
            },
            cutout: '50%'
        }
    });
}

/**
 * Filter geo map by region / 依區域篩選地圖
 * @param {string} region Region code (all, EU, AM, APAC)
 */
function filterGeoMapByRegion(region) {
    currentRegionFilter = region;

    // Update button active states
    document.querySelectorAll('.region-filter-btn').forEach(btn => {
        const btnRegion = btn.getAttribute('data-region');
        if (btnRegion === region) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    // Re-render geo map with filter applied
    renderGeoMap();
}

/**
 * Populate geo map legend table / 填充地圖圖例表
 * @param {Array} data Country distribution data
 */
function populateGeoMapLegend(data) {
    const tbody = document.getElementById('geoLegendBody');
    if (!tbody) return;

    // Filter by current region filter
    let filteredData = data;
    if (currentRegionFilter !== 'all') {
        filteredData = data.filter(item => item.region === currentRegionFilter);
    }

    // Sort by count descending
    const sortedData = [...filteredData].sort((a, b) => Number(b.count) - Number(a.count));

    // Calculate total for percentages (from filtered data)
    const total = sortedData.reduce((sum, d) => sum + Number(d.count), 0);

    // Build table rows with region column
    let html = '';
    sortedData.forEach(item => {
        const count = Number(item.count);
        const percentage = total > 0 ? ((count / total) * 100).toFixed(1) : 0;
        const flag = getCountryFlag(item.country_code);
        const region = item.region || 'OTHER';
        const regionColor = chartColors.regions[region] || chartColors.regions.OTHER;

        html += `
            <tr>
                <td class="region-cell">
                    <span class="region-badge" style="background:${regionColor};color:#fff;padding:2px 6px;border-radius:4px;font-size:0.75rem;">${region}</span>
                </td>
                <td>
                    <span class="country-flag">${flag}</span>
                    <span class="country-name">${item.country_name || item.country_code}</span>
                    <span class="country-code">(${item.country_code})</span>
                </td>
                <td class="count-cell">${count.toLocaleString()}</td>
                <td class="percent-cell">${percentage}%</td>
            </tr>
        `;
    });

    tbody.innerHTML = html;
}

/**
 * Export geo map as image / 匯出地圖為圖片
 * Uses Google Charts' built-in getImageURI() method for reliable export
 * 使用谷歌圖表內建的 getImageURI() 方法進行可靠的匯出
 */
function exportGeoMapAsImage() {
    try {
        // Check if geo map chart exists
        if (!geoMapChart) {
            console.error('Geo map chart not initialized');
            showChartNotification(t('export_failed'), 'error');
            return;
        }

        // Generate filename with date
        const date = new Date().toISOString().split('T')[0];
        const filename = `global-ip-heatmap-${date}.png`;

        // Method 1: Try Google Charts built-in getImageURI() method
        // This is the most reliable method for exporting Google Charts
        if (typeof geoMapChart.getImageURI === 'function') {
            try {
                const imageURI = geoMapChart.getImageURI();
                if (imageURI) {
                    downloadImage(imageURI, filename);
                    showChartNotification(t('export_success'), 'success');
                    console.log('Geo map exported using getImageURI:', filename);
                    return;
                }
            } catch (uriError) {
                console.warn('getImageURI failed, trying fallback method:', uriError);
            }
        }

        // Method 2: Fallback - Manual SVG to Canvas conversion with proper namespace handling
        const mapContainer = document.getElementById('blackIpGeoMap');
        if (!mapContainer) {
            console.error('Map container not found');
            showChartNotification(t('export_failed'), 'error');
            return;
        }

        const svg = mapContainer.querySelector('svg');
        if (!svg) {
            console.error('SVG element not found in map container');
            showChartNotification(t('export_failed'), 'error');
            return;
        }

        // Clone SVG to avoid modifying the original
        const svgClone = svg.cloneNode(true);

        // Ensure proper XML namespaces are set
        svgClone.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
        svgClone.setAttribute('xmlns:xlink', 'http://www.w3.org/1999/xlink');

        // Get computed dimensions
        const svgRect = svg.getBoundingClientRect();
        const width = svgRect.width || svg.getAttribute('width') || 800;
        const height = svgRect.height || svg.getAttribute('height') || 450;

        // Set explicit dimensions on clone
        svgClone.setAttribute('width', width);
        svgClone.setAttribute('height', height);

        // Inline all styles from the original SVG
        inlineSVGStyles(svg, svgClone);

        // Serialize the SVG
        const svgData = new XMLSerializer().serializeToString(svgClone);

        // Create a properly formatted SVG data URL (more reliable than Blob URL)
        // Use TextEncoder for modern Unicode handling instead of deprecated unescape
        const svgBase64 = btoa(Array.from(new TextEncoder().encode(svgData), byte => String.fromCharCode(byte)).join(''));
        const dataUrl = 'data:image/svg+xml;base64,' + svgBase64;

        // Create canvas and image
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = width;
        canvas.height = height;

        const img = new Image();
        img.crossOrigin = 'anonymous';

        img.onload = function() {
            // Fill white background first
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Draw the SVG image
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

            // Export as PNG
            try {
                const pngDataUrl = canvas.toDataURL('image/png');
                downloadImage(pngDataUrl, filename);
                showChartNotification(t('export_success'), 'success');
                console.log('Geo map exported using SVG fallback:', filename);
            } catch (canvasError) {
                console.error('Canvas export failed:', canvasError);
                showChartNotification(t('export_failed'), 'error');
            }
        };

        img.onerror = function(e) {
            console.error('Failed to load SVG as image:', e);
            showChartNotification(t('export_failed'), 'error');
        };

        img.src = dataUrl;

    } catch (error) {
        console.error('Export geo map failed:', error);
        showChartNotification(t('export_failed'), 'error');
    }
}

/**
 * Helper function to download image / 下載圖片的輔助函數
 */
function downloadImage(dataUrl, filename) {
    const link = document.createElement('a');
    link.download = filename;
    link.href = dataUrl;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

/**
 * Inline SVG styles from computed styles / 從計算樣式內聯 SVG 樣式
 * This ensures styles are preserved when converting SVG to image
 */
function inlineSVGStyles(originalSvg, clonedSvg) {
    try {
        // Get all elements in both SVGs
        const originalElements = originalSvg.querySelectorAll('*');
        const clonedElements = clonedSvg.querySelectorAll('*');

        // Copy computed styles for key properties
        const styleProperties = ['fill', 'stroke', 'stroke-width', 'opacity', 'font-family', 'font-size', 'font-weight'];

        for (let i = 0; i < originalElements.length && i < clonedElements.length; i++) {
            const computedStyle = window.getComputedStyle(originalElements[i]);
            let inlineStyle = '';

            styleProperties.forEach(prop => {
                const value = computedStyle.getPropertyValue(prop);
                if (value && value !== 'none' && value !== '') {
                    inlineStyle += `${prop}:${value};`;
                }
            });

            if (inlineStyle) {
                const existingStyle = clonedElements[i].getAttribute('style') || '';
                clonedElements[i].setAttribute('style', existingStyle + inlineStyle);
            }
        }
    } catch (styleError) {
        console.warn('Could not inline SVG styles:', styleError);
    }
}


/**
 * Get common bar chart options
 */
function getBarChartOptions() {
    return {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: (ctx) => `${t('count')}: ${ctx.raw}`
                }
            }
        },
        scales: {
            x: {
                grid: { display: false },
                ticks: { font: { size: 10 } }
            },
            y: {
                grid: { color: 'rgba(0,0,0,0.05)' },
                ticks: { font: { size: 10 } }
            }
        },
        animation: {
            duration: 800,
            easing: 'easeOutQuart'
        }
    };
}

/**
 * Render TOP 5 rankings with badges
 */
function renderTop5(data, containerId, displayField, fallbackField, total) {
    if (!data || data.length === 0) {
        document.getElementById(containerId).innerHTML = `<div class="no-data">${t('no_data')}</div>`;
        return;
    }

    const html = data.map((item, index) => {
        const badge = rankBadges[index] || '🏅';
        const name = item[displayField] || item[fallbackField] || 'Unknown';
        const count = item.count;
        const pct = ((count / total) * 100).toFixed(1);
        const rankClass = index < 3 ? `top-${index + 1}` : 'top-other';

        return `
            <div class="top-item ${rankClass}">
                <span class="rank-badge">${badge}</span>
                <span class="rank-name" title="${name}">${name.length > 18 ? name.substring(0, 18) + '...' : name}</span>
                <span class="rank-stats">${count} <span class="rank-pct">(${pct}%)</span></span>
            </div>
        `;
    }).join('');

    document.getElementById(containerId).innerHTML = `<div class="top5-list">${html}</div>`;
}

/**
 * Sort chart data and re-render
 */
function sortChartData(chartType) {
    const sortState = chartSortStates[chartType];
    if (!sortState) return;

    // Toggle direction
    sortState.dir = sortState.dir === 'desc' ? 'asc' : 'desc';

    // Re-render the specific chart
    switch (chartType) {
        case 'country':
            renderCountryChart();
            break;
        case 'city':
            renderCityChart();
            break;
        case 'isp':
            renderISPChart();
            break;
        case 'threat':
            renderThreatTypeChart();
            break;
    }
}

/**
 * Export chart as PNG image
 * @param {string} chartId - Canvas element ID
 * @param {string} filename - Base filename without extension
 */
function exportChartAsImage(chartId, filename) {
    try {
        const canvas = document.getElementById(chartId);
        if (!canvas) {
            console.error('Canvas not found:', chartId);
            showChartNotification(t('export_failed'), 'error');
            return;
        }

        // Get current date for filename
        const date = new Date().toISOString().split('T')[0]; // YYYY-MM-DD
        const fullFilename = `${filename}-${date}.png`;

        // Convert canvas to data URL
        const dataURL = canvas.toDataURL('image/png');

        // Create temporary download link
        const link = document.createElement('a');
        link.download = fullFilename;
        link.href = dataURL;

        // Trigger download
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        // Show success message
        showChartNotification(t('export_success'), 'success');
        console.log('Chart exported:', fullFilename);
    } catch (error) {
        console.error('Export failed:', error);
        showChartNotification(t('export_failed'), 'error');
    }
}

/**
 * Show notification message for chart operations
 * @param {string} message - Message to display
 * @param {string} type - 'success' or 'error'
 */
function showChartNotification(message, type) {
    // Remove any existing notifications
    const existing = document.querySelector('.chart-notification');
    if (existing) {
        existing.remove();
    }

    // Create notification element
    const notification = document.createElement('div');
    notification.className = `chart-notification ${type}`;
    notification.textContent = message;

    // Add to page
    document.body.appendChild(notification);

    // Auto-remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('fade-out');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}