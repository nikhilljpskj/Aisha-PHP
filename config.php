<?php
// ====================================================================
// FILE: config.php
// PURPOSE: Establishes connection between PHP and MySQL database
// ====================================================================

// --- 1. Database Credentials ---
// In a default local XAMPP setup:
// - Server host is usually "localhost"
// - Default MySQL user is "root"
// - Default password is empty "" (no password)
// - Database name is the one we created in database.sql ("aisha_db")
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "aisha_db";

// --- 2. Create Connection ---
// We use the modern Object-Oriented style of MySQLi:
$conn = new mysqli($servername, $username, $password, $dbname);

// --- 3. Check Connection ---
// If the connection fails, $conn->connect_error contains the error message.
// die() prints the error message and immediately stops the PHP script.
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// ====================================================================
// 🐞 DEBUGGING TIP (For Beginners / Small-scale testing):
// To verify if your database connection is working, uncomment the line below,
// open config.php in your browser (http://localhost/aisha-php/config.php),
// and check if it prints the connection object or success message!
//
// echo "<!-- DB Connected Successfully! -->";
// var_dump($conn); // Shows the connection object details (status, server_info, etc.)
// ====================================================================
?>
