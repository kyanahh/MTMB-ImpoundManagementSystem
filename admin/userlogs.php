<?php

session_start();

require("../server/connection.php");   

if(isset($_SESSION["logged_in"])){
    if(isset($_SESSION["firstname"]) || isset($_SESSION["email"])){
        $textaccount = $_SESSION["firstname"];
        $useremail = $_SESSION["email"];
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

        <div class="content">
            <nav class="navbar navbar-expand-md navbar-dark">
                <div class="container-fluid">
                </div>
            </nav>

            <!-- List of User Logs -->
            <div class="px-3">
                <div class="row">
                    <div class="col-sm-2">
                        <h2 class="fs-5 mt-1 ms-2">User Logs</h2>
                    </div>
                    <div class="col input-group mb-3">
                        <input type="text" class="form-control" id="searchUserInput" placeholder="Search" aria-describedby="button-addon2" oninput="searchUsers()">
                    </div>
                </div>
                
                <div class="card" style="height: 600px;">
                    <div class="card-body">
                        <div class="table-responsive" style="height: 550px;">
                            <table id="user-table" class="table table-bordered table-hover">
                                <thead class="table-light" style="position: sticky; top: 0;">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">User ID</th>
                                        <th scope="col">Log Time</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                <?php
                                    // Query the database to fetch user data
                                    $result = $connection->query("SELECT * FROM userlogs ORDER BY logid DESC");

                                    if ($result->num_rows > 0) {
                                        $count = 1; 

                                        while ($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td>' . $count . '</td>';
                                            echo '<td>' . $row['userid'] . '</td>';
                                            echo '<td>' . $row['logtime'] . '</td>';
                                            echo '</tr>';
                                            $count++; 
                                        }
                                    } else {
                                        echo '<tr><td colspan="5">No user logs found.</td></tr>';
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
            <!-- End of List of Users -->
        </div>
    
    </div>

    <!-- Script -->  
    <script>

    </script>

</body>
</html>