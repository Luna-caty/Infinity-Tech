<?php
require_once '../register/database.php';

// Vérifier si l'ID est valide
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de produit manquant");
}
$product_id = intval($_GET['id']);

// Récupérer les données du produit
$query = "SELECT * FROM products WHERE id_product = $product_id";
$result = mysqli_query($connection, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Produit introuvable");
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name'], $_POST['prix'], $_POST['type'])) {
        $name = mysqli_real_escape_string($connection, $_POST['name']);
        $price = floatval($_POST['prix']);
        $category = mysqli_real_escape_string($connection, $_POST['type']);

        $update_query = "UPDATE products SET name='$name', prix='$price', type='$category' WHERE id_product=$product_id";

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
    <p>Edit Product</p>
    <form method="POST" class="edit-form">
        <label>Nom :</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

        <label>Prix :</label>
        <input type="number" name="price" step="0.01" value="<?php echo htmlspecialchars($product['prix']); ?>" required>

        <label>Catégorie :</label>
        <input type="text" name="category" value="<?php echo htmlspecialchars($product['type']); ?>" required>

        <button type="submit">Mettre à jour</button>
    </form>

</body>

</html>