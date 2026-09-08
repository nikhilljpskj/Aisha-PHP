<?php
// ====================================================================
// FILE: functions.php
// PURPOSE: Reusable helper functions for database CRUD operations
//          (Create, Read, Update, Delete)
// INTERVIEW CONCEPT: Modular Programming (DRY - Don't Repeat Yourself)
// Instead of writing SQL queries multiple times across different files,
// we create separate small functions that can be called anywhere!
// ====================================================================

/**
 * Function 1: Fetch all users from the database
 * 
 * @param mysqli $conn The active database connection object from config.php
 * @return array An array of associative arrays containing all user records
 */
function getAllUsers($conn) {
    // SQL query to select all records, newest first (ORDER BY id DESC)
    $sql = "SELECT * FROM users ORDER BY id DESC";
    $result = $conn->query($sql);

    // Create an empty array to hold the rows
    $users = [];

    // Check if query succeeded and returned rows
    if ($result && $result->num_rows > 0) {
        // Fetch each row as an associative array and add to $users
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    // ================================================================
    // 🐞 DEBUGGING TIP:
    // To see what this function fetched, you can test it like this:
    // var_dump($users);
    // ================================================================

    return $users;
}

/**
 * Function 2: Fetch a single user by their unique ID
 * 
 * @param mysqli $conn The database connection
 * @param int $id The user's ID
 * @return array|null Returns user data array if found, null otherwise
 */
function getUserById($conn, $id) {
    // Validate that $id is a positive integer
    $id = (int)$id;
    if ($id <= 0) {
        return null;
    }

    // Prepared statement for safety
    $sql = "SELECT * FROM users WHERE id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return null;
    }

    // "i" means integer
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = null;
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }

    $stmt->close();
    return $user;
}

/**
 * Function 3: Delete a user by their unique ID
 * 
 * @param mysqli $conn The database connection
 * @param int $id The ID of the record to delete
 * @return bool True if successfully deleted, false otherwise
 */
function deleteUserById($conn, $id) {
    // Validate ID: ensure it is a valid integer > 0
    $id = (int)$id;
    if ($id <= 0) {
        return false;
    }

    // ================================================================
    // INTERVIEW POINT: Why prepared statement for DELETE?
    // An attacker might inject: "id = 1 OR 1=1" to wipe out the whole table!
    // A prepared statement guarantees only the exact integer ID is matched.
    // ================================================================
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        // Prepare failed
        return false;
    }

    // Bind $id as an integer ("i")
    $stmt->bind_param("i", $id);
    $success = $stmt->execute();

    // Check if any row was actually affected (deleted)
    if ($success && $stmt->affected_rows > 0) {
        $stmt->close();
        return true;
    }

    $stmt->close();
    return false;
}

/**
 * Function 4: Insert a new user into the database
 * 
 * @param mysqli $conn Database connection
 * @param string $name User full name
 * @param string $mobile Phone number
 * @param string $email Email address
 * @param string $address Street address
 * @param string $country Country name
 * @param string $state State name
 * @return bool True if inserted successfully, false otherwise
 */
function insertUser($conn, $name, $mobile, $email, $address, $country, $state) {
    $sql = "INSERT INTO users (name, mobile, email, address, country, state) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return false;
    }

    // "ssssss" means 6 strings
    $stmt->bind_param("ssssss", $name, $mobile, $email, $address, $country, $state);
    $success = $stmt->execute();
    $stmt->close();

    return $success;
}
?>
