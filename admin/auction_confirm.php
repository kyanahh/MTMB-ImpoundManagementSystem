<?php

require("../server/connection.php");

if (isset($_POST['auctionid'])) {
    $auctionid = $_POST['auctionid'];

    $auctionid = $connection->real_escape_string($auctionid);

    $updateQuery = "UPDATE auctions SET status = 'Auctioned' WHERE auctionid = '$auctionid'";
    $updateResult = $connection->query($updateQuery);

    if ($updateResult) {
        echo json_encode(['success' => 'Vehicle mark as auctioned']);
    } else {
        error_log("Error: " . $connection->error);
        echo json_encode(['error' => 'Error closing the case']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

$connection->close();

?>