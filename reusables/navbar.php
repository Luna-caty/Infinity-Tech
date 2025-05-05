<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../register/database.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
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

        .user-dropdown {
            position: relative;
            display: inline-block;
        }

        .welcome-message {
            color: #124e8b;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: opacity 0.3s ease;
        }

        .welcome-message:hover {
            opacity: 0.8;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            border-radius: 4px;
        }

        .dropdown-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 14px;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .user-dropdown:hover .dropdown-content {
            display: block;
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
                <li> <a href="../order/order_history.php">Mes Commandes</a></li>
            </ul>
            <div class="nav_actions">
                <a href="../cart/cart.php" style="text-decoration: none;">
                    <img src="../assets/cart.png" alt="cart" class="cart-icon">
                </a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <div class="user-dropdown">
                        <span class="welcome-message">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        <div class="dropdown-content">
                            <a href="../register/logout.php">Logout</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="../register/signUp.php" class="register-btn">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</body>

</html>