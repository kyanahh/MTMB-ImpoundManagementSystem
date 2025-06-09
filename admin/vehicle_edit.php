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

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $query = "SELECT * FROM users WHERE userid = '$id'";

    $res = $connection->query($query);

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();

        $userid = $row["userid"];

    } else {
        $errorMessage = "User not found.";
    }
} else {
    $errorMessage = "User ID is missing.";
}

$platenumber = $vehicle_type = $model = $color = $registration_date = $chassis_number = $engine_number = $errorMessage = $successMessage = "";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $query = "SELECT * FROM vehicles WHERE vehicleid = '$id'";

    $res = $connection->query($query);

    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();

        $userid = $row["userid"];
        $platenumber = $row["platenumber"];
        $vehicle_type = $row["vehicle_type"];
        $model = $row["model"];
        $color = $row["color"];
        $registration_date = $row["registration_date"];
        $chassis_number = $row["chassis_number"];
        $engine_number = $row["engine_number"];
        $status = $row["status"];

    } else {
        $errorMessage = "Vehicle not found.";
    }
} else {
    $errorMessage = "Vehicle ID is missing.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($id)) {
    $platenumber =  strtoupper($_POST["platenumber"]);
    $vehicle_type = $_POST["vehicle_type"];
    $model =  ucwords($_POST["model"]);
    $color =  ucwords($_POST["color"]);
    $registration_date = $_POST["registration_date"];
    $chassis_number =  strtoupper($_POST["chassis_number"]);
    $engine_number =  strtoupper($_POST["engine_number"]);
    $status =  ucwords($_POST["status"]);

    // Base update query
    $query1 = "UPDATE vehicles 
               SET 
                   platenumber = '$platenumber', 
                   vehicle_type = '$vehicle_type', 
                   model = '$model', 
                   color = '$color', 
                   registration_date = '$registration_date', 
                   chassis_number = '$chassis_number', 
                   engine_number = '$engine_number',
                   status = '$status' WHERE vehicleid = '$id'";

    $result = $connection->query($query1);

    if ($result) {
        // Set a session variable for success
        $_SESSION['update_success'] = true;
        header("Location: vehicles.php"); // Redirect to previous page
        exit;
    } else {
        $errorMessage1 = "Error updating details";
    }
    
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

        <div class="content bg-light">
            <nav class="navbar navbar-expand-md navbar-dark">
                <div class="container-fluid">
                </div>
            </nav>

            <!-- Edit Vehicle -->
            <div class="px-3 pt-4">
                <form method="POST" action="<?php htmlspecialchars("SELF_PHP"); ?>">

                    <div class="row ms-1 mt-1">
                        <h2 class="fs-5">Edit Vehicle</h2>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <?php
                                if (!empty($errorMessage)) {
                                    echo "
                                    <div class='alert alert-warning alert-dismissible fade show mt-2 ms-3' role='alert'>
                                        <strong>$errorMessage</strong>
                                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                                    </div>
                                    ";
                                }
                            ?>
                        </div>
                    </div>
                    
                    <div class="row mb-3 mt-2">
                        <div class="col-sm-2">
                            <label class="form-label mt-2 ps-3">User ID</label>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="userid" id="userid" value="<?php echo $userid; ?>" disabled>
                        </div>
                        <div class="col-sm-2">
                            <label class="form-label mt-2 px-3">Plate Number<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="platenumber" id="platenumber" value="<?php echo $platenumber; ?>" placeholder="Enter plate number" required>
                        </div>
                    </div>

                    <div class="row mb-3 mt-2">
                        <div class="col-sm-2">
                            <label class="form-label mt-2 px-3">Vehicle Type<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-select" id="vehicle_type" name="vehicle_type" required>
                                <option value="" disabled selected>Select a vehicle type</option>
                                <option value="MC" <?php echo ($vehicle_type == "MC") ? "selected" : ""; ?>>Motorcycle (MC) – Two-wheeled vehicle with or without sidecar</option>
                                <option value="TC" <?php echo ($vehicle_type == "TC") ? "selected" : ""; ?>>Tricycle (TC) – Motorcycle with sidecar</option>
                                <option value="PV" <?php echo ($vehicle_type == "PV") ? "selected" : ""; ?>>Private (PV) – Privately-owned sedan, SUV, van, etc.</option>
                                <option value="FH" <?php echo ($vehicle_type == "FH") ? "selected" : ""; ?>>For Hire (FH) – Public Utility Vehicle (PUV)</option>
                                <option value="GV" <?php echo ($vehicle_type == "GV") ? "selected" : ""; ?>>Government (GV) – Government-owned vehicle</option>
                                <option value="DP" <?php echo ($vehicle_type == "DP") ? "selected" : ""; ?>>Diplomatic (DP) – Foreign diplomatic mission vehicle</option>
                                <option value="PUJ" <?php echo ($vehicle_type == "PUJ") ? "selected" : ""; ?>>Public Utility Jeepney (PUJ)</option>
                                <option value="PUB" <?php echo ($vehicle_type == "PUB") ? "selected" : ""; ?>>Public Utility Bus (PUB)</option>
                                <option value="TR" <?php echo ($vehicle_type == "TR") ? "selected" : ""; ?>>Truck (TR) – Cargo/freight vehicle</option>
                                <option value="TL" <?php echo ($vehicle_type == "TL") ? "selected" : ""; ?>>Trailer (TL) – Non-motorized trailer</option>
                                <option value="SV" <?php echo ($vehicle_type == "SV") ? "selected" : ""; ?>>Service Vehicle (SV) – Company/fleet service</option>
                                <option value="SS" <?php echo ($vehicle_type == "SS") ? "selected" : ""; ?>>School Service (SS)</option>
                                <option value="AMB" <?php echo ($vehicle_type == "AMB") ? "selected" : ""; ?>>Ambulance (AMB)</option>
                                <option value="FT" <?php echo ($vehicle_type == "FT") ? "selected" : ""; ?>>Fire Truck (FT)</option>
                                <option value="WR" <?php echo ($vehicle_type == "WR") ? "selected" : ""; ?>>Wrecker (WR) – Tow truck</option>
                            </select>                        
                        </div>
                        <div class="col-sm-2">
                            <label class="form-label mt-2 px-3">Model<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="model" id="model" value="<?php echo $model; ?>" placeholder="Enter vehicle model" required>
                        </div>
                    </div>

                    <div class="row mb-3 mt-2">
                        <div class="col-sm-2">
                            <label class="form-label mt-2 px-3">Color<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="color" name="color" value="<?php echo $color; ?>" placeholder="Enter vehicle color" required>
                        </div>
                        <div class="col-sm-2">
                            <label class="form-label mt-2 px-3">Registration Date<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-sm-4">
                            <div class="col-sm-12">
                            <input type="date" class="form-control" name="registration_date" id="registration_date" value="<?php echo $registration_date; ?>" required>
                        </div>
                        </div>
                    </div>

                    <div class="row mb-3 mt-2">
                        <div class="col-sm-2">
                            <label class="form-label mt-2 px-3">Chassis Number<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="chassis_number" id="chassis_number" value="<?php echo $chassis_number; ?>" placeholder="Enter chassis number" required>
                        </div>
                        <div class="col-sm-2">
                            <label class="form-label mt-2 px-3">Engine Number<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="engine_number" id="engine_number" value="<?php echo $engine_number; ?>" placeholder="Enter engine number" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3 mt-2">
                        <div class="col-sm-2">
                            <label class="form-label mt-2 px-3">Status<span class="text-danger">*</span></label>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-select" id="status" name="status" required>
                                <option value="" disabled <?php echo ($status == "") ? "selected" : ""; ?>>Select a vehicle status</option>
                                <option value="Violation" <?php echo ($status == "Violation") ? "selected" : ""; ?>>Violation</option>
                                <option value="Impounded" <?php echo ($status == "Impounded") ? "selected" : ""; ?>>Impounded</option>
                                <option value="Released" <?php echo ($status == "Released") ? "selected" : ""; ?>>Released</option>
                                <option value="Unclaimed" <?php echo ($status == "Unclaimed") ? "selected" : ""; ?>>Unclaimed</option>
                                <option value="Under Investigation" <?php echo ($status == "Under Investigation") ? "selected" : ""; ?>>Under Investigation</option>
                                <option value="For Auction" <?php echo ($status == "For Auction") ? "selected" : ""; ?>>For Auction</option>
                                <option value="Auctioned" <?php echo ($status == "Auctioned") ? "selected" : ""; ?>>Auctioned</option>
                            </select>                    
                        </div>
                    </div>
                        
                    <div class="row mb-3 mt-2 float-end">
                        <div class="col-sm-5">
                            <button type="submit" class="btn btn-primary px-5"><i class="bi bi-check-lg"></i></button>
                        </div>
                        <div class="col-sm-5">
                            <a class="btn btn-danger px-5 ms-2" href="vehicles.php"><i class="bi bi-x-lg"></i></a>
                        </div>
                    </div>
                </form>

            </div>
            <!-- End of Edit Vehicle -->

        </div>
    
    </div>

</body>
</html>