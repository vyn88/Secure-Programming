<!DOCTYPE html>
<html lang="en">

<?php
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);
    session_start();
    $is_invalid = false;
    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        $sql = require("../database/database2.php");

        $stmt = $sql->prepare("SELECT * FROM users WHERE email = ? AND username = ? ");
        $stmt->bind_param("ss", $_POST["email"], $_POST["username"]);
        $stmt->execute();
        $res = $stmt->get_result();
        $user = $res->fetch_assoc();
        $stmt->close();

        if ($user){
            if (password_verify($_POST["password"], $user["password"])){
                session_regenerate_id();
                $_SESSION["user_id"] = $user["id"];
                header("Location: user_home.php");
                exit;
            }
        }

        $is_invalid = true;
    }
?>

<?php 
    require("../vendor/autoload.php");

    $client = new Google\Client;

    $client->setClientId("1089010188231-nut2j3bvg6tdq1o9aqa8klaineb53qes.apps.googleusercontent.com");
    $client->setClientSecret("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");
    $client->setRedirectUri("http://localhost:8000/user_home.php");

    $client->addScope("email");
    $client->addScope("profile");

    $url = $client->createAuthUrl();


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ojekku - Your Ride, Anytime, Anywhere</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel = "stylesheet" type = "text/css" href = "../css/user_login.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
</head>

<body>
<div class = "content">
        <?php if ($is_invalid): ?>
            <em class = "error"> Invalid Credentials </em>
        <?php endif; ?>
   <form method = "POST">
    <h2 class = "h2"> Log In Page </h2>
        <div>
            <label for = "username"> Username </label>
            <input type = "text" name = "username" class = "username" value = "<?= !isset($_POST["username"]) ? "" : htmlspecialchars($_POST["username"]) ?>"/>
        </div>

        <div>
            <label for = "email"> Email </label>
            <input type = "email" name = "email" class = "email" value = "<?= !isset($_POST["email"]) ? "" : htmlspecialchars($_POST["email"]) ?>" />
        </div>

        <div>
            <label for = "password"> Password </label>
            <input type = "password" name = "password" class = "password"/>
        </div>
            <button class = "btnsubmit" name = "submit"> Login </button>

        <div class = "googlesignin">
            <p><a class = "link" href = "<?= $url; ?>"> Login with your Google Account </a></p>
        </div>

        <div class="forgot">
            <a href = "./forgotten-password-form.php"> Forgot Password? </a>
        </div>
   </form>
</div>
</body>

</html>