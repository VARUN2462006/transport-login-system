<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userlogin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username_user = $_POST['username'];
$email = $_POST['email'];
$vehicle_type = $_POST['vehicle'];
$distance_km = $_POST['distance'];
$price_per_km = $_POST['price_per_km'];
$total_price = $_POST['total_price'];
$booking_date = $_POST['date'];
$booking_time = $_POST['time'];
$payment_method = $_POST['payment'];

$stmt = $conn->prepare("INSERT INTO bookings (username, email, vehicle_type, distance_km, price_per_km, total_price, booking_date, booking_time, payment_method) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssddsss", $username_user, $email, $vehicle_type, $distance_km, $price_per_km, $total_price, $booking_date, $booking_time, $payment_method);

if ($stmt->execute()) {
    echo "<script>alert('Booking successful!'); window.location.href='../mainwebpage/main.html';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
