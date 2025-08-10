<?php
session_start();
require '../../db_connect.php';
$email = $_SESSION['email'] ?? null;
if(!$email) { die("Login required."); }

$id = intval($_GET['id']);
$stmt = $conn->prepare("DELETE FROM bookings WHERE id=? AND email=?");
$stmt->bind_param("is", $id, $email);
if ($stmt->execute()) {
    echo "<script>alert('Booking cancelled.'); window.location='my_bookings.html';</script>";
} else {
    echo "<script>alert('Could not cancel booking'); window.location='my_bookings.html';</script>";
}
$conn->close();
?>
