<?php
session_start();
$conn = new mysqli("localhost", "root", "", "user_management");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$aadhar = $_POST['aadhar'];
$questionChoice = $_POST['question_choice'];
$answer = $_POST['answer'];

$sql = "SELECT security_answer1, security_answer2 FROM users WHERE aadhar_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $aadhar);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $storedAnswer = ($questionChoice == "1") ? $row['security_answer1'] : $row['security_answer2'];

    if (password_verify($answer, $storedAnswer)) {
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
?>
