<?php
require("../server/connection.php");

if (isset($_POST['recordid'])) {
    $recordid = intval($_POST['recordid']);

    // Get the vehicleid from impound_records
    $impound_query = $connection->prepare("SELECT vehicleid FROM impound_records WHERE recordid = ?");
    $impound_query->bind_param('i', $recordid);
    $impound_query->execute();
    $impound_result = $impound_query->get_result();

    if ($impound_result->num_rows > 0) {
        $row = $impound_result->fetch_assoc();
        $vehicleid = $row['vehicleid'];

        // Get the fineid for this vehicle that is unpaid
        $fine_query = $connection->prepare("SELECT fineid FROM fines WHERE vehicleid = ? AND status = 'Unpaid' LIMIT 1");
        $fine_query->bind_param('i', $vehicleid);
        $fine_query->execute();
        $fine_result = $fine_query->get_result();

        if ($fine_result->num_rows > 0) {
            $fine_row = $fine_result->fetch_assoc();
            echo json_encode(['success' => true, 'data' => ['fineid' => $fine_row['fineid']]]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No unpaid fine found for this vehicle.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Impound record not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
