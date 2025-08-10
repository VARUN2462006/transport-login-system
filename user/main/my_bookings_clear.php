<?php
session_start();
require '../../db_connect.php';
$email = $_SESSION['email'] ?? null;
if(!$email) { die("Login required."); }

$stmt = $conn->prepare("DELETE FROM bookings WHERE email=?");
$stmt->bind_param("s", $email);
if ($stmt->execute()) {
    echo "<script>alert('All bookings cleared.'); window.location='my_bookings.html';</script>";
} else {
    echo "<script>alert('Could not clear history'); window.location='my_bookings.html';</script>";
}
$conn->close();
?>
