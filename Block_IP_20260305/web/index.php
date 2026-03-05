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

.table-scroll { max-height: 650px; overflow-y: auto; }
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
    <h1>🛡️ SSLVPN Security Dashboard</h1>
    <div class="subtitle">FortiAnalyzer SSLVPN Brute-Force IP Analysis</div>
  </div>
  <div class="header-right" style="display: flex; gap: 1rem; align-items: center;">
    <a href="index.php" style="color: var(--text); text-decoration: none; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 0.4rem; padding: 0.5rem 0.8rem; border-radius: 8px; background: var(--bg-card); border: 1px solid var(--border); transition: background 0.2s;">
      <span class="icon" style="font-size: 1.1rem;">📊</span> Dashboard
    </a>
    <a href="devices.php" style="color: var(--text-dim); text-decoration: none; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 0.4rem; padding: 0.5rem 0.8rem; border-radius: 8px; transition: background 0.2s;" onmouseover="this.style.color='var(--text)'; this.style.background='var(--bg-card)';" onmouseout="this.style.color='var(--text-dim)'; this.style.background='transparent';">
      <span class="icon" style="font-size: 1.1rem;">⚙️</span> Devices
    </a>
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
        <select id="deviceFilter" class="btn-collect" style="background: var(--bg-card); color: var(--text); border: 1px solid var(--border); padding-right: 1.5rem; appearance: auto;" onchange="refreshDashboard();">
          <option value="all">All Devices</option>
        </select>
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

  <!-- Device Events Timeline Table -->
  <div class="table-section fade-in" style="margin-bottom: 1.5rem;">
    <div class="table-header">
      <h3 id="timelineTableTitle">🛡️ Device Events by Day (Loading...)</h3>
      <button id="btnExportCSV" class="btn-collect" style="padding: 0.3rem 0.8rem; font-size: 0.75rem; background: var(--bg-card); border: 1px solid var(--border);" onclick="exportTimelineToCSV()" disabled>
        <span class="icon">📥</span> Export CSV
      </button>
    </div>
    <div class="table-scroll" id="deviceTimelineTableWrap" style="max-height: 350px;">
      <div class="loading"><div class="spinner"></div><br>Loading timeline...</div>
    </div>
  </div>

  <!-- Stats cards deleted -->

  <!-- Tables -->
  <!-- Realtime FAZ Table -->
  <div class="table-section fade-in" style="margin-bottom: 1.5rem;">
    <div class="table-header">
      <h3 id="realtimeTitle">📡 Realtime FAZ Results (Loading...)</h3>
      <div style="display: flex; gap: 0.5rem; align-items: center;">
        <span class="badge blue" id="fazBadge">0</span>
        <button id="btnExportFazCSV" class="btn-collect" style="padding: 0.3rem 0.8rem; font-size: 0.75rem; background: var(--bg-card); border: 1px solid var(--border);" onclick="exportFazToCSV()" disabled>
          <span class="icon">📥</span> Export CSV
        </button>
      </div>
    </div>
    <div class="table-scroll" id="fazTableWrap" style="max-height: 250px;">
      <div class="loading"><div class="spinner"></div><br>Loading FAZ results...</div>
    </div>
  </div>

  <!-- Blacklist Table -->
  <div class="table-section fade-in" style="margin-bottom: 1.5rem;">
    <div class="table-header">
      <h3 id="maliciousTitle">🚫 Confirmed Malicious IPs (≥ 3 Vendors)</h3>
      <div style="display: flex; gap: 0.5rem; align-items: center;">
        <span class="badge" id="blBadge">0</span>
        <button id="btnExportBlCSV" class="btn-collect" style="padding: 0.3rem 0.8rem; font-size: 0.75rem; background: var(--bg-card); border: 1px solid var(--border);" onclick="exportBlacklistToCSV()" disabled>
          <span class="icon">📥</span> Export CSV
        </button>
      </div>
    </div>
    <div class="table-scroll" id="blacklistTableWrap" style="max-height: 250px;">
      <div class="loading"><div class="spinner"></div><br>Loading blacklist...</div>
    </div>
  </div>

  <!-- AD Users Status Table -->
  <div class="table-section fade-in" style="margin-top: 1.5rem;">
    <div class="table-header">
      <h3 id="adStatusTitle">🛡️ Top 5 Targeted AD User(s) Status</h3>
      <button id="btnExportAdCSV" class="btn-collect" style="padding: 0.3rem 0.8rem; font-size: 0.75rem; background: var(--bg-card); border: 1px solid var(--border);" onclick="exportAdStatusToCSV()" disabled>
        <span class="icon">📥</span> Export CSV
      </button>
    </div>
    <div class="table-scroll" id="adStatusTableWrap" style="max-height: 200px;">
      <div class="loading"><div class="spinner"></div><br>Loading AD Users...</div>
    </div>
  </div>

  <!-- Non-AD Users Status Table -->
  <div class="table-section fade-in" style="margin-top: 1.5rem;">
    <div class="table-header">
      <h3 id="nonAdStatusTitle">🛡️ Top 10 Targeted NON-AD User(s) Status</h3>
      <button id="btnExportNonAdCSV" class="btn-collect" style="padding: 0.3rem 0.8rem; font-size: 0.75rem; background: var(--bg-card); border: 1px solid var(--border);" onclick="exportNonAdStatusToCSV()" disabled>
        <span class="icon">📥</span> Export CSV
      </button>
    </div>
    <div class="table-scroll" id="nonAdStatusTableWrap" style="max-height: 300px;">
      <div class="loading"><div class="spinner"></div><br>Loading Non-AD Users...</div>
    </div>
  </div>

  <!-- Charts grid -->
  <div class="two-col">
    <!-- Failed Attempts by Country Chart -->
    <div class="table-section fade-in" style="margin-bottom: 0;">
      <div class="table-header">
        <h3 id="countryChartTitle">🌍 Failed Attempts by Country</h3>
      </div>
      <div style="padding: 1.5rem; display: flex; justify-content: center; align-items: center; min-height: 350px;" id="chartWrap">
        <div class="loading" id="chartLoading"><div class="spinner"></div><br>Loading chart data...</div>
        <canvas id="countryChart" style="display: none; height: 100%; width: 100%;"></canvas>
      </div>
    </div>

    <!-- Failed Attempts by FortiGate Device Chart -->
    <div class="table-section fade-in" style="margin-bottom: 0;">
      <div class="table-header">
        <h3 id="deviceChartTitle">🛡️ Events by FortiGate Device</h3>
      </div>
      <div style="padding: 1.5rem; display: flex; justify-content: center; align-items: center; min-height: 350px;" id="deviceChartWrap">
        <div class="loading" id="deviceLoading"><div class="spinner"></div><br>Loading device data...</div>
        <canvas id="deviceChart" style="display: none; height: 100%; width: 100%;"></canvas>
      </div>
    </div>
  </div>

  <!-- Top 10 Attack Country Timeline Chart -->
  <div class="two-col" style="margin-top: 1.5rem;">
    <!-- Country Timeline -->
    <div class="table-section fade-in" style="margin-bottom: 0;">
      <div class="table-header">
        <h3 id="countryTimelineTitle">📉 Top 10 Attack Countries Timeline</h3>
      </div>
      <div style="padding: 1.5rem; display: flex; justify-content: center; align-items: center; min-height: 400px;" id="timelineWrap">
        <div class="loading" id="timelineLoading"><div class="spinner"></div><br>Loading timeline data...</div>
        <canvas id="countryTimelineChart" style="display: none; max-height: 400px; width: 100%;"></canvas>
      </div>
    </div>

    <!-- Top 10 Users Chart -->
    <div class="table-section fade-in" style="margin-bottom: 0;">
      <div class="table-header">
        <h3 id="userChartTitle">👤 Top 10 Users by Device</h3>
      </div>
      <div style="padding: 1.5rem; display: flex; justify-content: center; align-items: center; min-height: 400px;" id="userChartWrap">
        <div class="loading" id="userLoading"><div class="spinner"></div><br>Loading user data...</div>
        <canvas id="userChart" style="display: none; max-height: 400px; width: 100%;"></canvas>
      </div>
    </div>
  </div>

</div>

<script>
const API = 'api.php';
let currentTimelineData = null; 
let currentFazData = null;
let currentBlacklistData = null;
let currentAdStatusData = null;
let currentNonAdStatusData = null;

function getAnalysisDays() {
  let days = document.getElementById('analysisDays').value;
  if (days === 'custom') {
    days = document.getElementById('customDays').value || 7;
  }
  return days;
}

function getSelectedDevice() {
  const el = document.getElementById('deviceFilter');
  return el ? el.value : 'all';
}

// Refresh all dashboard widgets dynamically
function refreshDashboard() {
  Promise.all([loadStats(), loadBlacklist(), loadFaz(), loadCountryChart(), loadDeviceChart(), loadCountryTimeline(), loadUserChart(), loadAdStatus(), loadNonAdStatus(), loadDeviceTimeline()])
    .catch(err => console.error('Refresh error:', err));
}

async function fetchJson(action) {
  try {
    const days = getAnalysisDays();
    const devname = getSelectedDevice();
    const minEvents = document.getElementById('minTargetEvents') ? document.getElementById('minTargetEvents').value : 50;
    const minMal = document.getElementById('minMalVendors') ? document.getElementById('minMalVendors').value : 3;
    
    const r = await fetch(`${API}?action=${action}&days=${days}&devname=${encodeURIComponent(devname)}&min_events=${minEvents}&min_mal=${minMal}`);
    if (!r.ok) throw new Error(`HTTP error! status: ${r.status}`);
    return await r.json();
  } catch (e) {
    console.error(`API Error (${action}):`, e);
    return null;
  }
}

async function loadDevices() {
  try {
    const r = await fetch(`${API}?action=devices`);
    const devices = await r.json();
    const select = document.getElementById('deviceFilter');
    const current = select.value;
    select.innerHTML = '<option value="all">All Devices</option>';
    if (devices && devices.length > 0) {
      devices.forEach(d => {
        select.innerHTML += `<option value="${d}">${d}</option>`;
      });
      select.value = current; // restore selection
    }
  } catch (e) {
    console.error('Error loading devices:', e);
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
        // Use the selected period from the dropdown for consistency
        const daysSelect = document.getElementById('analysisDays');
        let periodStr = daysSelect.options[daysSelect.selectedIndex].text.replace('Last ', '');
        if (daysSelect.value === 'custom') {
            const cDays = document.getElementById('customDays').value || 1;
            periodStr = cDays + (parseInt(cDays) === 1 ? " Day" : " Days");
        } else if (periodStr.includes('Custom')) {
            // Fallback if somehow text isn't replaced
            const cDays = document.getElementById('customDays').value || 1;
            periodStr = cDays + (parseInt(cDays) === 1 ? " Day" : " Days");
        }
        
        currentPeriodStr = periodStr;
        
        document.getElementById('realtimeTitle').textContent = `📡 Realtime FAZ Results (${s.faz_start} to ${s.faz_end}) - Last ${periodStr}`;
        let targetWarning = s.is_partial ? ' <span title="Partial data" style="color: var(--accent-orange); cursor: help;">⚠️</span>' : '';
        const minEvents = document.getElementById('minTargetEvents') ? document.getElementById('minTargetEvents').value : 50;
        const minMal = document.getElementById('minMalVendors') ? document.getElementById('minMalVendors').value : 3;
        
        document.getElementById('targetPeriodLabel').innerHTML = `(≥ ${minEvents} / Last ${periodStr})${targetWarning}`;
        document.getElementById('maliciousTitle').textContent = `🚫 Confirmed Malicious IPs (${s.faz_start} to ${s.faz_end}) - Last ${periodStr} (≥ ${minMal} Vendors)`;
        document.querySelector('.wf-step.blacklist .step-label:last-child').textContent = `(≥ ${minMal} Security Vendors)`;
        
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
        const daysSelect = document.getElementById('analysisDays');
        let periodStr = daysSelect.options[daysSelect.selectedIndex].text.replace('Last ', '');
        if (daysSelect.value === 'custom') {
            const cDays = document.getElementById('customDays').value || 1;
            periodStr = cDays + (parseInt(cDays) === 1 ? " Day" : " Days");
        }
        currentPeriodStr = periodStr;

        document.getElementById('realtimeTitle').textContent = `📡 Realtime FAZ Results - No Data for Last ${periodStr}`;
        document.getElementById('maliciousTitle').textContent = `🚫 Confirmed Malicious IPs - No Data for Last ${periodStr}`;
      document.getElementById('lastUpdate').innerHTML =
        `<div style="font-size: 1rem; color: #e4e6f0;">
           <span style="color: var(--accent-orange);">⚠️ No events found for the selected device in this time window.</span>
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
  document.getElementById('btnExportBlCSV').disabled = true;
  const data = await fetchJson('blacklist');
  const wrap = document.getElementById('blacklistTableWrap');
  
  if (!data) {
    wrap.innerHTML = '<div class="empty-state">Error loading blacklist</div>';
    document.getElementById('blBadge').textContent = '0';
    currentBlacklistData = null;
    return;
  }
  
  currentBlacklistData = data;
  document.getElementById('btnExportBlCSV').disabled = false;
  
  document.getElementById('blBadge').textContent = data.length;

  if (data.length === 0) {
    const minMal = document.getElementById('minMalVendors') ? document.getElementById('minMalVendors').value : 3;
    wrap.innerHTML = `<div class="empty-state">No IPs with ≥ ${minMal} malicious vendor flags yet for the selected device/period.</div>`;
    return;
  }

  let html = `<table><thead><tr>
    <th>IP Address</th><th>Failed Attempts</th><th>Risk</th><th>Identified Vendors</th>
    <th>Target Device(s)</th><th>Country</th><th>Duration</th><th>Target Account(s)</th>
  </tr></thead><tbody>`;

  data.forEach(r => {
    let devices = r.target_devices || 'Unknown';
    if (devices !== 'Unknown') {
        let devArr = devices.split(',').map(d => d.trim()).filter(d => d);
        devArr.sort((a, b) => a.localeCompare(b));
        devices = devArr.join(',');
    }
    const users = r.targeted_users || 'None';
    
    html += `<tr>
      <td class="ip-cell">${r.ip}</td>
      <td class="${countClass(r.fail_count)}">${(r.fail_count || 0).toLocaleString()}</td>
      <td>${verdictTag(r.verdict)}</td>
      <td class="${countClass(r.malicious)}">${r.malicious}</td>
      <td style="color: #8b8fa3; font-size: 0.8rem; max-width: 150px; word-wrap: break-word;">${devices}</td>
      <td class="table-tooltip" title="${countryName(r.country)}">${countryName(r.country)}</td>
      <td style="color: #e4e6f0; font-size: 0.85rem; line-height: 1.2;">${r.duration}</td>
      <td style="color: #8b8fa3; font-size: 0.8rem; max-width: 150px; word-wrap: break-word;">${users}</td>
    </tr>`;
  });

  html += '</tbody></table>';
  wrap.innerHTML = `<div style="margin-top: 15px;">${html}</div>`;
}

async function loadFaz() {
  document.getElementById('btnExportFazCSV').disabled = true;
  const data = await fetchJson('faz');
  const wrap = document.getElementById('fazTableWrap');
  
  if (!data) {
    wrap.innerHTML = '<div class="empty-state">Error loading FAZ results</div>';
    document.getElementById('fazBadge').textContent = '0';
    currentFazData = null;
    return;
  }
  
  currentFazData = data;
  document.getElementById('btnExportFazCSV').disabled = false;

  document.getElementById('fazBadge').textContent = data.length;

  if (data.length === 0) {
    wrap.innerHTML = '<div class="empty-state">No FAZ results found for the selected device/period.</div>';
    return;
  }

  let html = `<table><thead><tr>
    <th>IP Address</th><th>Failed Attempts</th><th>Duration</th><th>Target Device(s)</th><th>Severity</th>
  </tr></thead><tbody>`;

  data.forEach(r => {
    let devices = r.target_devices || 'Unknown';
    if (devices !== 'Unknown') {
        let devArr = devices.split(',').map(d => d.trim()).filter(d => d);
        devArr.sort((a, b) => a.localeCompare(b));
        devices = devArr.join(',');
    }

    const sev = r.count >= 500 ? 'malicious' : r.count >= 100 ? 'suspicious' : 'clean';
    const sevLabel = r.count >= 500 ? 'CRITICAL' : r.count >= 100 ? 'HIGH' : 'MEDIUM';
    html += `<tr>
      <td class="ip-cell">${r.ip}</td>
      <td class="${countClass(r.count)}">${r.count.toLocaleString()}</td>
      <td style="color: #e4e6f0; font-size: 0.85rem; line-height: 1.2;">${r.duration || '—'}</td>
      <td style="color: #8b8fa3; font-size: 0.8rem; max-width: 150px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap;" title="${devices}">${devices}</td>
      <td>${verdictTag(sevLabel)}</td>
    </tr>`;
  });

  html += '</tbody></table>';
  wrap.innerHTML = html;
}

async function loadDeviceTimeline() {
  document.getElementById('btnExportCSV').disabled = true;
  const data = await fetchJson('device_timeline');
  const wrap = document.getElementById('deviceTimelineTableWrap');
  
  if (!data || !data.devices || data.devices.length === 0) {
    wrap.innerHTML = '<div class="empty-state">No timeline data available for the selected period/device.</div>';
    currentTimelineData = null;
    return;
  }

  currentTimelineData = data;
  document.getElementById('btnExportCSV').disabled = false;

  // Calculate grand total for percentages
  const grandTotal = data.devices.reduce((sum, dev) => sum + dev.total, 0);

  // Update title with period
  document.getElementById('timelineTableTitle').textContent = `🛡️ Device Events by Day - Last ${currentPeriodStr}`;

  let html = `<table><thead><tr>
    <th style="text-align: left; padding-left: 1.5rem;">Device / Day</th>`;
  
  const weekdays = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
  data.days.forEach(d => {
    const dt = new Date(d + 'T00:00:00');
    const dayName = weekdays[dt.getDay()];
    const parts = d.split('-');
    const displayDate = `${parseInt(parts[1])}-${parseInt(parts[2])}`; // mm-dd without leading zeros
    html += `<th>${displayDate} ${dayName}</th>`;
  });
  
  html += `<th>Total</th><th>%</th></tr></thead><tbody>`;

  data.devices.forEach(dev => {
    const pct = grandTotal > 0 ? ((dev.total / grandTotal) * 100).toFixed(1) + '%' : '0%';
    html += `<tr>
      <td style="text-align: left; font-weight: 500; color: var(--accent-blue); padding-left: 1.5rem;">${dev.name}</td>`;
    
    data.days.forEach(d => {
      const count = dev.data[d] || 0;
      const cls = count >= 500 ? 'count-cell high' : 'count-cell';
      html += `<td class="${cls}">${count.toLocaleString()}</td>`;
    });
    
    html += `<td style="font-weight: 700; background: rgba(79,143,247,0.05);">${dev.total.toLocaleString()}</td>`;
    html += `<td style="font-size: 0.75rem; color: var(--text-dim);">${pct}</td></tr>`;
  });

  html += '</tbody></table>';
  wrap.innerHTML = html;
}

function downloadCSV(csvContent, fileName) {
  const params = new URLSearchParams();
  params.append('csv_content', csvContent);
  params.append('filename', fileName);

  fetch('api.php?action=save_csv', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: params
  })
  .then(res => {
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    return res.json();
  })
  .then(async res => {
    if (res.id) {
      // Step 2: Fetch the stored CSV as a Blob to force the filename via <a> download attribute
      const downloadRes = await fetch(`api.php?action=download_csv&id=${res.id}`);
      if (!downloadRes.ok) throw new Error('Download request failed');
      
      const blob = await downloadRes.blob();
      const url = window.URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.style.display = 'none';
      a.href = url;
      a.download = fileName; // FORCE filename in browser
      document.body.appendChild(a);
      a.click();
      
      // Cleanup
      setTimeout(() => {
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
      }, 100);
    } else {
      throw new Error(res.error || 'Unknown server error');
    }
  })
  .catch(err => {
    console.error('Export error:', err);
    alert('Export failed: ' + err.message);
  });
}

function getCSVTimestamp() {
  return new Date().toISOString().replace(/[:.]/g, '-').slice(0, 19);
}

function exportTimelineToCSV() {
  if (!currentTimelineData) return;
  const data = currentTimelineData;
  const weekdays = ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'];
  
  const formattedHeaders = data.days.map(dStr => {
    const parts = dStr.split('-');
    const y = parseInt(parts[0], 10);
    const m = parseInt(parts[1], 10);
    const d = parseInt(parts[2], 10);
    const dt = new Date(y, m - 1, d);
    const wd = weekdays[dt.getDay()];
    return `${m}-${d} ${wd}`;
  });
  
  let csv = '\uFEFFDevice,' + formattedHeaders.join(',') + ',Total,%\r\n';
  const grandTotal = data.devices.reduce((sum, dev) => sum + dev.total, 0);
  
  data.devices.forEach(dev => {
    let row = `"${dev.name}"`;
    data.days.forEach(d => { row += `,${dev.data[d] || 0}`; });
    const pct = grandTotal > 0 ? ((dev.total / grandTotal) * 100).toFixed(1) + '%' : '0%';
    csv += row + `,${dev.total},${pct}\r\n`;
  });
  
  downloadCSV(csv, `fgt_event_timeline_${getCSVTimestamp()}.csv`);
}

function exportFazToCSV() {
  if (!currentFazData) return;
  let csv = '\uFEFFIP Address,Failed Attempts,Duration,Target Device(s),Severity\r\n';
  currentFazData.forEach(r => {
    const sevLabel = r.count >= 500 ? 'CRITICAL' : r.count >= 100 ? 'HIGH' : 'MEDIUM';
    csv += `"${r.ip}",${r.count},"${r.duration || ''}","${r.target_devices || ''}","${sevLabel}"\r\n`;
  });
  downloadCSV(csv, `faz_realtime_results_${getCSVTimestamp()}.csv`);
}

function exportBlacklistToCSV() {
  if (!currentBlacklistData) return;
  let csv = '\uFEFFIP Address,Failed Attempts,Risk,Vendors,Target Device(s),Country,Duration,Target Account(s)\r\n';
  currentBlacklistData.forEach(r => {
    csv += `"${r.ip}",${r.fail_count},"${r.verdict}",${r.malicious},"${r.target_devices || ''}","${r.country}","${r.duration}","${r.targeted_users || ''}"\r\n`;
  });
  downloadCSV(csv, `malicious_ips_${getCSVTimestamp()}.csv`);
}

function exportAdStatusToCSV() {
  if (!currentAdStatusData) return;
  let csv = '\uFEFFUsername,Failed Attempts,Target Device(s),Duration,OU / DEPT / PHONE,Locked Out,Password Expired,Last Password Changed,Last Logon\r\n';
  currentAdStatusData.forEach(u => {
    csv += `"${u.Username}",${u.fail_count},"${u.target_devices}","${u.duration}","${u.OU_Dept}","${u.LockedOut}","${u.PasswordExpired}","${u.LastPasswordChange}","${u.LastLogon}"\r\n`;
  });
  downloadCSV(csv, `ad_users_status_${getCSVTimestamp()}.csv`);
}

function exportNonAdStatusToCSV() {
  if (!currentNonAdStatusData) return;
  let csv = '\uFEFFUsername,Failed Attempts,Target Device(s),Duration\r\n';
  currentNonAdStatusData.forEach(u => {
    csv += `"${u.Username}",${u.fail_count},"${u.target_devices}","${u.duration}"\r\n`;
  });
  downloadCSV(csv, `non_ad_users_status_${getCSVTimestamp()}.csv`);
}

let deviceChartInstance = null;

async function loadDeviceChart() {
  const data = await fetchJson('device_stats');
  const canvas = document.getElementById('deviceChart');
  const loading = document.getElementById('deviceLoading');
  
  if (!data || data.length === 0) {
    loading.innerHTML = '<div class="empty-state">No data available</div>';
    canvas.style.display = 'none';
    return;
  }

  loading.style.display = 'none';
  canvas.style.display = 'block';

  const totalFails = data.reduce((sum, d) => sum + d.fail_count, 0);
  document.getElementById('deviceChartTitle').textContent = `🛡️ Events by FortiGate Device (Total: ${totalFails.toLocaleString()})`;

  let labels = data.map(d => d.devname || 'Unknown');
  let values = data.map(d => d.fail_count);

  if (data.length > 10) {
    const topLabels = labels.slice(0, 9);
    const topValues = values.slice(0, 9);
    topLabels.push('Others');
    topValues.push(values.slice(9).reduce((a, b) => a + b, 0));
    labels = topLabels;
    values = topValues;
  }

  const bgColors = [
    'rgba(79,143,247,0.8)',  // accent-blue
    'rgba(124,92,252,0.8)',  // accent-purple
    'rgba(45,212,168,0.8)',  // accent-green
    'rgba(247,168,79,0.8)',  // accent-orange
    'rgba(247,79,111,0.8)',  // accent-red
    'rgba(79,195,247,0.8)',  // accent-cyan
  ];

  if (deviceChartInstance) {
    deviceChartInstance.destroy();
  }

  Chart.register(ChartDataLabels);

  deviceChartInstance = new Chart(canvas, {
    type: 'doughnut',
    data: {
      labels: labels,
      datasets: [{
        data: values,
        backgroundColor: bgColors,
        borderColor: '#1a1d28',
        borderWidth: 2,
        hoverOffset: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '65%',
      plugins: {
        legend: {
          position: window.innerWidth < 900 ? 'bottom' : 'right',
          labels: { color: '#e4e6f0', font: { size: 12 } }
        },
        datalabels: { display: false }
      }
    }
  });
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

let userChartInstance = null;

async function loadUserChart() {
  const data = await fetchJson('user_timeline');
  const canvas = document.getElementById('userChart');
  const loading = document.getElementById('userLoading');
  
  if (!data || !data.datasets || data.datasets.length === 0) {
    loading.innerHTML = '<div class="empty-state">No user data available</div>';
    if (userChartInstance) userChartInstance.destroy();
    return;
  }

  loading.style.display = 'none';
  canvas.style.display = 'block';
  
  document.getElementById('userChartTitle').textContent = `👤 Top 10 Users by Device - Last ${currentPeriodStr}`;

  const bgColors = [
    'rgba(79,143,247,0.8)',  // accent-blue
    'rgba(124,92,252,0.8)',  // accent-purple
    'rgba(45,212,168,0.8)',  // accent-green
    'rgba(247,168,79,0.8)',  // accent-orange
    'rgba(247,79,111,0.8)',  // accent-red
    'rgba(79,195,247,0.8)',  // accent-cyan
  ];

  data.datasets.forEach((dataset, i) => {
    dataset.backgroundColor = bgColors[i % bgColors.length];
    dataset.borderWidth = 1;
    dataset.borderColor = '#1a1d28';
  });

  if (userChartInstance) {
    userChartInstance.destroy();
  }

  Chart.defaults.color = '#8b8fa3';
  Chart.defaults.font.family = "'Inter', sans-serif";

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
  
  if (typeof ChartDataLabels !== 'undefined') {
      pluginsConfig.datalabels = { display: false };
  }

  userChartInstance = new Chart(canvas, {
    type: 'bar',
    data: data,
    options: {
      indexAxis: 'y',
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

async function loadAdStatus() {
  const adWrap = document.getElementById('adStatusTableWrap');
  document.getElementById('btnExportAdCSV').disabled = true;
  
  adWrap.innerHTML = '<div class="loading"><div class="spinner"></div><br>Loading AD Users...</div>';
  
  const data = await fetchJson('ad_status');
  
  if (!data || data.error) {
    adWrap.innerHTML = `<div class="empty-state">Error loading AD status: ${data && data.error ? data.error : 'Unknown error'}</div>`;
    currentAdStatusData = null;
    return;
  }
  
  currentAdStatusData = data;
  document.getElementById('btnExportAdCSV').disabled = false;

  document.getElementById('adStatusTitle').textContent = `🛡️ Top 5 Targeted AD User(s) Status - Last ${currentPeriodStr}`;

  // Helper for date formatting
  function formatAdDate(str) {
    if (!str || str === 'N/A' || str === '') return 'N/A';
    // Handle SQL format or other strings
    const dateStr = str.replace(/-/g, '/').split(' ')[0]; // Take only date part
    const d = new Date(dateStr);
    if (isNaN(d.getTime())) return str;
    const pad = n => n.toString().padStart(2, '0');
    const MM = pad(d.getMonth() + 1);
    const DD = pad(d.getDate());
    const YY = d.getFullYear().toString().slice(-2);
    return `${MM}/${DD}/${YY}`;
  }

  // --- AD Users Table ---
  if (!data || data.length === 0) {
    adWrap.innerHTML = '<div class="empty-state">No Active Directory users with failed logins found.</div>';
  } else {
    let adHtml = `<table><thead><tr>
      <th>Username</th><th>Failed Attempts</th><th>Target Device(s)</th><th>Duration</th>
      <th>OU / DEPT / PHONE</th><th>Locked Out</th><th>Password Expired</th>
      <th>Last Password Changed</th><th>Last Logon</th>
    </tr></thead><tbody>`;

    data.forEach(u => {
      let nameHtml = `<div class="ip-cell" style="color: #4f8ff7;">${u.Username || 'Unknown'}</div>`;

      // Extract lock icon formatting explicitly if needed based on "True" mappings
      let lockHtml = u.LockedOut === 'True' ? `<span style="color: #f85149;">Yes 🔒</span>` : (u.LockedOut === 'False' ? '<span style="color: #2da44e;">No</span>' : 'N/A');
      let expHtml = u.PasswordExpired === 'True' ? `<span style="color: #f85149;">Yes</span>` : (u.PasswordExpired === 'False' ? '<span style="color: #2da44e;">No</span>' : 'N/A');

      adHtml += `<tr>
        <td>${nameHtml}</td>
        <td class="${countClass(u.fail_count || 0)}">${(u.fail_count || 0).toLocaleString()}</td>
        <td style="color: #8b8fa3; font-size: 0.8rem; max-width: 150px; word-wrap: break-word; line-height: 1.4;" title="${u.target_devices || ''}">${u.target_devices || 'Unknown'}</td>
        <td style="color: #e4e6f0; font-size: 0.85rem; word-wrap: break-word; min-width: 100px;">${u.duration || '—'}</td>
        <td style="color: #c9d1d9; font-size: 0.85rem; max-width: 200px; line-height: 1.4; word-wrap: break-word;">${u.OU_Dept || 'N/A'}</td>
        <td style="color: #c9d1d9;">${lockHtml}</td>
        <td style="color: #c9d1d9;">${expHtml}</td>
        <td style="color: #8b8fa3; font-size: 0.85rem;">${formatAdDate(u.LastPasswordChange)}</td>
        <td style="color: #8b8fa3; font-size: 0.85rem;">${formatAdDate(u.LastLogon)}</td>
      </tr>`;
    });
    adHtml += '</tbody></table>';
    adWrap.innerHTML = adHtml;
  }
}

async function loadNonAdStatus() {
  const nonAdWrap = document.getElementById('nonAdStatusTableWrap');
  document.getElementById('btnExportNonAdCSV').disabled = true;
  
  nonAdWrap.innerHTML = '<div class="loading"><div class="spinner"></div><br>Loading Non-AD Users...</div>';
  
  const data = await fetchJson('non_ad_status');
  
  document.getElementById('nonAdStatusTitle').textContent = `🛡️ Top 10 Targeted NON-AD User(s) Status - Last ${currentPeriodStr}`;
  
  if (data && !data.error) {
    currentNonAdStatusData = data;
    document.getElementById('btnExportNonAdCSV').disabled = false;
  } else {
    currentNonAdStatusData = null;
  }

  try {
    if (!data) {
      nonAdWrap.innerHTML = '<div class="empty-state">Error loading Non-AD status.</div>';
      return;
    }

    if (!data || data.length === 0) {
      nonAdWrap.innerHTML = '<div class="empty-state">No Non-AD users with failed logins found.</div>';
    } else {
      let html = `<table><thead><tr>
        <th>Username</th><th>Failed Attempts</th><th>Target Device(s)</th><th>Duration</th>
      </tr></thead><tbody>`;

      data.forEach(u => {
        html += `<tr>
          <td><div class="ip-cell" style="color: #4f8ff7;">${u.Username || 'Unknown'}</div></td>
          <td class="${countClass(u.fail_count || 0)}">${(u.fail_count || 0).toLocaleString()}</td>
          <td style="color: #8b8fa3; font-size: 0.8rem; max-width: 250px; word-wrap: break-word; line-height: 1.4;">${u.target_devices || 'Unknown'}</td>
          <td style="color: #e4e6f0; font-size: 0.85rem; word-wrap: break-word; min-width: 100px;">${u.duration || '—'}</td>
        </tr>`;
      });
      html += '</tbody></table>';
      nonAdWrap.innerHTML = html;
    }
  } catch (err) {
    nonAdWrap.innerHTML = `<div class="empty-state">Error loading data: ${err.message}</div>`;
  }
}

// Collection Logic

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
  let devname = getSelectedDevice();
  ansiOpenSpans = 0;

  const runToken = Date.now().toString();
  eventSource = new EventSource(`run_analysis.php?days=${days}&devname=${encodeURIComponent(devname)}&run_token=${runToken}`);
  
  let isScrolling = false;
  eventSource.onmessage = function(e) {
    try {
      const data = JSON.parse(e.data);
      if (data.type === 'log') {
        logOutput.insertAdjacentHTML('beforeend', parseANSIColor(data.msg.replace(/\r$/, '')) + '\n');
        // Auto-scroll (debounced)
        if (!isScrolling) {
          isScrolling = true;
          requestAnimationFrame(() => {
            logOutput.scrollTop = logOutput.scrollHeight;
            isScrolling = false;
          });
        }
      } else if (data.type === 'error') {
        logOutput.insertAdjacentHTML('beforeend', '<span style="color:#f74f6f;">ERROR: ' + parseANSIColor(data.msg.replace(/\r$/, '')) + '</span>\n');
      } else if (data.type === 'done') {
        logOutput.insertAdjacentHTML('beforeend', '\n' + parseANSIColor(data.msg.replace(/\r$/, '')) + '\n');
        stopCollection();
        // Refresh dashboard data instantly using local aggregate logic
        refreshDashboard();
      }
    } catch (err) {
      console.error('Parse error', err);
    }
  };

  eventSource.onerror = function(e) {
    if (e.eventPhase === EventSource.CLOSED) {
      // Re-connecting automatically
      console.log('SSE connection closed. Browser will auto-reconnect.');
    } else {
      console.log('SSE connection dropped or error. Retrying...');
    }
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
  if (btnCollect.disabled) {
    if (!confirm('Analysis is still running. Are you sure you want to stop monitoring? (Process continues in background)')) {
      return;
    }
    stopCollection();
  }
  logModal.style.display = 'none';
}

// Initial load
loadDevices().then(refreshDashboard);
</script>
</body>
</html>
