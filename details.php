

<?php
// Include database connection
include 'db_connection.php';


if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    
    $query = "SELECT * FROM hotels WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

     
        echo '<div class="content-container">';

    
        echo '<a href="dashboard.php" class="return-btn"><i class="fas fa-arrow-left"></i> Return to Home Page</a>';

        // Display the hotel name
        echo '<h1>' . htmlspecialchars($product['name']) . '</h1>';

        // Display the Gallery Grid
        echo '<div class="section">';
        echo '<h3>Gallery:</h3>';
        echo '<div class="gallery-grid">';

        // Loop through gallery images
        $galleryImages = explode(',', $product['gallery_images']);
        foreach ($galleryImages as $index => $image) {
            echo '<div class="gallery-item">';
            echo '<img src="' . htmlspecialchars($image) . '" alt="Gallery Image ' . ($index + 1) . '" data-bs-toggle="modal" data-bs-target="#galleryModal" onclick="setModalImage(this.src)">';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>'; // End Gallery section

        // Display Inclusions
        echo '<div class="section">';
        echo '<h3>Inclusions:</h3>';
        echo '<ul class="list-section" id="content">';
        $inclusions = explode("\n", htmlspecialchars($product['inclusions']));
        foreach ($inclusions as $inclusion) {
            echo '<li>' . $inclusion . '</li>';
        }
        echo '</ul>';
        echo '</div>';

        // Display Exclusions
        echo '<div class="section">';
        echo '<h3>Exclusions:</h3>';
        echo '<ul class="list-section">';
        $exclusions = explode("\n", htmlspecialchars($product['exclusions']));
        foreach ($exclusions as $exclusion) {
            echo '<li>' . $exclusion . '</li>';
        }
        echo '</ul>';
        echo '</div>';

        // Display Policy
        echo '<div class="section">';
        echo '<h3>Policy:</h3>';
        echo '<ul class="list-section" id="policyText">';
        $policies = explode("\n", htmlspecialchars($product['policy']));
        foreach ($policies as $policy) {
            echo '<li>' . $policy . '</li>';
        }
        echo '</ul>';
        echo '</div>';

        echo '</div>'; // End content container

    } else {
        echo '<p class="text-danger">Hotel not found.</p>';
    }
} else {
    echo '<p class="text-danger">No hotel ID provided.</p>';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Details</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="styles2.css">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            padding: 20px;
        }

        h1 {
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        #navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

     
        .content-container {
            max-width: 1200px;
            margin: 100px auto 0; 
            padding: 0 15px;
        }

        .return-btn {
            display: inline-block;
            margin-bottom: 20px;
            font-size: 1rem;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .return-btn:hover {
            background-color: #2980b9;
        }

        /* Masonry-style gallery grid */
        .gallery-grid {
            column-count: 3;
            column-gap: 15px;
        }

        .gallery-grid img {
            width: 100%;
            margin-bottom: 15px;
            border-radius: 10px;
            display: block;
            object-fit: cover;
            max-height: 250px;
            cursor: pointer;
            transition: transform 0.3s ease, opacity 0.3s ease-in-out;
        }

        .gallery-grid img:hover {
            transform: scale(1.05);
            opacity: 0.8;
        }

        .section {
            margin-bottom: 40px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            animation: fadeInUp 0.6s ease both;
        }

        .section h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }

        .list-section {
            list-style: none;
            padding: 0;
        }

        .list-section li {
            font-size: 1rem;
            color: #555;
            line-height: 1.8;
            margin-bottom: 10px;
        }

    
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-body img {
            width: 100%;
            border-radius: 10px;
        }


        @media (max-width: 768px) {
            .gallery-grid {
                column-count: 2;
            }
        }

        @media (max-width: 576px) {
            .gallery-grid {
                column-count: 1;
            }
        }
    </style>
</head>
<body>

<!-- Navbar Section -->
<nav class="navbar navbar-expand-lg bg-light shadow" id="navbar">
    <div class="container-fluid d-flex align-items-center">
        <!-- Logo and Text -->
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="images/mattlogo.jpg" alt="Matt Travel Logo" class="img-fluid me-2" style="height: 50px;">
            <span>Matt Destinations Travel and Tours</span>
        </a>
        <!-- Toggler for small screens -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Shopping Cart link -->
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCart" aria-controls="offcanvasCart">
                        <i class="fas fa-shopping-cart"></i> Shopping Cart
                    </a>
                </li>
                <!-- Profile Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user"></i> Profile
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#accountDetailsModal"><i class="fas fa-id-badge"></i> Account Details</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#bookingsModal"><i class="fas fa-calendar-alt"></i> My Bookings</a></li>
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#reviewsModal"><i class="fas fa-star"></i> My Reviews</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>


<!-- Modal for viewing full-size images -->
<div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body text-center">
        <img src="" alt="Gallery Image" class="modal-img" id="modalImage">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>

    function setModalImage(src) {
        document.getElementById('modalImage').src = src;
    }

    // Trigger fade-in animations on scroll
    window.addEventListener('scroll', function() {
        const elements = document.querySelectorAll('.section');
        const windowHeight = window.innerHeight;

        elements.forEach(el => {
            const elementTop = el.getBoundingClientRect().top;
            if (elementTop < windowHeight - 100) {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }
        });
    });


    // Select the content
    const contentDiv = document.getElementById('content');
        // Replace the specific words with bolded versions
        contentDiv.innerHTML = contentDiv.innerHTML
            .replace('Includes:', '<b>Includes:</b>')
            .replace('You’ll see:', '<b>You’ll see:</b>');


    // Define the keywords to make bold
    const keywords = [
            "20% Down Payment:",
            "Balance Payment:",
            "Non-Refundable Deposits:",
            "Rebooking:",
            "Cancellation Notice:",
            "Port Terminal Fee and Environmental Fee:",
            "Assistance with Travel Arrangements:",
            "Common Kitchen:"
        ];

        // Get the content element
        const content = document.getElementById('policyText').innerHTML;

        // Replace each keyword with bolded version
        let formattedContent = content;
        keywords.forEach(keyword => {
            const regex = new RegExp(`(${keyword})`, 'g');
            formattedContent = formattedContent.replace(regex, '<strong>$1</strong>');
        });

        // Update the element with formatted content
        document.getElementById('policyText').innerHTML = formattedContent;

</script>

</body>
</html>
