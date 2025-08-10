<?php
$conn = new mysqli("localhost", "root", "", "user_management");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$aadhar = $_POST['aadhar'];
$questionChoice = $_POST['question_choice'];

$sql = "SELECT security_question1, security_question2 FROM users WHERE aadhar_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $aadhar);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if ($questionChoice == "1") {
        echo $row['security_question1'];
    } elseif ($questionChoice == "2") {
        echo $row['security_question2'];
    } else {
        echo "Invalid selection.";
    }
} else {
    echo "Aadhar not found.";
}

$stmt->close();
$conn->close();
?>
