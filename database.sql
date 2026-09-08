CREATE DATABASE IF NOT EXISTS aisha_db;
-- Operation: Creates the application database 'aisha_db' if it does not already exist.

USE aisha_db;
-- Operation: Selects 'aisha_db' as the active database for all following queries.

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    mobile VARCHAR(15) NOT NULL,
    email VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    country VARCHAR(50) NOT NULL,
    state VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Operation: Creates the 'users' table to store user registration data with an auto-incrementing ID and timestamp.
