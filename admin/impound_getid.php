<?php
require("../server/connection.php");

if (isset($_POST['vehicleid'])) {
    $vehicleid = $_POST['vehicleid'];
    $query = $connection->prepare("SELECT vehicleid FROM vehicles WHERE vehicleid = ?");
    $query->bind_param("s", $vehicleid);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => true, 'data' => $result->fetch_assoc()]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Vehicle not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
