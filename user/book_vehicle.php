<?php
session_start();
require_once 'db_connect1.php';  // Update with your DB connection file path

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize inputs
    $vehicleType = trim($_POST['vehicleType'] ?? '');
    $bookingDate = trim($_POST['bookingDate'] ?? '');
    $bookingTime = trim($_POST['bookingTime'] ?? '');
    $contactName = trim($_POST['contactName'] ?? '');
    $contactPhone = trim($_POST['contactPhone'] ?? '');
    $paymentAmount = trim($_POST['paymentAmount'] ?? '');

    // Validate required fields
    if (
        empty($vehicleType) ||
        empty($bookingDate) ||
        empty($bookingTime) ||
        empty($contactName) ||
        empty($contactPhone) ||
        empty($paymentAmount)
    ) {
        echo "Please fill all required fields.";
        exit;
    }

    // Prepare and execute insert
    $stmt = $conn->prepare("INSERT INTO bookings (vehicle_type, booking_date, booking_time, contact_name, contact_phone, payment_amount) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssssd", $vehicleType, $bookingDate, $bookingTime, $contactName, $contactPhone, $paymentAmount);

    if ($stmt->execute()) {
        echo "Booking successful! Thank you, $contactName.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    echo "Invalid request method.";
}
?>
