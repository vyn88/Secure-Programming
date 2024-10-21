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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <title>Order</title>
    <link rel="stylesheet" href="order.css">
</head>
<body>
    <?php include "layout/header_chat.php" ?>

    <div id="map">

    </div>

    <div class = "background_order">
        <form action = "" method = "POST">
            <div class="back_back">
                <label for = "username"> </label>
                <input type = "text" name = "username" class = "but"/>
            </div>
            <br>
            <div class="back_back">
                <label for = "email"></label>
                <input type = "email" name = "email" class = "but"/>
            </div>
            <br>
            <div class="back_back1">
                <button class="sub_order" name = "submit"> <h2>Order Ride</h2> </button>
            </div>
        </form>
    </div>

    <script>
        var map = L.map('map').setView([0, 0], 1);
        L.tileLayer('https://api.maptiler.com/maps/streets-v2/{z}/{x}/{y}.png?key=5PlkXaUdpLW60hdY1DbR', {
            attribution: '<a href="https://www.maptiler.com/copyright/" target="_blank">&copy; MapTiler</a> <a href="https://www.openstreetmap.org/copyright" target="_blank">&copy; OpenStreetMap contributors</a>',
        }).addTo(map);
    </script>
</body>
</html>