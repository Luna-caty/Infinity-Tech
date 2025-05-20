<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: ../home/home.php");
    exit();
}

require_once '../register/database.php';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$items_per_page = 10;
$offset = ($page - 1) * $items_per_page;

$count_query = "SELECT COUNT(*) as total FROM OrderCancellationHistory";
$count_result = mysqli_query($connection, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_items = $count_row['total'];
$total_pages = ceil($total_items / $items_per_page);

$query = "SELECT h.*, u.first_name, u.last_name, u.email
FROM OrderCancellationHistory h
JOIN Users u ON h.user_id = u.id_user
ORDER BY h.id_history DESC  
LIMIT $offset, $items_per_page";

$result = mysqli_query($connection, $query);

$cancellations = array();
while ($row = mysqli_fetch_assoc($result)) {
    $cancellations[] = $row;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des annulations - Infinity-Tech</title>
    <link rel="stylesheet" href="admin.css">
    <link rel="icon" href="../assets/icon2.png" type="image/png">
    <style>
        .cancellations-container {
            max-width: 1400px;
            margin: 20px auto;
            padding: 20px;
        }

        .cancellations-table {
            width: 100%;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        .cancellations-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .cancellations-table th,
        .cancellations-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .cancellations-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }

        .cancellations-table tr:hover {
            background-color: #f9f9f9;
        }

        .cancellations-table a {
            color: #007bff;
            text-decoration: none;
        }

        .cancellations-table a:hover {
            text-decoration: underline;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 30px;
        }

        .page-link {
            padding: 8px 12px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #333;
            text-decoration: none;
        }

        .page-link:hover {
            background-color: #f8f9fa;
        }

        .page-link.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .no-results {
            text-align: center;
            padding: 50px 0;
            color: #666;
        }

        .client-info {
            font-size: 0.9rem;
        }

        .client-email {
            color: #666;
            display: block;
            font-size: 0.85rem;
        }
    </style>
</head>

<body>
    <nav>
        <div class="navbar">
            <div class="logo">
                <img src="../assets/logo.png" alt="logo">
                <span>Infinity-Tech</span>
            </div>
            <ul class="nav-menu">
                <li><a href="admin.php">View Products</a></li>
                <li><a href="admin_insert_product.php">Insert Product</a></li>
                <li><a href="cancellation_history.php">Historique Annulations</a></li>
            </ul>

            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="user-dropdown">
                    <div class="dropdown-content">
                        <a href="../register/logout.php" class="logout-link">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="../register/login.php">Login</a>
            <?php endif; ?>
        </div>
    </nav>

    <p id="welcomeP">
        Historique des annulations de commandes
    </p>

    <div class="cancellations-container">
        <?php if (count($cancellations) > 0): ?>
            <div class="cancellations-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID Historique</th>
                            <th>Commande #</th>
                            <th>Client</th>
                            <th>Date de commande</th>
                            <th>Montant</th>
                            <th>Statut précédent</th>
                            <th>Nombre d'articles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cancellations as $cancellation): ?>
                            <tr>
                                <td><?php echo $cancellation['id_history']; ?></td>
                                <td><a href="view_order.php?id=<?php echo $cancellation['order_id']; ?>"><?php echo $cancellation['order_id']; ?></a></td>
                                <td class="client-info">
                                    <?php echo htmlspecialchars($cancellation['first_name'] . ' ' . $cancellation['last_name']); ?>
                                    <span class="client-email"><?php echo htmlspecialchars($cancellation['email']); ?></span>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($cancellation['order_date'])); ?></td>
                                <td><?php echo number_format($cancellation['total_amount'], 2, ',', ' '); ?>€</td>
                                <td><?php echo $cancellation['previous_status']; ?></td>
                                <td><?php echo $cancellation['items_count']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($total_pages > 1): ?>
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>" class="page-link">&laquo; Précédent</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" class="page-link <?php echo $i === $page ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>" class="page-link">Suivant &raquo;</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p class="no-results">Aucune annulation de commande n'a été enregistrée.</p>
        <?php endif; ?>
    </div>
</body>

</html>