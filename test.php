<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Google Maps Directions</title>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
        #controls {
            margin-top: 10px;
        }
        .location-input {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h3>Calculate Directions</h3>
    <div id="controls">
        <div class="location-input">
            <input id="origin-input" type="text" placeholder="Enter Origin">
            <button id="origin-button">Set Origin</button>
        </div>
        <div class="location-input">
            <input id="destination-input" type="text" placeholder="Enter Destination">
            <button id="destination-button">Set Destination</button>
        </div>
        <button id="order-button">Order Ride</button>
    </div>
    <div id="map"></div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMr819bh0zkoq_K8aqoeaH4-h_TJIpNN0&libraries=places&callback=initMap" async defer></script>
    <script>
        let map;
        let directionsService;
        let directionsRenderer;
        let originPlace = null;
        let destinationPlace = null;

        function initMap() {
            // Inisialisasi peta
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: -6.200000, lng: 106.816666 }, // Jakarta
                zoom: 12
            });

            // Inisialisasi Directions API
            directionsService = new google.maps.DirectionsService();
            directionsRenderer = new google.maps.DirectionsRenderer();
            directionsRenderer.setMap(map);

            // Event listener untuk tombol origin
            document.getElementById('origin-button').addEventListener('click', () => {
                const originInput = document.getElementById('origin-input').value;
                if (originInput) {
                    originPlace = originInput;
                    alert("Origin set to: " + originPlace);
                } else {
                    alert("Please enter a valid origin location");
                }
            });

            // Event listener untuk tombol destination
            document.getElementById('destination-button').addEventListener('click', () => {
                const destinationInput = document.getElementById('destination-input').value;
                if (destinationInput) {
                    destinationPlace = destinationInput;
                    alert("Destination set to: " + destinationPlace);
                } else {
                    alert("Please enter a valid destination location");
                }
            });

            // Event listener untuk tombol order
            document.getElementById('order-button').addEventListener('click', () => {
                if (originPlace && destinationPlace) {
                    calculateAndDisplayRoute();
                } else {
                    alert("Please set both origin and destination locations");
                }
            });
        }

        function calculateAndDisplayRoute() {
            directionsService.route(
                {
                    origin: originPlace,
                    destination: destinationPlace,
                    travelMode: google.maps.TravelMode.DRIVING
                },
                (response, status) => {
                    if (status === "OK") {
                        directionsRenderer.setDirections(response);
                    } else {
                        alert("Directions request failed due to " + status);
                    }
                }
            );
        }
    </script>
</body>
</html>
