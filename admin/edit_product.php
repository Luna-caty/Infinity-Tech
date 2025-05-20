<?php
require_once '../register/database.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../home/home.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de produit manquant");
}
$product_id = intval($_GET['id']);

$query = "SELECT * FROM products WHERE id_product = $product_id";
$result = mysqli_query($connection, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Produit introuvable");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name'], $_POST['price'], $_POST['category'])) {
        $name = mysqli_real_escape_string($connection, $_POST['name']);
        $price = floatval($_POST['price']);
        $category = mysqli_real_escape_string($connection, $_POST['category']);
        $image = $product['image_principale']; 

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_name = basename($_FILES['image']['name']);
            $upload_dir = '../assets/';

            if (move_uploaded_file($image_tmp_name, $upload_dir . $image_name)) {
                $image = $image_name; 
            } else {
                echo "Erreur lors du téléchargement de l'image.";
            }
        }

        $update_query = "UPDATE products 
                         SET name='$name', prix='$price', type='$category', image_principale='$image' 
                         WHERE id_product=$product_id";

        if (mysqli_query($connection, $update_query)) {
            header("Location: admin.php");
            exit();
        } else {
            echo "Erreur lors de la mise à jour";
        }
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
    <link rel="stylesheet" href="edit.css">
    <link rel="icon" href="../assets/icon2.png" type="image/png">

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
    <p id="editP">Edit Product</p>
    <div class="edit-form">
        <form method="POST" enctype="multipart/form-data">
        <img src="../assets/<?php echo htmlspecialchars($product['image_principale']); ?>" alt="Product Image" style="max-width: 150px; margin-left:100px">
            <label>Changer l'image :</label>
            <input type="file" name="image">
            <label>Nom :</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

            <label>Prix :</label>
            <input type="number" name="price" step="0.01" value="<?php echo htmlspecialchars($product['prix']); ?>" required>

            <label>Catégorie :</label>
            <input type="text" name="category" value="<?php echo htmlspecialchars($product['type']); ?>" required>

            <div>
                <button type="submit" class="edit-btn">Mettre à jour</button>
                <a href="admin.php" class="cancel-button" style="text-decoration: none;">Annuler</a>
            </div>
        </form>

    </div>

</body>

</html>