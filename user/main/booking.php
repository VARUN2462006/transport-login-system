<?php
session_start();
// Correct relative path to db_connect.php — adjust if needed
require '../../db_connect.php';

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$username = $_SESSION['username'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicle = trim($_POST['vehicle'] ?? '');
    $distance_km = floatval($_POST['distance_km'] ?? 0);
    $total_price = floatval($_POST['total_price'] ?? 0);
    $booking_date = $_POST['booking_date'] ?? '';
    $booking_time = $_POST['booking_time'] ?? '';
    $payment_method = $_POST['payment_method'] ?? '';

    if ($vehicle && $distance_km > 0 && $total_price > 0 && $booking_date && $booking_time && $payment_method) {
        $stmt = $conn->prepare("INSERT INTO bookings 
            (username, email, vehicle, distance_km, total_price, booking_date, booking_time, payment_method, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssdssss", $username, $email, $vehicle, $distance_km, $total_price, $booking_date, $booking_time, $payment_method);

        if ($stmt->execute()) {
            $success = "Booking successfully created!";
        } else {
            $error = "Error saving booking. Please try again.";
        }
        $stmt->close();
    } else {
        $error = "Please fill all fields with valid values.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book a Vehicle</title>
<style>
body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background: #f4f6fa;
    margin: 0; padding: 0;
}

.container {
    max-width: 550px;
    margin: 50px auto;
    background: #ffffffcc;
    padding: 30px;
    border-radius: 14px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    backdrop-filter: blur(12px);
}

h2 {
    text-align: center;
    color: #264476;
    margin-bottom: 20px;
}

.success, .error {
    padding: 12px;
    border-radius: 6px;
    margin-bottom: 15px;
    font-size: 0.95rem;
}
.success { background: #e6ffed; color: #2d7a46; border: 1px solid #99e2b4; }
.error { background: #ffe6e6; color: #a94442; border: 1px solid #e2b4b4; }

label {
    display: block;
    margin-top: 12px;
    font-weight: 600;
    color: #333;
}

input, select, button {
    width: 100%;
    padding: 10px 12px;
    margin-top: 6px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    box-sizing: border-box;
    transition: border 0.2s;
}

input:focus, select:focus {
    border-color: #264476;
    outline: none;
}

button {
    background: #264476;
    color: white;
    font-weight: bold;
    cursor: pointer;
    margin-top: 20px;
    transition: background 0.25s ease;
}
button:hover {
    background: #1a2f59;
}

@media (max-width: 600px) {
    .container {
        margin: 20px;
        padding: 20px;
    }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        document.querySelectorAll('.success, .error').forEach(el => el.style.display = 'none');
    }, 3000);
});

function updatePrice() {
    const distance = parseFloat(document.getElementById('distance').value) || 0;
    const pricePerKm = parseFloat(document.querySelector('select[name="vehicle"] option:checked').dataset.price) || 0;
    document.getElementById('total_price').value = (distance * pricePerKm).toFixed(2);
}
</script>
</head>
<body>

<div class="container">
    <h2>Book a Vehicle</h2>

    <?php if (!empty($success)) echo "<div class='success'>" . htmlspecialchars($success) . "</div>"; ?>
    <?php if (!empty($error)) echo "<div class='error'>" . htmlspecialchars($error) . "</div>"; ?>

    <form method="post">
        <label>Vehicle:</label>
        <select name="vehicle" onchange="updatePrice()" required>
            <option value="">-- Select Vehicle --</option>
            <?php
            $vehicles = $conn->query("SELECT name, price_per_km FROM vehicles ORDER BY name ASC");
            while ($v = $vehicles->fetch_assoc()) {
                echo "<option value='".htmlspecialchars($v['name'])."' data-price='".htmlspecialchars($v['price_per_km'])."'>"
                    .htmlspecialchars($v['name'])." (₹".number_format($v['price_per_km'], 2)."/km)"
                    ."</option>";
            }
            ?>
        </select>

        <label>Distance (km):</label>
        <input type="number" id="distance" name="distance_km" min="1" step="0.1" oninput="updatePrice()" required>

        <label>Total Price (₹):</label>
        <input type="number" id="total_price" name="total_price" readonly required>

        <label>Date:</label>
        <input type="date" name="booking_date" required>

        <label>Time:</label>
        <input type="time" name="booking_time" required>

        <label>Payment Method:</label>
        <select name="payment_method" required>
            <option value="">-- Select Payment Method --</option>
            <option value="Cash">Cash</option>
            <option value="UPI">UPI</option>
            <option value="Credit Card">Credit Card</option>
        </select>

        <button type="submit">Confirm Booking</button>
    </form>
</div>

</body>
</html>
