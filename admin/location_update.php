<?php
require("../server/connection.php");

if (isset($_POST['locationid']) && isset($_POST['area_name']) && isset($_POST['description']) && isset($_POST['capacity'])) {
    $locationid = $_POST['locationid'];
    $area_name = $_POST['area_name'];
    $description = $_POST['description'];
    $capacity = $_POST['capacity'];

    $query = $connection->prepare("UPDATE impound_locations SET area_name = ?, description = ?, capacity = ? WHERE locationid = ?");
    $query->bind_param("ssii", $area_name, $description, $capacity, $locationid);

    if ($query->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update information.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
