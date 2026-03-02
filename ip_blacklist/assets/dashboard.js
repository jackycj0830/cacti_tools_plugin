// Security Dashboard JS logic
// Ported from Block_IP_20260223 Dashboard

function getAnalysisDays() {
    return document.getElementById('analysisDays').value || 7;
}

function refreshDashboard() {
    Promise.all([
        loadDashStats(),
        loadDashBlacklist(),
        loadDashFaz(),
        loadDashCountryChart(),
        loadDashCountryTimeline()
    ]).catch(err => console.error('Dashboard refresh error:', err));
}

async function fetchDashJson(action) {
    try {
        const days = getAnalysisDays();
        const response = await fetch(`${API_URL}?action=${action}&days=${days}`);
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
    if (eventSource) return;

    const logModal = document.getElementById('logModal');
    const logOutput = document.getElementById('logOutput');
    const btnCollect = document.getElementById('btnCollectFaz');

    logModal.style.display = 'flex';
    logOutput.textContent = 'Starting analysis...\n';
    if (btnCollect) btnCollect.disabled = true;

    // Defaulting to 7 days for the dashboard if not explicitly provided
    let days = getAnalysisDays();

    ansiOpenSpans = 0;
    eventSource = new EventSource(`api_run_analysis.php?days=${days}`);

    eventSource.onmessage = function (e) {
        try {
            const data = JSON.parse(e.data);
            if (data.type === 'log') {
                logOutput.innerHTML += parseANSIColor(data.msg);
                logOutput.scrollTop = logOutput.scrollHeight;
            } else if (data.type === 'error') {
                logOutput.innerHTML += '<span style="color:#f74f6f;">ERROR: ' + parseANSIColor(data.msg) + '</span>\n';
            } else if (data.type === 'done') {
                logOutput.innerHTML += '\n' + parseANSIColor(data.msg) + '\n';
                stopCollection();
                refreshDashboard();
            }
        } catch (err) {
            console.error('Parse error', err);
        }
    };

    eventSource.onerror = function (e) {
        console.error('SSE Error', e);
        logOutput.textContent += '\nConnection closed or error occurred.\n';
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
