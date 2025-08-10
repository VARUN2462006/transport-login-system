<?php
session_start();
require '../db_connect.php'; // one folder up to reach db_connect.php in root

// Redirect to login if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Fetch user info from the database
$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT username, email FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>My Profile</title>
  <link rel="stylesheet" href="main/main.css" />
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; }
    .profile-container {
      max-width: 500px;
      margin: auto;
      background: rgba(255,255,255,0.9);
      padding: 20px;
      border-radius: 10px;
    }
    h2 { text-align: center; }
    p { font-size: 1.1rem; }
    a.btn {
      display: inline-block;
      margin-top: 15px;
      background: #264476;
      color: #fff;
      padding: 8px 14px;
      border-radius: 6px;
      text-decoration: none;
    }
    a.btn:hover { background: #1a2f59; }
  </style>
</head>
<body>
<div class="profile-container">
  <h2>My Profile</h2>
  <p><strong>Name:</strong> <?= htmlspecialchars($user['username']) ?></p>
  <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
  
  <a class="btn" href="login.php?logout=1">Logout</a>
  <a class="btn" href="main/main.html">Back to Dashboard</a>
</div>
</body>
</html>
