<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ojekku - Your Ride, Anytime, Anywhere</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <link rel = "stylesheet" type = "text/css" href = "../css/driver_register.css">
</head>
<body>
<div class = "content">
   <form action = "driver_SignUpValidation.php" method = "POST">
    <h2> Register Page </h2>
        <div>
            <label for = "username"> Username </label>
            <input type = "text" name = "username" class = "username"/>
        </div>

        <div>
            <label for = "email"> Email </label>
            <input type = "email" name = "email" class = "email"/>
        </div>

        <div>
            <label for = "password"> Password </label>
            <input type = "password" name = "password" class = "password"/>
        </div>

        <div>
            <label for = "password_confirm"> Confirm Password </label>
            <input type = "password" name = "confirmpassword" class ="confirm"/>
        </div>
            <button class = "btnsubmit" name = "submit"> Sign Up </button>
   </form>
</div>
</body>
</html>