<?php
require("../server/connection.php");

if (isset($_POST['vehicleid'])) {
    $vehicleid = $_POST['vehicleid'];

    $stmt = $connection->prepare("SELECT vehicles.*, users.firstname, users.lastname 
    FROM vehicles INNER JOIN users ON vehicles.userid = users.userid WHERE vehicleid = ?");
    $stmt->bind_param("i", $vehicleid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        echo json_encode([
            'success' => true,
            'data' => $user
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Vehicle not found'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Invalid request'
    ]);
}
?>
