<?php
require '../db_connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    // In real app: generate token & send email
    $success = "If this email exists, a reset link will be sent.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="auth-container">
    <h2>Forgot Password</h2>
    <?php if (!empty($success)) echo "<div class='success'>$success</div>"; ?>
    <form method="post">
        <input type="email" name="email" placeholder="Your Admin Email" required>
        <button type="submit">Send Reset Link</button>
    </form>
    <div class="form-links">
        <a href="admin_login.php">⬅ Back to Login</a>
    </div>
</div>
</body>
</html>
