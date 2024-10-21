<?php
    session_start();
    if (isset($_SESSION["user_id"])){
        $sql = require("./database2.php");

        $newsql = "SELECT * FROM users
                 WHERE id = {$_SESSION["user_id"]}";

        $res = $sql->query($newsql);

        $user = $res->fetch_assoc();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ojekku Home Page </title>
    <link rel = "stylesheet" type = "text/css" href= "home.css">
</head>

<body>
    <h1 class = "h1"> Home Page </h1>
    <div class = "welcome">
    <?php if (isset($user)): ?>
        <p> Welcome <?= htmlspecialchars($user["username"]) ?>! </p>

    <?php endif; ?>
    </div>

</body>

</html>