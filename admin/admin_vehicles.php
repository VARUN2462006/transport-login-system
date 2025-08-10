<?php
require 'admin_check.php';
require '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['vehicle_name'])) {
    $name = trim($_POST['vehicle_name']);
    $price = floatval($_POST['price_per_km']);
    $stmt = $conn->prepare("INSERT INTO vehicles (name, price_per_km) VALUES (?,?)");
    $stmt->bind_param("sd", $name, $price);
    $stmt->execute();
}

$vehicles = $conn->query("SELECT * FROM vehicles");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Vehicles</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="admin-container">
    <h2>Vehicles & Pricing</h2>
    <div class="dashboard-nav">
        <a href="admin_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
    <form method="post" style="display:flex;gap:18px;flex-wrap:wrap;justify-content:center;">
        <input type="text" name="vehicle_name" placeholder="Vehicle Name" required style="max-width:160px;">
        <input type="number" step="0.01" name="price_per_km" placeholder="Price/km" required style="max-width:120px;">
        <button type="submit" style="max-width:100px;">Add</button>
    </form>
    <div class="table-area">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Price/km</th></tr></thead>
        <tbody>
        <?php while($v = $vehicles->fetch_assoc()): ?>
        <tr>
            <td><?= $v['id'] ?></td>
            <td><?= htmlspecialchars($v['name']) ?></td>
            <td><?= $v['price_per_km'] ?></td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>
</body>
</html>
