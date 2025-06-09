<?php

require("../server/connection.php");

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
    if (!empty($query)) {
        $sql = "SELECT vehicle_violations.*, vehicles.platenumber, 
                violations.violation_type, violations.fine_amount  
                FROM vehicle_violations INNER JOIN vehicles 
                ON vehicle_violations.vehicleid = vehicles.vehicleid 
                INNER JOIN violations ON vehicle_violations.violationid = violations.violationid 
                WHERE (violations.violation_type LIKE '%$query%' 
                OR vehicles.platenumber LIKE '%$query%' 
                OR vehicle_violations.remarks LIKE '%$query%' 
                OR DATE_FORMAT(vehicle_violations.date_committed, '%M %d, %Y') LIKE '%$query%' 
                OR DATE_FORMAT(vehicle_violations.date_committed, '%m/%d/%Y') LIKE '%$query%'
                OR vehicle_violations.date_committed LIKE '%$query%') 
                ORDER BY recordid DESC";
    } else {
        $sql = "SELECT vehicle_violations.*, vehicles.platenumber, 
                violations.violation_type, violations.fine_amount  
                FROM vehicle_violations INNER JOIN vehicles 
                ON vehicle_violations.vehicleid = vehicles.vehicleid 
                INNER JOIN violations ON vehicle_violations.violationid = violations.violationid 
                ORDER BY recordid DESC";
    }

    $result = mysqli_query($connection, $sql);

    if ($result->num_rows > 0) {
        $count = 1; 

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . $row['platenumber'] . '</td>';
            echo '<td>' . $row['violation_type'] . '</td>';
            echo '<td>' . $row['fine_amount'] . '</td>';
            echo '<td>' . date("F d, Y", strtotime($row['date_committed'])) . '</td>';
            echo '<td>' . ($row['is_paid'] == 1 ? 'Yes' : 'No') . '</td>';
            echo '<td>' . $row['remarks'] . '</td>';
            echo '<td>';
            echo '<div class="d-flex justify-content-center">';
            if ($row['is_paid'] == 0) {
            echo '<button title="Paid" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#confirmModal" onclick="openConfirmModal(' . $row['recordid'] . ')"><i class="bi bi-check"></i></button>';
            }
            echo '<button title="Delete" class="btn btn-danger" onclick="del(' . $row['recordid'] . ')"><i class="bi bi-trash"></i></button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            $count++; 
        }
    } else {
        echo '<tr><td colspan="5">No vehicle violations found.</td></tr>';
    }
}

?>