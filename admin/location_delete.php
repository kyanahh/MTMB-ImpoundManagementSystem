<?php

require("../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['locationid'])) {
    $locationid = $_POST['locationid'];

    $deleteQuery = "DELETE FROM impound_locations WHERE locationid = '$locationid'";
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
