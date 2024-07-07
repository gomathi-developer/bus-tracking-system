CREATE DATABASE userlog;

USE userlog;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('driver', 'admin') NOT NULL
);

CREATE TABLE drivers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    bus_number VARCHAR(20) NOT NULL,
    contact VARCHAR(20) NOT NULL,
    route VARCHAR(100) NOT NULL,
    FOREIGN KEY (username) REFERENCES users(username)
);

CREATE TABLE bus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    bus_number VARCHAR(20) NOT NULL,
    route VARCHAR(100) NOT NULL
);

CREATE TABLE schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    driver_username VARCHAR(50) NOT NULL,
    time VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    FOREIGN KEY (driver_username) REFERENCES users(username)
);

INSERT INTO users (username, password, user_type) VALUES
('admin', 'adminpassword', 'admin'),
('driver1', 'driver1password', 'driver'),
('driver2', 'driver2password', 'driver');

INSERT INTO drivers (username, password, name, bus_number, contact, route) VALUES
('driver1', 'driver1password', 'John Doe', 'Bus100', '1234567890', 'Route 1'),
('driver2', 'driver2password', 'Jane Smith', 'Bus200', '0987654321', 'Route 2');

INSERT INTO bus (bus_number, route) VALUES
('Bus100', 'Route 1'),
('Bus200', 'Route 2');
