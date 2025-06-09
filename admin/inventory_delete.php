<?php

require("../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['inventoryid'])) {
    $inventoryid = $_POST['inventoryid'];

    $deleteQuery = "DELETE FROM inventory WHERE inventoryid = '$inventoryid'";
    $deleteResult = $connection->query($deleteQuery);

    if ($deleteResult) {
        echo json_encode(array('success' => 'Information deleted successfully'));
    } else {
        echo json_encode(array('error' => 'Error deleting information: ' . $connection->error));
    }

} else {
    echo json_encode(array('error' => 'Invalid request'));
}

$connection->close();

?>
