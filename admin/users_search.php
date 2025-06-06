<?php

require("../server/connection.php");

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
    if (!empty($query)) {
        $sql = "SELECT * FROM users 
                WHERE (userid LIKE '%$query%' 
                OR firstname LIKE '%$query%' 
                OR lastname LIKE '%$query%' 
                OR email LIKE '%$query%' 
                OR DATE_FORMAT(users.bday, '%M %d, %Y') LIKE '%$query%' 
                OR DATE_FORMAT(users.bday, '%m/%d/%Y') LIKE '%$query%'
                OR gender LIKE '%$query%' 
                OR phone LIKE '%$query%' 
                OR usertype LIKE '%$query%') ORDER BY userid DESC";
    } else {
        $sql = "SELECT * FROM users ORDER BY userid DESC";
    }

    $result = mysqli_query($connection, $sql);

    if ($result->num_rows > 0) {
        $count = 1; 

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . $row['userid'] . '</td>';
            echo '<td>' . $row['firstname'] . '</td>';
            echo '<td>' . $row['lastname'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>' . date("F d, Y", strtotime($row['bday'])) . '</td>';
            echo '<td>' . $row['gender'] . '</td>';
            echo '<td>' . $row['phone'] . '</td>';
            echo '<td>' . $row['usertype'] . '</td>';
            echo '<td>';
            echo '<div class="d-flex justify-content-center">';
            echo '<button class="btn btn-info me-2" onclick="viewUser(' . $row['userid'] . ')">View</button>';
            echo '<button class="btn btn-primary me-2" onclick="editUser(' . $row['userid'] . ')">Edit</button>';
            echo '<button class="btn btn-danger" onclick="deleteUser(' . $row['userid'] . ')">Delete</button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            $count++; 
        }
    } else {
        echo '<tr><td colspan="5">No users found.</td></tr>';
    }
}

?>