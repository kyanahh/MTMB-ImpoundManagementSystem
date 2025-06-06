<?php
require("../server/connection.php");

if (isset($_POST['inventoryid'])) {
    $inventoryid = $_POST['inventoryid'];
    $query = $connection->prepare("SELECT * FROM inventory WHERE inventoryid = ?");
    $query->bind_param("i", $inventoryid);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => true, 'data' => $result->fetch_assoc()]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Inventory not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
