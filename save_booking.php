<?php

// Include the database connection file
include 'db_connection.php';

// Retrieve data from the POST request
$username = $_POST['username'];
$email = $_POST['email'];
$contactNumber = $_POST['contactNumber'];
$totalAmount = $_POST['totalAmount'];
$downPayment = $totalAmount * 0.20;
$balance = $totalAmount - $downPayment;

// Insert booking into the newbookings table
$insertBookingQuery = "INSERT INTO newbookings (username, email, contact_number, total_amount, down_payment, balance) 
                       VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $connection->prepare($insertBookingQuery);
$stmt->bind_param("sssddd", $username, $email, $contactNumber, $totalAmount, $downPayment, $balance);

if ($stmt->execute()) {
    $bookingId = $connection->insert_id; // Get the inserted booking ID

    // Insert each item from the cart summary into the CartItems table
    $insertCartItemQuery = "INSERT INTO CartItems (booking_id, product_name, check_in_date, check_out_date, nights, rooms, adults, kids, quantity, date, schedule, seniors, total_price) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtCart = $connection->prepare($insertCartItemQuery);

    foreach ($_POST['cartSummary'] as $item) {
        // Extract item details
        $productName = $item['productName'];
        $checkInDate = $item['checkInDate'] ?? NULL;
        $checkOutDate = $item['checkOutDate'] ?? NULL;
        $nights = $item['nights'] ?? NULL;
        $rooms = $item['rooms'] ?? NULL;
        $adults = $item['adults'] ?? NULL;
        $kids = $item['kids'] ?? NULL;
        $quantity = $item['quantity'] ?? NULL;
        $date = $item['date'] ?? NULL;
        $schedule = $item['schedule'] ?? NULL;
        $seniors = $item['seniors'] ?? NULL;
        $totalPrice = $item['totalPrice'];

        // Bind parameters for the cart item query
        $stmtCart->bind_param("isssiiiiiisdi", $bookingId, $productName, $checkInDate, $checkOutDate, $nights, $rooms, $adults, $kids, $quantity, $date, $schedule, $seniors, $totalPrice);
        $stmtCart->execute();
    }

    echo "Booking and cart items saved successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close the prepared statements and connection
$stmt->close();
$stmtCart->close();
$connection->close();
?>
