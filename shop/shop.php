<?php
require_once '../register/database.php';


$category = isset($_GET['type']) ? $_GET['type'] : '';
if (isset($_POST['category']) && $_POST['category'] != '') {
    $category = $_POST['category'];
}
$price_order = isset($_POST['price']) ? $_POST['price'] : '';
$alphabetical_order = isset($_POST['alphabetical']) ? $_POST['alphabetical'] : '';

$select = "SELECT * FROM products where 1";

if (!empty($category)) {
    $select .= " AND type = '" . mysqli_real_escape_string($connection, $category) . "'";
}

if (!empty($price_order)) {
    if ($price_order == 'low-to-high') {
        $select .= " ORDER BY prix ASC";
    } elseif ($price_order == 'high-to-low') {
        $select .= " ORDER BY prix DESC";
    }
} elseif (!empty($alphabetical_order)) {
    if ($alphabetical_order == 'a-to-z') {
        $select .= " ORDER BY name ASC";
    } elseif ($alphabetical_order == 'z-to-a') {
        $select .= " ORDER BY name DESC";
    }
} else {
    // ordre par defaut 
    $select .= " ORDER BY id_product ASC";
}

/*
On utilise '.=' pour ajouter des conditions et tris à la requête SQL
sans écraser les conditions précédentes.
par exemple:
avant l'ajout des conditions le $select =select *from products
apres si on ajoute un filtre de category laptop
donc c'est $select .= " WHERE type = 'laptop'";
et si on ajoute un filtre de tri de prix 
on aura :$select .= " ORDER BY prix ASC";
donc finalement la requete final sera 
SELECT * FROM products WHERE type = 'laptop' ORDER BY prix ASC;
donc le .= nous a aider a concatainer plusieurs requete pour avoir la requete final

*/

$show_products = mysqli_query($connection, $select);

// Vérification des erreurs de requête
if (!$show_products) {
    die("Erreur de requête: " . mysqli_error($connection));
}

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
    <link rel="icon" href="../assets/icon2.png" type="image/png">

</head>

<body>
    <?php include '../reusables/navbar.php'; ?>

    <form method="POST" action="shop.php" class="filter">
        <select name="category">
            <option value="" disabled <?= empty($category) ? 'selected' : '' ?>>Categories</option>
            <option value="laptop" <?= $category == 'laptop' ? 'selected' : '' ?>>Laptop</option>
            <option value="smartphone" <?= $category == 'smartphone' ? 'selected' : '' ?>>smartPhones</option>
            <option value="accessorie" <?= $category == 'accessorie' ? 'selected' : '' ?>>Accessories</option>
            <option value="composant" <?= $category == 'composant' ? 'selected' : '' ?>>Composants</option>
        </select>
        <select name="price">
            <option value="" disabled selected>Price</option>
            <option value="low-to-high" <?= $price_order == 'low-to-high' ? 'selected' : '' ?>>Low to High</option>
            <option value="high-to-low" <?= $price_order == 'high-to-low' ? 'selected' : '' ?>>High to Low</option>
        </select>
        <select name="alphabetical">
            <option value="" disabled selected>Alphabetical</option>
            <option value="a-to-z" <?= $alphabetical_order == 'a-to-z' ? 'selected' : '' ?>>A to Z</option>
            <option value="z-to-a" <?= $alphabetical_order == 'z-to-a' ? 'selected' : '' ?>>Z to A</option>
        </select>
        <input type="submit" value="Filter" id="filter-btn">
    </form>

    <div class="products">
        <?php
        if (mysqli_num_rows($show_products) > 0) {
            while ($row = mysqli_fetch_assoc($show_products)) {
                echo '<div class="product-card">';
                echo '<img src="../assets/' . htmlspecialchars($row['image_principale']) . '" alt="' . htmlspecialchars($row['name']) . '" class="product-image">';
                echo '<h3 class="product-name">' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p class="product-price">' . number_format($row['prix'], 2, ',', ' ') . '€</p>';
                echo '<a href="../productDetail/product_detail.php?id=' . htmlspecialchars($row['id_product']) . '" class="see-more-btn">See more</a>';
                echo '</div>';
            }
        } else {
            echo '<p class="no-products">No products found matching your criteria.</p>';
        }
        ?>
    </div>

    <?php include '../reusables/footer.php'; ?>
</body>

</html>