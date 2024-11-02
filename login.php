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
    <link rel="stylesheet" type="text/css" href="login.css"> <!-- Link to external CSS file -->
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
