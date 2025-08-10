<?php
session_start();
require '../db_connect.php';

if (isset($_POST['username'], $_POST['email'], $_POST['password'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if user already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email=? LIMIT 1");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $error = "Email is already registered.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        if ($stmt->execute()) {
            $_SESSION['username'] = $username;
            $_SESSION['email']    = $email;
            header("Location: main/main.html");
            exit();
        } else {
            $error = "Registration failed. Try again.";
        }
        $stmt->close();
    }
    $check->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="main/main.css" />
</head>
<body>
<form method="post" action="">
    <h2>Register</h2>
    <?php if (!empty($error)) echo "<div style='color:red;'>$error</div>"; ?>
    <label>Name: <input type="text" name="username" required></label><br>
    <label>Email: <input type="email" name="email" required></label><br>
    <label>Password: <input type="password" name="password" required></label><br>
    <button type="submit">Register</button>
</form>
<a href="login.php">Login</a>
</body>
</html>
