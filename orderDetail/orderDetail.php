<?php
require_once '../register/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../register/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    die("ID de commande manquant.");
}

$order_id = intval($_GET['id']);

// Utilisation de requêtes préparées pour éviter les injections SQL
$check_stmt = mysqli_prepare($connection, "SELECT id_order FROM orders WHERE id_order = ? AND user_id = ?");
mysqli_stmt_bind_param($check_stmt, "ii", $order_id, $user_id);
mysqli_stmt_execute($check_stmt);
mysqli_stmt_store_result($check_stmt);

if (mysqli_stmt_num_rows($check_stmt) == 0) {
    die("Cette commande n'existe pas ou ne vous appartient pas.");
}
mysqli_stmt_close($check_stmt);

// Récupération des infos de base de la commande avec requête préparée
$order_stmt = mysqli_prepare(
    $connection,
    "SELECT 
        o.id_order, 
        o.date_commande,
        o.total,
        u.first_name, 
        u.last_name, 
        u.email
    FROM orders o
    JOIN users u ON o.user_id = u.id_user
    WHERE o.id_order = ?"
);
mysqli_stmt_bind_param($order_stmt, "i", $order_id);
mysqli_stmt_execute($order_stmt);
$order_result = mysqli_stmt_get_result($order_stmt);
$order = mysqli_fetch_assoc($order_result);
mysqli_stmt_close($order_stmt);

// Récupération des articles de la commande avec requête préparée
$items_stmt = mysqli_prepare(
    $connection,
    "SELECT 
        oi.product_id,
        p.name,
        p.image_principale,
        oi.quantity,
        oi.prix_unitaire,
        (oi.quantity * oi.prix_unitaire) AS sous_total
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id_product
    WHERE oi.order_id = ?"
);
mysqli_stmt_bind_param($items_stmt, "i", $order_id);
mysqli_stmt_execute($items_stmt);
$items_result = mysqli_stmt_get_result($items_stmt);
$items = mysqli_fetch_all($items_result, MYSQLI_ASSOC);
mysqli_stmt_close($items_stmt);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de commande - Infinity-Tech</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="icon" href="../assets/icon2.png" type="image/png">
    <style>
        .order-detail-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 1rem;
        }

        .order-info {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .order-products table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .order-products th,
        .order-products td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .order-products th {
            background-color: #f2f2f2;
        }

        .product-image {
            width: 80px;
            height: auto;
        }
    </style>
</head>

<body>
    <?php include '../reusables/navbar.php'; ?>

    <div class="cart-container">
        <div class="cart-content">
            <div class="order-detail-container">
                <h2>Détails de la commande #<?php echo $order['id_order']; ?></h2>

                <div class="order-info">
                    <p><strong>Date :</strong> <?php echo date('d/m/Y H:i', strtotime($order['date_commande'])); ?></p>
                    <p><strong>Client :</strong> <?php echo htmlspecialchars($order['first_name'] . " " . $order['last_name']); ?></p>
                    <p><strong>Email :</strong> <?php echo htmlspecialchars($order['email']); ?></p>
                </div>

                <div class="order-products">
                    <h3>Produits commandés</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Prix unitaire</th>
                                <th>Quantité</th>
                                <th>Sous-total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td>
                                        <img src="../assets/<?php echo htmlspecialchars($item['image_principale']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="product-image">
                                        <?php echo htmlspecialchars($item['name']); ?>
                                    </td>
                                    <td><?php echo number_format($item['prix_unitaire'], 2); ?> €</td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo number_format($item['sous_total'], 2); ?> €</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: right;"><strong>Total :</strong></td>
                                <td><strong><?php echo number_format($order['total'], 2); ?> €</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>