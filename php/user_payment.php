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
    <link rel="stylesheet" href="../css/user_payment.css">
</head>
<body>
    <?php include "../layout/header_order.php" ?>   

    <!-- Payment Method -->
     <div class="container">
        <div class="main-container">
            <h2>You Need To Pay: </h2>
        </div>
        <div class="img">
            <img src="../images/qr.png" alt="">
        </div>
        <div>
            <button type="submit" class="button"><a class="button" href="user_order.php">Done</a></button>
        </div>
     </div>
</body>
</html>