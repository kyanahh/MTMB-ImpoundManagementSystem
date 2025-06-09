<?php

require("../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['fineid'])) {
    $fineid = $connection->real_escape_string($_POST['fineid']);

    // Step 1: Get vehicleid and date_issued from the fine record before deletion
    $fineQuery = "SELECT vehicleid, date_issued FROM fines WHERE fineid = '$fineid'";
    $fineResult = $connection->query($fineQuery);

    if ($fineResult && $fineResult->num_rows > 0) {
        $fineData = $fineResult->fetch_assoc();
        $vehicleid = $fineData['vehicleid'];
        $date_issued = $fineData['date_issued'];

        // Step 2: Delete related records in vehicle_violations
        $deleteViolationsQuery = "
            DELETE FROM vehicle_violations 
            WHERE vehicleid = '$vehicleid' AND date_committed = '$date_issued'
        ";
        $deleteViolationsResult = $connection->query($deleteViolationsQuery);

        // Step 3: Delete the fine record
        $deleteFineQuery = "DELETE FROM fines WHERE fineid = '$fineid'";
        $deleteFineResult = $connection->query($deleteFineQuery);

        if ($deleteFineResult) {
            echo json_encode(['success' => 'Fine and related violations deleted successfully']);
        } else {
            echo json_encode(['error' => 'Error deleting fine record: ' . $connection->error]);
        }
    } else {
        echo json_encode(['error' => 'Fine not found']);
    }

} else {
    echo json_encode(['error' => 'Invalid request']);
}

$connection->close();

?>
