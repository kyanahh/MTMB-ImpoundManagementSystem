<?php

require("../server/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicleid = $connection->real_escape_string($_POST['vehicleid'] ?? '');
    $violationid = $connection->real_escape_string($_POST['violationid'] ?? '');
    $date_committed = $connection->real_escape_string($_POST['date_committed'] ?? '');
    $remarks = $connection->real_escape_string($_POST['remarks'] ?? '');
    $is_paid = 0;

    // Step 1: Insert into vehicle_violations
    $insertViolation = "INSERT INTO vehicle_violations (vehicleid, violationid, date_committed, remarks, is_paid) 
                        VALUES ('$vehicleid', '$violationid', '$date_committed', '$remarks', '$is_paid')";

    if (!$connection->query($insertViolation)) {
        echo json_encode(['success' => false, 'message' => 'Failed to add violation.']);
        exit;
    }

    // Step 2: Get fine_amount from violations table
    $fineAmountQuery = "SELECT fine_amount FROM violations WHERE violationid = '$violationid'";
    $fineResult = $connection->query($fineAmountQuery);
    $fineAmount = 0;

    if ($fineResult && $fineResult->num_rows > 0) {
        $fineRow = $fineResult->fetch_assoc();
        $fineAmount = $fineRow['fine_amount'];
    } else {
        echo json_encode(['success' => false, 'message' => 'Violation not found.']);
        exit;
    }

    // Step 3: Check if a fines record already exists for this vehicle and date
    $checkFinesQuery = "SELECT fineid, total_amount FROM fines 
                        WHERE vehicleid = '$vehicleid' AND date_issued = '$date_committed'";
    $checkFinesResult = $connection->query($checkFinesQuery);

    if ($checkFinesResult->num_rows > 0) {
        // Existing fines record for the day — update total_amount
        $fine = $checkFinesResult->fetch_assoc();
        $updatedAmount = $fine['total_amount'] + $fineAmount;
        $updateFines = "UPDATE fines 
                        SET total_amount = '$updatedAmount' 
                        WHERE fineid = '{$fine['fineid']}'";
        $connection->query($updateFines);
    } else {
        // New fine record for this vehicle and day
        $due_date = date('Y-m-d', strtotime($date_committed . ' +10 days'));
        $status = 'Unpaid';

        $insertFines = "INSERT INTO fines (vehicleid, total_amount, date_issued, due_date, status) 
                        VALUES ('$vehicleid', '$fineAmount', '$date_committed', '$due_date', '$status')";
        $connection->query($insertFines);
    }

    // ─── Step 4: Mark vehicle status as "Violation" ───
    $updateVehicle = "UPDATE vehicles 
                      SET status = 'Violation' 
                      WHERE vehicleid = '$vehicleid'";
    if (! $connection->query($updateVehicle)) {
        // Log, but don’t break the response
        error_log("Failed to update vehicle status for ID $vehicleid: " . $connection->error);
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
