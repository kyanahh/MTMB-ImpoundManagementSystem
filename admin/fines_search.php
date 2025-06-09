<?php

require("../server/connection.php");

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
    if (!empty($query)) {
        $sql = "SELECT fines.*, vehicles.platenumber 
                FROM fines INNER JOIN vehicles 
                ON fines.vehicleid = vehicles.vehicleid 
                WHERE (vehicles.platenumber LIKE '%$query%' 
                OR DATE_FORMAT(fines.date_issued, '%M %d, %Y') LIKE '%$query%' 
                OR DATE_FORMAT(fines.date_issued, '%m/%d/%Y') LIKE '%$query%'
                OR DATE_FORMAT(fines.due_date, '%M %d, %Y') LIKE '%$query%' 
                OR DATE_FORMAT(fines.due_date, '%m/%d/%Y') LIKE '%$query%'
                OR fines.date_issued LIKE '%$query%' 
                OR fines.due_date LIKE '%$query%' 
                OR fines.total_amount LIKE '%$query%' 
                OR fines.status LIKE '%$query%') 
                ORDER BY fineid DESC";
    } else {
        $sql = "SELECT fines.*, vehicles.platenumber 
                FROM fines INNER JOIN vehicles 
                ON fines.vehicleid = vehicles.vehicleid 
                ORDER BY fineid DESC";
    }

    $result = mysqli_query($connection, $sql);

    if ($result->num_rows > 0) {
        $count = 1; 

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . $row['platenumber'] . '</td>';
            echo '<td>' . $row['total_amount'] . '</td>';
            echo '<td>' . date("F d, Y", strtotime($row['date_issued'])) . '</td>';
            echo '<td>' . date("F d, Y", strtotime($row['due_date'])) . '</td>';
            echo '<td>' . $row['status'] . '</td>';
            echo '<td>';
            echo '<div class="d-flex justify-content-center">';
            if ($row['status'] == "Unpaid") {
            echo '<button title="Add Payment" class="btn btn-primary me-2" data-bs-toggle="modal" 
            data-bs-target="#addModal" onclick="openAddModal(' . $row['fineid'] . ')">
            </i><i class="bi bi-cash-stack"></i></button>';
            echo '<button title="Paid" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#confirmModal" onclick="openConfirmModal(' . $row['fineid'] . ')"><i class="bi bi-check"></i></button>';
            }
            echo '<button title="Delete" class="btn btn-danger" onclick="del(' . $row['fineid'] . ')"><i class="bi bi-trash"></i></button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            $count++; 
        }
    } else {
        echo '<tr><td colspan="5">No fines found.</td></tr>';
    }
}

?>