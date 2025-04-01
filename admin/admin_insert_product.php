<?php
require_once '../register/database.php';
if (isset($_POST['add-product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    // $description = $_POST ['description'];
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        // Obtenir le nom du fichier
        $image_name = $_FILES['product_image']['name'];
        $temp_name = $_FILES['product_image']['tmp_name'];
        // Déplacer le fichier vers le dossier des assets
        move_uploaded_file($temp_name, "../assets/" . $image_name);
    }
    $add_query = "INSERT INTO products (name,prix,image_principale,type) VALUES ('$name',' $price', ' $image_name' ,'$category')";
    $add_product = mysqli_query($connection, $add_query);
    // if ($add_product) {
    //     echo "<p style='color: green;'>Produit ajouté avec succès!</p>";
    // } else {
    //     echo "<p style='color: red;'>Erreur lors de l'ajout du produit.</p>";
    // }
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
    <link rel="stylesheet" href="admin.css.">
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
        </div>
    </nav>

    <div class="product-form-container">
        <h2>Add New Product</h2>
        <form action="admin_insert_product.php" method="POST" enctype="multipart/form-data" class="product-form">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" id="product_name" name="name" required placeholder="Enter product name">
            </div>

            <div class="form-group">
                <label for="product_price">Price (€)</label>
                <input type="number" id="product_price" name="price" step="0.01" min="0" required placeholder="0.00">
            </div>

            <div class="form-group">
                <label for="product_category">Category</label>
                <select id="product_category" name="category" required>
                    <option value="" disabled selected>Select a category</option>
                    <option value="laptops">Laptops</option>
                    <option value="smartphones">Smartphones</option>
                    <option value="accessoires">accessoires</option>
                    <option value="composants">composants</option>
                </select>
            </div>

            <!-- <div class="form-group">
                <label for="product_description">Description</label>
                <textarea id="product_description" name="description" rows="4" placeholder="Enter product description"></textarea>
            </div> -->

            <div class="form-group">
                <label for="product_image">Product Image</label>
                <input type="file" id="product_image" name="product_image" accept="image/*" required>
                <p class="file-help">Accepted formats: JPG, PNG, WebP. Max size: 2MB</p>
            </div>
            <div class="form-actions">
                <input type="submit" class="add_btn" value="Add Product" name="add-product">
            </div>
        </form>
    </div>
</body>

</html>