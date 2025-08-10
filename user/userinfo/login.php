<?php
session_start();

// ✅ Use __DIR__ to always reference from this file's own folder
require_once __DIR__ . '/../../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email && $password) {
        // Fetch user record
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email=? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($row = $res->fetch_assoc()) {
            // Verify password (assuming PASSWORD_HASH() used for storage)
            if (password_verify($password, $row['password'])) {
                $_SESSION['userid']   = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email']    = $email;

                // Redirect to dashboard
                header("Location: ../main/main.html");
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "No account registered with that email.";
        }
        $stmt->close();
    } else {
        $error = "Please enter both email and password.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../main/main.css" />
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 50px; }
        form { max-width: 400px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; }
        h2 { text-align: center; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-top: 5px; border-radius: 4px; border: 1px solid #ccc; }
        button { width: 100%; padding: 10px; background: #264476; color: white; border: none; border-radius: 4px; margin-top: 15px; }
        button:hover { background: #1a2f59; }
        .error { color: red; text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>
    <form method="post">
        <h2>Login</h2>
        <?php if (!empty($error)) echo "<div class='error'>{$error}</div>"; ?>
        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</body>
</html>
