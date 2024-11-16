<?php
    session_start();
    if (isset($_SESSION["user_id"])){
        session_regenerate_id();
        $sql = require("../database/database2.php");

        $stmt = $sql->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $_SESSION["user_id"]);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
    }

    else{
        header("location: user_login.php");
        echo("You are unauthorized to access this page, please login first!");
        exit;
    }


    if(isset($_POST['logout'])){
        session_unset();
        session_destroy();
        header("Location: both_home.php");
        exit;
    }
    $costPerKm = 5000; // Tetapkan biaya per km
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $origin = $conn->real_escape_string($_POST["origin"]);
        $destination = $conn->real_escape_string($_POST["destination"]);
        $distance = floatval($_POST["distance"]);
        $cost = floatval($_POST["cost"]);

        $sql = "INSERT INTO perjalanan (asal, tujuan, jarak, biaya) VALUES ('$origin', '$destination', $distance, $cost)";

        if ($conn->query($sql) === TRUE) {
            echo "Data berhasil disimpan";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ojekku - Your Ride, Anytime, Anywhere</title>
    <link rel="stylesheet" href="../css/user_order.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include "../layout/header_order.php" ?>

    <div id="map"></div>

    <div class="main-container">
        <div id="container">
            <form method="post" action="user_order.php">
                <input type="text" id="origin" name="origin" placeholder="Origin: " required>
                <input type="text" id="destination" name="destination" placeholder="Destination: " required>

                <button type="button" onclick="calculateDistance()">Estimation Price and Time to arrive</button>
            </form>
            <div id="result"></div>
            <button class="payyy" type="button" id="btn2"><a href="user_payment.php">Pay First!</a></button>
            <button type="button" id="btn2"><a href="user_after_order.php">Order Now!</a></button>
        </div>
    </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMr819bh0zkoq_K8aqoeaH4-h_TJIpNN0&libraries=places&callback=initMap" async defer></script>
    <script>
        let map, directionsService, directionsRenderer;
        let originAutocomplete, destinationAutocomplete;
        const costPerKm = <?= $costPerKm ?>;

        function initMap() {
            map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: -6.200000, lng: 106.816666 },
                zoom: 13,
            });
            
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);

            // Tambahkan fitur autocomplete untuk asal dan tujuan
            originAutocomplete = new google.maps.places.Autocomplete(document.getElementById("origin"));
            destinationAutocomplete = new google.maps.places.Autocomplete(document.getElementById("destination"));
        }

        function calculateDistance() {
            const origin = document.getElementById("origin").value;
            const destination = document.getElementById("destination").value;

            directionsService.route(
                {
                    origin: origin,
                    destination: destination,
                    travelMode: google.maps.TravelMode.DRIVING,
                },
                (response, status) => {
                    if (status === "OK") {
                        directionsRenderer.setDirections(response);

                        const distanceMeters = response.routes[0].legs[0].distance.value;
                        const distanceKm = distanceMeters / 1000;
                        const cost = distanceKm * costPerKm;
                        const duration = response.routes[0].legs[0].duration.text;

                        document.getElementById("result").innerHTML = `
                            <p>Distance: ${distanceKm.toFixed(2)} km</p>
                            <p>Estimation to arrive: ${duration}</p>
                            <p>Cost: Rp ${cost.toLocaleString("id-ID")}</p>
                        `;

                        // Simpan data ke database melalui AJAX
                        saveToDatabase(origin, destination, distanceKm, cost, duration);
                    } else {
                        alert("Gagal mendapatkan arah: " + status);
                    }
                }
            );
        }

        function saveToDatabase(origin, destination, distance, cost, duration) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "index.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log("Data berhasil disimpan ke database.");
                }
            };
            xhr.send(`save_data=1&origin=${origin}&destination=${destination}&distance=${distance}&cost=${cost}&duration=${duration}`);
        }
    </script>
</body>
</html>