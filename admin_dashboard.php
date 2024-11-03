    <?php

    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }



include 'db_connection.php';


if (isset($_POST['update_status']) && isset($_POST['booking_id']) && isset($_POST['status'])) {
    $booking_id = $_POST['booking_id'];
    $status = $_POST['status'];

    $update_sql = "UPDATE bookings SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('si', $status, $booking_id);
    $stmt->execute();

    $fetch_booking_sql = "SELECT total_price, booking_date FROM bookings WHERE id = ?";
    $stmt = $conn->prepare($fetch_booking_sql);
    $stmt->bind_param('i', $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();

    
    $payment_method = 'GCash';


    $check_sales_sql = "SELECT * FROM sales WHERE booking_id = ?";
    $stmt = $conn->prepare($check_sales_sql);
    $stmt->bind_param('i', $booking_id);
    $stmt->execute();
    $sales_result = $stmt->get_result();

    if ($sales_result->num_rows == 0) {

        $insert_sale_sql = "INSERT INTO sales (booking_id, total_price, sales_date, payment_method) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sale_sql);
        $stmt->bind_param('idss', $booking_id, $booking['total_price'], $booking['booking_date'], $payment_method);
        $stmt->execute();
    }

    header("Location: admin_dashboard.php?section=bookings");
    exit();
}


    // Deleting Products
    if (isset($_GET['delete']) && isset($_GET['category'])) {
        $product_id = $_GET['delete'];
        $category = $_GET['category'];

        switch ($category) {
            case 'hotels':
                $delete_sql = "DELETE FROM hotels WHERE id = ?";
                break;
            case 'meals':
                $delete_sql = "DELETE FROM meals WHERE id = ?";
                break;
            case 'ferries':
                $delete_sql = "DELETE FROM ferry_tickets WHERE id = ?";
                break;
            case 'tours':
                $delete_sql = "DELETE FROM tours WHERE id = ?";
                break;
            case 'bookings':
                $delete_sql = "DELETE FROM bookings WHERE id = ?"; 
                break;
            default:
                exit("Invalid category");
        }

        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        header("Location: admin_dashboard.php?section=$category");
        exit();
    }

    $sql_count_hotels = "SELECT COUNT(*) AS count FROM hotels";
    $count_hotels = $conn->query($sql_count_hotels)->fetch_assoc()['count'];

    $sql_count_meals = "SELECT COUNT(*) AS count FROM meals";
    $count_meals = $conn->query($sql_count_meals)->fetch_assoc()['count'];

    $sql_count_ferries = "SELECT COUNT(*) AS count FROM ferry_tickets";
    $count_ferries = $conn->query($sql_count_ferries)->fetch_assoc()['count'];

    $sql_count_tours = "SELECT COUNT(*) AS count FROM tours";
    $count_tours = $conn->query($sql_count_tours)->fetch_assoc()['count'];

    $sql_count_bookings = "SELECT COUNT(*) AS count FROM bookings";
    $count_bookings = $conn->query($sql_count_bookings)->fetch_assoc()['count'];

    // Calculate total bookings
    $sql_total_bookings = "SELECT COUNT(*) AS total_bookings FROM bookings";
    $total_bookings = $conn->query($sql_total_bookings)->fetch_assoc()['total_bookings'];

    // Calculate total sales
    $sql_total_sales = "SELECT SUM(total_price) AS total_sales FROM sales";
    $total_sales = $conn->query($sql_total_sales)->fetch_assoc()['total_sales'];
    
    $sql_hotels = "SELECT * FROM hotels";
    $hotels = $conn->query($sql_hotels);

    $sql_meals = "SELECT * FROM meals";
    $meals = $conn->query($sql_meals);

    $sql_ferries = "SELECT * FROM ferry_tickets";
    $ferries = $conn->query($sql_ferries);

    $sql_tours = "SELECT * FROM tours";
    $tours = $conn->query($sql_tours);

    $sql_bookings = "SELECT * FROM bookings"; 
    $bookings = $conn->query($sql_bookings);

    $sql_sales = "SELECT * FROM sales";
    $sales = $conn->query($sql_sales);

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard - Matt Travel and Tours</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
       <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />


        <style>
            /* Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Playfair+Display:wght@400;700&display=swap');

    
    body, html {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
    }
            body {
               display: flex; 
            }

.sidebar {
    width: 250px;
    height: 100vh;
    background-color: #2c3e50;
    padding-top: 20px;
    position: fixed;
}

.sidebar a {
    text-decoration: none;
    color: white;
    padding: 15px;
    display: block;
    margin-bottom: 10px;
    transition: background-color 0.2s, color 0.2s;
    font-weight: 500;
}

.sidebar a:hover {
    background-color: #34495e;
    color: #ffffff;
}


.content {
    margin-left: 250px;
    padding: 20px;
    width: 100%;
    background-color: #ecf0f1;
    min-height: 100vh;
}


thead.table-light {
    background-color: #f8f9fa; 
    color: #000; 
    font-weight: bold; 
    border-bottom: 2px solid #dee2e6; 
}

table {
    border-collapse: collapse; 
}

thead th {
    padding: 10px; 
    text-align: left; 
}


.btn {
    font-weight: 500;
    padding: 10px 20px;
}

.btn-primary {
    background-color: #2980b9;
    border-color: #2980b9;
    transition: background-color 0.3s;
}

.btn-primary:hover {
    background-color: #3498db;
}

.btn-warning {
    background-color: #e67e22;
    border-color: #e67e22;
}

.btn-danger {
    background-color: #e74c3c;
    border-color: #e74c3c;
}

.modal-header {
    background-color: #2980b9;
    color: white;
}

.modal-body {
    font-size: 1rem;
}

.hidden {
    display: none;
}


.form-control, .form-select {
    border-radius: 8px;
    padding: 10px;
    margin-bottom: 10px;
}


.login-box {
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    width: 300px;
}


.sidebar {
    width: 250px;
    height: 100vh;
    background-color: #cfe2ff; 
    padding-top: 20px;
    position: fixed;
}

.sidebar a {
    text-decoration: none;
    color: #2c3e50; 
    padding: 15px;
    display: block;
    margin-bottom: 10px;
    transition: background-color 0.2s, color 0.2s;
    font-weight: 500;
}

.sidebar a:hover {
    background-color: #b6d4fe; 
    color: #2c3e50; 
}
            .content {
                margin-left: 250px;
                padding: 20px;
                width: 100%;
                 background-color: #f8f9fa;
            }
            .hidden {
                display: none;
            }
           
    .text-truncate {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis; 
    }

        </style>
    </head>
    <body>

        <div class="sidebar">
            <div style="display: flex; align-items: center; padding: 15px;">
            <img src="images/mattlogo.jpg" alt="Company Logo" class="img-fluid" style="width: 60px; height: auto; margin-right: 10px;">
            <h5 style="color: #2c3e50; margin: 0;">Matt Travel and Tours</h5>
            </div>
        <a href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="javascript:void(0)" onclick="toggleSection('manageBookingsSection')"><i class="fas fa-calendar-check"></i> Bookings</a>
        <a href="javascript:void(0)" onclick="toggleSection('manageHotelsSection')"><i class="fas fa-hotel"></i> Manage Hotels</a>
        <a href="javascript:void(0)" onclick="toggleSection('manageMealsSection')"><i class="fas fa-utensils"></i> Manage Meals</a>
        <a href="javascript:void(0)" onclick="toggleSection('manageFerriesSection')"><i class="fas fa-ship"></i> Manage Ferry Tickets</a>
        <a href="javascript:void(0)" onclick="toggleSection('manageToursSection')"><i class="fas fa-map"></i> Manage Tours</a>
        <a href="javascript:void(0)" onclick="toggleSection('salesReportSection')"><i class="fas fa-chart-line"></i> Sales Report</a>

        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>


        <!-- Main Content Area -->
     <div class="content">
            <!-- Dashboard Section -->
            <div id="dashboardSection">
                <h3>Dashboard</h3>
                <div class="row mb-3">
    <div class="col-md-6">
        <div class="card text-white bg-info mb-3">
            <div class="card-header">Total Bookings</div>
            <div class="card-body">
                <h5 class="card-title"><?php echo $total_bookings; ?></h5>
                <p class="card-text">Total number of bookings.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-white bg-secondary mb-3">
            <div class="card-header">Total Sales</div>
            <div class="card-body">
                <h5 class="card-title">₱<?php echo number_format($total_sales, 2); ?></h5>
                <p class="card-text">Total sales from all bookings.</p>
            </div>
        </div>
    </div>
</div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-header">Total Hotels</div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $count_hotels; ?></h5>
                                <p class="card-text">Manage your hotels.</p>
                                <a href="javascript:void(0)" onclick="toggleSection('manageHotelsSection')" class="btn btn-light">Manage Hotels</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-header">Total Meals</div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $count_meals; ?></h5>
                                <p class="card-text">Manage your meals.</p>
                                <a href="javascript:void(0)" onclick="toggleSection('manageMealsSection')" class="btn btn-light">Manage Meals</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-header">Total Ferries</div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $count_ferries; ?></h5>
                                <p class="card-text">Manage your ferry tickets.</p>
                                <a href="javascript:void(0)" onclick="toggleSection('manageFerriesSection')" class="btn btn-light">Manage Ferries</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-danger mb-3">
                            <div class="card-header">Total Tours</div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $count_tours; ?></h5>
                                <p class="card-text">Manage your tours.</p>
                                <a href="javascript:void(0)" onclick="toggleSection('manageToursSection')" class="btn btn-light">Manage Tours</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!-- Booking Section -->
<div id="manageBookingsSection">
    <h3>Manage Bookings</h3>
    <div class="table-responsive mt-3">
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 15%;">Username</th>
                    <th style="width: 20%;">Email</th>
                    <th style="width: 15%;">Contact Number</th>
                    <th style="width: 10%;">Total Price</th>
                    <th style="width: 15%;">Booking Date</th>
                    <th style="width: 10%;">Current Status</th>
                    <th style="width: 10%;">Set Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($bookings->num_rows > 0) {
                    while ($booking = $bookings->fetch_assoc()) {
                        switch ($booking['status']) {
                            case 'Checked-in':
                                $status_class = 'badge bg-success';
                                break;
                            case 'Checked-out':
                                $status_class = 'badge bg-secondary';
                                break;
                            case 'Rebooked':
                                $status_class = 'badge bg-warning text-dark';
                                break;
                            case 'Cancelled':
                                $status_class = 'badge bg-danger';
                                break;
                            default:
                                $status_class = 'badge bg-light text-dark';
                        }
                ?>
                <tr>
                    <td><?php echo $booking['id']; ?></td>
                    <td class="text-truncate"><?php echo htmlspecialchars($booking['username']); ?></td>
                    <td class="text-truncate"><?php echo htmlspecialchars($booking['email']); ?></td>
                    <td><?php echo htmlspecialchars($booking['contact_number']); ?></td>
                    <td>₱<?php echo number_format($booking['total_price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                    
                    <!-- Display the current status with a badge -->
                    <td>
                        <span class="<?php echo $status_class; ?>">
                            <?php echo htmlspecialchars($booking['status']); ?>
                        </span>
                    </td>
                    
                    <!-- Set Status modal trigger -->
                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#setStatusModal<?php echo $booking['id']; ?>">
                            Set
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="setStatusModal<?php echo $booking['id']; ?>" tabindex="-1" aria-labelledby="setStatusModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="setStatusModalLabel">Set Status for Booking ID: <?php echo $booking['id']; ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="admin_dashboard.php?section=bookings">
                                            <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                            <div class="mb-3">
                                                <label for="statusSelect<?php echo $booking['id']; ?>" class="form-label">Select Status</label>
                                                <select name="status" id="statusSelect<?php echo $booking['id']; ?>" class="form-select">
                                                    <option value="Checked-in" <?php echo $booking['status'] == 'Checked-in' ? 'selected' : ''; ?>>Checked-in</option>
                                                    <option value="Checked-out" <?php echo $booking['status'] == 'Checked-out' ? 'selected' : ''; ?>>Checked-out</option>
                                                    <option value="Rebooked" <?php echo $booking['status'] == 'Rebooked' ? 'selected' : ''; ?>>Rebooked</option>
                                                    <option value="Cancelled" <?php echo $booking['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" name="update_status">Update Status</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>

                </tr>
                <?php
                    }
                } else {
                ?>
                <tr>
                    <td colspan="8" class="text-center">No bookings available.</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Manage Hotels Section -->
<div id="manageHotelsSection" class="hidden">
    
    <h3>Manage Hotels</h3>
    <button class="btn btn-primary mb-3" id="openHotelModal">Add New Hotel</button>
    <div class="table-responsive mt-3">
        
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 15%;">Name</th>
                    <th style="width: 10%;">Check-In</th>
                    <th style="width: 10%;">Check-Out</th>
                    <th style="width: 10%;" class="text-truncate">Features</th>
                    <th style="width: 10%;">Capacity</th>
                    <th style="width: 15%;" class="text-truncate">Description</th>
                    <th style="width: 10%;" class="text-truncate">Inclusions</th>
                    <th style="width: 10%;" class="text-truncate">Exclusions</th>
                    <th style="width: 10%;" class="text-truncate">Policy</th>
                    <th style="width: 10%;" class="text-truncate">Fully Booked Dates</th>
                    <th colspan="6" class="text-center">Pricing</th>
                    <th style="width: 10%;">Actions</th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="width: 10%;">2D1N Adult</th>
                    <th style="width: 10%;">2D1N Kid</th>
                    <th style="width: 10%;">3D2N Adult</th>
                    <th style="width: 10%;">3D2N Kid</th>
                    <th style="width: 10%;">4D3N Adult</th>
                    <th style="width: 10%;">4D3N Kid</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($hotels->num_rows > 0) { ?>
                <?php while ($hotel = $hotels->fetch_assoc()) { 
                    $gallery_images = explode(',', $hotel['gallery_images']);
                    $thumbnail = !empty($gallery_images[0]) ? 'matttnt/images/' . trim($gallery_images[0]) : 'matttnt/images/no-image.jpg';
                ?>
                <tr>
                    <td><?php echo $hotel['id']; ?></td>
                    <td class="text-truncate" style="max-width: 150px;"><?php echo htmlspecialchars($hotel['name']); ?></td>
                    <td><?php echo htmlspecialchars($hotel['check_in']); ?></td>
                    <td><?php echo htmlspecialchars($hotel['check_out']); ?></td>
                    <td class="text-truncate" style="max-width: 150px;"><?php echo htmlspecialchars($hotel['features']); ?></td>
                    <td><?php echo htmlspecialchars($hotel['capacity']); ?></td>
                    <td class="text-truncate" style="max-width: 150px;"><?php echo htmlspecialchars($hotel['description']); ?></td>
                    <td class="text-truncate" style="max-width: 150px;"><?php echo htmlspecialchars($hotel['inclusions']); ?></td>
                    <td class="text-truncate" style="max-width: 150px;"><?php echo htmlspecialchars($hotel['exclusions']); ?></td>
                    <td class="text-truncate" style="max-width: 150px;"><?php echo htmlspecialchars($hotel['policy']); ?></td>
                    <td class="text-truncate" style="max-width: 150px;">
                        <?php echo htmlspecialchars($hotel['fully_booked_dates']); ?>
                        <button class="btn btn-info btn-sm" onclick="openDateModal(<?php echo $hotel['id']; ?>)">Add Dates</button>
                    </td>
                    
                    <td>₱<?php echo number_format($hotel['price_2d1n_adult'], 2); ?></td>
                    <td>₱<?php echo number_format($hotel['price_2d1n_kid'], 2); ?></td>
                    <td>₱<?php echo number_format($hotel['price_3d2n_adult'], 2); ?></td>
                    <td>₱<?php echo number_format($hotel['price_3d2n_kid'], 2); ?></td>
                    <td>₱<?php echo number_format($hotel['price_4d3n_adult'], 2); ?></td>
                    <td>₱<?php echo number_format($hotel['price_4d3n_kid'], 2); ?></td>

                    <td>
                         

                        <a href="#" class="btn btn-danger btn-sm" onclick="showDeleteModal('admin_dashboard.php?delete=<?php echo $hotel['id']; ?>&category=hotels')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
        </tr>
        <!-- Modal for Adding Fully Booked Dates -->
<div class="modal fade" id="dateModal" tabindex="-1" aria-labelledby="dateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dateModalLabel">Add Fully Booked Dates</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="hotelId">
                <div class="mb-3">
                    <label for="bookedDates" class="form-label">Select Dates</label>
                    <input type="date" class="form-control" id="bookedDates">
                </div>
                <div id="dateList"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addBookedDate()">Add Date</button>
                 <button type="button" class="btn btn-primary" onclick="saveBookedDates()">Save Dates</button>
            </div>

            </div>
        </div>
    </div>
</div>

        <?php } ?>
    <?php } else { ?>
        <tr>
            <td colspan="20" class="text-center">No hotels found.</td>
        </tr>
    <?php } ?>
</tbody>

        </table>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content text-center">
      <div class="modal-header border-0" style="background-color: white;">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <i class="fas fa-times-circle text-danger" style="font-size: 60px;"></i>
        <h5 class="modal-title mt-3" id="deleteConfirmationModalLabel">Are you sure?</h5>
        <p class="text-muted">Do you really want to delete these records? This process cannot be undone.</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>




    <!-- Edit Hotel Modal -->
    <div class="modal fade" id="editHotelModal" tabindex="-1" aria-labelledby="editHotelLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editHotelLabel">Edit Hotel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editHotelForm">
                        <input type="hidden" id="edit_hotel_id" name="id">
                        
                        <div class="form-group">
                            <label for="edit_hotel_name">Hotel Name</label>
                            <input type="text" id="edit_hotel_name" name="hotel_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
    <label for="edit_price_2d1n_adult" class="form-label">Price for 2D1N (Adult)</label>
    <input type="number" class="form-control" id="edit_price_2d1n_adult" name="edit_price_2d1n_adult" step="0.01" required>
</div>
<div class="mb-3">
    <label for="edit_price_2d1n_kid" class="form-label">Price for 2D1N (Kid)</label>
    <input type="number" class="form-control" id="edit_price_2d1n_kid" name="edit_price_2d1n_kid" step="0.01" required>
</div>
<div class="mb-3">
    <label for="edit_price_3d2n_adult" class="form-label">Price for 3D2N (Adult)</label>
    <input type="number" class="form-control" id="edit_price_3d2n_adult" name="edit_price_3d2n_adult" step="0.01" required>
</div>
<div class="mb-3">
    <label for="edit_price_3d2n_kid" class="form-label">Price for 3D2N (Kid)</label>
    <input type="number" class="form-control" id="edit_price_3d2n_kid" name="edit_price_3d2n_kid" step="0.01" required>
</div>
<div class="mb-3">
    <label for="edit_price_4d3n_adult" class="form-label">Price for 4D3N (Adult)</label>
    <input type="number" class="form-control" id="edit_price_4d3n_adult" name="edit_price_4d3n_adult" step="0.01" required>
</div>
<div class="mb-3">
    <label for="edit_price_4d3n_kid" class="form-label">Price for 4D3N (Kid)</label>
    <input type="number" class="form-control" id="edit_price_4d3n_kid" name="edit_price_4d3n_kid" step="0.01" required>
</div>
    <div class="mb-3">
        <label for="edit_capacity" class="form-label">Capacity</label>
        <select class="form-select" id="edit_capacity" name="edit_capacity" required>
            <option value="2 pax">2 Pax</option>
            <option value="3 pax">3 Pax</option>
            <option value="4 pax">4 Pax</option>
            <option value="5 pax">5 Pax</option>
            <option value="6 pax">6 Pax</option>
        </select>
    </div>

                        <div class="form-group">
                            <label for="edit_check_in">Check-In Time</label>
                            <input type="time" id="edit_check_in" name="check_in" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="edit_check_out">Check-Out Time</label>
                            <input type="time" id="edit_check_out" name="check_out" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="edit_features">Features</label>
                            <div class="form-check">
                                <input type="checkbox" id="edit_feature_wifi" name="features[]" value="Free Wifi" class="form-check-input">
                                <label for="edit_feature_wifi" class="form-check-label">Free Wifi</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="edit_feature_breakfast" name="features[]" value="Free Breakfast" class="form-check-input">
                                <label for="edit_feature_breakfast" class="form-check-label">Free Breakfast</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="edit_feature_pool" name="features[]" value="Swimming Pool" class="form-check-input">
                                <label for="edit_feature_pool" class="form-check-label">Swimming Pool</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="edit_feature_pet" name="features[]" value="Pet Friendly" class="form-check-input">
                                <label for="edit_feature_pet" class="form-check-label">Pet Friendly</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="edit_feature_non_beachfront" name="features[]" value="Non Beachfront" class="form-check-input">
                                <label for="edit_feature_non_beachfront" class="form-check-label">Non Beachfront</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="edit_feature_beachfront" name="features[]" value="Beachfront" class="form-check-input">
                                <label for="edit_feature_beachfront" class="form-check-label">Beachfront</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="edit_feature_kitchen" name="features[]" value="With Kitchen" class="form-check-input">
                                <label for="edit_feature_kitchen" class="form-check-label">With Kitchen</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="edit_feature_grilling_area" name="features[]" value="With Grilling Area" class="form-check-input">
                                <label for="edit_feature_grilling_area" class="form-check-label">With Grilling Area</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="edit_feature_non_smoking" name="features[]" value="Non Smoking" class="form-check-input">
                                <label for="edit_feature_non_smoking" class="form-check-label">Non Smoking</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" id="edit_feature_double_bed" name="features[]" value="Double Sized Bed" class="form-check-input">
                                <label for="edit_feature_double_bed" class="form-check-label">Double Sized Bed</label>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="edit_description">Description</label>
                            <textarea id="edit_description" name="description" rows="4" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                        <label for="thumbnail_image" class="form-label">Thumbnail Image</label>
                        <input type="file" class="form-control" id="thumbnail_image" name="thumbnail_image" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="gallery_images" class="form-label">Gallery Images</label>
                        <input type="file" class="form-control" id="gallery_images" name="gallery_images[]" accept="image/*" multiple required>
                    </div>

                        <div class="form-group">
                            <label for="edit_inclusions">Inclusions</label>
                            <textarea id="edit_inclusions" name="inclusions" rows="2" class="form-control" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="edit_exclusions">Exclusions</label>
                            <textarea id="edit_exclusions" name="exclusions" rows="2" class="form-control" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="edit_policy">Policy</label>
                            <textarea id="edit_policy" name="policy" rows="3" class="form-control" required></textarea>
                        </div>

                       <div class="form-group">
                            <label for="edit_fully_booked_dates">Fully Booked Dates</label>
                            <input type="text" id="edit_fully_booked_dates" name="fully_booked_dates" class="form-control" readonly>
                            <button type="button" class="btn btn-secondary" id="edit_select_dates">Select Dates</button>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

 

           <!-- Manage Meals Section -->
    <div id="manageMealsSection" class="hidden">
        <h3>Manage Meals</h3>
        <button class="btn btn-primary" id="openMealsModal">Add New Meal</button>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <!-- <th>Image</th> -->
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($meals->num_rows > 0) {
                    while ($meal = $meals->fetch_assoc()) {
                        echo "<tr>
                            <td>{$meal['id']}</td>
                            <td>{$meal['name']}</td>
                            <td>₱{$meal['price']}</td>
                            <td>" . substr($meal['description'], 0, 50) . "...</td>";

                        // if (!empty($meal['image_url'])) {
                        //     echo "<td><img src='images/{$meal['image_url']}' alt='Meal Image' width='100'></td>";
                        // } else {
                        //     echo "<td>No Image</td>";
                        // }

                        echo "<td>
               
                <a href='#' class='btn btn-danger btn-sm' onclick=\"showDeleteModal('admin_dashboard.php?delete={$meal['id']}&category=meals')\">
                    <i class='fas fa-trash'></i>
                </a>
                </td>
            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No Meals Found</td></tr>";
                } ?>
            </tbody>
        </table>
    </div>


   <!-- Manage Ferry Tickets Section -->
<div id="manageFerriesSection" class="hidden">
    <h3>Manage Ferry Tickets</h3>
    <button class="btn btn-primary" id="openFerryModal" data-bs-toggle="modal" data-bs-target="#addFerryModal">Add New Ferry Ticket</button>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Route</th>
                <th>Schedule(s)</th>
                <th>Vessel</th>
                <th>Class and Prices</th> 
                <th>Description</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($ferries->num_rows > 0) {
                while ($ferry = $ferries->fetch_assoc()) {
                    echo "<tr>
                        <td>{$ferry['id']}</td>
                        <td>{$ferry['name']}</td>
                        <td>{$ferry['route']}</td>";

                    
                    $schedules = explode(', ', $ferry['schedule']);
                    echo "<td>";
                    foreach ($schedules as $schedule) {
                        echo htmlspecialchars($schedule) . "<br>";
                    }
                    echo "</td>";

                    
            echo "<td>{$ferry['vessel']}</td>";

            
            echo "<td>";
            if ($ferry['vessel'] === 'Fast Craft') {
                echo "Tourist Class:<br>";
                echo "Adult: ₱{$ferry['tourist_adult_price']}<br>";
                echo "Senior/Student/PWD: ₱{$ferry['tourist_senior_price']}<br>";
                echo "Kid: ₱{$ferry['tourist_kid_price']}<br>";
                echo "Toddler: ₱{$ferry['tourist_toddler_price']}<br><br>";

                echo "Business Class:<br>";
                echo "Adult: ₱{$ferry['business_adult_price']}<br>";
                echo "Senior/Student/PWD: ₱{$ferry['business_senior_price']}<br>";
                echo "Kid: ₱{$ferry['business_kid_price']}<br>";
                echo "Toddler: ₱{$ferry['business_toddler_price']}<br>";
            } elseif ($ferry['vessel'] === 'RORO') {
                echo "Economy Class:<br>";
                echo "Adult: ₱{$ferry['economy_adult_price']}<br>";
                echo "Senior/Student/PWD: ₱{$ferry['economy_senior_price']}<br>";
                echo "Kid: ₱{$ferry['economy_kid_price']}<br>";
                echo "Toddler: ₱{$ferry['economy_toddler_price']}<br><br>";

                echo "VIP Class:<br>";
                echo "Adult: ₱{$ferry['vip_adult_price']}<br>";
                echo "Senior/Student/PWD: ₱{$ferry['vip_senior_price']}<br>";
                echo "Kid: ₱{$ferry['vip_kid_price']}<br>";
                echo "Toddler: ₱{$ferry['vip_toddler_price']}<br>";
            }
            echo "</td>";

                    
                    echo "<td>" . substr($ferry['description'], 0, 50) . "...</td>";
                    echo "<td><img src='{$ferry['image_url']}' width='100' height='60' alt='Ferry Image'></td>";

                  
                    echo "<td>
    </a>
    <a href='#' class='btn btn-danger btn-sm' onclick=\"showDeleteModal('admin_dashboard.php?delete={$ferry['id']}&category=ferries')\">
        <i class='fas fa-trash'></i>
    </a>
</td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9' class='text-center'>No Ferries Found</td></tr>";
            } ?>
        </tbody>
    </table>
</div>


<!-- Manage Tours Section -->
<div id="manageToursSection">
    <h3>Manage Tours</h3>
    <button class="btn btn-primary" id="openTourModal">Add New Tour</button>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tour Name</th>
                <th>Tour Type</th>
                <th>Duration</th>
                <th>Price (Adult)</th>
                <th>Price (Kid)</th>
                <th>Inclusion</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($tours->num_rows > 0) {
                while ($tour = $tours->fetch_assoc()) {
                    echo "<tr>
        <td>{$tour['id']}</td>
        <td>{$tour['name']}</td>
        <td>{$tour['tour_type']}</td>
        <td>{$tour['duration']}</td>
        <td>\${$tour['price_adult']}</td>
        <td>\${$tour['price_kid']}</td>
        <td>{$tour['inclusion']}</td>
        <td>{$tour['description']}</td>
        <td>
            
            <a href='#' class='btn btn-danger btn-sm' 
               onclick=\"showDeleteModal('admin_dashboard.php?delete={$tour['id']}&category=tours')\">
               <i class='fas fa-trash'></i>
            </a>
        </td>
    </tr>";
                }
            } else {
                echo "<tr><td colspan='9' class='text-center'>No Tours Found</td></tr>";
            } ?>
        </tbody>
    </table>
</div>

<!-- Edit Tour Modal -->
<div id="editTourModal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Tour</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editTourForm" method="POST" action="update_tour.php">
                    <input type="hidden" name="id" id="tourId">
                    <div class="form-group">
                        <label for="tourType">Tour Type:</label>
                        <input type="text" class="form-control" id="tourType" name="tour_type" required>
                    </div>
                    <div class="form-group">
                        <label for="priceAdult">Price (Adult):</label>
                        <input type="number" step="0.01" class="form-control" id="priceAdult" name="price_adult" required>
                    </div>
                    <div class="form-group">
                        <label for="priceKid">Price (Kid):</label>
                        <input type="number" step="0.01" class="form-control" id="priceKid" name="price_kid" required>
                    </div>
                    <div class="form-group">
                        <label for="inclusion">Inclusion:</label>
                        <textarea class="form-control" id="inclusion" name="inclusion" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exclusion">Exclusion:</label>
                        <textarea class="form-control" id="exclusion" name="exclusion" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="salesReportSection" class="hidden">
    <h3>Sales Report</h3>
    
    <!-- Date Filter Form -->
    <form method="GET" action="admin_dashboard.php?section=salesReport">
        <label for="from_date">From:</label>
        <input type="date" name="from_date" value="<?php echo $_GET['from_date'] ?? ''; ?>">
        <label for="to_date">To:</label>
        <input type="date" name="to_date" value="<?php echo $_GET['to_date'] ?? ''; ?>">
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
    
    <div class="table-responsive mt-3">
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Booking ID</th>
                    <th>Total Price</th>
                    <th>Sales Date</th>
                    <th>Payment Method</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetching filter values from the GET request
                $from_date = $_GET['from_date'] ?? null;
                $to_date = $_GET['to_date'] ?? null;

                // Default SQL query (without filter)
                $sql_sales = "SELECT s.id, s.booking_id, s.total_price, s.sales_date, s.payment_method 
                              FROM sales s WHERE 1";

                // Adding date filter to the SQL query
                if ($from_date && $to_date) {
                    $sql_sales .= " AND s.sales_date BETWEEN ? AND ?";
                    $stmt = $conn->prepare($sql_sales);
                    $stmt->bind_param('ss', $from_date, $to_date);
                } elseif ($from_date) {
                    
                    $sql_sales .= " AND s.sales_date >= ?";
                    $stmt = $conn->prepare($sql_sales);
                    $stmt->bind_param('s', $from_date);
                } elseif ($to_date) {
                    
                    $sql_sales .= " AND s.sales_date <= ?";
                    $stmt = $conn->prepare($sql_sales);
                    $stmt->bind_param('s', $to_date);
                } else {
                    // No filters applied
                    $stmt = $conn->prepare($sql_sales);
                }

                $stmt->execute();
                $sales = $stmt->get_result();

               
                if ($sales->num_rows > 0) {
                    while ($sale = $sales->fetch_assoc()) {
                        echo "<tr>
                            <td>{$sale['id']}</td>
                            <td>{$sale['booking_id']}</td>
                            <td>₱" . number_format($sale['total_price'], 2) . "</td>
                            <td>{$sale['sales_date']}</td>
                            <td>{$sale['payment_method']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No sales available for this date range.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


            <!-- Add Hotel Modal -->
<div class="modal fade" id="addHotelModal" tabindex="-1" aria-labelledby="addHotelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addHotelLabel">Add New Hotel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="add_hotel.php" method="POST" enctype="multipart/form-data">
                    <!-- Hotel Name -->
                    <div class="mb-3">
                        <label for="hotel_select" class="form-label">Select Hotel</label>
                        <select class="form-select" id="hotel_select" name="hotel_name" required>
                            <option value="Villa Monica Hotel">Villa Monica Hotel</option>
                            <option value="White Beach Hotel">White Beach Hotel</option>
                            <option value="The Mang-Yan Grand Hotel">The Mang-Yan Grand Hotel</option>
                        </select>
                    </div>

                    <!-- Thumbnail Image Upload -->
                    <div class="mb-3">
                        <label for="hotel_thumbnail" class="form-label">Hotel Thumbnail Image</label>
                        <input type="file" class="form-control" id="hotel_thumbnail" name="thumbnail_image" required> 
                        <div id="thumbnailPreview" class="mt-3"></div>
                    </div>


                    <div class="mb-3">
                        <label for="hotel_images" class="form-label">Hotel Image Gallery</label>
                        <input type="file" class="form-control" id="hotel_images" name="gallery_images[]" multiple required>
                        <div id="imagePreview" class="mt-3"></div>
                    </div>

                    <!-- Price Fields -->
                    <div class="mb-3">
                        <label for="price_2d1n_adult" class="form-label">Price for 2D1N (Adult)</label>
                        <input type="number" class="form-control" id="price_2d1n_adult" name="price_2d1n_adult" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="price_2d1n_kid" class="form-label">Price for 2D1N (Kid)</label>
                        <input type="number" class="form-control" id="price_2d1n_kid" name="price_2d1n_kid" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="price_3d2n_adult" class="form-label">Price for 3D2N (Adult)</label>
                        <input type="number" class="form-control" id="price_3d2n_adult" name="price_3d2n_adult" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="price_3d2n_kid" class="form-label">Price for 3D2N (Kid)</label>
                        <input type="number" class="form-control" id="price_3d2n_kid" name="price_3d2n_kid" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="price_4d3n_adult" class="form-label">Price for 4D3N (Adult)</label>
                        <input type="number" class="form-control" id="price_4d3n_adult" name="price_4d3n_adult" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="price_4d3n_kid" class="form-label">Price for 4D3N (Kid)</label>
                        <input type="number" class="form-control" id="price_4d3n_kid" name="price_4d3n_kid" step="0.01" required>
                    </div>

                    <!-- Capacity -->
                    <div class="mb-3">
                        <label for="capacity" class="form-label">Capacity</label>
                        <select class="form-select" id="capacity" name="capacity" required>
                            <option value="2 pax">2 Pax</option>
                            <option value="3 pax">3 Pax</option>
                            <option value="4 pax">4 Pax</option>
                            <option value="5 pax">5 Pax</option>
                            <option value="6 pax">6 Pax</option>
                        </select>
                    </div>

                    <!-- Check-in and Check-out Times -->
                    <div class="mb-3">
                        <label for="check_in" class="form-label">Check-in Time</label>
                        <input type="time" class="form-control" id="check_in" name="check_in" required>
                    </div>
                    <div class="mb-3">
                        <label for="check_out" class="form-label">Check-out Time</label>
                        <input type="time" class="form-control" id="check_out" name="check_out" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>

                    <!-- Features -->
                    <div class="mb-3">
                        <label class="form-label">Features</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="feature_wifi" name="features[]" value="Free Wifi">
                            <label class="form-check-label" for="feature_wifi">
                                <i class="fas fa-wifi"></i> Free Wifi
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="feature_breakfast" name="features[]" value="Free Breakfast">
                            <label class="form-check-label" for="feature_breakfast">
                                <i class="fas fa-bacon"></i> Free Breakfast
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="feature_pool" name="features[]" value="Swimming Pool">
                            <label class="form-check-label" for="feature_pool">
                                <i class="fas fa-swimming-pool"></i> Swimming Pool
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="feature_pet_friendly" name="features[]" value="Pet Friendly">
                            <label class="form-check-label" for="feature_pet_friendly">
                                <i class="fas fa-dog"></i> Pet Friendly
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="feature_non_beachfront" name="features[]" value="Non Beachfront">
                            <label class="form-check-label" for="feature_non_beachfront">
                                <i class="fas fa-umbrella-beach"></i> Non Beachfront
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="feature_beachfront" name="features[]" value="Beachfront">
                            <label class="form-check-label" for="feature_beachfront">
                                <i class="fas fa-sun"></i> Beachfront
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="feature_kitchen" name="features[]" value="With Kitchen">
                            <label class="form-check-label" for="feature_kitchen">
                                <i class="fas fa-utensils"></i> With Kitchen
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="feature_grilling_area" name="features[]" value="With Grilling Area">
                            <label class="form-check-label" for="feature_grilling_area">
                                <i class="fas fa-fire"></i> With Grilling Area
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="feature_non_smoking" name="features[]" value="Non Smoking">
                            <label class="form-check-label" for="feature_non_smoking">
                                <i class="fas fa-smoking-ban"></i> Non Smoking
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="feature_double_bed" name="features[]" value="Double Sized Bed">
                            <label class="form-check-label" for="feature_double_bed">
                                <i class="fas fa-bed"></i> Double Sized Bed
                            </label>
                        </div>
                    </div>

                        <div class="mb-3">
                            <label for="inclusions" class="form-label">Inclusions</label>
                            <textarea class="form-control" id="inclusions" name="inclusions" rows="3" placeholder="List of inclusions"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="exclusions" class="form-label">Exclusions</label>
                            <textarea class="form-control" id="exclusions" name="exclusions" rows="3" placeholder="List of exclusions"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="policy" class="form-label">Policy</label>
                            <textarea class="form-control" id="policy" name="policy" rows="3" placeholder="Hotel policies"></textarea>
                        </div>

                    <button type="submit" class="btn btn-primary">Add Hotel</button>
                </form>
            </div>
        </div>
    </div>
</div>

          <!-- Add Meals Modal -->
            <div class="modal fade" id="addMealsModal" tabindex="-1" aria-labelledby="addMealsLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addMealsLabel">Add New Meal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="add_meal.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="meal_name" class="form-label">Meal Name</label>
            <input type="text" class="form-control" id="meal_name" name="meal_name" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Meal Image</label>
            <input type="file" class="form-control" id="image" name="image" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Meal</button>
    </form>


                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Ferry Modal -->
            <div class="modal fade" id="addFerryModal" tabindex="-1" aria-labelledby="addFerryLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addFerryLabel">Add New Ferry Ticket</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                             <form action="add_ferry.php" method="POST" enctype="multipart/form-data">
                                <!-- Name Field -->
<div class="mb-3">
    <label for="name" class="form-label">Ferry Name</label>
    <input type="text" class="form-control" id="name" name="name" required>
</div>

<!-- Description Field -->
<div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea class="form-control" id="description" name="description" required></textarea>
</div>
<!-- Image Upload Field -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload Ferry Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>


    <!-- Select Route -->
    <div class="mb-3">
        <label for="route" class="form-label">Select Route</label>
        <select class="form-select" id="route" name="route" required>
            <option value="Batangas - Puerto Galera">Batangas - Puerto Galera</option>
            <option value="Puerto Galera - Batangas">Puerto Galera - Batangas</option>
        </select>
    </div>

    <!-- Add Multiple Schedules -->
    <div class="mb-3">
        <label class="form-label">Set Schedules</label>
        <div id="scheduleContainer">
            <div class="schedule-item mb-2">
                <input type="text" class="form-control" name="schedules[]" placeholder="e.g., 8:00 AM - 10:00 AM" required>
            </div>
        </div>
        <button type="button" class="btn btn-secondary" id="addSchedule">Add Another Schedule</button>
    </div>

    <!-- Select Vessel -->
    <div class="mb-3">
        <label for="vessel" class="form-label">Select Vessel</label>
        <select class="form-select" id="vessel" name="vessel" required>
            <option value="">--Select Vessel--</option>
            <option value="Fast Craft">Fast Craft</option>
            <option value="RORO">RORO</option>
        </select>
    </div>

    <!-- Set Prices for Fast Craft -->
    <div id="fast-craft-prices" class="mb-3" style="display:none;">
        <h5>Fast Craft Prices</h5>
        <!-- Tourist Class -->
        <label for="tourist_adult_price" class="form-label">Tourist Class (Adult)</label>
        <input type="number" class="form-control" id="tourist_adult_price" name="tourist_adult_price" step="0.01" placeholder="Enter price for adult">

        <label for="tourist_senior_price" class="form-label">Tourist Class (Senior/Student/PWD)</label>
        <input type="number" class="form-control" id="tourist_senior_price" name="tourist_senior_price" step="0.01" placeholder="Enter price for senior/student/PWD">

        <label for="tourist_kid_price" class="form-label">Tourist Class (Kid)</label>
        <input type="number" class="form-control" id="tourist_kid_price" name="tourist_kid_price" step="0.01" placeholder="Enter price for kid">

        <label for="tourist_toddler_price" class="form-label">Tourist Class (Toddler)</label>
        <input type="number" class="form-control" id="tourist_toddler_price" name="tourist_toddler_price" step="0.01" placeholder="Enter price for toddler">

        <!-- Business Class -->
        <label for="business_adult_price" class="form-label">Business Class (Adult)</label>
        <input type="number" class="form-control" id="business_adult_price" name="business_adult_price" step="0.01" placeholder="Enter price for adult">

        <label for="business_senior_price" class="form-label">Business Class (Senior/Student/PWD)</label>
        <input type="number" class="form-control" id="business_senior_price" name="business_senior_price" step="0.01" placeholder="Enter price for senior/student/PWD">

        <label for="business_kid_price" class="form-label">Business Class (Kid)</label>
        <input type="number" class="form-control" id="business_kid_price" name="business_kid_price" step="0.01" placeholder="Enter price for kid">

        <label for="business_toddler_price" class="form-label">Business Class (Toddler)</label>
        <input type="number" class="form-control" id="business_toddler_price" name="business_toddler_price" step="0.01" placeholder="Enter price for toddler">
    </div>

    <!-- Set Prices for RORO -->
    <div id="roro-prices" class="mb-3" style="display:none;">
        <h5>RORO Prices</h5>
        <!-- Economy Class -->
        <label for="economy_adult_price" class="form-label">Economy Class (Adult)</label>
        <input type="number" class="form-control" id="economy_adult_price" name="economy_adult_price" step="0.01" placeholder="Enter price for adult">

        <label for="economy_senior_price" class="form-label">Economy Class (Senior/Student/PWD)</label>
        <input type="number" class="form-control" id="economy_senior_price" name="economy_senior_price" step="0.01" placeholder="Enter price for senior/student/PWD">

        <label for="economy_kid_price" class="form-label">Economy Class (Kid)</label>
        <input type="number" class="form-control" id="economy_kid_price" name="economy_kid_price" step="0.01" placeholder="Enter price for kid">

        <label for="economy_toddler_price" class="form-label">Economy Class (Toddler)</label>
        <input type="number" class="form-control" id="economy_toddler_price" name="economy_toddler_price" step="0.01" placeholder="Enter price for toddler">

        <!-- VIP Class -->
        <label for="vip_adult_price" class="form-label">VIP Class (Adult)</label>
        <input type="number" class="form-control" id="vip_adult_price" name="vip_adult_price" step="0.01" placeholder="Enter price for adult">

        <label for="vip_senior_price" class="form-label">VIP Class (Senior/Student/PWD)</label>
        <input type="number" class="form-control" id="vip_senior_price" name="vip_senior_price" step="0.01" placeholder="Enter price for senior/student/PWD">

        <label for="vip_kid_price" class="form-label">VIP Class (Kid)</label>
        <input type="number" class="form-control" id="vip_kid_price" name="vip_kid_price" step="0.01" placeholder="Enter price for kid">

        <label for="vip_toddler_price" class="form-label">VIP Class (Toddler)</label>
        <input type="number" class="form-control" id="vip_toddler_price" name="vip_toddler_price" step="0.01" placeholder="Enter price for toddler">
    </div>

    <!-- Travel Time -->
    <div class="mb-3">
        <label for="travel_time" class="form-label">Travel Time</label>
        <input type="text" class="form-control" id="travel_time" name="travel_time" required placeholder="e.g., 1 hour 45 minutes">
    </div>

    <button type="submit" class="btn btn-primary">Add Ferry Ticket</button>
</form>

                        </div>
                    </div>
                </div>
            </div>

<!-- Add Tour Modal -->
<div class="modal fade" id="addTourModal" tabindex="-1" aria-labelledby="addTourLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTourLabel">Add New Tour</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="add_tour.php" method="POST" enctype="multipart/form-data">
                    <!-- Name field -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Tour Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    
                    <!-- Tour Type -->
                    <div class="mb-3">
                        <label for="tour_type" class="form-label">Tour Type</label>
                        <select class="form-select" id="tour_type" name="tour_type" required>
                            <option value="Snorkeling">Snorkeling Tour</option>
                            <option value="Island Hopping">Island Hopping Tour</option>
                            <option value="Land Tour">Land Tour</option>
                        </select>
                    </div>

                    <!-- Inclusion -->
                    <div class="mb-3">
                            <label for="inclusions" class="form-label">Inclusions</label>
                            <textarea class="form-control" id="itenerary" name="itinerary" rows="3" placeholder="List of inclusions"></textarea>
                    </div>
                        

                    <!-- Duration -->
                    <div class="mb-3">
                        <label for="duration" class="form-label">Duration</label>
                        <input type="text" class="form-control" id="duration" name="duration" placeholder="e.g., 4hrs, 2 days" required>
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>

                    <!-- Price for Adults -->
                    <div class="mb-3">
                        <label for="price_adult" class="form-label">Price (Adult)</label>
                        <input type="number" step="0.01" class="form-control" id="price_adult" name="price_adult" required>
                    </div>

                    <!-- Price for Kids -->
                    <div class="mb-3">
                        <label for="price_kid" class="form-label">Price (Kid)</label>
                        <input type="number" step="0.01" class="form-control" id="price_kid" name="price_kid">
                    </div>

                    <!-- Thumbnail Image -->
                    <div class="mb-3">
                        <label for="thumbnail_image" class="form-label">Thumbnail Image</label>
                        <input type="file" class="form-control" id="thumbnail_image" name="thumbnail_image" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Tour</button>
                </form>
            </div>
        </div>
    </div>
</div>


        </div> 
        <!-- JavaScript -->
        <script>
            function toggleSection(sectionId) {
                const sections = ['dashboardSection', 'manageBookingsSection', 'manageHotelsSection', 'manageMealsSection', 'manageFerriesSection', 'manageToursSection','salesReportSection'];
                sections.forEach(function(section) {
                    document.getElementById(section).style.display = section === sectionId ? 'block' : 'none';
                });
            }

            toggleSection('dashboardSection');

            // Manually trigger modals
            document.getElementById('openHotelModal').addEventListener('click', function () {
                var hotelModal = new bootstrap.Modal(document.getElementById('addHotelModal'), {});
                hotelModal.show();
            });

            document.getElementById('openMealsModal').addEventListener('click', function () {
                var mealsModal = new bootstrap.Modal(document.getElementById('addMealsModal'), {});
                mealsModal.show();
            });

            document.getElementById('openFerryModal').addEventListener('click', function () {
                var ferryModal = new bootstrap.Modal(document.getElementById('addFerryModal'), {});
                ferryModal.show();
            });

            document.getElementById('openTourModal').addEventListener('click', function () {
                var tourModal = new bootstrap.Modal(document.getElementById('addTourModal'), {});
                tourModal.show();
            });
            document.getElementById('hotel_images').addEventListener('change', function(event) {
                const imagePreview = document.getElementById('imagePreview');

        
        if (event.target.files && event.target.files.length > 0) {
            Array.from(event.target.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = "100px"; 
                    img.style.marginRight = "10px";
                    img.style.marginTop = "10px";
                    imagePreview.appendChild(img);
                };
                reader.readAsDataURL(file); 
            });
        }
    });

 document.addEventListener("DOMContentLoaded", function() {
    const vesselSelect = document.getElementById("vessel");
    const fastCraftPrices = document.getElementById("fast-craft-prices");
    const roroPrices = document.getElementById("roro-prices");

    vesselSelect.addEventListener("change", function() {
        if (this.value === "Fast Craft") {
            fastCraftPrices.style.display = "block";
            roroPrices.style.display = "none";
        } else if (this.value === "RORO") {
            fastCraftPrices.style.display = "none";
            roroPrices.style.display = "block";
        } else {
            fastCraftPrices.style.display = "none";
            roroPrices.style.display = "none";
        }
    });
});
    // Add schedule functionality
    document.getElementById('addSchedule').addEventListener('click', function () {
        const scheduleContainer = document.getElementById('scheduleContainer');
        const newScheduleInput = document.createElement('div');
        newScheduleInput.classList.add('schedule-item', 'mb-2');
        newScheduleInput.innerHTML = '<input type="text" class="form-control" name="schedules[]" placeholder="e.g., 8:00 AM - 10:00 AM" required>';
        scheduleContainer.appendChild(newScheduleInput);
    });
    document.getElementById('gallery_images').addEventListener('change', function(event) {
    const imagePreview = document.getElementById('image_preview');
    imagePreview.innerHTML = ''; 
    const files = event.target.files;
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '100px'; 
            img.style.marginRight = '10px';
            imagePreview.appendChild(img);
        }
        
        reader.readAsDataURL(file);
    }
});
    function showDeleteModal(deleteUrl) {
    var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    confirmDeleteBtn.href = deleteUrl;
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
    deleteModal.show();
}
    let bookedDates = [];

    function openDateModal(hotelId) {
 
    document.getElementById('hotelId').value = hotelId;

    bookedDates = [];
    document.getElementById('dateList').innerHTML = ''; 

    
    $.ajax({
        url: 'get_fully_booked_dates.php', 
        type: 'GET',
        data: { hotel_id: hotelId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                
                response.dates.forEach(function(date) {
                    bookedDates.push(date); 
                    document.getElementById('dateList').innerHTML += `<div>${date} <button class="btn btn-danger btn-sm" onclick="removeDate('${date}')">Remove</button></div>`;
                });
            } else {
                alert("Error fetching booked dates: " + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error fetching dates:", error);
            alert("An error occurred while fetching the booked dates.");
        }
    });

    // Show the modal
    $('#dateModal').modal('show');
}


    function addBookedDate() {
        const dateInput = document.getElementById('bookedDates');
        const dateValue = dateInput.value;

        if (dateValue) {
            bookedDates.push(dateValue);
            document.getElementById('dateList').innerHTML += `<div>${dateValue} <button class="btn btn-danger btn-sm" onclick="removeDate('${dateValue}')">Remove</button></div>`;
            dateInput.value = ''; // Clear the input
        }
    }

    function removeDate(date) {
        bookedDates = bookedDates.filter(d => d !== date);
        document.getElementById('dateList').innerHTML = bookedDates.map(d => `<div>${d} <button class="btn btn-danger btn-sm" onclick="removeDate('${d}')">Remove</button></div>`).join('');
    }
    function saveBookedDates() {
    const hotelId = document.getElementById('hotelId').value;

   
    if (bookedDates.length === 0) {
        alert("No dates to save!");
        return;
    }

   
    $.ajax({
        url: 'set_fully_booked_dates.php', 
        type: 'POST',
        data: {
            hotel_id: hotelId,
            booked_dates: bookedDates
        },
        dataType: 'json', 
        success: function(response) {
            if (response.success) {
                alert(response.message);
                $('#dateModal').modal('hide'); 
            } else {
                alert("Error: " + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error saving dates:", error);
            alert("An error occurred while saving the dates.");
        }
    });
}

 </script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>



     <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Your Custom JavaScript -->
    <script src="admin_dashboard.js"></script>
    </body>
    </html>

    <?php
    $conn->close();
    ?>
