<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Block_IP — SSLVPN Security Dashboard</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<style>
:root {
  --bg-primary: #0f1117;
  --bg-card: #1a1d28;
  --bg-card-hover: #222636;
  --border: #2a2e3e;
  --text: #e4e6f0;
  --text-dim: #8b8fa3;
  --accent-blue: #4f8ff7;
  --accent-purple: #7c5cfc;
  --accent-green: #2dd4a8;
  --accent-red: #f74f6f;
  --accent-orange: #f7a84f;
  --accent-cyan: #4fc3f7;
  --glow-blue: rgba(79,143,247,0.15);
  --glow-red: rgba(247,79,111,0.15);
  --glow-green: rgba(45,212,168,0.15);
}
* { box-sizing: border-box; margin: 0; padding: 0; }
body {
  font-family: 'Inter', -apple-system, sans-serif;
  background: var(--bg-primary);
  color: var(--text);
  line-height: 1.6;
  min-height: 100vh;
}

/* Header */
.header {
  background: linear-gradient(135deg, #141722 0%, #1e2235 100%);
  border-bottom: 1px solid var(--border);
  padding: 1.5rem 2rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.header h1 {
  font-size: 1.5rem;
  font-weight: 700;
  background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.header .subtitle {
  color: var(--text-dim);
  font-size: 0.85rem;
}
.header .last-update {
  color: var(--text-dim);
  font-size: 0.8rem;
  text-align: right;
}

.container { max-width: 1400px; margin: 0 auto; padding: 2rem; }

/* Workflow Section */
.section-title {
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 1rem;
  color: var(--text);
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
.section-title .icon { font-size: 1.2rem; }

.workflow {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0;
  margin-bottom: 2rem;
  padding: 1.5rem;
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 16px;
  overflow-x: auto;
}
.wf-step {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
  padding: 1rem 1.5rem;
  border-radius: 12px;
  min-width: 150px;
  text-align: center;
  transition: transform 0.2s, box-shadow 0.2s;
  position: relative;
}
.wf-step:hover { transform: translateY(-3px); }
.wf-step .step-icon {
  font-size: 1.5rem;
  width: 48px;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 12px;
  margin-bottom: 0.25rem;
}
.wf-step .step-value {
  font-size: 1.8rem;
  font-weight: 700;
  margin: 0.25rem 0;
  line-height: 1;
}
.wf-step .step-label { font-size: 0.75rem; color: var(--text-dim); text-transform: uppercase; font-weight: 600; }
.wf-step.faz .step-icon { background: var(--glow-blue); color: var(--accent-blue); }
.wf-step.filter .step-icon { background: rgba(247,168,79,0.15); color: var(--accent-orange); }
.wf-step.vt .step-icon { background: rgba(124,92,252,0.15); color: var(--accent-purple); }
.wf-step.blacklist .step-icon { background: var(--glow-red); color: var(--accent-red); }

/* Color defaults for values */
.wf-step .step-value { color: var(--text); }
.wf-step:nth-child(1) .step-value { color: var(--accent-red); } /* Total Fails */
.wf-step:nth-child(3) .step-value { color: var(--accent-blue); } /* Unique IPs */
.wf-step:nth-child(5) .step-value { color: var(--accent-orange); } /* Targets */
.wf-step:nth-child(7) .step-value { color: var(--accent-green); } /* Blacklist */
.wf-arrow {
  font-size: 1.5rem;
  color: var(--text-dim);
  padding: 0 0.5rem;
  flex-shrink: 0;
}

/* Stats Grid */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
  margin-bottom: 2rem;
}
.stat-card {
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 14px;
  padding: 1.25rem;
  transition: border-color 0.3s, box-shadow 0.3s;
}
.stat-card:hover { border-color: var(--accent-blue); box-shadow: 0 0 20px var(--glow-blue); }
.stat-card .stat-label { font-size: 0.75rem; color: var(--text-dim); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
.stat-card .stat-value { font-size: 2rem; font-weight: 700; }
.stat-card .stat-sub { font-size: 0.75rem; color: var(--text-dim); margin-top: 0.25rem; }
.stat-card.red .stat-value { color: var(--accent-red); }
.stat-card.orange .stat-value { color: var(--accent-orange); }
.stat-card.green .stat-value { color: var(--accent-green); }
.stat-card.blue .stat-value { color: var(--accent-blue); }
.stat-card.purple .stat-value { color: var(--accent-purple); }
.stat-card.cyan .stat-value { color: var(--accent-cyan); }

/* Tables */
.table-section {
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 14px;
  margin-bottom: 2rem;
  overflow: hidden;
}
.table-header {
  padding: 1rem 1.25rem;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.table-header h3 { font-size: 0.95rem; font-weight: 600; }
.table-header .badge {
  font-size: 0.7rem;
  font-weight: 600;
  padding: 0.2rem 0.6rem;
  border-radius: 20px;
  background: var(--glow-red);
  color: var(--accent-red);
}
.table-header .badge.blue { background: var(--glow-blue); color: var(--accent-blue); }
.table-header .badge.green { background: var(--glow-green); color: var(--accent-green); }
table { width: 100%; border-collapse: collapse; }
thead th {
  text-align: center;
  padding: 0.75rem 1rem;
  font-size: 0.7rem;
  font-weight: 600;
  color: var(--text-dim);
  text-transform: uppercase;
  letter-spacing: 0.05em;
  border-bottom: 1px solid var(--border);
  position: sticky;
  top: 0;
  background: var(--bg-card);
}
tbody td {
  text-align: center;
  padding: 0.65rem 1rem;
  font-size: 0.85rem;
  border-bottom: 1px solid rgba(42,46,62,0.5);
}
tbody tr { transition: background 0.15s; }
tbody tr:hover { background: var(--bg-card-hover); }
tbody tr:last-child td { border-bottom: none; }

.verdict-tag {
  display: inline-block;
  font-size: 0.7rem;
  font-weight: 600;
  padding: 0.15rem 0.5rem;
  border-radius: 6px;
  text-transform: uppercase;
}
.verdict-tag.malicious { background: var(--glow-red); color: var(--accent-red); }
.verdict-tag.suspicious { background: rgba(247,168,79,0.15); color: var(--accent-orange); }
.verdict-tag.clean { background: var(--glow-green); color: var(--accent-green); }

.ip-cell { font-family: 'JetBrains Mono', 'Fira Code', monospace; font-weight: 500; color: var(--accent-cyan); }
.count-cell { font-weight: 600; }
.count-cell.high { color: var(--accent-red); }

.table-scroll { max-height: 400px; overflow-y: auto; }
.table-scroll::-webkit-scrollbar { width: 6px; }
.table-scroll::-webkit-scrollbar-track { background: transparent; }
.table-scroll::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }

.loading {
  text-align: center;
  padding: 3rem;
  color: var(--text-dim);
  font-size: 0.9rem;
}
.loading .spinner {
  display: inline-block;
  width: 28px;
  height: 28px;
  border: 3px solid var(--border);
  border-top-color: var(--accent-blue);
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
  margin-bottom: 0.5rem;
}
@keyframes spin { to { transform: rotate(360deg); } }
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
.fade-in { animation: fadeIn 0.5s ease-out forwards; }

.two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
@media (max-width: 900px) {
  .two-col { grid-template-columns: 1fr; }
  .workflow { flex-wrap: wrap; gap: 0.5rem; }
}

.empty-state { text-align: center; padding: 2rem; color: var(--text-dim); font-size: 0.85rem; }

/* Collect Button */
.btn-collect {
  background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
  color: white;
  border: none;
  padding: 0.6rem 1.2rem;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.85rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  transition: opacity 0.2s, transform 0.2s;
}
.btn-collect:hover { opacity: 0.9; transform: translateY(-1px); }
.btn-collect:active { transform: translateY(0); }
.btn-collect:disabled { opacity: 0.6; cursor: wait; }

/* Modal */
.modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.7);
  backdrop-filter: blur(4px);
  z-index: 1000;
  display: flex;
  align-items: center;
  justify-content: center;
}
.modal-window {
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 12px;
  width: 90%;
  max-width: 800px;
  height: 80vh;
  display: flex;
  flex-direction: column;
  box-shadow: 0 10px 40px rgba(0,0,0,0.5);
}
.modal-header {
  padding: 1rem 1.5rem;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.modal-header h3 { font-size: 1rem; color: var(--text); }
.modal-close {
  background: none; border: none; color: var(--text-dim);
  font-size: 1.5rem; cursor: pointer; padding: 0 0.5rem;
}
.modal-close:hover { color: var(--text); }

.modal-body {
  flex: 1;
  padding: 0;
  overflow: hidden;
  background: #0d0f14;
  display: flex;
}
.modal-body pre {
  width: 100%;
  height: 100%;
  padding: 1rem;
  overflow: auto;
  font-family: 'JetBrains Mono', 'Fira Code', monospace;
  font-size: 0.8rem;
  color: #c9d1d9;
  white-space: pre-wrap;
  word-wrap: break-word;
}
</style>
</head>
<body>

<div class="header">
  <div>
    <h1>🛡️ Block_IP Security Dashboard</h1>
    <div class="subtitle">FortiAnalyzer SSLVPN Brute-Force IP Analysis</div>
  </div>
  <div class="header-right">
    <!-- Moved controls to workflow section -->
  </div>
</div>

<!-- Log Modal -->
<div id="logModal" class="modal-overlay" style="display: none;">
  <div class="modal-window">
    <div class="modal-header">
      <h3>🚀 Executing Analysis...</h3>
      <button class="modal-close" onclick="closeModal()">×</button>
    </div>
    <div class="modal-body">
      <pre id="logOutput"></pre>
    </div>
  </div>
</div>

<div class="container">

  <!-- Workflow -->
  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
    <div class="section-title" style="margin-bottom: 0;"><span class="icon">⚡</span> Analysis Workflow</div>
    <div style="display: flex; gap: 1rem; align-items: center;">
      <div class="last-update" id="lastUpdate" style="margin-top: 0;">Loading...</div>
      <div style="display: flex; gap: 0.5rem; align-items: center;">
        <select id="analysisDays" class="btn-collect" style="background: var(--bg-card); color: var(--text); border: 1px solid var(--border); padding-right: 1.5rem; appearance: auto;" onchange="toggleCustomDays(); refreshDashboard();">
          <option value="1">Last 1 Day</option>
          <option value="2">Last 2 Days</option>
          <option value="4">Last 4 Days</option>
          <option value="7" selected>Last 1 Week</option>
          <option value="14">Last 2 Weeks</option>
          <option value="28">Last 4 Weeks</option>
          <option value="custom">Custom (Days)</option>
        </select>
        <input type="number" id="customDays" class="btn-collect" style="display: none; width: 70px; background: var(--bg-card); color: var(--text); border: 1px solid var(--border);" min="1" max="28" placeholder="Days">
        <button id="btnCollect" class="btn-collect" onclick="startCollection()">
          <span class="icon">⚡</span> Collect from FAZ now
        </button>
      </div>
    </div>
  </div>
  <div class="workflow">
    <div class="wf-step">
      <div class="step-icon">📉</div>
      <div class="step-value" id="wfTotalFails">—</div>
      <div class="step-label">Total Events</div>
    </div>
    <div class="wf-arrow">→</div>
    <div class="wf-step">
      <div class="step-icon">🌐</div>
      <div class="step-value" id="wfTotalIps">—</div>
      <div class="step-label">Unique IPs</div>
    </div>
    <div class="wf-arrow">→</div>
    <div class="wf-step filter">
      <div class="step-icon">🎯</div>
      <div class="step-value" id="wfFilterCount">—</div>
      <div class="step-label">Targets</div>
      <div class="step-label" id="targetPeriodLabel" style="font-size: 0.65rem; color: #8b8fa3; margin-top: 0.2rem;">(≥ 50 / Period)</div>
    </div>
    <div class="wf-arrow">→</div>
    <div class="wf-step blacklist">
      <div class="step-icon">🚫</div>
      <div class="step-value" id="wfBlCount">—</div>
      <div class="step-label">Blacklist</div>
      <div class="step-label" style="font-size: 0.65rem; color: #8b8fa3; margin-top: 0.2rem;">(≥ 3 Security Vendors)</div>
    </div>
  </div>

  <!-- Stats cards deleted -->

  <!-- Tables -->
  <div class="two-col">
    <!-- Realtime FAZ Table (Moved to Left) -->
    <div class="table-section fade-in">
      <div class="table-header">
        <h3 id="realtimeTitle">📡 Realtime FAZ Results (Loading...)</h3>
        <span class="badge blue" id="fazBadge">0</span>
      </div>
      <div class="table-scroll" id="fazTableWrap">
        <div class="loading"><div class="spinner"></div><br>Loading FAZ results...</div>
      </div>
    </div>

    <!-- Blacklist Table (Moved to Right) -->
    <div class="table-section fade-in">
      <div class="table-header">
        <h3 id="maliciousTitle">🚫 Confirmed Malicious IPs (≥ 3 Vendors)</h3>
        <span class="badge" id="blBadge">0</span>
      </div>
      <div class="table-scroll" id="blacklistTableWrap">
        <div class="loading"><div class="spinner"></div><br>Loading blacklist...</div>
      </div>
    </div>
  </div>

  <!-- Failed Attempts by Country Chart (full width) -->
  <div class="table-section fade-in">
    <div class="table-header">
      <h3 id="countryChartTitle">🌍 Failed Attempts by Country</h3>
    </div>
    <div style="padding: 1.5rem; display: flex; justify-content: center; align-items: center; min-height: 400px;" id="chartWrap">
      <div class="loading" id="chartLoading"><div class="spinner"></div><br>Loading chart data...</div>
      <canvas id="countryChart" style="display: none; max-height: 400px; width: 100%;"></canvas>
    </div>
  </div>

  <!-- Top 10 Attack Country Timeline Chart -->
  <div class="table-section fade-in" style="margin-top: 1.5rem;">
    <div class="table-header">
      <h3 id="countryTimelineTitle">📉 Top 10 Attack Countries Timeline</h3>
    </div>
    <div style="padding: 1.5rem; display: flex; justify-content: center; align-items: center; min-height: 400px;" id="timelineWrap">
      <div class="loading" id="timelineLoading"><div class="spinner"></div><br>Loading timeline data...</div>
      <canvas id="countryTimelineChart" style="display: none; max-height: 400px; width: 100%;"></canvas>
    </div>
  </div>

</div>

<script>
const API = 'api.php';

function getAnalysisDays() {
  let days = document.getElementById('analysisDays').value;
  if (days === 'custom') {
    days = document.getElementById('customDays').value || 7;
  }
  return days;
}

// Refresh all dashboard widgets dynamically
function refreshDashboard() {
  Promise.all([loadStats(), loadBlacklist(), loadFaz(), loadCountryChart(), loadCountryTimeline()])
    .catch(err => console.error('Refresh error:', err));
}

async function fetchJson(action) {
  try {
    const days = getAnalysisDays();
    const r = await fetch(`${API}?action=${action}&days=${days}`);
    if (!r.ok) throw new Error(`HTTP error! status: ${r.status}`);
    return await r.json();
  } catch (e) {
    console.error(`API Error (${action}):`, e);
    return null;
  }
}

function verdictTag(v) {
  const cls = v === 'MALICIOUS' ? 'malicious' : v === 'SUSPICIOUS' ? 'suspicious' : 'clean';
  return `<span class="verdict-tag ${cls}">${v}</span>`;
}

function countClass(n) {
  return n >= 100 ? 'count-cell high' : 'count-cell';
}

let currentPeriodStr = "1 Week"; // global to share across widgets


async function loadStats() {
  const s = await fetchJson('stats');
  if (!s) {
    document.getElementById('lastUpdate').textContent = 'Error loading stats';
    return;
  }
  // Removed stats cards bindings

  // Workflow counts from JSON
  document.getElementById('wfTotalFails').textContent = (s.faz_total_logins || 0).toLocaleString();
  document.getElementById('wfTotalIps').textContent = (s.faz_unique_ips || 0).toLocaleString();
  document.getElementById('wfFilterCount').textContent = (s.faz_ip_count || 0).toLocaleString();
  document.getElementById('wfBlCount').textContent = (s.run_blacklisted || 0).toLocaleString();

   if (s.faz_start && s.faz_end) {
        // Compute period label based on hours
        let year = new Date().getFullYear();
        let d1 = new Date(`${year}-${s.faz_start.replace(' ', 'T')}:00`);
        let d2 = new Date(`${year}-${s.faz_end.replace(' ', 'T')}:00`);
        if (d1 > d2) d1.setFullYear(year - 1); // handle year boundary
        
        let diffHours = Math.round(Math.abs(d2 - d1) / 36e5);
        let diffDays = Math.round(diffHours / 24);
        
        let periodStr = diffDays + " Days";
        if (diffDays === 1 || diffHours <= 24) periodStr = "1 Day";
        else if (diffDays === 7) periodStr = "1 Week";
        else if (diffDays === 14) periodStr = "2 Weeks";
        else if (diffDays === 28) periodStr = "4 Weeks";
        
        currentPeriodStr = periodStr;
        
        document.getElementById('realtimeTitle').textContent = `📡 Realtime FAZ Results (${s.faz_start} to ${s.faz_end}) - Last ${periodStr}`;
        document.getElementById('maliciousTitle').textContent = `🚫 Confirmed Malicious IPs (${s.faz_start} to ${s.faz_end}) - Last ${periodStr} (≥ 3 Vendors)`;
        
        let targetWarning = s.is_partial ? ' <span title="Partial data" style="color: var(--accent-orange); cursor: help;">⚠️</span>' : '';
        document.getElementById('targetPeriodLabel').innerHTML = `(≥ 50 / Last ${periodStr})${targetWarning}`;
        
        let partialBadge = s.is_partial ? `<span style="background: rgba(247,168,79,0.15); color: var(--accent-orange); padding: 0.15rem 0.6rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600; margin-left: 0.8rem; border: 1px solid rgba(247,168,79,0.3);" title="The database only has logs starting from ${s.faz_start}. Click 'Collect from FAZ now' to fetch older logs for the full requested period.">⚠️ Incomplete Data</span>` : "";

        document.getElementById('lastUpdate').innerHTML =
         `<div style="font-size: 1rem; color: #e4e6f0; display: flex; align-items: center;">
            <span style="color: #8b8fa3; margin-right: 0.5rem;">⏱️ Analysis Window:</span> 
            <span style="color: #4fc3f7; font-weight: 600;">${s.faz_start}</span> 
            <span style="color: #8b8fa3; margin: 0 0.5rem;">→</span> 
            <span style="color: #4fc3f7; font-weight: 600;">${s.faz_end}</span>
            ${partialBadge}
          </div>`;
   } else {
      document.getElementById('realtimeTitle').textContent = `📡 Realtime FAZ Results (24h)`;
      document.getElementById('lastUpdate').innerHTML =
        `<div style="font-size: 1rem; color: #e4e6f0;">
           <span style="color: #8b8fa3;">Last CSV:</span> <strong>${s.faz_csv || 'N/A'}</strong> <span style="color: #8b8fa3; margin-left: 0.5rem;">(${s.faz_date || ''})</span>
         </div>`;
  }
}

const regionNames = new Intl.DisplayNames(['en'], { type: 'region' });

function countryName(code) {
  if (!code || code === 'N/A') return '—';
  try {
    return regionNames.of(code) || code;
  } catch (e) {
    return code;
  }
}

async function loadBlacklist() {
  const data = await fetchJson('blacklist');
  const wrap = document.getElementById('blacklistTableWrap');
  
  if (!data) {
    wrap.innerHTML = '<div class="empty-state">Error loading blacklist</div>';
    return;
  }
  
  document.getElementById('blBadge').textContent = data.length;

  if (data.length === 0) {
    wrap.innerHTML = '<div class="empty-state">No IPs with ≥ 3 malicious vendor flags yet</div>';
    return;
  }

  let html = `<table><thead><tr>
    <th>IP Address</th><th>Country</th><th>Risk</th><th>Detections</th>
    <th>AS Owner</th>
  </tr></thead><tbody>`;

  data.forEach(r => {
    html += `<tr>
      <td class="ip-cell">${r.ip}</td>
      <td>${countryName(r.country)}</td>
      <td>${verdictTag(r.verdict)}</td>
      <td class="${countClass(r.malicious)}">${r.malicious}</td>
      <td>${r.as_owner || '—'}</td>
    </tr>`;
  });

  html += '</tbody></table>';
  wrap.innerHTML = html;
}

async function loadFaz() {
  const data = await fetchJson('faz');
  const wrap = document.getElementById('fazTableWrap');
  
  if (!data) {
    wrap.innerHTML = '<div class="empty-state">Error loading FAZ results</div>';
    return;
  }

  document.getElementById('fazBadge').textContent = data.length;

  if (data.length === 0) {
    wrap.innerHTML = '<div class="empty-state">No FAZ results found. Run analyze_faz_ips.py first.</div>';
    return;
  }

  let html = `<table><thead><tr>
    <th>IP Address</th><th>Failed Attempts</th><th>Last Seen</th><th>Severity</th>
  </tr></thead><tbody>`;

  data.forEach(r => {
    const sev = r.count >= 500 ? 'malicious' : r.count >= 100 ? 'suspicious' : 'clean';
    const sevLabel = r.count >= 500 ? 'CRITICAL' : r.count >= 100 ? 'HIGH' : 'MEDIUM';
    html += `<tr>
      <td class="ip-cell">${r.ip}</td>
      <td class="${countClass(r.count)}">${r.count.toLocaleString()}</td>
      <td style="color: #8b8fa3; font-size: 0.85rem;">${r.last_seen ? r.last_seen.substring(5, 16) : '—'}</td>
      <td>${verdictTag(sevLabel)}</td>
    </tr>`;
  });

  html += '</tbody></table>';
  wrap.innerHTML = html;
}

let countryChartInstance = null;

async function loadCountryChart() {
  const data = await fetchJson('country_stats');
  const canvas = document.getElementById('countryChart');
  const loading = document.getElementById('chartLoading');
  
  if (!data || data.length === 0) {
    loading.innerHTML = '<div class="empty-state">No data available for chart</div>';
    canvas.style.display = 'none';
    return;
  }

  loading.style.display = 'none';
  canvas.style.display = 'block';

  const rawTotalFails = data.reduce((sum, d) => sum + d.total_fails, 0);
  document.getElementById('countryChartTitle').textContent = `🌍 Failed Attempts by Country - Last ${currentPeriodStr} (Total: ${rawTotalFails.toLocaleString()})`;

  // Sort data descending by total_fails
  data.sort((a, b) => b.total_fails - a.total_fails);
  
  let labels = data.map(d => countryName(d.country));
  let values = data.map(d => d.total_fails);
  
  // Group small tail into "Others" if too many countries
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
    'rgba(247,79,111,0.8)',   // accent-red
    'rgba(247,168,79,0.8)',  // accent-orange
    'rgba(45,212,168,0.8)',  // accent-green
    'rgba(79,143,247,0.8)',  // accent-blue
    'rgba(124,92,252,0.8)',  // accent-purple
    'rgba(79,195,247,0.8)',  // accent-cyan
    '#e63946', '#f4a261', '#e9c46a', '#2a9d8f', '#264653',
    '#8ecae6', '#219ebc', '#023047', '#ffb703', '#fb8500'
  ];

  if (countryChartInstance) {
    countryChartInstance.destroy();
  }

  Chart.defaults.color = '#8b8fa3';
  Chart.defaults.font.family = "'Inter', sans-serif";
  Chart.register(ChartDataLabels);

  const totalSum = values.reduce((a, b) => a + b, 0);

  // Generate legend labels with percentages
  const labelsWithPercentages = labels.map((lbl, i) => {
    const pct = ((values[i] / totalSum) * 100).toFixed(1);
    return `${lbl} (${pct}%)`;
  });

  countryChartInstance = new Chart(canvas, {
    type: 'pie',
    data: {
      labels: labelsWithPercentages,
      datasets: [{
        data: values,
        backgroundColor: bgColors.slice(0, labels.length),
        borderColor: '#1a1d28', /* match bg-card */
        borderWidth: 2,
        hoverOffset: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: window.innerWidth < 900 ? 'bottom' : 'right',
          labels: { 
            color: '#e4e6f0', 
            padding: 20, 
            font: { size: 13 }
          }
        },
        datalabels: {
          color: '#ffffff',
          font: { weight: 'bold', size: 12 },
          formatter: (value, ctx) => {
            const percentage = ((value / totalSum) * 100).toFixed(1);
            // Hide label if slice is too small (< 3%) to prevent text overlap
            return percentage >= 3 ? percentage + '%' : null;
          },
          textShadowBlur: 4,
          textShadowColor: 'rgba(0,0,0,0.8)'
        },
        tooltip: {
          backgroundColor: 'rgba(26, 29, 40, 0.95)', /* bg-card */
          titleColor: '#e4e6f0',
          bodyColor: '#e4e6f0',
          borderColor: '#2a2e3e',
          borderWidth: 1,
          padding: 12,
          callbacks: {
            title: function(context) { 
               // Restore raw title without percentage suffix on hovering
               return labels[context[0].dataIndex];
            },
            label: function(context) {
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

let countryTimelineInstance = null;

async function loadCountryTimeline() {
  const data = await fetchJson('country_timeline');
  const canvas = document.getElementById('countryTimelineChart');
  const loading = document.getElementById('timelineLoading');
  
  if (!data || !data.datasets || data.datasets.length === 0) {
    loading.innerHTML = '<div class="empty-state">No timeline data available</div>';
    if (countryTimelineInstance) countryTimelineInstance.destroy();
    return;
  }

  loading.style.display = 'none';
  canvas.style.display = 'block';
  
  document.getElementById('countryTimelineTitle').textContent = `📉 Top 10 Attack Countries Timeline - Last ${currentPeriodStr}`;

  const bgColors = [
    'rgba(247,79,111,0.8)',   // accent-red
    'rgba(247,168,79,0.8)',  // accent-orange
    'rgba(45,212,168,0.8)',  // accent-green
    'rgba(79,143,247,0.8)',  // accent-blue
    'rgba(124,92,252,0.8)',  // accent-purple
    'rgba(79,195,247,0.8)',  // accent-cyan
    'rgba(230,57,70,0.8)', 'rgba(244,162,97,0.8)', 'rgba(233,196,106,0.8)', 'rgba(42,157,143,0.8)'
  ];

  data.datasets.forEach((dataset, i) => {
    dataset.backgroundColor = bgColors[i % bgColors.length];
    dataset.label = countryName(dataset.label);
    dataset.borderWidth = 1;
    dataset.borderColor = '#1a1d28'; // bg-card
  });

  if (countryTimelineInstance) {
    countryTimelineInstance.destroy();
  }

  Chart.defaults.color = '#8b8fa3';
  Chart.defaults.font.family = "'Inter', sans-serif";

  // Prevent drawing data labels on stacked bars
  let pluginsConfig = {
    legend: {
      position: window.innerWidth < 900 ? 'bottom' : 'right',
      labels: { color: '#e4e6f0', padding: 20, font: { size: 13 } }
    },
    tooltip: {
      backgroundColor: 'rgba(26, 29, 40, 0.95)',
      titleColor: '#e4e6f0',
      bodyColor: '#e4e6f0',
      borderColor: '#2a2e3e',
      borderWidth: 1,
      padding: 12,
      mode: 'index',
      intersect: false
    }
  };
  
  // chart.js datalabels plugin might be registered globally from loadCountryChart
  if (typeof ChartDataLabels !== 'undefined') {
      pluginsConfig.datalabels = { display: false };
  }

  countryTimelineInstance = new Chart(canvas, {
    type: 'bar',
    data: data,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          stacked: true,
          grid: { color: 'rgba(139,143,163,0.1)' },
          ticks: { color: '#8b8fa3' }
        },
        y: {
          stacked: true,
          grid: { color: 'rgba(139,143,163,0.1)' },
          ticks: { color: '#8b8fa3' }
        }
      },
      plugins: pluginsConfig
    }
  });
}

// Collection Logic
let eventSource = null;
let ansiOpenSpans = 0;
const logOutput = document.getElementById('logOutput');
const logModal = document.getElementById('logModal');
const btnCollect = document.getElementById('btnCollect');

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

function toggleCustomDays() {
  const cd = document.getElementById('customDays');
  if (document.getElementById('analysisDays').value === 'custom') {
    cd.style.display = 'block';
    cd.value = '';
    cd.focus();
    // Rebind enter key on custom to refresh
    cd.onchange = refreshDashboard;
  } else {
    cd.style.display = 'none';
  }
}

function startCollection() {
  if (eventSource) return;

  logModal.style.display = 'flex';
  logOutput.textContent = 'Starting analysis...\n';
  btnCollect.disabled = true;

  let days = getAnalysisDays();

  ansiOpenSpans = 0;
  eventSource = new EventSource(`run_analysis.php?days=${days}`);
  
  eventSource.onmessage = function(e) {
    try {
      const data = JSON.parse(e.data);
      if (data.type === 'log') {
        logOutput.innerHTML += parseANSIColor(data.msg);
        // Auto-scroll
        logOutput.scrollTop = logOutput.scrollHeight; 
      } else if (data.type === 'error') {
        logOutput.innerHTML += '<span style="color:#f74f6f;">ERROR: ' + parseANSIColor(data.msg) + '</span>\n';
      } else if (data.type === 'done') {
        logOutput.innerHTML += '\n' + parseANSIColor(data.msg) + '\n';
        stopCollection();
        // Refresh dashboard data instantly using local aggregate logic
        refreshDashboard();
      }
    } catch (err) {
      console.error('Parse error', err);
    }
  };

  eventSource.onerror = function(e) {
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
  btnCollect.disabled = false;
}

function closeModal() {
  if (eventSource) {
    if (!confirm('Analysis is still running. Are you sure you want to stop monitoring? (Process continues in background)')) {
      return;
    }
    stopCollection();
  }
  logModal.style.display = 'none';
}

// Initial load
refreshDashboard();
</script>
</body>
</html>
