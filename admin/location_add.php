<?php

require("../server/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $area_name = $connection->real_escape_string($_POST['area_name'] ?? '');
    $description = $connection->real_escape_string($_POST['description'] ?? '');
    $capacity = $connection->real_escape_string($_POST['capacity'] ?? '');

    $query = "INSERT INTO impound_locations (area_name, description, capacity) VALUES 
    ('$area_name', '$description', '$capacity')";

    if ($connection->query($query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add information.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

?>