<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OJEKKU - Register Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css"> <!-- External CSS Library -->
    <link rel="stylesheet" type="text/css" href="register.css"> <!-- Custom CSS File -->
</head>

<body>
    <div class="register-box">
        <a class="logo" href="index.php">OJEKKU</a>
        <h2>Register</h2>

        <!-- Error Message Placeholder -->
        <?php
        if (isset($_GET['error']) && $_GET['error'] == 'true') : ?>
            <div class="message error">Invalid input. Please try again.</div>
        <?php endif; ?>

        <form id="registerForm" method="POST" action="SignUpValidation.php">
            <div class="input-group">
                <input type="text" name="username" id="username" required>
                <label for="username">Username</label>
            </div>

            <div class="input-group">
                <input type="email" name="email" id="email" required>
                <label for="email">Email</label>
            </div>

            <div class="input-group">
                <input type="password" name="password" id="password" required>
                <label for="password">Password</label>
            </div>

            <div class="input-group">
                <input type="password" name="password_confirm" id="confirmPassword" required>
                <label for="confirmPassword">Confirm Password</label>
            </div>

            <button type="submit" class="btnsubmit">Sign Up</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="login.php">Login here</a>
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

        // Initialize check for filled inputs
        checkInput(document.getElementById('username'));
        checkInput(document.getElementById('email'));
    </script>
</body>
</html>
