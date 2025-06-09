<?php

require("../server/connection.php");

if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($connection, $_POST['query']);
    if (!empty($query)) {
        $sql = "SELECT 
                    payments.*, 
                    fines.fineid, 
                    fines.total_amount, 
                    vehicles.platenumber,
                    users.firstname, 
                    users.lastname  
                FROM payments 
                INNER JOIN fines ON payments.fineid = fines.fineid 
                INNER JOIN vehicles ON fines.vehicleid = vehicles.vehicleid
                INNER JOIN users ON payments.received_by = users.userid 
                WHERE (vehicles.platenumber LIKE '%$query%' 
                OR fines.total_amount LIKE '%$query%' 
                OR users.firstname LIKE '%$query%' 
                OR users.lastname LIKE '%$query%' 
                OR DATE_FORMAT(payments.date_paid, '%M %d, %Y') LIKE '%$query%' 
                OR DATE_FORMAT(payments.date_paid, '%m/%d/%Y') LIKE '%$query%'
                OR payments.date_paid LIKE '%$query%' 
                OR payments.amount_paid LIKE '%$query%' 
                OR payments.payment_method LIKE '%$query%') ORDER BY paymentid DESC";
    } else {
        $sql = "SELECT 
                    payments.*, 
                    fines.fineid, 
                    fines.total_amount, 
                    vehicles.platenumber,
                    users.firstname, 
                    users.lastname  
                FROM payments 
                INNER JOIN fines ON payments.fineid = fines.fineid 
                INNER JOIN vehicles ON fines.vehicleid = vehicles.vehicleid
                INNER JOIN users ON payments.received_by = users.userid 
                ORDER BY paymentid DESC";
    }

    $result = mysqli_query($connection, $sql);

    if ($result->num_rows > 0) {
        $count = 1; 

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $count . '</td>';
            echo '<td>' . $row['fineid'] . '</td>';
            echo '<td>' . $row['total_amount'] . '</td>';
            echo '<td>' . $row['amount_paid'] . '</td>';
            $balance = $row['total_amount'] - $row['amount_paid'];
            echo '<td>' . $balance . '</td>';
            echo '<td>' . date("F d, Y", strtotime($row['date_paid'])) . '</td>';
            echo '<td>' . $row['payment_method'] . '</td>';
            echo '<td>' . $row['received_by'] . '</td>';
            echo '<td>';
            echo '<div class="d-flex justify-content-center">';
            echo '<button class="btn btn-sm btn-secondary" onclick="printReceipt(' . $row['paymentid'] . ')">';
            echo '<i class="bi bi-printer"></i>'; 
            echo '</button>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
            $count++; 
        }
    } else {
        echo '<tr><td colspan="5">No payment found.</td></tr>';
    }
}

?>