<?php
require("../server/connection.php");

if (isset($_POST['violationid']) && isset($_POST['violation_type']) && isset($_POST['description']) && isset($_POST['fine_amount'])) {
    $violationid = $_POST['violationid'];
    $violation_type = $_POST['violation_type'];
    $description = $_POST['description'];
    $fine_amount = $_POST['fine_amount'];

    $query = $connection->prepare("UPDATE violations SET violation_type = ?, description = ?, fine_amount = ? WHERE violationid = ?");
    $query->bind_param("ssdi", $violation_type, $description, $fine_amount, $violationid);

    if ($query->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update information.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
