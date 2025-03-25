<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="signInStyle.css">
</head>

<body>
    <div class="signInForm">
        <p id="signInP1">
            Create an account
        </p>
        <p id="signInP2">
            Join InfinityTech and access the best high-tech deals.
        </p>
        <form action="signIn.php" method="post">
            <div class="name">
                <input type="text" name="firstName" id="firstName" placeholder="First Name" required>
                <br>
                <input type="text" name="lastName" id="lastName" placeholder="Last Name" required>
            </div>
            <br>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <br>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <br>
            <input type="password" name="password" id="password" placeholder="confirme Password" required>
            <br>
            <div class="button">
                <button type="submit" id="registerButton">Create account</button>
            </div>
            <br>
            <p id="signUptext">already have one ?<a href="signIn.php" id="signUpLink">Sign up </a></p>
    </div>
</body>

</html>