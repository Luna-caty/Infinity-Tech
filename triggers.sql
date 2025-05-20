
DELIMITER //

CREATE TRIGGER update_product_stock 
AFTER INSERT ON OrderItems
FOR EACH ROW
BEGIN
    DECLARE product_type VARCHAR(20);
    
    SELECT type INTO product_type
    FROM Products
    WHERE id_product = NEW.product_id;
    
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
CREATE TRIGGER check_product_stock 
BEFORE INSERT ON Orders
FOR EACH ROW
BEGIN
    DECLARE available_stock INT;
    

    SELECT quantity INTO available_stock 
    FROM Products 
    WHERE id_product = NEW.product_id;
    
    IF NEW.quantity > available_stock THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Quantité demandée supérieure au stock disponible';
    END IF;
END //

DELIMITER ;

DELIMITER //

DROP TRIGGER IF EXISTS check_stock_before_order //
CREATE TRIGGER check_stock_before_order
BEFORE INSERT ON Orders
FOR EACH ROW
BEGIN
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
DELIMITER //

CREATE TRIGGER restore_stock_after_cancel
AFTER UPDATE ON Orders
FOR EACH ROW
BEGIN
    IF NEW.status = 'annulée' AND OLD.status != 'annulée' THEN
        UPDATE Products p
        JOIN OrderItems oi ON p.id_product = oi.product_id
        SET p.quantity = p.quantity + oi.quantity
        WHERE oi.order_id = NEW.id_order;
        
        UPDATE Laptops l
        JOIN Products p ON l.id_product = p.id_product
        JOIN OrderItems oi ON p.id_product = oi.product_id
        SET l.quantity = l.quantity + oi.quantity
        WHERE oi.order_id = NEW.id_order AND p.type = 'laptop';
        
        UPDATE Smartphones s
        JOIN Products p ON s.id_product = p.id_product
        JOIN OrderItems oi ON p.id_product = oi.product_id
        SET s.quantity = s.quantity + oi.quantity
        WHERE oi.order_id = NEW.id_order AND p.type = 'smartphone';
        
        UPDATE Accessoires a
        JOIN Products p ON a.id_product = p.id_product
        JOIN OrderItems oi ON p.id_product = oi.product_id
        SET a.quantity = a.quantity + oi.quantity
        WHERE oi.order_id = NEW.id_order AND p.type = 'accessoire';
        
        UPDATE Stockage_Composants sc
        JOIN Products p ON sc.id_product = p.id_product
        JOIN OrderItems oi ON p.id_product = oi.product_id
        SET sc.quantity = sc.quantity + oi.quantity
        WHERE oi.order_id = NEW.id_order AND p.type = 'composant';
    END IF;
END //

DELIMITER ;
-- trigger 4
DELIMITER //

CREATE TRIGGER log_cancelled_order
AFTER UPDATE ON Orders
FOR EACH ROW
BEGIN
    IF NEW.status = 'annulée' AND OLD.status != 'annulée' THEN
        DECLARE items_count INT;
        
        SELECT COUNT(*) INTO items_count
        FROM OrderItems
        WHERE order_id = NEW.id_order;
        
        INSERT INTO OrderCancellationHistory (
            order_id,
            user_id,
            order_date,
            total_amount,
            previous_status,
            items_count
        )
        VALUES (
            NEW.id_order,
            NEW.user_id,
            NEW.order_date,
            NEW.total_amount,
            OLD.status,
            items_count
        );
    END IF;
END //

DELIMITER ;
