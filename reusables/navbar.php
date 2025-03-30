<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="navbar.css">
    <style>
    .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 5%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img {
            height: 40px;
        }

        .logo span {
            font-weight: 600;
            font-size: 1.2rem;
            color: #333;
        }

        .nav-menu {
            display: flex;
            gap: 30px;
            margin: 0;
            padding: 0;
            list-style-type: none;
        }

        .nav-menu a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-menu a:hover {
            color: #124e8b;
        }

        .nav_actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .cart-icon {
            height: 24px;
            cursor: pointer;
            padding-right: 50px;
        }

        .register-btn {
            text-decoration: none;
            color: #124e8b;
            font-weight: 600;
            font-size: 26px;
            transition: opacity 0.3s ease;
        }

        .register-btn:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <nav>
        <div class="navbar">
            <div class="logo">
                <img src="../assets/logo.png" alt="logo">
                <span>Infinity-Tech</span>

            </div>
            <ul class="nav-menu">
                <li><a href="../home/home.php">Home</a></li>
                <li><a href="../shop/shop.php">Shop</a></li>
                <li><a href="accessoires.php">Accessoires</a></li>
                <li><a href="laptops.php">Laptops</a></li>
            </ul>
            <div class="nav_actions">
                <img src="../assets/cart.png" alt="cart" class="cart-icon">
                <a href="../register/signUp.php" class="register-btn">Register</a>
            </div>
        </div>
    </nav>

</body>

</html>