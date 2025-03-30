<?php
require_once '../register/database.php';
$select = "SELECT name,prix,image_principale FROM products";
$show_products = mysqli_query($connection, $select);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infinity-Tech</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="shop.css">
</head>

<body>
    <nav>
        <div class="navbar">
            <div class="logo">
                <img src="../assets/logo.png" alt="logo">
                <span>Infinity-Tech</span>

            </div>
            <ul class="nav-menu">
                <li><a href="home.php">Home</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="accessoires.php">Accessoires</a></li>
                <li><a href="laptops.php">Laptops</a></li>
            </ul>
            <div class="nav_actions">
                <img src="../assets/cart.png" alt="cart" class="cart-icon">
                <a href="../register/signUp.php" class="register-btn">Register</a>
            </div>
        </div>
    </nav>
    <div class="filter">
        <div class="by-category">
            <select name="category" id="category">
                <option value="" disabled selected>Categories</option>
                <option value="laptops">Laptops</option>
                <option value="phones">Phones</option>
                <option value="accessories">Accessories</option>
                <option value="storage">Storage</option>
            </select>
        </div>

        <div class="by-price">
            <select name="price" id="price">
                <option value="" disabled selected>Price</option>
                <option value="low-to-high">Low to High</option>
                <option value="high-to-low">High to Low</option>
            </select>
        </div>

        <div class="by-alphabetical">
            <select name="alphabetical" id="alphabetical">
                <option value="" disabled selected>Alphabetical</option>
                <option value="a-to-z">A to Z</option>
                <option value="z-to-a">Z to A</option>
            </select>
        </div>
        <div class="filter-btn">
            <input type="button" value="Filter" id="filter-btn">
        </div>
    </div>
    <div class="products">
        <?php
        while ($row = mysqli_fetch_assoc($show_products)) {
            echo '<div class="product-card">';
            echo '<img src="../assets/' . htmlspecialchars($row['image_principale']) . '" alt="' . htmlspecialchars($row['name']) . '" class="product-image">';
            echo '<h3 class="product-name">' . htmlspecialchars($row['name']) . '</h3>';
            echo '<p class="product-price">' . number_format($row['prix'], 2, ',', ' ') . '€</p>';
            echo '<a href="#" class="see-more-btn">See more</a>';
            echo '</div>';
        }
        ?>
    </div>
    <footer>
        <div class="footer-container">
            <div class="footer-left">
                <div class="footer-logo">
                    <img src="../assets/whiteLogo.png" alt="InfinityTech Logo">
                    <span class="footer-logo-text">InfinityTech</span>
                </div>
                <p class="footer-description">
                    Votre boutique en ligne en électronique et informatique.
                    Retrouvez une sélection de PC, smartphones et accessoires high-tech de qualité, avec un service client à votre écoute.
                </p>
            </div>

            <div class="quick-links">
                <h3>Quick Links</h3>
                <a href="home.php">Home</a>
                <a href="about.php">About us</a>
                <a href="contact.php">Contact us</a>
            </div>

            <div class="get-in-touch">
                <h3>Get In Touch</h3>
                <p class="getitTouchP"> find us in social</p>
                <div class="social-icons">
                    <img src="../assets/social media.png" alt="social media">
                </div>
                <div class="payment-icons">
                    <img src="../assets/payment.png" alt="payment methods">
                </div>
            </div>
        </div>
        <div class="copyright">
            <p id="copyright-text">
                &copy;Copyright 2025 InfinityTech. All Rights Reserved
            </p>
        </div>
    </footer>
</body>

</html>