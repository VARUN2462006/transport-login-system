<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if ($result && mysqli_num_rows($result) === 1) {
        // For demo, reset password to "newpassword123" and display it
        $new_pass = password_hash('newpassword123', PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE users SET password='$new_pass' WHERE email='$email'");
        echo "<script>alert('Your password has been reset. Temporary password: newpassword123');window.location='login.html';</script>";
    } else {
        echo "<script>alert('Email not found.');window.location='forgot_password.html';</script>";
    }
}
?>
