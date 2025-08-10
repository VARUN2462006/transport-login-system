<?php
session_start();
require '../../db_connect.php';

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    echo "<p>Please log in to view your bookings.</p>";
    exit;
}

$email = $_SESSION['email'];

// Get user bookings (latest first)
$stmt = $conn->prepare("SELECT * FROM bookings WHERE email=? ORDER BY created_at DESC");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table border='1' cellspacing='0' cellpadding='8'>
            <tr>
                <th>ID</th>
                <th>Vehicle</th>
                <th>Distance (km)</th>
                <th>Total Price</th>
                <th>Date</th>
                <th>Time</th>
                <th>Payment</th>
                <th>Action</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['id']) . "</td>
                <td>" . htmlspecialchars($row['vehicle']) . "</td>
                <td>" . htmlspecialchars($row['distance_km']) . "</td>
                <td>₹" . number_format($row['total_price'], 2) . "</td>
                <td>" . htmlspecialchars($row['booking_date']) . "</td>
                <td>" . htmlspecialchars($row['booking_time']) . "</td>
                <td>" . htmlspecialchars($row['payment_method']) . "</td>
                <td><button onclick='cancelBooking(" . htmlspecialchars($row['id']) . ")'>Cancel</button></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No bookings found.</p>";
}

$conn->close();
?>
