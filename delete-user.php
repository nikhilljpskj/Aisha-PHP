<?php
// ====================================================================
// FILE: delete-user.php
// PURPOSE: Processes deletion of a specific user record from database
// ====================================================================

// 1. Include database connection and helper functions
require_once 'config.php';
require_once 'functions.php';

// ====================================================================
// 🐞 DEBUGGING TIP:
// To see what ID was received from the link, you can test it like this:
// echo "<pre>";
// var_dump($_GET);
// echo "</pre>";
// exit();
// ====================================================================

// 2. Validate the incoming 'id' parameter
// We check if 'id' exists and is a valid number
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    // 3. Call our dedicated helper function to delete the record
    $deleted = deleteUserById($conn, $id);

    // 4. Close database connection
    $conn->close();

    // 5. Redirect back to users.php with feedback status
    if ($deleted) {
        header("Location: users.php?status=deleted");
        exit();
    } else {
        header("Location: users.php?status=error&msg=" . urlencode("Could not delete record (ID may not exist)."));
        exit();
    }
} else {
    // If no valid ID was provided, close connection and redirect
    $conn->close();
    header("Location: users.php?status=error&msg=" . urlencode("Invalid user ID provided."));
    exit();
}
?>
