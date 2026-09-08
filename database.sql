-- ====================================================================
-- DATABASE SCRIPT: database.sql
-- Project: Aisha PHP Responsive Form Project
-- Purpose: Creates the database and table to store user submissions
-- ====================================================================

-- 1. Create the database if it doesn't already exist
-- (IF NOT EXISTS prevents an error if the database was already created)
CREATE DATABASE IF NOT EXISTS aisha_db;

-- 2. Select / switch to the newly created database
USE aisha_db;

-- 3. Create the 'users' table to store form submissions
-- INTERVIEW NOTE: We use appropriate data types for each field:
-- - INT AUTO_INCREMENT: Gives each row a unique numeric ID automatically (1, 2, 3...)
-- - VARCHAR(length): Variable length string, saves storage space
-- - TEXT: For longer text like addresses
-- - TIMESTAMP: Automatically stores the current date and time when record is inserted
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,        -- Unique Primary Key for each user
    name VARCHAR(100) NOT NULL,               -- User's full name (mandatory)
    mobile VARCHAR(15) NOT NULL,              -- Mobile number (mandatory)
    email VARCHAR(100) NOT NULL,              -- Email address (mandatory)
    address TEXT NOT NULL,                    -- Full street address
    country VARCHAR(50) NOT NULL,             -- Selected country
    state VARCHAR(50) NOT NULL,               -- Selected or entered state
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Submission timestamp
);
