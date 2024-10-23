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
                <input type = "text" name = "username" class = "but" placeholder="Origin: "/>
            </div>
            <br>
            <div class="back_back">
                <label for = "email"></label>
                <input type = "email" name = "email" class = "but" placeholder="Destination: "/>
            </div>
            <br>
            <div class="back_back1">
                <button class="sub_order" name = "submit"> <h2>Order Ride</h2> </button>
            </div>
        </form>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMr819bh0zkoq_K8aqoeaH4-h_TJIpNN0&libraries=places&callback=initMap" async defer></script>

    <script>
        function initMap() {
            var location = {lat: -6.200000, lng: 106.816666};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: location
            });
            
            var input = document.getElementById('searchInput');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
            });

            var markers = [];
            searchBox.addListener('places_changed', function() {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }


                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
                markers = [];


                var bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {
                    if (!place.geometry || !place.geometry.location) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };

                    markers.push(new google.maps.Marker({
                        map: map,
                        icon: icon,
                        title: place.name,
                        position: place.geometry.location
                    }));

                    if (place.geometry.viewport) {
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });
        }
    </script>

    <!-- <script>
        var map = L.map('map').setView([-6.200000, 106.816666], 13);
        // Menambahkan lapisan peta dari MapBox
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibmFuZG90YW4iLCJhIjoiY20ya2tmaTg2MDI5ZjJqb283Z3ZxazRkZiJ9.SV2r2sK9xxvub0CB7lt8Yg', {
            id: 'mapbox/streets-v11', // Gaya peta yang digunakan (streets, satellite, dll.)
            tileSize: 512,
            zoomOffset: -1,
            accessToken: 'pk.eyJ1IjoibmFuZG90YW4iLCJhIjoiY20ya2tmaTg2MDI5ZjJqb283Z3ZxazRkZiJ9.SV2r2sK9xxvub0CB7lt8Yg'
        }).addTo(map);
        var marker;

        // Fungsi untuk mencari lokasi menggunakan Mapbox Geocoding API
        function searchLocation() {
            var query = document.getElementById('searchInput').value;
            if (query) {
                var accessToken = 'pk.eyJ1IjoibmFuZG90YW4iLCJhIjoiY20ya2tmaTg2MDI5ZjJqb283Z3ZxazRkZiJ9.SV2r2sK9xxvub0CB7lt8Yg';
                var url = 'https://api.mapbox.com/geocoding/v5/mapbox.places/' + encodeURIComponent(query) + '.json?access_token=' + accessToken;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data.features && data.features.length > 0) {
                            var latlng = [
                                data.features[0].geometry.coordinates[1],
                                data.features[0].geometry.coordinates[0]
                            ];

                            // Memindahkan peta ke lokasi yang dicari
                            map.setView(latlng, 13);

                            // Menambahkan marker di lokasi tersebut
                            if (marker) {
                                map.removeLayer(marker);
                            }
                            marker = L.marker(latlng).addTo(map).bindPopup(query).openPopup();
                        } else {
                            alert('Location Not Found');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching location:', error);
                        alert('Error!');
                    });
            } else {
                alert('Input the name of the streets');
            }
        }

        // Tambahkan event listener untuk menangani enter key
        document.getElementById('searchInput').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                searchLocation();
            }
        });

    </script> -->
</body>
</html>