<?php

require("../server/connection.php");

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
    if (!empty($query)) {
        $sql = "SELECT * FROM impound_locations 
                WHERE (area_name LIKE '%$query%' 
                OR description LIKE '%$query%' 
                OR capacity LIKE '%$query%') ORDER BY locationid DESC";
    } else {
        $sql = "SELECT * FROM impound_locations ORDER BY locationid DESC";
    }

    $result = mysqli_query($connection, $sql);

    if ($result->num_rows > 0) {
        $count = 1; 

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . $row['area_name'] . '</td>';
            echo '<td>' . $row['description'] . '</td>';
            echo '<td>' . $row['capacity'] . '</td>';
            echo '<td>';
            echo '<div class="d-flex justify-content-center">';
            echo '<button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#editModal" onclick="loadData(' . $row['locationid'] . ')"><i class="bi bi-pencil-square"></i></button>';
            echo '<button class="btn btn-danger" onclick="del(' . $row['locationid'] . ')"><i class="bi bi-trash"></i></button>';
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