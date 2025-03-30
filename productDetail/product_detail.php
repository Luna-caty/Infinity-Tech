<?php
require_once '../register/database.php';
// le 'id ' est celui qu'il a dans l'url 

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $query = "SELECT * FROM products WHERE id_product = $product_id";
    $result = mysqli_query($connection, $query);


    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        switch ($product['type']) {
            case 'laptop':
                $select_query = "SELECT * FROM laptops WHERE id_product = $product_id";
                break;
            case 'smartphone':
                $select_query = "SELECT * FROM smartphones WHERE id_product = $product_id";
                break;
            case 'accessoire':
                $select_query = "SELECT * FROM accessoires WHERE id_product = $product_id";
                break;
            case 'composant':
                $select_query = "SELECT * FROM stockage_composants WHERE id_product = $product_id";
                break;
            default:
                $select_query = null;
                break;
        }
        if ($select_query) {
            $select_query = mysqli_query($connection, $select_query);
            if ($select_query && mysqli_num_rows($select_query) > 0) {
                $product_details = mysqli_fetch_assoc($select_query);
            } else {
                $product_details = null;
            }
        }
    } else {
        echo "Product not found.";
        exit;
    }
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
    <link rel="stylesheet" href="product_detail.css">
</head>

<body>
    <?php include '../reusables/navbar.php'; ?>
    <div class="product-detail">
        <div class="product-image">
            <?php
            echo '<img src="../assets/' . htmlspecialchars($product_details['image_principale']) . '" alt="' . htmlspecialchars($product_details['name']) . '" class="product-image">';
            ?>
        </div>
        <div class="product-description">
            <p id="product-name">
                <?php
                echo $product['name'];
                ?>
            </p>
            <p id="product-text">
                <?php
                echo $product_details['description'];
                ?>
            </p>
            <p id="product-price">
                <?php
                echo $product['prix'] . "€";
                ?>
            </p>
            <div>
                <button id="add-to-cart">Add to Cart <img src="../assets/whitecart.png"> </button>
            </div>
        </div>
    </div>
    <?php include '../reusables/footer.php'; ?>
</body>

</html>