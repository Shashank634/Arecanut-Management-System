<?php
session_start();
ob_start();
$conn = new mysqli("localhost", "root", "", "user_management");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$aadhar = $_POST['aadhar'];
$choice = $_POST['question_choice'];
$answer = $_POST['answer'];

// Fetch user
$stmt = $conn->prepare("SELECT * FROM users WHERE aadhar_number = ?");
$stmt->bind_param("s", $aadhar);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    $question_column = $choice == "1" ? "security_answer1" : "security_answer2";
    if (password_verify($answer, $user[$question_column])) {
        $_SESSION['aadhar'] = $aadhar;
        header("Location: reset_password.html");
        exit();
    } else {
        echo "<script>alert('Incorrect answer.'); window.location.href='forgot_password.html';</script>";
    }
} else {
    echo "<script>alert('Aadhar not found.'); window.location.href='forgot_password.html';</script>";
}

$stmt->close();
$conn->close();
ob_end_flush();
?>
