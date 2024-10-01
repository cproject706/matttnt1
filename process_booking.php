<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "matttnt";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the POST data
$user_username = $_POST['username'];
$user_email = $_POST['email'];
$contact_number = $_POST['contact_number'];
$cartSummary = json_decode($_POST['cartSummary'], true);
foreach ($cartSummary as $item) {
    $product_name = $item['productName'];
    $check_in_date = isset($item['checkInDate']) ? $item['checkInDate'] : NULL;
    $check_out_date = isset($item['checkOutDate']) ? $item['checkOutDate'] : NULL;
    $nights = isset($item['nights']) ? $item['nights'] : NULL;
    $rooms = isset($item['rooms']) ? $item['rooms'] : NULL;
    $adults = isset($item['adults']) ? $item['adults'] : NULL;
    $kids = isset($item['kids']) ? $item['kids'] : NULL;
    $total_price = $item['totalPrice'];

    $stmt = $conn->prepare("INSERT INTO bookings (username, email, contact_number, product_name, check_in_date, check_out_date, nights, rooms, adults, kids, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssiiiid", $user_username, $user_email, $contact_number, $product_name, $check_in_date, $check_out_date, $nights, $rooms, $adults, $kids, $total_price);
    $stmt->execute();
}

// Close the connection
$conn->close();

// Return a success message
echo json_encode(['status' => 'success', 'message' => 'Booking confirmed successfully!']);