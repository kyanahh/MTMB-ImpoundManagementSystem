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

            <!-- List of Impound  -->
            <div class="px-3">
                <div class="row">
                    <div class="col-sm-2">
                        <h2 class="fs-5 mt-1 ms-2">Impound Records</h2>
                    </div>
                    <div class="col input-group mb-3">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search" aria-describedby="button-addon2" oninput="search()">
                    </div>
                </div>
                
                <div class="card" style="height: 600px;">
                    <div class="card-body">
                        <div class="table-responsive" style="height: 550px;">
                            <table id="vehicle-table" class="table table-bordered table-hover">
                                <thead class="table-light" style="position: sticky; top: 0;">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Plate Number</th>
                                        <th scope="col">Date Impounded</th>
                                        <th scope="col">Reason</th>
                                        <th scope="col">Impounded by</th>
                                        <th scope="col">Release Date</th>
                                        <th scope="col">Paid (Y/N)</th>
                                        <th scope="col">Release Status</th>
                                        <th scope="col">Remarks</th>
                                        <th scope="col">Location</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                <?php
                                    // Query the database to fetch user data
                                    $result = $connection->query("SELECT impound_records.*, vehicles.platenumber, 
                                    users.firstname, users.lastname, impound_locations.area_name 
                                    FROM impound_records INNER JOIN vehicles ON impound_records.vehicleid = vehicles.vehicleid
                                    INNER JOIN users ON impound_records.impounded_by = users.userid 
                                    INNER JOIN impound_locations ON impound_records.locationid = impound_locations.locationid 
                                    ORDER BY recordid DESC");

                                    if ($result->num_rows > 0) {
                                        $count = 1; 

                                        while ($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td>' . $count . '</td>';
                                            echo '<td>' . $row['platenumber'] . '</td>';
                                            echo '<td>' . date("F d, Y", strtotime($row['date_impounded'])) . '</td>';
                                            echo '<td>' . $row['reason'] . '</td>';
                                            echo '<td>' . $row['firstname'] . ' ' . $row['lastname'] . '</td>';
                                            echo '<td>' . (!empty($row['release_date']) ? date("F d, Y", strtotime($row['release_date'])) : '') . '</td>';
                                            echo '<td>' . ($row['is_paid'] == 1 ? 'Yes' : 'No') . '</td>';
                                            echo '<td>' . $row['release_status'] . '</td>';
                                            echo '<td>' . $row['remarks'] . '</td>';
                                            echo '<td>' . $row['area_name'] . '</td>';
                                            echo '<td>';
                                            echo '<div class="d-flex justify-content-center">';

                                            if ($row['locationid'] == 0 && $row['release_status'] === 'Pending') {
                                            echo '<button title="Assign Location" class="btn btn-primary me-2" data-bs-toggle="modal" 
                                            data-bs-target="#impoundModal" onclick="openImpoundModal(' . $row['recordid'] . ')">
                                            <i class="bi bi-pin-map-fill"></i></button>';
                                            }

                                            if ($row['release_status'] == "Pending" && $row['is_paid'] == 1) {
                                            echo '<button title="Release" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#confirmModal" onclick="openConfirmModal(' . $row['recordid'] . ')"><i class="bi bi-check"></i></button>';
                                            }

                                            if (
                                                !empty($row['release_date']) &&
                                                strtotime($row['release_date']) < strtotime(date('Y-m-d')) &&
                                                $row['release_status'] === 'Pending' &&
                                                $row['is_paid'] == 0
                                            ) {
                                                echo '<button title="Mark as Unclaimed" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#unclaimModal" onclick="openUnclaimModal(' . $row['recordid'] . ')"><i class="bi bi-x"></i></button>';
                                            }

                                            if ($row['is_paid'] == 0 && $row['locationid'] > 0) {
                                                echo '<button title="Add Payment" class="btn btn-primary me-2" onclick="openAddModal(' . $row['recordid'] . ')"><i class="bi bi-cash-stack"></i></button>';
                                            }

                                            echo '<button title="Delete" class="btn btn-danger" onclick="del(' . $row['recordid'] . ')"><i class="bi bi-trash"></i></button>';
                                            echo '</div>';
                                            echo '</td>';
                                            echo '</tr>';
                                            $count++; 
                                        }
                                    } else {
                                        echo '<tr><td colspan="5">No record found.</td></tr>';
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
            <!-- End of List of Impound Records -->
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

    <!-- Toast Notification -->
    <div id="liveToast" class="toast align-items-center text-white bg-success border-0 position-fixed bottom-0 end-0 m-3" role="alert" aria-live="assertive" aria-atomic="true" style="z-index: 9999;">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">
                <!-- Message will be injected here -->
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
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
                Are you sure you want to delete this record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirm Release</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to release this vehicle?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="confirmButton">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Unlcaim Modal -->
    <div class="modal fade" id="unclaimModal" tabindex="-1" aria-labelledby="unclaimModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unclaimModalLabel">Mark as Unclaimed</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to mark this vehicle as unclaimed?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="unclaimButton">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Impound Modal -->
    <div class="modal fade" id="impoundModal" tabindex="-1" aria-labelledby="impoundModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="impoundModalLabel">Assign Impound Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="impoundForm">
                        <div class="mb-3">
                            <div>

                                <label for="recordid" class="form-label">Record ID</label>
                                <input type="text" class="form-control" id="recordid" name="recordid" disabled>
                            </div>
                            <div>
                                <label for="locationid" class="form-label">Area<span class="text-danger">*</span></label>
                                <select class="form-control" name="locationid" id="locationid" required>
                                    <option value="" disabled selected>Select Impound Location</option>
                                    <?php
                                    // Query to get all faculty members
                                    $sql = "SELECT locationid, area_name FROM impound_locations";
                                    $result = $connection->query($sql);

                                    // Check if there are any faculty members and populate the dropdown
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row['locationid'] . '">' . $row['area_name'] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="" disabled>No area found.</option>';
                                    }
                                    ?>
                                </select>                         
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Payment Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <div class="mb-3">
                            <div>
                                <label for="fineid" class="form-label">Fine ID</label>
                                <input type="text" class="form-control" id="fineid" name="fineid" disabled>
                            </div>
                            <div>
                                <label for="amount_paid" class="form-label">Amount Paid<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="amount_paid" name="amount_paid" required>                         
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
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

            // Determine Bootstrap class based on type
            let bgClass = 'text-bg-success'; // default
            if (type === 'error') {
                bgClass = 'text-bg-danger';
            } else if (type === 'warning') {
                bgClass = 'text-bg-warning';
            }

            // Update class
            toastElement.className = `toast align-items-center border-0 ${bgClass}`;

            // Show the toast
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }

        //---------------------------Delete Vehicle---------------------------//
        let IdToDelete = null;

        function del(id) {
            IdToDelete = id; // Store the ID to delete
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show(); // Show the modal
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (IdToDelete) {
                $.ajax({
                    url: 'impound_delete.php',
                    method: 'POST',
                    data: { recordid: IdToDelete },
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


        //---------------------------Search Record Results---------------------------//c
        function search() {
            const query = document.getElementById("searchInput").value;

            // Make an AJAX request to fetch search results
            $.ajax({
                url: 'impound_search.php', // Replace with the actual URL to your search script
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

       //---------------------------Confirm Release ---------------------------//
        // JavaScript code for modal and toast handling
        let IdToConfirm = null;

        // Function to open the confirmation modal
        function openConfirmModal(recordid) {
            console.log("Opening modal for record ID:", recordid); // Debugging log
            IdToConfirm = recordid;
            const confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
            confirmModal.show();
        }

        // Event listener for the confirmation button
        document.getElementById('confirmButton').addEventListener('click', function () {
            if (IdToConfirm) {
                $.ajax({
                    url: "impound_confirm.php",
                    method: "POST",
                    data: { recordid: IdToConfirm },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
                            modal.hide(); // Close the modal

                            showToast(response.success, "bg-success");
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            showToast(response.error, "bg-danger");
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors from the AJAX request
                        showToast('Error confirming the payment', 'bg-danger');
                    }
                });
            }
        });

        // Function to display the toast
        function showToast(message, className) {
            // Get the toast elements
            const toastMessage = document.getElementById('toastMessage');
            const toastElement = document.getElementById('liveToast');

            // Update the toast message and class
            toastMessage.textContent = message;
            toastElement.className = `toast align-items-center text-white ${className} border-0`;

            // Initialize and show the toast
            const toast = new bootstrap.Toast(toastElement);
            toast.show();
        }

        //--------------------------- Unclaimed ---------------------------//
        // JavaScript code for modal and toast handling
        let unclaimIdToConfirm = null;

        // Function to open the confirmation modal
        function openUnclaimModal(recordid) {
            console.log("Opening modal for record ID:", recordid); // Debugging log
            unclaimIdToConfirm = recordid;
            const modal = new bootstrap.Modal(document.getElementById('unclaimModal'));
            modal.show();
        }


        // Event listener for the confirmation button
        document.getElementById('unclaimButton').addEventListener('click', function () {
            if (unclaimIdToConfirm) {
                $.ajax({
                    url: "impound_unclaim.php",
                    method: "POST",
                    data: { recordid: unclaimIdToConfirm },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('unclaimModal'));
                            modal.hide(); // Close the modal

                            showToast(response.success, "bg-success");
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            showToast(response.error, "bg-danger");
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle errors from the AJAX request
                        showToast('Error unclaiming the record', 'bg-danger');
                    }
                });
            }
        });

        //---------------------------Impound Location---------------------------//
        // Open the modal and load only the ID
        function openImpoundModal(recordid) {
            // Clear all fields except id
            $('#locationid').val('');
            
            // Load vehicle ID
            $.ajax({
                url: 'impound_getid_loc.php',
                type: 'POST',
                data: { recordid: recordid },
                success: function (response) {
                    const result = JSON.parse(response);

                    if (result.success) {
                        $('#recordid').val(result.data.recordid);
                        $('#impoundModal').modal('show'); // Show modal after setting data
                    } else {
                        showDynamicToast('Error fetching fine data: ' + result.message, 'danger');
                    }
                },
                error: function () {
                    showDynamicToast('An error occurred while fetching the fine data.', 'danger');
                },
            });
        }

        // Handle the form submission for adding a violation
        $('#impoundForm').on('submit', function (e) {
            e.preventDefault();

            const recordid = $('#recordid').val();
            const locationid = $('#locationid').val();

            $.ajax({
                url: 'impound_location_add.php',
                type: 'POST',
                data: {
                    recordid: recordid,
                    locationid: locationid
                },
                success: function (response) {
                    const result = JSON.parse(response);

                    if (result.success) {
                        $('#impoundModal').modal('hide');
                        showDynamicToast('Location added successfully!', 'success');
                        setTimeout(() => location.reload(), 2000); // Optional reload
                    } else {
                        showDynamicToast('Error adding location: ' + result.message, 'danger');
                    }
                },
                error: function () {
                    showDynamicToast('An error occurred while adding the location.', 'danger');
                },
            });
        });

        // ---------------------------------------- Payment  ----------------------------------------
        function openAddModal(recordid) {
            $('#amount_paid').val(''); // clear amount

            // You need to fetch the fineid related to this impound record.
            $.ajax({
                url: 'impoundfines_getid.php',
                type: 'POST',
                data: { recordid: recordid },  // sending recordid to get fineid
                success: function (response) {
                    const result = JSON.parse(response);

                    if (result.success) {
                        $('#fineid').val(result.data.fineid);
                        $('#addModal').modal('show');
                    } else {
                        showDynamicToast('Error fetching fine data: ' + result.message, 'danger');
                    }
                },
                error: function () {
                    showDynamicToast('An error occurred while fetching the fine data.', 'danger');
                },
            });
        }

        // Handle the form submission for adding payment
        $('#addForm').on('submit', function (e) {
            e.preventDefault();

            const fineid = $('#fineid').val();
            const amount_paid = $('#amount_paid').val();

            $.ajax({
                url: 'impound_paymentadd.php',
                type: 'POST',
                data: {
                    fineid: fineid,
                    amount_paid: amount_paid
                },
                success: function (response) {
                    const result = JSON.parse(response);

                    if (result.success) {
                        $('#addModal').modal('hide');
                        showDynamicToast('Payment added successfully!', 'success');
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        showDynamicToast('Error adding payment: ' + result.message, 'danger');
                    }
                },
                error: function () {
                    showDynamicToast('An error occurred while adding the payment.', 'danger');
                },
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