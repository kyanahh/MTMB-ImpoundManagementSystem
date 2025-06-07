<?php

require("../server/connection.php");

if (isset($_POST['recordid'])) {
    $recordid = $connection->real_escape_string($_POST['recordid']);

    // Step 1: Get vehicleid from impound_records
    $vehicleQuery = "SELECT vehicleid FROM impound_records WHERE recordid = '$recordid'";
    $vehicleResult = $connection->query($vehicleQuery);

    if ($vehicleResult && $vehicleResult->num_rows > 0) {
        $vehicleRow = $vehicleResult->fetch_assoc();
        $vehicleid = $vehicleRow['vehicleid'];

        // Step 2: Update impound_records
        $updateImpoundQuery = "UPDATE impound_records SET release_status = 'Unclaimed', locationid = 0 WHERE recordid = '$recordid'";
        $updateImpoundResult = $connection->query($updateImpoundQuery);

        // Step 3: Update vehicles table
        if ($updateImpoundResult) {
            $updateVehicleQuery = "UPDATE vehicles SET status = 'Unclaimed' WHERE vehicleid = '$vehicleid'";
            $updateVehicleResult = $connection->query($updateVehicleQuery);

            if ($updateVehicleResult) {
                echo json_encode(['success' => 'Vehicle marked as unclaimed']);
            } else {
                error_log("Vehicle Table Error: " . $connection->error);
                echo json_encode(['error' => 'Failed to update vehicle status.']);
            }
        } else {
            error_log("Impound Table Error: " . $connection->error);
            echo json_encode(['error' => 'Failed to update impound record.']);
        }
    } else {
        echo json_encode(['error' => 'Vehicle ID not found.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

$connection->close();
?>
