<?php
require_once '../register/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../register/signIn.php");
    exit;
}

// Gestion de l'ajout au panier
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = intval($_POST['product_id']);

    // Vérifier si le produit existe déjà dans le panier
    $check_query = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Produit existe déjà, incrémenter la quantité
        $update_query = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $product_id";
        mysqli_query($connection, $update_query);
    } else {
        // Nouveau produit, l'ajouter au panier
        $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)";
        mysqli_query($connection, $insert_query);
    }

    // Stocker un message de confirmation dans la session
    $_SESSION['cart_message'] = "Produit ajouté au panier!";

    // Recharger la page sans redirection
    header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $product_id);
    exit();
}
// Récupération des détails du produit
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
    <link rel="icon" href="../assets/icon2.png" type="image/png">

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
            <!-- Formulaire qui pointe vers la page courante -->
            <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . htmlspecialchars($product_id); ?>" method="POST">
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
                <button id="add-to-cart" type="submit" style="text-decoration: none; color: white;">
                    Add to Cart <img src="../assets/whitecart.png" alt="Icon Cart">
                </button>
            </form>
        </div>
    </div>
    <div class="product_more_details">
        <p class="product_details_title">
            Description Detailée :
        </p>
        <div class="more_details_content">
            <?php
            if ($product['type'] == 'laptop') {
                echo "CPU: " . $product_details['cpu'] . "<br>";
                echo "GPU: " . $product_details['gpu'] . "<br>";
                echo "RAM: " . $product_details['ram'] . "<br>";
                echo "Stockage: " . $product_details['stockage'] . "<br>";
                echo "Ecran: " . $product_details['ecran'] . "<br>";
                echo "Batterie: " . $product_details['batterie'] . "<br>";
                echo "Design: " . $product_details['design'] . "<br>";
                echo "Poids: " . $product_details['poids'] . "<br>";
            } elseif ($product['type'] == 'smartphone') {
                echo "Processeur: " . $product_details['processeur'] . "<br>";
                echo "Ecran : " . $product_details['ecran'] . "<br>";
                echo "RAM: " . $product_details['ram'] . "<br>";
                echo "Stockage: " . $product_details['stockage'] . "<br>";
                echo "Appereil Photo :" . $product_details['appareil_photo'] . "<br>";
                echo "Batterie: " . $product_details['batterie'] . "<br>";
                echo "Securité : " . $product_details['securite'] . "<br>";
                echo "Design : " . $product_details['design'] . "<br>";
                echo "Dimensions : " . $product_details['dimensions'] . "<br>";
                echo "Poids : " . $product_details['poids'] . "<br>";
            } elseif ($product['type'] == 'accessoire') {
                echo "Type: " . $product_details['type_accessoire'] . "<br>";
                echo "Compatibilité: " . $product_details['compatibilite'] . "<br>";
                echo "Specifications: " . $product_details['specifications'] . "<br>";
            } elseif ($product['type'] == 'composant') {
                echo "Marque: " . $product_details['marque'] . "<br>";
                echo "Type du Composant : " . $product_details['type_composant'] . "<br>";
                echo "Specifications: " . $product_details['specifications'] . "<br>";
                if (is_null($product_details['capacite'])) {
                    echo "Capacité: // <br>";
                } else {
                    echo "Capacité: " . $product_details['capacite'] . "<br>";
                }
                echo "Compatibilité: " . $product_details['compatibilite'] . "<br>";
            }
            ?>
        </div>
    </div>
    <?php include '../reusables/footer.php'; ?>
</body>

</html>