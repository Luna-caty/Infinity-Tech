<?php
require_once '../register/database.php';

if (isset($_POST['delete_product']) && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $delete_query = "DELETE FROM products WHERE id_product = '" . $product_id . "'";
    $delete_result = mysqli_query($connection, $delete_query);
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
    <link rel="stylesheet" href="admin.css">
</head>

<body>
    <nav>
        <div class="navbar">
            <div class="logo">
                <img src="../assets/logo.png" alt="logo">
                <span>Infinity-Tech</span>
            </div>
            <ul class="nav-menu">
                <li><a href="../admin/admin.php">View Products</a></li>
                <li><a href="../admin/admin_insert_product.php">Insert Product</a></li>
            </ul>
            <!-- <div class="nav_actions">
                <img src="../assets/cart.png" alt="cart" class="cart-icon">
                <a href="../register/signUp.php" class="register-btn">Register</a>
            </div> -->
        </div>
    </nav>
    <p id="welcomeP"> Welcome To <span>Admin Panel</span>
    </p>
    <div class="product-table">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select = "SELECT * FROM products";
                $show_products = mysqli_query($connection, $select);
                while ($row = mysqli_fetch_assoc($show_products)) {
                    echo '<tr>';
                    echo '<td data-label="Product ID">' . htmlspecialchars($row['id_product']) . '</td>';
                    echo '<td data-label="Name">' . htmlspecialchars($row['name']) . '</td>';
                    echo '<td data-label="Price" class="price-column">' . number_format($row['prix'], 2, ',', ' ') . '€</td>';
                    echo '<td data-label="Category">' . htmlspecialchars($row['type']) . '</td>';
                    echo '<td data-label="Image"><img src="../assets/' . htmlspecialchars($row['image_principale']) . '" alt="' . htmlspecialchars($row['name']) . '" class="product-image"></td>';
                    echo '<td data-label="Actions">
                    <a href="../productDetail/product_detail.php?id=' . htmlspecialchars($row['id_product']) . '" class="see-more-btn">View</a>
                    <a href="edit_product.php?id=' . htmlspecialchars($row['id_product']) . '" class="edit-btn">Edit</a>
                    <form method="POST" action="admin.php" style="display: inline;">
                        <input type="hidden" name="product_id" value="' . htmlspecialchars($row['id_product']) . '">
                        <button type="submit" name="delete_product" class="delete-btn" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce produit?\');">Delete</button>
                    </form>
                  </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>


</html