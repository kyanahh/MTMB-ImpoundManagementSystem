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

$counts = [
    'Admins' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS total FROM users WHERE usertype = 'Admin'"))['total'],
    'Staff' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS total FROM users WHERE usertype = 'Staff'"))['total'],
    'Vehicle Owners' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS total FROM users WHERE usertype = 'Vehicle Owner'"))['total'],
    'Total Vehicles' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS total FROM vehicles"))['total'],
    'Impounded' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS total FROM vehicles WHERE status = 'Impound'"))['total'],
    'Released' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS total FROM vehicles WHERE status = 'Released'"))['total'],
    'Unclaimed' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) AS total FROM impound_records WHERE release_status = 'Unclaimed'"))['total'],
    'With Violations' => mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(DISTINCT vehicleid) AS total FROM vehicle_violations"))['total']
];

$impounded_per_month_query = mysqli_query($connection, "SELECT DATE_FORMAT(date_impounded, '%Y-%m') AS month, COUNT(*) AS count FROM impound_records GROUP BY month ORDER BY month");
$impounded_months = $impounded_counts = [];
while ($row = mysqli_fetch_assoc($impounded_per_month_query)) {
    $impounded_months[] = $row['month'];
    $impounded_counts[] = $row['count'];
}

$violations_per_month_query = mysqli_query($connection, "SELECT DATE_FORMAT(date_committed, '%Y-%m') AS month, COUNT(*) AS count FROM vehicle_violations GROUP BY month ORDER BY month");
$violation_months = $violation_counts = [];
while ($row = mysqli_fetch_assoc($violations_per_month_query)) {
    $violation_months[] = $row['month'];
    $violation_counts[] = $row['count'];
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

        <div class="container my-5">
            <h3 class="mb-4">Dashboard Summary</h3>
            <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php foreach ($counts as $label => $value): ?>
                <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                    <h5 class="card-title"><?= $label ?></h5>
                    <p class="card-text display-6 fw-bold text-primary"><?= $value ?></p>
                    </div>
                </div>
                </div>
            <?php endforeach; ?>
            </div>

            <div class="row mt-5">
            <div class="col-md-6">
                <h4>Impounded Vehicles per Month</h4>
                <canvas id="impoundedChart"></canvas>
            </div>
            <div class="col-md-6">
                <h4>Violations per Month</h4>
                <canvas id="violationsChart"></canvas>
            </div>
            </div>
        </div>

        <script>
            const impoundedChart = new Chart(document.getElementById('impoundedChart'), {
            type: 'bar',
            data: {
                labels: <?= json_encode($impounded_months) ?>,
                datasets: [{
                label: 'Impounded',
                data: <?= json_encode($impounded_counts) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                y: {
                    beginAtZero: true
                }
                }
            }
            });

            const violationsChart = new Chart(document.getElementById('violationsChart'), {
            type: 'line',
            data: {
                labels: <?= json_encode($violation_months) ?>,
                datasets: [{
                label: 'Violations',
                data: <?= json_encode($violation_counts) ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                y: {
                    beginAtZero: true
                }
                }
            }
            });
        </script>
    

</body>
</html>