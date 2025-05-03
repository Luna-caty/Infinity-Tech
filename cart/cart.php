<?php
require_once '../register/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../register/SignIn.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['product_id']) && isset($_POST['action'])) {
        $product_id = intval($_POST['product_id']);
        $action = $_POST['action'];

        switch ($action) {
            case 'add':
                $check_query = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";
                $check_result = mysqli_query($connection, $check_query);

                if (mysqli_num_rows($check_result) > 0) {
                    $update_query = "UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $product_id";
                    mysqli_query($connection, $update_query);
                } else {
                    $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)";
                    mysqli_query($connection, $insert_query);
                }
                break;

            case 'update':
                if (isset($_POST['quantity'])) {
                    $quantity = intval($_POST['quantity']);
                    if ($quantity > 0 && $quantity <= 10) {
                        $update_query = "UPDATE cart SET quantity = $quantity WHERE user_id = $user_id AND product_id = $product_id";
                        mysqli_query($connection, $update_query);
                    }
                }
                break;

            case 'remove':
                $delete_query = "DELETE FROM cart WHERE user_id = $user_id AND product_id = $product_id";
                mysqli_query($connection, $delete_query);
                break;
        }

        header("Location: cart.php");
        exit();
    }
}

$query = "SELECT p.id_product, p.name, p.prix, p.image_principale, c.quantity 
          FROM cart c
          JOIN products p ON c.product_id = p.id_product
          WHERE c.user_id = $user_id";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) === 0) {
    header("Location: emptyCart.php");
    exit();
}

$items = array();
$total = 0;
while ($item = mysqli_fetch_assoc($result)) {
    // Calcul avec valeurs brutes
    $subtotal = $item['prix'] * $item['quantity'];
    $total += $subtotal;

    // Formatage pour l'affichage
    $item['prix_formatted'] = number_format($item['prix'], 2);
    $item['subtotal_formatted'] = number_format($subtotal, 2);
    $items[] = $item;
}

$total_formatted = number_format($total, 2);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="cart.css">
    <link rel="icon" href="../assets/icon2.png" type="image/png">
</head>

<body>
    <?php include '../reusables/navbar.php'; ?>
    <div class="cart-container">
        <div class="cart-content">
            <?php if (!empty($items)): ?>
                <div class="cart-items">
                    <?php foreach ($items as $item): ?>
                        <div class="cart-item">
                            <div class="item-image">
                                <img src="../assets/<?php echo htmlspecialchars($item['image_principale']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                            </div>
                            <div class="item-details">
                                <div class="item-title"><?php echo htmlspecialchars($item['name']); ?></div>
                                <div class="item-price"><?php echo htmlspecialchars($item['prix_formatted']) . "€"; ?></div>
                                <div class="quantity-selector">
                                    <form method="post" action="cart.php" style="display: inline;">
                                        <input type="hidden" name="product_id" value="<?php echo $item['id_product']; ?>">
                                        <input type="hidden" name="action" value="update">
                                        <select name="quantity" onchange="this.form.submit()">
                                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                                <option value="<?php echo $i; ?>" <?php if ($i == $item['quantity']) echo 'selected'; ?>>
                                                    <?php echo $i; ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </form>
                                    <form method="post" action="cart.php" style="display: inline;">
                                        <input type="hidden" name="product_id" value="<?php echo $item['id_product']; ?>">
                                        <input type="hidden" name="action" value="remove">
                                        <button type="submit" class="remove-btn">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="cart-summary">
                    <div class="validate-order">
                        <a href="../order/order_details.php" class="validate-btn">Valider Commande</a>
                    </div>
                </div>
            <?php else: ?>
                <?php include 'empty_cart.php'; ?>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>