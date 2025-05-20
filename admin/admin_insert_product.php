<?php
require_once '../register/database.php'; 
session_start();
if (isset($_POST['add-product'])) {
    echo 'Soumission reçue<br>';

    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image_name = '';

    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $image_name = basename($_FILES['product_image']['name']);
        $temp_name = $_FILES['product_image']['tmp_name'];
        $destination = "../assets/" . $image_name;

        if (!move_uploaded_file($temp_name, $destination)) {
            die("Erreur lors du téléchargement de l'image.");
        }
    } else {
        die("Aucune image téléchargée ou erreur dans le fichier.");
    }

    $add_query = "INSERT INTO products (name, prix, image_principale, type) VALUES ('$name', '$price', '$image_name', '$category')";
    $add_product = mysqli_query($connection, $add_query) or die("Erreur SQL PRODUIT : " . mysqli_error($connection));
    $id_product = mysqli_insert_id($connection);


    if ($category == 'laptop') {
        $marque = $_POST['marque'];
        $cpu = $_POST['cpu'];
        $gpu = $_POST['gpu'];
        $ram = $_POST['ram'];
        $stockage = $_POST['stockage'];
        $screen = $_POST['screen'];
        $battery = $_POST['battery'];
        $design = $_POST['design'];
        $OS = $_POST['OS'];
        $weight = $_POST['weight'];
        $description = $_POST['description'];

        $add_query2 = "INSERT INTO laptops (name, marque, cpu, gpu, ram, stockage, ecran, batterie, design, systeme_exploitation, poids, description, prix, image_principale,id_product)
                       VALUES ('$name', '$marque', '$cpu', '$gpu', '$ram', '$stockage', '$screen', '$battery', '$design', '$OS', '$weight', '$description', '$price', '$image_name',' $id_product')";
    } elseif ($category == 'smartphone') {
        $marque = $_POST['marque'];
        $processeur = $_POST['processeur'];
        $ecran = $_POST['ecran'];
        $ram = $_POST['ram'];
        $stockage = $_POST['stockage'];
        $appareil_photo = $_POST['appareil_photo'];
        $batterie = $_POST['batterie'];
        $securite = $_POST['securite'];
        $design = $_POST['design'];
        $dimensions = $_POST['dimensions'];
        $poids = $_POST['poids'];
        $description = $_POST['description'];

        $add_query2 = "INSERT INTO smartphones (name, marque, processeur, ecran, ram, stockage, appareil_photo, batterie, securite, design, dimensions, poids, description, prix, image_principale,id_product)
                       VALUES ('$name', '$marque', '$processeur', '$ecran', '$ram', '$stockage', '$appareil_photo', '$batterie', '$securite', '$design', '$dimensions', '$poids', '$description', '$price', '$image_name','$id_product')";
    } elseif ($category == 'accessoire') {
        $marque = $_POST['marque'];
        $type_accessoire = $_POST['type_accessoire'];
        $specifications = $_POST['specifications'];
        $compatibilite = $_POST['compatibilite'];
        $description = $_POST['description'];

        $add_query2 = "INSERT INTO accessoires (name, marque, type, specifications, compatibilite, description, prix, image_principale, id_product)
                       VALUES ('$name', '$marque', '$type_accessoire', '$specifications', '$compatibilite', '$description', '$price', '$image_name','$id_product')";
    } elseif ($category == 'composant') {
        $marque = $_POST['marque'];
        $type_composant = $_POST['type_composant'];
        $capicite = $_POST['capicite'];
        $specifications = $_POST['specifications'];
        $compatibilite = $_POST['compatibilite'];
        $description = $_POST['description'];

        $add_query2 = "INSERT INTO stockage_composants (name, marque, type_composant, capacite, specifications, compatibilite, description, prix, image_principale,id_product)
                       VALUES ('$name', '$marque', '$type_composant', '$capicite', '$specifications', '$compatibilite', '$description', '$price', '$image_name','$id_product')";
    }

    if (isset($add_query2)) {
        $add_product_details = mysqli_query($connection, $add_query2) or die("Erreur SQL DÉTAILS : " . mysqli_error($connection));
    }

    header("Location: admin.php");
    exit();
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

    <div class="product-form-container">
        <h2>Add New Product</h2>
        <form action="admin_insert_product.php" method="POST" class="product-form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" id="product_name" name="name"  placeholder="Enter product name">
            </div>

            <div class="form-group">
                <label for="product_price">Price (€)</label>
                <input type="number" id="product_price" name="price" step="0.01" min="0"  placeholder="0.00">
            </div>

            <div class="form-group">
                <label for="product_category">Category</label>
                <div class="radio-group">
                    <div>
                        <input type="radio" id="laptop" name="category" value="laptop" >
                        <label for="laptop">Laptop</label>
                    </div>
                    <div>
                        <input type="radio" id="smartphone" name="category" value="smartphone" >
                        <label for="smartphone">Smartphone</label>
                    </div>
                    <div>
                        <input type="radio" id="accessoire" name="category" value="accessoire" >
                        <label for="accessoire">Accessoire</label>
                    </div>
                    <div>
                        <input type="radio" id="composant" name="category" value="composant" >
                        <label for="composant">Stockage et Composant</label>
                    </div>
                </div>
            </div>
            <div class="product-details-form">
                <div class="PC_more_details">
                    <h3 id="more-detail-text">More details for PC </h3>

                    <label for="marque"> Marque </label>
                    <input type="text" id="marque" name="marque"  placeholder="Enter Marque details">
                    <br>
                    <label for="cpu"> CPU </label>
                    <input type="text" id="cpu" name="cpu"  placeholder="Enter CPU details">
                    <br>
                    <label for="gpu"> GPU </label>
                    <input type="text" id="gpu" name="gpu"  placeholder="Enter GPU details">
                    <br>
                    <label for="ram"> Ram </label>
                    <input type="text" id="ram" name="ram"  placeholder="Enter Ram details">
                    <br>
                    <label for="Stockage"> Stockage </label>
                    <input type="text" id="stockage" name="stockage"  placeholder="Enter stockage details">
                    <br>
                    <label for="screen"> Screen </label>
                    <input type="text" id="screen" name="screen"  placeholder="Enter screen details">
                    <br>
                    <label for="battery"> Battery </label>
                    <input type="text" id="battery" name="battery"  placeholder="Enter battery details">
                    <label for="design"> Design </label>
                    <input type="text" id="design" name="design"  placeholder="Enter design details">
                    <label for="OS"> OS </label>
                    <input type="text" id="OS" name="OS"  placeholder="Enter Operating system">
                    <label for="weight"> Weight </label>
                    <input type="text" id="weight" name="weight"  placeholder="Enter weight details">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"  placeholder="Enter product description"></textarea>
                </div>




                <div class="Phones_more_details">
                    <h3 id="more-detail-text">More details for Phones </h3>

                    <label for="marque">Marque</label>
                    <input type="text" id="marque" name="marque"  placeholder="Entrez la marque">
                    <br>
                    <label for="processeur">Processeur</label>
                    <input type="text" id="processeur" name="processeur"  placeholder="Entrez les détails du processeur">
                    <br>
                    <label for="ecran">Écran</label>
                    <input type="text" id="ecran" name="ecran"  placeholder="Entrez les détails de l'écran">
                    <br>
                    <label for="ram">RAM</label>
                    <input type="text" id="ram" name="ram"  placeholder="Entrez les détails de la RAM">
                    <br>
                    <label for="stockage">Stockage</label>
                    <input type="text" id="stockage" name="stockage"  placeholder="Entrez les détails du stockage">
                    <br>
                    <label for="appareil_photo">Appareil photo</label>
                    <input type="text" id="appareil_photo" name="appareil_photo"  placeholder="Entrez les détails de l'appareil photo">
                    <br>
                    <label for="batterie">Batterie</label>
                    <input type="text" id="batterie" name="batterie"  placeholder="Entrez les détails de la batterie">
                    <br>
                    <label for="securite">Sécurité</label>
                    <input type="text" id="securite" name="securite"  placeholder="Entrez les détails de sécurité">
                    <br>
                    <label for="design">Design</label>
                    <input type="text" id="design" name="design"  placeholder="Entrez les détails du design">
                    <br>
                    <label for="dimensions">Dimensions</label>
                    <input type="text" id="dimensions" name="dimensions"  placeholder="Entrez les dimensions">
                    <br>
                    <label for="poids">Poids</label>
                    <input type="text" id="poids" name="poids"  placeholder="Entrez le poids">
                    <br>
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"  placeholder="Entrez la description du produit"></textarea>
                </div>


                <div class="accessory_more_details">
                    <h3 id="more-detail-text">More details for Accessoires </h3>
                    <label for="marque">Marque</label>
                    <input type="text" id="marque" name="marque"  placeholder="Entrez la marque">
                    <br>
                    <label for="type_accessoire">Type</label>
                    <input type="text" id="type_accessoire" name="type_accessoire"  placeholder="Entrez le type d'accessoire">
                    <br>
                    <label for="specifications">Spécifications</label>
                    <textarea id="specifications" name="specifications" rows="4"  placeholder="Entrez les spécifications détaillées"></textarea>
                    <br>
                    <label for="compatibilite">Compatibilité</label>
                    <input type="text" id="compatibilite" name="compatibilite"  placeholder="Entrez les informations de compatibilité">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"  placeholder="Entrez la description du produit"></textarea>
                </div>

                <div class="composant_more_details">
                    <h3 id="more-detail-text">More details for Componants </h3>

                    <label for="marque">Marque</label>
                    <input type="text" id="marque" name="marque"  placeholder="Entrez la marque">
                    <br>
                    <label for="type_composant">Type Composant </label>
                    <input type="text" id="type_composant" name="type_composant"  placeholder="Entrez le type d'accessoire">
                    <br>
                    <label for="capicite">Capacite</label>
                    <input id="capicite" name="capicite" rows="4"  placeholder="Entrez la capicite détaillées (ou NULL)">
                    <br>
                    <label for="specifications">Spécifications</label>
                    <input id="specifications" name="specifications" rows="4"  placeholder="Entrez les spécifications détaillées">
                    <br>
                    <label for="compatibilite">Compatibilité</label>
                    <input type="text" id="compatibilite" name="compatibilite"  placeholder="Entrez les informations de compatibilité">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"  placeholder="Entrez la description du produit"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="product_image">Product Image</label>
                <input type="file" id="product_image" name="product_image" accept="image/*" >
                <p class="file-help">Accepted formats: JPG, PNG, WebP. Max size: 2MB</p>
            </div>
            <div class="form-actions">
                <input type="submit" class="add_btn" value="Add Product" name="add-product">
            </div>
        </form>
    </div>
    <script src="admin.js"></script>
</body>

</html>