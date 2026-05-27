CREATE DATABASE IF NOT EXISTS smart_ecommerce;
USE smart_ecommerce;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','customer') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status ENUM('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Seed data
INSERT INTO categories (name) VALUES ('Electronics'),('Clothing'),('Books'),('Home & Garden');

INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@shop.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('Jane Doe', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer');
-- Default password: password

INSERT INTO products (category_id, name, description, price, stock, image) VALUES
(1, 'Wireless Headphones', 'Premium noise-cancelling headphones', 4999.00, 20, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400'),
(1, 'Smartphone X12', 'Latest flagship smartphone 128GB', 65000.00, 15, 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400'),
(2, 'Classic T-Shirt', '100% cotton comfortable tee', 850.00, 50, 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400'),
(3, 'Web Development Guide', 'Full-stack development from scratch', 1200.00, 30, 'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=400'),
(4, 'Desk Lamp LED', 'Energy-saving adjustable desk lamp', 1500.00, 25, 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=400'),
(1, 'Bluetooth Speaker', 'Portable waterproof speaker', 3200.00, 18, 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?w=400');
