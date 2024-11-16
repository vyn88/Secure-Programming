<?php
    session_start();
    if (isset($_SESSION["driver_id"])){
        $sql = require("../database/database2.php");
        session_regenerate_id();
        
        $stmt = $sql->prepare("SELECT * FROM drivers WHERE id = ?");
        $stmt->bind_param("i", $_SESSION["driver_id"]);
        $stmt->execute();
        $driver = $stmt->get_result()->fetch_assoc();
    }

    else{
        header("location: driver_login.php");
        echo("You are unauthorized to access this page, please login first!");
        exit;
    }


    if(isset($_POST['logout'])){
        session_unset();
        session_destroy();
        header("Location: ./both_home.php");
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
    <link href="{{ asset('css/nav-style.css') }}" rel="stylesheet">
</head>

<body>
    <div>
        <nav class="navbar">
            <div class="logo">OJEKKU</div>
            <ul class="nav-links">
                <li><a href="driver_home.php" class="active">Home</a></li>
                <li><a href="driver_get_order.php">Order</a></li>
                <li><a href="driver_about_us.php">About Us</a></li>
                <li><a href="faq_driver.php">FAQ</a></li>
            </ul>
            <div class = "nav-auth">
                <form action="both_home.php" method="POST">
                    <button type="submit" name="logout" class="register">Logout</button>
                </form>
                <?php if (isset($driver)): ?>
                <p class="login"> Welcome <?= htmlspecialchars($driver["name"]) ?>! </p>
                <?php endif; ?>
            </div>
        </nav>
        
        <div class="mobile-menu">
            <ul>
                <li><a href="home.php" class="active">Home</a></li>
                <li><a href="about_us.php">About Us</a></li>
                <li><a href="faq.php">FAQ</a></li>
                <li><a href="#" class="login">Log In</a></li>
                <li><a href="#" class="register">Register</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <div class="upper-section">
            <h1 class="title">Ojekku</h1>
            <p class="description">Your Ride, Anytime, Anywhere</p>
        </div>
        
        <section class="how-it-works">
            <h2>How It Works</h2>
            <div class="steps">
                <div class="step">
                    <h3>1. Choose Location</h3>
                    <p>Enter your pick-up and destination locations.</p>
                </div>
                <div class="step">
                    <h3>2. Select a Driver</h3>
                    <p>Pick an available driver nearby.</p>
                </div>
                <div class="step">
                    <h3>3. Enjoy Your Ride</h3>
                    <p>The driver will pick you up and get you safely to your destination.</p>
                </div>
            </div>
        </section>

        <section class="features">
            <h2>Main Features</h2>
            <div class="feature-card">
                <h3>Security</h3>
                <p>Each ride is equipped with top-notch security systems.</p>
            </div>
            <div class="feature-card">
                <h3>Comfort</h3>
                <p>Experience a comfortable ride with professional drivers.</p>
            </div>
            <div class="feature-card">
                <h3>Speed</h3>
                <p>Drivers arrive promptly and take you to your destination quickly.</p>
            </div>
        </section>

        <section class="testimonials">
            <h2>What Our Users Say</h2>
            <div class="testimonial">
                <p>"Ojekku really helped me when I was in a hurry! Fast service and friendly drivers!" - John</p>
            </div>
            <div class="testimonial">
                <p>"My ride was safe and comfortable. Thank you, Ojekku!" - Sarah</p>
            </div>
        </section>

        <footer>
            <p>&copy; 2024 Ojekku. Always with you on every journey.</p>
        </footer>
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

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Nunito', sans-serif;
    }

    body {
        height: 100vh;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
    }

    .register{
        cursor: pointer;
    }

    .container {
        background: linear-gradient(135deg, rgba(0, 105, 255, 0.8), rgba(0, 255, 255, 0.5)),
                    radial-gradient(circle, rgba(0, 105, 255, 0.5) 0%, rgba(0, 255, 255, 0.2) 70%);
        background-blend-mode: multiply;
        padding: 10px;
        flex: 1;
    }

    .upper-section {
        align-content: center;
        margin: 20px;
        margin-block: 50px;
    }

    .title {
        text-align: center;
    }

    .description {
        text-align: center;
    }

    .feature-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 35px;
        padding-inline: 5vw;
        padding-bottom: 50px;
    }

    .feature-box {
        box-shadow: rgba(17, 25, 46, 0.1) 0px 0px 0px 2px inset;
        background: rgb(249, 250, 254);
        border-radius: 10px;
        display: flex;
        max-width: 100%;
        flex-direction: column;
        gap: 24px;
        height: 100%;
        padding: 35px;
        justify-content: center;
        transition: background-color 0.3s;
    }

    .feature-title {
        font-weight: 700;
    }

    .feature-description {
        font-weight: 500;
        align-items: flex-start;
        align-self: stretch;
        display: flex;
        flex-grow: 1;
        gap: 24px;
    }

    .navbar {
        font-weight: 750;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: white;
        padding: 15px 20px;
        position: relative;
        border-bottom: 1px solid rgb(227, 232, 244);
    }

    .logo {
        color: rgb(0, 105, 255);
        font-size: 24px;
    }

    .nav-links {
        list-style: none;
        display: flex;
    }

    .nav-links li {
        margin: 0 15px;
    }

    .nav-links a {
        text-decoration: none;
        color: gray;
        transition: color 0.3s;
    }

    .nav-links a.active,
    .nav-links a:hover {
        color: rgb(0, 105, 255);
    }

    .nav-auth {
        display: flex;
        align-items: center;
    }

    .nav-auth .login {
        text-decoration: none;
        color: black;
        margin-right: 15px;
    }

    .nav-auth .register {
        text-decoration: none;
        color: white;
        background-color: rgb(0, 105, 255);
        padding: 10px 15px;
        border-radius: 5px;
        margin-right: 5px;
        color: black;
        font-weight: bold;
    }

    .hamburger {
        display: none;
        font-size: 24px;
        cursor: pointer;
    }

    .mobile-menu {
        font-weight: 750;
        display: none;
        background-color: white;
        position: absolute;
        top: 60px;
        width: 100%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .mobile-menu ul {
        list-style: none;
        padding: 10px 0;
    }

    .mobile-menu li {
        padding: 10px 20px;
    }

    .mobile-menu a {
        text-decoration: none;
        color: gray;
        display: block;
    }

    .mobile-menu a.active,
    .mobile-menu a:hover {
        color: rgb(0, 105, 255);
    }

    @media only screen and (max-width: 768px) {
        .feature-container {
            grid-template-columns: 1fr;
        }

        .nav-links, .nav-auth {
            display: none;
        }

        .hamburger {
            display: block;
        }

        .mobile-menu.active {
            display: block;
        }
    }
    .about, .how-it-works, .features, .testimonials {
    padding: 2rem;
    text-align: center;
    }
    .about p, .how-it-works .steps p, .feature-card p, .testimonial p {
        color: #555;
    }
    .steps {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 1rem;
    }

    .step {
        background: white;
        padding: 1rem;
        width: 200px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .feature-card {
        background: white;
        padding: 1.5rem;
        width: 250px;
        text-align: center;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: inline-block;
        margin: 0.5rem;
    }

    .testimonials .testimonial {
        background: #fff;
        padding: 1rem;
        border-radius: 5px;
        margin: 1rem auto;
        width: 80%;
        max-width: 500px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    footer {
        background: #1e90ff;
        color: white;
        text-align: center;
        padding: 1rem;
    }
</style>