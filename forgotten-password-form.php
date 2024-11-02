<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel="stylesheet" type="text/css" href="forgotten-password-form.css">
</head>
<body>
    <div class="content">
        <form method="POST" action="reset-password.php" id="forgotPasswordForm">
            <h1>Forgot Password</h1>

            <!-- Error or Success Messages -->
            <?php if (isset($_SESSION['message'])) : ?>
                <div class="message <?php echo $_SESSION['message_type']; ?>">
                    <?php echo htmlspecialchars($_SESSION['message']); ?>
                </div>
                <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
            <?php endif; ?>

            <!-- Email Input -->
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email" class="email">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn">Submit</button>
        </form>
    </div>

    <!-- JavaScript for Client-Side Validation -->
    <script>
        document.getElementById('forgotPasswordForm').addEventListener('submit', function(event) {
            const emailField = document.getElementById('email');
            if (!emailField.value.trim()) {
                alert('Please enter your email.');
                emailField.focus();
                event.preventDefault();
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailField.value)) {
                alert('Please enter a valid email address.');
                emailField.focus();
                event.preventDefault();
            }
        });
    </script>
</body>
</html>
