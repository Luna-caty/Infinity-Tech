DELIMITER / / CREATE PROCEDURE GetOrderDetails (IN p_user_id INT) BEGIN 
DECLARE v_total DECIMAL(10, 2) DEFAULT 0;

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

SELECT
    SUM(p.prix * c.quantity) AS total_amount
FROM
    cart c
    JOIN products p ON c.product_id = p.id_product
WHERE
    c.user_id = p_user_id;

END / / DELIMITER;

DELIMITER / / CREATE PROCEDURE FinalizeOrder (IN p_user_id INT, OUT p_order_id INT) BEGIN 
DECLARE v_total DECIMAL(10, 2) DEFAULT 0;

SELECT
    SUM(p.prix * c.quantity) INTO v_total
FROM
    cart c
    JOIN products p ON c.product_id = p.id_product
WHERE
    c.user_id = p_user_id;

IF v_total > 0 THEN
IF EXISTS (
    SELECT
        1
    FROM
        cart c
        JOIN products p ON c.product_id = p.id_product
    WHERE
        c.user_id = p_user_id
        AND c.quantity > p.quantity
) THEN
SET
    p_order_id = -1;


ELSE
INSERT INTO
    Orders (user_id, total_amount)
VALUES
    (p_user_id, v_total);

SET
    p_order_id = LAST_INSERT_ID ();

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


UPDATE Products p
JOIN cart c ON p.id_product = c.product_id
SET
    p.quantity = p.quantity - c.quantity
WHERE
    c.user_id = p_user_id;

DELETE FROM cart
WHERE
    user_id = p_user_id;

END IF;

ELSE
SET
    p_order_id = 0;

END IF;

END / / DELIMITER;

DELIMITER / / CREATE PROCEDURE GetCustomerOrderHistory (IN customer_id INT) BEGIN
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