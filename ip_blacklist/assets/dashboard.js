// Security Dashboard JS logic
// Ported from Block_IP_20260223 Dashboard + Block_IP_20260305 new features

/* ── Helpers ─────────────────────────────────────── */
function getAnalysisDays() {
    return document.getElementById('analysisDays').value || 7;
}

function getDeviceFilter() {
    const el = document.getElementById('deviceFilter');
    return el ? el.value : '';
}

function refreshDashboard() {
    Promise.all([
        loadDashStats(),
        loadDashBlacklist(),
        loadDashFaz(),
        loadDashCountryChart(),
        loadDashCountryTimeline(),
        // NEW Phase 4 loaders
        loadDashDeviceTimeline(),
        loadDashAdStatus(),
        loadDashNonAdStatus(),
        loadDashDeviceChart(),
        loadDashUserChart(),
    ]).catch(err => console.error('Dashboard refresh error:', err));
}

async function fetchDashJson(action, extraParams) {
    try {
        const days = getAnalysisDays();
        const devname = getDeviceFilter();
        let url = `${API_URL}?action=${action}&days=${days}`;
        if (devname) url += `&devname=${encodeURIComponent(devname)}`;
        if (extraParams) {
            for (const [k, v] of Object.entries(extraParams)) {
                url += `&${k}=${encodeURIComponent(v)}`;
            }
        }
        const response = await fetch(url);
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        return await response.json();
    } catch (e) {
        console.error(`API Error (${action}):`, e);
        return null;
    }
}

function dashVerdictTag(v) {
    if (!v) return '<span class="verdict-tag">UNKNOWN</span>';
    const cls = v.toUpperCase() === 'MALICIOUS' ? 'malicious' : v.toUpperCase() === 'SUSPICIOUS' ? 'suspicious' : 'clean';
    return `<span class="verdict-tag ${cls}">${v}</span>`;
}

function dashCountClass(n) {
    return n >= 100 ? 'count-cell high' : 'count-cell';
}

let currentDashPeriodStr = "1 Week";

async function loadDashStats() {
    const s = await fetchDashJson('dash_stats');
    if (!s) {
        document.getElementById('dashboardLastUpdate').textContent = 'Error loading stats';
        return;
    }

    document.getElementById('wfTotalFails').textContent = (s.faz_total_logins || 0).toLocaleString();
    document.getElementById('wfTotalIps').textContent = (s.faz_unique_ips || 0).toLocaleString();
    document.getElementById('wfFilterCount').textContent = (s.faz_ip_count || 0).toLocaleString();
    document.getElementById('wfBlCount').textContent = (s.run_blacklisted || 0).toLocaleString();

    if (s.faz_start && s.faz_end) {
        let year = new Date().getFullYear();
        let d1 = new Date(`${year}-${s.faz_start.replace(' ', 'T')}:00`);
        let d2 = new Date(`${year}-${s.faz_end.replace(' ', 'T')}:00`);
        if (d1 > d2) d1.setFullYear(year - 1);

        let diffHours = Math.round(Math.abs(d2 - d1) / 36e5);
        let diffDays = Math.round(diffHours / 24);

        let periodStr = diffDays + " Days";
        if (diffDays === 1 || diffHours <= 24) periodStr = "1 Day";
        else if (diffDays === 7) periodStr = "1 Week";
        else if (diffDays === 14) periodStr = "2 Weeks";
        else if (diffDays === 28) periodStr = "4 Weeks";

        currentDashPeriodStr = periodStr;

        document.getElementById('dashRealtimeTitle').textContent = `📡 Realtime FAZ Results (${s.faz_start} to ${s.faz_end}) - Last ${periodStr}`;
        document.getElementById('dashMaliciousTitle').textContent = `🚫 Confirmed Malicious IPs (${s.faz_start} to ${s.faz_end}) - Last ${periodStr} (≥ 3 Vendors)`;

        let partialBadge = s.is_partial ? `<span style="background: rgba(247,168,79,0.15); color: var(--accent-orange, #f7a84f); padding: 0.15rem 0.6rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600; margin-left: 0.8rem; border: 1px solid rgba(247,168,79,0.3);" title="Data in SQLite cache only starts from ${s.faz_start}">⚠️ Incomplete Data</span>` : "";

        let luArea = document.getElementById('dashboardLastUpdate');
        if (luArea) {
            luArea.innerHTML =
                `<div style="display: flex; align-items: center;">
                <span class="icon">⏱️</span> 
                <span style="font-weight: 600; margin-left: 0.5rem;">${s.faz_start}</span> 
                <span style="margin: 0 0.5rem;">→</span> 
                <span style="font-weight: 600;">${s.faz_end}</span>
                ${partialBadge}
            </div>`;
        }
    }
}

async function loadDashBlacklist() {
    const data = await fetchDashJson('dash_blacklist');
    const wrap = document.getElementById('dashBlacklistTableWrap');

    if (!data) {
        wrap.innerHTML = '<div class="empty-state" style="padding: 2rem; text-align: center;">Error loading blacklist</div>';
        return;
    }

    if (data.length === 0) {
        wrap.innerHTML = '<div class="empty-state" style="padding: 2rem; text-align: center;">No IPs with ≥ 3 malicious vendor flags yet</div>';
        return;
    }

    let html = `<table class="dashboard-table" style="width: 100%; border-collapse: collapse; text-align: left;"><thead><tr style="border-bottom: 2px solid #dee2e6;">
        <th style="padding: 8px;">IP Address</th><th style="padding: 8px;">Country</th><th style="padding: 8px;">Risk</th><th style="padding: 8px;">Dets</th>
      </tr></thead><tbody>`;

    data.forEach(r => {
        let countryDisplay = r.country && r.country !== 'Unknown' ? r.country : '—';
        html += `<tr style="border-bottom: 1px solid #e9ecef;">
          <td style="padding: 8px; font-family: monospace; color: #0d6efd;">${r.ip}</td>
          <td style="padding: 8px; font-size: 0.85rem;">${countryDisplay}</td>
          <td style="padding: 8px;">${dashVerdictTag(r.verdict)}</td>
          <td style="padding: 8px;" class="${dashCountClass(r.malicious)}">${r.malicious}</td>
        </tr>`;
    });

    html += '</tbody></table>';
    wrap.innerHTML = html;
}

async function loadDashFaz() {
    const data = await fetchDashJson('dash_faz');
    const wrap = document.getElementById('dashFazTableWrap');

    if (!data) {
        wrap.innerHTML = '<div class="empty-state" style="padding: 2rem; text-align: center;">Error loading FAZ results</div>';
        return;
    }

    if (data.length === 0) {
        wrap.innerHTML = '<div class="empty-state" style="padding: 2rem; text-align: center;">No FAZ results found in cache.</div>';
        return;
    }

    let html = `<table class="dashboard-table" style="width: 100%; border-collapse: collapse; text-align: left;"><thead><tr style="border-bottom: 2px solid #dee2e6;">
        <th style="padding: 8px;">IP Address</th><th style="padding: 8px;">Fails</th><th style="padding: 8px;">Last Seen</th><th style="padding: 8px;">Severity</th>
      </tr></thead><tbody>`;

    data.forEach(r => {
        const sevLabel = r.count >= 500 ? 'CRITICAL' : r.count >= 100 ? 'HIGH' : 'MEDIUM';
        const sevClass = r.count >= 500 ? 'malicious' : r.count >= 100 ? 'suspicious' : 'clean';
        html += `<tr style="border-bottom: 1px solid #e9ecef;">
          <td style="padding: 8px; font-family: monospace; color: #0d6efd;">${r.ip}</td>
          <td style="padding: 8px;" class="${dashCountClass(r.count)}">${r.count.toLocaleString()}</td>
          <td style="padding: 8px; color: #6c757d; font-size: 0.8rem;">${r.last_seen ? r.last_seen.substring(5, 16) : '—'}</td>
          <td style="padding: 8px;"><span class="verdict-tag ${sevClass}">${sevLabel}</span></td>
        </tr>`;
    });

    html += '</tbody></table>';
    wrap.innerHTML = html;
}

let dashCountryChartInstance = null;

async function loadDashCountryChart() {
    const data = await fetchDashJson('dash_country');
    const canvas = document.getElementById('dashCountryChart');

    if (!data || data.length === 0) {
        canvas.parentElement.innerHTML = '<div class="empty-state" style="padding: 2rem; text-align: center;">No data available for chart</div>';
        return;
    }

    const rawTotalFails = data.reduce((sum, d) => sum + d.total_fails, 0);

    data.sort((a, b) => b.total_fails - a.total_fails);

    let labels = data.map(d => d.country);
    let values = data.map(d => d.total_fails);

    if (data.length > 15) {
        const topLabels = labels.slice(0, 14);
        const topValues = values.slice(0, 14);
        const otherFails = values.slice(14).reduce((a, b) => a + b, 0);
        topLabels.push('Others');
        topValues.push(otherFails);
        labels = topLabels;
        values = topValues;
    }

    const bgColors = [
        'rgba(220, 53, 69, 0.8)',   // danger
        'rgba(253, 126, 20, 0.8)',  // orange
        'rgba(25, 135, 84, 0.8)',   // success
        'rgba(13, 110, 253, 0.8)',  // primary
        'rgba(111, 66, 193, 0.8)',  // purple
        'rgba(13, 202, 240, 0.8)',  // info
        '#e63946', '#f4a261', '#e9c46a', '#2a9d8f', '#264653',
        '#8ecae6', '#219ebc', '#023047', '#ffb703', '#fb8500'
    ];

    if (dashCountryChartInstance) {
        dashCountryChartInstance.destroy();
    }

    const totalSum = values.reduce((a, b) => a + b, 0);

    const labelsWithPercentages = labels.map((lbl, i) => {
        const pct = ((values[i] / totalSum) * 100).toFixed(1);
        return `${lbl} (${pct}%)`;
    });

    dashCountryChartInstance = new Chart(canvas, {
        type: 'pie',
        data: {
            labels: labelsWithPercentages,
            datasets: [{
                data: values,
                backgroundColor: bgColors.slice(0, labels.length),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: { font: { size: 12 } }
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const val = context.parsed;
                            const percentage = ((val / totalSum) * 100).toFixed(1) + '%';
                            return `  ${val.toLocaleString()} Attempts (${percentage})`;
                        }
                    }
                }
            }
        }
    });
}

let dashCountryTimelineInstance = null;

async function loadDashCountryTimeline() {
    const data = await fetchDashJson('dash_country_timeline');
    const canvas = document.getElementById('dashCountryTimelineChart');
    const title = document.getElementById('dashCountryTimelineTitle');

    if (!data || !data.datasets || data.datasets.length === 0) {
        canvas.parentElement.innerHTML = '<div class="empty-state" style="padding: 2rem; text-align: center;">No timeline data available</div>';
        if (dashCountryTimelineInstance) dashCountryTimelineInstance.destroy();
        return;
    }

    if (title) {
        title.textContent = `📉 Top 10 Attack Countries Timeline - Last ${currentDashPeriodStr}`;
    }

    const bgColors = [
        'rgba(220, 53, 69, 0.8)',   // danger
        'rgba(253, 126, 20, 0.8)',  // orange
        'rgba(25, 135, 84, 0.8)',   // success
        'rgba(13, 110, 253, 0.8)',  // primary
        'rgba(111, 66, 193, 0.8)',  // purple
        'rgba(13, 202, 240, 0.8)',  // info
        'rgba(230, 57, 70, 0.8)', 'rgba(244, 162, 97, 0.8)', 'rgba(233, 196, 106, 0.8)', 'rgba(42, 157, 143, 0.8)'
    ];

    data.datasets.forEach((dataset, i) => {
        dataset.backgroundColor = bgColors[i % bgColors.length];
        dataset.borderWidth = 1;
        dataset.borderColor = '#1a1d28';
    });

    if (dashCountryTimelineInstance) {
        dashCountryTimelineInstance.destroy();
    }

    dashCountryTimelineInstance = new Chart(canvas, {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { stacked: true },
                y: { stacked: true, beginAtZero: true }
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 12 } }
                }
            }
        }
    });
}

// FAZ Collection Logic
let eventSource = null;
let ansiOpenSpans = 0;

const ansiColorMap = {
    '1': 'font-weight:bold;',
    '31': 'color:#f74f6f;',
    '32': 'color:#2dd4a8;',
    '33': 'color:#f7a84f;',
    '34': 'color:#4f8ff7;',
    '35': 'color:#7c5cfc;',
    '36': 'color:#4fc3f7;',
    '91': 'color:#ff7999;',
    '92': 'color:#5ef4ce;',
    '93': 'color:#ffcc80;',
    '94': 'color:#80bfff;',
    '95': 'color:#b39ddb;',
    '96': 'color:#80deea;'
};

function parseANSIColor(text) {
    text = text.replace(/</g, "&lt;").replace(/>/g, "&gt;");
    return text.replace(/\x1b\[(\d+)m/g, (match, p1) => {
        if (p1 === '0') {
            let closes = '</span>'.repeat(ansiOpenSpans);
            ansiOpenSpans = 0;
            return closes;
        } else if (ansiColorMap[p1]) {
            ansiOpenSpans++;
            return `<span style="${ansiColorMap[p1]}">`;
        }
        return '';
    });
}

function triggerFazCollection() {
    console.log('[FAZ] triggerFazCollection() called');
    if (eventSource) {
        console.log('[FAZ] Aborted: eventSource already active');
        return;
    }

    const logModal = document.getElementById('logModal');
    const logOutput = document.getElementById('logOutput');
    const btnCollect = document.getElementById('btnCollectFaz');

    // Debug: check elements exist
    console.log('[FAZ] logModal:', logModal);
    console.log('[FAZ] logOutput:', logOutput);
    console.log('[FAZ] btnCollect:', btnCollect);

    if (!logModal) {
        console.error('[FAZ] FATAL: logModal element not found!');
        alert('Error: logModal element not found in HTML. Check browser console.');
        return;
    }
    if (!logOutput) {
        console.error('[FAZ] FATAL: logOutput element not found!');
        alert('Error: logOutput element not found in HTML. Check browser console.');
        return;
    }

    // Show modal
    logModal.style.display = 'flex';
    console.log('[FAZ] Modal display set to flex');

    // Build debug header
    let days = getAnalysisDays();
    const sseUrl = `api_run_analysis.php?days=${days}`;
    const fullUrl = new URL(sseUrl, window.location.href).href;

    logOutput.innerHTML = '';
    logOutput.innerHTML += '<span style="color:#4fc3f7;">[DEBUG] ======================================</span>\n';
    logOutput.innerHTML += '<span style="color:#4fc3f7;">[DEBUG] FAZ Collection Started</span>\n';
    logOutput.innerHTML += '<span style="color:#4fc3f7;">[DEBUG] Time: ' + new Date().toLocaleString() + '</span>\n';
    logOutput.innerHTML += '<span style="color:#4fc3f7;">[DEBUG] Days: ' + days + '</span>\n';
    logOutput.innerHTML += '<span style="color:#4fc3f7;">[DEBUG] SSE URL (relative): ' + sseUrl + '</span>\n';
    logOutput.innerHTML += '<span style="color:#4fc3f7;">[DEBUG] SSE URL (resolved): ' + fullUrl + '</span>\n';
    logOutput.innerHTML += '<span style="color:#4fc3f7;">[DEBUG] Page URL: ' + window.location.href + '</span>\n';
    logOutput.innerHTML += '<span style="color:#4fc3f7;">[DEBUG] ======================================</span>\n';
    logOutput.innerHTML += '<span style="color:#f7a84f;">[INFO] Connecting to SSE endpoint...</span>\n';

    if (btnCollect) btnCollect.disabled = true;

    ansiOpenSpans = 0;

    try {
        eventSource = new EventSource(sseUrl);
        console.log('[FAZ] EventSource created:', sseUrl);
        logOutput.innerHTML += '<span style="color:#2dd4a8;">[OK] EventSource created successfully</span>\n';
    } catch (err) {
        console.error('[FAZ] EventSource creation FAILED:', err);
        logOutput.innerHTML += '<span style="color:#f74f6f;">[ERROR] EventSource creation failed: ' + err.message + '</span>\n';
        if (btnCollect) btnCollect.disabled = false;
        return;
    }

    eventSource.onopen = function () {
        console.log('[FAZ] SSE connection opened');
        logOutput.innerHTML += '<span style="color:#2dd4a8;">[OK] SSE connection established</span>\n';
        logOutput.innerHTML += '<span style="color:#f7a84f;">[INFO] Waiting for server output...</span>\n\n';
    };

    eventSource.onmessage = function (e) {
        console.log('[FAZ] SSE message received:', e.data);
        try {
            const data = JSON.parse(e.data);
            if (data.type === 'log') {
                logOutput.innerHTML += parseANSIColor(data.msg) + '\n';
                logOutput.scrollTop = logOutput.scrollHeight;
            } else if (data.type === 'error') {
                logOutput.innerHTML += '<span style="color:#f74f6f;">ERROR: ' + parseANSIColor(data.msg) + '</span>\n';
            } else if (data.type === 'done') {
                logOutput.innerHTML += '\n<span style="color:#2dd4a8;font-weight:bold;">' + parseANSIColor(data.msg) + '</span>\n';
                logOutput.innerHTML += '<span style="color:#4fc3f7;">[DEBUG] Collection completed at ' + new Date().toLocaleString() + '</span>\n';
                stopCollection();
                refreshDashboard();
            } else {
                logOutput.innerHTML += '<span style="color:#7c5cfc;">[UNKNOWN TYPE] ' + JSON.stringify(data) + '</span>\n';
            }
        } catch (err) {
            console.error('[FAZ] Parse error:', err, 'Raw data:', e.data);
            logOutput.innerHTML += '<span style="color:#f74f6f;">[PARSE ERROR] ' + err.message + '</span>\n';
            logOutput.innerHTML += '<span style="color:#8b8fa3;">[RAW DATA] ' + e.data.replace(/</g, '&lt;') + '</span>\n';
        }
    };

    eventSource.onerror = function (e) {
        console.error('[FAZ] SSE Error:', e);
        const readyState = eventSource ? eventSource.readyState : 'N/A';
        const stateNames = { 0: 'CONNECTING', 1: 'OPEN', 2: 'CLOSED' };
        logOutput.innerHTML += '\n<span style="color:#f74f6f;">[SSE ERROR] Connection error or closed</span>\n';
        logOutput.innerHTML += '<span style="color:#f74f6f;">[SSE ERROR] ReadyState: ' + readyState + ' (' + (stateNames[readyState] || 'UNKNOWN') + ')</span>\n';
        logOutput.innerHTML += '<span style="color:#f7a84f;">[TIP] Check browser Network tab (F12) for HTTP status of api_run_analysis.php</span>\n';
        logOutput.innerHTML += '<span style="color:#f7a84f;">[TIP] Check browser Console tab for more details</span>\n';
        stopCollection();
    };
}


function stopCollection() {
    if (eventSource) {
        eventSource.close();
        eventSource = null;
    }
    const btnCollect = document.getElementById('btnCollectFaz');
    if (btnCollect) btnCollect.disabled = false;
}

function closeLogModal() {
    if (eventSource) {
        if (!confirm('Analysis is still running. Are you sure you want to stop monitoring? (Process continues in background)')) {
            return;
        }
        stopCollection();
    }
    const logModal = document.getElementById('logModal');
    if (logModal) logModal.style.display = 'none';
}

async function loadTestData() {
    const btn = document.getElementById('btnLoadTestData');
    if (btn) btn.disabled = true;

    try {
        const resp = await fetch(`${API_URL}?action=dash_load_test`);
        const data = await resp.json();
        if (data.success) {
            alert(`✅ Test data loaded: ${data.total_events} events inserted.`);
            refreshDashboard();
        } else {
            alert(`❌ Error: ${data.error || 'Unknown error'}`);
        }
    } catch (e) {
        alert(`❌ Network Error: ${e.message}`);
    } finally {
        if (btn) btn.disabled = false;
    }
}

async function clearTestData() {
    if (!confirm('Are you sure you want to clear test data?')) return;

    const btn = document.getElementById('btnClearTestData');
    if (btn) btn.disabled = true;

    try {
        const resp = await fetch(`${API_URL}?action=dash_clear_test`);
        const data = await resp.json();
        if (data.success) {
            alert('✅ Test data cleared.');
            refreshDashboard();
        } else {
            alert(`❌ Error: ${data.error || 'Unknown error'}`);
        }
    } catch (e) {
        alert(`❌ Network Error: ${e.message}`);
    } finally {
        if (btn) btn.disabled = false;
    }
}

// ============================================================================
// Phase 4: New dashboard functions (Block_IP_20260305 integration)
// ============================================================================

/* ── Device Filter Dropdown Population ─────────────────────────── */
async function loadDashDevices() {
    const sel = document.getElementById('deviceFilter');
    if (!sel) return;
    try {
        const resp = await fetch(`${API_URL}?action=dash_devices`);
        const data = await resp.json();
        if (!Array.isArray(data)) return;
        const cur = sel.value;
        // Rebuild options keeping saved value
        sel.innerHTML = '<option value="">All Devices</option>';
        data.forEach(d => {
            const opt = document.createElement('option');
            opt.value = d;
            opt.textContent = d;
            if (d === cur) opt.selected = true;
            sel.appendChild(opt);
        });
    } catch (e) {
        console.warn('loadDashDevices error:', e);
    }
}

/* ── Device Timeline Table ─────────────────────────────────────── */
let _lastDeviceTimeline = null; // for CSV export

async function loadDashDeviceTimeline() {
    const wrap = document.getElementById('dashDeviceTimelineWrap');
    if (!wrap) return;
    wrap.innerHTML = '<div class="loading-spinner"></div> Loading...';

    const data = await fetchDashJson('dash_device_timeline');
    _lastDeviceTimeline = data;

    if (!data || data.error || !data.days || data.days.length === 0) {
        wrap.innerHTML = '<p style="color:#8b8fa3;text-align:center;padding:1rem;">No device timeline data available.</p>';
        return;
    }

    const { days, devices } = data;
    let html = `<table style="width:100%;border-collapse:collapse;font-size:0.82rem;min-width:${100 + days.length * 80}px">
        <thead>
            <tr style="position:sticky;top:0;background:var(--bg-card,#1a1d28);z-index:1;">
                <th style="padding:0.4rem 0.6rem;text-align:left;border-bottom:1px solid #2a2e3e;">Device</th>
                ${days.map(d => `<th style="padding:0.4rem 0.5rem;text-align:right;border-bottom:1px solid #2a2e3e;">${d.slice(5)}</th>`).join('')}
                <th style="padding:0.4rem 0.6rem;text-align:right;border-bottom:1px solid #2a2e3e;font-weight:bold;">Total</th>
            </tr>
        </thead>
        <tbody>`;

    devices.forEach((dev, i) => {
        const bg = i % 2 === 0 ? '' : 'background:rgba(255,255,255,0.03);';
        html += `<tr style="${bg}">
            <td style="padding:0.35rem 0.6rem;font-weight:600;">${dev.name}</td>
            ${days.map(d => {
            const v = dev.data[d] || 0;
            const color = v >= 1000 ? '#f74f6f' : v >= 100 ? '#f7a84f' : '';
            return `<td style="padding:0.35rem 0.5rem;text-align:right;${color ? `color:${color};font-weight:bold;` : ''}">${v > 0 ? v.toLocaleString() : '—'}</td>`;
        }).join('')}
            <td style="padding:0.35rem 0.6rem;text-align:right;font-weight:bold;color:#2dd4a8;">${dev.total.toLocaleString()}</td>
        </tr>`;
    });

    // Totals row
    const totals = days.map(d => devices.reduce((s, dev) => s + (dev.data[d] || 0), 0));
    html += `<tr style="border-top:2px solid #2a2e3e;font-weight:bold;background:rgba(124,92,252,0.1);">
        <td style="padding:0.35rem 0.6rem;">Total</td>
        ${totals.map(t => `<td style="padding:0.35rem 0.5rem;text-align:right;">${t > 0 ? t.toLocaleString() : '—'}</td>`).join('')}
        <td style="padding:0.35rem 0.6rem;text-align:right;color:#7c5cfc;">${totals.reduce((a, b) => a + b, 0).toLocaleString()}</td>
    </tr>`;
    html += '</tbody></table>';
    wrap.innerHTML = html;
}

/* ── AD User Status Table ─────────────────────────────────────── */
let _lastAdStatus = null;

async function loadDashAdStatus() {
    const wrap = document.getElementById('dashAdStatusWrap');
    if (!wrap) return;
    wrap.innerHTML = '<div class="loading-spinner"></div> Loading...';

    const data = await fetchDashJson('dash_ad_status');
    _lastAdStatus = data;

    if (!data || data.error || data.length === 0) {
        const msg = (data && data.error) ? data.error : 'No AD user data available.';
        wrap.innerHTML = `<p style="color:#8b8fa3;text-align:center;padding:1rem;">${msg}</p>`;
        return;
    }

    let html = `<table style="width:100%;border-collapse:collapse;font-size:0.78rem;">
        <thead>
            <tr style="background:var(--bg-card,#1a1d28);">
                <th style="padding:0.35rem;text-align:left;">Username</th>
                <th style="padding:0.35rem;text-align:right;"># Fails</th>
                <th style="padding:0.35rem;text-align:left;">Devices</th>
                <th style="padding:0.35rem;text-align:left;">Duration</th>
                <th style="padding:0.35rem;text-align:left;">Locked</th>
                <th style="padding:0.35rem;text-align:left;">Dept</th>
            </tr>
        </thead><tbody>`;

    data.forEach((r, i) => {
        const bg = i % 2 ? 'background:rgba(255,255,255,0.03);' : '';
        const locked = r.LockedOut === 'True' ? '<span style="color:#f74f6f;font-weight:bold;">🔒 Yes</span>' : '—';
        html += `<tr style="${bg}">
            <td style="padding:0.3rem;font-weight:600;">${r.Username}</td>
            <td style="padding:0.3rem;text-align:right;color:#f7a84f;font-weight:bold;">${(+r.fail_count).toLocaleString()}</td>
            <td style="padding:0.3rem;font-size:0.72rem;color:#8b8fa3;">${r.target_devices || '—'}</td>
            <td style="padding:0.3rem;font-size:0.72rem;">${r.duration || '—'}</td>
            <td style="padding:0.3rem;">${locked}</td>
            <td style="padding:0.3rem;font-size:0.72rem;">${r.OU_Dept || '—'}</td>
        </tr>`;
    });
    html += '</tbody></table>';
    wrap.innerHTML = html;
}

/* ── Non-AD User Status Table ─────────────────────────────────── */
let _lastNonAdStatus = null;

async function loadDashNonAdStatus() {
    const wrap = document.getElementById('dashNonAdStatusWrap');
    if (!wrap) return;
    wrap.innerHTML = '<div class="loading-spinner"></div> Loading...';

    const data = await fetchDashJson('dash_non_ad_status');
    _lastNonAdStatus = data;

    if (!data || data.error || data.length === 0) {
        const msg = (data && data.error) ? data.error : 'No Non-AD user data available.';
        wrap.innerHTML = `<p style="color:#8b8fa3;text-align:center;padding:1rem;">${msg}</p>`;
        return;
    }

    let html = `<table style="width:100%;border-collapse:collapse;font-size:0.78rem;">
        <thead>
            <tr style="background:var(--bg-card,#1a1d28);">
                <th style="padding:0.35rem;text-align:left;">Username</th>
                <th style="padding:0.35rem;text-align:right;"># Fails</th>
                <th style="padding:0.35rem;text-align:left;">Devices</th>
                <th style="padding:0.35rem;text-align:left;">Duration</th>
            </tr>
        </thead><tbody>`;

    data.forEach((r, i) => {
        const bg = i % 2 ? 'background:rgba(255,255,255,0.03);' : '';
        html += `<tr style="${bg}">
            <td style="padding:0.3rem;font-weight:600;">${r.Username}</td>
            <td style="padding:0.3rem;text-align:right;color:#f7a84f;font-weight:bold;">${(+r.fail_count).toLocaleString()}</td>
            <td style="padding:0.3rem;font-size:0.72rem;color:#8b8fa3;">${r.target_devices || '—'}</td>
            <td style="padding:0.3rem;font-size:0.72rem;">${r.duration || '—'}</td>
        </tr>`;
    });
    html += '</tbody></table>';
    wrap.innerHTML = html;
}

/* ── Device Bar Chart ─────────────────────────────────────────── */
let dashDeviceChartInst = null;
const CHART_COLORS = [
    '#7c5cfc', '#2dd4a8', '#f7a84f', '#f74f6f', '#4fc3f7',
    '#ff9f40', '#9966ff', '#22c55e', '#ef4444', '#3b82f6'
];

async function loadDashDeviceChart() {
    const canvas = document.getElementById('dashDeviceChart');
    if (!canvas) return;

    const data = await fetchDashJson('dash_device_stats');
    if (!data || data.error || data.length === 0) {
        canvas.parentElement.innerHTML = '<p style="color:#8b8fa3;text-align:center;padding:1rem;">No device data available.</p>';
        return;
    }

    const labels = data.map(r => r.devname);
    const values = data.map(r => r.fail_count);

    if (dashDeviceChartInst) { dashDeviceChartInst.destroy(); dashDeviceChartInst = null; }
    dashDeviceChartInst = new Chart(canvas.getContext('2d'), {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Failed Attempts',
                data: values,
                backgroundColor: labels.map((_, i) => CHART_COLORS[i % CHART_COLORS.length] + 'cc'),
                borderColor: labels.map((_, i) => CHART_COLORS[i % CHART_COLORS.length]),
                borderWidth: 1,
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { maxRotation: 30, font: { size: 10 } } },
                y: { beginAtZero: true }
            }
        }
    });
}

/* ── User × Device Stacked Bar Chart ─────────────────────────── */
let dashUserChartInst = null;

async function loadDashUserChart() {
    const canvas = document.getElementById('dashUserChart');
    if (!canvas) return;

    const data = await fetchDashJson('dash_user_timeline');
    if (!data || data.error || !data.labels || data.labels.length === 0) {
        canvas.parentElement.innerHTML = '<p style="color:#8b8fa3;text-align:center;padding:1rem;">No user data available (user column may not exist in faz_raw_events).</p>';
        return;
    }

    const datasets = data.datasets.map((ds, i) => ({
        ...ds,
        backgroundColor: CHART_COLORS[i % CHART_COLORS.length] + 'cc',
        borderColor: CHART_COLORS[i % CHART_COLORS.length],
        borderWidth: 1,
    }));

    if (dashUserChartInst) { dashUserChartInst.destroy(); dashUserChartInst = null; }
    dashUserChartInst = new Chart(canvas.getContext('2d'), {
        type: 'bar',
        data: { labels: data.labels, datasets },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { font: { size: 10 } } } },
            scales: {
                x: { stacked: true, ticks: { maxRotation: 30, font: { size: 10 } } },
                y: { stacked: true, beginAtZero: true }
            }
        }
    });
}

/* ── CSV Helpers ──────────────────────────────────────────────── */
function arrayToCsv(headers, rows) {
    const escape = v => {
        if (v == null) return '';
        const s = String(v).replace(/<br\s*\/?>/gi, ' ');
        return /[",\n]/.test(s) ? `"${s.replace(/"/g, '""')}"` : s;
    };
    const lines = [headers.map(escape).join(',')];
    rows.forEach(r => lines.push(r.map(escape).join(',')));
    return lines.join('\r\n');
}

function downloadCsv(csvContent, filename) {
    const bom = '\uFEFF'; // UTF-8 BOM for Excel compatibility
    const blob = new Blob([bom + csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    setTimeout(() => { document.body.removeChild(a); URL.revokeObjectURL(url); }, 200);
}

function exportDeviceTimelineToCSV() {
    if (!_lastDeviceTimeline || !_lastDeviceTimeline.days || !_lastDeviceTimeline.devices) {
        alert('No device timeline data loaded yet.'); return;
    }
    const { days, devices } = _lastDeviceTimeline;
    const headers = ['Device', ...days, 'Total'];
    const rows = devices.map(dev => [dev.name, ...days.map(d => dev.data[d] || 0), dev.total]);
    downloadCsv(arrayToCsv(headers, rows), `device_timeline_${new Date().toISOString().slice(0, 10)}.csv`);
}

function exportAdStatusToCSV() {
    if (!_lastAdStatus || !Array.isArray(_lastAdStatus) || _lastAdStatus.length === 0) {
        alert('No AD user data loaded yet.'); return;
    }
    const headers = ['Username', 'FailCount', 'Devices', 'Duration', 'ExistsInAD', 'OU_Dept', 'LockedOut', 'PasswordExpired', 'LastPasswordChange', 'LastLogon'];
    const rows = _lastAdStatus.map(r => [r.Username, r.fail_count, r.target_devices, r.duration, r.ExistsInAD, r.OU_Dept, r.LockedOut, r.PasswordExpired, r.LastPasswordChange, r.LastLogon]);
    downloadCsv(arrayToCsv(headers, rows), `ad_users_${new Date().toISOString().slice(0, 10)}.csv`);
}

function exportNonAdStatusToCSV() {
    if (!_lastNonAdStatus || !Array.isArray(_lastNonAdStatus) || _lastNonAdStatus.length === 0) {
        alert('No Non-AD user data loaded yet.'); return;
    }
    const headers = ['Username', 'FailCount', 'Devices', 'Duration'];
    const rows = _lastNonAdStatus.map(r => [r.Username, r.fail_count, r.target_devices, r.duration]);
    downloadCsv(arrayToCsv(headers, rows), `non_ad_users_${new Date().toISOString().slice(0, 10)}.csv`);
}

/* ── DOMContentLoaded init ────────────────────────────────────── */
document.addEventListener('DOMContentLoaded', function () {
    // Populate device filter dropdown asynchronously on page load
    loadDashDevices();
});
