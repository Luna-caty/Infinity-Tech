<?php
require_once '../register/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../register/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Requête directe au lieu de la procédure stockée
$query = "SELECT o.id_order, o.order_date, o.status, o.total_amount, 
          (SELECT COUNT(*) FROM OrderItems WHERE order_id = o.id_order) as total_items
          FROM Orders o
          WHERE o.user_id = ?
          ORDER BY o.order_date DESC";

$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Erreur lors de la récupération des commandes: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes commandes</title>
    <link rel="stylesheet" href="orders.css">
    <link rel="icon" href="../assets/icon2.png" type="image/png">
</head>

<body>
    <?php include '../reusables/navbar.php'; ?>

    <div class="orders-container">
        <h1>Mes commandes</h1>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Commande #</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Total</th>
                        <th>Articles</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $order['id_order']; ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo strtolower($order['status']); ?>">
                                    <?php echo $order['status']; ?>
                                </span>
                            </td>
                            <td><?php echo number_format($order['total_amount'], 2); ?>€</td>
                            <td><?php echo $order['total_items']; ?></td>
                            <td>
                                <a href="view_completed_order.php?id=<?php echo $order['id_order']; ?>" class="view-btn">
                                    Voir les détails
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-orders">
                <p>Vous n'avez pas encore de commande.</p>
                <a href="../shop/shop.php" class="shop-now-btn">Commencer vos achats</a>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>