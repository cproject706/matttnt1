    <?php
    session_start();
    include 'db_connection.php';

    $error_message = '';
    $success_message = '';
    $show_login_form = false;

    // Handle successful registration message
    if (isset($_GET['registration']) && $_GET['registration'] == 'success') {
        $success_message = 'Registration successful! Please log in.';
    }

    // Handle login form submission
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query to find user
        $sql = "SELECT * FROM users WHERE username='$username' OR email='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $row['username'];

                // Redirect based on role
                if ($row['role'] == 'admin') {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: dashboard.php");
                }
                exit();
            } else {
                $error_message = 'Invalid password!';
                $show_login_form = true; 
            }
        } else {
            $error_message = 'User not found!';
            $show_login_form = true; 
        }
    }

    $conn->close();
    ?>



    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Matt Destinations Travel and Tours</title>
        <link rel="icon" href="images/mattlogo.jpg" type="image/jpg">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Roboto:wght@400;500&display=swap" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Font Awesome for Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        
        <style>
            /* General Styling */
            body,
            html {
                font-family: 'Roboto', sans-serif;
                height: 100%;
                margin: 0;
                padding: 0;
                scroll-behavior: smooth;
            }

            /* Navbar Section */
            .navbar {
                position: absolute;
                top: 0;
                width: 100%;
                padding: 20px 50px;
                z-index: 10;
                background-color: #f8f9fa;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .navbar-brand img {
                width: 70px;
            }

            .navbar-nav .nav-link {
                color: #333 !important;
                font-size: 14px;
                font-weight: 500;
                margin-left: 20px;
                transition: color 0.3s ease;
            }

            .navbar-nav .nav-link:hover {
                color: #0056b3 !important;
            }

            .navbar-toggler {
                border: none;
                color: #333;
            }

            /* Adjusting the button styles */
            .navbar .btn-primary {
                background-color: #0056b3;
                border-color: #0056b3;
                color: white;
                transition: all 0.3s ease;
            }

            .navbar .btn-primary:hover {
                background-color: #004494;
                border-color: #004494;
            }

            .navbar .btn-outline-primary {
                color: #0056b3;
                border-color: #0056b3;
                transition: all 0.3s ease;
            }

            .navbar .btn-outline-primary:hover {
                background-color: #0056b3;
                color: white;
                border-color: #0056b3;
            }

           .hero {
                background: url('images/hero.png') no-repeat center center;
                background-size: cover;
                height: 100vh;
                display: flex;
                justify-content: flex-start;
                align-items: center;
                padding-left: 20px;
                color: white;
                text-align: left;
                position: relative;
                box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.4);
            }

            .hero h1 {
                font-size: 4rem;
                font-weight: 800;
                text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6);
                margin-bottom: 20px;
                margin-left: -10px;
            }

            .hero p {
                font-size: 1.5rem;
                margin-top: 10px;
                text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.9);
                margin-left: -10px;
            }

            .hero .btn {
                margin-top: 20px;
                font-size: 1.2rem;
                padding: 12px 25px;
                border-radius: 30px;
                transition: all 0.3s ease;
            }

            .hero .btn-primary {
                background-color: #0056b3;
                border-color: #0056b3;
                color: white;
            }

            .hero .btn-primary:hover {
                background-color: #004494;
            }

            .hero .btn-outline-primary {
                color: #0056b3;
                border-color: #0056b3;
            }

            .hero .btn-outline-primary:hover {
                background-color: #0056b3;
                color: white;
            }

            .hero .btn + .btn {
                margin-left: 15px; 
            }

            /* Why Choose Us Section */
            .why-choose-us {
                padding: 80px 0;
                background-color: #f7f7f7;
                text-align: center;
            }

            .why-choose-us h2 {
                margin-bottom: 40px;
                font-size: 2.5rem;
                font-weight: 700;
            }

            .why-choose-us .feature-box {
                padding: 20px;
                transition: all 0.3s ease;
            }

            .why-choose-us .feature-box:hover {
                transform: translateY(-10px);
            }

            .why-choose-us .feature-box i {
                color: #4ABDAC;
                margin-bottom: 15px;
                transition: color 0.3s ease;
            }

            .why-choose-us .feature-box:hover i {
                color: #037D77;
            }

            .why-choose-us h4 {
                font-size: 1.5rem;
                font-weight: 600;
            }

            /* Travel Destinations Section */
            .destinations {
                background-color: #f9f9f9;
                padding: 60px 0;
            }

            .destinations h2 {
                margin-bottom: 40px;
                text-align: center;
                font-size: 2.5rem;
                font-weight: 700;
            }

            .destinations .card {
                transition: all 0.3s ease;
            }

            .destinations .card:hover {
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
                transform: translateY(-5px);
            }

            .destinations .card img {
                height: 200px;
                object-fit: cover;
                border-radius: 5px;
            }

            /* Reviews Section */
            .reviews {
                padding: 60px 0;
                background-color: #fff;
            }

            .reviews h2 {
                margin-bottom: 40px;
                text-align: center;
                font-size: 2.5rem;
                font-weight: 700;
            }

            .review-item {
                margin-bottom: 30px;
                text-align: center;
                font-size: 1.2rem;
                color: #555;
            }

            .review-item small {
                display: block;
                margin-top: 10px;
                color: #888;
            }

            /* Contact Section */
            .contact {
                background-color: #f9f9f9;
                padding: 60px 0;
            }

            .contact h2 {
                margin-bottom: 40px;
                text-align: center;
                font-size: 2.5rem;
                font-weight: 700;
            }

            .contact .map {
                width: 100%;
                height: 300px;
                background-color: #e9ecef;
                margin-bottom: 30px;
            }

            /* Footer Styling */
            footer {
                background-color: #333;
                color: white;
                padding: 20px 0;
            }

            footer .social-icons a {
                color: white;
                margin: 0 10px;
                font-size: 1.5rem;
                transition: color 0.3s ease;
            }

            footer .social-icons a:hover {
                color: #f2e86d;
            }

            /* Login/Registration Forms */
            .login-box {
                display: none;
                background-color: rgba(255, 255, 255, 0.95);
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                width: 320px;
                position: absolute;
                right: 50px;
                top: 25%;
                z-index: 100;
                transition: opacity 0.3s ease;
            }

            .login-box h3 {
                font-size: 1.7rem;
                margin-bottom: 20px;
            }

            .login-box .form-control {
                margin-bottom: 15px;
            }

            .login-box .btn {
                background-color: #4ABDAC;
                border: none;
                padding: 10px;
                width: 100%;
                font-size: 1rem;
                transition: background-color 0.3s ease;
            }

            .login-box .btn:hover {
                background-color: #037D77;
            }

            .login-box.show {
                display: block;
                opacity: 1;
            }
            .login-box .register-link,
            #login-box a {
                cursor: pointer; 
            }
            /* Modal Styles */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1000; /* On top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.5); /* Black background with opacity */
}

.modal-content {
    background-color: #fff;
    margin: 10% auto; /* 10% from top and centered */
    padding: 20px;
    border-radius: 8px;
    width: 80%; /* Adjust to fit your content */
    max-width: 800px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
/* Style the Privacy Policy link */
.privacy-policy-link {
    color: #007bff; /* Link color */
    text-decoration: underline; /* Underline text */
    cursor: pointer; /* Pointer cursor on hover */
}

.privacy-policy-link:hover {
    text-decoration: none; /* Remove underline on hover for a subtle effect */
    color: #0056b3; /* Darker blue on hover */
}


        </style>
    </head>

    <body>

        <!-- Navbar Section -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="/matttnt/images/mattlogo.jpg" alt="Matt Travel and Tours" style="width: 50px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="#why-choose-us">Why Choose Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="#destinations">Destinations</a></li>
                        <li class="nav-item"><a class="nav-link" href="#reviews">Reviews</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li>
                        <!-- Login and Register Buttons -->
                        <li class="nav-item">
                            <button class="btn btn-outline-primary ms-2" onclick="showLogin()">Login</button>
                        </li>
                        <li class="nav-item">
                            <button class="btn btn-primary ms-2" onclick="showRegister()">Register</button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <h1>Discover Your Next Adventure</h1>
                <p>Explore the best travel package with Matt Destinations Travel and Tours</p>
                <a href="javascript:void(0);" class="btn btn-primary btn-lg" onclick="showLogin()">Book Now</a>
                <a href="#destinations" class="btn btn-outline-primary btn-lg ms-3">Explore Destinations</a>

        </section>

        <!-- Hidden Login/Registration Forms -->
        <div class="login-box" id="login-box">
            <form id="login-form" action="index.php" method="POST">
                <h3>Login</h3>

                <!-- Success message display -->
                <?php if ($success_message != ''): ?>
                    <div class="alert alert-success"><?php echo $success_message; ?></div>
                <?php endif; ?>

                <!-- Error message display -->
                <?php if ($error_message != ''): ?>
                    <div class="alert alert-danger"><?php echo $error_message; ?></div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="username" class="form-label">Username or Email</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
   <!-- Privacy Policy Checkbox -->
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="privacyCheck" required>
            <label class="form-check-label" for="privacyCheck">
                By logging in and using our services, you agree to our 
                <a href="javascript:void(0);" class="privacy-policy-link" onclick="openPrivacyModal()">Privacy Policy</a>.
            </label>
        </div>


<!-- Privacy Policy Modal -->
<div id="privacyModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closePrivacyModal()">&times;</span>
        <h2>Privacy Policy for Matt Destinations Travel and Tours</h2>
        <p><strong>Effective Date:</strong> October 22, 2024</p>

        <h3>1. Information We Collect</h3>
        <p>We collect the following types of information when you visit our website or use our services:...</p>

        <h2>2. How We Use Your Information</h2>
        <p>We use your information to:</p>
        <ul>
            <li>Process bookings and reservations.</li>
            <li>Send booking confirmations and travel updates.</li>
            <li>Improve our website, services, and customer experience.</li>
            <li>Ensure compliance with legal and regulatory requirements.</li>
        </ul>

        <h2>3. Data Sharing and Disclosure</h2>
        <p>We do not sell, rent, or share your personal information with third parties, except:</p>
        <ul>
            <li>With service providers (e.g., hotels, tour guides, payment processors) to fulfill your travel requests.</li>
            <li>To comply with legal obligations, law enforcement, or court orders.</li>
        </ul>

        <h2>4. Data Security</h2>
        <p>We implement industry-standard security measures to protect your personal information from unauthorized access, disclosure, or loss. This includes encryption, and secure payment gateways.</p>

        <h2>5. Your Rights</h2>
        <p>You have the following rights regarding your personal information:</p>
        <ul>
            <li><strong>Access:</strong> You may request a copy of the data we hold about you.</li>
            <li><strong>Correction:</strong> You can update or correct any inaccuracies in your personal information.</li>
        </ul>

        <h2>6. Data Retention</h2>
        <p>We retain your personal data only as long as necessary for the purposes outlined in this policy, or as required by law.</p>

        <h2>7. Changes to This Privacy Policy</h2>
        <p>We may update this Privacy Policy from time to time. Any changes will be posted on this page, and the effective date will be updated accordingly.</p>

        <h2>8. Contact Us</h2>
        <p>If you have any questions or concerns about this Privacy Policy, please contact us at:</p>
        <p>Email: <a href="mailto:info.pgph@gmail.com">info.pgph@gmail.com</a></p>
        <p>Phone: +639123456789</p>

        <h2>10. Compliance with the Data Privacy Act of 2012</h2>
        <p>We are committed to complying with the Data Privacy Act of 2012 and its implementing rules and regulations. We ensure that your personal information is:</p>
        <ul>
            <li>Collected for legitimate purposes only.</li>
            <li>Processed fairly, lawfully, and with your consent.</li>
            <li>Secured and protected against unauthorized access or breaches.</li>
        </ul>

        <p>As part of our compliance, you have the right to:</p>
        <ul>
            <li><strong>Access:</strong> Know what personal data we collect and how it is processed.</li>
            <li><strong>Rectify:</strong> Request corrections to any inaccurate or incomplete data.</li>
            <li><strong>Object:</strong> Decline the collection and processing of your data in certain situations.</li>
        </ul>
    </div>
</div>

                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                <p class="mt-3">Don't have an account? <a class="register-link" onclick="showRegister()">Register here</a>.</p>

            </form>

            <form id="register-form" action="register.php" method="POST" style="display: none;">
                <h3>Register</h3>
                <div class="mb-3">
                    <label for="reg-username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="reg-username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="reg-email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="reg-email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="reg-password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="reg-password" name="password" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary w-100">Register</button>
                <p class="mt-3">Already have an account? <a class="login-link" onclick="showLogin()">Login here</a>.</p>
            </form>
        </div>
        <!-- Why Choose Us Section -->
        <section class="why-choose-us" id="why-choose-us">
            <div class="container">
                <h2>Why Choose Us</h2>
                <div class="row">
                    <div class="col-md-4 feature-box">
                        <i class="fas fa-check-circle fa-3x mb-3"></i>
                        <h4>DOT Accredited Travel Agency</h4>
                        <p>We are DOT Accredited travel agency to provide you the service you can trust.</p>
                    </div>
                    <div class="col-md-4 feature-box">
                        <i class="fas fa-calendar-check fa-3x mb-3"></i>
                        <h4>Easy Booking</h4>
                        <p>Book your trips easily with our user-friendly platform.</p>
                    </div>
                    <div class="col-md-4 feature-box">
                        <i class="fas fa-user-friends fa-3x mb-3"></i>
                        <h4>Personalized Service</h4>
                        <p>We offer tailored travel planning to ensure you have a unique experience.</p>
                    </div>

                </div>
            </div>
        </section>

        <section class="destinations" id="destinations">
            <div class="container">
                <h2>Must Try Activities</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <img src="images/beach/hopping.jpg" class="card-img-top" alt="Activity 1">
                            <div class="card-body">
                                <h5 class="card-title">Island Hopping</h5>
                                <p class="card-text">Haligi Beach, Heart Beach, Long Beach</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="images/beach/snorkeling.jpg" class="card-img-top" alt="Activity 2">
                            <div class="card-body">
                                <h5 class="card-title">Snorkeling</h5>
                                <p class="card-text">Coral Garden, Underwater Cave, Century Old Gian Clam Shell</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="images/beach/tamarraw.jpg" class="card-img-top" alt="Activity 3">
                            <div class="card-body">
                                <h5 class="card-title">Land Tour</h5>
                                <p class="card-text">Tamarraw Falls, Muelle Bay Herritage Park, Puerto Galera Mangrove Conservation</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Reviews Section -->
        <section class="reviews" id="reviews">
            <div class="container">
                <h2>What Our Customers Say</h2>

                <!-- Carousel -->
                <div id="reviewsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                    <div class="carousel-inner">
                        <!-- Slide 1 -->
                        <div class="carousel-item active">
                            <div class="row">
                                <div class="col-md-4 review-item">
                                    <p>"Thank you for the warm welcome at puerto galera mam and sir, our puerto trip wont be the best without you, since day 1 up to the last. From accommodation and tour very wort it. Highly recommended indeed... thank you and Godbless. Til we meet again ❤️"</p>
                                    <small>Ms. Richee</small>
                                </div>
                                <div class="col-md-4 review-item">
                                    <p>"Hiiii! Sorry late na, thank you for accommodating us pala ha. We enjoyed our stay!! Looking forwad na maulit yung tour hahahaha thank you sa smooth transactions! More power to you all ❤️"</p>
                                    <small>Ms. Christine</small>
                                </div>
                                <div class="col-md-4 review-item">
                                    <p>"Thank you so much po sa pag-asikaso sa amin. Hassle free talaga at mababait pa ang mga staff. Super enjoy po quick vacation namin ng mister ko 💕
                                        Sa uulitin po. God bless 🙏"</p>
                                    <small>Ms. Mary</small>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 2 -->
                        <div class="carousel-item">
                            <div class="row">
                                <div class="col-md-4 review-item">
                                    <p>"Thank You White Beach Puerto Galera Tour

                                        Kuddos!!!! To Ate Dora as always lagi kaming asiskaso nya"</p>
                                    <small>Sir Oliver</small>
                                </div>
                                <div class="col-md-4 review-item">
                                    <p>"Hello po. Thank you so much po. Super sulit ng buong package. Sa uulitin po ☺️"</p>
                                    <small>Ms. Jasmine</small>
                                </div>
                                <div class="col-md-4 review-item">
                                    <p>"Sobrang thank you po sa pagtanggap ng booking namin kahit sobrang alanganin ng time. Sorry po kung makulit ako. Super satisfied po at saya ng mga kasama namin. Mabait din po ng mga kasama niyo dito. Thank youu po ng marami ulit. Sa uulitin ♥️"</p>
                                    <small>Ms. Pauu</small>
                                </div>
                            </div>
                        </div>
                        <!-- Slide 3 -->
                        <div class="carousel-item">
                            <div class="row">
                                <div class="col-md-4 review-item">
                                    <p>"Hi, thank you sa hassle free na bakasyon namin. Thank you sa mabait na kausap namin dito sa Matt travel and tours (super accommodating), si ate Alona na tour guide namin, sa mga bankero namin, sa pinag stay-an at sa mga drivers. Sa susunod ulit! Nag enjoy po kami. Maraming maraming salamat"</p>
                                    <small>Ms. Jecka</small>
                                </div>
                                <div class="col-md-4 review-item">
                                    <p>"Hello po, thank you so much po for accommodating us nag enjoy po kame!! Also salamat po sa pag answer ng mga questions namen sa uulutin po!!"</p>
                                    <small>Ms. Ria</small>
                                </div>
                                <div class="col-md-4 review-item">
                                    <p>"thank you po sa magandang experience ng puerto galera namin, pag bumalik po kami jan ulit sa inyo"</p>
                                    <small>Ms. Bhabes</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </section>


        <!-- Contact Section with Map -->
        <section class="contact" id="contact">
            <div class="container">
                <h2>Contact Us</h2>
                <div class="row">
                    <div class="col-md-6">
                        <form class="contact-form">
                            <div class="mb-3">
                                <label for="name" class="form-label">Your Name</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Your Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="map">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7758.9092368359015!2d120.89438329559155!3d13.507669094095839!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bcf87d834d9f2b%3A0xfb09a13453794531!2sWhite%20Beach!5e0!3m2!1sen!2sph!4v1727637151658!5m2!1sen!2sph"
                                width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer Section -->
        <footer class="bg-dark text-white text-center py-4">
            <div class="container">
                <p>&copy; 2024 Matt Travel and Tours. All rights reserved.</p>

                <!-- DOT Accreditation -->
                <p>DOT Accredited. License No: <strong>12345-6789</strong></p>

                <!-- Additional Contact Information -->
                <p>Email: <a href="mailto:info.pgph@gmail.com" class="text-white">info.pgph@gmail.com</a> | Phone: <a href="tel:+639123456789" class="text-white">+63 912 345 6789</a></p>

                <!-- Operating Hours -->
                <p>Operating Hours: Mon - Sun, 8:00 AM - 12:00 AM</p>

                <!-- Social Media Icons -->
                <div class="social-icons">
                    <a href="https://web.facebook.com/PuertoGaleraAdventures/" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                </div>

                <!-- Legal Links -->
                <div class="mt-3">
                    <a href="terms.php" class="text-white me-3">Terms & Conditions</a>
                    <a href="privacy-policy.php" class="text-white">Privacy Policy</a>
                </div>
            </div>
        </footer>


        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            function showLogin() {
                document.getElementById('login-box').style.display = 'block';
                document.getElementById('login-form').style.display = 'block';
                document.getElementById('register-form').style.display = 'none';
            }

            function showRegister() {
                document.getElementById('login-box').style.display = 'block';
                document.getElementById('login-form').style.display = 'none';
                document.getElementById('register-form').style.display = 'block';
            }

            document.addEventListener('click', function(event) {
                var loginBox = document.getElementById('login-box');
                if (loginBox.style.display === 'block' && !loginBox.contains(event.target) && event.target.className.indexOf('btn') === -1) {
                    loginBox.style.display = 'none';
                }
            });

            <?php if ($show_login_form): ?>
                showLogin();
            <?php endif; ?>
            // Function to open the modal
function openPrivacyModal() {
    document.getElementById("privacyModal").style.display = "block";
}

// Function to close the modal
function closePrivacyModal() {
    document.getElementById("privacyModal").style.display = "none";
}

// Close the modal when the user clicks outside of it
window.onclick = function(event) {
    var modal = document.getElementById("privacyModal");
    if (event.target === modal) {
        modal.style.display = "none";
    }
}

        </script>

    </body>

    </html>