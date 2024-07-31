-- create db
CREATE DATABASE 2024_wms;

-- create tables
CREATE TABLE staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    contact_no VARCHAR(255) NOT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE customer (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    contact_no VARCHAR(255) NOT NULL,
    address VARCHAR(255)
);

CREATE TABLE supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    contact_no VARCHAR(255) NOT NULL,
    address VARCHAR(255)
);

CREATE TABLE product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image VARCHAR(255),
    cas_number VARCHAR(50) NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    packaging VARCHAR(50), 
    unit_price DECIMAL(10, 2)
);

CREATE TABLE inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    quantity DECIMAL(10), 
    datetime DATETIME,
    location VARCHAR(50),
    remarks TEXT,
    product_id INT,
    supplier_id INT,
    FOREIGN KEY (product_id) REFERENCES product(id),
    FOREIGN KEY (supplier_id) REFERENCES supplier(id)
);

-- insert into tables
INSERT INTO staff (name, email, contact_no, username, password) VALUES 
('Admin123', 'admin123@mail.com', '0187865555', 'admin123', 'admin123');

INSERT INTO customer (name, email, contact_no, address) VALUES
('Customer One', 'customer1@example.com', '123-456-7890', '111 Main St, City A'),
('Customer Two', 'customer2@example.com', '234-567-8901', '222 Elm St, City B'),
('Customer Three', 'customer3@example.com', '345-678-9012', '333 Oak St, City C'),
('Customer Four', 'customer4@example.com', '456-789-0123', '444 Pine St, City D'),
('Customer Five', 'customer5@example.com', '567-890-1234', '555 Maple St, City E');

INSERT INTO supplier (name, email, contact_no, address) VALUES
('Supplier One', 'supplier1@example.com', '123-456-7890', '123 Main St, City A'),
('Supplier Two', 'supplier2@example.com', '234-567-8901', '456 Elm St, City B'),
('Supplier Three', 'supplier3@example.com', '345-678-9012', '789 Oak St, City C'),
('Supplier Four', 'supplier4@example.com', '456-789-0123', '101 Pine St, City D'),
('Supplier Five', 'supplier5@example.com', '567-890-1234', '202 Maple St, City E');

INSERT INTO product (image, cas_number, name, description, packaging, unit_price) VALUES
('hcl.jpeg', '7647-01-0', 'Hydrochloric Acid', 'A strong corrosive acid used in various industrial processes.', '1L Bottle', 25.00),
('h2so4.jpeg', '7664-93-9', 'Sulfuric Acid', 'A highly corrosive strong mineral acid used in batteries and industrial processes.', '1L Bottle', 30.00),
('sodiumhydroxide.jpeg', '1310-73-2', 'Sodium Hydroxide', 'A strong base used in soap making and chemical synthesis.', '500g Bottle', 20.00),
('ammoniumhydroxide.jpeg', '1336-21-6', 'Ammonium Hydroxide', 'A solution of ammonia in water, used in cleaning products and as a precursor to other chemicals.', '1L Bottle', 15.00),
('methanol.jpeg', '67-56-1', 'Methanol', 'A volatile, flammable liquid used as a solvent and antifreeze.', '1L Bottle', 10.00),
('ethanol.jpeg', '64-17-5', 'Ethanol', 'A commonly used solvent and disinfectant.', '1L Bottle', 12.00);

INSERT INTO inventory (quantity, datetime, location, remarks, product_id, supplier_id) VALUES 
(100, '2024-07-31 10:00:00', 'Warehouse A', 'No defects', 1, 1),
(100, '2024-07-31 10:00:00', 'Warehouse A', 'No defects', 1, 2),
(100, '2024-07-31 10:00:00', 'Warehouse B', 'No defects', 1, 3),
(200, '2024-07-31 10:00:00', 'Warehouse B', 'No defects', 1, 4),
(20, '2024-07-31 10:00:00', 'Warehouse B', 'No defects', 2, 1),
(50, '2024-07-31 10:00:00', 'Warehouse C', 'No defects', 2, 2),
(100, '2024-07-31 10:00:00', 'Warehouse C', 'No defects', 2, 3),
(20, '2024-07-31 10:00:00', 'Warehouse B', 'No defects', 3, 1),
(50, '2024-07-31 10:00:00', 'Warehouse C', 'No defects', 3, 2),
(1006, '2024-07-31 10:00:00', 'Warehouse C', 'No defects', 4, 1);
