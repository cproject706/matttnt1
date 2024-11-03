<?php
include 'db_connection.php'; 

$search_term = $_GET['search'] ?? '';

$sql = "SELECT * FROM bookings WHERE username LIKE ? OR email LIKE ? OR status LIKE ?";
$stmt = $conn->prepare($sql);
$search_term = '%' . $search_term . '%';
$stmt->bind_param('sss', $search_term, $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];
while ($booking = $result->fetch_assoc()) {
    $bookings[] = $booking;
}

$response = [
    'results' => $bookings,
    'count' => count($bookings)
];

echo json_encode($response);
$conn->close();
?>
