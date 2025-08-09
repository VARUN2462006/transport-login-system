<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false]);
    exit();
}

require 'config.php';

// Fetch user info
$userId = $_SESSION['user_id'];

// Get username
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
    echo json_encode(['success' => false]);
    exit();
}

// Get count of upcoming bookings
$stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE user_id = ? AND booking_date >= CURDATE()");
$stmt->execute([$userId]);
$upcomingBookings = $stmt->fetchColumn();

// Get active booking details (if any)
$stmt = $pdo->prepare("SELECT b.booking_date, v.vehicle_number FROM bookings b JOIN vehicles v ON b.vehicle_id = v.id WHERE b.user_id = ? AND b.booking_date = CURDATE() AND b.status = 'confirmed' LIMIT 1");
$stmt->execute([$userId]);
$activeBooking = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    'success' => true,
    'username' => $user['username'],
    'upcomingBookings' => $upcomingBookings,
    'activeBooking' => $activeBooking
]);
?>
