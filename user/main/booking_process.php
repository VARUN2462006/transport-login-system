<?php
session_start();
require '../../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch POST data safely
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $vehicle_id = intval($_POST['vehicle_id'] ?? 0);
    $distance = floatval($_POST['distance_km'] ?? 0);
    $date = $_POST['booking_date'] ?? '';
    $time = $_POST['booking_time'] ?? '';
    $payment_method = $_POST['payment_method'] ?? '';

    // Validate required fields
    if (!$username || !$email || $vehicle_id <= 0 || $distance <= 0 || !$date || !$time || !$payment_method) {
        die("Please fill in all fields correctly.");
    }

    // ✅ Fetch live vehicle info from DB
    $stmt = $conn->prepare("SELECT name, price_per_km FROM vehicles WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $vehicle_id);
    $stmt->execute();
    $vehicleData = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$vehicleData) {
        die("Invalid vehicle selected.");
    }

    $vehicleName = $vehicleData['name'];
    $pricePerKm = (float)$vehicleData['price_per_km'];

    // Calculate total price live from DB values
    $total_price = $pricePerKm * $distance;

    // Insert booking into DB
    $stmt = $conn->prepare("INSERT INTO bookings 
        (username, email, vehicle, distance_km, total_price, booking_date, booking_time, payment_method) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "sssddsss", 
        $username, 
        $email, 
        $vehicleName, 
        $distance, 
        $total_price, 
        $date, 
        $time, 
        $payment_method
    );

    if ($stmt->execute()) {
        echo "<script>
            alert('Booking confirmed! Total price: ₹" . number_format($total_price, 2) . "');
            window.location='my_bookings.php';
        </script>";
    } else {
        echo "<script>
            alert('Error: Could not complete booking.');
            window.history.back();
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
