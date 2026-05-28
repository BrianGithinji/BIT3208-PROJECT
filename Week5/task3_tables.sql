-- Task 3: Creating Tables
-- BIT3208 Advanced Web Design

-- =====================
-- 1. studentdb Tables
-- =====================
USE studentdb;

DROP TABLE IF EXISTS students;
CREATE TABLE students (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    email VARCHAR(100),
    date_of_birth DATE,
    course VARCHAR(100),
    enrollment_date DATE
);

DROP TABLE IF EXISTS courses;
CREATE TABLE courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_name VARCHAR(100),
    duration_years INT
);

-- =====================
-- 2. productdb Tables
-- =====================
USE productdb;

DROP TABLE IF EXISTS products;
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(100),
    description TEXT,
    price DECIMAL(10, 2),
    stock_quantity INT,
    category VARCHAR(50)
);

DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(100),
    description TEXT
);

-- =====================
-- 3. authdb Tables
-- =====================
USE authdb;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(255),
    role VARCHAR(20)
);

DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    session_token VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NULL DEFAULT NULL
);
