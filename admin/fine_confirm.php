<?php

require("../server/connection.php");

if (isset($_POST['fineid'])) {
    $fineid = $connection->real_escape_string($_POST['fineid']);

    // Step 1: Update the fines table
    $updateFineQuery = "UPDATE fines SET status = 'Paid' WHERE fineid = '$fineid'";
    $updateFineResult = $connection->query($updateFineQuery);

    if ($updateFineResult) {
        // Step 2: Get vehicleid and date_issued for the fine
        $fineDetailsQuery = "SELECT vehicleid, date_issued FROM fines WHERE fineid = '$fineid'";
        $fineDetailsResult = $connection->query($fineDetailsQuery);

        if ($fineDetailsResult && $fineDetailsResult->num_rows > 0) {
            $fineDetails = $fineDetailsResult->fetch_assoc();
            $vehicleid = $fineDetails['vehicleid'];
            $date_issued = $fineDetails['date_issued'];

            // Step 3: Update vehicle_violations that match the vehicleid and date_committed
            $updateViolationsQuery = "
                UPDATE vehicle_violations 
                SET is_paid = 1 
                WHERE vehicleid = '$vehicleid' AND date_committed = '$date_issued'
            ";
            $updateViolationsResult = $connection->query($updateViolationsQuery);

            if ($updateViolationsResult) {
                echo json_encode(['success' => 'Payment confirmed successfully and related violations marked as paid.']);
            } else {
                error_log("Error updating vehicle_violations: " . $connection->error);
                echo json_encode(['error' => 'Fine updated, but failed to update related violations.']);
            }
        } else {
            echo json_encode(['error' => 'Failed to fetch fine details.']);
        }
    } else {
        error_log("Error updating fine status: " . $connection->error);
        echo json_encode(['error' => 'Error confirming the payment']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

$connection->close();

?>
