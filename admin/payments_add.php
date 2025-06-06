<?php
session_start();  // Make sure session is started
require("../server/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fineid = $connection->real_escape_string($_POST['fineid'] ?? '');
    $amount_paid = floatval($_POST['amount_paid'] ?? 0);
    $date_paid = date("Y-m-d");
    $payment_method = "Cash";
    $received_by = isset($_SESSION["userid"]) ? $connection->real_escape_string($_SESSION["userid"]) : null;

    if (!$received_by) {
        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
        exit;
    }

    // Get the total_amount from fines table
    $fineQuery = "SELECT total_amount FROM fines WHERE fineid = ?";
    if ($fineStmt = $connection->prepare($fineQuery)) {
        $fineStmt->bind_param("i", $fineid);
        $fineStmt->execute();
        $fineResult = $fineStmt->get_result();

        if ($fineResult->num_rows === 0) {
            echo json_encode(['success' => false, 'message' => 'Fine not found.']);
            exit;
        }

        $fineData = $fineResult->fetch_assoc();
        $total_amount = floatval($fineData['total_amount']);

        // Validate if amount paid is exact
        if ($amount_paid < $total_amount) {
            echo json_encode(['success' => false, 'message' => 'Please pay the exact amount of ₱' . number_format($total_amount, 2)]);
            exit;
        }

        // Proceed with inserting payment
        $query = "INSERT INTO payments (fineid, amount_paid, date_paid, payment_method, received_by) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $connection->prepare($query)) {
            $stmt->bind_param("idssi", $fineid, $amount_paid, $date_paid, $payment_method, $received_by);

            if ($stmt->execute()) {
                // Update status to "Paid" in fines table
                $updateQuery = "UPDATE fines SET status = 'Paid' WHERE fineid = ?";
                $updateStmt = $connection->prepare($updateQuery);
                $updateStmt->bind_param("i", $fineid);
                $updateStmt->execute();
                $updateStmt->close();

                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add payment.']);
            }
            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to prepare payment insert.']);
        }

    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare fine check.']);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

$connection->close();
?>
