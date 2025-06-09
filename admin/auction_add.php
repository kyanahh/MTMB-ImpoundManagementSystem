<?php
require("../server/connection.php");
session_start(); 
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicleid = $connection->real_escape_string($_POST['vehicleid'] ?? '');
    $schedule_date = $connection->real_escape_string($_POST['schedule_date'] ?? '');
    $starting_bid = $connection->real_escape_string($_POST['starting_bid'] ?? '');
    $date_reported = date("Y-m-d H:i:s");
    $status = "Open";

    $investigated_by = isset($_SESSION["userid"]) ? $connection->real_escape_string($_SESSION["userid"]) : null;

    if (!$investigated_by) {
        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
        exit;
    }

    $query = "INSERT INTO auctions (vehicleid, schedule_date, starting_bid, status) VALUES 
    ('$vehicleid', '$schedule_date', '$starting_bid', '$status')";

    $updateQuery = "UPDATE vehicles SET status = 'For Auction' WHERE vehicleid = '$vehicleid'";
    $connection->query($updateQuery);

    if ($connection->query($query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add information: ' . $connection->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
