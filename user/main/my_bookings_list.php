<?php
session_start();
require '../../db_connect.php';

// Temporary: using posted email for demo
// Replace with $_SESSION['email'] if you have login system
$email = $_SESSION['email'] ?? null;
if(!$email) { echo "<p>Please log in to view bookings.</p>"; exit; }

$stmt = $conn->prepare("SELECT * FROM bookings WHERE email=? ORDER BY created_at DESC");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Vehicle</th><th>Distance</th><th>Price</th><th>Date</th><th>Time</th><th>Payment</th><th>Action</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
          <td>{$row['id']}</td>
          <td>{$row['vehicle']}</td>
          <td>{$row['distance_km']}</td>
          <td>₹{$row['total_price']}</td>
          <td>{$row['booking_date']}</td>
          <td>{$row['booking_time']}</td>
          <td>{$row['payment_method']}</td>
          <td><button onclick='cancelBooking({$row['id']})'>Cancel</button></td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No bookings found.</p>";
}
$conn->close();
?>
