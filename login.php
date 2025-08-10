<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists
    $sql = "SELECT username, password FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($username, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            header("Location: buy.php");
            exit();
        } else {
            echo "<script>alert('Invalid password. Please try again.'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('Email not found. Please register first.'); window.location.href='register.html';</script>";
    }
}
?>
