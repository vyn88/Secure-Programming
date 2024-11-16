<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if (!isset($_POST["username"]) && !isset($_POST["password"]) && empty($_POST["username"]) && empty($_POST["password"])){
        echo("Please fill the input fields below!");
        return false;
    }

    else if (strlen($_POST["password"]) < 6){
        echo("Passwords must be at least 6 characters long");
        return false;
    }
    else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        echo("Please enter the email in the valid format!");
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

    else if ($_POST["password"] !== $_POST["confirmpassword"]){
        echo("Passwords don't match!");
        return false;
    }

    else if ($_POST["username"] === "admin" && $_POST["email"] === "admin@example.com"){
        echo("These credentials are not allowed, pick a different format of credentials!");
        return false;
    }

    $hashed_password = htmlspecialchars(password_hash($_POST["password"], PASSWORD_DEFAULT));
    $sql = require("../database/database2.php");

    $newsql = "INSERT INTO drivers (name, email, password)
               VALUES(?, ?, ?)";

    $stmt = $sql->stmt_init();
    if (!$stmt->prepare($newsql)){
        die("SQL error: " . $sql->error);
    }

    $stmt->bind_param("sss", htmlspecialchars($_POST["username"]), htmlspecialchars($_POST["email"]), $hashed_password);

    if($stmt->execute()){
        header("location: ../index.php");
        exit;
    }

    else {
        if ($sql->errno === 1062){
            die("Email has already been taken");
        }

        else {
            die($sql->error . " ". $sql->errno);
        }
    }
}

?>