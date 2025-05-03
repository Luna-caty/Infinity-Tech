<?php
require_once '../register/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../register/SignIn.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Appel de la procédure stockée pour récupérer l'historique des commandes
$query = "CALL GetCustomerOrderHistory(?)";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Vérifier s'il y a des commandes
$has_orders = mysqli_num_rows($result) > 0;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des commandes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="order_history.css">
    <link rel="icon" href="../assets/icon2.png" type="image/png">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        .history-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            color: #333;
        }

        .orders-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .order-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            background-color: #f9f9f9;
            border-bottom: 1px solid #eee;
        }

        .order-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .order-number {
            font-weight: 600;
            color: #333;
        }

        .order-date {
            font-size: 0.9rem;
            color: #666;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .status-en_attente {
            background-color: #FFF8E1;
            color: #FFA000;
        }

        .status-confirmée {
            background-color: #E8F5E9;
            color: #4CAF50;
        }

        .status-expédiée {
            background-color: #E3F2FD;
            color: #2196F3;
        }

        .status-livrée {
            background-color: #E0F2F1;
            color: #009688;
        }

        .status-annulée {
            background-color: #FFEBEE;
            color: #F44336;
        }

        .order-body {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-summary {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .order-items-count {
            color: #666;
            font-size: 0.9rem;
        }

        .order-total {
            font-weight: 600;
            color: #4CAF50;
        }

        .order-actions {
            margin-left: auto;
        }

        .view-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }

        .view-btn:hover {
            background-color: #45a049;
        }

        .no-orders {
            text-align: center;
            padding: 50px 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .no-orders p {
            margin-bottom: 20px;
            font-size: 1.1rem;
            color: #666;
        }

        .no-orders-actions {
            margin-top: 30px;
        }

        .action-btn {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .primary-btn {
            background-color: #4CAF50;
            color: white;
        }

        .primary-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <?php include '../reusables/navbar.php'; ?>

    <div class="history-container">
        <h1>Historique de mes commandes</h1>

        <?php if ($has_orders): ?>
            <div class="orders-list">
                <?php while ($order = mysqli_fetch_assoc($result)): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-info">
                                <span class="order-number">Commande #<?php echo $order['id_order']; ?></span>
                                <span class="order-date"><?php echo date('d/m/Y à H:i', strtotime($order['order_date'])); ?></span>
                            </div>
                        </div>
                        <div class="order-body">
                            <div class="order-summary">
                                <div class="order-items-count">
                                    <span>Articles: <?php echo $order['items_count']; ?></span>
                                </div>
                                <div class="order-total">
                                    <span>Total: <?php echo number_format($order['total_amount'], 2); ?>€</span>
                                </div>
                            </div>
                            <div class="order-actions">
                                <a href="view_completed_order.php?id=<?php echo $order['id_order']; ?>" class="view-btn">
                                    Voir les détails
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="no-orders">
                <p>Vous n'avez pas encore effectué de commande.</p>
                <div class="no-orders-actions">
                    <a href="../index.php" class="action-btn primary-btn">Explorer nos produits</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>