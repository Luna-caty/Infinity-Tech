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

-- une table pour stocker plusieurs images
CREATE TABLE
    Images (
        id_image INT PRIMARY KEY AUTO_INCREMENT,
        id_produit INT NOT NULL,
        type_produit ENUM ('laptop', 'smartphone', 'accessoire') NOT NULL,
        url_image VARCHAR(255) NOT NULL
    );

-- Orders table  Stocker les informations globales de chaque commande passée.
CREATE TABLE
    Orders (
        id_order INT PRIMARY KEY AUTO_INCREMENT,
        user_id INT NOT NULL,
        date_commande DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        total DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (user_id) REFERENCES Users (id_user) ON DELETE CASCADE
    );

-- Order Items table Stocker la liste des produits pour chaque commande.
CREATE TABLE
    Order_Items (
        id_item INT PRIMARY KEY AUTO_INCREMENT,
        order_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        prix_unitaire DECIMAL(10, 2) NOT NULL,
        FOREIGN KEY (order_id) REFERENCES Orders (id_order) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES Products (id_product) ON DELETE CASCADE
    );

DELIMITER / / CREATE PROCEDURE GetOrderDetails (IN p_order_id INT, IN p_user_id INT) BEGIN DECLARE total_amount DECIMAL(10, 2);

-- Vérifier que la commande appartient à l'utilisateur
IF NOT EXISTS (
    SELECT
        1
    FROM
        Orders
    WHERE
        id_order = p_order_id
        AND user_id = p_user_id
) THEN SIGNAL SQLSTATE '45000'
SET
    MESSAGE_TEXT = "Cette commande n\'appartient pas à cet utilisateur";

END IF;

-- Détails de la commande
SELECT
    o.id_order,
    o.date_commande,
    o.statut,
    o.adresse_livraison,
    u.first_name,
    u.last_name,
    u.email
FROM
    Orders o
    JOIN Users u ON o.user_id = u.id_user
WHERE
    o.id_order = p_order_id;

-- Articles de la commande avec détails produits
SELECT
    oi.product_id,
    p.name,
    p.type,
    oi.quantity,
    oi.prix_unitaire,
    (oi.quantity * oi.prix_unitaire) AS sous_total
FROM
    Order_Items oi
    JOIN Products p ON oi.product_id = p.id_product
WHERE
    oi.order_id = p_order_id;

-- Total de la commande
SELECT
    total
FROM
    Orders
WHERE
    id_order = p_order_id;

END / / DELIMITER;