<?php
require("../server/connection.php");

if (isset($_POST['violationid'])) {
    $violationid = $_POST['violationid'];
    $query = $connection->prepare("SELECT * FROM violations WHERE violationid = ?");
    $query->bind_param("i", $violationid);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => true, 'data' => $result->fetch_assoc()]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Violation not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
