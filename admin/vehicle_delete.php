<?php

require("../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['vehicleid'])) {
    $vehicleid = $_POST['vehicleid'];

    $deleteQuery = "DELETE FROM vehicles WHERE vehicleid = '$vehicleid'";
    $deleteResult = $connection->query($deleteQuery);

    if ($deleteResult) {
        echo json_encode(array('success' => 'Vehicle deleted successfully'));
    } else {
        echo json_encode(array('error' => 'Error deleting vehicle: ' . $connection->error));
    }

} else {
    echo json_encode(array('error' => 'Invalid request'));
}

$connection->close();

?>
