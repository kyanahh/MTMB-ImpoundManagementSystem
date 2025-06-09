<?php
require("../server/connection.php");
session_start(); // Make sure session is started
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicleid = $connection->real_escape_string($_POST['vehicleid'] ?? '');
    $case_type = $connection->real_escape_string($_POST['case_type'] ?? '');
    $description = $connection->real_escape_string($_POST['description'] ?? '');
    $date_reported = date("Y-m-d H:i:s");
    $status = "Open";

    // Make sure session is active and userid is set
    $investigated_by = isset($_SESSION["userid"]) ? $connection->real_escape_string($_SESSION["userid"]) : null;

    if (!$investigated_by) {
        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
        exit;
    }

    $query = "INSERT INTO investigations (vehicleid, case_type, description, status, date_reported, investigated_by) VALUES 
    ('$vehicleid', '$case_type', '$description', '$status', '$date_reported', '$investigated_by')";

    if ($connection->query($query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add information: ' . $connection->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
