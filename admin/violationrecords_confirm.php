<?php

require("../server/connection.php");

if (isset($_POST['recordid'])) {
    $recordid = $_POST['recordid'];

    $recordid = $connection->real_escape_string($recordid);

    $updateQuery = "UPDATE vehicle_violations SET is_paid = 1 WHERE recordid = '$recordid'";
    $updateResult = $connection->query($updateQuery);

    if ($updateResult) {
        echo json_encode(['success' => 'Payment confirmed successfully']);
    } else {
        error_log("Error: " . $connection->error);
        echo json_encode(['error' => 'Error confirming the payment']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

$connection->close();

?>