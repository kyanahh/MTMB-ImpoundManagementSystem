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

        <div class="content bg-light">
            <nav class="navbar navbar-expand-md navbar-dark">
                <div class="container-fluid">
                </div>
            </nav>

            <!-- List of Vehicles -->
            <div class="px-3">
                <div class="row">
                    <div class="col-sm-1">
                        <h2 class="fs-5 mt-1 ms-2">Vehicles</h2>
                    </div>
                    <div class="col input-group mb-3">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search" aria-describedby="button-addon2" oninput="search()">
                    </div>
                    <div class="col-sm-1">
                        <a href="vehicles_add.php" class="btn btn-dark px-4"><i class="bi bi-plus-lg text-white"></i></a>
                    </div>
                </div>
                
                <div class="card" style="height: 600px;">
                    <div class="card-body">
                        <div class="table-responsive" style="height: 550px;">
                            <table id="vehicle-table" class="table table-bordered table-hover">
                                <thead class="table-light" style="position: sticky; top: 0;">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">User ID</th>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Plate Number</th>
                                        <th scope="col">Vehicle Type</th>
                                        <th scope="col">Model</th>
                                        <th scope="col">Color</th>
                                        <th scope="col">Registration Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                <?php
                                    // Query the database to fetch user data
                                    $result = $connection->query("SELECT vehicles.*, users.firstname, users.lastname 
                                    FROM vehicles INNER JOIN users 
                                    ON vehicles.userid = users.userid ORDER BY vehicleid DESC");

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

                                            
                                            echo '<button title="Add Violation" class="btn btn-secondary me-2" data-bs-toggle="modal" 
                                            data-bs-target="#addModal" onclick="openAddModal(' . $row['vehicleid'] . ')">
                                            <i class="bi bi-plus"></i><i class="bi bi-exclamation-triangle"></i></button>';

                                            echo '<button title="Impound Vehicle" class="btn btn-warning me-2" data-bs-toggle="modal" 
                                            data-bs-target="#impoundModal" onclick="openImpoundModal(' . $row['vehicleid'] . ')">
                                            <i class="bi bi-truck-flatbed"></i></button>';

                                            echo '<button title="Investigate" class="btn btn-dark me-2" data-bs-toggle="modal" 
                                            data-bs-target="#invModal" onclick="openInvModal(' . $row['vehicleid'] . ')">
                                            <i class="bi bi-person-exclamation"></i></button>';

                                            echo '<button title="For Auction" class="btn btn-success me-2" data-bs-toggle="modal" 
                                            data-bs-target="#auctionModal" onclick="openAuctionModal(' . $row['vehicleid'] . ')">
                                            <i class="bi bi-tag"></i></button>';
                                            
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
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                    <!-- Search results will be displayed here -->
                <div id="search-results"></div>
            </div>
            <!-- End of List of Vehicles -->
        </div>
    
    </div>

    <!-- View Vehicles Modal -->
    <div class="modal fade" id="viewVehicleModal" tabindex="-1" aria-labelledby="viewVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="viewVehicleModalLabel">Vehicle Information</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <dl class="row">
            <dt class="col-sm-3">Vehicle ID:</dt>
            <dd class="col-sm-9" id="view-vehicleid"></dd>

            <dt class="col-sm-3">User ID:</dt>
            <dd class="col-sm-9" id="view-userid"></dd>

            <dt class="col-sm-3">First Name:</dt>
            <dd class="col-sm-9" id="view-firstname"></dd>

            <dt class="col-sm-3">Last Name:</dt>
            <dd class="col-sm-9" id="view-lastname"></dd>

            <dt class="col-sm-3">Plate Number:</dt>
            <dd class="col-sm-9" id="view-platenumber"></dd>

            <dt class="col-sm-3">Vehicle Type:</dt>
            <dd class="col-sm-9" id="view-vehicle_type"></dd>

            <dt class="col-sm-3">Model:</dt>
            <dd class="col-sm-9" id="view-model"></dd>

            <dt class="col-sm-3">Color:</dt>
            <dd class="col-sm-9" id="view-color"></dd>

            <dt class="col-sm-3">Registration Date:</dt>
            <dd class="col-sm-9" id="view-registration_date"></dd>

            <dt class="col-sm-3">Chassis Number:</dt>
            <dd class="col-sm-9" id="view-chassis_number"></dd>

            <dt class="col-sm-3">Engine Number:</dt>
            <dd class="col-sm-9" id="view-engine_number"></dd>

            <dt class="col-sm-3">Status:</dt>
            <dd class="col-sm-9" id="view-status"></dd>
            </dl>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toast-container">
        <div id="deleteToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Notification</strong>
                <small>Just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Information deleted successfully.
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this vehicle?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
            </div>
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

    <!-- Add Violation Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Vehicle Violation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <div class="mb-3">
                            <div>
                                <label for="vehicleid" class="form-label">Vehicle ID</label>
                                <input type="text" class="form-control" id="vehicleid" name="vehicleid" disabled>
                            </div>
                            <div>
                                <label for="violationid" class="form-label">Violation Type<span class="text-danger">*</span></label>
                                <select class="form-control" name="violationid" id="violationid" required>
                                    <option value="" disabled selected>Select Vehicle Violation</option>
                                    <?php
                                        // Query to get all faculty members
                                        $sql = "SELECT violationid, violation_type FROM violations";
                                        $result = $connection->query($sql);

                                        // Check if there are any faculty members and populate the dropdown
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . $row['violationid'] . '">' . $row['violation_type'] . '</option>';
                                            }
                                        } else {
                                            echo '<option value="" disabled>No violation found.</option>';
                                        }
                                    ?>
                                </select>                            
                            </div>
                            <div class="mb-3">
                                <label for="date_committed" class="form-label">Date Committed<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="date_committed" name="date_committed" required>
                            </div>
                            <div class="mb-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <input type="text" class="form-control" id="remarks" name="remarks">                     
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Impound Modal -->
    <div class="modal fade" id="impoundModal" tabindex="-1" aria-labelledby="impoundModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="impoundModalLabel">Impound Vehicle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="impoundForm">
                        <div class="mb-3">
                            <div>
                                <label for="impound_vehicleid" class="form-label">Vehicle ID<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="impound_vehicleid" name="vehicleid" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="date_impounded" class="form-label">Date Impounded<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="date_impounded" name="date_impounded" required>
                            </div>
                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="reason" name="reason" required>
                            </div>
                            <div class="mb-3">
                                <label for="impound_remarks" class="form-label">Remarks</label>
                                <input type="text" class="form-control" id="impound_remarks" name="remarks">                     
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

     <!-- Investigate Modal -->
    <div class="modal fade" id="invModal" tabindex="-1" aria-labelledby="invModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invModalLabel">Investigate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="invForm">
                        <div class="mb-3">
                            <div>
                                <label for="inv_vehicleid" class="form-label">Vehicle ID<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="inv_vehicleid" name="vehicleid" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="case_type" class="form-label">Case Type<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="case_type" name="case_type" required>
                            </div>
                            <div class="mb-3">
                                <label for="invdescription" class="form-label">Description<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="invdescription" name="description" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

     <!-- Auction Modal -->
    <div class="modal fade" id="auctionModal" tabindex="-1" aria-labelledby="auctionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="auctionModalLabel">For Auction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="auctionForm">
                        <div class="mb-3">
                            <div>
                                <label for="auction_vehicleid" class="form-label">Vehicle ID<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="auction_vehicleid" name="vehicleid" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="schedule_date" class="form-label">Schedule Date<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="schedule_date" name="schedule_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="starting_bid" class="form-label">Starting Bid<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="starting_bid" name="starting_bid" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
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

    <!-- Script -->
    <script>

        //--------------------------- Dynamic Toast Notification ---------------------------//
        function showDynamicToast(message, type) {
            const toastElement = document.getElementById('dynamicToast');
            const toastBody = document.getElementById('toastBody');

            // Set the message
            toastBody.textContent = message;

            // Set the type (e.g., success, error)
            toastElement.className = `toast align-items-center border-0 text-bg-${type}`;

            // Show the toast
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }
        
        //---------------------------Edit Vehicle---------------------------//
        function edit(id) {
            window.location = "vehicle_edit.php?id=" + id;
        }


        //---------------------------Delete Vehicle---------------------------//
        let IdToDelete = null;

        function del(id) {
            IdToDelete = id; // Store the ID to delete
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show(); // Show the modal
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (userIdToDelete) {
                $.ajax({
                    url: 'vehicle_delete.php',
                    method: 'POST',
                    data: { vehicleid: IdToDelete },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            showDeleteToast();
                            setTimeout(function () {
                                location.reload();
                            }, 3000); // Wait 3 seconds before refreshing
                        } else {
                            alert(response.error);
                        }
                    },
                    error: function () {
                        alert('Error deleting record');
                    }
                });
            }
        });

        function showDeleteToast() {
            const deleteToast = new bootstrap.Toast(document.getElementById('deleteToast'));
            deleteToast.show();
        }


        //---------------------------Search Vehicle Results---------------------------//c
        function search() {
            const query = document.getElementById("searchInput").value;

            // Make an AJAX request to fetch search results
            $.ajax({
                url: 'vehicle_search.php', // Replace with the actual URL to your search script
                method: 'POST',
                data: { query: query },
                success: function(data) {
                    // Update the user-table with the search results
                    $('#vehicle-table tbody').html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error during search request:", error);
                }
            });
        }

        //---------------------------View Vehicle---------------------------//c
        function view(vehicleid) {
            $.ajax({
                url: 'vehicle_info.php',
                type: 'POST',
                data: { vehicleid: vehicleid },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#view-vehicleid').text(response.data.vehicleid);
                        $('#view-userid').text(response.data.userid);
                        $('#view-firstname').text(response.data.firstname);
                        $('#view-lastname').text(response.data.lastname);
                        $('#view-platenumber').text(response.data.platenumber);
                        $('#view-vehicle_type').text(response.data.vehicle_type);
                        $('#view-model').text(response.data.model);
                        $('#view-color').text(response.data.color);
                        $('#view-registration_date').text(response.data.registration_date);
                        $('#view-chassis_number').text(response.data.chassis_number);
                        $('#view-engine_number').text(response.data.engine_number);
                        $('#view-status').text(response.data.status);

                        const viewModal = new bootstrap.Modal(document.getElementById('viewVehicleModal'));
                        viewModal.show();
                    } else {
                        alert('Vehicle not found.');
                    }
                },
                error: function() {
                    alert('Failed to retrieve vehicle info.');
                }
            });
        }

        //---------------------------Add Violation---------------------------//
        // Open the modal and load only the vehicle ID
        function openAddModal(vehicleid) {
            // Clear all fields except vehicleid
            $('#violationid').val('');
            $('#date_committed').val('');
            $('#remarks').val('');
            
            // Load vehicle ID
            $.ajax({
                url: 'violationrecords_get.php',
                type: 'POST',
                data: { vehicleid: vehicleid },
                success: function (response) {
                    const result = JSON.parse(response);

                    if (result.success) {
                        $('#vehicleid').val(result.data.vehicleid);
                        $('#addModal').modal('show'); // Show modal after setting data
                    } else {
                        showDynamicToast('Error fetching vehicle data: ' + result.message, 'danger');
                    }
                },
                error: function () {
                    showDynamicToast('An error occurred while fetching the vehicle data.', 'danger');
                },
            });
        }

        // Handle the form submission for adding a violation
        $('#addForm').on('submit', function (e) {
            e.preventDefault();

            const vehicleid = $('#vehicleid').val();
            const violationid = $('#violationid').val();
            const date_committed = $('#date_committed').val();
            const remarks = $('#remarks').val();

            $.ajax({
                url: 'violationrecords_add.php',
                type: 'POST',
                data: {
                    vehicleid: vehicleid,
                    violationid: violationid,
                    date_committed: date_committed,
                    remarks: remarks
                },
                success: function (response) {
                    const result = JSON.parse(response);

                    if (result.success) {
                        $('#addModal').modal('hide');
                        showDynamicToast('Violation added successfully!', 'success');
                        setTimeout(() => location.reload(), 2000); // Optional reload
                    } else {
                        showDynamicToast('Error adding violation: ' + result.message, 'danger');
                    }
                },
                error: function () {
                    showDynamicToast('An error occurred while adding the violation.', 'danger');
                },
            });
        });

        //---------------------------Impound---------------------------//
        // Open the modal and load only the  ID
        function openImpoundModal(vehicleid) {
            // Clear all fields except id
            $('#date_impounded').val('');
            $('#reason').val('');
            $('#impound_remarks').val('');
            
            // Load vehicle ID
            $.ajax({
                url: 'impound_getid.php',
                type: 'POST',
                data: { vehicleid: vehicleid },
                success: function (response) {
                    const result = JSON.parse(response);

                    if (result.success) {
                        $('#impound_vehicleid').val(result.data.vehicleid);
                        $('#impoundModal').modal('show'); // Show modal after setting data
                    } else {
                        showDynamicToast('Error fetching vehicle data: ' + result.message, 'danger');
                    }
                },
                error: function () {
                    showDynamicToast('An error occurred while fetching the vehicle data.', 'danger');
                },
            });
        }

        // Handle the form submission for adding a violation
        $('#impoundForm').on('submit', function (e) {
            e.preventDefault();

            const vehicleid = $('#impound_vehicleid').val();
            const date_impounded = $('#date_impounded').val();
            const reason = $('#reason').val();
            const remarks = $('#impound_remarks').val();

            $.ajax({
                url: 'impound_add.php',
                type: 'POST',
                data: {
                    vehicleid: vehicleid,
                    date_impounded: date_impounded,
                    reason: reason,
                    remarks: remarks
                },
                success: function (response) {
                    const result = JSON.parse(response);

                    if (result.success) {
                        $('#impoundModal').modal('hide');
                        showDynamicToast('Record added successfully!', 'success');
                        setTimeout(() => location.reload(), 2000); // Optional reload
                    } else {
                        showDynamicToast('Error adding record: ' + result.message, 'danger');
                    }
                },
                error: function () {
                    showDynamicToast('An error occurred while adding the record.', 'danger');
                },
            });
        });

        //--------------------------- Investigate ---------------------------//
        function openInvModal(vehicleid) {
            $('#case_type').val('');
            $('#invdescription').val('');
            
            // Load vehicle ID
            $.ajax({
                url: 'investigate_getid.php',
                type: 'POST',
                data: { vehicleid: vehicleid },
                success: function (response) {
                    const result = JSON.parse(response);

                    if (result.success) {
                        $('#inv_vehicleid').val(result.data.vehicleid);
                        $('#invModal').modal('show');
                    } else {
                        showDynamicToast('Error fetching vehicle data: ' + result.message, 'danger');
                    }
                },
                error: function () {
                    showDynamicToast('An error occurred while fetching the vehicle data.', 'danger');
                },
            });
        }

        $('#invForm').on('submit', function (e) {
            e.preventDefault();

            const vehicleid = $('#inv_vehicleid').val();
            const case_type = $('#case_type').val();
            const description = $('#invdescription').val();

            $.ajax({
                url: 'investigate_add.php',
                type: 'POST',
                data: {
                    vehicleid: vehicleid,
                    case_type: case_type,
                    description: description
                },
                dataType: 'text',  // prevent jQuery from auto-parsing
                success: function (response) {
                    const result = JSON.parse(response);
                    if (result.success) {
                        $('#impoundModal').modal('hide');
                        showDynamicToast('Record added successfully!', 'success');
                        setTimeout(() => location.reload(), 2000); // Optional reload
                    } else {
                        showDynamicToast('Error adding record: ' + result.message, 'danger');
                    }
                },
                error: function () {
                    showDynamicToast('An error occurred while saving investigation.', 'danger');
                }
            });
        });

        //--------------------------- Auction ---------------------------//
        function openAuctionModal(vehicleid) {
            $('#schedule_date').val('');
            $('#starting_bid').val('');
            
            // Load vehicle ID
            $.ajax({
                url: 'auction_getid.php',
                type: 'POST',
                data: { vehicleid: vehicleid },
                success: function (response) {
                    const result = JSON.parse(response);

                    if (result.success) {
                        $('#auction_vehicleid').val(result.data.vehicleid);
                        $('#auctionModal').modal('show');
                    } else {
                        showDynamicToast('Error fetching vehicle data: ' + result.message, 'danger');
                    }
                },
                error: function () {
                    showDynamicToast('An error occurred while fetching the vehicle data.', 'danger');
                },
            });
        }

        $('#auctionForm').on('submit', function (e) {
            e.preventDefault();

            const vehicleid = $('#auction_vehicleid').val();
            const schedule_date = $('#schedule_date').val();
            const starting_bid = $('#starting_bid').val();

            $.ajax({
                url: 'auction_add.php',
                type: 'POST',
                data: {
                    vehicleid: vehicleid,
                    schedule_date: schedule_date,
                    starting_bid: starting_bid
                },
                dataType: 'text',  // prevent jQuery from auto-parsing
                success: function (response) {
                    const result = JSON.parse(response);
                    if (result.success) {
                        $('#auctionModal').modal('hide');
                        showDynamicToast('Record added successfully!', 'success');
                        setTimeout(() => location.reload(), 2000); // Optional reload
                    } else {
                        showDynamicToast('Error adding record: ' + result.message, 'danger');
                    }
                },
                error: function () {
                    showDynamicToast('An error occurred while saving record.', 'danger');
                }
            });
        });



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

</body>
</html>