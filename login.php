<!DOCTYPE html>
<html lang="en">

<?php
// Initialize variables for error handling
$is_invalid = false;

// Check if form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Include database connection file
    $sql = require("./database2.php");

    // Sanitize and prepare SQL query to prevent SQL injection
    $sqli = sprintf("SELECT * FROM users 
                     WHERE email = '%s'", 
                     $sql->real_escape_string($_POST["email"]));

    // Execute query and fetch user data
    $res = $sql->query($sqli);
    $user = $res->fetch_assoc();

    // Verify password if user exists
    if ($user) {
        if (password_verify($_POST["password"], $user["password"])) {
            session_start();
            session_regenerate_id();
            $_SESSION["user_id"] = $user["id"];
            header("Location: home.php");
            exit;
        }
    }

    // Set invalid flag if login fails
    $is_invalid = true;
}

// Google Sign-In setup
require("./vendor/autoload.php");
$client = new Google\Client();

$client->setClientId("YOUR_GOOGLE_CLIENT_ID");
$client->setClientSecret("YOUR_GOOGLE_CLIENT_SECRET");
$client->setRedirectUri("http://127.0.0.1:1234/home.php");

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OJEKKU - Login Form</title>
    <style>
        /* Styles for the page */
        * {
            font-family: 'Nunito', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(to top, rgb(0, 200, 0), rgba(144, 238, 144, 0.5));
            margin: 0;
        }

        .login-box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            width: 350px;
            text-align: center;
        }

        .logo {
            font-size: 32px;
            font-weight: bold;
            color: rgb(0, 150, 0);
            text-decoration: none;
            margin-bottom: 20px;
        }

        h2 {
            color: #333;
            font-size: 22px;
            margin: 10px 0;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        label {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            pointer-events: none;
            transition: 0.2s ease all;
            padding: 0 5px;
            background: white;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #f0f0f0;
            font-size: 16px;
            transition: border 0.3s ease, background 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            background: white;
            outline: none;
            border: 1px solid rgb(0, 150, 0);
            box-shadow: 0 4px 8px rgba(0, 150, 0, 0.2);
        }

        input:focus + label,
        input.filled + label {
            top: -8px;
            font-size: 12px;
            color: rgb(0, 150, 0);
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, rgb(0, 150, 0), rgb(144, 238, 144));
            color: white;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: linear-gradient(135deg, rgb(0, 130, 0), rgb(120, 220, 120));
        }

        .login-link,
        .forgot-password-link {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }

        .login-link a,
        .forgot-password-link a,
        .google-signin a {
            color: rgb(0, 150, 0);
            text-decoration: none;
            font-weight: bold;
        }

        .message {
            color: red;
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="login-box">
        <a class="logo" href="index.php">OJEKKU</a>
        <h2>Login</h2>

        <?php if ($is_invalid): ?>
            <div class="message">Invalid Credentials</div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <input type="text" name="username" id="username" value="<?= !isset($_POST["username"]) ? "" : htmlspecialchars($_POST["username"]) ?>" required onfocus="checkInput(this)" onblur="checkInput(this)">
                <label for="username">Username</label>
            </div>

            <div class="input-group">
                <input type="email" name="email" id="email" value="<?= !isset($_POST["email"]) ? "" : htmlspecialchars($_POST["email"]) ?>" required onfocus="checkInput(this)" onblur="checkInput(this)">
                <label for="email">Email</label>
            </div>

            <div class="input-group">
                <input type="password" name="password" id="password" required onfocus="checkInput(this)" onblur="checkInput(this)">
                <label for="password">Password</label>
            </div>

            <button type="submit">Login</button>
        </form>

        <div class="google-signin">
            <p><a href="<?= $url; ?>">Login with your Google Account</a></p>
        </div>

        <div class="forgot-password-link">
            <a href="./forgotten-password-form.php">Forgot Password?</a>
        </div>
    </div>

    <script>
        function checkInput(input) {
            if (input.value) {
                input.classList.add('filled');
            } else {
                input.classList.remove('filled');
            }
        }

        // Check initial values
        checkInput(document.getElementById('username'));
        checkInput(document.getElementById('email'));
        checkInput(document.getElementById('password'));
    </script>
</body>

</html>
