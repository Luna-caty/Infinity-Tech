<?php
session_start();
require_once 'database.php';

if (isset($_POST["signin"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $select = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($connection, $select);
    $error = [];

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Vérifie le mot de passe
        if ($password == $user['password']) {

            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['user_name'] = $user['first_name'];

            if ($user['role'] == 'admin') {
                $_SESSION['is_admin'] = true;
                header("Location: ../admin/admin.php");
                exit();
            } else {
                header("Location: ../home/home.php");
                exit();
            }
            exit();
        } else {
            $error[] = 'Password is incorrect';
        }
    } else {
        $error[] = 'Email does not exist';
    }
}
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
    <link rel="stylesheet" href="register.css">
    <link rel="icon" href="../assets/icon2.png" type="image/png">
</head>

<body>
    <div class="signInForm">
        <p id="signInP1SignIn">
            Welcome Back
        </p>
        <p id="signInP2">
            Let’s get you back to shopping
        </p>
        <?php
        if (isset($error)) {
            foreach ($error as $error) {
                echo '<p class ="error-msg"> ' . $error . '  </p>';
            }
        };
        ?>
        <form action="signIn.php" method="post">
            <input type="email" name="email" id="email" placeholder="Email" required>
            <br>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <br>
            <div class="button">
                <input type="submit" value="Sign in" id="registerButton" name="signin">
            </div>

            <br>
            <p id="signUptext">Don't have an account? <a href="signUp.php" id="signUpLink">Sign up </a></p>
    </div>
</body>

</html>