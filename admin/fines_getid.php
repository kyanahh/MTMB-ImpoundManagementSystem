<?php
require("../server/connection.php");

if (isset($_POST['fineid'])) {
    $fineid = $_POST['fineid'];
    $query = $connection->prepare("SELECT fineid FROM fines WHERE fineid = ?");
    $query->bind_param("i", $fineid);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => true, 'data' => $result->fetch_assoc()]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Record not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
