<?php
/**
 * FAZ Device Management — faz_devices.php
 * Manage FortiAnalyzer devices and FortiGate device mappings.
 *
 * Ported from Block_IP_20260305/web/devices.php
 * Adapted: API path → faz_devices_api.php, restyled to Cacti theme.
 */
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FAZ Device Management — IP Blacklist</title>
<link rel="stylesheet" href="assets/style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
/* ── Cacti-Theme Variables ────────────────────────────────────── */
:root {
  --cacti-green:       #739e3e;
  --cacti-green-dk:    #5a7b2d;
  --cacti-green-lt:    #f0f5e9;
  --cacti-header-bg:   #3c5a1e;
  --cacti-header-text: #ffffff;
  --bg:                #f4f4f4;
  --bg-card:           #ffffff;
  --border:            #d5d5d5;
  --border-dk:         #b0b0b0;
  --text:              #333333;
  --text-dim:          #666666;
  --text-muted:        #999999;
  --accent-red:        #c0392b;
  --accent-blue:       #2980b9;
  --accent-cyan:       #1a6a87;
  --shadow:            rgba(0,0,0,0.10);
}

* { box-sizing: border-box; margin: 0; padding: 0; }
body {
  font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
  background: var(--bg);
  color: var(--text);
  line-height: 1.5;
  font-size: 13px;
}

/* ── Page Header (Cacti banner style) ───────────────────────── */
.page-header {
  background: linear-gradient(to bottom, #4e7a29 0%, var(--cacti-header-bg) 100%);
  border-bottom: 3px solid var(--cacti-green-dk);
  padding: 0.75rem 1.5rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0 2px 6px rgba(0,0,0,0.25);
}
.page-header h1 {
  font-size: 1.15rem;
  font-weight: 700;
  color: var(--cacti-header-text);
  letter-spacing: 0.02em;
  text-shadow: 0 1px 3px rgba(0,0,0,0.4);
}
.page-header .subtitle {
  color: rgba(255,255,255,0.70);
  font-size: 0.78rem;
  margin-top: 0.1rem;
}
.header-nav { display: flex; gap: 0.5rem; align-items: center; }
.nav-link {
  color: rgba(255,255,255,0.85);
  text-decoration: none;
  font-size: 0.82rem;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 0.35rem;
  padding: 0.35rem 0.75rem;
  border-radius: 4px;
  border: 1px solid rgba(255,255,255,0.2);
  background: rgba(255,255,255,0.08);
  transition: background 0.15s, border-color 0.15s;
}
.nav-link:hover { background: rgba(255,255,255,0.18); border-color: rgba(255,255,255,0.4); color: #fff; }
.nav-link.active { background: rgba(255,255,255,0.22); border-color: rgba(255,255,255,0.5); color: #fff; font-weight: 600; }

/* ── Layout ──────────────────────────────────────────────────── */
.container { max-width: 1300px; margin: 0 auto; padding: 1.5rem 1.25rem; }

/* ── Card / Table Section ────────────────────────────────────── */
.table-section {
  background: var(--bg-card);
  border: 1px solid var(--border);
  border-radius: 6px;
  margin-bottom: 1.5rem;
  overflow: hidden;
  box-shadow: 0 1px 4px var(--shadow);
}
.table-header {
  padding: 0.65rem 1rem;
  background: linear-gradient(to bottom, #f8f8f8 0%, #eaeaea 100%);
  border-bottom: 2px solid var(--cacti-green);
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.table-header h3 {
  font-size: 0.88rem;
  font-weight: 700;
  color: var(--cacti-green-dk);
  letter-spacing: 0.01em;
}
.table-scroll { overflow-x: auto; }

table { width: 100%; border-collapse: collapse; }
thead th {
  text-align: left;
  padding: 0.5rem 0.8rem;
  font-size: 0.78rem;
  font-weight: 600;
  color: #fff;
  background: #5a7b2d;
  border-right: 1px solid rgba(255,255,255,0.15);
  white-space: nowrap;
}
thead th:last-child { border-right: none; }
tbody td {
  text-align: left;
  padding: 0.55rem 0.8rem;
  font-size: 0.82rem;
  border-bottom: 1px solid var(--border);
  vertical-align: middle;
}
tbody tr:nth-child(even) { background: #f9fdf5; }
tbody tr:hover { background: var(--cacti-green-lt); }
tbody tr:last-child td { border-bottom: none; }

/* ── Buttons ─────────────────────────────────────────────────── */
.btn {
  background: linear-gradient(to bottom, #f5f5f5 0%, #e0e0e0 100%);
  color: var(--text);
  border: 1px solid var(--border-dk);
  padding: 0.35rem 0.75rem;
  border-radius: 4px;
  font-weight: 500;
  font-size: 0.80rem;
  cursor: pointer;
  transition: background 0.15s, border-color 0.15s;
  display: inline-flex;
  align-items: center;
  gap: 0.35rem;
  text-decoration: none;
}
.btn:hover { background: linear-gradient(to bottom, #e8e8e8 0%, #d0d0d0 100%); border-color: #999; }
.btn-primary {
  background: linear-gradient(to bottom, #8ab94d 0%, var(--cacti-green) 50%, var(--cacti-green-dk) 100%);
  color: #fff;
  border: 1px solid var(--cacti-green-dk);
  text-shadow: 0 1px 2px rgba(0,0,0,0.3);
}
.btn-primary:hover { background: linear-gradient(to bottom, #9ece5e 0%, #82ad3a 100%); }
.btn-danger {
  background: linear-gradient(to bottom, #e57878 0%, #c0392b 100%);
  color: #fff;
  border: 1px solid #a93226;
  text-shadow: 0 1px 2px rgba(0,0,0,0.3);
}
.btn-danger:hover { background: linear-gradient(to bottom, #ec8c8c 0%, #cd4437 100%); }
.btn-sm { padding: 2px 7px; font-size: 0.72rem; line-height: 1.5; }

/* ── Modal ───────────────────────────────────────────────────── */
.modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.55);
  backdrop-filter: blur(2px);
  z-index: 1000;
  display: flex;
  align-items: center;
  justify-content: center;
}
.modal-window {
  background: var(--bg-card);
  border: 1px solid var(--border-dk);
  border-radius: 6px;
  width: 92%;
  max-width: 520px;
  box-shadow: 0 8px 32px rgba(0,0,0,0.3);
  animation: slideUp 0.2s ease-out;
}
@keyframes slideUp {
  from { opacity: 0; transform: translateY(16px); }
  to { opacity: 1; transform: translateY(0); }
}
.modal-header {
  padding: 0.65rem 1rem;
  background: linear-gradient(to bottom, #f5f5f5 0%, #e6e6e6 100%);
  border-bottom: 2px solid var(--cacti-green);
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-radius: 5px 5px 0 0;
}
.modal-header h3 { font-size: 0.88rem; font-weight: 700; color: var(--cacti-green-dk); }
.modal-close {
  background: none; border: none; color: var(--text-muted);
  font-size: 1.3rem; cursor: pointer; padding: 0 0.3rem; line-height: 1;
}
.modal-close:hover { color: var(--text); }
.modal-body { padding: 1.25rem 1rem; }
.form-group { margin-bottom: 1rem; }
.form-label {
  display: block;
  font-size: 0.80rem;
  color: var(--text-dim);
  margin-bottom: 0.3rem;
  font-weight: 600;
}
.form-control {
  width: 100%;
  background: #ffffff;
  border: 1px solid var(--border-dk);
  color: var(--text);
  padding: 0.45rem 0.7rem;
  border-radius: 4px;
  font-family: inherit;
  font-size: 0.82rem;
  transition: border-color 0.15s, box-shadow 0.15s;
}
.form-control:focus {
  outline: none;
  border-color: var(--cacti-green);
  box-shadow: 0 0 0 2px rgba(115,158,62,0.2);
}
.modal-footer {
  padding: 0.75rem 1rem;
  background: #f8f8f8;
  border-top: 1px solid var(--border);
  display: flex;
  justify-content: flex-end;
  gap: 0.5rem;
  border-radius: 0 0 5px 5px;
}

/* ── Misc ────────────────────────────────────────────────────── */
.empty-state { text-align: center; padding: 2rem; color: var(--text-muted); font-size: 0.85rem; font-style: italic; }
.move-btns { display: flex; flex-direction: column; gap: 2px; }
.action-group { display: flex; gap: 0.4rem; align-items: center; }
.placeholder-red { color: var(--accent-red); font-weight: bold; font-family: monospace; }
</style>
</head>
<body>

<div class="page-header">
  <div>
    <h1>⚙️ FAZ Device Management</h1>
    <div class="subtitle">Manage FortiAnalyzer Devices &amp; FortiGate Mappings</div>
  </div>
  <nav class="header-nav">
    <a href="ip_blacklist.php" class="nav-link">
      <span>🏠</span> IP Blacklist
    </a>
    <a href="ip_blacklist.php#dashboard" class="nav-link">
      <span>📊</span> Dashboard
    </a>
    <a href="faz_devices.php" class="nav-link active">
      <span>⚙️</span> Devices
    </a>
  </nav>
</div>

<div class="container">

  <!-- FAZ Devices Table -->
  <div class="table-section">
    <div class="table-header">
      <h3>📡 Managed FAZ (FortiAnalyzer) Devices</h3>
      <button class="btn btn-primary" onclick="openModal()">
        <span>➕</span> Add FAZ Device
      </button>
    </div>
    <div class="table-scroll">
      <table>
        <thead>
          <tr>
            <th style="width:46px;">#</th>
            <th>Display Name</th>
            <th>IP Address</th>
            <th>API Token</th>
            <th style="width:180px;">Actions</th>
          </tr>
        </thead>
        <tbody id="devicesTableBody">
          <tr><td colspan="5" class="empty-state">Loading devices...</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- FortiGate Mapping Table -->
  <div class="table-section">
    <div class="table-header">
      <div style="display: flex; align-items: center; gap: 1rem;">
        <h3>🗺️ FortiGate Device Mapping</h3>
        <button class="btn" onclick="syncMappings(event)" title="Scan logs for new FortiGate devices and auto-add them">
          <span>🔄</span> Sync from Logs
        </button>
      </div>
      <button class="btn btn-primary" onclick="openMappingModal()">
        <span>➕</span> Add Mapping
      </button>
    </div>
    <div class="table-scroll">
      <table>
        <thead>
          <tr>
            <th style="width:46px;">#</th>
            <th>FAZ Name</th>
            <th>FortiGate Name</th>
            <th>Display Name</th>
            <th>Region</th>
            <th>Site</th>
            <th style="width:200px;">Actions</th>
          </tr>
        </thead>
        <tbody id="mappingsTableBody">
          <tr><td colspan="7" class="empty-state">Loading mappings...</td></tr>
        </tbody>
      </table>
    </div>
  </div>

</div><!-- /.container -->

<!-- ===== Device Modal (Add / Edit) ===== -->
<div id="deviceModal" class="modal-overlay" style="display: none;">
  <div class="modal-window">
    <div class="modal-header">
      <h3 id="modalTitle">Add FAZ Device</h3>
      <button class="modal-close" onclick="closeModal()">×</button>
    </div>
    <div class="modal-body">
      <input type="hidden" id="deviceId" value="">
      <div class="form-group">
        <label class="form-label">Display Name</label>
        <input type="text" id="deviceName" class="form-control" placeholder="e.g. FAZ-Datacenter-01">
      </div>
      <div class="form-group">
        <label class="form-label">IP Address</label>
        <input type="text" id="deviceIp" class="form-control" placeholder="e.g. 172.16.0.4">
      </div>
      <div class="form-group">
        <label class="form-label">API Token</label>
        <input type="password" id="deviceToken" class="form-control" placeholder="FortiAnalyzer API Token (leave blank to keep existing)">
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn" onclick="closeModal()">Cancel</button>
      <button class="btn btn-primary" onclick="saveDevice()">Save Device</button>
    </div>
  </div>
</div>

<!-- ===== Delete Device Modal ===== -->
<div id="deleteModal" class="modal-overlay" style="display: none;">
  <div class="modal-window">
    <div class="modal-header">
      <h3>Delete FAZ Device</h3>
      <button class="modal-close" onclick="closeDeleteModal()">×</button>
    </div>
    <div class="modal-body">
      <p>Are you sure you want to delete <strong id="deleteDeviceName"></strong>?</p>
      <p style="margin-top: 1rem; font-size: 0.85rem; color: var(--text-dim);">
        This will NOT delete its historical log data, but will remove it from the device list.
      </p>
      <input type="hidden" id="deleteDeviceId" value="">
    </div>
    <div class="modal-footer">
      <button class="btn" onclick="closeDeleteModal()">Cancel</button>
      <button class="btn btn-danger" onclick="confirmDeleteDevice()">Delete</button>
    </div>
  </div>
</div>

<!-- ===== Mapping Modal (Add / Edit) ===== -->
<div id="mappingModal" class="modal-overlay" style="display: none;">
  <div class="modal-window">
    <div class="modal-header">
      <h3 id="mappingModalTitle">Add FortiGate Mapping</h3>
      <button class="modal-close" onclick="closeMappingModal()">×</button>
    </div>
    <div class="modal-body">
      <input type="hidden" id="mappingId" value="">
      <div class="form-group">
        <label class="form-label">FAZ Name</label>
        <select id="mappingFazName" class="form-control">
          <option value="">Select FAZ Device...</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">FortiGate Name (as appears in logs)</label>
        <input type="text" id="mappingFgtName" class="form-control" placeholder="e.g. AMSTERDAM">
      </div>
      <div class="form-group">
        <label class="form-label">Display Name (shown on dashboard)</label>
        <input type="text" id="mappingDisplayName" class="form-control" placeholder="e.g. Amsterdam HQ">
      </div>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
        <div class="form-group">
          <label class="form-label">Region</label>
          <input type="text" id="mappingRegion" class="form-control" placeholder="e.g. Europe">
        </div>
        <div class="form-group">
          <label class="form-label">Site</label>
          <input type="text" id="mappingSite" class="form-control" placeholder="e.g. AMS-01">
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn" onclick="closeMappingModal()">Cancel</button>
      <button class="btn btn-primary" onclick="saveMapping()">Save Mapping</button>
    </div>
  </div>
</div>

<!-- ===== Delete Mapping Modal ===== -->
<div id="deleteMappingModal" class="modal-overlay" style="display: none;">
  <div class="modal-window">
    <div class="modal-header">
      <h3>Delete Mapping</h3>
      <button class="modal-close" onclick="closeDeleteMappingModal()">×</button>
    </div>
    <div class="modal-body">
      <p>Are you sure you want to delete the mapping for <strong id="deleteMappingName"></strong>?</p>
      <input type="hidden" id="deleteMappingId" value="">
    </div>
    <div class="modal-footer">
      <button class="btn" onclick="closeDeleteMappingModal()">Cancel</button>
      <button class="btn btn-danger" onclick="confirmDeleteMapping()">Delete</button>
    </div>
  </div>
</div>

<script>
const API = 'faz_devices_api.php';
let knownFazNames = [];

function esc(str) {
  if (!str) return '';
  return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;');
}

// ============================================================
// DEVICES
// ============================================================
async function loadDevices() {
  const tbody = document.getElementById('devicesTableBody');
  try {
    const r = await fetch(`${API}?action=list_devices`);
    const data = await r.json();

    if (!data.success) {
      tbody.innerHTML = `<tr><td colspan="5" class="empty-state" style="color:var(--accent-red)">Error: ${esc(data.error)}</td></tr>`;
      return;
    }

    if (data.devices.length === 0) {
      tbody.innerHTML = '<tr><td colspan="5" class="empty-state">No FAZ devices configured. Click "Add FAZ Device" to get started.</td></tr>';
      return;
    }

    knownFazNames = [];
    let html = '';
    data.devices.forEach((dev, i) => {
      knownFazNames.push(dev.display_name);
      html += `<tr>
        <td style="color:#999;font-weight:600;">${i + 1}</td>
        <td style="font-weight:600;color:var(--accent-cyan);">${esc(dev.display_name)}</td>
        <td style="font-family:monospace;font-size:0.85rem;">${esc(dev.ip)}</td>
        <td><span style="color:#bbb;font-size:0.8rem;letter-spacing:2px;">●●●●●●●●●●</span></td>
        <td>
          <div class="action-group">
            <div class="move-btns">
              <button class="btn btn-sm" onclick="moveDevice(${dev.id}, 'up')" title="Move Up">▲</button>
              <button class="btn btn-sm" onclick="moveDevice(${dev.id}, 'down')" title="Move Down">▼</button>
            </div>
            <button class="btn edit-dev-btn"
              data-id="${dev.id}" data-ip="${esc(dev.ip)}" data-name="${esc(dev.display_name)}"
              title="Edit">✏️</button>
            <button class="btn btn-danger delete-dev-btn"
              data-id="${dev.id}" data-name="${esc(dev.display_name)}"
              title="Delete">🗑️</button>
          </div>
        </td>
      </tr>`;
    });
    tbody.innerHTML = html;

    tbody.querySelectorAll('.edit-dev-btn').forEach(btn =>
      btn.onclick = () => editDevice(btn.dataset.id, btn.dataset.ip, btn.dataset.name)
    );
    tbody.querySelectorAll('.delete-dev-btn').forEach(btn =>
      btn.onclick = () => deleteDeviceConfirm(btn.dataset.id, btn.dataset.name)
    );
  } catch (e) {
    console.error(e);
    tbody.innerHTML = '<tr><td colspan="5" class="empty-state" style="color:var(--accent-red)">Failed to load devices.</td></tr>';
  }
}

async function moveDevice(id, direction) {
  try {
    const r = await fetch(API, { method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify({action:'move_device', id, direction}) });
    const result = await r.json();
    if (result.success) loadDevices();
    else alert(`Move failed: ${result.error}`);
  } catch (e) { alert('Failed to move device.'); }
}

function openModal() {
  document.getElementById('modalTitle').textContent = 'Add FAZ Device';
  document.getElementById('deviceId').value = '';
  document.getElementById('deviceName').value = '';
  document.getElementById('deviceIp').value = '';
  document.getElementById('deviceToken').value = '';
  document.getElementById('deviceModal').style.display = 'flex';
}

function editDevice(id, ip, name) {
  document.getElementById('modalTitle').textContent = 'Edit FAZ Device';
  document.getElementById('deviceId').value = id;
  document.getElementById('deviceName').value = name;
  document.getElementById('deviceIp').value = ip;
  document.getElementById('deviceToken').value = ''; // blank = keep existing
  document.getElementById('deviceModal').style.display = 'flex';
}

function closeModal() { document.getElementById('deviceModal').style.display = 'none'; }

async function saveDevice() {
  const id    = document.getElementById('deviceId').value;
  const name  = document.getElementById('deviceName').value.trim();
  const ip    = document.getElementById('deviceIp').value.trim();
  const token = document.getElementById('deviceToken').value.trim();

  if (!name || !ip) { alert('Display Name and IP Address are required.'); return; }
  if (!id && !token) { alert('API Token is required when adding a new device.'); return; }

  const payload = { action: id ? 'update' : 'add', id, display_name: name, ip, token };
  try {
    const r = await fetch(API, { method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify(payload) });
    const result = await r.json();
    if (result.success) { closeModal(); loadDevices(); }
    else alert(`Error: ${result.error}`);
  } catch (e) { alert('Failed to save device.'); }
}

function deleteDeviceConfirm(id, name) {
  document.getElementById('deleteDeviceId').value = id;
  document.getElementById('deleteDeviceName').textContent = name;
  document.getElementById('deleteModal').style.display = 'flex';
}
function closeDeleteModal() { document.getElementById('deleteModal').style.display = 'none'; }
async function confirmDeleteDevice() {
  const id = document.getElementById('deleteDeviceId').value;
  try {
    const r = await fetch(API, { method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({action:'delete', id}) });
    const result = await r.json();
    if (result.success) { closeDeleteModal(); loadDevices(); }
    else alert(`Error: ${result.error}`);
  } catch (e) { alert('Failed to delete device.'); }
}

// ============================================================
// MAPPINGS
// ============================================================
async function loadMappings() {
  const tbody = document.getElementById('mappingsTableBody');
  try {
    const r = await fetch(`${API}?action=list_mappings`);
    const data = await r.json();

    if (!data.success) {
      tbody.innerHTML = `<tr><td colspan="7" class="empty-state" style="color:var(--accent-red)">Error: ${esc(data.error)}</td></tr>`;
      return;
    }

    if (data.mappings.length === 0) {
      tbody.innerHTML = '<tr><td colspan="7" class="empty-state">No device mappings defined. Click "Sync from Logs" to auto-discover FortiGate devices, or "Add Mapping" to add manually.</td></tr>';
      return;
    }

    const reminder = `<span class="placeholder-red">????</span>`;
    const isPlaceholder = v => !v || v === '????';

    let html = '';
    data.mappings.forEach((m, i) => {
      const disp = isPlaceholder(m.display_name) ? reminder : `<span style="font-weight:600;color:var(--cacti-green-dk);">${esc(m.display_name)}</span>`;
      const reg  = isPlaceholder(m.region) ? reminder : esc(m.region);
      const site = isPlaceholder(m.site)   ? reminder : esc(m.site);

      html += `<tr>
        <td style="color:#999;font-weight:600;">${i + 1}</td>
        <td style="font-size:0.82rem;color:#666;">${esc(m.faz_name)}</td>
        <td style="font-family:monospace;font-size:0.82rem;">${esc(m.fgt_name)}</td>
        <td>${disp}</td>
        <td style="font-size:0.85rem;">${reg}</td>
        <td style="font-size:0.85rem;">${site}</td>
        <td>
          <div class="action-group">
            <div class="move-btns">
              <button class="btn btn-sm" onclick="moveMapping(${m.id}, 'up')" title="Move Up">▲</button>
              <button class="btn btn-sm" onclick="moveMapping(${m.id}, 'down')" title="Move Down">▼</button>
            </div>
            <button class="btn edit-map-btn"
              data-id="${m.id}" data-faz="${esc(m.faz_name)}" data-fgt="${esc(m.fgt_name)}"
              data-disp="${esc(m.display_name)}" data-reg="${esc(m.region)}" data-site="${esc(m.site)}"
              title="Edit">✏️</button>
            <button class="btn btn-danger delete-map-btn"
              data-id="${m.id}" data-name="${esc(m.display_name || m.fgt_name)}"
              title="Delete">🗑️</button>
          </div>
        </td>
      </tr>`;
    });
    tbody.innerHTML = html;

    tbody.querySelectorAll('.edit-map-btn').forEach(btn =>
      btn.onclick = () => editMapping(btn.dataset.id, btn.dataset.faz, btn.dataset.fgt, btn.dataset.disp, btn.dataset.reg, btn.dataset.site)
    );
    tbody.querySelectorAll('.delete-map-btn').forEach(btn =>
      btn.onclick = () => deleteMappingConfirm(btn.dataset.id, btn.dataset.name)
    );
  } catch (e) {
    console.error(e);
    tbody.innerHTML = '<tr><td colspan="7" class="empty-state" style="color:var(--accent-red)">Failed to load mappings.</td></tr>';
  }
}

async function moveMapping(id, direction) {
  try {
    const r = await fetch(API, { method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({action:'move_mapping', id, direction}) });
    const result = await r.json();
    if (result.success) loadMappings();
    else alert(`Move failed: ${result.error}`);
  } catch (e) { alert('Failed to move mapping.'); }
}

async function syncMappings(event) {
  const btn = event.currentTarget;
  const origHtml = btn.innerHTML;
  btn.innerHTML = '<span>⌛</span> Syncing...';
  btn.disabled = true;
  try {
    const r = await fetch(API, { method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({action:'sync_fgt_mappings'}) });
    const result = await r.json();
    if (result.success) {
      alert(`Sync complete! Added ${result.added_count} new FortiGate device(s) from logs.`);
      loadMappings();
    } else { alert(`Sync failed: ${result.error}`); }
  } catch (e) { alert('Failed to sync.'); }
  finally { btn.innerHTML = origHtml; btn.disabled = false; }
}

function openMappingModal() {
  document.getElementById('mappingModalTitle').textContent = 'Add FortiGate Mapping';
  document.getElementById('mappingId').value = '';
  document.getElementById('mappingFgtName').value = '';
  document.getElementById('mappingFgtName').readOnly = false;
  document.getElementById('mappingDisplayName').value = '';
  document.getElementById('mappingRegion').value = '';
  document.getElementById('mappingSite').value = '';
  populateFazSelect('');
  document.getElementById('mappingModal').style.display = 'flex';
}

function editMapping(id, faz, fgt, disp, reg, site) {
  document.getElementById('mappingModalTitle').textContent = 'Edit FortiGate Mapping';
  document.getElementById('mappingId').value = id;
  document.getElementById('mappingFgtName').value = fgt;
  document.getElementById('mappingFgtName').readOnly = true;
  document.getElementById('mappingDisplayName').value = disp;
  document.getElementById('mappingRegion').value = reg;
  document.getElementById('mappingSite').value = site;
  populateFazSelect(faz);
  document.getElementById('mappingModal').style.display = 'flex';
}

function populateFazSelect(selected) {
  const sel = document.getElementById('mappingFazName');
  sel.innerHTML = '<option value="">Select FAZ Device...</option>';
  knownFazNames.forEach(n => {
    sel.innerHTML += `<option value="${esc(n)}" ${n === selected ? 'selected' : ''}>${esc(n)}</option>`;
  });
}

function closeMappingModal() { document.getElementById('mappingModal').style.display = 'none'; }

async function saveMapping() {
  const id = document.getElementById('mappingId').value;
  const payload = {
    action: id ? 'update_mapping' : 'add_mapping',
    id, 
    faz_name:     document.getElementById('mappingFazName').value,
    fgt_name:     document.getElementById('mappingFgtName').value.trim(),
    display_name: document.getElementById('mappingDisplayName').value.trim(),
    region:       document.getElementById('mappingRegion').value.trim(),
    site:         document.getElementById('mappingSite').value.trim()
  };
  if (!payload.faz_name || !payload.fgt_name) { alert('FAZ Device and FortiGate Name are required.'); return; }
  try {
    const r = await fetch(API, { method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify(payload) });
    const result = await r.json();
    if (result.success) { closeMappingModal(); loadMappings(); }
    else alert(`Error: ${result.error}`);
  } catch (e) { alert('Failed to save mapping.'); }
}

function deleteMappingConfirm(id, name) {
  document.getElementById('deleteMappingId').value = id;
  document.getElementById('deleteMappingName').textContent = name;
  document.getElementById('deleteMappingModal').style.display = 'flex';
}
function closeDeleteMappingModal() { document.getElementById('deleteMappingModal').style.display = 'none'; }
async function confirmDeleteMapping() {
  const id = document.getElementById('deleteMappingId').value;
  try {
    const r = await fetch(API, { method:'POST', headers:{'Content-Type':'application/json'}, body:JSON.stringify({action:'delete_mapping', id}) });
    const result = await r.json();
    if (result.success) { closeDeleteMappingModal(); loadMappings(); }
    else alert(`Error: ${result.error}`);
  } catch (e) { alert('Failed to delete mapping.'); }
}

// ============================================================
// Init
// ============================================================
loadDevices();
loadMappings();
</script>
</body>
</html>
