<?php
// Database connection (shared by all scripts)
$servername = "localhost";       // XAMPP host
$username   = "root";            // Default XAMPP username
$password   = "";                // Default XAMPP password (empty)
$dbname     = "transport_db";    // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to avoid encoding issues
$conn->set_charset("utf8mb4");
?>
