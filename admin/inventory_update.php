<?php
require("../server/connection.php");

if (isset($_POST['inventoryid']) && isset($_POST['locationid']) && isset($_POST['occupied_slots']) && isset($_POST['available_slots'])) {
    $inventoryid = $_POST['inventoryid'];
    $locationid = $_POST['locationid'];
    $occupied_slots = $_POST['occupied_slots'];
    $available_slots = $_POST['available_slots'];
    $last_updated = date("Y-m-d H:i:s");

    $query = $connection->prepare("UPDATE inventory SET locationid = ?, occupied_slots = ?, available_slots = ?, 
    last_updated = ? WHERE inventoryid = ?");
    $query->bind_param("iiisi", $locationid, $occupied_slots, $available_slots, $last_updated, $inventoryid);

    if ($query->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update information.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
