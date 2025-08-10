<?php
require 'admin_check.php';
require '../db_connect.php';

// Delete user
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id = $id");
    header("Location: manage_users.php");
    exit();
}

$users = $conn->query("SELECT id, username, email, is_admin FROM users ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Users</title>
<link rel="stylesheet" href="style.css">
<script src="script.js" defer></script>
</head>
<body>
<div class="admin-container">
    <h2>Manage Users</h2>
    <div class="dashboard-nav">
        <a href="admin_dashboard.php" class="btn">⬅ Back</a>
    </div>
    <div class="table-area">
        <table>
            <thead>
                <tr><th>ID</th><th>Name</th><th>Email</th><th>Admin?</th><th>Action</th></tr>
            </thead>
            <tbody>
            <?php while($u = $users->fetch_assoc()): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['username']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= $u['is_admin'] ? 'Yes' : 'No' ?></td>
                    <td>
                        <?php if ($_SESSION['admin_id'] != $u['id']): ?>
                            <a class="btn logout" href="?delete=<?= $u['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
                        <?php else: ?>
                            <em>Current Admin</em>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
