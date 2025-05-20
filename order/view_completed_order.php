<?php
require_once '../register/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../register/SignIn.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: order_history.php");
    exit;
}

$order_id = intval($_GET['id']);

$stmt = mysqli_prepare($connection, "CALL GetCompletedOrderDetails(?)");
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$order_info = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($order_info) === 0) {
    header("Location: order_history.php");
    exit;
}

$order = mysqli_fetch_assoc($order_info);

if ($order['user_id'] != $user_id) {
    header("Location: order_history.php");
    exit;
}

mysqli_next_result($connection);
$items_result = mysqli_store_result($connection);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la commande #<?php echo $order_id; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="view_completed_order.css">
    <link rel="icon" href="../assets/icon2.png" type="image/png">
</head>

<body>
    <?php include '../reusables/navbar.php'; ?>

    <div class="view-order-container">
        <div class="back-link">
            <a href="order_history.php">&larr; Retour à l'historique des commandes</a>
        </div>

        <div class="order-header">
            <h1>Commande #<?php echo $order_id; ?></h1>
            <div class="order-meta">
                <div class="order-date">
                    <span>Date: <?php echo date('d/m/Y à H:i', strtotime($order['order_date'])); ?></span>
                </div>
            </div>
        </div>

        <div class="order-content">
            <div class="customer-info">
                <h2>Informations client</h2>
                <p><strong>Nom:</strong> <?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
            </div>

            <div class="order-items">
                <h2>Articles commandés</h2>

                <table class="items-table">
                    <thead>
                        <tr>
                            <th class="product-cell">Produit</th>
                            <th>Prix unitaire</th>
                            <th>Quantité</th>
                            <th>Sous-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($item = mysqli_fetch_assoc($items_result)): ?>
                            <tr>
                                <td class="product-cell" data-label="Produit">
                                    <div class="product-info">
                                        <div class="product-image">
                                            <img src="../assets/<?php echo htmlspecialchars($item['image_principale']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                        </div>
                                        <span class="product-name"><?php echo htmlspecialchars($item['name']); ?></span>
                                    </div>
                                </td>
                                <td data-label="Prix unitaire"><?php echo number_format($item['price_per_unit'], 2); ?>€</td>
                                <td data-label="Quantité"><?php echo $item['quantity']; ?></td>
                                <td data-label="Sous-total"><?php echo number_format($item['subtotal'], 2); ?>€</td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="total-label">Total</td>
                            <td class="total-value"><?php echo number_format($order['total_amount'], 2); ?>€</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</body>

</html>