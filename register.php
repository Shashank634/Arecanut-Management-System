<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $aadhar = $_POST['aadhar'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $gender = $_POST['gender'];
  $security_question1 = $_POST['security_question1'];
  $security_answer1 = $_POST['security_answer1'];
  $security_question2 = $_POST['security_question2'];
  $security_answer2 = $_POST['security_answer2'];

  if ($password !== $confirm_password) {
    die("Passwords do not match.");
  }

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $hashed_answer1 = password_hash($security_answer1, PASSWORD_DEFAULT);
  $hashed_answer2 = password_hash($security_answer2, PASSWORD_DEFAULT);

  $conn = new mysqli("localhost", "root", "", "user_management");

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "INSERT INTO users (username, phone, email, aadhar_number, password, gender,
          security_question1, security_answer1, security_question2, security_answer2)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = $conn->prepare($sql);

  if (!$stmt) {
    die("Prepare failed: " . $conn->error);
  }

  $stmt->bind_param("ssssssssss", $username, $phone, $email, $aadhar, $hashed_password, $gender,
      $security_question1, $hashed_answer1, $security_question2, $hashed_answer2);

  if ($stmt->execute()) {
    echo "<script>alert('Registration successful!'); window.location.href='login.html';</script>";
  } else {
    echo "<script>alert('Error: " . $stmt->error . "'); window.history.back();</script>";
  }

  $stmt->close();
  $conn->close();
}
?>
