
USE studentdb;

-- CREATE (Add Records)
INSERT INTO students (first_name, last_name, email, date_of_birth, course, enrollment_date)
VALUES ('John', 'Doe', 'john.doe@email.com', '2002-05-14', 'Computer Science', '2024-01-10');

INSERT INTO students (first_name, last_name, email, date_of_birth, course, enrollment_date)
VALUES ('Jane', 'Smith', 'jane.smith@email.com', '2003-08-22', 'Information Technology', '2024-01-10');

INSERT INTO courses (course_name, duration_years)
VALUES ('Computer Science', 3);

INSERT INTO courses (course_name, duration_years)
VALUES ('Information Technology', 3);

-- READ (View Records)
SELECT * FROM students;
SELECT * FROM courses;
SELECT id, first_name, last_name, course FROM students WHERE course = 'Computer Science';

-- UPDATE (Edit Records)
UPDATE students
SET email = 'john.updated@email.com'
WHERE id = 1;

UPDATE students
SET course = 'Information Technology'
WHERE id = 2;

-- DELETE (Delete Records)
DELETE FROM students WHERE id = 2;


-- =====================
-- 2. productdb CRUD
-- =====================
USE productdb;

-- CREATE
INSERT INTO categories (category_name, description)
VALUES ('Electronics', 'Electronic devices and accessories');

INSERT INTO products (product_name, description, price, stock_quantity, category)
VALUES ('Laptop', '15-inch laptop, 8GB RAM', 999.99, 10, 'Electronics');

INSERT INTO products (product_name, description, price, stock_quantity, category)
VALUES ('Mouse', 'Wireless optical mouse', 25.99, 50, 'Electronics');

-- READ
SELECT * FROM products;
SELECT * FROM categories;
SELECT product_name, price FROM products WHERE price < 100.00;

-- UPDATE
UPDATE products
SET price = 899.99
WHERE product_name = 'Laptop';

UPDATE products
SET stock_quantity = stock_quantity - 1
WHERE id = 1;

-- DELETE
DELETE FROM products WHERE id = 2;


-- =====================
-- 3. authdb CRUD
-- =====================
USE authdb;

-- CREATE
INSERT INTO users (username, email, password, role)
VALUES ('admin', 'admin@email.com', '1234', 'admin');

INSERT INTO users (username, email, password, role)
VALUES ('brian', 'brian@email.com', '1234', 'user');

-- READ
SELECT * FROM users;
SELECT id, username, role FROM users WHERE role = 'admin';

-- UPDATE
UPDATE users
SET password = 'newpassword123'
WHERE username = 'brian';

UPDATE users
SET role = 'admin'
WHERE id = 2;

-- DELETE
DELETE FROM users WHERE id = 2;
