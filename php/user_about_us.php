<?php
    session_start();
    if (isset($_SESSION["user_id"])){
        session_regenerate_id();
        $sql = require("../database/database2.php");

        $stmt = $sql->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $_SESSION["user_id"]);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
    }

    else{
        header("location: user_login.php");
        echo("You are unauthorized to access this page, please login first!");
        exit;
    }


    if(isset($_POST['logout'])){
        session_unset();
        session_destroy();
        header("Location: both_home.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ojekku - Your Ride, Anytime, Anywhere</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/about_us.css">
</head>

<body>
    <div>
        <nav class="navbar">
            <div class="logo">OJEKKU</div>
            <ul class="nav-links">
                <li><a href="user_home.php" class="active">Home</a></li>
                <li><a href="user_order.php">Order</a></li>
                <li><a href="user_about_us.php">About Us</a></li>
                <li><a href="faq_user.php">FAQ</a></li>
            </ul>
            <div class="nav-auth">
                <form action="both_home.php" method="POST">
                    <button type="submit" name="logout" class="register">Logout</button>
                </form>
                <?php if (isset($user)): ?>
                <p class="login"> Welcome <?= htmlspecialchars($user["username"]) ?>! </p>
                <?php endif; ?>
            </div>
        </nav>
        
        <div class="mobile-menu">
            <ul>
                <li><a href="both_home.php" class="active">Home</a></li>
                <li><a href="/about-us">About Us</a></li>
                <li><a href="/faq_user.php">FAQ</a></li>
                <li><a href="both_login.php" class="login">Log In</a></li>
                <li><a href="both_register.php" class="register">Register</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <section class="about-us">
        <div class="container">
            <div class="header-image">
                <img src="../images/taxi.jpg" alt="Transport Header Image" class="fade-in zoom-in">
            </div>
            <h1>About Us</h1>
            <p class="intro">Welcome to <strong>Ojekku</strong> – a ride-hailing app designed to make your journeys easier with fast, safe, and reliable online motorcycle taxi services.</p>

            <div class="section">
                <h2>Our Mission</h2>
                <p>At Ojekku, we are committed to providing dependable and affordable transportation services. We understand the high mobility needs of daily life, and we’re here to be your solution for getting around quickly and safely, whenever you need it.</p>
            </div>

            <div class="section">
                <h2>Our Vision</h2>
                <p>To become the top choice in transportation, empowering local drivers and providing the best travel experience for users across Indonesia. Through technology and innovation, we aim to bring ease and convenience into one app.</p>
            </div>

            <div class="section">
                <h2>Our Advantages</h2>
                <ul>
                    <li><strong>Ease of Use</strong>: With a simple interface, users can easily book a ride and track their driver’s location.</li>
                    <li><strong>Trained Drivers</strong>: All our drivers go through a verification and training process to ensure your safety and comfort.</li>
                    <li><strong>Transparent Pricing</strong>: We offer clear, transparent pricing with no hidden fees.</li>
                    <li><strong>Safety Commitment</strong>: Your safety is our priority. Each ride is monitored and protected by strict safety standards.</li>
                </ul>
            </div>

            <div class="section">
                <h2>How We Work</h2>
                <p>Simply open the Ojekku app, select your pick-up and destination points, and let us connect you with the nearest driver. Within minutes, a driver will arrive to take you safely and comfortably to your destination.</p>
            </div>

            <div class="section">
                <h2>Contact Us</h2>
                <p>If you have any questions or feedback, don’t hesitate to reach out to our team. We are here to assist you and are constantly working to improve Ojekku’s quality of service for you.</p>
            </div>
        </div>
    </section>

    </div>

    <x-footer></x-footer>

    <script>
        function toggleMenu() {
            const mobileMenu = document.querySelector('.mobile-menu');
            mobileMenu.classList.toggle('active');
        }
    </script>
</body>
</html>