<?php

require("../server/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $violation_type = $connection->real_escape_string($_POST['violation_type'] ?? '');
    $description = $connection->real_escape_string($_POST['description'] ?? '');
    $fine_amount = $connection->real_escape_string($_POST['fine_amount'] ?? '');

    $query = "INSERT INTO violations (violation_type, description, fine_amount) VALUES 
    ('$violation_type', '$description', '$fine_amount')";

    if ($connection->query($query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add information.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

?>