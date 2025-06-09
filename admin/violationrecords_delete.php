<?php

require("../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['recordid'])) {
    $recordid = $connection->real_escape_string($_POST['recordid']);

    // Step 1: Get details before deletion
    $getDetailsQuery = "
        SELECT v.vehicleid, v.violationid, v.date_committed, vio.fine_amount
        FROM vehicle_violations v
        JOIN violations vio ON v.violationid = vio.violationid
        WHERE v.recordid = '$recordid'
    ";

    $detailsResult = $connection->query($getDetailsQuery);

    if ($detailsResult && $detailsResult->num_rows > 0) {
        $row = $detailsResult->fetch_assoc();
        $vehicleid = $row['vehicleid'];
        $violationid = $row['violationid'];
        $date_committed = $row['date_committed'];
        $fine_amount = $row['fine_amount'];

        // Step 2: Update the fines total_amount
        $updateFineQuery = "
            UPDATE fines 
            SET total_amount = total_amount - $fine_amount
            WHERE vehicleid = '$vehicleid' AND date_issued = '$date_committed'
        ";
        $updateResult = $connection->query($updateFineQuery);

        if (!$updateResult) {
            echo json_encode(['error' => 'Failed to update fines: ' . $connection->error]);
            exit;
        }

        // Step 3: Optionally delete the fine record if total_amount is now zero
        $deleteZeroFineQuery = "
            DELETE FROM fines 
            WHERE vehicleid = '$vehicleid' AND date_issued = '$date_committed' AND total_amount <= 0
        ";
        $connection->query($deleteZeroFineQuery);

        // Step 4: Delete the vehicle violation record
        $deleteViolationQuery = "DELETE FROM vehicle_violations WHERE recordid = '$recordid'";
        $deleteResult = $connection->query($deleteViolationQuery);

        if ($deleteResult) {
            echo json_encode(['success' => 'Information deleted successfully']);
        } else {
            echo json_encode(['error' => 'Error deleting violation: ' . $connection->error]);
        }
    } else {
        echo json_encode(['error' => 'Violation record not found.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

$connection->close();
?>
