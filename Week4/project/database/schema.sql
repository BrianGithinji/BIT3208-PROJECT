-- ── database/schema.sql ──────────────────────────────────────────────────
-- Database schema for the BIT3208 Week 4 project.
-- Run this file in phpMyAdmin or via: mysql -u root -p < database/schema.sql

CREATE DATABASE IF NOT EXISTS bit3208_week4
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE bit3208_week4;

-- ── Users table ───────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS users (
    id         INT UNSIGNED    AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(50)     NOT NULL UNIQUE,
    password   VARCHAR(255)    NOT NULL,          -- bcrypt hash, never plain text
    name       VARCHAR(100)    NOT NULL,
    email      VARCHAR(150)    NOT NULL UNIQUE,
    course     VARCHAR(50)     NOT NULL DEFAULT '',
    role       ENUM('Student', 'Administrator') NOT NULL DEFAULT 'Student',
    created_at TIMESTAMP       DEFAULT CURRENT_TIMESTAMP
);

-- ── Seed data (passwords are bcrypt hashes) ───────────────────────────────
-- brian  → plain text: "secret"
-- admin  → plain text: "password"
INSERT INTO users (username, password, name, email, course, role) VALUES
(
    'brian',
    '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B9bd/C2',
    'Brian Doe',
    'brian@example.com',
    'BIT',
    'Student'
),
(
    'admin',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Admin User',
    'admin@example.com',
    'N/A',
    'Administrator'
);

-- ── Sessions table (optional — for DB-backed sessions) ────────────────────
-- Uncomment if you want to store sessions in the database instead of files.
--
-- CREATE TABLE IF NOT EXISTS sessions (
--     session_id   VARCHAR(128)  NOT NULL PRIMARY KEY,
--     user_id      INT UNSIGNED  NOT NULL,
--     ip_address   VARCHAR(45)   NOT NULL,
--     last_active  TIMESTAMP     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
--     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
-- );
