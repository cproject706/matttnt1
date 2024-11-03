<?php
session_start(); 

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    
  
    $username = $user['username'];
    $email = $user['email'];

    die('User not found');
}

include 'db_connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$input = json_decode(file_get_contents('php://input'), true);

$username = $conn->real_escape_string($input['username']);
$email = $conn->real_escape_string($input['email']);
$contactNumber = $conn->real_escape_string($input['contactNumber']);
$totalAmount = $conn->real_escape_string($input['totalAmount']);

// Insert into database
$sql = "INSERT INTO bookings (username, email, contact_number, total_price) VALUES ('$username', '$email', '$contactNumber', '$totalAmount')";

if ($conn->query($sql) === TRUE) {

    
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
}

$conn->close();
?>
