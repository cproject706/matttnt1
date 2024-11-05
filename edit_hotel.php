<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form inputs
    $hotel_id = $_POST['hotel_id'];  
    $name = $_POST['hotel_name'];
    $price_2d1n_adult = $_POST['price_2d1n_adult'];
    $price_2d1n_kid = $_POST['price_2d1n_kid'];
    $price_3d2n_adult = $_POST['price_3d2n_adult'];
    $price_3d2n_kid = $_POST['price_3d2n_kid'];
    $price_4d3n_adult = $_POST['price_4d3n_adult'];
    $price_4d3n_kid = $_POST['price_4d3n_kid'];
    $capacity = $_POST['capacity'];
    $inclusions = $_POST['inclusions'];
    $exclusions = $_POST['exclusions'];
    $policy = $_POST['policy'];
    $description = $_POST['description'];
    $features = isset($_POST['features']) ? implode(', ', $_POST['features']) : '';

    // Convert check-in and check-out times to AM/PM format
    $check_in = DateTime::createFromFormat('H:i', $_POST['check_in'])->format('h:i A');
    $check_out = DateTime::createFromFormat('H:i', $_POST['check_out'])->format('h:i A');

    // Handle Thumbnail Upload
    $thumbnailPath = null;
    if (isset($_FILES['thumbnail_image']) && $_FILES['thumbnail_image']['error'] === 0) {
        $thumbnailName = time() . '_thumbnail_' . $_FILES['thumbnail_image']['name'];
        $thumbnailPath = 'images/' . $thumbnailName;
        if (!move_uploaded_file($_FILES['thumbnail_image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/matttnt/' . $thumbnailPath)) {
            echo "Failed to upload the thumbnail image.";
            $thumbnailPath = null;
        }
    }

    // Handle Gallery Images Upload
    $galleryPaths = [];
    if (isset($_FILES['gallery_images'])) {
        foreach ($_FILES['gallery_images']['tmp_name'] as $key => $tmpName) {
            if ($_FILES['gallery_images']['error'][$key] === 0) {
                $galleryName = time() . '_' . $key . '_' . $_FILES['gallery_images']['name'][$key];
                $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/matttnt/images/' . $galleryName;
                if (move_uploaded_file($tmpName, $targetPath)) {
                    $galleryPaths[] = 'images/' . $galleryName;
                } else {
                    echo "Failed to upload gallery image: " . $_FILES['gallery_images']['name'][$key];
                }
            }
        }
    }
    $galleryImagesString = implode(',', $galleryPaths);

    // Build SQL statement dynamically
    $sql = "UPDATE hotels SET 
            name = ?, 
            check_in = ?, 
            check_out = ?, 
            features = ?, 
            capacity = ?, 
            description = ?, 
            inclusions = ?, 
            exclusions = ?, 
            policy = ?, 
            price_2d1n_adult = ?, 
            price_2d1n_kid = ?, 
            price_3d2n_adult = ?, 
            price_3d2n_kid = ?, 
            price_4d3n_adult = ?, 
            price_4d3n_kid = ?";
    
 
    $params = [
        &$name, &$check_in, &$check_out, &$features, &$capacity,
        &$description, &$inclusions, &$exclusions, &$policy,
        &$price_2d1n_adult, &$price_2d1n_kid, &$price_3d2n_adult,
        &$price_3d2n_kid, &$price_4d3n_adult, &$price_4d3n_kid
    ];

    if ($thumbnailPath) {
        $sql .= ", thumbnail_image = ?";
        $params[] = &$thumbnailPath;
    }
    if (!empty($galleryPaths)) {
        $sql .= ", gallery_images = ?";
        $params[] = &$galleryImagesString;
    }

    $sql .= " WHERE id = ?";
    $params[] = &$hotel_id;

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Dynamically bind parameters
    $types = str_repeat('s', 8) . str_repeat('d', 7) . (isset($thumbnailPath) ? 's' : '') . (!empty($galleryPaths) ? 's' : '') . 'i';
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        
        if ($stmt->affected_rows > 0) {
            header("Location: admin_dashboard.php"); 
            exit();
        } else {
            echo "Update failed: No rows were affected. Please check the input data or hotel ID.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
