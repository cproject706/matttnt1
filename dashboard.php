<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'db_connection.php';

// Fetch user information (account details)
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fetch bookings for the user
$bookings_stmt = $conn->prepare("SELECT * FROM bookings WHERE id = ?");
$bookings_stmt->bind_param("i", $id);
$bookings_stmt->execute();
$bookings_result = $bookings_stmt->get_result();

// Fetch reviews for the user
$reviews_stmt = $conn->prepare("SELECT * FROM reviews WHERE user_id = ?");
$reviews_stmt->bind_param("i", $user_id);
$reviews_stmt->execute();
$reviews_result = $reviews_stmt->get_result();




// Fetch data based on the category
function fetchHotels($conn, $hotel)
{
    $stmt = $conn->prepare("SELECT * FROM hotels WHERE name = ?");
    $stmt->bind_param("s", $hotel);
    $stmt->execute();
    return $stmt->get_result();
}
function fetchMeals($conn)
{
    $stmt = $conn->prepare("SELECT * FROM meals");
    $stmt->execute();
    return $stmt->get_result();
}

function fetchFerries($conn)
{
    $stmt = $conn->prepare("SELECT * FROM ferry_tickets");
    $stmt->execute();
    return $stmt->get_result();
}
function fetchTours($conn)
{
    $stmt = $conn->prepare("SELECT * FROM tours");
    $stmt->execute();
    return $stmt->get_result();
}

$sql = "SELECT * FROM tours";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matt Travel and Tours</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="styles2.css">


    <style>
        body {
            font-family: Roboto, sans-serif;
            padding-top: 70px;

        }

         h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            font-weight: 600;
            color: #3498db; 
            text-align: center;
            margin-top: 50px;
            text-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
        }

        #numberOfNightsContainer {
            display: inline-block;
            background-color: #f8f9fa;
            border: 2px solid #007bff;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 1.25rem;
            font-weight: bold;
            color: #007bff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;

        }

        .input-group {
            width: 150px;
        }

        .input-group .btn {
            width: 35px;
        }

        .input-group input {
            text-align: center;
            padding: 5px;
        }

        .cart-item-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        .list-group-item {
            border: none;
            padding: 10px 0;
        }

        .list-group-item p {
            font-size: 14px;
        }


        #cartItems {
            list-style-type: none;
            padding: 0;
            margin: 0;
            max-width: 600px;
            margin: 20px auto;
        }

        .list-group-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .list-group-item img.cart-item-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }

        .list-group-item p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        .list-group-item p strong {
            font-size: 16px;
            color: #333;
        }

        #cartItems .d-flex {
            display: flex;
            align-items: flex-start;
        }

        #cartItems .d-flex img {
            margin-right: 15px;
        }

        .list-group-item div {
            flex: 1;
        }

        .cart-item-price {
            color: #e67e22;
            font-weight: bold;
        }

        .total-price {
            font-size: 16px;
            font-weight: bold;
            color: #2ecc71;
        }

        .add-to-cart i {
            visibility: visible !important;
            display: inline-block !important;
            font-size: 16px !important;
        }

        /* Button Styles */
        .btn {
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .btn-outline-secondary {
            background-color: white;
            color: #3498db;
            border: 1px solid #3498db;
            border-radius: 4px;
        }

        .btn-outline-secondary:hover {
            background-color: #3498db;
            color: white;
        }

        /* Modal Styles */
        .modal-header {
            background-color: #3498db;
            color: white;
        }

        .modal-title {
            font-size: 18px;
        }

        .modal-footer button {
            background-color: #e67e22;
            border: none;
        }

        .modal-footer button:hover {
            background-color: #d35400;
        }

        .modal-body label {
            font-size: 14px;
            color: #333;
        }

        .input-group {
            display: flex;
            align-items: center;
        }

        .input-group button {
            border-radius: 0;
        }

        .input-group input {
            border: 1px solid #ddd;
            text-align: center;
        }

        #pricePerHeadAdults,
        #pricePerHeadKids {
            color: #3498db;
            font-size: 14px;
        }

        #totalPriceAdults,
        #totalPriceKids {
            color: #2ecc71;
            font-weight: bold;
        }

        footer {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        @media (max-width: 576px) {
            .list-group-item img {
                width: 80px;
                height: 80px;
            }
        }

        @media (min-width: 768px) {
            .product-card {
                width: auto;
            }
        }
        .remove-item {
            align-self: flex-end; 
        }

       
        @media (max-width: 576px) {
            h2 {
                font-size: 1.5rem; 
                margin-top: 100px; 
                padding: 0 10px; 
            }

            .navbar-brand {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                width: 100%;
            }

            .navbar-toggler {
                margin-top: 10px;
                display: flex;
                justify-content: center;
                width: 30%; 
                max-width: 100px; 
            }
            }
        }

        /* Button Styles */
        .btn {
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        footer {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light shadow" id="navbar">
        <div class="container-fluid d-flex align-items-center flex-column">
            <!-- Logo and Text -->
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="images/mattlogo.jpg" alt="Matt Travel Logo" class="img-fluid me-2" style="height: 50px;">
                <span>Matt Destinations Travel and Tours</span>
            </a>
            <!-- Toggler for small screens -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Navbar menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Shopping Cart link -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                            <i class="fas fa-shopping-cart"></i> Shopping Cart
                            <span id="cartBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display: none;">
                                0
                            </span>
                        </a>
                    </li>

                    <!-- Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i> Profile
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#accountDetailsModal"><i class="fas fa-id-badge"></i> Account Details</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#bookingsModal"><i class="fas fa-calendar-alt"></i> My Bookings</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#reviewsModal"><i class="fas fa-star"></i> My Reviews</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>




    <!-- Offcanvas Shopping Cart -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasCartLabel">Shopping Cart</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul id="cartItems" class="list-group">
                <li class="list-group-item">Your cart is empty.</li>
            </ul>
            <!-- <div class="total-bill">
                <p><strong>Total Bill: ₱<span id="totalBill">0.00</span></strong></p>
            </div> -->
            <!-- Alert box -->
            <div class="alert alert-danger mt-3" role="alert">
                <strong>Pay 20% downpayment now, Pay your balance upon arrival!</strong>
            </div>
            <!-- Proceed to Checkout Button -->
            <button id="proceedToCheckout" class="btn btn-primary">Proceed to Checkout</button>
        </div>
    </div>

    <!-- Profile Modal Example -->
    <div class="modal fade" id="accountDetailsModal" tabindex="-1" aria-labelledby="accountDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountDetailsModalLabel">Account Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Registered On:</strong> <?php echo htmlspecialchars($user['reg_date']); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<!-- My Bookings Modal -->
<div class="modal fade" id="bookingsModal" tabindex="-1" aria-labelledby="bookingsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingsModalLabel">My Bookings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                // Assuming $username is available and you're fetching bookings for the logged-in user
                $query = "SELECT * FROM bookings WHERE username = '$username'";
                $bookings_result = $conn->query($query);

                if ($bookings_result->num_rows > 0): ?>
                    <ul class="list-group">
                        <?php while ($booking = $bookings_result->fetch_assoc()): ?>
                            <li class="list-group-item">
                                <strong>Booking ID:</strong> <?php echo htmlspecialchars($booking['id']); ?><br>
                                <strong>Username:</strong> <?php echo htmlspecialchars($booking['username']); ?><br>
                                <strong>Email:</strong> <?php echo htmlspecialchars($booking['email']); ?><br>
                                <strong>Contact Number:</strong> <?php echo htmlspecialchars($booking['contact_number']); ?><br>
                                <strong>Total Price:</strong> <?php echo htmlspecialchars($booking['total_price']); ?><br>
                                <strong>Booking Date:</strong> <?php echo htmlspecialchars($booking['booking_date']); ?><br>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>No bookings available at the moment.</p>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!-- Print Button -->
                <button type="button" class="btn btn-primary" onclick="printBooking()">Print Confirmation</button>
            </div>
        </div>
    </div>
</div>


    <!-- My Reviews Modal -->
    <div class="modal fade" id="reviewsModal" tabindex="-1" aria-labelledby="reviewsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewsModalLabel">My Reviews</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if ($reviews_result->num_rows > 0): ?>
                        <ul class="list-group">
                            <?php while ($review = $reviews_result->fetch_assoc()): ?>
                                <li class="list-group-item">
                                    <strong>Review Date:</strong> <?php echo htmlspecialchars($review['review_date']); ?><br>
                                    <strong>Review:</strong> <?php echo htmlspecialchars($review['review_text']); ?>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php else: ?>
                        <p>No reviews available at the moment.</p>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Main Content Area -->

    <div class="container mt-4">
        <h2><?php echo htmlspecialchars($user['username']); ?>, let’s create your dream travel package together! Customize it to make every moment unforgettable!</h2>

        <!-- Product Categories Tabs -->
        <ul class="nav nav-tabs mt-5" id="productTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="hotel-tab" data-bs-toggle="tab" data-bs-target="#hotel" type="button" role="tab" aria-controls="hotel" aria-selected="true">
                    <i class="fas fa-hotel"></i> Hotels + Tour Packages
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="meals-tab" data-bs-toggle="tab" data-bs-target="#meals" type="button" role="tab" aria-controls="meals" aria-selected="false">
                    <i class="fas fa-utensils"></i> Meals
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="ferry-tab" data-bs-toggle="tab" data-bs-target="#ferry" type="button" role="tab" aria-controls="ferry" aria-selected="false">
                    <i class="fas fa-ship"></i> Ferry Tickets
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tours-tab" data-bs-toggle="tab" data-bs-target="#tours" type="button" role="tab" aria-controls="tours" aria-selected="false">
                    <i class="fas fa-map-marker-alt"></i> Tours
                </button>

            </li>
        </ul>


        <!-- Tab Content -->
        <div class="tab-content mt-4" id="productTabContent">

            <!-- Hotels + Tour Packages Tab -->
            <div class="tab-pane fade show active" id="hotel" role="tabpanel" aria-labelledby="hotel-tab">
                <ul class="nav nav-pills mb-3" id="hotelSubTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="villa-monica-tab" data-bs-toggle="pill" data-bs-target="#villa-monica" type="button" role="tab" aria-controls="villa-monica" aria-selected="true">Villa Monica Hotel</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="white-beach-tab" data-bs-toggle="pill" data-bs-target="#white-beach" type="button" role="tab" aria-controls="white-beach" aria-selected="false">White Beach Hotel</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="mangyan-grand-tab" data-bs-toggle="pill" data-bs-target="#mangyan-grand" type="button" role="tab" aria-controls="mangyan-grand" aria-selected="false">The Mang-Yan Grand Hotel</button>
                    </li>
                </ul>

                <!-- Hotel Sub-Tab Content -->
                <div class="tab-content" id="hotelTabContent">
                    <div class="tab-pane fade show active" id="villa-monica" role="tabpanel" aria-labelledby="villa-monica-tab">
                        <!-- Villa Monica Hotel Products -->
                        <div class="row">
                            <!-- Card Section for Map and Nearby Establishments -->
                            <div class="col-md-12">
                                <div class="card mb-3">
                                    <div class="row g-0">
                                        <!-- Map Section in Card -->
                                        <div class="col-md-4">
                                            <div class="map-container">
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d990543.556440394!2d120.35775271256784!3d14.117812795420251!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bcf97e4ff3041f%3A0xb6e958d1e330b791!2sVilla%20Monica%20Hotel%20White%20beach%20Puerto%20Galera!5e0!3m2!1sen!2sph!4v1726999182697!5m2!1sen!2sph"
                                                    width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title">Nearby Establishments</h5>
                                                <p class="text-muted mt-3"><small>Marion Roos's Grill & Restobar - 170 m</small></p>
                                                <p class="text-muted mt-3"><small>Aqua Restobar - 190 m</small></p>
                                                <p class="text-muted mt-3"><small>Polycare Pharmacy - 400 m</small></p>
                                                <p class="text-muted mt-3"><small>Itim Tattoo Shop - 250 m</small></p>
                                                <p class="text-muted mt-3"><small>San Isidro Chapel Catholic Church - 650 m</small></p>
                                                <p class="text-muted mt-3"><small>Iglesia Ni Cristo Lokal ng White Beach- 700 m</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <?php
                            $result_villa_monica = fetchHotels($conn, 'Villa Monica Hotel');
                            if ($result_villa_monica && $result_villa_monica->num_rows > 0) {
                                while ($product = $result_villa_monica->fetch_assoc()) {
                                    $product_id = $product['id'];
                                    // Convert check-in and check-out time to AM/PM format
                                    $check_in_12hr = DateTime::createFromFormat('H:i:s', $product['check_in'])->format('h:i A');
                                    $check_out_12hr = DateTime::createFromFormat('H:i:s', $product['check_out'])->format('h:i A');

                                    echo '<div class="col-md-4 mb-4">';
                                    echo '<div class="card product-card">';
                                    echo '<img src="' . htmlspecialchars($product['thumbnail_image']) . '" class="card-img-top" alt="' . htmlspecialchars($product['name']) . '">';

                                    echo '<div class="card-body">';
                                    echo '<h5 class="card-title">' . htmlspecialchars($product['name']) . '</h5>';
                                    echo '<p class="card-text">' . htmlspecialchars($product['description']) . '</p>';
                                    // Display the converted times
                                    echo '<p><strong>Check-in Time:</strong> ' . $check_in_12hr . '</p>';
                                    echo '<p><strong>Check-out Time:</strong> ' . $check_out_12hr . '</p>';
                                    echo '<p><strong>Features:</strong><br><span class="features-list" data-features="' . htmlspecialchars($product['features']) . '"></span></p>';
                                    echo '<p><strong>Capacity:</strong> ' . htmlspecialchars($product['capacity']) . ' persons</p>';
                                    echo '<p><strong>Price starts at (Adult):</strong> ₱' . number_format($product['price_2d1n_adult'], 2) . '</p>';
                                    echo '<p><strong>Price starts at (Kid):</strong> ₱' . number_format($product['price_2d1n_kid'], 2) . '</p>';

                                    // Add to Cart button
                                    echo '<a href="#" class="btn btn-success add-to-cart me-2" 
                data-product-id="' . $product_id . '"
                data-product-name="' . htmlspecialchars($product['name']) . '"
                data-product-image="images/' . htmlspecialchars($product['thumbnail_image']) . '" 
                data-price-2d1n-adult="' . htmlspecialchars($product['price_2d1n_adult']) . '"
                data-price-2d1n-kid="' . htmlspecialchars($product['price_2d1n_kid']) . '"
                data-price-3d2n-adult="' . htmlspecialchars($product['price_3d2n_adult']) . '"
                data-price-3d2n-kid="' . htmlspecialchars($product['price_3d2n_kid']) . '"
                data-price-4d3n-adult="' . htmlspecialchars($product['price_4d3n_adult']) . '"
                data-price-4d3n-kid="' . htmlspecialchars($product['price_4d3n_kid']) . '"
                data-capacity="' . htmlspecialchars($product['capacity']) . '">
                <i class="fas fa-shopping-bag"></i> Add to Cart
            </a>';

                                    // View More button (link to details.php)
                                    echo '<a href="details.php?id=' . $product_id . '" class="btn btn-primary"> 
                <i class="fas fa-info-circle"></i> View More</a>';

                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo "<p>No products available for Villa Monica Hotel.</p>";
                            }
                            ?>





                        </div>
                    </div>

                    <!-- Insert Date Picker Modal Outside Loop -->
                    <div class="modal fade" id="datePickerModal" tabindex="-1" aria-labelledby="datePickerModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="datePickerModalLabel">Select Your Preferred Dates</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <label for="modalCheckInDate" class="form-label">Check-In Date:</label>
                                    <input type="date" id="modalCheckInDate" class="form-control">
                                    <label for="modalCheckOutDate" class="form-label mt-3">Check-Out Date:</label>
                                    <input type="date" id="modalCheckOutDate" class="form-control">
                                    <p class="mt-3"><strong>Number of Nights:</strong> <span id="numberOfNightsContainer"><span id="numberOfNights">0</span></span></p>
                                    <p id="roomCapacity" class="mt-3"><strong>Room Capacity:</strong> N/A</p>
                                    <div class="mt-3">
                                        <label class="form-label">Number of Rooms:</label>
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary" type="button" id="minusRooms">-</button>
                                            <input type="number" id="roomsCount" class="form-control text-center" min="1" value="1" readonly>
                                            <button class="btn btn-outline-secondary" type="button" id="plusRooms">+</button>
                                        </div>
                                    </div>
                                    <!-- Adults Section -->
                                    <div class="mt-3">
                                        <label class="form-label">Number of Adults:</label>
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary" type="button" id="minusAdults">-</button>
                                            <input type="number" id="adultsCount" class="form-control text-center" min="1" value="1" readonly>
                                            <button class="btn btn-outline-secondary" type="button" id="plusAdults">+</button>
                                        </div>
                                        <p id="pricePerHeadAdults" class="mt-2">Price Per Adult: ₱0.00</p>
                                        <p id="totalPriceAdults" class="mt-2">Total Price (Adults): ₱0.00</p>
                                    </div>

                                    <!-- Kids Section -->
                                    <div class="mt-3">
                                        <label class="form-label">Number of Kids:</label>
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary" type="button" id="minusKids">-</button>
                                            <input type="number" id="kidsCount" class="form-control text-center" min="0" value="0" readonly>
                                            <button class="btn btn-outline-secondary" type="button" id="plusKids">+</button>
                                        </div>
                                        <p id="pricePerHeadKids" class="mt-2">Price Per Kid: ₱0.00</p>
                                        <p id="totalPriceKids" class="mt-2">Total Price (Kids): ₱0.00</p>
                                    </div>



                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" id="confirmDate" class="btn btn-primary">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- White Beach Hotel Products -->
                    <div class="tab-pane fade" id="white-beach" role="tabpanel" aria-labelledby="white-beach-tab">
                        <div class="row">
                            <!-- Card Section for Map and Nearby Establishments -->
                            <div class="col-md-12">
                                <div class="card mb-3">
                                    <div class="row g-0">
                                        <!-- Map Section in Card -->
                                        <div class="col-md-4">
                                            <div class="map-container">
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1939.7441719435656!2d120.90291438854729!3d13.50559545622689!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bcf87d7487b409%3A0x8fb820422c2be47d!2sWhite%20Beach%20Resort!5e0!3m2!1sen!2sph!4v1727655356725!5m2!1sen!2sph" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            </div>
                                        </div>

                                        <!-- Nearby Establishments Section in Card -->
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title">Nearby Establishments</h5>
                                                <p class="text-muted mt-3"><small>Marion Roos's Grill & Restobar - 170 m</small></p>
                                                <p class="text-muted mt-3"><small>Aqua Restobar - 190 m</small></p>
                                                <p class="text-muted mt-3"><small>Polycare Pharmacy - 400 m</small></p>
                                                <p class="text-muted mt-3"><small>Itim Tattoo Shop - 250 m</small></p>
                                                <p class="text-muted mt-3"><small>San Isidro Chapel Catholic Church - 650 m</small></p>
                                                <p class="text-muted mt-3"><small>Iglesia Ni Cristo Lokal ng White Beach- 700 m</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            $result_white_beach = fetchHotels($conn, 'White Beach Hotel');
                            if ($result_white_beach && $result_white_beach->num_rows > 0) {
                                while ($product = $result_white_beach->fetch_assoc()) {
                                    $product_id = $product['id'];
                                    // Convert check-in and check-out time to AM/PM format
                                    $check_in_12hr = DateTime::createFromFormat('H:i:s', $product['check_in'])->format('h:i A');
                                    $check_out_12hr = DateTime::createFromFormat('H:i:s', $product['check_out'])->format('h:i A');

                                    echo '<div class="col-md-4 mb-4">';
                                    echo '<div class="card product-card">';
                                    echo '<img src="' . htmlspecialchars($product['thumbnail_image']) . '" class="card-img-top" alt="' . htmlspecialchars($product['name']) . '">';

                                    echo '<div class="card-body">';
                                    echo '<h5 class="card-title">' . htmlspecialchars($product['name']) . '</h5>';
                                    echo '<p class="card-text">' . htmlspecialchars($product['description']) . '</p>';
                                    // Display the converted times
                                    echo '<p><strong>Check-in Time:</strong> ' . $check_in_12hr . '</p>';
                                    echo '<p><strong>Check-out Time:</strong> ' . $check_out_12hr . '</p>';
                                    echo '<p><strong>Features:</strong><br><span class="features-list" data-features="' . htmlspecialchars($product['features']) . '"></span></p>';
                                    echo '<p><strong>Capacity:</strong> ' . htmlspecialchars($product['capacity']) . ' persons</p>';
                                    echo '<p><strong>Price starts at (Adult):</strong> ₱' . number_format($product['price_2d1n_adult'], 2) . '</p>';
                                    echo '<p><strong>Price starts at (Kid):</strong> ₱' . number_format($product['price_2d1n_kid'], 2) . '</p>';

                                    // Add to Cart button
                                    echo '<a href="#" class="btn btn-success add-to-cart me-2" 
                data-product-id="' . $product_id . '"
                data-product-name="' . htmlspecialchars($product['name']) . '"
                data-product-image="images/' . htmlspecialchars($product['thumbnail_image']) . '" 
                data-price-2d1n-adult="' . htmlspecialchars($product['price_2d1n_adult']) . '"
                data-price-2d1n-kid="' . htmlspecialchars($product['price_2d1n_kid']) . '"
                data-price-3d2n-adult="' . htmlspecialchars($product['price_3d2n_adult']) . '"
                data-price-3d2n-kid="' . htmlspecialchars($product['price_3d2n_kid']) . '"
                data-price-4d3n-adult="' . htmlspecialchars($product['price_4d3n_adult']) . '"
                data-price-4d3n-kid="' . htmlspecialchars($product['price_4d3n_kid']) . '"
                data-capacity="' . htmlspecialchars($product['capacity']) . '">
                <i class="fas fa-shopping-bag"></i> Add to Cart
            </a>';

                                    // View More button (link to details.php)
                                    echo '<a href="details.php?id=' . $product_id . '" class="btn btn-primary"> 
                <i class="fas fa-info-circle"></i> View More</a>';

                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo "<p>No products available for White Beach Hotel.</p>";
                            }
                            ?>

                        </div>
                    </div>

                    <!-- The Mang-Yan Grand Hotel Products -->
                    <div class="tab-pane fade" id="mangyan-grand" role="tabpanel" aria-labelledby="mangyan-grand-tab">
                        <div class="row">
                            <!-- Card Section for Map and Nearby Establishments -->
                            <div class="col-md-12">
                                <div class="card mb-3">
                                    <div class="row g-0">
                                        <!-- Map Section in Card -->
                                        <div class="col-md-4">
                                            <div class="map-container">
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3879.457793758186!2d120.9005349781175!3d13.50747386904491!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bcf9ebbc3a5b69%3A0xfffb4ea6b662f43d!2sThe%20Mang-Yan%20Grand%20Hotel%20by%20Cocotel!5e0!3m2!1sen!2sph!4v1727655618184!5m2!1sen!2sph" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                            </div>
                                        </div>

                                        <!-- Nearby Establishments Section in Card -->
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title">Nearby Establishments</h5>
                                                <p class="text-muted mt-3"><small>Marion Roos's Grill & Restobar - 170 m</small></p>
                                                <p class="text-muted mt-3"><small>Aqua Restobar - 190 m</small></p>
                                                <p class="text-muted mt-3"><small>Polycare Pharmacy - 400 m</small></p>
                                                <p class="text-muted mt-3"><small>Itim Tattoo Shop - 250 m</small></p>
                                                <p class="text-muted mt-3"><small>San Isidro Chapel Catholic Church - 650 m</small></p>
                                                <p class="text-muted mt-3"><small>Iglesia Ni Cristo Lokal ng White Beach- 700 m</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            $result_mangyan_grand = fetchHotels($conn, 'The Mang-Yan Grand Hotel');
                            if ($result_mangyan_grand && $result_mangyan_grand->num_rows > 0) {
                                while ($product = $result_mangyan_grand->fetch_assoc()) {
                                    $product_id = $product['id'];
                                    // Convert check-in and check-out time to AM/PM format
                                    $check_in_12hr = DateTime::createFromFormat('H:i:s', $product['check_in'])->format('h:i A');
                                    $check_out_12hr = DateTime::createFromFormat('H:i:s', $product['check_out'])->format('h:i A');

                                    echo '<div class="col-md-4 mb-4">';
                                    echo '<div class="card product-card">';
                                    echo '<img src="' . htmlspecialchars($product['thumbnail_image']) . '" class="card-img-top" alt="' . htmlspecialchars($product['name']) . '">';

                                    echo '<div class="card-body">';
                                    echo '<h5 class="card-title">' . htmlspecialchars($product['name']) . '</h5>';
                                    echo '<p class="card-text">' . htmlspecialchars($product['description']) . '</p>';
                                    // Display the converted times
                                    echo '<p><strong>Check-in Time:</strong> ' . $check_in_12hr . '</p>';
                                    echo '<p><strong>Check-out Time:</strong> ' . $check_out_12hr . '</p>';
                                    echo '<p><strong>Features:</strong><br><span class="features-list" data-features="' . htmlspecialchars($product['features']) . '"></span></p>';
                                    echo '<p><strong>Capacity:</strong> ' . htmlspecialchars($product['capacity']) . ' persons</p>';
                                    echo '<p><strong>Price starts at (Adult):</strong> ₱' . number_format($product['price_2d1n_adult'], 2) . '</p>';
                                    echo '<p><strong>Price starts at (Kid):</strong> ₱' . number_format($product['price_2d1n_kid'], 2) . '</p>';

                                    // Add to Cart button
                                    echo '<a href="#" class="btn btn-success add-to-cart me-2" 
                data-product-id="' . $product_id . '"
                data-product-name="' . htmlspecialchars($product['name']) . '"
                data-product-image="images/' . htmlspecialchars($product['thumbnail_image']) . '" 
                data-price-2d1n-adult="' . htmlspecialchars($product['price_2d1n_adult']) . '"
                data-price-2d1n-kid="' . htmlspecialchars($product['price_2d1n_kid']) . '"
                data-price-3d2n-adult="' . htmlspecialchars($product['price_3d2n_adult']) . '"
                data-price-3d2n-kid="' . htmlspecialchars($product['price_3d2n_kid']) . '"
                data-price-4d3n-adult="' . htmlspecialchars($product['price_4d3n_adult']) . '"
                data-price-4d3n-kid="' . htmlspecialchars($product['price_4d3n_kid']) . '"
                data-capacity="' . htmlspecialchars($product['capacity']) . '">
                <i class="fas fa-shopping-bag"></i> Add to Cart
            </a>';

                                    // View More button (link to details.php)
                                    echo '<a href="details.php?id=' . $product_id . '" class="btn btn-primary"> 
                <i class="fas fa-info-circle"></i> View More</a>';

                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo "<p>No products available for The Mang-Yan Grand Hotel.</p>";
                            }
                            ?>

                        </div>

                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="meals" role="tabpanel" aria-labelledby="meals-tab">
                <div class="row">
                    <?php
                    $result_meals = fetchMeals($conn);
                    if ($result_meals && $result_meals->num_rows > 0) {
                        while ($meal = $result_meals->fetch_assoc()) {
                            $meal_id = $meal['id'];
                            echo '<div class="col-md-4 mb-4">';
                            echo '<div class="card product-card h-100">';
                            echo '<img src="' . htmlspecialchars($meal['image_url']) . '" class="card-img-top meal-image" alt="' . htmlspecialchars($meal['name']) . '">';
                            echo '<div class="card-body d-flex flex-column">';
                            echo '<h5 class="card-title">' . htmlspecialchars($meal['name']) . '</h5>';
                            echo '<p class="card-text">' . htmlspecialchars($meal['description']) . '</p>';
                            echo '<p><strong>Price:</strong> ₱' . number_format($meal['price'], 2) . '</p>';


                            echo '<button class="btn btn-primary add-to-cart-meal" 
                        data-bs-toggle="modal" 
                        data-bs-target="#mealModal" 
                        data-meal-id="' . $meal_id . '" 
                        data-meal-name="' . htmlspecialchars($meal['name']) . '" 
                        data-meal-price="' . htmlspecialchars($meal['price']) . '" 
                        data-meal-image="' . htmlspecialchars($meal['image_url']) . '">
                        Add to Cart
                    </button>';

                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo "<p>No meals available at the moment.</p>";
                    }
                    ?>
                    <!-- Meal Add to Cart Modal -->
                    <div class="modal fade" id="mealModal" tabindex="-1" aria-labelledby="mealModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="mealModalLabel">Add Meal to Cart</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <img id="mealImage" src="" alt="" class="cart-item-image me-3">
                                        <div>
                                            <h5 id="mealName"></h5>
                                            <p><strong>Price:</strong> ₱<span id="mealPrice"></span></p>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="mealQuantity" class="form-label">Quantity:</label>
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary" type="button" id="minusMealQuantityModal">-</button>
                                            <input type="number" id="mealQuantityModal" class="form-control text-center" value="1" min="1">
                                            <button class="btn btn-outline-secondary" type="button" id="plusMealQuantityModal">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" id="confirmMealAddToCart" class="btn btn-primary">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="tab-pane fade" id="ferry" role="tabpanel" aria-labelledby="ferry-tab">
                <div class="row">
                    <?php
                    $result_ferries = fetchFerries($conn);

                    if ($result_ferries->num_rows > 0) {
                        while ($ferry = $result_ferries->fetch_assoc()) {
                            echo '<div class="col-md-4 mb-4">';
                            echo '<div class="card product-card">';
                            echo '<img src="' . htmlspecialchars($ferry['image_url']) . '" class="card-img-top" alt="' . htmlspecialchars($ferry['name']) . '">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . htmlspecialchars($ferry['name']) . '</h5>';
                            echo '<p class="card-text">' . htmlspecialchars($ferry['description']) . '</p>';
                            echo '<p><strong>Route:</strong> ' . htmlspecialchars($ferry['route']) . '</p>';
                            echo '<p><strong>Schedule:</strong> ' . htmlspecialchars($ferry['schedule']) . '</p>';
                            echo '<p><strong>Vessel:</strong> ' . htmlspecialchars($ferry['vessel']) . '</p>';

                            if ($ferry['vessel'] === 'Fast Craft') {
                                echo '<p><strong>Tourist Class:</strong><br>';
                                echo 'Adult: ₱' . (isset($ferry['tourist_adult_price']) ? htmlspecialchars($ferry['tourist_adult_price']) : 'Not available') . '<br>';
                                echo 'Senior/Student/PWD: ₱' . (isset($ferry['tourist_senior_price']) ? htmlspecialchars($ferry['tourist_senior_price']) : 'Not available') . '<br>';
                                echo 'Kid: ₱' . (isset($ferry['tourist_kid_price']) ? htmlspecialchars($ferry['tourist_kid_price']) : 'Not available') . '<br>';
                                echo 'Toddler: ₱' . (isset($ferry['tourist_toddler_price']) ? htmlspecialchars($ferry['tourist_toddler_price']) : 'Not available') . '</p>';

                                echo '<p><strong>Business Class:</strong><br>';
                                echo 'Adult: ₱' . (isset($ferry['business_adult_price']) ? htmlspecialchars($ferry['business_adult_price']) : 'Not available') . '<br>';
                                echo 'Senior/Student/PWD: ₱' . (isset($ferry['business_senior_price']) ? htmlspecialchars($ferry['business_senior_price']) : 'Not available') . '<br>';
                                echo 'Kid: ₱' . (isset($ferry['business_kid_price']) ? htmlspecialchars($ferry['business_kid_price']) : 'Not available') . '<br>';
                                echo 'Toddler: ₱' . (isset($ferry['business_toddler_price']) ? htmlspecialchars($ferry['business_toddler_price']) : 'Not available') . '</p>';
                            } elseif ($ferry['vessel'] === 'RORO') {
                                echo '<p><strong>Economy Class:</strong><br>';
                                echo 'Adult: ₱' . (isset($ferry['economy_adult_price']) ? htmlspecialchars($ferry['economy_adult_price']) : 'Not available') . '<br>';
                                echo 'Senior/Student/PWD: ₱' . (isset($ferry['economy_senior_price']) ? htmlspecialchars($ferry['economy_senior_price']) : 'Not available') . '<br>';
                                echo 'Kid: ₱' . (isset($ferry['economy_kid_price']) ? htmlspecialchars($ferry['economy_kid_price']) : 'Not available') . '<br>';
                                echo 'Toddler: ₱' . (isset($ferry['economy_toddler_price']) ? htmlspecialchars($ferry['economy_toddler_price']) : 'Not available') . '</p>';

                                echo '<p><strong>VIP Class:</strong><br>';
                                echo 'Adult: ₱' . (isset($ferry['vip_adult_price']) ? htmlspecialchars($ferry['vip_adult_price']) : 'Not available') . '<br>';
                                echo 'Senior/Student/PWD: ₱' . (isset($ferry['vip_senior_price']) ? htmlspecialchars($ferry['vip_senior_price']) : 'Not available') . '<br>';
                                echo 'Kid: ₱' . (isset($ferry['vip_kid_price']) ? htmlspecialchars($ferry['vip_kid_price']) : 'Not available') . '<br>';
                                echo 'Toddler: ₱' . (isset($ferry['vip_toddler_price']) ? htmlspecialchars($ferry['vip_toddler_price']) : 'Not available') . '</p>';
                            }


                            $prices = [];
                            if ($ferry['vessel'] === 'Fast Craft') {
                                $prices = [
                                    'tourist' => [
                                        'adult' => $ferry['tourist_adult_price'],
                                        'senior' => $ferry['tourist_senior_price'],
                                        'kid' => $ferry['tourist_kid_price'],
                                        'toddler' => $ferry['tourist_toddler_price']
                                    ],
                                    'business' => [
                                        'adult' => $ferry['business_adult_price'],
                                        'senior' => $ferry['business_senior_price'],
                                        'kid' => $ferry['business_kid_price'],
                                        'toddler' => $ferry['business_toddler_price']
                                    ]
                                ];
                            } elseif ($ferry['vessel'] === 'RORO') {
                                $prices = [
                                    'economy' => [
                                        'adult' => $ferry['economy_adult_price'],
                                        'senior' => $ferry['economy_senior_price'],
                                        'kid' => $ferry['economy_kid_price'],
                                        'toddler' => $ferry['economy_toddler_price']
                                    ],
                                    'vip' => [
                                        'adult' => $ferry['vip_adult_price'],
                                        'senior' => $ferry['vip_senior_price'],
                                        'kid' => $ferry['vip_kid_price'],
                                        'toddler' => $ferry['vip_toddler_price']
                                    ]
                                ];
                            }

                            echo '<button class="btn btn-primary" 
                data-bs-toggle="modal" 
                data-bs-target="#addToCartModal"
                data-ferry-schedule="' . htmlspecialchars($ferry['schedule']) . '" 
                data-ferry-vessel="' . htmlspecialchars($ferry['vessel']) . '" 
                data-prices=\'' . json_encode($prices) . '\'>Add to Cart</button>';



                            echo '</div>'; // end card-body
                            echo '</div>'; // end card
                            echo '</div>'; // end col-md-4
                        }
                    } else {
                        echo "<p>No ferry tickets available.</p>";
                    }
                    ?>
                    <!-- Add to Cart Modal -->
                    <div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addToCartLabel">Add Ferry Ticket to Cart</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Date Selector -->
                                    <div class="mb-3">
                                        <label for="ferryDate" class="form-label">Select Date</label>
                                        <input type="date" class="form-control" id="ferryDate" required>
                                    </div>

                                    <!-- Schedule Selector -->
                                    <div class="mb-3">
                                        <label for="ferrySchedule" class="form-label">Select Schedule</label>
                                        <select class="form-select" id="ferrySchedule" required>
                                            <option selected>Select Schedule</option>
                                        </select>
                                    </div>

                                    <!-- Class Selector -->
                                    <div class="mb-3">
                                        <label for="ferryClass" class="form-label">Select Class</label>
                                        <select class="form-select" id="ferryClass" required>
                                            <option selected>Select Class</option>
                                        </select>
                                    </div>

                                    <!-- Quantity Selectors with Prices -->
                                    <div class="mb-3">
                                        <label class="form-label">Select Quantity</label>
                                        <!-- Adult Section -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <label class="form-label">Number of Adults:</label>
                                            <p id="adultPrice" class="text-success mb-0">₱0.00 per adult</p>
                                        </div>
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary" type="button" id="minusAdultQuantity">-</button>
                                            <input type="number" id="adultQuantity" class="form-control text-center" value="1" min="0">
                                            <button class="btn btn-outline-secondary" type="button" id="plusAdultQuantity">+</button>
                                        </div>

                                        <!-- Senior/Student/PWD Section -->
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <label class="form-label">Number of Seniors/Students/PWD:</label>
                                            <p id="seniorPrice" class="text-success mb-0">₱0.00 per person</p>
                                        </div>
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary" type="button" id="minusSeniorQuantity">-</button>
                                            <input type="number" id="seniorQuantity" class="form-control text-center" value="0" min="0">
                                            <button class="btn btn-outline-secondary" type="button" id="plusSeniorQuantity">+</button>
                                        </div>

                                        <!-- Kid Section -->
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <label class="form-label">Number of Kids:</label>
                                            <p id="kidPrice" class="text-success mb-0">₱0.00 per kid</p>
                                        </div>
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary" type="button" id="minusKidQuantity">-</button>
                                            <input type="number" id="kidQuantity" class="form-control text-center" value="0" min="0">
                                            <button class="btn btn-outline-secondary" type="button" id="plusKidQuantity">+</button>
                                        </div>

                                        <!-- Toddler Section -->
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <label class="form-label">Number of Toddlers:</label>
                                            <p id="toddlerPrice" class="text-success mb-0">₱0.00 per toddler</p>
                                        </div>
                                        <div class="input-group">
                                            <button class="btn btn-outline-secondary" type="button" id="minusToddlerQuantity">-</button>
                                            <input type="number" id="toddlerQuantity" class="form-control text-center" value="0" min="0">
                                            <button class="btn btn-outline-secondary" type="button" id="plusToddlerQuantity">+</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="addToCartBtn">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Tours Tab Content -->

            <div class="tab-pane fade" id="tours" role="tabpanel" aria-labelledby="tours-tab">
                <div class="row">
                    <?php if ($result->num_rows > 0) {
                        while ($tour = $result->fetch_assoc()) { ?>
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <!-- Tour thumbnail -->
                                    <img src="<?php echo htmlspecialchars($tour['thumbnail_image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($tour['tour_type']); ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($tour['tour_type']); ?></h5>
                                        <p class="card-text"><strong>Duration:</strong> <?php echo htmlspecialchars($tour['duration']); ?></p>
                                        <p class="card-text"><strong>Description:</strong> <?php echo htmlspecialchars($tour['description']); ?></p>
                                        <p class="card-text"><strong>Price (Adult):</strong> ₱<?php echo number_format($tour['price_adult'], 2); ?></p>
                                        <p class="card-text"><strong>Price (Kid):</strong> ₱<?php echo number_format($tour['price_kid'], 2); ?></p>
                                        <!-- Add to Cart Button -->
                                        <button class="btn btn-success addToCartBtn" data-bs-toggle="modal" data-bs-target="#addToCartModal<?php echo $tour['id']; ?>" data-tour-id="<?php echo $tour['id']; ?>" data-tour-name="<?php echo htmlspecialchars($tour['tour_type']); ?>" data-price-adult="<?php echo $tour['price_adult']; ?>" data-price-kid="<?php echo $tour['price_kid']; ?>">
                                            Add to Cart
                                        </button>
                                        <!-- View More Button -->
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tourModal<?php echo $tour['id']; ?>">View More</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal for Additional Tour Details -->
                            <div class="modal fade" id="tourModal<?php echo $tour['id']; ?>" tabindex="-1" aria-labelledby="tourModalLabel<?php echo $tour['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="tourModalLabel<?php echo $tour['id']; ?>"><?php echo htmlspecialchars($tour['tour_type']); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Inclusions:</strong> <?php echo htmlspecialchars($tour['inclusion']); ?></p>
                                            <p><strong>Exclusions:</strong> <?php echo htmlspecialchars($tour['exclusion']); ?></p>
                                            <p><strong>Itinerary:</strong> <?php echo htmlspecialchars($tour['itinerary']); ?></p>
                                            <p><strong>Gallery:</strong></p>
                                            <!-- Bootstrap Carousel for Gallery -->
                                            <div id="carousel<?php echo $tour['id']; ?>" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    <?php
                                                    $galleryImages = explode(',', $tour['gallery_images']);
                                                    foreach ($galleryImages as $index => $image) {
                                                        $activeClass = $index === 0 ? 'active' : '';
                                                        echo '<div class="carousel-item ' . $activeClass . '">';
                                                        echo '<img src="' . htmlspecialchars($image) . '" class="d-block w-100" alt="Tour Image ' . ($index + 1) . '">';
                                                        echo '</div>';
                                                    } ?>
                                                </div>
                                                <!-- Carousel controls -->
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?php echo $tour['id']; ?>" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carousel<?php echo $tour['id']; ?>" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Add to Cart Modal -->
                            <div class="modal fade" id="addToCartModal<?php echo $tour['id']; ?>" tabindex="-1" aria-labelledby="addToCartLabel<?php echo $tour['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addToCartLabel<?php echo $tour['id']; ?>">Add Tour to Cart</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Tour:</strong> <span id="tourName<?php echo $tour['id']; ?>"></span></p>
                                            <p><strong>Price per Adult:</strong> ₱<span id="adultPrice<?php echo $tour['id']; ?>"></span></p>
                                            <p><strong>Price per Kid:</strong> ₱<span id="kidPrice<?php echo $tour['id']; ?>"></span></p>
                                            <label for="adultsCount<?php echo $tour['id']; ?>" class="form-label">Number of Adults:</label>
                                            <div class="input-group mb-3">
                                                <button class="btn btn-outline-secondary minus" type="button">-</button>
                                                <input type="number" id="adultsCount<?php echo $tour['id']; ?>" class="form-control text-center" value="1" min="1">
                                                <button class="btn btn-outline-secondary plus" type="button">+</button>
                                            </div>
                                            <label for="kidsCount<?php echo $tour['id']; ?>" class="form-label">Number of Kids:</label>
                                            <div class="input-group mb-3">
                                                <button class="btn btn-outline-secondary minus" type="button">-</button>
                                                <input type="number" id="kidsCount<?php echo $tour['id']; ?>" class="form-control text-center" value="0" min="0">
                                                <button class="btn btn-outline-secondary plus" type="button">+</button>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary confirmAddToCart" data-tour-id="<?php echo $tour['id']; ?>">Add to Cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php }
                    } else {
                        echo '<p>No tours available.</p>';
                    } ?>
                </div>
            </div>
            <!-- Summary Modal -->
            <div class="modal fade" id="summaryModal" tabindex="-1" aria-labelledby="summaryModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="summaryModalLabel">Order Summary</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="accountDetails">

                                <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

                                <!-- Hidden fields for passing data to JavaScript -->
                                <input type="hidden" id="hiddenUsername" value="<?php echo htmlspecialchars($user['username']); ?>">
                                <input type="hidden" id="hiddenEmail" value="<?php echo htmlspecialchars($user['email']); ?>">


                                <form id="contactForm">
                                    <div class="mb-3">
                                        <label for="contactNumber" class="form-label"><strong>Please provide a contact number:</strong></label>
                                        <input type="tel" class="form-control" id="contactNumber" placeholder="Enter your contact number" required>
                                    </div>
                                </form>
                            </div>
                            <div id="summaryModalContent">
                                <!-- The cart summary will be here -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div id="totalPriceSummary" class="me-auto"><strong>Total Amount: ₱0.00</strong></div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" class="btn btn-primary" id="confirmBookingBtn">Confirm Booking</button> -->
                             <button type="button" class="btn btn-primary" id="payNowButton" data-bs-toggle="modal" data-bs-target="#paymentModal">Pay Now</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Payment Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="paymentForm" action="your_payment_processor.php" method="POST">
                    <!-- Payment Method Selection -->
                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label"><strong>Select Payment Method:</strong></label>
                        <div class="d-flex">
                            <!-- Credit Card Option -->
                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" value="creditCard" checked>
                                <label class="form-check-label" for="creditCard">
                                    <i class="fas fa-credit-card" style="font-size: 1.5em;"></i> Credit Card
                                </label>
                            </div>
                            <!-- GCash Option -->
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="gcash" value="gcash">
                                <label class="form-check-label" for="gcash">
                                    <img src="images/gcashlogo.png" alt="GCash" style="width: 40px;"> GCash
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Credit Card Payment Fields -->
                    <div id="creditCardFields">
                        <div class="mb-3">
                            <label for="cardNumber" class="form-label"><strong>Card Number</strong></label>
                            <input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="Enter your card number" required>
                        </div>
                        <div class="mb-3">
                            <label for="expiryDate" class="form-label"><strong>Expiry Date</strong></label>
                            <input type="text" class="form-control" id="expiryDate" name="expiryDate" placeholder="MM/YY" required>
                        </div>
                        <div class="mb-3">
                            <label for="cvv" class="form-label"><strong>CVV</strong></label>
                            <input type="text" class="form-control" id="cvv" name="cvv" placeholder="Enter CVV" required>
                        </div>
                    </div>

                    <div id="gcashFields" style="display: none;">
                        <div class="mb-3">
                            <label for="gcashNumber" class="form-label"><strong>GCash Mobile Number</strong></label>
                            <input type="text" class="form-control" id="gcashNumber" name="gcashNumber" placeholder="Enter your GCash number" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label"><strong>Amount</strong></label>
                        <input type="text" class="form-control" id="amount" name="amount" value="₱0.00" readonly>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="paymentForm" class="btn btn-primary" id="confirmBookingBtn">Submit Payment</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to Handle Payment Method Switching -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const creditCardRadio = document.getElementById('creditCard');
        const gcashRadio = document.getElementById('gcash');
        const creditCardFields = document.getElementById('creditCardFields');
        const gcashFields = document.getElementById('gcashFields');

        // Show/Hide fields based on selected payment method
        creditCardRadio.addEventListener('change', function () {
            if (this.checked) {
                creditCardFields.style.display = 'block';
                gcashFields.style.display = 'none';
            }
        });

        gcashRadio.addEventListener('change', function () {
            if (this.checked) {
                creditCardFields.style.display = 'none';
                gcashFields.style.display = 'block';
            }
        });
    });
</script>

        </div>
    </div>
    </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="dashboard.js"> </script>

    <footer class="bg-dark text-white text-center py-2">
        <div class="container">
            <p>&copy; 2024 Matt Travel and Tours. All rights reserved.</p>

            <!-- DOT Accreditation -->
            <p>DOT Accredited. Accreditation No: <strong>DOT-R4B-TOP-00558-2022</strong></p>

            <!-- Additional Contact Information -->
            <p>Email: <a href="mailto:info.pgph@gmail.com" class="text-white">info.pgph@gmail.com</a> | Phone: <a href="tel:+639123456789" class="text-white">+63 912 345 6789</a></p>

            <!-- Operating Hours -->
            <p>Operating Hours: Mon - Sun, 8:00 AM - 12:00 AM</p>

            <!-- Social Media Icons -->
            <div class="social-icons">
                <a href="https://web.facebook.com/PuertoGaleraAdventures/" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
            </div>

            <!-- Legal Links -->
            <div class="mt-3">
                <a href="/terms" class="text-white me-3">Terms & Conditions</a>
                <a href="/privacy-policy" class="text-white">Privacy Policy</a>
            </div>
        </div>
    </footer>

</body>

</html>

<?php
$conn->close();
?>