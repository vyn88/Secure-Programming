<?php
session_start();
require('./connection.php');
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if (isset($_POST['login'])){
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars(password_hash($_POST['password'], PASSWORD_DEFAULT));

            $sanitized_username = mysqli_real_escape_string($conn, $username);
            $sanitized_password = mysqli_real_escape_string($conn, $password);
            $query = "SELECT * FROM users 
            WHERE username = ' ".$sanitized_username ." ' AND password = '" .$sanitized_password ."'";
            $res = $conn->query($query);

            if ($res->num_rows > 0){
                $row = $res->fetch_assoc();
                $_SESSION['is_login'] = true;
                $_SESSION['role'] = htmlspecialchars($row['role']);

                header('location: ../messages.php');
            }

            // else {
            //     header('location: ../Error.php');
            //     die;
            // }
        }

        else if (isset($_POST['register'])){
            require('../SignUpValidation.php');
            $password_hash = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, password)
                      VALUES(?, ?)";
            $stmt = $conn->stmt_init();

            if (!$stmt->prepare($query)){
                die("Sql error: ". $conn->error);
            }
            $stmt->bind_param("ss", htmlspecialchars($_POST['username'], $password_hash));

        }

        else if (isset($_POST['logout'])){
            $logout = $_SESSION['logout'];
            if (isset($logout)){
                unset($_POST['login']);
                session_destroy();
                exit;
            }
        }
    }

?>