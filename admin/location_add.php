<?php
require("../server/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $area_name = $connection->real_escape_string($_POST['area_name'] ?? '');
    $description = $connection->real_escape_string($_POST['description'] ?? '');
    $capacity = intval($_POST['capacity'] ?? 0);

    // Start transaction to keep data consistent
    $connection->begin_transaction();

    try {
        // Insert into impound_locations
        $stmt = $connection->prepare("INSERT INTO impound_locations (area_name, description, capacity) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $area_name, $description, $capacity);
        if (!$stmt->execute()) {
            throw new Exception('Failed to add impound location.');
        }

        // Get inserted locationid
        $locationid = $connection->insert_id;

        // Insert corresponding inventory record
        $stmt2 = $connection->prepare("INSERT INTO inventory (locationid, occupied_slots, available_slots, last_updated) VALUES (?, 0, ?, NOW())");
        $stmt2->bind_param("ii", $locationid, $capacity);
        if (!$stmt2->execute()) {
            throw new Exception('Failed to add inventory record.');
        }

        // Commit if both inserts succeed
        $connection->commit();

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $connection->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
