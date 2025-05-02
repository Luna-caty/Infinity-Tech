<?php
require_once '../register/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../register/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['product_id']) && isset($_POST['action'])) {
        $product_id = intval($_POST['product_id']);
        $action = $_POST['action'];

        switch ($action) {
            case 'add':
                $check_stmt = mysqli_prepare($connection, "SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
                mysqli_stmt_bind_param($check_stmt, "ii", $user_id, $product_id);
                mysqli_stmt_execute($check_stmt);
                mysqli_stmt_store_result($check_stmt);

                if (mysqli_stmt_num_rows($check_stmt) > 0) {
                    mysqli_stmt_close($check_stmt);
                    $update_stmt = mysqli_prepare($connection, "UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
                    mysqli_stmt_bind_param($update_stmt, "ii", $user_id, $product_id);
                    mysqli_stmt_execute($update_stmt);
                    mysqli_stmt_close($update_stmt);
                } else {
                    mysqli_stmt_close($check_stmt);
                    $insert_stmt = mysqli_prepare($connection, "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
                    mysqli_stmt_bind_param($insert_stmt, "ii", $user_id, $product_id);
                    mysqli_stmt_execute($insert_stmt);
                    mysqli_stmt_close($insert_stmt);
                }
                break;

            case 'update':
                if (isset($_POST['quantity'])) {
                    $quantity = intval($_POST['quantity']);
                    if ($quantity > 0 && $quantity <= 10) {
                        $update_stmt = mysqli_prepare($connection, "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
                        mysqli_stmt_bind_param($update_stmt, "iii", $quantity, $user_id, $product_id);
                        mysqli_stmt_execute($update_stmt);
                        mysqli_stmt_close($update_stmt);
                    }
                }
                break;

            case 'remove':
                $delete_stmt = mysqli_prepare($connection, "DELETE FROM cart WHERE user_id = ? AND product_id = ?");
                mysqli_stmt_bind_param($delete_stmt, "ii", $user_id, $product_id);
                mysqli_stmt_execute($delete_stmt);
                mysqli_stmt_close($delete_stmt);
                break;

                case 'place_order':
                    $cart_stmt = mysqli_prepare($connection, "SELECT product_id, quantity FROM cart WHERE user_id = ?");
                    mysqli_stmt_bind_param($cart_stmt, "i", $user_id);
                    mysqli_stmt_execute($cart_stmt);
                    $cart_result = mysqli_stmt_get_result($cart_stmt);
                
                    if (mysqli_num_rows($cart_result) > 0) {
                        // Insère une commande vide
                        $insert_order_stmt = mysqli_prepare(
                            $connection,
                            "INSERT INTO orders (user_id, date_commande, total)
                             VALUES (?, NOW(), 0)"
                        );
                        mysqli_stmt_bind_param($insert_order_stmt, "i", $user_id);
                        mysqli_stmt_execute($insert_order_stmt);
                        mysqli_stmt_close($insert_order_stmt);
                
                        $order_id = mysqli_insert_id($connection);
                        $total = 0;
                
                        while ($row = mysqli_fetch_assoc($cart_result)) {
                            $product_id = $row['product_id'];
                            $quantity = $row['quantity'];
                
                            $price_stmt = mysqli_prepare($connection, "SELECT prix FROM products WHERE id_product = ?");
                            mysqli_stmt_bind_param($price_stmt, "i", $product_id);
                            mysqli_stmt_execute($price_stmt);
                            $price_result = mysqli_stmt_get_result($price_stmt);
                            $price_row = mysqli_fetch_assoc($price_result);
                            $unit_price = $price_row['prix'];
                            mysqli_stmt_close($price_stmt);
                
                            $subtotal = $quantity * $unit_price;
                            $total += $subtotal;
                
                            $insert_item_stmt = mysqli_prepare(
                                $connection,
                                "INSERT INTO order_items (order_id, product_id, quantity, prix_unitaire)
                                 VALUES (?, ?, ?, ?)"
                            );
                            mysqli_stmt_bind_param($insert_item_stmt, "iiid", $order_id, $product_id, $quantity, $unit_price);
                            mysqli_stmt_execute($insert_item_stmt);
                            mysqli_stmt_close($insert_item_stmt);
                        }
                
                        $update_total_stmt = mysqli_prepare($connection, "UPDATE orders SET total = ? WHERE id_order = ?");
                        mysqli_stmt_bind_param($update_total_stmt, "di", $total, $order_id);
                        mysqli_stmt_execute($update_total_stmt);
                        mysqli_stmt_close($update_total_stmt);
                
                        $delete_cart_stmt = mysqli_prepare($connection, "DELETE FROM cart WHERE user_id = ?");
                        mysqli_stmt_bind_param($delete_cart_stmt, "i", $user_id);
                        mysqli_stmt_execute($delete_cart_stmt);
                        mysqli_stmt_close($delete_cart_stmt);
                
                        // Version sûre et propre de la redirection
                        $redirect_url = "orderDetail/orderDetail.php?id=" . $order_id;
                        echo "<script>window.location.href = '" . $redirect_url . "';</script>";
                        // En cas où JavaScript est désactivé
                        echo "<meta http-equiv='refresh' content='0;url=" . $redirect_url . "'>";
                        // Redirection PHP comme fallback
                        header("Location: " . $redirect_url);
                        exit;
                    } else {
                        echo "Votre panier est vide.";
                    }
            mysqli_stmt_close($cart_stmt);
            break;
        }
        header("Location: cart.php");
        exit();
    }
}

$query_stmt = mysqli_prepare(
    $connection,
    "SELECT p.id_product, p.name, p.prix, p.image_principale, c.quantity 
     FROM cart c
     JOIN products p ON c.product_id = p.id_product
     WHERE c.user_id = ?"
);
mysqli_stmt_bind_param($query_stmt, "i", $user_id);
mysqli_stmt_execute($query_stmt);
$result = mysqli_stmt_get_result($query_stmt);
mysqli_stmt_close($query_stmt);

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

$last_order_stmt = mysqli_prepare($connection, "SELECT id_order FROM orders WHERE user_id = ? ORDER BY date_commande DESC LIMIT 1");
mysqli_stmt_bind_param($last_order_stmt, "i", $user_id);
mysqli_stmt_execute($last_order_stmt);
$last_order_result = mysqli_stmt_get_result($last_order_stmt);
mysqli_stmt_close($last_order_stmt);

$last_order_id = null;
if ($last_order_result && mysqli_num_rows($last_order_result) > 0) {
    $row = mysqli_fetch_assoc($last_order_result);
    $last_order_id = $row['id_order'];
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier - Infinity-Tech</title>
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
                                    <form method="post" action="cart.php" style="display: inline-flex; align-items: center;">
                                        <input type="hidden" name="product_id" value="<?php echo $item['id_product']; ?>">
                                        <input type="hidden" name="action" value="update">
                                        <button type="button" class="quantity-btn minus" onclick="this.form.quantity.value=Math.max(1, parseInt(this.form.quantity.value)-1); this.form.submit()">-</button>
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" max="10" style="width: 40px; text-align: center;" readonly>
                                        <button type="button" class="quantity-btn plus" onclick="this.form.quantity.value=Math.min(10, parseInt(this.form.quantity.value)+1); this.form.submit()">+</button>
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
                    <div class="summary-box">
                        <div class="summary-title">Summary</div>
                        <div class="summary-row summary-total">
                            <span>Total</span>
                            <span><?php echo $total_formatted; ?>€</span>
                        </div>
                        <div class="shipping-note">(Excluding Delivery)</div>
                    </div>
                    <div class="checkout-actions">
                        <?php if ($last_order_id): ?>
                            <a href="../orderDetail/orderDetail.php echo $last_order_id; ?>" class="checkout-btn">Voir détail commande</a>
                        <?php else: ?>
                            <form method="post" action="cart.php">
                                <input type="hidden" name="action" value="place_order">
                                <input type="hidden" name="product_id" value="0"> <!-- Ajout de cette ligne -->
                                <button type="submit" class="checkout-btn">Passer la commande</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <?php include 'empty_cart.php'; ?>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>