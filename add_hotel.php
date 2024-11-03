    <?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: index.php");
        exit();
    }

    include 'db_connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form inputs
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
                echo "Failed to upload the thumbnail image.";
                $thumbnailPath = null;
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
                        echo "Failed to upload gallery image: " . $_FILES['gallery_images']['name'][$key];
                    }
                } else {
                    echo "Error with file upload for gallery image: " . $_FILES['gallery_images']['name'][$key] . " - Error code: " . $_FILES['gallery_images']['error'][$key];
                }
            }
        }

        
        $galleryImagesString = implode(',', $galleryPaths);

       
        $sql = "INSERT INTO hotels 
                (name, check_in, check_out, features, capacity, description, inclusions, exclusions, policy, fully_booked_dates, price_2d1n_adult, price_2d1n_kid, price_3d2n_adult, price_3d2n_kid, price_4d3n_adult, price_4d3n_kid, thumbnail_image, gallery_images) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        $fully_booked_dates = ''; 

        $stmt->bind_param(
            "ssssssssssssddddss",
            $name,
            $check_in,
            $check_out,
            $features,
            $capacity,
            $description,
            $inclusions,
            $exclusions,
            $policy,
            $fully_booked_dates,
            $price_2d1n_adult,
            $price_2d1n_kid,
            $price_3d2n_adult,
            $price_3d2n_kid,
            $price_4d3n_adult,
            $price_4d3n_kid,
            $thumbnailPath,
            $galleryImagesString
        );

       
        if ($stmt->execute()) {
            header("Location: admin_dashboard.php"); 
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
    ?>
