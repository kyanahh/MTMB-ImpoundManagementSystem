<?php
session_start();  
require("../server/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicleid = $connection->real_escape_string($_POST['vehicleid'] ?? '');
    $date_impounded = $connection->real_escape_string($_POST['date_impounded'] ?? '');
    $reason = $connection->real_escape_string($_POST['reason'] ?? '');
    $remarks = $connection->real_escape_string($_POST['remarks'] ?? '');
    $impounded_by = isset($_SESSION["userid"]) ? $connection->real_escape_string($_SESSION["userid"]) : null;
    $release_status = "Pending";
    $locationid = 0;
    $violationid = 27; // Automatic violation for impound
    $remarks_violation = "Automatic violation due to impound";
    $is_paid = 0;
    $status = "Unpaid";
    $max_storage_days = 30;

    if (!$impounded_by) {
        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
        exit;
    }

    $release_date_obj = new DateTime($date_impounded);
    $release_date_obj->modify("+{$max_storage_days} days");
    $release_date = $release_date_obj->format('Y-m-d');

    // Step 1: Insert into impound_records
    $query = "INSERT INTO impound_records (vehicleid, date_impounded, reason, remarks, impounded_by, release_status, locationid, release_date, is_paid) 
              VALUES ('$vehicleid', '$date_impounded', '$reason', '$remarks', '$impounded_by', '$release_status', '$locationid', '$release_date', '$is_paid')";

    if (!$connection->query($query)) {
        echo json_encode(['success' => false, 'message' => 'Failed to insert into impound_records.']);
        exit;
    }

    // Step 2: Update vehicle status to 'Impound'
    $updateQuery = "UPDATE vehicles SET status = 'Impound' WHERE vehicleid = '$vehicleid'";
    $connection->query($updateQuery); // Safe to continue even if it fails

    // Step 3: Insert into vehicle_violations
    $violationQuery = "INSERT INTO vehicle_violations (vehicleid, violationid, date_committed, is_paid, remarks)
                       VALUES ('$vehicleid', '$violationid', '$date_impounded', '$is_paid', '$remarks_violation')";

    if (!$connection->query($violationQuery)) {
        echo json_encode(['success' => false, 'message' => 'Failed to add vehicle violation.']);
        exit;
    }

    // Step 4: Get fine_amount from violations table
    $fineAmountQuery = "SELECT fine_amount FROM violations WHERE violationid = '$violationid'";
    $fineResult = $connection->query($fineAmountQuery);
    $fineAmount = 0;

    if ($fineResult && $fineResult->num_rows > 0) {
        $fineRow = $fineResult->fetch_assoc();
        $fineAmount = $fineRow['fine_amount'];
    } else {
        echo json_encode(['success' => false, 'message' => 'Violation not found for impound fine.']);
        exit;
    }

    // Step 5: Check if a fines record already exists for this vehicle and date
    $checkFinesQuery = "SELECT fineid, total_amount FROM fines 
                        WHERE vehicleid = '$vehicleid' AND date_issued = '$date_impounded'";
    $checkFinesResult = $connection->query($checkFinesQuery);

    if ($checkFinesResult->num_rows > 0) {
        // Existing fines record — update total
        $fine = $checkFinesResult->fetch_assoc();
        $updatedAmount = $fine['total_amount'] + $fineAmount;
        $updateFines = "UPDATE fines 
                        SET total_amount = '$updatedAmount' 
                        WHERE fineid = '{$fine['fineid']}'";
        $connection->query($updateFines);
    } else {
        // New fine record
        $due_date = date('Y-m-d', strtotime($date_impounded . ' +10 days'));
        $insertFines = "INSERT INTO fines (vehicleid, total_amount, date_issued, due_date, status) 
                        VALUES ('$vehicleid', '$fineAmount', '$date_impounded', '$due_date', '$status')";
        $connection->query($insertFines);
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
