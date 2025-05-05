<?php
require_once '../register/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../register/SignIn.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ajout: Vérifier si une erreur de stock a été stockée dans la session
$error_message = "";
if (isset($_SESSION['stock_error'])) {
    $error_message = $_SESSION['stock_error'];
    unset($_SESSION['stock_error']); // Nettoyer la variable de session
}

// Vérifier si l'ID de commande est présent
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    header("Location: ../cart/cart.php");
    exit;
}

$order_id = intval($_GET['order_id']);

// Récupérer les informations de la commande
$order_query = "SELECT * FROM Orders WHERE id_order = $order_id AND user_id = $user_id";
$order_result = mysqli_query($connection, $order_query);

if (mysqli_num_rows($order_result) === 0) {
    header("Location: ../cart/cart.php");
    exit;
}

$order = mysqli_fetch_assoc($order_result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande confirmée</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="order_confirmation.css">
    <link rel="icon" href="../assets/icon2.png" type="image/png">
    <!-- Ajout: Style pour l'affichage d'erreur -->
    <style>
        .error-message {
            background-color: #ffebee;
            color: #c62828;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            border-left: 5px solid #c62828;
        }
    </style>
</head>

<body>
    <?php include '../reusables/navbar.php'; ?>
    <div class="confirmation-container">
        <!-- Ajout: Affichage du message d'erreur s'il existe -->
        <?php if (!empty($error_message)): ?>
            <div class="error-message">
                <strong>Erreur:</strong> <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <div class="confirmation-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#4CAF50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
        </div>
        <div class="confirmation-header">
            <h1>Commande Confirmée</h1>
            <p class="order-number">Commande #<?php echo $order_id; ?></p>
        </div>
        <div class="confirmation-details">
            <p>Merci pour votre commande!</p>
            <p>Votre commande a été confirmée et est en cours de traitement.</p>
            <p class="order-date">Date de commande: <?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></p>
            <p class="order-total">Montant total: <?php echo number_format($order['total_amount'], 2); ?>€</p>
        </div>
        <div class="confirmation-actions">
            <a href="../shop/shop.php" class="continue-shopping-btn">Continuer les achats</a>
            <a href="orders.php" class="view-orders-btn">Voir mes commandes</a>
        </div>
    </div>
</body>

</html>