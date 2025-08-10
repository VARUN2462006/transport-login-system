<?php
require 'admin_check.php';
require '../db_connect.php';

// Dashboard counters
$totalBookings = $conn->query("SELECT COUNT(*) AS c FROM bookings")->fetch_assoc()['c'] ?? 0;
$totalUsers    = $conn->query("SELECT COUNT(*) AS c FROM users")->fetch_assoc()['c'] ?? 0;
$totalRevenue  = $conn->query("SELECT SUM(total_price) AS s FROM bookings")->fetch_assoc()['s'] ?? 0;
$today = date("F j, Y");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
    <style>
    /* Compact dashboard tweaks */
    .admin-container { 
        max-width: 900px;
        padding: 25px;
        margin: 30px auto;
    }
    h1 { font-size: 1.6rem; margin-bottom: 0.3em; }
    .stats-grid { display: flex; gap: 15px; flex-wrap: wrap; justify-content: center; }
    .stat-card {
        background: #fff;
        color: #222;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border-radius: 10px;
        padding: 18px 20px;
        text-align: center;
        flex: 1 0 200px;
        min-width: 180px;
    }
    .stat-card h4 { font-size: 1rem; margin-bottom: 6px; }
    .stat-card .icon { font-size: 1.8rem; margin-bottom: 4px; opacity: 0.85; }
    .fs-3 { font-size: 1.4rem; font-weight: 600; }
    .dashboard-nav { margin-bottom: 20px; }
    .dashboard-nav .btn { font-size: 0.85rem; padding: 7px 12px; }
    @media (max-width: 768px) {
        .stat-card { padding: 14px; }
        .fs-3 { font-size: 1.2rem; }
    }
    </style>
</head>
<body>
<div class="admin-container">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['admin_name']) ?></h1>
    <div style="text-align:center;font-size:0.9rem;opacity:.7;margin-bottom:20px;">
        <?= $today ?>
    </div>
    <div class="dashboard-nav" style="text-align:center;">
        <a href="manage_bookings.php" class="btn">📚 Bookings</a>
        <a href="manage_users.php" class="btn">👤 Users</a>
        <a href="manage_vehicles.php" class="btn">🚚 Vehicles</a>
        <a href="logout.php" class="btn logout">🚪 Logout</a>
    </div>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="icon">📚</div>
            <h4>Total Bookings</h4>
            <div class="fs-3"><?= $totalBookings ?></div>
        </div>
        <div class="stat-card">
            <div class="icon">👥</div>
            <h4>Total Users</h4>
            <div class="fs-3"><?= $totalUsers ?></div>
        </div>
        <div class="stat-card">
            <div class="icon" style="color:#3ec27e;">₹</div>
            <h4>Total Revenue</h4>
            <div class="fs-3" style="font-family:monospace;">
                ₹<?= number_format(floatval($totalRevenue), 2) ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
