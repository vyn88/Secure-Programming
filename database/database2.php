<?php
    $host = "localhost";
    $db_name = "ojekku";
    $username = "root";
    $password = "";

    // Koneksi ke database
    $sqli = new mysqli(hostname: $host,
                      username: $username,
                      password: $password,
                      database: $db_name);

    if ($sqli->connect_error){
        die("Connection error: " . $sqli->connect_error);
    }
    return $sqli
?>
