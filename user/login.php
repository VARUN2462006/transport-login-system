<?php
session_start();
include "db_connect.php"; // connection file

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Encrypt password with MD5 (same as stored in DB)
    $hashed_password = md5($password);

    $sql = "SELECT * FROM users WHERE username=? AND email=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Save login info in session
        $_SESSION['username'] = $username;
        
        // Redirect to main page
        header("Location: main.html");
        exit();
    } else {
        echo "<script>
                alert('Invalid login details!');
                window.location.href='login.html';
              </script>";
    }
}
?>
