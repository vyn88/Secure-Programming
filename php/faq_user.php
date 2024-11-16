
<?php
    session_start();
    if (isset($_SESSION["user_id"])){
        session_regenerate_id();
        $sql = require("../database/database2.php");

        $newsql = "SELECT * FROM users
                 WHERE id = {$_SESSION["user_id"]}";

        $res = $sql->query($newsql);

        $user = $res->fetch_assoc();
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
</head>
<body>
    <div>
    <nav class="navbar">
            <div class="logo">OJEKKU</div>
            <div class = "lists">
            <ul class="nav-links">
                <li><a href="user_home.php" class="active">Home</a></li>
                <li><a href="user_order.php">Order</a></li>
                <li><a href="user_about_us.php">About Us</a></li>
                <li><a href="faq_user.php">FAQ</a></li>
            </ul>
            </div>
            <div class = "nav-auth">
                <form action="both_home.php" method="POST">
                    <button type="submit" name="logout" class="register">Logout</button>
                </form>
                <?php if (isset($user)): ?>
                <p class="login"> Welcome <?= htmlspecialchars($user["username"]) ?>! </p>
                <?php endif; ?>
            </div>
        </nav>
    <div class="container">
        <div class="upper-section">
            <h1 class="title">FAQ For User</h1>
        </div>
    </div>

    <div class = "main-content">
        <div class = "middle-section">
            <p class = "first"> 
            Q: What is this application used for? <br>
            A: This application can be used to offer convenience to those who need to get around the city using online transportation services. See About Us for more details.
            </p>
            <br>
            <br>
            <p class = "second">
            Q: Will the application update us once a driver has been found? <br>
            A: Yes. Just surf the order page and try ordering a ride, we will notify you once a driver has been found.
            </p>
        </div>

    </div>
    </div>

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
        background: linear-gradient(135deg, rgba(0, 105, 255, 0.8), rgba(0, 255, 255, 0.5)),
                    radial-gradient(circle, rgba(0, 105, 255, 0.5) 0%, rgba(0, 255, 255, 0.2) 70%);
    }

.nav-auth {
        display: flex;
        align-items: center;
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
        cursor: pointer;
}

.first{
    background-color: white;
    padding-left: 5px;
    max-width: 100%;
    width: 1000px;
    border: 2px solid black;
}

.second{
    background-color: white;
    padding-left: 5px;
    max-width: 100%;
    width: 1000px;
    border: 2px solid black;
}

.main-content{
    display: flex;
    position: absolute;
}

.middle-section{
    margin-top: 150px;
    padding-left: 10px;
    font-size: 22px;
}


.container {
        background: linear-gradient(135deg, rgba(0, 105, 255, 0.8), rgba(0, 255, 255, 0.5)),
                    radial-gradient(circle, rgba(0, 105, 255, 0.5) 0%, rgba(0, 255, 255, 0.2) 70%);
        background-blend-mode: multiply;
        padding: 10px;
        flex: 1;
    }
.nav-links {
        list-style: none;
        display: flex;
    }

.title {
    text-align: center;
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
    cursor: pointer;
    }

.lists a{
    text-decoration: none;
    color: gray;
    transition: color 0.3s;
    cursor: pointer;
}

.logo {
    color: rgb(0, 105, 255);
    font-size: 24px;
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

.nav-links a.active,
.nav-links a:hover {
    color: rgb(0, 105, 255);
}

</style>