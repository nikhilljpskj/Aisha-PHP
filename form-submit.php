<?php
// ====================================================================
// FILE: form-submit.php
// PURPOSE: Handles backend processing, sanitization, validation,
//          and secure database insertion using MySQLi Prepared Statements.
// ====================================================================

// --- 1. Include Database Connection ---
// 'require_once' ensures config.php is loaded. If missing, it halts execution.
require_once 'config.php';

// ====================================================================
// 🐞 BEGINNER DEBUGGING TIP #1 (How to check submitted form data):
// If you ever want to see what data the form sent to PHP, uncomment
// the 4 lines below and submit the form. It will print the array and stop!
//
// echo "<pre>";
// echo "<h2>Debugging \$_POST Data:</h2>";
// var_dump($_POST);
// echo "</pre>";
// exit(); // Stops the script here for inspection
// ====================================================================

// --- 2. Verify HTTP Request Method ---
// INTERVIEW POINT: Always verify that the form was submitted using POST.
// If someone visits "form-submit.php" directly in the browser via GET,
// redirect them back to the form page.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit();
}

// --- 3. Retrieve and Sanitize User Inputs ---
// - trim(): Removes accidental leading/trailing spaces.
// - htmlspecialchars(): Escapes special HTML characters (<, >, &, etc.)
//   to prevent XSS (Cross-Site Scripting) attacks.
$name    = isset($_POST['name'])    ? trim(htmlspecialchars($_POST['name']))    : '';
$mobile  = isset($_POST['mobile'])  ? trim(htmlspecialchars($_POST['mobile']))  : '';
$email   = isset($_POST['email'])   ? trim(htmlspecialchars($_POST['email']))   : '';
$address = isset($_POST['address']) ? trim(htmlspecialchars($_POST['address'])) : '';
$country = isset($_POST['country']) ? trim(htmlspecialchars($_POST['country'])) : '';
$state   = isset($_POST['state'])   ? trim(htmlspecialchars($_POST['state']))   : '';

// ====================================================================
// 🐞 BEGINNER DEBUGGING TIP #2 (Inspect individual sanitized variables):
// echo "Name: " . $name . "<br>";
// echo "Email: " . $email . "<br>";
// ====================================================================

// --- 4. Backend Validation (Server-Side Checks) ---
// INTERVIEW POINT: Why do we need backend validation if HTML5 has "required"?
// Because any user can easily disable HTML5 validation using browser inspect element!
// Server-side validation is the true line of defense.

$errorMessage = "";

// Check A: Verify no fields were submitted empty
if (empty($name) || empty($mobile) || empty($email) || empty($address) || empty($country) || empty($state)) {
    $errorMessage = "Please fill in all required fields.";
}
// Check B: Validate Email Format
// filter_var() checks if the string follows a valid standard email format (user@domain.com)
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorMessage = "Invalid email address format. Please enter a valid email.";
}
// Check C: Validate Mobile Number (Must be 10 to 15 digits only)
// preg_match() tests the variable against a regular expression pattern
elseif (!preg_match('/^[0-9]{10,15}$/', $mobile)) {
    $errorMessage = "Mobile number must contain only digits (between 10 to 15 digits).";
}

// If any validation failed, redirect back to index.php with error message
if (!empty($errorMessage)) {
    header("Location: index.php?status=error&msg=" . urlencode($errorMessage));
    exit();
}

// --- 5. Insert Data Using MySQLi Prepared Statements ---
// ====================================================================
// CRITICAL INTERVIEW TOPIC: PREPARED STATEMENTS
// What is a Prepared Statement?
// A feature used to execute the same (or similar) SQL statements repeatedly
// with high efficiency and absolute security against SQL Injection.
//
// How it works in 3 Simple Steps:
// Step A (Prepare): The SQL query blueprint is sent to the database with
//                   question mark '?' placeholders. The database compiles it.
// Step B (Bind)   : We bind the actual user variables into the placeholders.
//                   The database treats them strictly as plain DATA, not executable code.
// Step C (Execute): The database executes the statement safely.
// ====================================================================

// Step A: Prepare SQL blueprint with placeholders (?)
$sql = "INSERT INTO users (name, mobile, email, address, country, state) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Check if prepare() succeeded
if ($stmt === false) {
    // 🐞 Debugging note: $conn->error tells us what syntax went wrong in SQL
    $errorMsg = "Database prepare error: " . $conn->error;
    header("Location: index.php?status=error&msg=" . urlencode($errorMsg));
    exit();
}

// Step B: Bind Parameters
// The first parameter "ssssss" defines the data types for each corresponding '?' placeholder:
// 's' = string
// 'i' = integer
// 'd' = double
// 'b' = blob
// Here, all 6 columns are passed as strings ('s' repeated 6 times).
$stmt->bind_param("ssssss", $name, $mobile, $email, $address, $country, $state);

// Step C: Execute the statement
if ($stmt->execute()) {
    // Insertion was successful!
    // Close the statement and connection to free up server resources
    $stmt->close();
    $conn->close();

    // ================================================================
    // INTERVIEW POINT: Post/Redirect/Get (PRG) Pattern
    // Always redirect the user after a successful POST request.
    // This prevents form resubmission when the user clicks 'Refresh' (F5)!
    // ================================================================
    header("Location: index.php?status=success#form-section");
    exit();
} else {
    // Insertion failed: retrieve the error from $stmt->error
    $errorMsg = "Database execution error: " . $stmt->error;
    $stmt->close();
    $conn->close();

    header("Location: index.php?status=error&msg=" . urlencode($errorMsg));
    exit();
}
?>
