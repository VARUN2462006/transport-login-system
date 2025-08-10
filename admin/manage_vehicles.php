<?php
require 'admin_check.php';
require '../db_connect.php';

// Add new vehicle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['vehicle_name'])) {
    $name = trim($_POST['vehicle_name']);
    $price = floatval($_POST['price_per_km']);
    $stmt = $conn->prepare("INSERT INTO vehicles (name, price_per_km) VALUES (?,?)");
    $stmt->bind_param("sd", $name, $price);
    $stmt->execute();
    header("Location: manage_vehicles.php");
    exit();
}

// Delete vehicle
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM vehicles WHERE id = $id");
    header("Location: manage_vehicles.php");
    exit();
}

$vehicles = $conn->query("SELECT * FROM vehicles");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Vehicles</title>
<link rel="stylesheet" href="style.css">
<script src="script.js" defer></script>
</head>
<body>
<div class="admin-container">
    <h2>Manage Vehicles</h2>
    <div class="dashboard-nav">
        <a href="admin_dashboard.php" class="btn">⬅ Back</a>
    </div>

    <form method="post" style="display:flex;gap:18px;flex-wrap:wrap;justify-content:center;">
        <input type="text" name="vehicle_name" placeholder="Vehicle Name" required style="max-width:200px;">
        <input type="number" step="0.01" name="price_per_km" placeholder="Price/km" required style="max-width:140px;">
        <button type="submit" style="max-width:120px;">Add</button>
    </form>

    <div class="table-area">
    <table>
        <thead><tr><th>ID</th><th>Name</th><th>Price/km</th><th>Action</th></tr></thead>
        <tbody>
        <?php while($v = $vehicles->fetch_assoc()): ?>
        <tr>
            <td><?= $v['id'] ?></td>
            <td><?= htmlspecialchars($v['name']) ?></td>
            <td><?= $v['price_per_km'] ?></td>
            <td><a class="btn logout" href="?delete=<?= $v['id'] ?>" onclick="return confirm('Delete this vehicle?')">Delete</a></td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>
</body>
</html>
