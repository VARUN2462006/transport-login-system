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
    /* A few dashboard-specific touch-ups */
    .stats-grid { display: flex; gap: 20px; flex-wrap: wrap; justify-content: center;}
    .stat-card {
        background: linear-gradient(120deg, #fff6e0 60%, #e3ebff 100%);
        color: #222;
        box-shadow: 0 4px 24px 0 rgba(24,34,58,0.07);
        border-radius: 15px;
        padding: 30px 35px;
        text-align: center;
        margin: 0 10px 18px 0;
        min-width: 210px;
        flex: 1 0 260px;
    }
    .stat-card h4 {font-size: 1.13rem; margin-bottom: 1.1rem;}
    .stat-card .icon {font-size: 2.5rem; margin-bottom:10px; opacity:.9;}
    .fs-3 { font-size: 2.2rem; font-weight: 700;}
    @media (max-width: 899px) {
        .stats-grid {flex-direction:column;gap:12px;}
        .stat-card {margin:0 0 15px;}
    }
    .dashboard-nav { margin-bottom:32px; }
    </style>
</head>
<body>
<div class="admin-container">
    <h1 style="margin-bottom:0.4em;">Welcome, <?= htmlspecialchars($_SESSION['admin_name']) ?></h1>
    <div style="text-align:center;font-size:1.04rem;opacity:.74;margin-bottom:30px;">
        <span><?= $today ?></span>
    </div>
    <div class="dashboard-nav">
        <a href="manage_bookings.php" class="btn">📚 Manage Bookings</a>
        <a href="manage_users.php" class="btn">👤 Manage Users</a>
        <a href="manage_vehicles.php" class="btn">🚚 Manage Vehicles</a>
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
            <div class="fs-3" style="font-family:monospace;font-weight:800;">
                ₹<?= number_format(floatval($totalRevenue), 2) ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
