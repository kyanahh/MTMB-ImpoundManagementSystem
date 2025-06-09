<?php

require("../server/connection.php");

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
    if (!empty($query)) {
        $sql = "SELECT vehicles.*, users.firstname, users.lastname 
                FROM vehicles INNER JOIN users 
                ON vehicles.userid = users.userid
                WHERE (users.userid LIKE '%$query%' 
                OR users.firstname LIKE '%$query%' 
                OR users.lastname LIKE '%$query%' 
                OR vehicles.platenumber LIKE '%$query%' 
                OR vehicles.vehicle_type LIKE '%$query%' 
                OR vehicles.model LIKE '%$query%' 
                OR vehicles.color LIKE '%$query%' 
                OR vehicles.status LIKE '%$query%' 
                OR DATE_FORMAT(vehicles.registration_date, '%M %d, %Y') LIKE '%$query%' 
                OR DATE_FORMAT(vehicles.registration_date, '%m/%d/%Y') LIKE '%$query%'
                OR vehicles.registration_date LIKE '%$query%') ORDER BY vehicleid DESC";
    } else {
        $sql = "SELECT vehicles.*, users.firstname, users.lastname 
                FROM vehicles INNER JOIN users 
                ON vehicles.userid = users.userid ORDER BY vehicleid DESC";
    }

    $result = mysqli_query($connection, $sql);

    if ($result->num_rows > 0) {
        $count = 1; 

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . $row['userid'] . '</td>';
            echo '<td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
            echo '<td>' . $row['platenumber'] . '</td>';
            echo '<td>' . $row['vehicle_type'] . '</td>';
            echo '<td>' . $row['model'] . '</td>';
            echo '<td>' . $row['color'] . '</td>';
            echo '<td>' . date("F d, Y", strtotime($row['registration_date'])) . '</td>';
            echo '<td>' . $row['status'] . '</td>';
            echo '<td>';
            echo '<div class="d-flex justify-content-center">';
            echo '<button title="View" class="btn btn-info me-2" onclick="view(' . $row['vehicleid'] . ')"><i class="bi bi-eye"></i></button>';
            echo '<button title="Edit" class="btn btn-primary me-2" onclick="edit(' . $row['vehicleid'] . ')"><i class="bi bi-pencil-square"></i></button>';
            echo '<button title="Delete" class="btn btn-danger" onclick="del(' . $row['vehicleid'] . ')"><i class="bi bi-trash"></i></button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            $count++; 
        }
    } else {
        echo '<tr><td colspan="5">No vehicles found.</td></tr>';
    }
}

?>