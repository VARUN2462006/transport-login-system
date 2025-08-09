<?php
include "db_connect.php"; // database connection

if (isset($_POST['reset'])) {
    $email = trim($_POST['email']);
    $new_password = md5($_POST['new_password']); // encrypt new password

    // Check if email exists and get old password
    $check = $conn->prepare("SELECT password FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $old_password = $row['password'];

        // Compare old and new password
        if ($old_password === $new_password) {
            echo "<script>alert('New password cannot be the same as the old password!'); window.location.href='forgot_password.html';</script>";
            exit();
        }

        // Update password
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE email=?");
        $stmt->bind_param("ss", $new_password, $email);

        if ($stmt->execute()) {
            echo "<script>alert('Password updated successfully! You can now log in.'); window.location.href='login.html';</script>";
        } else {
            echo "<script>alert('Error updating password.'); window.location.href='forgot_password.html';</script>";
        }
    } else {
        echo "<script>alert('Email not found!'); window.location.href='forgot_password.html';</script>";
    }
}
?>
