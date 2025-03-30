<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infinity-Tech</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="footer.css">
    <style>
        footer {
            background: #124e8b;
            color: white;
            /* padding: 50px 20px; */
            padding-top: 30px;
            font-family: "Poppins", sans-serif;
            margin-top: 50px;
        }

        .footer-container {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-logo img {
            width: 50px;
        }

        .footer-logo-text {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .footer-description {
            max-width: 400px;
            margin-top: 15px;
            line-height: 1.6;
            font-family: "Poppins", sans-serif;
            font-weight: 200;
            font-style: normal;
        }

        .quick-links,
        .get-in-touch {
            display: flex;
            flex-direction: column;
        }

        .quick-links h3,
        .get-in-touch h3 {
            margin-bottom: 15px;
            font-weight: 600;
        }

        .quick-links a {
            color: white;
            text-decoration: none;
            margin-bottom: 10px;
            transition: color 0.3s ease;
        }

        .quick-links a:hover {
            color: #dadada;
        }

        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .social-icons a {
            color: white;
            font-size: 1.5rem;
            transition: color 0.3s ease;
        }

        .social-icons a:hover {
            color: #dadada;
        }

        .payment-icons {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }

        .getitTouchP {
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-style: normal;
            color: white;
        }

        .copyright {
            background-color: rgba(0, 0, 0, 0.2);
        }

        .copyright-text {
            font-family: "Poppins", sans-serif;
            font-weight: 200;
            font-style: normal;
            color: white;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <footer>
        <div class="footer-container">
            <div class="footer-left">
                <div class="footer-logo">
                    <img src="../assets/whiteLogo.png" alt="InfinityTech Logo">
                    <span class="footer-logo-text">InfinityTech</span>
                </div>
                <p class="footer-description">
                    Votre boutique en ligne en électronique et informatique.
                    Retrouvez une sélection de PC, smartphones et accessoires high-tech de qualité, avec un service client à votre écoute.
                </p>
            </div>

            <div class="quick-links">
                <h3>Quick Links</h3>
                <a href="home.php">Home</a>
                <a href="about.php">About us</a>
                <a href="contact.php">Contact us</a>
            </div>

            <div class="get-in-touch">
                <h3>Get In Touch</h3>
                <p class="getitTouchP"> find us in social</p>
                <div class="social-icons">
                    <img src="../assets/social media.png" alt="social media">
                </div>
                <div class="payment-icons">
                    <img src="../assets/payment.png" alt="payment methods">
                </div>
            </div>
        </div>
        <div class="copyright">
            <p id="copyright-text">
                &copy;Copyright 2025 InfinityTech. All Rights Reserved
            </p>
        </div>
    </footer>

</body>

</html>