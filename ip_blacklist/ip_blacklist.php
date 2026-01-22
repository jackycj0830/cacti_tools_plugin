<?php
/**
 * IP Blacklist Query System - Web Interface
 * 黑名單IP查詢系統 - 網頁介面
 */
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Blacklist Query System / 黑名單IP查詢系統</title>
    <link rel="stylesheet" href="assets/style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <h1>🛡️ IP Blacklist Query System</h1>
            <p class="subtitle">黑名單IP查詢系統 - 即時查詢海外惡意IP</p>
            <div class="lang-switch">
                <button onclick="setLang('en')" id="btn-en">EN</button>
                <button onclick="setLang('zh')" id="btn-zh" class="active">中文</button>
            </div>
        </header>

        <!-- Statistics Panel -->
        <div class="stats-panel" id="statsPanel">
            <div class="stat-item">
                <span class="stat-value" id="totalBlacklisted">-</span>
                <span class="stat-label" data-i18n="total_blacklisted">黑名單IP總數</span>
            </div>
            <div class="stat-item">
                <span class="stat-value" id="lastUpdated">-</span>
                <span class="stat-label" data-i18n="last_updated">最後更新</span>
            </div>
        </div>

        <!-- Query Tabs -->
        <div class="tabs">
            <button class="tab active" onclick="switchTab('single')" data-i18n="single_query">單一查詢</button>
            <button class="tab" onclick="switchTab('batch')" data-i18n="batch_query">批量查詢</button>
            <button class="tab" onclick="switchTab('localdb')" data-i18n="local_database">本地數據查詢</button>
            <!--<button class="tab" onclick="switchTab('history')" data-i18n="history">查詢歷史</button>-->
            <button class="tab" onclick="switchTab('fortigate')" data-i18n="fortigate_cli">防火牆指令</button>
            <button class="tab" onclick="switchTab('riskinfo')" data-i18n="risk_methodology">風險評估說明</button>
            <button class="tab" onclick="switchTab('geoapi')" data-i18n="geoip_apis">GeoIP APIs</button>
            <button class="tab" onclick="switchTab('changelog')" data-i18n="version_history">版本歷史</button>
        </div>

        <!-- Single Query Panel -->
        <div class="panel" id="singlePanel">
            <div class="query-form">
                <input type="text" id="ipInput" placeholder="輸入IP地址 (例: 192.168.1.1) 或 CIDR (例: 192.168.0.0/24)" class="ip-input">
                <button onclick="querySingleIP()" class="btn-primary" data-i18n="query">查詢</button>
            </div>
            <div class="quick-actions">
                <span data-i18n="quick_test">快速測試:</span>
                <button onclick="testIP('192.227.217.239')" class="btn-small">黑名單IP</button>
                <button onclick="testIP('8.8.8.8')" class="btn-small">安全IP</button>
                <button onclick="testIP('176.117.107.0/24')" class="btn-small">CIDR範圍</button>
            </div>
            <div id="singleResult" class="result-container"></div>
        </div>

        <!-- Batch Query Panel -->
        <div class="panel hidden" id="batchPanel">
            <div class="query-form">
                <textarea id="batchInput" placeholder="每行一個IP地址，最多50個" class="batch-input" rows="6"></textarea>
                <button onclick="queryBatchIP()" class="btn-primary" data-i18n="batch_query">批量查詢</button>
            </div>
            <div id="batchResult" class="result-container"></div>
        </div>

        <!-- Local Database Query Panel -->
        <div class="panel hidden" id="localdbPanel">
            <div class="localdb-container">
                <div class="localdb-header">
                    <h3>📁 Local Database Query / 本地數據查詢</h3>
                    <p class="localdb-desc">
                        Search the archived IP database for historical records. These are previously queried IPs that have been archived from the cache.
                    </p>
                    <p class="localdb-desc zh">
                        搜尋已歸檔的IP資料庫以查詢歷史記錄。這些是先前查詢過並從快取歸檔的IP。
                    </p>
                </div>

                <!-- Archive Statistics -->
                <div class="archive-stats-panel" id="archiveStatsPanel">
                    <h4>📊 <span data-i18n="archive_statistics">歸檔統計</span></h4>
                    <div class="archive-stats-grid" id="archiveStatsGrid">
                        <div class="archive-stat-item">
                            <span class="archive-stat-value" id="archiveTotalRecords">-</span>
                            <span class="archive-stat-label" data-i18n="total_archived">總歸檔數</span>
                        </div>
                        <div class="archive-stat-item">
                            <span class="archive-stat-value" id="archiveBlacklisted">-</span>
                            <span class="archive-stat-label" data-i18n="blacklisted_archived">黑名單IP</span>
                        </div>
                        <div class="archive-stat-item">
                            <span class="archive-stat-value" id="archiveHighRisk">-</span>
                            <span class="archive-stat-label" data-i18n="high_risk_archived">高風險</span>
                        </div>
                        <div class="archive-stat-item">
                            <span class="archive-stat-value" id="archiveCountries">-</span>
                            <span class="archive-stat-label" data-i18n="countries_archived">國家數</span>
                        </div>
                    </div>
                </div>

                <!-- Search Filters -->
                <div class="localdb-search-section">
                    <h4>🔍 <span data-i18n="search_filters">搜尋篩選</span></h4>
                    <div class="localdb-filters">
                        <div class="filter-row">
                            <div class="filter-group">
                                <label for="localIpInput" data-i18n="ip_address">IP 地址</label>
                                <input type="text" id="localIpInput" class="filter-input" placeholder="例: 192.168.1.1 或部分IP">
                            </div>
                            <div class="filter-group">
                                <label for="localCountryFilter" data-i18n="country">國家</label>
                                <select id="localCountryFilter" class="filter-select">
                                    <option value="" data-i18n="all_countries">所有國家</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label for="localRiskFilter" data-i18n="risk_level">風險等級</label>
                                <select id="localRiskFilter" class="filter-select">
                                    <option value="" data-i18n="all_levels">所有等級</option>
                                    <option value="high" data-i18n="high_risk">高風險</option>
                                    <option value="medium" data-i18n="medium_risk">中等風險</option>
                                    <option value="low" data-i18n="low_risk">低風險</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label for="localStatusFilter" data-i18n="status">狀態</label>
                                <select id="localStatusFilter" class="filter-select">
                                    <option value="" data-i18n="all_status">所有狀態</option>
                                    <option value="blocked" data-i18n="blocked">已封鎖</option>
                                    <option value="safe" data-i18n="safe">安全</option>
                                </select>
                            </div>
                        </div>
                        <div class="filter-row">
                            <div class="filter-group">
                                <label for="localDateFrom" data-i18n="date_from">開始日期</label>
                                <input type="date" id="localDateFrom" class="filter-input">
                            </div>
                            <div class="filter-group">
                                <label for="localDateTo" data-i18n="date_to">結束日期</label>
                                <input type="date" id="localDateTo" class="filter-input">
                            </div>
                            <div class="filter-group filter-actions">
                                <button onclick="searchLocalDatabase()" class="btn-primary" data-i18n="search">搜尋</button>
                                <button onclick="clearLocalFilters()" class="btn-secondary" data-i18n="clear_filters">清除篩選</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick IP Lookup -->
                <div class="localdb-quick-lookup">
                    <h4>⚡ <span data-i18n="quick_lookup">快速查詢</span></h4>
                    <div class="quick-lookup-form">
                        <input type="text" id="localQuickIpInput" class="quick-ip-input" placeholder="輸入完整IP地址進行精確查詢">
                        <button onclick="queryLocalIP()" class="btn-primary" data-i18n="lookup">查詢</button>
                    </div>
                </div>

                <!-- Results Section -->
                <div class="localdb-results-section" id="localdbResultsSection" style="display:none;">
                    <div class="results-header">
                        <h4>📋 <span data-i18n="search_results">搜尋結果</span></h4>
                        <div class="results-info">
                            <span id="localResultCount">0</span> <span data-i18n="records_found">筆記錄</span>
                        </div>
                    </div>
                    <div id="localdbResults" class="localdb-results"></div>
                    <div class="pagination-controls" id="localPagination" style="display:none;">
                        <button onclick="loadLocalPage('prev')" class="btn-secondary" id="localPrevBtn" disabled data-i18n="previous">上一頁</button>
                        <span id="localPageInfo">1 / 1</span>
                        <button onclick="loadLocalPage('next')" class="btn-secondary" id="localNextBtn" disabled data-i18n="next">下一頁</button>
                    </div>
                </div>

                <!-- Single IP Result -->
                <div class="localdb-single-result" id="localdbSingleResult" style="display:none;">
                    <div class="single-result-header">
                        <h4>📍 <span data-i18n="ip_details">IP 詳情</span></h4>
                        <span class="archived-badge" data-i18n="archived_data">歷史數據</span>
                    </div>
                    <div id="localSingleResultContent"></div>
                </div>

                <!-- No Results Message -->
                <div class="localdb-no-results" id="localdbNoResults" style="display:none;">
                    <div class="no-results-icon">🔍</div>
                    <p data-i18n="no_archived_records">本地數據庫中沒有找到符合條件的記錄</p>
                    <p class="no-results-hint" data-i18n="no_results_hint">嘗試調整搜尋條件或等待更多數據被歸檔</p>
                </div>
            </div>
        </div>

        <!-- History Panel -->
        <div class="panel hidden" id="historyPanel">
            <div class="history-actions">
                <button onclick="loadHistory()" class="btn-secondary" data-i18n="refresh">刷新</button>
                <button onclick="exportHistory('json')" class="btn-secondary">導出 JSON</button>
                <button onclick="exportHistory('csv')" class="btn-secondary">導出 CSV</button>
            </div>
            <div id="historyResult" class="result-container"></div>
        </div>

        <!-- Fortigate CLI Panel -->
        <div class="panel hidden" id="fortigatePanel">
            <div class="fortigate-container">
                <div class="fortigate-header">
                    <h3>🔥 Fortigate CLI Command Generator / Fortigate 防火牆指令產生器</h3>
                    <p class="fortigate-desc">
                        Generate Fortigate firewall CLI commands to block IP addresses.
                        Paste IP addresses (one per line) and generate the corresponding CLI commands.
                    </p>
                    <p class="fortigate-desc zh">
                        產生 Fortigate 防火牆 CLI 指令來封鎖 IP 地址。
                        貼上 IP 地址（每行一個）即可產生相應的 CLI 指令。
                    </p>
                </div>

                <div class="fortigate-input-section">
                    <div class="input-group">
                        <label for="fortigateIpInput" data-i18n="input_ips">輸入 IP 地址</label>
                        <textarea id="fortigateIpInput" class="fortigate-input" rows="8"
                            placeholder="每行輸入一個 IP 地址，例如:&#10;85.11.182.27&#10;91.231.222.20&#10;91.231.222.33&#10;176.117.107.241&#10;176.117.107.242"></textarea>
                    </div>

                    <div class="fortigate-options">
                        <div class="option-group">
                            <label for="fortigatePrefix" data-i18n="address_prefix">地址名稱前綴</label>
                            <input type="text" id="fortigatePrefix" value="Blacklist_IP_" class="option-input" placeholder="Blacklist_IP_">
                        </div>
                        <div class="option-group">
                            <label for="fortigateSubnetMask" data-i18n="subnet_mask">子網掩碼</label>
                            <select id="fortigateSubnetMask" class="option-select">
                                <option value="255.255.255.255" selected>/32 (255.255.255.255) - Single Host</option>
                                <option value="255.255.255.0">/24 (255.255.255.0) - Class C</option>
                                <option value="255.255.0.0">/16 (255.255.0.0) - Class B</option>
                            </select>
                        </div>
                    </div>

                    <!-- Group Management Section -->
                    <div class="fortigate-group-section">
                        <div class="group-header">
                            <h4>📁 <span data-i18n="group_management">群組管理</span></h4>
                        </div>
                        <div class="group-options">
                            <div class="group-checkbox-wrapper">
                                <input type="checkbox" id="enableGroupAssignment" class="group-checkbox">
                                <label for="enableGroupAssignment" data-i18n="enable_group_assignment">將 IP 加入群組</label>
                            </div>
                            <div class="group-number-wrapper">
                                <label for="fortigateGroupNumber" data-i18n="group_number">群組編號</label>
                                <input type="number" id="fortigateGroupNumber" value="18" min="1" max="999" class="group-number-input" oninput="updateGroupPreview()" onchange="updateGroupPreview()">
                            </div>
                            <div class="group-preview-wrapper">
                                <label data-i18n="group_name_preview">群組名稱預覽</label>
                                <span id="groupNamePreview" class="group-name-preview">Blacklist_Group_IPs_18</span>
                            </div>
                        </div>
                        <div class="group-tip">
                            <span class="tip-icon">💡</span>
                            <span data-i18n="group_tip">使用 append member 指令，不會覆蓋現有成員</span>
                        </div>
                    </div>

                    <div class="fortigate-actions">
                        <button onclick="generateFortigateCLI()" class="btn-primary" data-i18n="generate_cli">產生指令</button>
                        <button onclick="clearFortigateInput()" class="btn-secondary" data-i18n="clear">清除</button>
                        <button onclick="loadBlacklistedIPs()" class="btn-secondary" data-i18n="load_blacklist">載入黑名單 IP</button>
                    </div>
                </div>

                <div class="fortigate-output-section" id="fortigateOutputSection" style="display:none;">
                    <div class="output-header">
                        <h4>📋 <span data-i18n="generated_commands">產生的指令</span></h4>
                        <div class="output-stats">
                            <span id="fortigateIpCount">0</span> <span data-i18n="ips_processed">個 IP 已處理</span>
                        </div>
                    </div>
                    <div class="output-actions">
                        <button onclick="copyFortigateCLI()" class="btn-copy" data-i18n="copy_to_clipboard">複製到剪貼簿</button>
                        <button onclick="downloadFortigateCLI()" class="btn-secondary" data-i18n="download_file">下載檔案</button>
                    </div>
                    <textarea id="fortigateOutput" class="fortigate-output" rows="15" readonly></textarea>
                    <div id="fortigateCopyStatus" class="copy-status"></div>
                </div>

                <div class="fortigate-validation" id="fortigateValidation" style="display:none;">
                    <h4>⚠️ <span data-i18n="validation_errors">驗證錯誤</span></h4>
                    <ul id="fortigateErrors"></ul>
                </div>

                <div class="fortigate-help">
                    <h4>💡 <span data-i18n="usage_tips">使用提示</span></h4>
                    <ul>
                        <li><span data-i18n="tip_1">輸入的 IP 地址會自動驗證，無效的 IP 會被忽略</span></li>
                        <li><span data-i18n="tip_2">產生的指令可直接貼入 Fortigate CLI 執行</span></li>
                        <li><span data-i18n="tip_3">建議先在測試環境驗證指令後再應用至生產環境</span></li>
                        <li><span data-i18n="tip_4">點擊「載入黑名單 IP」可自動載入系統中的黑名單 IP</span></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Risk Assessment Methodology Panel -->
        <div class="panel hidden" id="riskinfoPanel">
            <div class="riskinfo-container">
                <h3>📊 Risk Assessment Methodology / 風險評估方法論</h3>

                <div class="riskinfo-section">
                    <h4>🎯 Overview / 概述</h4>
                    <p class="riskinfo-desc">
                        The risk assessment algorithm evaluates IP addresses based on multiple factors to determine their threat level.
                        Each factor contributes points to a total risk score, which determines the final risk level.
                    </p>
                    <p class="riskinfo-desc zh">
                        風險評估算法根據多個因素評估 IP 地址，以確定其威脅等級。
                        每個因素都會為總風險分數貢獻分數，最終決定風險等級。
                    </p>
                </div>

                <div class="riskinfo-section">
                    <h4>📈 Risk Score Calculation / 風險分數計算</h4>
                    <div class="score-formula">
                        <code>Total Risk Score = Factor 1 + Factor 2 + Factor 3</code>
                    </div>

                    <div class="risk-factors-grid">
                        <div class="risk-factor-card factor-1">
                            <div class="factor-header">
                                <span class="factor-number">1</span>
                                <h5>Blacklist Status / 黑名單狀態</h5>
                            </div>
                            <div class="factor-body">
                                <div class="factor-score">+50 points / 分</div>
                                <p><strong>Condition:</strong> IP is found in the blacklist database</p>
                                <p class="zh"><strong>條件：</strong> IP 存在於黑名單數據庫中</p>
                                <div class="factor-impact high">High Impact / 高影響</div>
                            </div>
                        </div>

                        <div class="risk-factor-card factor-2">
                            <div class="factor-header">
                                <span class="factor-number">2</span>
                                <h5>Provider Data Availability / 提供者數據可用性</h5>
                            </div>
                            <div class="factor-body">
                                <div class="factor-score">+10 points / 分</div>
                                <p><strong>Condition:</strong> Less than 50% of GeoIP providers respond successfully</p>
                                <p class="zh"><strong>條件：</strong> 少於 50% 的 GeoIP 提供者成功回應</p>
                                <div class="factor-impact medium">Medium Impact / 中影響</div>
                            </div>
                        </div>

                        <div class="risk-factor-card factor-3">
                            <div class="factor-header">
                                <span class="factor-number">3</span>
                                <h5>Country Consensus / 國家共識</h5>
                            </div>
                            <div class="factor-body">
                                <div class="factor-score">+5 points / 分</div>
                                <p><strong>Condition:</strong> GeoIP providers disagree on the IP's country of origin</p>
                                <p class="zh"><strong>條件：</strong> GeoIP 提供者對 IP 來源國家的判定不一致</p>
                                <div class="factor-impact low">Low Impact / 低影響</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="riskinfo-section">
                    <h4>🚦 Risk Level Thresholds / 風險等級閾值</h4>
                    <div class="threshold-table">
                        <div class="threshold-row high">
                            <div class="threshold-level">🔴 High Risk / 高風險</div>
                            <div class="threshold-range">Score ≥ 50</div>
                            <div class="threshold-action">Recommend blocking / 建議封鎖</div>
                        </div>
                        <div class="threshold-row medium">
                            <div class="threshold-level">🟡 Medium Risk / 中等風險</div>
                            <div class="threshold-range">Score ≥ 20 and < 50</div>
                            <div class="threshold-action">Recommend monitoring / 建議監控</div>
                        </div>
                        <div class="threshold-row low">
                            <div class="threshold-level">🟢 Low Risk / 低風險</div>
                            <div class="threshold-range">Score < 20</div>
                            <div class="threshold-action">Generally safe / 通常安全</div>
                        </div>
                    </div>
                </div>

                <div class="riskinfo-section">
                    <h4>💡 Interpretation Guide / 解讀指南</h4>
                    <ul class="interpretation-list">
                        <li>
                            <strong>Blacklisted IPs (Score 50+):</strong> These IPs are confirmed threats from the blacklist database.
                            Immediate action recommended.
                        </li>
                        <li class="zh">
                            <strong>黑名單 IP（分數 50+）：</strong> 這些 IP 是黑名單數據庫中確認的威脅。建議立即採取行動。
                        </li>
                        <li>
                            <strong>Limited Provider Data:</strong> When fewer providers respond, the geolocation data may be less reliable,
                            warranting additional caution.
                        </li>
                        <li class="zh">
                            <strong>有限的提供者數據：</strong> 當較少提供者回應時，地理位置數據可能較不可靠，需要額外謹慎。
                        </li>
                        <li>
                            <strong>Country Disagreement:</strong> Inconsistent country data may indicate proxy usage, VPN, or data center IPs
                            that require further investigation.
                        </li>
                        <li class="zh">
                            <strong>國家不一致：</strong> 不一致的國家數據可能表示使用代理、VPN 或數據中心 IP，需要進一步調查。
                        </li>
                    </ul>
                </div>

                <div class="riskinfo-section">
                    <h4>⚙️ Algorithm Details / 算法詳情</h4>
                    <pre class="code-block">
// Risk Score Calculation Algorithm
riskScore = 0;

// Factor 1: Blacklist Status (50 points)
if (IP is in blacklist) {
    riskScore += 50;
}

// Factor 2: Provider Data Availability (10 points)
dataRatio = successfulProviders / totalProviders;
if (dataRatio < 0.5) {
    riskScore += 10;
}

// Factor 3: Country Consensus (5 points)
if (providers report different countries) {
    riskScore += 5;
}

// Determine Risk Level
if (riskScore >= 50) → High Risk
else if (riskScore >= 20) → Medium Risk
else → Low Risk
                    </pre>
                </div>
            </div>
        </div>

        <!-- GeoIP API Panel -->
        <div class="panel hidden" id="geoapiPanel">
            <div class="geoapi-info">
                <h3>🌍 GeoIP API Providers / GeoIP API 提供者</h3>
                <p class="geoapi-desc">
                    This system uses multiple GeoIP API providers to ensure reliable and accurate geolocation data.
                    The system operates in <strong>fallback mode</strong> by default: it queries providers in priority order
                    and uses the first successful response.
                </p>
                <p class="geoapi-desc zh">
                    本系統使用多個 GeoIP API 提供者以確保可靠且準確的地理位置數據。
                    系統預設使用<strong>回退模式</strong>：按優先順序查詢各提供者，使用第一個成功的響應。
                </p>

                <div class="geoapi-modes">
                    <h4>📋 Query Modes / 查詢模式</h4>
                    <div class="mode-item">
                        <strong>Fallback Mode (Default)</strong> - Tries each provider in order until one succeeds.
                        Fastest and most efficient for normal use.
                    </div>
                    <div class="mode-item">
                        <strong>Aggregate Mode</strong> - Queries all providers and merges results.
                        Provides most complete data but slower. Configure in api.php.
                    </div>
                </div>

                <h4>📡 Configured Providers / 已配置的提供者</h4>
                <div id="geoapiProviders" class="providers-list">
                    <div class="loading">Loading providers...</div>
                </div>

                <div class="geoapi-config">
                    <h4>⚙️ Configuration Guide / 配置指南</h4>
                    <p>To add your own API keys or enable additional providers, edit <code>api.php</code>:</p>
                    <pre class="code-block">
// Example: Enable ipgeolocation.io with your API key
$GEOIP_PROVIDERS['ipgeolocation'] = [
    'enabled' => true,
    'apiKey' => 'YOUR_API_KEY_HERE',
    // ... other settings
];

// Change query mode to aggregate
define('GEOIP_QUERY_MODE', 'aggregate');
                    </pre>
                </div>

                <div class="geoapi-notes">
                    <h4>📝 Important Notes / 重要說明</h4>
                    <ul>
                        <li><strong>Rate Limits:</strong> Free tiers have request limits. Results are cached for 24 hours to minimize API calls.</li>
                        <li><strong>API Keys:</strong> Some providers require API keys. Register at their websites for free keys.</li>
                        <li><strong>Accuracy:</strong> GeoIP data is approximate. City-level accuracy varies by provider and region.</li>
                        <li><strong>Privacy:</strong> IP addresses are sent to external APIs. No personal data is stored.</li>
                    </ul>
                    <ul class="zh">
                        <li><strong>請求限制：</strong> 免費方案有請求限制。結果緩存24小時以減少API調用。</li>
                        <li><strong>API金鑰：</strong> 部分提供者需要API金鑰。請至其網站免費註冊。</li>
                        <li><strong>準確度：</strong> GeoIP數據為近似值。城市級準確度因提供者和地區而異。</li>
                        <li><strong>隱私：</strong> IP地址會發送至外部API。不存儲個人數據。</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Version History / Changelog Panel -->
        <div class="panel hidden" id="changelogPanel">
            <div class="changelog-container">
                <h3>📋 Version History / 版本歷史</h3>
                <p class="changelog-intro">
                    This page documents all major updates, feature additions, and improvements to the IP Blacklist Query System.
                </p>
                <p class="changelog-intro zh">
                    此頁面記錄 IP 黑名單查詢系統的所有重大更新、功能添加和改進。
                </p>

                <div class="version-timeline">
                    <!-- Version 2.3.0 -->
                    <div class="version-entry">
                        <div class="version-header">
                            <span class="version-number">v2.3.0</span>
                            <span class="version-date">2026-01-22</span>
                            <span class="version-tag feature">Feature Release</span>
                        </div>
                        <div class="version-body">
                            <h5>🆕 New Features / 新功能</h5>
                            <ul>
                                <li>Fortigate CLI Two-Phase Workflow - Phase 1: Individual address objects, Phase 2: Group assignment / Fortigate CLI 兩階段工作流程</li>
                                <li>Group Management UI with enable checkbox, group number input (1-999), and dynamic name preview / 群組管理介面含啟用核取方塊、群組編號輸入、動態名稱預覽</li>
                                <li>Uses "append member" command for safe group assignment (won't overwrite existing members) / 使用 append member 指令安全添加成員</li>
                                <li>External IP Lookup buttons: Whois365, Trend Micro, VirusTotal / 外部 IP 查詢按鈕</li>
                                <li>Enhanced Note Editor with toolbar, font controls, expand/collapse, character counter / 增強備註編輯器含工具列、字體控制、展開收合、字數計數</li>
                            </ul>
                            <h5>🔧 Improvements / 改進</h5>
                            <ul>
                                <li>Cache-busting implementation for JS/CSS files to ensure latest version loads / 快取破壞機制確保載入最新版本</li>
                                <li>Note display area updated to fixed dimensions (500px × 200px) / 備註顯示區更新為固定尺寸</li>
                                <li>Group management section with light blue gradient styling / 群組管理區塊淺藍色漸層樣式</li>
                            </ul>
                            <h5>🐛 Bug Fixes / 修復</h5>
                            <ul>
                                <li>Fixed checkbox state detection in group assignment feature / 修復群組分配核取方塊狀態偵測</li>
                                <li>Fixed Phase 2 command generation when checkbox is enabled / 修復 Phase 2 指令產生</li>
                                <li>Fixed cached results showing "undefined" in risk analysis / 修復快取結果在風險分析顯示 undefined</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Version 2.2.0 -->
                    <div class="version-entry">
                        <div class="version-header">
                            <span class="version-number">v2.2.0</span>
                            <span class="version-date">2026-01-10</span>
                            <span class="version-tag feature">Feature Release</span>
                        </div>
                        <div class="version-body">
                            <h5>🆕 New Features / 新功能</h5>
                            <ul>
                                <li>Custom notes/annotations for blacklisted IPs / 黑名單IP自訂備註功能</li>
                                <li>Add, edit, and delete notes for any blacklisted IP / 新增、編輯、刪除任何黑名單IP的備註</li>
                                <li>Notes stored in database with creation and update timestamps / 備註存儲在資料庫中，含建立和更新時間戳</li>
                                <li>Notes displayed inline in query results / 備註在查詢結果中顯示</li>
                            </ul>
                            <h5>🔧 Improvements / 改進</h5>
                            <ul>
                                <li>Note character limit (2000 characters) with live counter / 備註字符限制（2000字符）含即時計數器</li>
                                <li>Bilingual UI for all note-related features / 所有備註相關功能的雙語UI</li>
                                <li>Notes persist even when cache expires / 備註在快取過期後仍保留</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Version 2.1.0 -->
                    <div class="version-entry">
                        <div class="version-header">
                            <span class="version-number">v2.1.0</span>
                            <span class="version-date">2026-01-10</span>
                            <span class="version-tag feature">Feature Release</span>
                        </div>
                        <div class="version-body">
                            <h5>🆕 New Features / 新功能</h5>
                            <ul>
                                <li>Cache status display in query results (From Cache / Fresh Query) / 查詢結果中顯示快取狀態（來自快取/新鮮查詢）</li>
                                <li>Cache info section showing creation time, expiration, remaining time, hit count / 快取資訊區塊顯示建立時間、過期時間、剩餘時間、命中次數</li>
                                <li>Manual "Save to Cache" button for single query results / 單一查詢結果的手動「存入快取」按鈕</li>
                                <li>Manual "Save All to Cache" button for batch query results / 批量查詢結果的手動「全部存入快取」按鈕</li>
                                <li>Cache hit statistics display in batch results / 批量結果中顯示快取命中統計</li>
                            </ul>
                            <h5>🔧 Improvements / 改進</h5>
                            <ul>
                                <li>Visual cache badges (From Cache, Fresh Query, Just Cached) / 視覺化快取標籤</li>
                                <li>Real-time feedback for cache save operations / 快取保存操作的即時回饋</li>
                                <li>Enhanced bilingual support for cache-related UI / 增強快取相關UI的雙語支援</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Version 2.0.0 -->
                    <div class="version-entry">
                        <div class="version-header">
                            <span class="version-number">v2.0.0</span>
                            <span class="version-date">2026-01-10</span>
                            <span class="version-tag feature">Major Release</span>
                        </div>
                        <div class="version-body">
                            <h5>🆕 New Features / 新功能</h5>
                            <ul>
                                <li>Database caching system (SQLite/MySQL) for IP query results / 資料庫快取系統（SQLite/MySQL）用於IP查詢結果</li>
                                <li>Cache management API endpoints (stats, cleanup, clear) / 快取管理API端點（統計、清理、清除）</li>
                                <li>Configurable TTL for different IP statuses / 可配置不同IP狀態的TTL</li>
                                <li>Cache hit/miss statistics in batch query results / 批量查詢結果中的快取命中/未命中統計</li>
                            </ul>
                            <h5>🔧 Improvements / 改進</h5>
                            <ul>
                                <li>Significantly reduced API calls through intelligent caching / 通過智能快取顯著減少API調用</li>
                                <li>Faster query response times for cached IPs (~5ms vs ~500ms) / 快取IP的查詢響應時間更快</li>
                                <li>Automatic cache cleanup with configurable probability / 可配置概率的自動快取清理</li>
                                <li>Skip cache option for fresh queries (?nocache=1) / 跳過快取選項用於新鮮查詢</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Version 1.7.0 -->
                    <div class="version-entry">
                        <div class="version-header">
                            <span class="version-number">v1.7.0</span>
                            <span class="version-date">2026-01-08</span>
                            <span class="version-tag feature">Feature Release</span>
                        </div>
                        <div class="version-body">
                            <h5>🆕 New Features / 新功能</h5>
                            <ul>
                                <li>Multi-provider GeoIP for batch queries with country consensus check / 批量查詢使用多提供者GeoIP與國家共識檢查</li>
                                <li>Full 3-factor risk assessment for batch queries (same as single query) / 批量查詢完整3因素風險評估</li>
                                <li>Sorting capability for batch results table (IP, Status, Country, Score, Risk) / 批量結果表格排序功能</li>
                                <li>Filtering by status and risk level (clickable summary cards) / 按狀態和風險等級篩選（可點擊摘要卡片）</li>
                            </ul>
                            <h5>🔧 Improvements / 改進</h5>
                            <ul>
                                <li>Factor 3: Country consensus check now included in batch queries / 因素3：國家共識檢查現已包含在批量查詢中</li>
                                <li>Interactive filter dropdown and clickable stat cards / 互動式篩選下拉選單和可點擊統計卡片</li>
                                <li>Enhanced rate limiting (150ms between IPs, 50ms between providers) / 增強速率限制</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Version 1.6.0 -->
                    <div class="version-entry">
                        <div class="version-header">
                            <span class="version-number">v1.6.0</span>
                            <span class="version-date">2026-01-08</span>
                            <span class="version-tag feature">Feature Release</span>
                        </div>
                        <div class="version-body">
                            <h5>🆕 New Features / 新功能</h5>
                            <ul>
                                <li>Enhanced batch query with GeoIP lookups and risk analysis / 增強批量查詢，加入GeoIP查詢和風險分析</li>
                                <li>Comprehensive batch results table with IP, Country, ISP, Risk Score / 完整批量結果表格，含IP、國家、ISP、風險分數</li>
                                <li>Progress indicator during batch processing / 批量處理進度指示器</li>
                                <li>Risk level statistics in batch summary (High/Medium/Low) / 批量摘要中的風險等級統計</li>
                            </ul>
                            <h5>🔧 Improvements / 改進</h5>
                            <ul>
                                <li>Rate limiting for API calls during batch processing (100ms delay) / 批量處理時的API速率限制</li>
                                <li>GeoIP result caching to avoid duplicate API calls / GeoIP結果快取以避免重複API呼叫</li>
                                <li>Batch query limit set to 50 IPs for detailed analysis / 詳細分析的批量查詢限制為50個IP</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Version 1.5.0 -->
                    <div class="version-entry">
                        <div class="version-header">
                            <span class="version-number">v1.5.0</span>
                            <span class="version-date">2026-01-08</span>
                            <span class="version-tag feature">Feature Release</span>
                        </div>
                        <div class="version-body">
                            <h5>🆕 New Features / 新功能</h5>
                            <ul>
                                <li>Added Risk Assessment Methodology documentation panel / 新增風險評估方法論說明面板</li>
                                <li>Added Version History tab with changelog / 新增版本歷史標籤與變更記錄</li>
                                <li>Enhanced footer with version information / 增強頁腳版本資訊顯示</li>
                            </ul>
                            <h5>🔧 Improvements / 改進</h5>
                            <ul>
                                <li>Improved timezone display format (Asia/Taipei GMT+8) / 改進時區顯示格式</li>
                                <li>Enhanced bilingual support throughout the interface / 增強整體介面的雙語支援</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Version 1.4.0 -->
                    <div class="version-entry">
                        <div class="version-header">
                            <span class="version-number">v1.4.0</span>
                            <span class="version-date">2026-01-07</span>
                            <span class="version-tag feature">Feature Release</span>
                        </div>
                        <div class="version-body">
                            <h5>🆕 New Features / 新功能</h5>
                            <ul>
                                <li>Added Fortigate CLI Command Generator / 新增 Fortigate 防火牆指令產生器</li>
                                <li>Support for generating firewall address commands / 支援產生防火牆地址指令</li>
                                <li>Copy to clipboard and download file functionality / 複製到剪貼簿和下載檔案功能</li>
                                <li>Load blacklist IPs feature / 載入黑名單 IP 功能</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Version 1.3.0 -->
                    <div class="version-entry">
                        <div class="version-header">
                            <span class="version-number">v1.3.0</span>
                            <span class="version-date">2026-01-06</span>
                            <span class="version-tag feature">Feature Release</span>
                        </div>
                        <div class="version-body">
                            <h5>🆕 New Features / 新功能</h5>
                            <ul>
                                <li>Aggregated GeoIP display from multiple providers / 多提供者聚合 GeoIP 顯示</li>
                                <li>Risk assessment algorithm with scoring system / 帶評分系統的風險評估算法</li>
                                <li>Provider comparison view / 提供者比較檢視</li>
                            </ul>
                            <h5>🔧 Improvements / 改進</h5>
                            <ul>
                                <li>Enhanced result display with risk analysis panel / 增強結果顯示與風險分析面板</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Version 1.2.0 -->
                    <div class="version-entry">
                        <div class="version-header">
                            <span class="version-number">v1.2.0</span>
                            <span class="version-date">2026-01-05</span>
                            <span class="version-tag feature">Feature Release</span>
                        </div>
                        <div class="version-body">
                            <h5>🆕 New Features / 新功能</h5>
                            <ul>
                                <li>Multi-provider GeoIP API support (4 providers) / 多提供者 GeoIP API 支援（4 個提供者）</li>
                                <li>Fallback and aggregate query modes / 回退和聚合查詢模式</li>
                                <li>GeoIP API configuration panel / GeoIP API 配置面板</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Version 1.1.0 -->
                    <div class="version-entry">
                        <div class="version-header">
                            <span class="version-number">v1.1.0</span>
                            <span class="version-date">2026-01-03</span>
                            <span class="version-tag improvement">Improvement</span>
                        </div>
                        <div class="version-body">
                            <h5>🔧 Improvements / 改進</h5>
                            <ul>
                                <li>Added CIDR range query support / 新增 CIDR 範圍查詢支援</li>
                                <li>Batch query functionality / 批量查詢功能</li>
                                <li>Query history tracking / 查詢歷史追蹤</li>
                                <li>Export to JSON/CSV / 匯出為 JSON/CSV</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Version 1.0.0 -->
                    <div class="version-entry">
                        <div class="version-header">
                            <span class="version-number">v1.0.0</span>
                            <span class="version-date">2026-01-01</span>
                            <span class="version-tag initial">Initial Release</span>
                        </div>
                        <div class="version-body">
                            <h5>🚀 Initial Release / 首次發布</h5>
                            <ul>
                                <li>IP blacklist query functionality / IP 黑名單查詢功能</li>
                                <li>GeoIP location lookup / GeoIP 位置查詢</li>
                                <li>Threat information display / 威脅資訊顯示</li>
                                <li>Bilingual interface (English/Chinese) / 雙語介面（英文/中文）</li>
                                <li>Statistics dashboard / 統計儀表板</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-content">
                <div class="footer-main">
                    <p>&copy; <?php echo date('Y'); ?> Cacti Tools - IP Blacklist Query System</p>
                    <p class="footer-powered">Powered by TPV IT Global Infrastructure Team</p>
                </div>
                <div class="footer-version">
                    <span class="version-badge">v2.3.0</span>
                    <span class="version-date">Last Updated:  2026-01-22</span>
                </div>
            </div>
        </footer>
    </div>

    <script src="assets/app.js?v=<?php echo time(); ?>"></script>
    <script>
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadStats();
            document.getElementById('ipInput').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') querySingleIP();
            });
        });
    </script>
</body>
</html>

