<?php

require("../server/connection.php");

if (isset($_POST['fineid'])) {
    $fineid = $_POST['fineid'];

    $fineid = $connection->real_escape_string($fineid);

    // Step 2: Get fineid 
    $fineDetailsQuery = "SELECT fineid, vehicleid FROM fines WHERE fineid = '$fineid'";
    $fineDetailsResult = $connection->query($fineDetailsQuery);

    if ($fineDetailsResult && $fineDetailsResult->num_rows > 0) {
        $fineDetails = $fineDetailsResult->fetch_assoc();
        $fineid = $fineDetails['fineid'];
        $vehicleid = $fineDetails['vehicleid'];

        $updateQuery = "UPDATE vehicles SET status = 'Released' WHERE vehicleid = '$vehicleid'";
        $updateResult = $connection->query($updateQuery);

        if ($updateResult) {
            echo json_encode(['success' => 'Vehicle mark as released']);
        } else {
            error_log("Error: " . $connection->error);
            echo json_encode(['error' => 'Error releasing the vehicle']);
        }

    } else {
        echo json_encode(['error' => 'Failed to fetch fine details.']);
    }


} else {
    echo json_encode(['error' => 'Invalid request']);
}

$connection->close();

?>