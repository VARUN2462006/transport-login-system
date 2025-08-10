<?php
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "userlogin";

// Connect to database
$conn = new mysqli($servername, $db_username, $db_password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$username = $_POST['username'];
$email = $_POST['email'];
$new_password = $_POST['new_password'];

// Check if username & email exist together
$sql = "SELECT * FROM users WHERE username = ? AND email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update password
    $update_sql = "UPDATE users SET password = ? WHERE username = ? AND email = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sss", $new_password, $username, $email);

    if ($update_stmt->execute()) {
        echo "<script>alert('Password updated successfully!'); window.location.href='userlogin.html';</script>";
    } else {
        echo "<script>alert('Error updating password!'); window.location.href='changepassword.html';</script>";
    }

    $update_stmt->close();
} else {
    echo "<script>alert('No user found with provided Username & Email!'); window.location.href='changepassword.html';</script>";
}

$stmt->close();
$conn->close();
?>
