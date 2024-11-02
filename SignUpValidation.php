<?php
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize an array to store error messages
    $errors = [];

    // Validation: Check if required fields are present and not empty
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email']) || empty($_POST['confirmpassword'])) {
        $errors[] = "Please fill in all input fields.";
    }

    // Validation: Check password length
    if (!empty($_POST['password']) && strlen($_POST['password']) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    // Validation: Check email format
    if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    // Validation: Check if password contains at least one letter
    if (!empty($_POST['password']) && !preg_match("/[a-zA-Z]/", $_POST['password'])) {
        $errors[] = "Password must contain at least one letter.";
    }

    // Validation: Check if password contains at least one number
    if (!empty($_POST['password']) && !preg_match("/[0-9]/", $_POST['password'])) {
        $errors[] = "Password must contain at least one number.";
    }

    // Validation: Check if passwords match
    if ($_POST['password'] !== $_POST['confirmpassword']) {
        $errors[] = "Passwords do not match.";
    }

    // If there are errors, redirect back to register page with errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: register.php");
        exit;
    }

    // Hash the password securely
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Database connection
    $sql = require './database2.php';

    // Prepare SQL query to insert new user
    $newsql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $sql->stmt_init();

    if (!$stmt->prepare($newsql)) {
        die("SQL error: " . $sql->error);
    }

    // Bind parameters to prevent SQL injection
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    // Execute the statement and handle errors
    if ($stmt->execute()) {
        // Redirect to login or homepage on success
        header("Location: index.php");
        exit;
    } else {
        // Check if the error is due to a duplicate email
        if ($sql->errno === 1062) {
            $errors[] = "Email has already been taken.";
        } else {
            $errors[] = "An error occurred: " . $sql->error;
        }
        $_SESSION['errors'] = $errors;
        header("Location: register.php");
        exit;
    }
}
?>
