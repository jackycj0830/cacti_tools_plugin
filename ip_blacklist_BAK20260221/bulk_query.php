<?php
/**
 * Bulk IP Query Utility - Standalone Page
 * 批量IP查詢工具 - 獨立頁面
 *
 * This page processes large lists of IPs in batches of 20 with 30-second delays.
 * Data is written to both ip_cache (temporary) and ip_database (permanent archive).
 *
 * @version 1.0.0
 */
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk IP Query Utility / 批量IP查詢工具</title>
    <link rel="stylesheet" href="assets/style.css?v=<?php echo time(); ?>">
    <style>
        /* Bulk Query Page Specific Styles */
        .bulk-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .bulk-header {
            text-align: center;
            padding: 30px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            margin-bottom: 25px;
        }
        .bulk-header h1 { margin: 0 0 10px 0; font-size: 2rem; }
        .bulk-header p { margin: 0; opacity: 0.9; }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        .back-link:hover { text-decoration: underline; }

        /* Input Section */
        .input-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 25px;
        }
        .input-section h3 { margin: 0 0 15px 0; color: #333; }
        .ip-textarea {
            width: 100%;
            height: 200px;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-family: 'Consolas', monospace;
            font-size: 14px;
            resize: vertical;
            transition: border-color 0.3s;
        }
        .ip-textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        .input-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            padding: 10px 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .ip-count { font-weight: 600; color: #667eea; }
        .batch-info { color: #666; font-size: 0.9rem; }

        /* Control Buttons */
        .control-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .btn-start {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-start:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
        }
        .btn-start:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .btn-pause {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-stop {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-clear {
            background: #6c757d;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
        }

        /* Progress Section */
        .progress-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 25px;
            display: none;
        }
        .progress-section.active { display: block; }
        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .progress-title { font-size: 1.2rem; font-weight: 600; color: #333; }
        .progress-status {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.9rem;
        }
        .status-running { background: #d4edda; color: #155724; }
        .status-paused { background: #fff3cd; color: #856404; }
        .status-completed { background: #cce5ff; color: #004085; }
        .status-error { background: #f8d7da; color: #721c24; }

        /* Progress Bar */
        .progress-bar-container {
            position: relative;
            height: 30px;
            background: #e9ecef;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 20px;
        }
        .progress-bar {
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            transition: width 0.5s ease;
            width: 0%;
        }
        .progress-percent {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: 600;
            color: #333;
        }
        .progress-details {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        .detail-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }
        .detail-label { display: block; font-size: 0.85rem; color: #666; margin-bottom: 5px; }
        .detail-value { display: block; font-size: 1.3rem; font-weight: 600; color: #333; }
        .countdown { color: #dc3545 !important; }

        /* Batch Results Log */
        .batch-results {
            max-height: 200px;
            overflow-y: auto;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            font-family: 'Consolas', monospace;
            font-size: 0.9rem;
        }
        .batch-log { padding: 8px 0; border-bottom: 1px solid #e0e0e0; }
        .batch-log:last-child { border-bottom: none; }
        .batch-log.success { color: #28a745; }
        .batch-log.error { color: #dc3545; }
        .batch-log.info { color: #17a2b8; }

        /* Results Section */
        .results-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 25px;
            display: none;
        }
        .results-section.active { display: block; }
        .results-section h3 { margin: 0 0 20px 0; color: #333; }
        .results-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }
        @media (max-width: 992px) {
            .results-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 576px) {
            .results-grid { grid-template-columns: repeat(2, 1fr); }
            .progress-details { grid-template-columns: 1fr; }
        }
        .result-card {
            background: #f8f9fa;
            padding: 20px 15px;
            border-radius: 10px;
            text-align: center;
            border-left: 4px solid #667eea;
        }
        .result-card.blacklisted { border-left-color: #dc3545; background: #fff5f5; }
        .result-card.safe { border-left-color: #28a745; background: #f0fff4; }
        .result-card.high-risk { border-left-color: #dc3545; }
        .result-card.medium-risk { border-left-color: #ffc107; }
        .result-card.low-risk { border-left-color: #28a745; }
        .result-value { display: block; font-size: 2rem; font-weight: 700; color: #333; }
        .result-label { display: block; font-size: 0.85rem; color: #666; margin-top: 5px; }

        /* Cache Stats */
        .cache-stats {
            background: #e8f4fd;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .cache-stats h4 { margin: 0 0 15px 0; color: #004085; }
        .cache-info {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }
        .cache-info span { color: #333; }
        .cache-info strong { color: #667eea; }

        /* Export Buttons */
        .export-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }
        .btn-export {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-export:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
</style>
</head>
<body>
    <div class="bulk-container">
        <a href="ip_blacklist.php" class="back-link">← 返回主頁 / Back to Main</a>

        <div class="bulk-header">
            <h1>📦 Bulk IP Query Utility</h1>
            <p>批量IP查詢工具 - 自動分批處理大量IP並存入資料庫</p>
        </div>

        <!-- Input Section -->
        <div class="input-section">
            <h3>📝 輸入IP列表 / Enter IP List</h3>
            <textarea id="ipTextarea" class="ip-textarea" placeholder="每行輸入一個IP地址，例如：
192.168.1.1
10.0.0.1
8.8.8.8

Enter one IP address per line..."></textarea>
            <div class="input-info">
                <span class="ip-count">IP數量: <span id="ipCount">0</span></span>
                <span class="batch-info">每批處理 <strong>20</strong> 個IP，批次間隔 <strong>30</strong> 秒</span>
            </div>
            <div class="control-buttons">
                <button id="btnStart" class="btn-start" onclick="startProcessing()">▶ 開始處理 / Start</button>
                <button id="btnPause" class="btn-pause" onclick="togglePause()" style="display:none;">⏸ 暫停 / Pause</button>
                <button id="btnStop" class="btn-stop" onclick="stopProcessing()" style="display:none;">⏹ 停止 / Stop</button>
                <button id="btnClear" class="btn-clear" onclick="clearAll()">🗑 清除 / Clear</button>
            </div>
        </div>

        <!-- Progress Section -->
        <div class="progress-section" id="progressSection">
            <div class="progress-header">
                <span class="progress-title">📊 處理進度 / Processing Progress</span>
                <span class="progress-status status-running" id="progressStatus">處理中...</span>
            </div>
            <div class="progress-bar-container">
                <div class="progress-bar" id="progressBar"></div>
                <span class="progress-percent" id="progressPercent">0%</span>
            </div>
            <div class="progress-details">
                <div class="detail-item">
                    <span class="detail-label">當前批次 / Current Batch:</span>
                    <span class="detail-value" id="currentBatch">0 / 0</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">已處理IP / Processed IPs:</span>
                    <span class="detail-value" id="processedIPs">0</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">下批倒數 / Next Batch In:</span>
                    <span class="detail-value countdown" id="countdown">--</span>
                </div>
            </div>
            <div class="batch-results" id="batchResults"></div>
        </div>

        <!-- Results Section -->
        <div class="results-section" id="resultsSection">
            <h3>📈 處理結果摘要 / Results Summary</h3>
            <div class="results-grid">
                <div class="result-card total">
                    <span class="result-value" id="totalProcessed">0</span>
                    <span class="result-label">總處理數 / Total</span>
                </div>
                <div class="result-card blacklisted">
                    <span class="result-value" id="totalBlacklisted">0</span>
                    <span class="result-label">黑名單 / Blacklisted</span>
                </div>
                <div class="result-card safe">
                    <span class="result-value" id="totalSafe">0</span>
                    <span class="result-label">安全 / Safe</span>
                </div>
                <div class="result-card high-risk">
                    <span class="result-value" id="totalHighRisk">0</span>
                    <span class="result-label">高風險 / High Risk</span>
                </div>
                <div class="result-card medium-risk">
                    <span class="result-value" id="totalMediumRisk">0</span>
                    <span class="result-label">中風險 / Medium Risk</span>
                </div>
                <div class="result-card low-risk">
                    <span class="result-value" id="totalLowRisk">0</span>
                    <span class="result-label">低風險 / Low Risk</span>
                </div>
            </div>
            <div class="cache-stats" id="cacheStats">
                <h4>💾 快取統計 / Cache Statistics</h4>
                <div class="cache-info">
                    <span>快取命中 / Cache Hits: <strong id="cacheHits">0</strong></span>
                    <span>API呼叫 / API Calls: <strong id="apiCalls">0</strong></span>
                    <span>命中率 / Hit Rate: <strong id="hitRate">0%</strong></span>
                </div>
            </div>
            <div class="export-buttons">
                <button class="btn-export" onclick="exportResults('csv')">📥 匯出CSV / Export CSV</button>
                <button class="btn-export" onclick="exportResults('json')">📥 匯出JSON / Export JSON</button>
            </div>
        </div>
    </div>

    <script>
    // =====================================================
    // Bulk IP Query Processing Script
    // 批量IP查詢處理腳本
    // =====================================================

    // State variables
    let allIPs = [];
    let batches = [];
    let currentBatchIndex = 0;
    let isProcessing = false;
    let isPaused = false;
    let countdownInterval = null;
    let allResults = [];

    // Statistics
    let stats = {
        totalProcessed: 0,
        blacklisted: 0,
        safe: 0,
        highRisk: 0,
        mediumRisk: 0,
        lowRisk: 0,
        cacheHits: 0,
        apiCalls: 0
    };

    // Configuration
    const BATCH_SIZE = 20;
    const DELAY_SECONDS = 30;

    // DOM Elements
    const ipTextarea = document.getElementById('ipTextarea');
    const ipCountEl = document.getElementById('ipCount');
    const btnStart = document.getElementById('btnStart');
    const btnPause = document.getElementById('btnPause');
    const btnStop = document.getElementById('btnStop');
    const progressSection = document.getElementById('progressSection');
    const resultsSection = document.getElementById('resultsSection');

    // Update IP count on input
    ipTextarea.addEventListener('input', updateIPCount);

    function updateIPCount() {
        const ips = parseIPs(ipTextarea.value);
        ipCountEl.textContent = ips.length;
        const batchCount = Math.ceil(ips.length / BATCH_SIZE);
        document.querySelector('.batch-info').innerHTML =
            `每批處理 <strong>${BATCH_SIZE}</strong> 個IP，共 <strong>${batchCount}</strong> 批，批次間隔 <strong>${DELAY_SECONDS}</strong> 秒`;
    }

    function parseIPs(text) {
        return text.split(/[\n,;]+/)
            .map(ip => ip.trim())
            .filter(ip => ip && /^(\d{1,3}\.){3}\d{1,3}$/.test(ip));
    }

    function startProcessing() {
        allIPs = parseIPs(ipTextarea.value);
        if (allIPs.length === 0) {
            alert('請輸入有效的IP地址 / Please enter valid IP addresses');
            return;
        }

        // Split into batches
        batches = [];
        for (let i = 0; i < allIPs.length; i += BATCH_SIZE) {
            batches.push(allIPs.slice(i, i + BATCH_SIZE));
        }

        // Reset state
        currentBatchIndex = 0;
        isProcessing = true;
        isPaused = false;
        allResults = [];
        stats = { totalProcessed: 0, blacklisted: 0, safe: 0, highRisk: 0, mediumRisk: 0, lowRisk: 0, cacheHits: 0, apiCalls: 0 };

        // Update UI
        btnStart.disabled = true;
        btnPause.style.display = 'inline-block';
        btnStop.style.display = 'inline-block';
        progressSection.classList.add('active');
        resultsSection.classList.remove('active');
        document.getElementById('batchResults').innerHTML = '';
        updateProgress();

        // Start processing
        processNextBatch();
    }

    async function processNextBatch() {
        if (!isProcessing || currentBatchIndex >= batches.length) {
            finishProcessing();
            return;
        }

        if (isPaused) return;

        const batch = batches[currentBatchIndex];
        const batchNum = currentBatchIndex + 1;
        const totalBatches = batches.length;

        updateStatus('running', `處理中 批次 ${batchNum}/${totalBatches}...`);
        addLog(`⏳ 開始處理批次 ${batchNum}/${totalBatches} (${batch.length} IPs)...`, 'info');

        try {
            const response = await fetch('api.php?action=batch', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'ips=' + encodeURIComponent(JSON.stringify(batch))
            });

            const result = await response.json();

            if (result.error) {
                addLog(`❌ 批次 ${batchNum} 錯誤: ${result.error}`, 'error');
            } else {
                // Update statistics
                stats.totalProcessed += result.total || 0;
                stats.blacklisted += result.blacklisted || 0;
                stats.safe += result.safe || 0;
                stats.highRisk += result.highRisk || 0;
                stats.mediumRisk += result.mediumRisk || 0;
                stats.lowRisk += result.lowRisk || 0;
                stats.cacheHits += result.cacheStats?.hits || 0;
                stats.apiCalls += result.cacheStats?.misses || 0;

                // Store results
                if (result.results) {
                    allResults = allResults.concat(result.results);
                }

                addLog(`✅ 批次 ${batchNum} 完成: ${result.blacklisted} 黑名單, ${result.safe} 安全`, 'success');
            }
        } catch (error) {
            addLog(`❌ 批次 ${batchNum} 網路錯誤: ${error.message}`, 'error');
        }

        currentBatchIndex++;
        updateProgress();

        // If more batches, wait before next
        if (currentBatchIndex < batches.length && isProcessing && !isPaused) {
            startCountdown(DELAY_SECONDS);
        } else if (!isPaused) {
            finishProcessing();
        }
    }


    function startCountdown(seconds) {
        let remaining = seconds;
        document.getElementById('countdown').textContent = remaining + 's';

        countdownInterval = setInterval(() => {
            remaining--;
            document.getElementById('countdown').textContent = remaining + 's';

            if (remaining <= 0) {
                clearInterval(countdownInterval);
                countdownInterval = null;
                document.getElementById('countdown').textContent = '--';
                if (!isPaused && isProcessing) {
                    processNextBatch();
                }
            }
        }, 1000);
    }

    function togglePause() {
        isPaused = !isPaused;

        if (isPaused) {
            btnPause.textContent = '▶ 繼續 / Resume';
            btnPause.classList.add('btn-resume');
            updateStatus('paused', '已暫停 / Paused');
            addLog('⏸ 處理已暫停', 'info');

            // Stop countdown if running
            if (countdownInterval) {
                clearInterval(countdownInterval);
                countdownInterval = null;
            }
        } else {
            btnPause.textContent = '⏸ 暫停 / Pause';
            btnPause.classList.remove('btn-resume');
            updateStatus('running', '處理中...');
            addLog('▶ 處理已繼續', 'info');

            // Resume processing
            processNextBatch();
        }
    }

    function stopProcessing() {
        if (confirm('確定要停止處理嗎？/ Are you sure you want to stop?')) {
            isProcessing = false;
            isPaused = false;

            if (countdownInterval) {
                clearInterval(countdownInterval);
                countdownInterval = null;
            }

            addLog('⏹ 處理已停止', 'error');
            finishProcessing();
        }
    }

    function finishProcessing() {
        isProcessing = false;
        isPaused = false;

        if (countdownInterval) {
            clearInterval(countdownInterval);
            countdownInterval = null;
        }

        // Update UI
        btnStart.disabled = false;
        btnPause.style.display = 'none';
        btnStop.style.display = 'none';
        updateStatus('completed', '完成 / Completed');
        document.getElementById('countdown').textContent = '--';

        // Show results section
        resultsSection.classList.add('active');
        updateResultsDisplay();

        addLog(`🎉 處理完成！共處理 ${stats.totalProcessed} 個IP`, 'success');
    }

    function updateProgress() {
        const percent = batches.length > 0 ? Math.round((currentBatchIndex / batches.length) * 100) : 0;
        document.getElementById('progressBar').style.width = percent + '%';
        document.getElementById('progressPercent').textContent = percent + '%';
        document.getElementById('currentBatch').textContent = `${currentBatchIndex} / ${batches.length}`;
        document.getElementById('processedIPs').textContent = stats.totalProcessed;
    }

    function updateStatus(status, text) {
        const el = document.getElementById('progressStatus');
        el.textContent = text;
        el.className = 'progress-status status-' + status;
    }

    function addLog(message, type = 'info') {
        const container = document.getElementById('batchResults');
        const log = document.createElement('div');
        log.className = 'batch-log ' + type;
        log.textContent = `[${new Date().toLocaleTimeString()}] ${message}`;
        container.appendChild(log);
        container.scrollTop = container.scrollHeight;
    }

    function updateResultsDisplay() {
        document.getElementById('totalProcessed').textContent = stats.totalProcessed;
        document.getElementById('totalBlacklisted').textContent = stats.blacklisted;
        document.getElementById('totalSafe').textContent = stats.safe;
        document.getElementById('totalHighRisk').textContent = stats.highRisk;
        document.getElementById('totalMediumRisk').textContent = stats.mediumRisk;
        document.getElementById('totalLowRisk').textContent = stats.lowRisk;
        document.getElementById('cacheHits').textContent = stats.cacheHits;
        document.getElementById('apiCalls').textContent = stats.apiCalls;

        const total = stats.cacheHits + stats.apiCalls;
        const hitRate = total > 0 ? ((stats.cacheHits / total) * 100).toFixed(1) : 0;
        document.getElementById('hitRate').textContent = hitRate + '%';
    }

    function clearAll() {
        if (isProcessing) {
            alert('請先停止處理 / Please stop processing first');
            return;
        }
        ipTextarea.value = '';
        updateIPCount();
        progressSection.classList.remove('active');
        resultsSection.classList.remove('active');
        allResults = [];
    }

    function exportResults(format) {
        if (allResults.length === 0) {
            alert('沒有可匯出的結果 / No results to export');
            return;
        }

        let content, filename, mimeType;
        const timestamp = new Date().toISOString().slice(0, 10);

        if (format === 'csv') {
            const headers = ['IP', 'Status', 'Blacklisted', 'Country', 'City', 'ISP', 'Risk Level', 'Risk Score'];
            const rows = allResults.map(r => [
                r.ip, r.status, r.blacklisted ? 'Yes' : 'No',
                r.countryName || r.country || '-', r.city || '-', r.isp || '-',
                r.riskLevel || 'low', r.riskScore || 0
            ]);
            content = [headers, ...rows].map(r => r.map(c => `"${c}"`).join(',')).join('\n');
            filename = `bulk_query_results_${timestamp}.csv`;
            mimeType = 'text/csv';
        } else {
            content = JSON.stringify({
                exportDate: new Date().toISOString(),
                statistics: stats,
                results: allResults
            }, null, 2);
            filename = `bulk_query_results_${timestamp}.json`;
            mimeType = 'application/json';
        }

        const blob = new Blob([content], { type: mimeType });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = filename;
        a.click();
        URL.revokeObjectURL(url);
    }

    // Initialize
    updateIPCount();
    </script>
</body>
</html>