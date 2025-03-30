<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infnity-Tech</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
</head>

<body>
    <?php include '../reusables/navbar.php'; ?>
    <div class="hero">
        <div class="hero-texts">
            <p id="hero1">InfinityTech – The Ultimate Electronics & IT Store</p>
            <p id="hero2">Discover a wide range of products: computers, phones, peripherals, storage, and more</p>
            <div>
                <a href="../shop/shop.php" id="callToAction">Shop Now</a>
            </div>
        </div>
        <img src="../assets/hero.png" alt="hero" class="hero-image">
    </div>

    <div class="categories">
        <p id="categories-title">Our Categories</p>
        <div class="product-cards">
            <div class="product-card">
                <img src="../assets/laptop.png" alt="Laptop" class="product-image">
                <div class="product-info">
                    <h2 class="categorie-name">Laptop</h2>
                    <a href="../shop/shop.php" class="shop-now-btn">Shop Now</a>
                </div>
            </div>

            <div class="product-card">
                <img src="../assets/phones.png" alt="Phone" class="product-image">
                <div class="product-info">
                    <h2 class="categorie-name">Phone</h2>
                    <a href="#" class="shop-now-btn">Shop Now</a>
                </div>
            </div>

            <div class="product-card">
                <img src="../assets/accessoires.png" alt="accessoires" class="product-image">
                <div class="product-info">
                    <h2 class="categorie-name">Accessoires</h2>
                    <a href="#" class="shop-now-btn">Shop Now</a>
                </div>
            </div>

            <div class="product-card">
                <img src="../assets/components.png" alt="components" class="product-image">
                <div class="product-info">
                    <h2 class="categorie-name">Stockage & Composants</h2>
                    <a href="#" class="shop-now-btn">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
    <section class="best-seller-section">
        <h2 class="best-seller-title">BEST SELLER</h2>
        <div class="best-seller-products">
            <div class="bestSeller-card">
                <img src="../assets/ASUS.png" alt="ASUS ROG Strix G15" class="product-image">
                <h3 class="product-name">ASUS ROG Strix G15 - RTX 4060</h3>
                <p class="product-price">1,299€</p>
                <div class="bestSeller-btn">
                    <a href="#" class="details-btn">See more details</a>
                </div>
            </div>

            <div class="bestSeller-card">
                <img src="../assets/iphone15pro.png" alt="iPhone 15 Pro Max" class="product-image">
                <h3 class="product-name">iPhone 15 Pro Max - 256Go</h3>
                <p class="product-price">1,199€</p>
                <div class="bestSeller-btn">
                    <a href="#" class="details-btn">See more details</a>
                </div>
            </div>

            <div class="bestSeller-card">
                <img src="../assets/casque.png" alt="Logitech G Pro Headset" class="product-image">
                <h3 class="product-name">Casque Gamer Logitech G Pro</h3>
                <p class="product-price">129€</p>
                <div class="bestSeller-btn">
                    <a href="#" class="details-btn">See more details</a>
                </div>
            </div>
        </div>
    </section>
    <?php include '../reusables/footer.php'; ?>
</body>

</html>