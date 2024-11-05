<?php
include 'db_connection.php';

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the data from the POST request
    $hotel_id = $_POST['id'];
    $hotel_name = $_POST['hotel_name'];
    $price_adult = $_POST['price_adult'];
    $price_kid = $_POST['price_kid'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $features = isset($_POST['features']) ? implode(', ', $_POST['features']) : '';
    $capacity = $_POST['capacity'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $inclusions = $_POST['inclusions'];
    $exclusions = $_POST['exclusions'];
    $policy = $_POST['policy'];
    $fully_booked_dates = $_POST['fully_booked_dates'];


    $sql = "UPDATE hotels SET name=?, price_adult=?, price_kid=?, check_in=?, check_out=?, features=?, capacity=?, description=?, image_url=?, inclusions=?, exclusions=?, policy=?, fully_booked_dates=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sddssssssssssi', $hotel_name, $price_adult, $price_kid, $check_in, $check_out, $features, $capacity, $description, $image_url, $inclusions, $exclusions, $policy, $fully_booked_dates, $hotel_id);

    if ($stmt->execute()) {
        $response['success'] = true; 
    } else {
        $response['error'] = $conn->error; 
    }
}

echo json_encode($response); 
?>
