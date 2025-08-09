<?php
include "db_connect.php"; // database connection

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = md5($_POST['password']); // encrypt password

    // Check if email already exists
    $check = $conn->prepare("SELECT * FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists! Try logging in.'); window.location.href='login.html';</script>";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Account created successfully! Please log in.'); window.location.href='login.html';</script>";
        } else {
            echo "<script>alert('Error creating account.'); window.location.href='register.html';</script>";
        }
    }
}
?>
