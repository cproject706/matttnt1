<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Fields from the form
    $name = $_POST['name'];
    $tour_type = $_POST['tour_type'];
    $price_adult = $_POST['price_adult'];
    $price_kid = $_POST['price_kid'];
    $duration = $_POST['duration'];
    $itinerary = $_POST['itinerary'];
    $inclusion = $_POST['inclusion'];
    $description = $_POST['description'];

    // Handle thumbnail image
    if (isset($_FILES['thumbnail_image']) && $_FILES['thumbnail_image']['error'] === 0) {
        $thumbnail = $_FILES['thumbnail_image'];
        $thumbnailName = time() . '_thumbnail_' . $thumbnail['name'];
        move_uploaded_file($thumbnail['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . 'images/' . $thumbnailName);
        $thumbnailPath = 'images/' . $thumbnailName;
    } else {
        $thumbnailPath = null; 
    }

    // SQL query to insert data into the 'tours' table
    $sql = "INSERT INTO tours (name, tour_type, price_adult, price_kid, duration, itinerary, inclusion, description, thumbnail_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssssss', $name, $tour_type, $price_adult, $price_kid, $duration, $itinerary, $inclusion, $description, $thumbnailPath);

    // Execute the query and handle success or failure
    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?section=tours");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
