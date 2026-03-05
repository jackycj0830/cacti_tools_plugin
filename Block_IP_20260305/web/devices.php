<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Block_IP — Device Management</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
  --glow-blue: rgba(79,143,247,0.15);
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

.container { max-width: 1400px; margin: 0 auto; padding: 2rem; }

/* Table Section */
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
.table-header h3 { font-size: 1.1rem; font-weight: 600; }

table { width: 100%; border-collapse: collapse; }
thead th {
  text-align: left;
  padding: 0.75rem 1rem;
  font-size: 0.8rem;
  font-weight: 600;
  color: var(--text-dim);
  text-transform: uppercase;
  letter-spacing: 0.05em;
  border-bottom: 1px solid var(--border);
  background: var(--bg-card);
}
tbody td {
  text-align: left;
  padding: 1rem 1rem;
  font-size: 0.9rem;
  border-bottom: 1px solid rgba(42,46,62,0.5);
}
tbody tr { transition: background 0.15s; }
tbody tr:hover { background: var(--bg-card-hover); }
tbody tr:last-child td { border-bottom: none; }

.btn {
  background: var(--bg-card-hover);
  color: var(--text);
  border: 1px solid var(--border);
  padding: 0.5rem 1rem;
  border-radius: 8px;
  font-weight: 500;
  font-size: 0.85rem;
  cursor: pointer;
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
}
.btn:hover { background: var(--border); }
.btn-primary {
  background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
  color: white;
  border: none;
}
.btn-primary:hover { opacity: 0.9; transform: translateY(-1px); }
.btn-danger {
  background: rgba(247,79,111,0.1);
  color: var(--accent-red);
  border-color: rgba(247,79,111,0.3);
}
.btn-danger:hover { background: rgba(247,79,111,0.2); }

.placeholder-red {
  color: var(--accent-red);
  font-weight: bold;
}

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
  max-width: 500px;
  box-shadow: 0 10px 40px rgba(0,0,0,0.5);
  animation: slideUp 0.3s ease-out;
}
@keyframes slideUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.modal-header {
  padding: 1rem 1.5rem;
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.modal-header h3 { font-size: 1.1rem; color: var(--text); }
.modal-close {
  background: none; border: none; color: var(--text-dim);
  font-size: 1.5rem; cursor: pointer; padding: 0 0.5rem;
}
.modal-close:hover { color: var(--text); }

.modal-body { padding: 1.5rem; }
.form-group { margin-bottom: 1.5rem; }
.form-label {
  display: block;
  font-size: 0.85rem;
  color: var(--text-dim);
  margin-bottom: 0.5rem;
  font-weight: 500;
}
.form-control {
  width: 100%;
  background: var(--bg-primary);
  border: 1px solid var(--border);
  color: var(--text);
  padding: 0.75rem 1rem;
  border-radius: 8px;
  font-family: inherit;
  font-size: 0.95rem;
  transition: border-color 0.2s;
}
.form-control:focus { outline: none; border-color: var(--accent-blue); }
.modal-footer {
  padding: 1.25rem 1.5rem;
  border-top: 1px solid var(--border);
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
}

.empty-state { text-align: center; padding: 3rem; color: var(--text-dim); }
</style>
</head>
<body>

<div class="header">
  <div>
    <h1>🛡️ Block_IP Security Dashboard</h1>
    <div class="subtitle">FortiAnalyzer SSLVPN Brute-Force IP Analysis</div>
  </div>
  <div class="header-right" style="display: flex; gap: 1rem; align-items: center;">
    <a href="index.php" style="color: var(--text-dim); text-decoration: none; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 0.4rem; padding: 0.5rem 0.8rem; border-radius: 8px; transition: background 0.2s;" onmouseover="this.style.color='var(--text)'; this.style.background='var(--bg-card)';" onmouseout="this.style.color='var(--text-dim)'; this.style.background='transparent';">
      <span class="icon" style="font-size: 1.1rem;">📊</span> Dashboard
    </a>
    <a href="devices.php" style="color: var(--text); text-decoration: none; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 0.4rem; padding: 0.5rem 0.8rem; border-radius: 8px; background: var(--bg-card); border: 1px solid var(--border); transition: background 0.2s;">
      <span class="icon" style="font-size: 1.1rem;">⚙️</span> Devices
    </a>
  </div>
</div>

<div class="container">
  <div class="table-section">
    <div class="table-header">
      <h3>📡 Managed FAZ (FortiAnalyzer) Devices</h3>
      <button class="btn btn-primary" onclick="openModal()">
        <span class="icon">➕</span> Add FAZ
      </button>
    </div>
    <div class="table-scroll">
      <table>
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th>FAZ Name</th>
            <th>IP Address</th>
            <th>Token (Hidden)</th>
            <th style="width: 200px;">Actions</th>
          </tr>
        </thead>
        <tbody id="devicesTableBody">
          <tr><td colspan="5" class="empty-state">Loading devices...</td></tr>
        </tbody>
      </table>
    </div>
  </div>
  
  <div class="table-section">
    <div class="table-header">
      <div style="display: flex; align-items: center; gap: 1rem;">
        <h3>🗺️ FortiGate Device Mapping</h3>
        <button class="btn" onclick="syncMappings()" title="Scan logs for new FortiGate devices">
          <span class="icon">🔄</span> Sync from Logs
        </button>
      </div>
      <button class="btn btn-primary" onclick="openMappingModal()">
        <span class="icon">➕</span> Add Mapping
      </button>
    </div>
    <div class="table-scroll">
      <table>
        <thead>
          <tr>
            <th style="width: 50px;">#</th>
            <th>FAZ Name</th>
            <th>FortiGate Name</th>
            <th>Display Name</th>
            <th>Region</th>
            <th>Site</th>
            <th style="width: 200px;">Actions</th>
          </tr>
        </thead>
        <tbody id="mappingsTableBody">
          <tr><td colspan="7" class="empty-state">Loading mappings...</td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Device Modal -->
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
        <input type="text" id="deviceName" class="form-control" placeholder="e.g. FW-Datacenter-01">
      </div>
      <div class="form-group">
        <label class="form-label">IP Address</label>
        <input type="text" id="deviceIp" class="form-control" placeholder="e.g. 172.16.0.4">
      </div>
      <div class="form-group">
        <label class="form-label">API Token</label>
        <input type="password" id="deviceToken" class="form-control" placeholder="FortiAnalyzer API Token">
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn" onclick="closeModal()">Cancel</button>
      <button class="btn btn-primary" onclick="saveDevice()">Save Device</button>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal-overlay" style="display: none;">
  <div class="modal-window">
    <div class="modal-header">
      <h3>Delete Device</h3>
      <button class="modal-close" onclick="closeDeleteModal()">×</button>
    </div>
    <div class="modal-body">
      <p>Are you sure you want to delete <strong id="deleteDeviceName"></strong>?</p>
      <p style="margin-top: 1rem; font-size: 0.85rem; color: var(--text-dim);">This will NOT delete its historical logs, but will stop polling it for future events.</p>
      <input type="hidden" id="deleteDeviceId" value="">
    </div>
    <div class="modal-footer">
      <button class="btn" onclick="closeDeleteModal()">Cancel</button>
      <button class="btn btn-danger" onclick="confirmDeleteDevice()">Delete</button>
    </div>
  </div>
</div>

<!-- Mapping Modal -->
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
          <option value="">Select FAZ...</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">FortiGate Name (as in logs)</label>
        <input type="text" id="mappingFgtName" class="form-control" placeholder="e.g. AMSTERDAM" id="mappingFgtName">
      </div>
      <div class="form-group">
        <label class="form-label">Display Name (Dashboard Label)</label>
        <input type="text" id="mappingDisplayName" class="form-control" placeholder="e.g. Amsterdam HQ">
      </div>
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
          <div class="form-group">
            <label class="form-label">Region (Human Input)</label>
            <input type="text" id="mappingRegion" class="form-control" placeholder="e.g. Europe">
          </div>
          <div class="form-group">
            <label class="form-label">Site (Human Input)</label>
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

<!-- Delete Mapping Modal -->
<div id="deleteMappingModal" class="modal-overlay" style="display: none;">
  <div class="modal-window">
    <div class="modal-header">
      <h3>Delete Mapping</h3>
      <button class="modal-close" onclick="closeDeleteMappingModal()">×</button>
    </div>
    <div class="modal-body">
      <p>Are you sure you want to delete mapping for <strong id="deleteMappingName"></strong>?</p>
      <input type="hidden" id="deleteMappingId" value="">
    </div>
    <div class="modal-footer">
      <button class="btn" onclick="closeDeleteMappingModal()">Cancel</button>
      <button class="btn btn-danger" onclick="confirmDeleteMapping()">Delete</button>
    </div>
  </div>
</div>

<script>
const API = 'devices_api.php';

async function loadDevices() {
  const tbody = document.getElementById('devicesTableBody');
  try {
    const r = await fetch(`${API}?action=list_devices`);
    const data = await r.json();
    
    if (!data.success) {
      tbody.innerHTML = `<tr><td colspan="5" class="empty-state" style="color: var(--accent-red)">Error: ${data.error}</td></tr>`;
      return;
    }

    if (data.devices.length === 0) {
      tbody.innerHTML = '<tr><td colspan="5" class="empty-state">No FAZ devices configured.</td></tr>';
      return;
    }

    let html = '';
    knownFazNames = [];
    data.devices.forEach((dev, index) => {
      knownFazNames.push(dev.display_name);
      
      const escapeHTML = (str) => {
          if (!str) return '';
          return str.toString().replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
      };

      html += `<tr>
        <td style="color: var(--text-muted); font-weight: 600;">${index + 1}</td>
        <td style="font-weight: 600; color: var(--accent-cyan);">${escapeHTML(dev.display_name)}</td>
        <td style="font-family: monospace; font-size: 0.9rem;">${escapeHTML(dev.ip)}</td>
        <td><span style="color: var(--text-muted); font-size: 0.8rem;">●●●●●●●●●●●●</span></td>
        <td>
          <div style="display: flex; gap: 0.5rem; align-items: center;">
            <div style="display: flex; flex-direction: column; gap: 2px;">
                <button class="btn btn-sm" onclick="moveDevice(${dev.id}, 'up')" style="padding: 2px 6px; font-size: 10px;" title="Move Up">▲</button>
                <button class="btn btn-sm" onclick="moveDevice(${dev.id}, 'down')" style="padding: 2px 6px; font-size: 10px;" title="Move Down">▼</button>
            </div>
            <button class="btn edit-dev-btn" 
              data-id="${dev.id}" 
              data-ip="${escapeHTML(dev.ip)}" 
              data-name="${escapeHTML(dev.display_name)}" 
              data-token="${escapeHTML(dev.token)}" 
              title="Edit">✏️</button>
            <button class="btn btn-danger delete-dev-btn" 
              data-id="${dev.id}" 
              data-name="${escapeHTML(dev.display_name)}" 
              title="Delete">🗑️</button>
          </div>
        </td>
      </tr>`;
    });
    tbody.innerHTML = html;

    // Attach listeners
    tbody.querySelectorAll('.edit-dev-btn').forEach(btn => {
        btn.onclick = () => editDevice(btn.dataset.id, btn.dataset.ip, btn.dataset.name, btn.dataset.token);
    });
    tbody.querySelectorAll('.delete-dev-btn').forEach(btn => {
        btn.onclick = () => deleteDevice(btn.dataset.id, btn.dataset.name);
    });

  } catch (e) {
    console.error(e);
    tbody.innerHTML = `<tr><td colspan="5" class="empty-state" style="color: var(--accent-red)">Failed to load devices.</td></tr>`;
  }
}

async function moveDevice(id, direction) {
  try {
    const r = await fetch(API, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'move_device', id: id, direction: direction })
    });
    const result = await r.json();
    if (result.success) {
        loadDevices();
    } else {
        alert(`Move failed: ${result.error}`);
    }
  } catch (e) {
    alert('Failed to move device.');
  }
}

function openModal() {
  document.getElementById('modalTitle').textContent = 'Add FAZ Device';
  document.getElementById('deviceId').value = '';
  document.getElementById('deviceName').value = '';
  document.getElementById('deviceIp').value = '';
  document.getElementById('deviceToken').value = '';
  document.getElementById('deviceModal').style.display = 'flex';
}

function editDevice(id, ip, name, token) {
  document.getElementById('modalTitle').textContent = 'Edit FAZ Device';
  document.getElementById('deviceId').value = id;
  document.getElementById('deviceName').value = name;
  document.getElementById('deviceIp').value = ip;
  document.getElementById('deviceToken').value = token;
  document.getElementById('deviceModal').style.display = 'flex';
}

function closeModal() {
  document.getElementById('deviceModal').style.display = 'none';
}

async function saveDevice() {
  const id = document.getElementById('deviceId').value;
  const name = document.getElementById('deviceName').value.trim();
  const ip = document.getElementById('deviceIp').value.trim();
  const token = document.getElementById('deviceToken').value.trim();

  if (!name || !ip || !token) {
    alert('Please fill in all fields.');
    return;
  }

  const payload = {
    action: id ? 'update' : 'add',
    id: id,
    display_name: name,
    ip: ip,
    token: token
  };

  try {
    const r = await fetch(API, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    });
    const result = await r.json();

    if (result.success) {
      closeModal();
      loadDevices();
    } else {
      alert(`Error saving device: ${result.error}`);
    }
  } catch (e) {
    console.error(e);
    alert('Failed to save device. Check console.');
  }
}

function deleteDevice(id, name) {
  document.getElementById('deleteDeviceId').value = id;
  document.getElementById('deleteDeviceName').textContent = name;
  document.getElementById('deleteModal').style.display = 'flex';
}

function closeDeleteModal() {
  document.getElementById('deleteModal').style.display = 'none';
}

async function confirmDeleteDevice() {
  const id = document.getElementById('deleteDeviceId').value;
  if (!id) return;

  try {
    const r = await fetch(API, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ action: 'delete', id: id })
    });
    const result = await r.json();

    if (result.success) {
      closeDeleteModal();
      loadDevices();
    } else {
      alert(`Error deleting device: ${result.error}`);
    }
  } catch (e) {
    console.error(e);
    alert('Failed to delete device. Check console.');
  }
}

// --- Mapping Logic ---

let knownFazNames = [];

async function loadMappings() {
  const tbody = document.getElementById('mappingsTableBody');
  try {
    const r = await fetch(`${API}?action=list_mappings`);
    const data = await r.json();
    
    if (!data.success) {
      tbody.innerHTML = `<tr><td colspan="7" class="empty-state" style="color: var(--accent-red)">Error: ${data.error}</td></tr>`;
      return;
    }

    if (data.mappings.length === 0) {
      tbody.innerHTML = '<tr><td colspan="7" class="empty-state">No device mappings defined. Click "Sync from Logs" to auto-discover FortiGate devices.</td></tr>';
      return;
    }

    let html = '';
    const reminder = `<span style="color: var(--accent-red); font-weight: bold; font-family: monospace;">????</span>`;

    data.mappings.forEach((m, index) => {
      const escapeHTML = (str) => {
          if (!str) return '';
          return str.toString().replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
      };
      
      const isPlaceholder = (val) => !val || val === '????';
      
      const disp = isPlaceholder(m.display_name) ? reminder : `<span style="font-weight: 600; color: var(--accent-purple);">${escapeHTML(m.display_name)}</span>`;
      const reg  = isPlaceholder(m.region) ? reminder : escapeHTML(m.region);
      const site = isPlaceholder(m.site) ? reminder : escapeHTML(m.site);

      html += `<tr>
        <td style="color: var(--text-muted); font-weight: 600;">${index + 1}</td>
        <td>${escapeHTML(m.faz_name)}</td>
        <td>${escapeHTML(m.fgt_name)}</td>
        <td>${disp}</td>
        <td>${reg}</td>
        <td>${site}</td>
        <td>
          <div style="display: flex; gap: 0.5rem; align-items: center;">
            <div style="display: flex; flex-direction: column; gap: 2px;">
                <button class="btn btn-sm" onclick="moveMapping(${m.id}, 'up')" style="padding: 2px 6px; font-size: 10px;" title="Move Up">▲</button>
                <button class="btn btn-sm" onclick="moveMapping(${m.id}, 'down')" style="padding: 2px 6px; font-size: 10px;" title="Move Down">▼</button>
            </div>
            <button class="btn edit-map-btn" 
              data-id="${m.id}" 
              data-faz="${escapeHTML(m.faz_name)}" 
              data-fgt="${escapeHTML(m.fgt_name)}" 
              data-disp="${escapeHTML(m.display_name)}" 
              data-reg="${escapeHTML(m.region)}" 
              data-site="${escapeHTML(m.site)}" 
              title="Edit">✏️</button>
            <button class="btn btn-danger delete-map-btn" 
              data-id="${m.id}" 
              data-name="${escapeHTML(m.display_name || m.fgt_name)}" 
              title="Delete">🗑️</button>
          </div>
        </td>
      </tr>`;
    });
    tbody.innerHTML = html;

    // Attach listeners
    tbody.querySelectorAll('.edit-map-btn').forEach(btn => {
        btn.onclick = () => editMapping(btn.dataset.id, btn.dataset.faz, btn.dataset.fgt, btn.dataset.disp, btn.dataset.reg, btn.dataset.site);
    });
    tbody.querySelectorAll('.delete-map-btn').forEach(btn => {
        btn.onclick = () => deleteMapping(btn.dataset.id, btn.dataset.name);
    });

  } catch (e) {
    console.error(e);
    tbody.innerHTML = `<tr><td colspan="7" class="empty-state" style="color: var(--accent-red)">Failed to load mappings.</td></tr>`;
  }
}

async function moveMapping(id, direction) {
  try {
    const r = await fetch(API, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'move_mapping', id: id, direction: direction })
    });
    const result = await r.json();
    if (result.success) {
        loadMappings();
    } else {
        alert(`Move failed: ${result.error}`);
    }
  } catch (e) {
    alert('Failed to move mapping.');
  }
}

async function syncMappings() {
  const btn = event.currentTarget;
  const originalHtml = btn.innerHTML;
  btn.innerHTML = '<span class="icon">⌛</span> Syncing...';
  btn.disabled = true;

  try {
    const r = await fetch(API, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'sync_fgt_mappings' })
    });
    const result = await r.json();
    if (result.success) {
        alert(`System synced! Identified ${result.added_count} new FortiGate devices from logs.`);
        loadMappings();
    } else {
        alert(`Sync failed: ${result.error}`);
    }
  } catch (e) {
    alert('Failed to sync mappings.');
  } finally {
    btn.innerHTML = originalHtml;
    btn.disabled = false;
  }
}

function openMappingModal() {
  document.getElementById('mappingModalTitle').textContent = 'Add FortiGate Mapping';
  document.getElementById('mappingId').value = '';
  document.getElementById('mappingFgtName').value = '';
  document.getElementById('mappingFgtName').readOnly = false;
  document.getElementById('mappingDisplayName').value = '';
  document.getElementById('mappingRegion').value = '';
  document.getElementById('mappingSite').value = '';
  
  // Populate FAZ dropdown
  const select = document.getElementById('mappingFazName');
  select.innerHTML = '<option value="">Select FAZ...</option>';
  knownFazNames.forEach(name => {
    select.innerHTML += `<option value="${name}">${name}</option>`;
  });
  
  document.getElementById('mappingModal').style.display = 'flex';
}

function editMapping(id, faz, fgt, disp, reg, site) {
  document.getElementById('mappingModalTitle').textContent = 'Edit FortiGate Mapping';
  document.getElementById('mappingId').value = id;
  
  const select = document.getElementById('mappingFazName');
  select.innerHTML = '<option value="">Select FAZ...</option>';
  knownFazNames.forEach(name => {
    select.innerHTML += `<option value="${name}" ${name === faz ? 'selected' : ''}>${name}</option>`;
  });
  
  document.getElementById('mappingFgtName').value = fgt;
  document.getElementById('mappingFgtName').readOnly = true;
  document.getElementById('mappingDisplayName').value = disp;
  document.getElementById('mappingRegion').value = reg;
  document.getElementById('mappingSite').value = site;
  document.getElementById('mappingModal').style.display = 'flex';
}

function closeMappingModal() {
  document.getElementById('mappingModal').style.display = 'none';
}

async function saveMapping() {
  const id = document.getElementById('mappingId').value;
  const payload = {
    action: id ? 'update_mapping' : 'add_mapping',
    id: id,
    faz_name: document.getElementById('mappingFazName').value,
    fgt_name: document.getElementById('mappingFgtName').value.trim(),
    display_name: document.getElementById('mappingDisplayName').value.trim(),
    region: document.getElementById('mappingRegion').value.trim(),
    site: document.getElementById('mappingSite').value.trim()
  };

  if (!payload.faz_name || !payload.fgt_name) {
    alert('FAZ and FortiGate Name are required.');
    return;
  }

  try {
    const r = await fetch(API, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    });
    const result = await r.json();
    if (result.success) {
      closeMappingModal();
      loadMappings();
    } else {
      alert(`Error: ${result.error}`);
    }
  } catch (e) {
    alert('Failed to save mapping.');
  }
}

function deleteMapping(id, name) {
  document.getElementById('deleteMappingId').value = id;
  document.getElementById('deleteMappingName').textContent = name;
  document.getElementById('deleteMappingModal').style.display = 'flex';
}

function closeDeleteMappingModal() {
  document.getElementById('deleteMappingModal').style.display = 'none';
}

async function confirmDeleteMapping() {
  const id = document.getElementById('deleteMappingId').value;
  try {
    const r = await fetch(API, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ action: 'delete_mapping', id: id })
    });
    const result = await r.json();
    if (result.success) {
      closeDeleteMappingModal();
      loadMappings();
    } else {
      alert(`Error: ${result.error}`);
    }
  } catch (e) {
    alert('Failed to delete mapping.');
  }
}

// Initial load
loadDevices();
loadMappings();
</script>

</body>
</html>
