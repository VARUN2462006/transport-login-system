<?php
require 'admin_check.php';
require '../db_connect.php';

$users = $conn->query("SELECT id, username, email, is_admin FROM users ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Users</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="admin-container">
    <h2>Registered Users</h2>
    <div class="dashboard-nav">
        <a href="admin_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
    <div class="table-area">
    <table>
        <thead>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Admin?</th></tr>
        </thead>
        <tbody>
        <?php while($u = $users->fetch_assoc()): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['username']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= $u['is_admin'] ? 'Yes' : 'No' ?></td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>
</body>
</html>
