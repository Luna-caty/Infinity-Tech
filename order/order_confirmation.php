<?php
require_once '../register/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../register/SignIn.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Vérifier si une erreur de stock a été stockée dans la session
$error_message = "";
if (isset($_SESSION['stock_error'])) {
    $error_message = $_SESSION['stock_error'];
    unset($_SESSION['stock_error']);
}

// Gérer l'annulation de commande
if (isset($_POST['cancel_order']) && isset($_POST['order_id'])) {
    $order_id_to_cancel = intval($_POST['order_id']);

    // Vérifier que la commande appartient à l'utilisateur et est confirmée
    $check_query = "SELECT status FROM Orders WHERE id_order = $order_id_to_cancel AND user_id = $user_id";
    $check_result = mysqli_query($connection, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $order_data = mysqli_fetch_assoc($check_result);
        if ($order_data['status'] === 'confirmée') {
            // Mettre à jour le statut de la commande
            $update_query = "UPDATE Orders SET status = 'annulée' WHERE id_order = $order_id_to_cancel AND user_id = $user_id";
            mysqli_query($connection, $update_query);

            // Stocker le message de confirmation dans la session
            $_SESSION['cancel_message'] = "Commande annulée avec succès";
            header("Location: order_confirmation.php?order_id=$order_id_to_cancel");
            exit;
        }
    }
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
if ($order['status'] === 'en_attente') {
    // Mettre à jour le statut de la commande
    $update_query = "UPDATE Orders SET status = 'confirmée' WHERE id_order = $order_id AND user_id = $user_id";
    mysqli_query($connection, $update_query);

    // Recharger les informations de la commande
    $order_result = mysqli_query($connection, $order_query);
    $order = mysqli_fetch_assoc($order_result);
}

// Vérifier si un message d'annulation existe
$cancel_message = "";
if (isset($_SESSION['cancel_message'])) {
    $cancel_message = $_SESSION['cancel_message'];
    unset($_SESSION['cancel_message']);
}
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
</head>

<body>
    <?php include '../reusables/navbar.php'; ?>
    <div class="confirmation-container">
        <?php if (!empty($error_message)): ?>
            <div class="error-message">
                <strong>Erreur:</strong> <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($cancel_message)): ?>
            <div class="success-message">
                <?php echo $cancel_message; ?>
            </div>
        <?php endif; ?>

        <div class="confirmation-icon">
            <?php if ($order['status'] === 'annulée'): ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#f44336" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
            <?php elseif ($order['status'] === 'confirmée'): ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#4CAF50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            <?php else: ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#FFC107" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            <?php endif; ?>
        </div>
        <div class="confirmation-header">
            <h1>
                Commande <?php echo $order['status'] === 'annulée' ? 'Annulée' : ($order['status'] === 'confirmée' ? 'Confirmée' : 'En Attente'); ?>
            </h1>
            <p class="order-number">Commande #<?php echo $order_id; ?></p>
        </div>
        <div class="confirmation-details">
            <div class="confirmation-details">
                <?php if ($order['status'] === 'annulée'): ?>
                    <p>Votre commande a été annulée avec succès.</p>
                    <p>Si vous avez des questions, n'hésitez pas à contacter notre service client.</p>
                <?php elseif ($order['status'] === 'confirmée'): ?>
                    <p>Merci pour votre commande!</p>
                    <p>Votre commande a été confirmée et est en cours de traitement.</p>
                <?php else: ?>
                    <p>Votre commande est en attente de confirmation.</p>
                    <p>Nous traitons votre paiement et vous serez notifié une fois confirmé.</p>
                <?php endif; ?>
                <p class="order-date">Date de commande: <?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></p>
                <p class="order-total">Montant total: <?php echo number_format($order['total_amount'], 2); ?>€</p>
            </div>

            <div class="confirmation-actions">
                <a href="../shop/shop.php" class="continue-shopping-btn">Continuer les achats</a>
                <a href="order_history.php" class="view-orders-btn">Voir mes commandes</a>

                <?php if ($order['status'] === 'confirmée'): ?>
                    <button id="cancelOrderBtn" class="cancel-btn">Annuler la commande</button>

                    
                    <form id="cancelOrderForm" method="post" style="display: none;">
                        <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                        <input type="hidden" name="cancel_order" value="1">
                    </form>
                <?php endif; ?>
            </div>
        </div>

        
        <div id="cancelModal" class="modal">
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h2>Confirmer l'annulation</h2>
                <p>Êtes-vous sûr de vouloir annuler cette commande ?</p>
                <div class="modal-buttons">
                    <button id="cancelCancelBtn" class="btn secondary">Non</button>
                    <button id="confirmCancelBtn" class="btn primary">Oui, annuler</button>
                </div>
            </div>
        </div>

        <script>
           
            const cancelOrderBtn = document.getElementById('cancelOrderBtn');
            const cancelModal = document.getElementById('cancelModal');
            const closeBtn = document.querySelector('.close-btn');
            const cancelCancelBtn = document.getElementById('cancelCancelBtn');
            const confirmCancelBtn = document.getElementById('confirmCancelBtn');
            const cancelOrderForm = document.getElementById('cancelOrderForm');

            
            if (cancelOrderBtn) {
                cancelOrderBtn.addEventListener('click', function() {
                    cancelModal.style.display = 'block';
                });
            }

           
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    cancelModal.style.display = 'none';
                });
            }

            
            if (cancelCancelBtn) {
                cancelCancelBtn.addEventListener('click', function() {
                    cancelModal.style.display = 'none';
                });
            }

            if (confirmCancelBtn) {
                confirmCancelBtn.addEventListener('click', function() {
                    cancelOrderForm.submit();
                });
            }

            window.addEventListener('click', function(event) {
                if (event.target === cancelModal) {
                    cancelModal.style.display = 'none';
                }
            });
        </script>
    </div>
</body>

</html>