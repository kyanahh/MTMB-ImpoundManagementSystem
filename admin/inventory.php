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

$last_updated = date("Y-m-d H:i:s");

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

            <!-- List of Inventory-->
            <div class="px-3">
                <div class="row">
                    <div class="col-sm-2">
                        <h2 class="fs-5 mt-1 ms-2">Inventory</h2>
                    </div>
                    <div class="col input-group mb-3">
                        <input type="text" class="form-control" id="searchInput" placeholder="Search" aria-describedby="button-addon2" oninput="search()">
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-dark px-4" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-plus-lg text-white"></i></button>
                    </div>
                </div>
                
                <div class="card" style="height: 600px;">
                    <div class="card-body">
                        <div class="table-responsive" style="height: 550px;">
                            <table id="inventory-table" class="table table-bordered table-hover">
                                <thead class="table-light" style="position: sticky; top: 0;">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Area</th>
                                        <th scope="col">Capacity</th>
                                        <th scope="col">Occupied</th>
                                        <th scope="col">Available</th>
                                        <th scope="col">Last Update</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                <?php
                                    // Query the database to fetch user data
                                    $result = $connection->query("SELECT inventory.*, impound_locations.area_name, impound_locations.capacity  
                                    FROM inventory INNER JOIN impound_locations
                                    ON inventory.locationid = impound_locations.locationid ORDER BY inventoryid DESC");

                                    if ($result->num_rows > 0) {
                                        $count = 1; 

                                        while ($row = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td>' . $count . '</td>';
                                            echo '<td>' . $row['area_name'] . '</td>';
                                            echo '<td>' . $row['capacity'] . '</td>';
                                            echo '<td>' . $row['occupied_slots'] . '</td>';
                                            echo '<td>' . $row['available_slots'] . '</td>';
                                            echo '<td>' . $row['last_updated'] . '</td>';
                                            echo '<td>';
                                            echo '<div class="d-flex justify-content-center">';
                                            echo '<button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#editModal" onclick="loadData(' . $row['inventoryid'] . ')"><i class="bi bi-pencil-square"></i></button>';
                                            echo '<button class="btn btn-danger" onclick="del(' . $row['inventoryid'] . ')"><i class="bi bi-trash"></i></button>';
                                            echo '</div>';
                                            echo '</td>';
                                            echo '</tr>';
                                            $count++; 
                                        }
                                    } else {
                                        echo '<tr><td colspan="5">No area found.</td></tr>';
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
            <!-- End of List of inventory -->
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
                Record deleted successfully.
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
                Are you sure you want to delete this record?
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

    <!-- Add Inventory Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add New Inventory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <select class="form-control" name="locationid" id="locationid" required>
                            <option value="" disabled selected>Select Impound Location</option>
                            <?php
                            // Query to get all faculty members
                            $sql = "SELECT l.locationid, l.area_name
                                    FROM impound_locations l
                                    JOIN (
                                        SELECT locationid, occupied_slots, available_slots
                                        FROM inventory i1
                                        WHERE i1.last_updated = (
                                            SELECT MAX(last_updated)
                                            FROM inventory i2
                                            WHERE i2.locationid = i1.locationid
                                        )
                                    ) latest_inventory ON l.locationid = latest_inventory.locationid
                                    WHERE latest_inventory.available_slots > 0";
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
                        <div class="mb-3">
                            <label for="occupiedTypeInput" class="form-label">Occupied Slots</label>
                            <input type="number" class="form-control" id="occupiedTypeInput" name="occupied_slots" placeholder="Enter occupied slots" required>
                        </div>
                        <div class="mb-3">
                            <label for="availableTypeInput" class="form-label">Available Slots</label>
                            <input type="number" class="form-control" id="availableTypeInput" name="available_slots" placeholder="Enter available slots" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveButton">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Inventory Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Inventory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <div class="mb-3">
                            <div>
                                <input type="hidden" id="editId" name="editId">
                                <select class="form-control" name="editType" id="editType" required>
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
                            <div class="mb-3">
                                <label for="editOccupied" class="form-label">Occupied Slots</label>
                                <input type="number" class="form-control" id="editOccupied" name="editOccupied" placeholder="Enter occupied slots" required>
                            </div>
                            <div class="mb-3">
                                <label for="editAvailable" class="form-label">Available Slots</label>
                                <input type="number" class="form-control" id="editAvailable" name="editAvailable" placeholder="Enter available slots" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
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

        //---------------------------Edit Inventory---------------------------//
            // Load data into the modal
            function loadData(inventoryid) {
                $.ajax({
                    url: 'inventory_get.php',
                    type: 'POST',
                    data: { inventoryid: inventoryid },
                    success: function (response) {
                        const result = JSON.parse(response);

                        if (result.success) {
                            $('#editId').val(result.data.inventoryid);
                            $('#editType').val(result.data.locationid);
                            $('#editOccupied').val(result.data.occupied_slots);
                            $('#editAvailable').val(result.data.available_slots);
                        } else {
                            showDynamicToast('Error fetching information data: ' + result.message, 'danger');
                        }
                    },
                    error: function () {
                        showDynamicToast('An error occurred while fetching the information data.', 'danger');
                    },
                });
            }

            // Handle the form submission for editing a inventory
            $('#editForm').on('submit', function (e) {
                e.preventDefault();

                const inventoryId = $('#editId').val();
                const locationType = $('#editType').val();
                const occupiedType = $('#editOccupied').val();
                const availableType = $('#editAvailable').val();

                $.ajax({
                    url: 'inventory_update.php',
                    type: 'POST',
                    data: { inventoryid: inventoryId, locationid: locationType,
                        occupied_slots: occupiedType, available_slots: availableType 
                     },
                    success: function (response) {
                        const result = JSON.parse(response);

                        if (result.success) {
                            $('#editModal').modal('hide');
                            showDynamicToast('Information updated successfully!', 'success');

                            // Optionally reload the page after a short delay
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            showDynamicToast('Error updating information: ' + result.message, 'danger');
                        }
                    },
                    error: function () {
                        showDynamicToast('An error occurred while updating the information.', 'danger');
                    },
                });
            });

        //---------------------------Delete Inventory---------------------------//
        let IdToDelete = null;

        function del(id) {
            IdToDelete = id; // Store the ID to delete
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show(); // Show the modal
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (IdToDelete) {
                $.ajax({
                    url: 'inventory_delete.php',
                    method: 'POST',
                    data: { inventoryid: IdToDelete },
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
                        alert('Error deleting information');
                    }
                });
            }
        });

        function showDeleteToast() {
            const deleteToast = new bootstrap.Toast(document.getElementById('deleteToast'));
            deleteToast.show();
        }


        //---------------------------Search Inventory Results---------------------------//c
        function search() {
            const query = document.getElementById("searchInput").value;

            // Make an AJAX request to fetch search results
            $.ajax({
                url: 'inventory_search.php', 
                method: 'POST',
                data: { query: query },
                success: function(data) {
                    $('#inventory-table tbody').html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error during search request:", error);
                }
            });
        }

        //--------------------------- Add Inventory ---------------------------//
        $(document).ready(function () {
            $('#saveButton').on('click', function () {
                const locationid = $('#locationid').val();
                const occupied_slots = $('#occupiedTypeInput').val();
                const available_slots = $('#availableTypeInput').val();

                if (locationid === '' || occupied_slots === '' || available_slots === '') {
                    showDynamicToast('Please fill in all fields.', 'warning');
                    return;
                }

                // Send data to the server
                $.ajax({
                    url: 'inventory_add.php',
                    type: 'POST',
                    data: {
                        locationid: locationid,
                        occupied_slots: occupied_slots,
                        available_slots: available_slots
                    },
                    success: function (response) {
                        const result = JSON.parse(response);

                        if (result.success) {
                            showDynamicToast('Inventory added successfully!', 'success');
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            showDynamicToast('Error adding inventory: ' + result.message, 'danger');
                        }
                    },
                    error: function () {
                        showDynamicToast('An error occurred while adding the inventory.', 'danger');
                    },
                });
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