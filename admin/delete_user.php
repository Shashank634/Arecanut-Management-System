<?php
$conn = new mysqli("localhost", "root", "", "user_management");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Delete user based on email
    $conn->query("DELETE FROM users WHERE email='$email'");
}

header("Location: admin_dashboard.php");
?>
