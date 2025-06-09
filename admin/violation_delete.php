<?php

require("../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['violationid'])) {
    $violationid = $_POST['violationid'];

    $deleteQuery = "DELETE FROM violations WHERE violationid = '$violationid'";
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
