CREATE TABLE
    Users (
        id_user INT PRIMARY KEY AUTO_INCREMENT,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM ('client', 'admin') DEFAULT 'client'
    );

CREATE TABLE
    Laptops (
        id_pc INT PRIMARY KEY AUTO_INCREMENT,
        id_product INT UNIQUE,
        name VARCHAR(100) NOT NULL,
        marque VARCHAR(50) NOT NULL,
        cpu VARCHAR(100) NOT NULL,
        gpu VARCHAR(100),
        ram VARCHAR(50) NOT NULL,
        stockage VARCHAR(100) NOT NULL,
        ecran VARCHAR(100) NOT NULL,
        batterie VARCHAR(50),
        design VARCHAR(100),
        systeme_exploitation VARCHAR(50),
        poids VARCHAR(20),
        description TEXT,
        prix DECIMAL(10, 2) NOT NULL,
        quantite_stock INT NOT NULL DEFAULT 0,
        image_principale VARCHAR(255),
        FOREIGN KEY (id_product) REFERENCES Products (id_product) ON DELETE CASCADE
    );

CREATE TABLE
    Smartphones (
        id_phone INT PRIMARY KEY AUTO_INCREMENT,
        id_product INT UNIQUE,
        name VARCHAR(100) NOT NULL,
        marque VARCHAR(50) NOT NULL,
        processeur VARCHAR(100) NOT NULL,
        ecran VARCHAR(100) NOT NULL,
        ram VARCHAR(50) NOT NULL,
        stockage VARCHAR(50) NOT NULL,
        appareil_photo VARCHAR(255) NOT NULL,
        batterie VARCHAR(50) NOT NULL,
        securite VARCHAR(100),
        design VARCHAR(100),
        dimensions VARCHAR(100),
        poids VARCHAR(20),
        description TEXT,
        prix DECIMAL(10, 2) NOT NULL,
        quantite_stock INT NOT NULL DEFAULT 0,
        image_principale VARCHAR(255),
        FOREIGN KEY (id_product) REFERENCES Products (id_product) ON DELETE CASCADE
    );

CREATE TABLE
    Accessoires (
        id_accessoire INT PRIMARY KEY AUTO_INCREMENT,
        id_product INT UNIQUE,
        name VARCHAR(100) NOT NULL,
        marque VARCHAR(50) NOT NULL,
        type_accessoire ENUM (
            'Clavier',
            'Souris',
            'Casque',
            'Écran',
            'Hub USB',
            'Webcam',
            'Tapis de souris',
            'Enceintes',
            'Refroidissement',
            'Manette'
        ) NOT NULL,
        specifications TEXT,
        compatibilite TEXT,
        description TEXT,
        prix DECIMAL(10, 2) NOT NULL,
        quantite_stock INT NOT NULL DEFAULT 0,
        image_principale VARCHAR(255),
        FOREIGN KEY (id_product) REFERENCES Products (id_product) ON DELETE CASCADE
    );

CREATE TABLE
    Stockage_Composants (
        id_composant INT PRIMARY KEY AUTO_INCREMENT,
        id_product INT UNIQUE,
        name VARCHAR(100) NOT NULL,
        marque VARCHAR(50) NOT NULL,
        type_composant ENUM (
            'Disque Dur',
            'SSD',
            'Carte Graphique',
            'Processeur',
            'RAM',
            'Carte Mère',
            'Alimentation',
            'Boîtier',
            'Ventilateur',
            'Watercooling'
        ) NOT NULL,
        capacite VARCHAR(100),
        specifications TEXT,
        compatibilite TEXT,
        description TEXT,
        prix DECIMAL(10, 2) NOT NULL,
        quantite_stock INT NOT NULL DEFAULT 0,
        image_principale VARCHAR(255),
        FOREIGN KEY (id_product) REFERENCES Products (id_product) ON DELETE CASCADE
    );

CREATE TABLE
    Products (
        id_product INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        prix DECIMAL(10, 2) NOT NULL,
        image_principale VARCHAR(255),
        type ENUM ('laptop', 'smartphone', 'accessoire', 'composant') NOT NULL
    );

CREATE TABLE
    Cart (
        id_cart INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL DEFAULT 1,
        FOREIGN KEY (user_id) REFERENCES Users (id_user) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES Products (id_product) ON DELETE CASCADE,
        UNIQUE KEY unique_cart_item (user_id, product_id)
    );

-- procedure 1 
DELIMITER / / CREATE PROCEDURE GetOrderDetails (IN p_user_id INT) BEGIN
-- Declare variables
DECLARE v_total DECIMAL(10, 2) DEFAULT 0;

-- Select all items in the cart with their details
SELECT
    p.id_product,
    p.name,
    p.prix,
    c.quantity,
    (p.prix * c.quantity) AS subtotal
FROM
    cart c
    JOIN products p ON c.product_id = p.id_product
WHERE
    c.user_id = p_user_id;

-- Calculate and display the total
SELECT
    SUM(p.prix * c.quantity) AS total_amount
FROM
    cart c
    JOIN products p ON c.product_id = p.id_product
WHERE
    c.user_id = p_user_id;

END / / DELIMITER;

-- Créer la table des commandes
CREATE TABLE
    Orders (
        id_order INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        total_amount DECIMAL(10, 2) NOT NULL,
        status ENUM (
            'en_attente',
            'confirmée',
            'expédiée',
            'livrée',
            'annulée'
        ) NOT NULL DEFAULT 'en_attente',
        FOREIGN KEY (user_id) REFERENCES Users (id_user) ON DELETE CASCADE
    );

-- Créer la table des items de commande
CREATE TABLE
    OrderItems (
        id_order_item INT PRIMARY KEY AUTO_INCREMENT,
        order_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        price_per_unit DECIMAL(10, 2) NOT NULL,
        subtotal DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (order_id) REFERENCES Orders (id_order) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES Products (id_product)
    );

DELIMITER / / CREATE PROCEDURE FinalizeOrder (IN p_user_id INT, OUT p_order_id INT) BEGIN DECLARE v_total DECIMAL(10, 2) DEFAULT 0;

-- Calcul du total de la commande
SELECT
    SUM(p.prix * c.quantity) INTO v_total
FROM
    cart c
    JOIN products p ON c.product_id = p.id_product
WHERE
    c.user_id = p_user_id;

-- Vérifier si le panier n'est pas vide
IF v_total > 0 THEN
-- Insérer la commande
INSERT INTO
    Orders (user_id, total_amount)
VALUES
    (p_user_id, v_total);

-- Récupérer l'ID de la commande créée
SET
    p_order_id = LAST_INSERT_ID ();

-- Insérer les items de la commande
INSERT INTO
    OrderItems (
        order_id,
        product_id,
        quantity,
        price_per_unit,
        subtotal
    )
SELECT
    p_order_id,
    p.id_product,
    c.quantity,
    p.prix,
    (p.prix * c.quantity)
FROM
    cart c
    JOIN products p ON c.product_id = p.id_product
WHERE
    c.user_id = p_user_id;

-- Mettre à jour le stock (si besoin)
UPDATE Products p
JOIN cart c ON p.id_product = c.product_id
SET
    p.quantite_stock = p.quantite_stock - c.quantity
WHERE
    c.user_id = p_user_id;

-- Vider le panier
DELETE FROM cart
WHERE
    user_id = p_user_id;

ELSE
-- Si le panier est vide, retourner 0 comme ID de commande
SET
    p_order_id = 0;

END IF;

END / / DELIMITER;

DELIMITER / / CREATE PROCEDURE GetCustomerOrderHistory (IN customer_id INT) BEGIN
-- Sélectionner toutes les commandes du client
SELECT
    o.id_order,
    o.order_date,
    o.status,
    o.total_amount,
    (
        SELECT
            COUNT(*)
        FROM
            OrderItems
        WHERE
            order_id = o.id_order
    ) AS items_count
FROM
    Orders o
WHERE
    o.user_id = customer_id
ORDER BY
    o.order_date DESC;

END / / DELIMITER;

DELIMITER / / CREATE PROCEDURE GetCompletedOrderDetails (IN order_id INT) BEGIN
-- Informations générales de la commande
SELECT
    o.id_order,
    o.user_id,
    o.order_date,
    o.status,
    o.total_amount,
    u.first_name,
    u.last_name,
    u.email
FROM
    Orders o
    JOIN Users u ON o.user_id = u.id_user
WHERE
    o.id_order = order_id;

-- Détails des articles de la commande
SELECT
    oi.product_id,
    p.name,
    p.image_principale,
    oi.quantity,
    oi.price_per_unit,
    oi.subtotal
FROM
    OrderItems oi
    JOIN Products p ON oi.product_id = p.id_product
WHERE
    oi.order_id = order_id;

END / / DELIMITER;