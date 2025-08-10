<?php
session_start();

// For testing: set session variables if not set
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'Varun Athawale';
    $_SESSION['email'] = 'athawalevarun1@gmail.com';
    $_SESSION['phone'] = '+919405220000';
}

// Redirect to login if not logged in (optional, keep or remove for testing)
// if (!isset($_SESSION['username'])) {
//     header('Location: login.php');
//     exit();
// }

$username = $_SESSION['username'];
$email = $_SESSION['email'] ?? 'guest@example.com';
$phone = $_SESSION['phone'] ?? '+0000000000';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Main Dashboard</title>
  <link rel="stylesheet" href="main.css" />
</head>
<body>
  <div class="navbar">
    <div class="menu">
      <div class="menu-icon" id="menu-icon"></div>
      <div class="menu-links" id="menu-links">
        <div class="profile-section">
          <div class="profile-photo" id="profile-photo"></div>
          <div class="profile-name" id="profile-name"></div>
        </div>

        <hr />

        <div class="contact-section">
          <h3>Contact Me</h3>
          <p>📞 <a href="tel:<?= htmlspecialchars($phone) ?>" id="phone-link"><?= htmlspecialchars($phone) ?></a></p>
          <p>📧 <a href="mailto:<?= htmlspecialchars($email) ?>" id="email-link"><?= htmlspecialchars($email) ?></a></p>
        </div>

        <hr />

        <div class="dark-mode-section">
          <h3>Dark / Light Mode</h3>
          <label class="switch">
            <input type="checkbox" id="darkModeToggle" />
            <span class="slider"></span>
          </label>
        </div>

        <hr />

        <nav>
          <a href="booking.html">Book a Vehicle</a>
          <a href="my_bookings.html">My Bookings</a>
          <a href="settings.html">Settings</a>
          <a href="logout.php">Logout</a>
        </nav>
      </div>
    </div>

    <h1 class="navbar-title" id="welcome-message">Welcome!</h1>
  </div>

  <script>
    // Pass PHP session data to JS user object
    const user = {
      username: <?= json_encode($username) ?>,
      email: <?= json_encode($email) ?>,
      phone: <?= json_encode($phone) ?>
    };
  </script>

  <script src="main.js"></script>
</body>
</html>