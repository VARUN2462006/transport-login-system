<?php
session_start();
require '../../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $vehicle = $_POST['vehicle'];
    $distance = floatval($_POST['distance']);
    $date = $_POST['booking_date'];
    $time = $_POST['booking_time'];
    $payment_method = $_POST['payment_method'];

    if (!$username || !$email || !$vehicle || $distance <= 0 || !$date || !$time || !$payment_method) {
        die("Please fill in all fields correctly.");
    }

    $prices = ["Pickup Truck" => 12, "Tempo" => 15, "Truck" => 45];
    if (!isset($prices[$vehicle])) {
        die("Invalid vehicle selected.");
    }
    $total_price = $prices[$vehicle] * $distance;

    $stmt = $conn->prepare("INSERT INTO bookings (username, email, vehicle, distance_km, total_price, booking_date, booking_time, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssddsss", $username, $email, $vehicle, $distance, $total_price, $date, $time, $payment_method);

    if ($stmt->execute()) {
        echo "<script>alert('Booking confirmed! Total price: ₹" . number_format($total_price, 2) . "'); window.location='my_bookings.html';</script>";
    } else {
        echo "<script>alert('Error: Could not complete booking.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
