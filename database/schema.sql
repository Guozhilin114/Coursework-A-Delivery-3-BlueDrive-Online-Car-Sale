CREATE DATABASE IF NOT EXISTS online_car_sale;
USE online_car_sale;

CREATE TABLE IF NOT EXISTS sellers (
    seller_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS cars (
    car_id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT NOT NULL,
    brand VARCHAR(50),
    model VARCHAR(100) NOT NULL,
    year INT NOT NULL,
    mileage VARCHAR(50),
    fuel_type VARCHAR(50),
    transmission VARCHAR(50),
    colour VARCHAR(50),
    location VARCHAR(100),
    price DECIMAL(10,2),
    image_path VARCHAR(500),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (seller_id) REFERENCES sellers(seller_id)
);
