<?php

require("../server/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $locationid = $connection->real_escape_string($_POST['locationid'] ?? '');
    $occupied_slots = $connection->real_escape_string($_POST['occupied_slots'] ?? '');
    $available_slots = $connection->real_escape_string($_POST['available_slots'] ?? '');
    $last_updated = date("Y-m-d H:i:s");

    $query = "INSERT INTO inventory (locationid, occupied_slots, available_slots, last_updated) VALUES 
    ('$locationid', '$occupied_slots', '$available_slots', '$last_updated')";

    if ($connection->query($query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add information.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

?>