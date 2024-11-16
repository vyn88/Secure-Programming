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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ojekku - Your Ride, Anytime, Anywhere</title>
    <link rel="stylesheet" href="../css/user_after_order.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Modal Styles */
        .modal {
            display: none; /* Tersembunyi secara default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            width: 90%;
            max-width: 400px; /* Ukuran maksimal 400px agar sama dengan contoh */
            border-radius: 10px;
            text-align: center;
            position: relative;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 20px;
            color: #aaa;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        /* Chat Box Styles */
        .chat-messages {
            height: 200px; /* Tinggi tetap untuk chat messages */
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            text-align: left;
        }

        #chatInput {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-top: 10px;
            box-sizing: border-box;
        }

        .btn-send {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-send:hover {
            background-color: #0056b3;
        }

        /* Call Button Styles */
        .accept-call {
            background-color: green;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            margin: 10px;
            cursor: pointer;
        }

        .decline-call {
            background-color: red;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            margin: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include "../layout/header_order.php" ?>
    <h1 class="info">You get the driver!</h1>
    <div id="map"></div>

    <div class="main-container">
        <div class="container">
            <div id="result"></div>
            <div class="top-container">
                <div><h3>Driver Name: Justin</h3></div>
                <div class="rating">
                    <img src="../images/star.png" alt="Rating" style="width: 20px; height: 20px;">
                    <span>5 / 5</span>
                </div>
            </div>
            <div class="mid-container">
                <button type="button" onclick="openChat()">Chat</button>
                <button type="button" onclick="openCall()">Call</button>
            </div>
        </div>
    </div>

    <!-- Modal Chat -->
    <div id="chatModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeChat()">&times;</span>
            <h2>Chat with Driver</h2>
            <div id="chatMessages" class="chat-messages">
                <!-- Chat messages will appear here -->
            </div>
            <input type="text" id="chatInput" placeholder="Type your message here...">
            <button class="btn-send" onclick="sendMessage()">Send</button>
        </div>
    </div>

    <!-- Modal Call -->
    <div id="callModal" class="modal">
        <div class="modal-content">
            <h2>Calling Driver...</h2>
            <button class="accept-call" onclick="acceptCall()">Accept</button>
            <button class="decline-call" onclick="closeCall()">Decline</button>
        </div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMr819bh0zkoq_K8aqoeaH4-h_TJIpNN0&callback=initMap" async defer></script>
    <script>
        function initMap() {
            const mapOptions = {
                center: { lat: -6.200000, lng: 106.816666 },
                zoom: 13
            };
            const map = new google.maps.Map(document.getElementById("map"), mapOptions);
        }

        // Modal Chat Functions
        function openChat() {
            document.getElementById("chatModal").style.display = "flex";
        }

        function closeChat() {
            document.getElementById("chatModal").style.display = "none";
        }

        function sendMessage() {
            const input = document.getElementById("chatInput");
            const message = input.value.trim();

            if (message) {
                const chatMessages = document.getElementById("chatMessages");

                // Create new message element
                const messageElement = document.createElement("div");
                messageElement.textContent = "You: " + message;
                messageElement.classList.add("message");

                // Add message to chatMessages
                chatMessages.appendChild(messageElement);

                // Clear input and scroll to the bottom
                input.value = "";
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }

        // Modal Call Functions
        function openCall() {
            document.getElementById("callModal").style.display = "flex";
        }

        function closeCall() {
            document.getElementById("callModal").style.display = "none";
        }

        function acceptCall() {
            alert("You accepted the call.");
            closeCall();
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const chatModal = document.getElementById("chatModal");
            const callModal = document.getElementById("callModal");
            if (event.target === chatModal) {
                chatModal.style.display = "none";
            } else if (event.target === callModal) {
                callModal.style.display = "none";
            }
        };
    </script>
</body>
</html>
