<?php
session_start();

// Check if the session has aadhar stored
if (!isset($_SESSION['aadhar'])) {
    echo "<script>alert('Session expired. Please try again.'); window.location.href='forgot_password.html';</script>";
    exit();
}

// Connect to the database
$conn = new mysqli("localhost", "root", "", "user_management");

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the posted values from the reset password form
$aadhar = $_SESSION['aadhar'];
$password = $_POST['new_password']; // IMPORTANT: match HTML input field name
$confirm_password = $_POST['confirm_password'];

// Check if passwords match
if ($password !== $confirm_password) {
    echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
    exit();
}

// Hash the new password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Update the password in the database
$sql = "UPDATE users SET password = ? WHERE aadhar_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $hashed_password, $aadhar);

if ($stmt->execute()) {
    session_destroy(); // Clear session after password reset
    echo "<script>alert('Password reset successful.'); window.location.href='login.html';</script>";
} else {
    echo "<script>alert('Error resetting password. Please try again.'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
