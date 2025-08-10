<?php
require 'admin_check.php';
require '../db_connect.php';

$bookings = $conn->query("SELECT * FROM bookings ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Bookings</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="admin-container">
    <h2>Bookings History</h2>
    <div class="dashboard-nav">
        <a href="admin_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
    <div class="table-area">
    <table>
        <thead>
        <tr>
            <th>ID</th><th>User</th><th>Email</th><th>Vehicle</th>
            <th>Distance</th><th>Price</th><th>Date</th><th>Time</th><th>Payment</th>
        </tr>
        </thead>
        <tbody>
        <?php while($b = $bookings->fetch_assoc()): ?>
        <tr>
            <td><?= $b['id'] ?></td>
            <td><?= htmlspecialchars($b['username']) ?></td>
            <td><?= htmlspecialchars($b['email']) ?></td>
            <td><?= htmlspecialchars($b['vehicle']) ?></td>
            <td><?= $b['distance_km'] ?></td>
            <td>₹<?= $b['total_price'] ?></td>
            <td><?= $b['booking_date'] ?></td>
            <td><?= $b['booking_time'] ?></td>
            <td><?= htmlspecialchars($b['payment_method']) ?></td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>
</body>
</html>
