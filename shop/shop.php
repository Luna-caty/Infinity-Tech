<?php
require_once '../register/database.php';
$select = "SELECT * FROM products";
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
    <?php include '../reusables/navbar.php'; ?>
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
            echo '<a href="../productDetail/product_detail.php?id=' . htmlspecialchars($row['id_product']) . '" class="see-more-btn">See more</a>';
            echo '</div>';
        }
        ?>
        <?php include '../reusables/footer.php'; ?>
</body>

</html>