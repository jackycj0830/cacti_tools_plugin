<?php
/**
 * Block_IP Dashboard — Devices API endpoint
 * Handles CRUD operations for FortiGate devices in vt_cache.db
 */

ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

$DB_PATH = realpath(__DIR__ . '/../vt_cache.db');

if (!$DB_PATH || !file_exists($DB_PATH)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database not found']);
    exit;
}

$db = new SQLite3($DB_PATH, SQLITE3_OPEN_READWRITE);

// Enable pragmas
$db->exec('PRAGMA foreign_keys = ON;');

// Parse JSON payload for POST requests
$postData = json_decode(file_get_contents('php://input'), true);
$action = $_GET['action'] ?? ($postData['action'] ?? 'list');

switch ($action) {

    case 'list_devices':
        $rows = [];
        $result = $db->query("SELECT id, ip, display_name, token, sort_order FROM devices ORDER BY sort_order ASC, id ASC");
        if ($result) {
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $rows[] = $row;
            }
        }
        echo json_encode(['success' => true, 'devices' => $rows]);
        break;

    case 'add':
        $ip = trim($postData['ip'] ?? '');
        $display_name = trim($postData['display_name'] ?? '');
        $token = trim($postData['token'] ?? '');

        if (!$ip || !$display_name || !$token) {
            echo json_encode(['success' => false, 'error' => 'Missing required fields']);
            break;
        }

        $maxOrder = $db->querySingle("SELECT MAX(sort_order) FROM devices") ?: 0;
        $maxOrder++;

        $stmt = $db->prepare("INSERT INTO devices (ip, display_name, token, sort_order) VALUES (:ip, :display_name, :token, :order)");
        $stmt->bindValue(':ip', $ip, SQLITE3_TEXT);
        $stmt->bindValue(':display_name', $display_name, SQLITE3_TEXT);
        $stmt->bindValue(':token', $token, SQLITE3_TEXT);
        $stmt->bindValue(':order', $maxOrder, SQLITE3_INTEGER);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'id' => $db->lastInsertRowID()]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to add device']);
        }
        break;

    case 'update':
        $id = intval($postData['id'] ?? 0);
        $ip = trim($postData['ip'] ?? '');
        $display_name = trim($postData['display_name'] ?? '');
        $token = trim($postData['token'] ?? '');

        if (!$id || !$ip || !$display_name || !$token) {
            echo json_encode(['success' => false, 'error' => 'Missing required fields']);
            break;
        }

        $stmt = $db->prepare("UPDATE devices SET ip = :ip, display_name = :display_name, token = :token WHERE id = :id");
        $stmt->bindValue(':ip', $ip, SQLITE3_TEXT);
        $stmt->bindValue(':display_name', $display_name, SQLITE3_TEXT);
        $stmt->bindValue(':token', $token, SQLITE3_TEXT);
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        
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
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to delete device']);
        }
        break;

    case 'list_mappings':
        $rows = [];
        $result = $db->query("SELECT id, faz_name, fgt_name, display_name, region, site, sort_order FROM fgt_mapping ORDER BY sort_order ASC, id ASC");
        if ($result) {
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $rows[] = $row;
            }
        }
        echo json_encode(['success' => true, 'mappings' => $rows]);
        break;

    case 'sync_fgt_mappings':
        // Find unique (faz_name, devname) pairs from logs that aren't in mapping
        $query = "
            SELECT DISTINCT faz_name, devname 
            FROM faz_raw_events 
            WHERE devname != 'Unknown' 
              AND (faz_name || '|' || devname) NOT IN (SELECT (faz_name || '|' || fgt_name) FROM fgt_mapping)
        ";
        $res = $db->query($query);
        
        $maxOrder = $db->querySingle("SELECT MAX(sort_order) FROM fgt_mapping") ?: 0;
        
        $count = 0;
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $maxOrder++;
            $stmt = $db->prepare("INSERT INTO fgt_mapping (faz_name, fgt_name, display_name, region, site, sort_order) VALUES (:faz, :fgt, '', '', '', :order)");
            $stmt->bindValue(':faz', $row['faz_name'], SQLITE3_TEXT);
            $stmt->bindValue(':fgt', $row['devname'], SQLITE3_TEXT);
            $stmt->bindValue(':order', $maxOrder, SQLITE3_INTEGER);
            if ($stmt->execute()) {
                $count++;
            }
        }
        echo json_encode(['success' => true, 'added_count' => $count]);
        break;

    case 'add_mapping':
        $faz_name = trim($postData['faz_name'] ?? '');
        $fgt_name = trim($postData['fgt_name'] ?? '');
        $display_name = trim($postData['display_name'] ?? '');
        $region = trim($postData['region'] ?? '');
        $site = trim($postData['site'] ?? '');

        if (!$faz_name || !$fgt_name) {
            echo json_encode(['success' => false, 'error' => 'Missing required fields']);
            break;
        }

        $maxOrder = $db->querySingle("SELECT MAX(sort_order) FROM fgt_mapping") ?: 0;
        $maxOrder++;

        $stmt = $db->prepare("INSERT INTO fgt_mapping (faz_name, fgt_name, display_name, region, site, sort_order) VALUES (:faz, :fgt, :disp, :reg, :site, :order)");
        $stmt->bindValue(':faz', $faz_name, SQLITE3_TEXT);
        $stmt->bindValue(':fgt', $fgt_name, SQLITE3_TEXT);
        $stmt->bindValue(':disp', $display_name, SQLITE3_TEXT);
        $stmt->bindValue(':reg', $region, SQLITE3_TEXT);
        $stmt->bindValue(':site', $site, SQLITE3_TEXT);
        $stmt->bindValue(':order', $maxOrder, SQLITE3_INTEGER);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'id' => $db->lastInsertRowID()]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to add mapping']);
        }
        break;

    case 'update_mapping':
        $id = intval($postData['id'] ?? 0);
        $faz_name = trim($postData['faz_name'] ?? '');
        $fgt_name = trim($postData['fgt_name'] ?? '');
        $display_name = trim($postData['display_name'] ?? '');
        $region = trim($postData['region'] ?? '');
        $site = trim($postData['site'] ?? '');

        if (!$id || !$faz_name || !$fgt_name) {
            echo json_encode(['success' => false, 'error' => 'Missing required fields']);
            break;
        }

        $stmt = $db->prepare("UPDATE fgt_mapping SET faz_name = :faz, fgt_name = :fgt, display_name = :disp, region = :reg, site = :site WHERE id = :id");
        $stmt->bindValue(':faz', $faz_name, SQLITE3_TEXT);
        $stmt->bindValue(':fgt', $fgt_name, SQLITE3_TEXT);
        $stmt->bindValue(':disp', $display_name, SQLITE3_TEXT);
        $stmt->bindValue(':reg', $region, SQLITE3_TEXT);
        $stmt->bindValue(':site', $site, SQLITE3_TEXT);
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to update mapping']);
        }
        break;

    case 'move_mapping':
        $id = intval($postData['id'] ?? 0);
        $direction = $postData['direction'] ?? ''; // 'up' or 'down'

        if (!$id || !in_array($direction, ['up', 'down'])) {
            echo json_encode(['success' => false, 'error' => 'Invalid parameters']);
            break;
        }

        // 1. Get current row's sort_order
        $currentOrder = $db->querySingle("SELECT sort_order FROM fgt_mapping WHERE id = $id");
        if ($currentOrder === false) {
            echo json_encode(['success' => false, 'error' => 'Record not found']);
            break;
        }

        // 2. Find target row to swap with
        if ($direction === 'up') {
            $target = $db->querySingle("SELECT id, sort_order FROM fgt_mapping WHERE sort_order < $currentOrder ORDER BY sort_order DESC LIMIT 1", true);
        } else {
            $target = $db->querySingle("SELECT id, sort_order FROM fgt_mapping WHERE sort_order > $currentOrder ORDER BY sort_order ASC LIMIT 1", true);
        }

        if (!$target) {
            echo json_encode(['success' => true, 'message' => 'Already at the end']);
            break;
        }

        $targetId = $target['id'];
        $targetOrder = $target['sort_order'];

        // 3. Swap sort_order
        $db->exec("UPDATE fgt_mapping SET sort_order = $targetOrder WHERE id = $id");
        $db->exec("UPDATE fgt_mapping SET sort_order = $currentOrder WHERE id = $targetId");

        echo json_encode(['success' => true]);
        break;

    case 'move_device':
        $id = intval($postData['id'] ?? 0);
        $direction = $postData['direction'] ?? ''; // 'up' or 'down'

        if (!$id || !in_array($direction, ['up', 'down'])) {
            echo json_encode(['success' => false, 'error' => 'Invalid parameters']);
            break;
        }

        // 1. Get current row's sort_order
        $currentOrder = $db->querySingle("SELECT sort_order FROM devices WHERE id = $id");
        if ($currentOrder === false) {
            echo json_encode(['success' => false, 'error' => 'Record not found']);
            break;
        }

        // 2. Find target row to swap with
        if ($direction === 'up') {
            $target = $db->querySingle("SELECT id, sort_order FROM devices WHERE sort_order < $currentOrder ORDER BY sort_order DESC LIMIT 1", true);
        } else {
            $target = $db->querySingle("SELECT id, sort_order FROM devices WHERE sort_order > $currentOrder ORDER BY sort_order ASC LIMIT 1", true);
        }

        if (!$target) {
            echo json_encode(['success' => true, 'message' => 'Already at the end']);
            break;
        }

        $targetId = $target['id'];
        $targetOrder = $target['sort_order'];

        // 3. Swap sort_order
        $db->exec("UPDATE devices SET sort_order = $targetOrder WHERE id = $id");
        $db->exec("UPDATE devices SET sort_order = $currentOrder WHERE id = $targetId");

        echo json_encode(['success' => true]);
        break;

    case 'delete_mapping':
        $id = intval($postData['id'] ?? 0);
        if (!$id) {
            echo json_encode(['success' => false, 'error' => 'Missing mapping ID']);
            break;
        }
        $stmt = $db->prepare("DELETE FROM fgt_mapping WHERE id = :id");
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to delete mapping']);
        }
        break;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Unknown action']);
}

$db->close();
