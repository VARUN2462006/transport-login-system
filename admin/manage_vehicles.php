<?php
require 'admin_check.php';
require '../db_connect.php';

// Add vehicle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_vehicle'])) {
    $name = trim($_POST['vehicle_name']);
    $price = floatval($_POST['price_per_km']);
    if ($name && $price > 0) {
        $stmt = $conn->prepare("INSERT INTO vehicles (name, price_per_km) VALUES (?, ?)");
        $stmt->bind_param("sd", $name, $price);
        $stmt->execute();
    }
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

// Update vehicle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_vehicle'])) {
    $id = intval($_POST['vehicle_id']);
    $name = trim($_POST['vehicle_name']);
    $price = floatval($_POST['price_per_km']);
    $stmt = $conn->prepare("UPDATE vehicles SET name=?, price_per_km=? WHERE id=?");
    $stmt->bind_param("sdi", $name, $price, $id);
    $stmt->execute();
    header("Location: manage_vehicles.php");
    exit();
}

$vehicles = $conn->query("SELECT * FROM vehicles ORDER BY name ASC");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Manage Vehicles</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="admin-container">
<h2>Manage Vehicles</h2>
<div class="dashboard-nav">
    <a href="admin_dashboard.php" class="btn">⬅ Back to Dashboard</a>
</div>

<!-- Add New Vehicle -->
<form method="post" style="display:flex;gap:10px;flex-wrap:wrap;justify-content:center;">
    <input type="text" name="vehicle_name" placeholder="Vehicle Name" required>
    <input type="number" step="0.01" name="price_per_km" placeholder="Price/km" required>
    <button type="submit" name="add_vehicle">Add Vehicle</button>
</form>

<!-- Vehicles Table -->
<div class="table-area">
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Vehicle</th>
            <th>Price/km</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($v = $vehicles->fetch_assoc()): ?>
        <tr>
            <form method="post">
                <td><?= $v['id'] ?></td>
                <td><input type="text" name="vehicle_name" value="<?= htmlspecialchars($v['name']) ?>" required></td>
                <td><input type="number" step="0.01" name="price_per_km" value="<?= $v['price_per_km'] ?>" required></td>
                <td>
                    <input type="hidden" name="vehicle_id" value="<?= $v['id'] ?>">
                    <button type="submit" name="update_vehicle">Update</button>
                    <a class="btn logout" href="?delete=<?= $v['id'] ?>" onclick="return confirm('Delete this vehicle?')">Delete</a>
                </td>
            </form>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
</div>
</div>
</body>
</html>
