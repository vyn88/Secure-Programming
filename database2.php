<?php
    $host = "localhost";
    $db_name = "signup_db";
    $username = "root";
    $password = "";

    $sql = new mysqli(hostname: $host,
                      username: $username,
                      password: $password,
                      database: $db_name);

    if ($sql->connect_errno){
        die("Connection error: " . $sql->connect_error);
    }

    return $sql;
?>