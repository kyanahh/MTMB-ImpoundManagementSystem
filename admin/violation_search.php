<?php

require("../server/connection.php");

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
    if (!empty($query)) {
        $sql = "SELECT * FROM violations 
                WHERE (violation_type LIKE '%$query%' 
                OR description LIKE '%$query%' 
                OR fine_amount LIKE '%$query%') ORDER BY violationid DESC";
    } else {
        $sql = "SELECT * FROM violations ORDER BY violationid DESC";
    }

    $result = mysqli_query($connection, $sql);

    if ($result->num_rows > 0) {
        $count = 1; 

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . $row['violation_type'] . '</td>';
            echo '<td>' . $row['description'] . '</td>';
            echo '<td>' . $row['fine_amount'] . '</td>';
            echo '<td>';
            echo '<div class="d-flex justify-content-center">';
            echo '<button class="btn btn-primary me-2" onclick="edit(' . $row['violationid'] . ')"><i class="bi bi-pencil-square"></i></button>';
            echo '<button class="btn btn-danger" onclick="delete(' . $row['violationid'] . ')"><i class="bi bi-trash"></i></button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            $count++; 
        }
    } else {
        echo '<tr><td colspan="5">No violations found.</td></tr>';
    }
}

?>