<?php
require("../server/connection.php");
session_start();

if (isset($_POST['fineid'], $_POST['amount_paid'])) {
    $fineid = intval($_POST['fineid']);
    $amount_paid = floatval($_POST['amount_paid']);
    $received_by = $_SESSION['userid']; // or however you get logged-in user ID

    $date_paid = date('Y-m-d');

    // Insert payment record
    $stmt = $connection->prepare("INSERT INTO payments (fineid, amount_paid, date_paid, payment_method, received_by) VALUES (?, ?, ?, ?, ?)");
    $payment_method = 'Cash'; // or get from form if needed
    $stmt->bind_param("idssi", $fineid, $amount_paid, $date_paid, $payment_method, $received_by);

    if ($stmt->execute()) {
        // Update fine status to Paid
        $update_fine = $connection->prepare("UPDATE fines SET status = 'Paid' WHERE fineid = ?");
        $update_fine->bind_param("i", $fineid);
        $update_fine->execute();

        // Get vehicleid for this fineid
        $stmt_vehicle = $connection->prepare("SELECT vehicleid FROM fines WHERE fineid = ?");
        $stmt_vehicle->bind_param("i", $fineid);
        $stmt_vehicle->execute();
        $result_vehicle = $stmt_vehicle->get_result();
        $vehicleid = null;
        if ($row = $result_vehicle->fetch_assoc()) {
            $vehicleid = $row['vehicleid'];
        }

        if ($vehicleid !== null) {
            // Update vehicle_violations set is_paid = 1 where vehicleid matches
            $update_violations = $connection->prepare("UPDATE vehicle_violations SET is_paid = 1 WHERE vehicleid = ?");
            $update_violations->bind_param("i", $vehicleid);
            $update_violations->execute();

            // Update impound_records set is_paid = 1 where vehicleid matches
            $update_impound = $connection->prepare("UPDATE impound_records SET is_paid = 1 WHERE vehicleid = ?");
            $update_impound->bind_param("i", $vehicleid);
            $update_impound->execute();
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add payment.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}
?>
