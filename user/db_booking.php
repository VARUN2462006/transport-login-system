<?php
$host = "localhost";
$user = "root"; // default for XAMPP
$pass = "";     // leave blank unless you set a password
$db   = "transport_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
