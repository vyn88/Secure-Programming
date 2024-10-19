<?php
session_start();
require('./controllers/connection.php');
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if (!isset($_POST['username']) && !isset($_POST['password']) && empty($_POST['username']) && empty($_POST['password'])){
        echo("Please fill the input fields below!");
        return false;
    }

    else if (strlen($_POST['password']) < 6){
        echo("Passwords must be at least 6 characters long");
        return false;
    }

    else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        echo ("Please enter the femail in the valid format!");
        return false;
    }

    else if (!preg_match("/[a-z]/i", $_POST['password'])){
        echo ("Password must contain at least one character!");
        return false;
    }

    else if (!preg_match("/[0-9]/", $_POST['password'])){
        echo ("Password must contain at least one number!");
        return false;
    }


}

?>