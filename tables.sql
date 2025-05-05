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
    Products (
        id_product INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        prix DECIMAL(10, 2) NOT NULL,
        image_principale VARCHAR(255),
        type ENUM ('laptop', 'smartphone', 'accessoire', 'composant') NOT NULL
        quantity int
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
        quantity int

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
        quantity int

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
        quantity int

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
        quantity int

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