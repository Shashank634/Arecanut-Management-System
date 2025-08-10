<?php
session_start();

// Hardcoded credentials for simplicity
$admin_username = "admin";
$admin_password = "admin123"; // In real apps, store hashed password securely!

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["admin_username"];
    $password = $_POST["admin_password"];

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION["admin_logged_in"] = true;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Only authorized users can access this page'); window.location.href='admin_login.html';</script>";
    }
}
?>
