<?php
    $token = htmlspecialchars($_GET["token"]);

    $token_hash = hash("sha256", $token);

    $sql = require("./database2.php");

    $newsql = "SELECT * FROM users
               WHERE reset_token_hash = ?";

    $stmt = $sql->prepare($newsql);
    $stmt->bind_param("s", $token_hash);

    $stmt->execute();

    $res = $stmt->get_result();
    $user = $res->fetch_assoc();

    if (!$user){
        die("token not found!");
    }

    if (strtotime($user["reset_token_expires_at"]) <= time()){
        die("token expired");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Reset Password </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel = "stylesheet" type = "text/css" href="reset.css">
</head>
<body>
    <div class = "content">
    <h1> Reset Password </h1>
    <form method = "POST" action = "reset-password-process.php">
        <input type = "hidden" name = "token" value = "<?= htmlspecialchars($token); ?>"/>
        <div class = "pwd">
        <label for = "newpassword"> New Password </label>
        <input type = "password" name = "password" class = "pwd2"/>
        </div>
        <div class = "cfm">
        <label for = "confirmpassword"> Confirm Password </label>
        <input type = "password" name = "passwordconfirm" class = "cfm2"/>
        </div>
        <button class = "btn"> Confirm </button>
    </form>

    </div>
</body>
</html>