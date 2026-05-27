-- ============================================================
-- Shopora E-Commerce Database
-- BIT3208 Advanced Web Design - Week 1
-- ============================================================

CREATE DATABASE IF NOT EXISTS shopora;
USE shopora;

-- ------------------------------------------------------------
-- Table: categories
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS categories (
    category_id   INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL
);

-- ------------------------------------------------------------
-- Table: users
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    user_id    INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    full_name  VARCHAR(100) NOT NULL,
    email      VARCHAR(100) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    phone      VARCHAR(20),
    address    TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- ------------------------------------------------------------
-- Table: products
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS products (
    product_id   INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category_id  INT(11),
    product_name VARCHAR(150) NOT NULL,
    description  TEXT,
    price        DECIMAL(10,2) NOT NULL,
    stock_quantity INT(11) DEFAULT 0,
    image_url    VARCHAR(255),
    created_at   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE SET NULL
);

-- ------------------------------------------------------------
-- Table: orders
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS orders (
    order_id     INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id      INT(11),
    total_amount DECIMAL(10,2),
    order_status VARCHAR(50) DEFAULT 'Pending',
    order_date   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- ------------------------------------------------------------
-- Table: order_items
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS order_items (
    order_item_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    order_id      INT(11),
    product_id    INT(11),
    quantity      INT(11) NOT NULL,
    subtotal      DECIMAL(10,2),
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- ------------------------------------------------------------
-- Seed Data: Categories
-- ------------------------------------------------------------
INSERT INTO categories (category_name) VALUES
('Electronics'),
('Clothing'),
('Sports'),
('Home & Kitchen');

-- ------------------------------------------------------------
-- Seed Data: Products
-- ------------------------------------------------------------
INSERT INTO products (category_id, product_name, description, price, stock_quantity, image_url) VALUES
(1, 'HP Laptop',         'High performance laptop for work and study',     55000.00, 10, 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&q=80'),
(1, 'Samsung Galaxy A55','Latest Samsung mid-range smartphone 128GB',      42000.00, 15, 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=400&q=80'),
(2, 'Men Hoodie',        '100% cotton comfortable hoodie for men',          2500.00, 30, 'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?w=400&q=80'),
(4, 'Microwave Oven',    'Energy-saving 20L microwave oven',                8500.00, 12, 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=400&q=80'),
(3, 'Football',          'FIFA approved size 5 football',                    1200.00, 25, 'https://images.unsplash.com/photo-1575361204480-aadea25e6e68?w=400&q=80');

-- ------------------------------------------------------------
-- Image URL fixes applied during development
-- ------------------------------------------------------------
UPDATE products SET image_url = 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&q=80' WHERE product_id = 1;
UPDATE products SET image_url = 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=400&q=80' WHERE product_id = 2;
UPDATE products SET image_url = 'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?w=400&q=80' WHERE product_id = 3;
UPDATE products SET image_url = 'https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=400&q=80' WHERE product_id = 4;
UPDATE products SET image_url = 'https://images.unsplash.com/photo-1575361204480-aadea25e6e68?w=400&q=80' WHERE product_id = 5;
