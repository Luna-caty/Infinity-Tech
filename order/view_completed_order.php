<?php
require_once '../register/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../register/SignIn.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Vérifier si l'ID de commande est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: order_history.php");
    exit;
}

$order_id = intval($_GET['id']);

// Récupérer les informations générales de la commande
$query = "SELECT o.id_order, o.user_id, o.order_date, o.status, o.total_amount, u.first_name, u.last_name, u.email
          FROM Orders o
          JOIN Users u ON o.user_id = u.id_user
          WHERE o.id_order = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "i", $order_id);
mysqli_stmt_execute($stmt);
$order_info = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($order_info) === 0) {
    header("Location: order_history.php");
    exit;
}

$order = mysqli_fetch_assoc($order_info);

// Vérifier si la commande appartient à l'utilisateur connecté
if ($order['user_id'] != $user_id) {
    header("Location: order_history.php");
    exit;
}

// Récupérer les détails des articles
$items_query = "SELECT oi.product_id, p.name, p.image_principale, oi.quantity, oi.price_per_unit, oi.subtotal
               FROM OrderItems oi
               JOIN Products p ON oi.product_id = p.id_product
               WHERE oi.order_id = ?";
$items_stmt = mysqli_prepare($connection, $items_query);
mysqli_stmt_bind_param($items_stmt, "i", $order_id);
mysqli_stmt_execute($items_stmt);
$items_result = mysqli_stmt_get_result($items_stmt);
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
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        .view-order-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }

        .back-link {
            margin-bottom: 20px;
        }

        .back-link a {
            text-decoration: none;
            color: #666;
            font-size: 0.95rem;
            transition: color 0.3s;
        }

        .back-link a:hover {
            color: #4CAF50;
        }

        .order-header {
            margin-bottom: 30px;
        }

        .order-header h1 {
            margin: 0 0 10px 0;
            font-weight: 600;
            color: #333;
        }

        .order-meta {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .order-date {
            color: #666;
            font-size: 0.95rem;
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

        .order-content {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .customer-info {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 1.2rem;
            font-weight: 600;
            color: #444;
        }

        .customer-info p {
            margin: 8px 0;
            color: #666;
        }

        .customer-info p strong {
            color: #333;
            margin-right: 5px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table th,
        .items-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .items-table th {
            font-weight: 600;
            color: #444;
            background-color: #f9f9f9;
        }

        .product-cell {
            width: 40%;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .product-image {
            width: 60px;
            height: 60px;
            border-radius: 5px;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-name {
            font-weight: 500;
        }

        .items-table tfoot {
            font-weight: 600;
        }

        .total-label {
            text-align: right;
        }

        .total-value {
            color: #4CAF50;
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .order-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .items-table th {
                display: none;
            }

            .items-table,
            .items-table tbody,
            .items-table tr,
            .items-table td {
                display: block;
                width: 100%;
            }

            .items-table tr {
                margin-bottom: 20px;
                border: 1px solid #eee;
                border-radius: 5px;
            }

            .items-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: right;
                padding: 10px 15px;
            }

            .items-table td:before {
                content: attr(data-label);
                font-weight: 600;
                margin-right: 10px;
            }

            .product-cell {
                width: 100%;
            }

            .product-info {
                width: 100%;
                justify-content: flex-start;
            }

            .items-table tfoot {
                display: block;
            }

            .items-table tfoot tr {
                margin-bottom: 0;
                border: none;
            }

            .total-label {
                text-align: left;
            }
        }
    </style>
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