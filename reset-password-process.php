<?php
    $token = htmlspecialchars($_POST["token"]);

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
        return false;
    }

    else if (strtotime($user["reset_token_expires_at"]) <= time()){
        die("token expired");
        return false;
    }

    else if (strlen($_POST["password"]) < 6){
        echo("Passwords must be at least 6 characters long");
        return false;
    }

    else if (!preg_match("/[a-z]/i", $_POST["password"])){
        echo("Password must contain at least one character!");
        return false;
    }

    else if (!preg_match("/[0-9]/", $_POST['password'])){
        echo("Password must contain at least one number!");
        return false;
    }

    else if ($_POST["password"] !== $_POST["passwordconfirm"]){
        echo("Passwords don't match!");
        return false;
        
    }

    $hashed_password = htmlspecialchars(password_hash($_POST["password"], PASSWORD_DEFAULT));

    $newsqli2 = "UPDATE users
                SET password = ?,
                reset_token_hash = NULL,
                reset_token_expires_at = NULL
                WHERE id = ?";

    $stmt = $sql->prepare($newsqli2);

    $stmt->bind_param("ss", $hashed_password, $user["id"]);

    $stmt->execute();

    echo "Password Updated. You can now log in.";

    header("location: login.php");