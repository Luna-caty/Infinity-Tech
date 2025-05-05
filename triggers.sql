DELIMITER //

CREATE TRIGGER update_product_stock 
AFTER INSERT ON OrderItems
FOR EACH ROW
BEGIN
    -- Déclarer la variable pour stocker le type de produit
    DECLARE product_type VARCHAR(20);
    
    -- Récupérer le type de produit
    SELECT type INTO product_type
    FROM Products
    WHERE id_product = NEW.product_id;
    
    -- Mettre à jour le stock dans la table spécifique selon le type de produit
    -- Noter que la mise à jour de la table Products est supprimée pour éviter la double mise à jour
    CASE product_type
        WHEN 'laptop' THEN
            UPDATE Laptops 
            SET quantity = quantity - NEW.quantity
            WHERE id_product = NEW.product_id;
            
        WHEN 'smartphone' THEN
            UPDATE Smartphones 
            SET quantity = quantity - NEW.quantity
            WHERE id_product = NEW.product_id;
            
        WHEN 'accessoire' THEN
            UPDATE Accessoires 
            SET quantity = quantity - NEW.quantity
            WHERE id_product = NEW.product_id;
            
        WHEN 'composant' THEN
            UPDATE Stockage_Composants 
            SET quantity = quantity - NEW.quantity
            WHERE id_product = NEW.product_id;
    END CASE;
END //

DELIMITER ;

DELIMITER //

-- trigger 2 
CREATE TRIGGER check_product_stock 
BEFORE INSERT ON Orders
FOR EACH ROW
BEGIN
    -- Déclarer la variable pour stocker le stock disponible
    DECLARE available_stock INT;
    
    -- Récupérer le stock disponible du produit
    SELECT quantity INTO available_stock 
    FROM Products 
    WHERE id_product = NEW.product_id;
    
    -- Vérifier si la quantité demandée dépasse le stock disponible
    IF NEW.quantity > available_stock THEN
        -- Générer une erreur SQL qui empêchera l'insertion
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Quantité demandée supérieure au stock disponible';
    END IF;
END //

DELIMITER ;

-- solution pour la table orders 
DELIMITER //

CREATE TRIGGER check_stock_before_order
BEFORE INSERT ON Orders
FOR EACH ROW
BEGIN
    -- Vérifier si un produit du panier a un stock insuffisant
    IF EXISTS (
        SELECT 1
        FROM cart c
        JOIN products p ON c.product_id = p.id_product
        WHERE c.user_id = NEW.user_id
        AND c.quantity > p.quantity
    ) THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Stock insuffisant pour certains produits du panier';
    END IF;
END //

DELIMITER ;

-- trigger 3
