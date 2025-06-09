<?php
require("../server/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recordid = $connection->real_escape_string($_POST['recordid'] ?? '');
    $locationid = $connection->real_escape_string($_POST['locationid'] ?? '');

    // First, check if the impound record exists and get the old locationid (if any)
    $oldLocQuery = $connection->prepare("SELECT locationid FROM impound_records WHERE recordid = ?");
    $oldLocQuery->bind_param("i", $recordid);
    $oldLocQuery->execute();
    $oldLocResult = $oldLocQuery->get_result();
    
    if ($oldLocResult->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Impound record not found.']);
        exit;
    }

    $oldLocationId = $oldLocResult->fetch_assoc()['locationid'];

    // Get capacity from impound_locations for the new location
    $capQuery = $connection->prepare("SELECT capacity FROM impound_locations WHERE locationid = ?");
    $capQuery->bind_param("i", $locationid);
    $capQuery->execute();
    $capResult = $capQuery->get_result();
    
    if ($capResult->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Location not found.']);
        exit;
    }
    $capacity = $capResult->fetch_assoc()['capacity'];

    // Get latest inventory record for the new location
    $invQuery = $connection->prepare("
        SELECT occupied_slots, available_slots 
        FROM inventory 
        WHERE locationid = ? 
        ORDER BY last_updated DESC LIMIT 1
    ");
    $invQuery->bind_param("i", $locationid);
    $invQuery->execute();
    $invResult = $invQuery->get_result();

    // If no inventory yet, initialize counts
    if ($invResult->num_rows === 0) {
        $occupied_slots = 0;
        $available_slots = $capacity;
    } else {
        $row = $invResult->fetch_assoc();
        $occupied_slots = $row['occupied_slots'];
        $available_slots = $row['available_slots'];
    }

    // Check if there are available slots to assign
    if ($available_slots <= 0) {
        echo json_encode(['success' => false, 'message' => 'No available slots in this location.']);
        exit;
    }

    // If the old location is different from new location, handle freeing slot in old location
    if ($oldLocationId && $oldLocationId != $locationid) {
        // Get old location capacity and inventory
        $oldCapQuery = $connection->prepare("SELECT capacity FROM impound_locations WHERE locationid = ?");
        $oldCapQuery->bind_param("i", $oldLocationId);
        $oldCapQuery->execute();
        $oldCapResult = $oldCapQuery->get_result();
        $oldCapacity = $oldCapResult->fetch_assoc()['capacity'];

        $oldInvQuery = $connection->prepare("
            SELECT occupied_slots, available_slots 
            FROM inventory 
            WHERE locationid = ? 
            ORDER BY last_updated DESC LIMIT 1
        ");
        $oldInvQuery->bind_param("i", $oldLocationId);
        $oldInvQuery->execute();
        $oldInvResult = $oldInvQuery->get_result();

        if ($oldInvResult->num_rows === 0) {
            $oldOccupied = 0;
            $oldAvailable = $oldCapacity;
        } else {
            $oldRow = $oldInvResult->fetch_assoc();
            $oldOccupied = $oldRow['occupied_slots'];
            $oldAvailable = $oldRow['available_slots'];
        }

        // Free up one slot in old location
        $oldOccupied = max(0, $oldOccupied - 1);
        $oldAvailable = min($oldCapacity, $oldAvailable + 1);

        // Insert new inventory record for old location
        $stmtOldInv = $connection->prepare("INSERT INTO inventory (locationid, occupied_slots, available_slots, last_updated) VALUES (?, ?, ?, NOW())");
        $stmtOldInv->bind_param("iii", $oldLocationId, $oldOccupied, $oldAvailable);
        $stmtOldInv->execute();
        $stmtOldInv->close();
    }

    // Now assign the new location to impound record
    $updateImpound = $connection->prepare("UPDATE impound_records SET locationid = ? WHERE recordid = ?");
    $updateImpound->bind_param("ii", $locationid, $recordid);
    if (!$updateImpound->execute()) {
        echo json_encode(['success' => false, 'message' => 'Failed to assign location.']);
        exit;
    }

    // Update inventory for new location: increment occupied, decrement available
    $occupied_slots += 1;
    $available_slots = max(0, $available_slots - 1);

    // Insert new inventory record with updated slots
    $stmt = $connection->prepare("INSERT INTO inventory (locationid, occupied_slots, available_slots, last_updated) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iii", $locationid, $occupied_slots, $available_slots);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update inventory.']);
    }

    $stmt->close();
    $updateImpound->close();
    $connection->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
