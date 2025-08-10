<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userlogin";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$pass = $_POST['password'];

// Check if user exists
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $email, $pass);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // ✅ Login success → go to main.html in mainwebpage folder
    header("Location: ../mainwebpage/main.html");
    exit();
} else {
    // ❌ Login failed
    echo "<script>alert('Invalid Email or Password!'); window.location.href='userlogin.html';</script>";
}

$stmt->close();
$conn->close();
?>
