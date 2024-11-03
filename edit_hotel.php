<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form inputs
    $hotel_id = $_POST['id'];
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

    // Handle check-in and check-out time to be in AM/PM format
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];

    // Convert check-in and check-out times to AM/PM format
    $check_in_time = DateTime::createFromFormat('H:i', $check_in)->format('h:i A');
    $check_out_time = DateTime::createFromFormat('H:i', $check_out)->format('h:i A');

    // Handle Thumbnail Upload
    if (isset($_FILES['thumbnail_image']) && $_FILES['thumbnail_image']['error'] === 0) {
        $thumbnail = $_FILES['thumbnail_image'];
        $thumbnailName = time() . '_thumbnail_' . $thumbnail['name'];
        if (move_uploaded_file($thumbnail['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/matttnt/images/' . $thumbnailName)) {
            $thumbnailPath = 'images/' . $thumbnailName;
        } else {
            echo json_encode(['success' => false, 'error' => 'Failed to upload the thumbnail image.']);
            exit();
        }
    } else {
        $thumbnailPath = null;
    }

    $galleryPaths = [];

    // Handle Gallery Images Upload
    if (isset($_FILES['gallery_images'])) {
        foreach ($_FILES['gallery_images']['tmp_name'] as $key => $tmpName) {
            if ($_FILES['gallery_images']['error'][$key] === 0) {
                $galleryName = time() . '_' . $key . '_' . $_FILES['gallery_images']['name'][$key];
                $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/matttnt/images/' . $galleryName;

                if (move_uploaded_file($tmpName, $targetPath)) {
                    $galleryPaths[] = 'images/' . $galleryName;
                } else {
                    echo json_encode(['success' => false, 'error' => "Failed to upload gallery image: " . $_FILES['gallery_images']['name'][$key]]);
                    exit();
                }
            } else {
                echo json_encode(['success' => false, 'error' => "Error with file upload for gallery image: " . $_FILES['gallery_images']['name'][$key] . " - Error code: " . $_FILES['gallery_images']['error'][$key]]);
                exit();
            }
        }
    }

    $galleryImagesString = implode(',', $galleryPaths);

    // Update hotel information
    $sql = "UPDATE hotels SET 
                name=?, 
                check_in=?, 
                check_out=?, 
                features=?, 
                capacity=?, 
                description=?, 
                inclusions=?, 
                exclusions=?, 
                policy=?, 
                price_2d1n_adult=?, 
                price_2d1n_kid=?, 
                price_3d2n_adult=?, 
                price_3d2n_kid=?, 
                price_4d3n_adult=?, 
                price_4d3n_kid=?, 
                thumbnail_image=?, 
                gallery_images=? 
            WHERE id=?";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param(
        "ssssssssddddssssi",
        $name,
        $check_in_time,
        $check_out_time,
        $features,
        $capacity,
        $description,
        $inclusions,
        $exclusions,
        $policy,
        $price_2d1n_adult,
        $price_2d1n_kid,
        $price_3d2n_adult,
        $price_3d2n_kid,
        $price_4d3n_adult,
        $price_4d3n_kid,
        $thumbnailPath,
        $galleryImagesString,
        $hotel_id
    );

    if ($stmt->execute()) {
        // Handle fully booked dates
        $conn->query("DELETE FROM fully_booked_dates WHERE hotel_id = $hotel_id");

        $selectedDates = isset($_POST['fully_booked_dates']) ? explode(',', $_POST['fully_booked_dates']) : [];
        foreach ($selectedDates as $date) {
            $date = $conn->real_escape_string($date);
            $conn->query("INSERT INTO fully_booked_dates (hotel_id, fully_booked_date) VALUES ($hotel_id, '$date')");
        }

        echo json_encode(['success' => true]);
        exit();
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
}
?>
