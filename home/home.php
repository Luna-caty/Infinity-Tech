<?php
require_once '../register/database.php';

$random_query = "SELECT * FROM products ORDER BY RAND() LIMIT 3";
$random_result = mysqli_query($connection, $random_query);

?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infnity-Tech</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
</head>

<body>
    <?php include '../reusables/navbar.php'; ?>
    <div class="hero animate-on-load">
        <div class="hero-texts">
            <p id="hero1">InfinityTech – The Ultimate Electronics & IT Store</p>
            <p id="hero2">Discover a wide range of products: computers, phones, peripherals, storage, and more</p>
            <div>
                <a href="../shop/shop.php" id="callToAction">Shop Now</a>
            </div>
        </div>
        <img src="../assets/hero.png" alt="hero" class="hero-image">
    </div>

    <div class="categories animate-on-load">
        <p id="categories-title">Our Categories</p>
        <div class="product-cards">
            <div class="product-card">
                <img src="../assets/laptop.png" alt="Laptop" class="product-image">
                <div class="product-info">
                    <h2 class="categorie-name">Laptop</h2>
                    <a href="../shop/shop.php?type=laptop" class="shop-now-btn">Shop Now</a>
                </div>
            </div>

            <div class="product-card">
                <img src="../assets/phones.png" alt="Phone" class="product-image">
                <div class="product-info">
                    <h2 class="categorie-name">Phone</h2>
                    <a href="../shop/shop.php?type=smartphone" class="shop-now-btn">Shop Now</a>
                </div>
            </div>

            <div class="product-card">
                <img src="../assets/accessoires.png" alt="accessoires" class="product-image">
                <div class="product-info">
                    <h2 class="categorie-name">Accessoires</h2>
                    <a href="../shop/shop.php?type=accessoire" class="shop-now-btn">Shop Now</a>
                </div>
            </div>

            <div class="product-card">
                <img src="../assets/components.png" alt="components" class="product-image">
                <div class="product-info">
                    <h2 class="categorie-name">Stockage & Composants</h2>
                    <a href="../shop/shop.php?type=composant" class="shop-now-btn">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
    <h2 class="best-seller-title animate-on-load">BEST SELLER</h2>
    <section class="best-seller-section animate-on-load">

        <?php
        if (mysqli_num_rows($random_result) > 0) {
            while ($row = mysqli_fetch_assoc($random_result)) {
                echo '<div class="best-seller-products">';
                echo ' <div class="bestSeller-card">';
                echo '<img src="../assets/' . htmlspecialchars($row['image_principale']) . '" alt="' . htmlspecialchars($row['name']) . '" class="product-image">';
                echo '<h3 class="product-name">' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p class="product-price">' . number_format($row['prix'], 2, ',', ' ') . '€</p>';
                echo '<div class="bestSeller-btn">';
                echo '<a href="../productDetail/product_detail.php?id=' . htmlspecialchars($row['id_product']) . '" class="details-btn">See more</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p class="no-products">No products found matching your criteria.</p>';
        }
        ?>

    </section>
    <?php include '../reusables/footer.php'; ?>
</body>

</html>