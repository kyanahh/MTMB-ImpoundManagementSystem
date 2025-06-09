<?php

require("../server/connection.php");

if (isset($_POST['investigationid'])) {
    $investigationid = $_POST['investigationid'];

    $investigationid = $connection->real_escape_string($investigationid);

    $updateQuery = "UPDATE investigations SET status = 'Closed' WHERE investigationid = '$investigationid'";
    $updateResult = $connection->query($updateQuery);

    if ($updateResult) {
        echo json_encode(['success' => 'Case closed successfully']);
    } else {
        error_log("Error: " . $connection->error);
        echo json_encode(['error' => 'Error closing the case']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

$connection->close();

?>