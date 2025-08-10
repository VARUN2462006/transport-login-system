<?php
session_start();
require '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username and email entered
    if (!$username || !$email) {
        $error = "Please fill out all fields.";
    } else {
        // Check for existing admin email
        $check = $conn->prepare("SELECT id FROM admin WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Admin email already registered.";
        } else {
            $stmt = $conn->prepare("INSERT INTO admin (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password);
            if ($stmt->execute()) {
                // ✅ Redirect to login after success
                header("Location: admin_login.php?registered=1");
                exit();
            } else {
                $error = "Error creating admin.";
            }
            $stmt->close();
        }
        $check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="auth-container">
    <h2>Add New Admin</h2>
    <?php 
    if (!empty($error)) echo "<div class='error'>$error</div>"; 
    ?>
    <form method="post">
        <input type="text" name="username" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Admin Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Create Admin</button>
    </form>
    <div class="form-links">
        <a href="admin_login.php">⬅ Back to Login</a>
    </div>
</div>
</body>
</html>
