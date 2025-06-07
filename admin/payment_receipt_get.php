<?php
// get_payment_receipt.php

header('Content-Type: application/json');
require("../server/connection.php");   

if (isset($_POST['paymentid'])) {
    $paymentid = intval($_POST['paymentid']);

    $stmt = $connection->prepare("
        SELECT 
            payments.paymentid, 
            fines.fineid, 
            fines.total_amount, 
            vehicles.platenumber,
            payments.amount_paid, 
            (payments.amount_paid - fines.total_amount) AS change_amount, 
            payments.date_paid, 
            payments.payment_method, 
            CONCAT(users.firstname, ' ', users.lastname) AS received_by
        FROM payments 
        INNER JOIN fines ON payments.fineid = fines.fineid
        INNER JOIN vehicles ON fines.vehicleid = vehicles.vehicleid
        INNER JOIN users ON payments.received_by = users.userid
        WHERE payments.paymentid = ?
    ");
    
    $stmt->bind_param("i", $paymentid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $payment = $result->fetch_assoc();

        // Format date nicely
        $payment['date_paid'] = date("F d, Y", strtotime($payment['date_paid']));

        echo json_encode([
            'success' => true,
            'paymentid' => $payment['paymentid'],
            'fineid' => $payment['fineid'],
            'platenumber' => $payment['platenumber'],
            'total_amount' => number_format($payment['total_amount'], 2),
            'amount_paid' => number_format($payment['amount_paid'], 2),
            'change_amount' => number_format($payment['change_amount'], 2),
            'date_paid' => $payment['date_paid'],
            'payment_method' => $payment['payment_method'],
            'received_by' => $payment['received_by']
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>
