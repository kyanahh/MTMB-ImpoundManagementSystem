<?php

session_start();

require("../server/connection.php");   

if(isset($_SESSION["logged_in"])){
    if(isset($_SESSION["firstname"]) || isset($_SESSION["email"])){
        $textaccount = $_SESSION["firstname"];
        $useremail = $_SESSION["email"];
        $usersid = $_SESSION["userid"];
    }else{
        $textaccount = "Account";
    }
}else{
    $textaccount = "Account";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MTMB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="admin.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <div class="main-container d-flex">
        <div class="sidebar bg-primary" id="side_nav">
            <div class="header-box px-2 pt-3 pb-4 d-flex justify-content-between">
                <h1 class="fs-4 ps-3 pt-3">
                <span class="text-white fw-bold">MTMB</span></h1>
                <button class="btn d-md-none d-block close-btn px-1 py-0 text-white"><i class="fal fa-stream"></i></button>
            </div>

            <ul class="list-unstyled px-2 text-dark">

                <li>
                    <a href="dashboard.php" class="text-decoration-none px-3 py-2 d-block">
                        <i class="fal fa-home me-2"></i>Dashboard
                    </a>
                </li>

                <li>
                    <a href="users.php" class="text-decoration-none px-3 py-2 d-block">
                    <i class="bi bi-person-square me-2"></i>Users
                    </a>
                </li>

                <li>
                    <a class="text-decoration-none px-3 py-2 d-block dropdown-toggle text-white" data-bs-toggle="collapse" href="#violationMenu" role="button" aria-expanded="false" aria-controls="violationMenu">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>Violation Management
                    </a>
                    <div class="collapse ps-4" id="violationMenu">
                        <ul class="list-unstyled">
                            <li>
                                <a href="vehicles.php" class="nav-link text-white">
                                    <i class="bi bi-car-front me-2"></i>Vehicles
                                </a>
                            </li>
                            <li>
                                <a href="violations.php" class="nav-link text-white mt-2">
                                    <i class="bi bi-clipboard2-x me-2"></i>Violations
                                </a>
                            </li>
                            <li>
                                <a href="violationrecords.php" class="nav-link text-white mt-2">
                                    <i class="bi bi-file-earmark-text me-2"></i>Violation Records
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a class="text-decoration-none px-3 py-2 d-block dropdown-toggle text-white" data-bs-toggle="collapse" href="#paymentMenu" role="button" aria-expanded="false" aria-controls="paymentMenu">
                        <i class="bi bi-cash-coin me-2"></i>Payment Management
                    </a>
                    <div class="collapse ps-4" id="paymentMenu">
                        <ul class="list-unstyled">
                            <li>
                                <a href="payments.php" class="nav-link text-white">
                                    <i class="bi bi-receipt me-2"></i>Payments
                                </a>
                            </li>
                            <li>
                                <a href="fines.php" class="nav-link text-white mt-2">
                                    <i class="bi bi-currency-dollar me-2"></i>Fines
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a class="text-decoration-none px-3 py-2 d-block dropdown-toggle text-white" data-bs-toggle="collapse" href="#impoundMenu" role="button" aria-expanded="false" aria-controls="impoundMenu">
                        <i class="bi bi-truck-front-fill me-2"></i>Impound Management
                    </a>
                    <div class="collapse ps-4" id="impoundMenu">
                        <ul class="list-unstyled">
                            <li>
                                <a href="inventory.php" class="nav-link text-white">
                                    <i class="bi bi-box-seam me-2"></i>Inventory
                                </a>
                            </li>
                            <li>
                                <a href="locations.php" class="nav-link text-white mt-2">
                                    <i class="bi bi-geo-alt-fill me-2"></i>Impound Locations
                                </a>
                            </li>
                            <li>
                                <a href="impound.php" class="nav-link text-white mt-2">
                                    <i class="bi bi-clipboard-data me-2"></i>Impound Records
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="investigations.php" class="text-decoration-none px-3 py-2 d-block">
                    <i class="bi bi-clipboard-data me-2"></i>Investigations
                    </a>
                </li>

                <li>
                    <a href="auctions.php" class="text-decoration-none px-3 py-2 d-block">
                    <i class="bi bi-tag me-2"></i>Auctions
                    </a>
                </li>

                <li>
                    <a href="userlogs.php" class="text-decoration-none px-3 py-2 d-block">
                    <i class="bi bi-journal me-2"></i>User Logs
                    </a>
                </li>

            </ul>

            <hr class="h-color mx-2">

            <ul class="list-unstyled px-2">
                <li class=""><a href="settings.php" class="text-decoration-none px-3 py-2 d-block">
                    <i class="fal fa-bars me-2"></i>Settings</a></li>
                <li class=""><a href="../logout.php" class="text-decoration-none px-3 py-2 d-block">
                    <i class="bi bi-box-arrow-left me-2"></i>Logout</a></li>
            </ul>

            <hr class="h-color mx-2 mt-5">
            
            <div class="d-flex align-items-end me">
                <p class="text-white ms-3 fs-6">Logged in as: <br> <?php echo $useremail ?><br>(Admin)</p>
            </div>
        </div>

        <div class="content bg-light">
            <nav class="navbar navbar-expand-md navbar-dark">
                <div class="container-fluid">
                </div>
            </nav>

            <!-- List of Payments  -->
            <div class="px-3">
                <div class="row">
                    <div class="col-sm-1">
                        <h2 class="fs-5 mt-1 ms-2">Payments</h2>
                    </div>
                    <div class="col input-group mb-3">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search" aria-describedby="button-addon2" oninput="search()">
                    </div>
                </div>
                
                <div class="card" style="height: 600px;">
                    <div class="card-body">
                        <div class="table-responsive" style="height: 550px;">
                            <table id="payment-table" class="table table-bordered table-hover">
                                <thead class="table-light" style="position: sticky; top: 0;">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Plate Number</th>
                                        <th scope="col">Total Amount</th>
                                        <th scope="col">Amount Paid</th>
                                        <th scope="col">Change Amount</th>
                                        <th scope="col">Date Paid</th>
                                        <th scope="col">Payment Method</th>
                                        <th scope="col">Received by</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                <?php
                                    // Query the database to fetch user data
                                    $result = $connection->query("
                                        SELECT 
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
                                        ORDER BY paymentid DESC
                                    ");

                                if ($result->num_rows > 0) {
                                        $count = 1; 

                                        while ($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td>' . $count . '</td>';
                                            echo '<td>' . $row['platenumber'] . '</td>';
                                            echo '<td>' . $row['total_amount'] . '</td>';
                                            echo '<td>' . $row['amount_paid'] . '</td>';
                                            $balance = $row['total_amount'] - $row['amount_paid'];
                                            echo '<td>' . $balance . '</td>';
                                            echo '<td>' . date("F d, Y", strtotime($row['date_paid'])) . '</td>';
                                            echo '<td>' . $row['payment_method'] . '</td>';
                                            echo '<td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
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
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                    <!-- Search results will be displayed here -->
                <div id="search-results"></div>
            </div>
            <!-- End of List of Payments -->
        </div>
    
    </div>

    <!-- Toast Notification -->
    <div id="liveToast" class="toast align-items-center text-white bg-success border-0 position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 9999;">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">
                <!-- Message will be injected here -->
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toast-container">
        <div id="updateToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Notification</strong>
                <small>Just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Information updated successfully.
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="dynamicToast" class="toast align-items-center border-0 text-bg-success" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div id="toastBody" class="toast-body">
                    <!-- Message goes here -->
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <div id="toast-container" style="position: fixed; top: 1rem; right: 1rem; z-index: 9999;"></div>


    <!-- Script -->
    <script>

        //--------------------------- Dynamic Toast Notification ---------------------------//
        function showDynamicToast(message, type = 'success') {
            let className = 'bg-success';
            if (type === 'danger') className = 'bg-danger';
            else if (type === 'warning') className = 'bg-warning';
            else if (type === 'info') className = 'bg-info';

            const toast = `
                <div class="toast align-items-center text-white ${className} border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">${message}</div>
                    </div>
                </div>
            `;
            $('#toast-container').append(toast);

            // Auto-remove the toast after 3 seconds
            setTimeout(() => {
                $('#toast-container .toast').first().remove();
            }, 3000);
        }

        //---------------------------Search Payment Results---------------------------//c
        function search() {
            const query = document.getElementById("searchInput").value;

            // Make an AJAX request to fetch search results
            $.ajax({
                url: 'payments_search.php', // Replace with the actual URL to your search script
                method: 'POST',
                data: { query: query },
                success: function(data) {
                    // Update the user-table with the search results
                    $('#payment-table tbody').html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error during search request:", error);
                }
            });
        }

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check if the session has the update success flag set
            <?php if (isset($_SESSION['update_success'])): ?>
                var updateToast = new bootstrap.Toast(document.getElementById('updateToast'));
                updateToast.show();
                <?php unset($_SESSION['update_success']); // Clear the session variable after showing the toast ?>
            <?php endif; ?>
        });
    </script>

    <script>
        function printReceipt(paymentId) {
            // AJAX call to fetch payment details and generate receipt content
            $.ajax({
                url: 'payment_receipt_get.php', 
                method: 'POST',
                data: { paymentid: paymentId },
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        const receiptWindow = window.open('', '_blank', 'width=400,height=600');
                        const receiptContent = `
                            <html>
                            <head>
                                <title>Receipt #${data.paymentid}</title>
                                <style>
                                    body { font-family: Arial, sans-serif; padding: 20px; }
                                    h2 { text-align: center; }
                                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                                    td, th { border: 1px solid #000; padding: 8px; text-align: left; }
                                    .total { font-weight: bold; }
                                    .center { text-align: center; }
                                </style>
                            </head>
                            <body>
                                <h2>Payment Receipt</h2>
                                <table>
                                    <tr><th>Payment ID</th><td>${data.paymentid}</td></tr>
                                    <tr><th>Plate Number</th><td>${data.platenumber}</td></tr>
                                    <tr><th>Total Amount</th><td>${data.total_amount}</td></tr>
                                    <tr><th>Amount Paid</th><td>${data.amount_paid}</td></tr>
                                    <tr><th>Change Amount</th><td>${data.change_amount}</td></tr>
                                    <tr><th>Date Paid</th><td>${data.date_paid}</td></tr>
                                    <tr><th>Payment Method</th><td>${data.payment_method}</td></tr>
                                    <tr><th>Received By</th><td>${data.received_by}</td></tr>
                                </table>
                                <p class="center" style="margin-top:30px;">Thank you for your payment!</p>
                                <script>
                                    window.print(); 
                                    window.onafterprint = function() { window.close(); }
                                <\/script>
                            </body>
                            </html>
                        `;
                        receiptWindow.document.write(receiptContent);
                        receiptWindow.document.close();
                    } else {
                        alert('Failed to generate receipt.');
                    }
                },
                error: function() {
                    alert('Error fetching receipt data.');
                }
            });
        }
        </script>    

</body>
</html>