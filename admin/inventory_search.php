<?php

require("../server/connection.php");

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
    if (!empty($query)) {
        $sql = "SELECT inventory.*, impound_locations.area_name, impound_locations.capacity 
                FROM inventory INNER JOIN impound_locations
                ON inventory.locationid = impound_locations.locationid 
                WHERE (impound_locations.area_name LIKE '%$query%' 
                OR inventory.occupied_slots LIKE '%$query%' 
                OR impound_locations.capacity LIKE '%$query%'
                OR inventory.available_slots LIKE '%$query%') ORDER BY inventoryid DESC";
    } else {
        $sql = "SELECT inventory.*, impound_locations.area_name, impound_locations.capacity 
                FROM inventory INNER JOIN impound_locations
                ON inventory.locationid = impound_locations.locationid ORDER BY inventoryid DESC";
    }

    $result = mysqli_query($connection, $sql);

    if ($result->num_rows > 0) {
        $count = 1; 

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . $row['area_name'] . '</td>';
            echo '<td>' . $row['capacity'] . '</td>';
            echo '<td>' . $row['occupied_slots'] . '</td>';
            echo '<td>' . $row['available_slots'] . '</td>';
            echo '<td>' . $row['last_updated'] . '</td>';
            echo '<td>';
            echo '<div class="d-flex justify-content-center">';
            echo '<button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#editModal" onclick="loadData(' . $row['inventoryid'] . ')"><i class="bi bi-pencil-square"></i></button>';
            echo '<button class="btn btn-danger" onclick="del(' . $row['inventoryid'] . ')"><i class="bi bi-trash"></i></button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            $count++; 
        }
    } else {
        echo '<tr><td colspan="5">No area found.</td></tr>';
    }
}

?>