<?php
require 'admin_check.php';
require '../db_connect.php';

// Delete booking
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM bookings WHERE id = $id");
    header("Location: manage_bookings.php");
    exit();
}

$bookings = $conn->query("SELECT * FROM bookings ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Bookings</title>
<link rel="stylesheet" href="style.css">
<script src="script.js" defer></script>
</head>
<body>
<div class="admin-container">
    <h2>Manage Bookings</h2>
    <div class="dashboard-nav">
        <a href="admin_dashboard.php" class="btn">⬅ Back</a>
    </div>
    <div class="table-area">
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>User</th><th>Email</th><th>Vehicle</th>
                    <th>Distance</th><th>Price</th><th>Date</th><th>Time</th><th>Payment</th><th>Action</th>
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
                    <td><a class="btn logout" href="?delete=<?= $b['id'] ?>" onclick="return confirm('Delete this booking?')">Delete</a></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
