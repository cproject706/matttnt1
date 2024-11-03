<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['meal_name'], $_POST['price'], $_POST['description'], $_FILES['image'])) {
        $meal_name = trim($_POST['meal_name']);
        $price = floatval($_POST['price']);
        $description = trim($_POST['description']);

        // Handle image upload
        $image = $_FILES['image'];
        $image_name = basename($image['name']);
        $image_tmp = $image['tmp_name'];
        $upload_dir = 'images/';
        $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $valid_ext = ['jpg', 'jpeg', 'png', 'gif'];

        
        if (!in_array($image_ext, $valid_ext)) {
            echo "Invalid file format. Only JPG, JPEG, PNG, and GIF are allowed.";
            exit();
        }

        $image_new_name = uniqid('', true) . '.' . $image_ext;
        $image_path = $upload_dir . $image_new_name;

        
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        
        $stmt = $conn->prepare("INSERT INTO meals (name, price, description, image_url) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdss", $meal_name, $price, $description, $image_path);

        if ($stmt->execute()) {
            
            if (move_uploaded_file($image_tmp, $image_path)) {
                header("Location: admin_dashboard.php?success=1");  
            } else {
                echo "Error uploading image.";
            }
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required.";
    }
}
$conn->close();
?>
