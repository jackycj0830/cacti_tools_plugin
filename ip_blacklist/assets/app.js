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
        confirm_delete_note: '確定要刪除此備註嗎？'
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
        confirm_delete_note: 'Are you sure you want to delete this note?'
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

            <!-- Note editor (hidden by default) -->
            <div id="noteEditor-${ip}" class="note-editor hidden">
                <textarea id="noteText-${ip}" class="note-textarea" placeholder="${t('note_placeholder')}" maxlength="2000">${note}</textarea>
                <div class="note-char-count">
                    <span id="charCount-${ip}">${note.length}</span>/2000
                </div>
                <div class="note-actions">
                    <button class="btn btn-primary btn-sm" onclick="saveNote('${ip}')">${t('save_note')}</button>
                    <button class="btn btn-secondary btn-sm" onclick="cancelNoteEdit('${ip}')">${t('cancel')}</button>
                    ${hasNote ? `<button class="btn btn-danger btn-sm" onclick="deleteNote('${ip}')">${t('delete_note')}</button>` : ''}
                </div>
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

        // Focus on textarea and update char count when showing editor
        if (!editor.classList.contains('hidden') && textarea) {
            textarea.focus();
            updateNoteCharCount(ip);
            // Add input listener for character count
            textarea.oninput = () => updateNoteCharCount(ip);
        }
    }
}

/**
 * Update character count for note textarea
 */
function updateNoteCharCount(ip) {
    const textarea = document.getElementById(`noteText-${ip}`);
    const countSpan = document.getElementById(`charCount-${ip}`);
    if (textarea && countSpan) {
        countSpan.textContent = textarea.value.length;
    }
}

/**
 * Cancel note editing
 */
function cancelNoteEdit(ip) {
    const display = document.getElementById(`noteDisplay-${ip}`);
    const editor = document.getElementById(`noteEditor-${ip}`);
    const textarea = document.getElementById(`noteText-${ip}`);

    // Reset textarea to original value
    if (textarea && lastQueryResult && lastQueryResult.customNote !== undefined) {
        textarea.value = lastQueryResult.customNote || '';
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
 * Generate Fortigate CLI commands
 */
function generateFortigateCLI() {
    const input = document.getElementById('fortigateIpInput').value;
    const prefix = document.getElementById('fortigatePrefix').value || 'Blacklist_IP_';
    const subnetMask = document.getElementById('fortigateSubnetMask').value;

    const { validIPs, invalidIPs } = parseAndValidateIPs(input);

    // Show validation errors if any
    const validationDiv = document.getElementById('fortigateValidation');
    const errorsUl = document.getElementById('fortigateErrors');

    if (invalidIPs.length > 0) {
        errorsUl.innerHTML = invalidIPs.map(err =>
            `<li>${t('invalid_ip_format')}: Line ${err.line} - "${err.ip}"</li>`
        ).join('');
        validationDiv.style.display = 'block';
    } else {
        validationDiv.style.display = 'none';
    }

    // Show output section
    const outputSection = document.getElementById('fortigateOutputSection');
    const outputTextarea = document.getElementById('fortigateOutput');
    const ipCountSpan = document.getElementById('fortigateIpCount');

    if (validIPs.length === 0) {
        outputSection.style.display = 'block';
        outputTextarea.value = `# ${t('no_valid_ips')}`;
        ipCountSpan.textContent = '0';
        return;
    }

    // Generate CLI commands
    let commands = 'config firewall address\n';

    validIPs.forEach(ip => {
        // Determine CIDR suffix based on subnet mask
        let cidrSuffix = '/32';
        if (subnetMask === '255.255.255.0') cidrSuffix = '/24';
        else if (subnetMask === '255.255.0.0') cidrSuffix = '/16';

        const addressName = `${prefix}${ip}${cidrSuffix}`;
        commands += `edit "${addressName}"\n`;
        commands += `set subnet ${ip} ${subnetMask}\n`;
        commands += `next\n`;
    });

    commands += 'end';

    // Display output
    outputSection.style.display = 'block';
    outputTextarea.value = commands;
    ipCountSpan.textContent = validIPs.length.toString();

    // Clear copy status
    document.getElementById('fortigateCopyStatus').textContent = '';
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
