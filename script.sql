CREATE TABLE Users (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,  -- Stockez toujours les mots de passe hachés
    role ENUM('client', 'admin') DEFAULT 'client'
);

CREATE TABLE Laptops (
    id_pc INT PRIMARY KEY AUTO_INCREMENT,
    reference VARCHAR(50) UNIQUE,
    name_pc VARCHAR(100) NOT NULL,
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
    prix DECIMAL(10,2) NOT NULL,
    quantite_stock INT NOT NULL DEFAULT 0,
    image_principale VARCHAR(255),
);

CREATE TABLE Smartphones (
    id_phone INT PRIMARY KEY AUTO_INCREMENT,
    reference VARCHAR(50) UNIQUE,
    phone_name VARCHAR(100) NOT NULL,
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
    prix DECIMAL(10,2) NOT NULL,
    quantite_stock INT NOT NULL DEFAULT 0,
    image_principale VARCHAR(255),
);
CREATE TABLE Accessoires (
    id_accessoire INT PRIMARY KEY AUTO_INCREMENT,
    reference VARCHAR(50) UNIQUE,
    name VARCHAR(100) NOT NULL,
    marque VARCHAR(50) NOT NULL,
    type_accessoire ENUM('Clavier', 'Souris', 'Casque', 'Écran', 'Hub USB', 'Webcam', 'Tapis de souris', 'Enceintes', 'Refroidissement', 'Manette') NOT NULL,
    specifications TEXT,
    compatibilite TEXT,
    description TEXT,
    prix DECIMAL(10,2) NOT NULL,
    quantite_stock INT NOT NULL DEFAULT 0,
    image_principale VARCHAR(255)
);
CREATE TABLE Stockage_Composants (
    id_composant INT PRIMARY KEY AUTO_INCREMENT,
    reference VARCHAR(50) UNIQUE,
    name VARCHAR(100) NOT NULL,
    marque VARCHAR(50) NOT NULL,
    type_composant ENUM('Disque Dur', 'SSD', 'Carte Graphique', 'Processeur', 'RAM', 'Carte Mère', 'Alimentation', 'Boîtier', 'Ventilateur', 'Watercooling') NOT NULL,
    capacite VARCHAR(100),
    specifications TEXT,
    compatibilite TEXT,
    description TEXT,
    prix DECIMAL(10,2) NOT NULL,
    quantite_stock INT NOT NULL DEFAULT 0,
    image_principale VARCHAR(255)
);

CREATE TABLE Products (
    id_product INT PRIMARY KEY AUTO_INCREMENT,
    type ENUM('laptop', 'smartphone', 'accessoire') NOT NULL,
    id_laptop INT,
    id_smartphone INT,
    id_accessoire INT,
    FOREIGN KEY (id_laptop) REFERENCES Laptops(id_pc),
    FOREIGN KEY (id_smartphone) REFERENCES Smartphones(id_phone),
    FOREIGN KEY (id_accessoire) REFERENCES Accessoires(id_accessoire)
);
-- une table pour stocker plusieurs images
CREATE TABLE Images (
    id_image INT PRIMARY KEY AUTO_INCREMENT,
    id_produit INT NOT NULL,
    type_produit ENUM('laptop', 'smartphone', 'accessoire') NOT NULL,
    url_image VARCHAR(255) NOT NULL
);