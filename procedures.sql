-- procedure 1 
DELIMITER 
/ / CREATE PROCEDURE GetOrderDetails (IN p_user_id INT) BEGIN
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

DELIMITER //

CREATE PROCEDURE FinalizeOrder (IN p_user_id INT, OUT p_order_id INT)
BEGIN
    DECLARE v_total DECIMAL(10, 2) DEFAULT 0;

    -- Calcul du total de la commande
    SELECT SUM(p.prix * c.quantity) INTO v_total
    FROM cart c
    JOIN products p ON c.product_id = p.id_product
    WHERE c.user_id = p_user_id;

    -- Vérifier si le panier n'est pas vide
    IF v_total > 0 THEN
        -- Vérifier le stock avant de procéder
        IF EXISTS (
            SELECT 1
            FROM cart c
            JOIN products p ON c.product_id = p.id_product
            WHERE c.user_id = p_user_id
            AND c.quantity > p.quantity
        ) THEN
            -- Si stock insuffisant, définir p_order_id à -1 pour indiquer une erreur
            SET p_order_id = -1;
            -- Vous pourriez également stocker un message d'erreur dans une variable de session
            -- dans la version PHP qui appelle cette procédure
        ELSE
            -- Insérer la commande
            INSERT INTO Orders (user_id, total_amount)
            VALUES (p_user_id, v_total);

            -- Récupérer l'ID de la commande créée
            SET p_order_id = LAST_INSERT_ID();

            -- Insérer les items de la commande
            INSERT INTO OrderItems (
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
            FROM cart c
            JOIN products p ON c.product_id = p.id_product
            WHERE c.user_id = p_user_id;

            -- Mettre à jour le stock - cette mise à jour sera maintenant la seule qui affecte Products
            -- Le trigger se chargera de mettre à jour les tables spécifiques (Laptops, Smartphones, etc.)
            UPDATE Products p
            JOIN cart c ON p.id_product = c.product_id
            SET p.quantity = p.quantity - c.quantity
            WHERE c.user_id = p_user_id;

            -- Vider le panier
            DELETE FROM cart
            WHERE user_id = p_user_id;
        END IF;
    ELSE
        -- Si le panier est vide, retourner 0 comme ID de commande
        SET p_order_id = 0;
    END IF;
END //

DELIMITER ;
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