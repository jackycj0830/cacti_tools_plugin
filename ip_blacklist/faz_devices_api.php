<?php
/**
 * FAZ Devices API — faz_devices_api.php
 * Handles CRUD operations for FAZ Devices and FortiGate Mapping tables.
 * DB-agnostic: supports both MySQL and SQLite via IPCacheDB / PDO.
 *
 * Ported from Block_IP_20260305/web/devices_api.php
 */

ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/database/IPCacheDB.php';

// ============================================================================
// DB Connection
// ============================================================================
$dbInstance = IPCacheDB::getInstance();
if (!$dbInstance->isConnected()) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . $dbInstance->getConnectionError()]);
    exit;
}
$db = $dbInstance->getPDO();

// Ensure devices and fgt_mapping tables exist
ensureDeviceTables($db);

// ============================================================================
// Parse Request
// ============================================================================
$postData = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $_GET['action'] ?? ($postData['action'] ?? 'list_devices');

// ============================================================================
// Helper: DB-agnostic "last insert id"
// ============================================================================
function lastId($db) {
    return $db->lastInsertId();
}

// ============================================================================
// Helper: Ensure tables exist
// ============================================================================
function ensureDeviceTables($db) {
    $isMySQL = (DB_TYPE !== 'sqlite');

    if ($isMySQL) {
        $db->exec("
            CREATE TABLE IF NOT EXISTS devices (
                id INT AUTO_INCREMENT PRIMARY KEY,
                ip VARCHAR(100) NOT NULL,
                display_name VARCHAR(255) NOT NULL,
                token VARCHAR(500) NOT NULL DEFAULT '',
                sort_order INT NOT NULL DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_devices_sort (sort_order)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");
        $db->exec("
            CREATE TABLE IF NOT EXISTS fgt_mapping (
                id INT AUTO_INCREMENT PRIMARY KEY,
                faz_name VARCHAR(255) NOT NULL,
                fgt_name VARCHAR(255) NOT NULL,
                display_name VARCHAR(255) NOT NULL DEFAULT '',
                region VARCHAR(100) NOT NULL DEFAULT '',
                site VARCHAR(100) NOT NULL DEFAULT '',
                sort_order INT NOT NULL DEFAULT 0,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_fgt_sort (sort_order),
                UNIQUE KEY unique_faz_fgt (faz_name, fgt_name)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");
    } else {
        $db->exec("
            CREATE TABLE IF NOT EXISTS devices (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                ip TEXT NOT NULL,
                display_name TEXT NOT NULL,
                token TEXT NOT NULL DEFAULT '',
                sort_order INTEGER NOT NULL DEFAULT 0,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP
            );
        ");
        $db->exec("
            CREATE TABLE IF NOT EXISTS fgt_mapping (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                faz_name TEXT NOT NULL,
                fgt_name TEXT NOT NULL,
                display_name TEXT NOT NULL DEFAULT '',
                region TEXT NOT NULL DEFAULT '',
                site TEXT NOT NULL DEFAULT '',
                sort_order INTEGER NOT NULL DEFAULT 0,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP,
                UNIQUE(faz_name, fgt_name)
            );
        ");
    }
}

// ============================================================================
// Helper: Get max sort_order for a table
// ============================================================================
function getMaxOrder($db, $table) {
    $stmt = $db->query("SELECT MAX(sort_order) FROM $table");
    $val = $stmt->fetchColumn();
    return ($val !== null && $val !== false) ? (int)$val : 0;
}

// ============================================================================
// Actions
// ============================================================================
switch ($action) {

    // ------------------------------------------------------------------
    // DEVICES
    // ------------------------------------------------------------------
    case 'list_devices':
        $rows = [];
        $result = $db->query("SELECT id, ip, display_name, token, sort_order FROM devices ORDER BY sort_order ASC, id ASC");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            // Mask token for display security — show only last 6 chars
            $row['token_masked'] = strlen($row['token']) > 6
                ? str_repeat('*', strlen($row['token']) - 6) . substr($row['token'], -6)
                : '******';
            $rows[] = $row;
        }
        echo json_encode(['success' => true, 'devices' => $rows]);
        break;

    case 'add':
        $ip           = trim($postData['ip'] ?? '');
        $display_name = trim($postData['display_name'] ?? '');
        $token        = trim($postData['token'] ?? '');

        if (!$ip || !$display_name || !$token) {
            echo json_encode(['success' => false, 'error' => 'Missing required fields (ip, display_name, token)']);
            break;
        }

        // Basic IP validation
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            echo json_encode(['success' => false, 'error' => 'Invalid IP address format']);
            break;
        }

        $maxOrder = getMaxOrder($db, 'devices') + 1;
        $stmt = $db->prepare("INSERT INTO devices (ip, display_name, token, sort_order) VALUES (:ip, :display_name, :token, :order)");
        $stmt->bindValue(':ip', $ip);
        $stmt->bindValue(':display_name', $display_name);
        $stmt->bindValue(':token', $token);
        $stmt->bindValue(':order', $maxOrder, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'id' => lastId($db)]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to add device']);
        }
        break;

    case 'update':
        $id           = intval($postData['id'] ?? 0);
        $ip           = trim($postData['ip'] ?? '');
        $display_name = trim($postData['display_name'] ?? '');
        $token        = trim($postData['token'] ?? '');

        if (!$id || !$ip || !$display_name) {
            echo json_encode(['success' => false, 'error' => 'Missing required fields (id, ip, display_name)']);
            break;
        }

        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            echo json_encode(['success' => false, 'error' => 'Invalid IP address format']);
            break;
        }

        // If token is blank or masked (all *), keep the existing token
        if (empty($token) || preg_match('/^\*+$/', $token)) {
            $stmt = $db->prepare("UPDATE devices SET ip = :ip, display_name = :display_name WHERE id = :id");
            $stmt->bindValue(':ip', $ip);
            $stmt->bindValue(':display_name', $display_name);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        } else {
            $stmt = $db->prepare("UPDATE devices SET ip = :ip, display_name = :display_name, token = :token WHERE id = :id");
            $stmt->bindValue(':ip', $ip);
            $stmt->bindValue(':display_name', $display_name);
            $stmt->bindValue(':token', $token);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        }

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update device']);
        }
        break;

    case 'delete':
        $id = intval($postData['id'] ?? 0);
        if (!$id) {
            echo json_encode(['success' => false, 'error' => 'Missing device ID']);
            break;
        }
        $stmt = $db->prepare("DELETE FROM devices WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to delete device']);
        }
        break;

    case 'move_device':
        $id        = intval($postData['id'] ?? 0);
        $direction = $postData['direction'] ?? '';

        if (!$id || !in_array($direction, ['up', 'down'])) {
            echo json_encode(['success' => false, 'error' => 'Invalid parameters']);
            break;
        }

        $rowStmt = $db->prepare("SELECT sort_order FROM devices WHERE id = :id");
        $rowStmt->execute([':id' => $id]);
        $current = $rowStmt->fetch(PDO::FETCH_ASSOC);
        if (!$current) {
            echo json_encode(['success' => false, 'error' => 'Record not found']);
            break;
        }
        $currentOrder = (int)$current['sort_order'];

        if ($direction === 'up') {
            $tStmt = $db->prepare("SELECT id, sort_order FROM devices WHERE sort_order < :order ORDER BY sort_order DESC LIMIT 1");
        } else {
            $tStmt = $db->prepare("SELECT id, sort_order FROM devices WHERE sort_order > :order ORDER BY sort_order ASC LIMIT 1");
        }
        $tStmt->execute([':order' => $currentOrder]);
        $target = $tStmt->fetch(PDO::FETCH_ASSOC);

        if (!$target) {
            echo json_encode(['success' => true, 'message' => 'Already at the end']);
            break;
        }

        $db->prepare("UPDATE devices SET sort_order = :o WHERE id = :id")->execute([':o' => (int)$target['sort_order'], ':id' => $id]);
        $db->prepare("UPDATE devices SET sort_order = :o WHERE id = :id")->execute([':o' => $currentOrder, ':id' => (int)$target['id']]);
        echo json_encode(['success' => true]);
        break;

    // ------------------------------------------------------------------
    // FGT MAPPINGS
    // ------------------------------------------------------------------
    case 'list_mappings':
        $rows = [];
        $result = $db->query("SELECT id, faz_name, fgt_name, display_name, region, site, sort_order FROM fgt_mapping ORDER BY sort_order ASC, id ASC");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }
        echo json_encode(['success' => true, 'mappings' => $rows]);
        break;

    case 'sync_fgt_mappings':
        // Find unique (faz_name, devname) pairs from faz_raw_events not already mapped
        if (DB_TYPE === 'sqlite') {
            $query = "
                SELECT DISTINCT faz_name, devname
                FROM faz_raw_events
                WHERE devname != 'Unknown'
                  AND (faz_name || '|' || devname) NOT IN (
                      SELECT (faz_name || '|' || fgt_name) FROM fgt_mapping
                  )
            ";
        } else {
            $query = "
                SELECT DISTINCT faz_name, devname
                FROM faz_raw_events
                WHERE devname != 'Unknown'
                  AND CONCAT(faz_name, '|', devname) NOT IN (
                      SELECT CONCAT(faz_name, '|', fgt_name) FROM fgt_mapping
                  )
            ";
        }

        $res = $db->query($query);
        $maxOrder = getMaxOrder($db, 'fgt_mapping');
        $count = 0;

        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $maxOrder++;
            $stmt = $db->prepare("
                INSERT INTO fgt_mapping (faz_name, fgt_name, display_name, region, site, sort_order)
                VALUES (:faz, :fgt, '', '', '', :order)
            ");
            $stmt->bindValue(':faz', $row['faz_name']);
            $stmt->bindValue(':fgt', $row['devname']);
            $stmt->bindValue(':order', $maxOrder, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $count++;
            }
        }
        echo json_encode(['success' => true, 'added_count' => $count]);
        break;

    case 'add_mapping':
        $faz_name     = trim($postData['faz_name'] ?? '');
        $fgt_name     = trim($postData['fgt_name'] ?? '');
        $display_name = trim($postData['display_name'] ?? '');
        $region       = trim($postData['region'] ?? '');
        $site         = trim($postData['site'] ?? '');

        if (!$faz_name || !$fgt_name) {
            echo json_encode(['success' => false, 'error' => 'Missing required fields (faz_name, fgt_name)']);
            break;
        }

        $maxOrder = getMaxOrder($db, 'fgt_mapping') + 1;
        $stmt = $db->prepare("
            INSERT INTO fgt_mapping (faz_name, fgt_name, display_name, region, site, sort_order)
            VALUES (:faz, :fgt, :disp, :reg, :site, :order)
        ");
        $stmt->bindValue(':faz', $faz_name);
        $stmt->bindValue(':fgt', $fgt_name);
        $stmt->bindValue(':disp', $display_name);
        $stmt->bindValue(':reg', $region);
        $stmt->bindValue(':site', $site);
        $stmt->bindValue(':order', $maxOrder, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'id' => lastId($db)]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to add mapping (may be a duplicate)']);
        }
        break;

    case 'update_mapping':
        $id           = intval($postData['id'] ?? 0);
        $faz_name     = trim($postData['faz_name'] ?? '');
        $fgt_name     = trim($postData['fgt_name'] ?? '');
        $display_name = trim($postData['display_name'] ?? '');
        $region       = trim($postData['region'] ?? '');
        $site         = trim($postData['site'] ?? '');

        if (!$id || !$faz_name || !$fgt_name) {
            echo json_encode(['success' => false, 'error' => 'Missing required fields (id, faz_name, fgt_name)']);
            break;
        }

        $stmt = $db->prepare("
            UPDATE fgt_mapping
            SET faz_name = :faz, fgt_name = :fgt, display_name = :disp, region = :reg, site = :site
            WHERE id = :id
        ");
        $stmt->bindValue(':faz', $faz_name);
        $stmt->bindValue(':fgt', $fgt_name);
        $stmt->bindValue(':disp', $display_name);
        $stmt->bindValue(':reg', $region);
        $stmt->bindValue(':site', $site);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update mapping']);
        }
        break;

    case 'delete_mapping':
        $id = intval($postData['id'] ?? 0);
        if (!$id) {
            echo json_encode(['success' => false, 'error' => 'Missing mapping ID']);
            break;
        }
        $stmt = $db->prepare("DELETE FROM fgt_mapping WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to delete mapping']);
        }
        break;

    case 'move_mapping':
        $id        = intval($postData['id'] ?? 0);
        $direction = $postData['direction'] ?? '';

        if (!$id || !in_array($direction, ['up', 'down'])) {
            echo json_encode(['success' => false, 'error' => 'Invalid parameters']);
            break;
        }

        $rowStmt = $db->prepare("SELECT sort_order FROM fgt_mapping WHERE id = :id");
        $rowStmt->execute([':id' => $id]);
        $current = $rowStmt->fetch(PDO::FETCH_ASSOC);
        if (!$current) {
            echo json_encode(['success' => false, 'error' => 'Record not found']);
            break;
        }
        $currentOrder = (int)$current['sort_order'];

        if ($direction === 'up') {
            $tStmt = $db->prepare("SELECT id, sort_order FROM fgt_mapping WHERE sort_order < :order ORDER BY sort_order DESC LIMIT 1");
        } else {
            $tStmt = $db->prepare("SELECT id, sort_order FROM fgt_mapping WHERE sort_order > :order ORDER BY sort_order ASC LIMIT 1");
        }
        $tStmt->execute([':order' => $currentOrder]);
        $target = $tStmt->fetch(PDO::FETCH_ASSOC);

        if (!$target) {
            echo json_encode(['success' => true, 'message' => 'Already at the end']);
            break;
        }

        $db->prepare("UPDATE fgt_mapping SET sort_order = :o WHERE id = :id")->execute([':o' => (int)$target['sort_order'], ':id' => $id]);
        $db->prepare("UPDATE fgt_mapping SET sort_order = :o WHERE id = :id")->execute([':o' => $currentOrder, ':id' => (int)$target['id']]);
        echo json_encode(['success' => true]);
        break;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Unknown action: ' . htmlspecialchars($action)]);
}
