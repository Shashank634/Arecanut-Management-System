<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Database Connection
$conn = new mysqli("localhost", "root", "", "user_management");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Generate New emp_id (EMP001, EMP002...)
$result = $conn->query("SELECT emp_id FROM em_info ORDER BY emp_id DESC LIMIT 1");

if ($result && $row = $result->fetch_assoc()) {
    $lastId = intval(substr($row['emp_id'], 3));
    $newId = "EMP" . str_pad($lastId + 1, 3, "0", STR_PAD_LEFT);
} else {
    $newId = "EMP001";
}

// Get Form Data
$name = $_POST['name'];
$phone = $_POST['phone'];
$aadhar = $_POST['aadhar'];
$gender = $_POST['gender'];
$salary = $_POST['salary'];

// Validate Inputs
if (empty($name) || empty($phone) || empty($aadhar) || empty($gender) || empty($salary)) {
    echo "<script>alert('All fields are required!'); window.history.back();</script>";
    exit();
}

// Insert Data
$stmt = $conn->prepare("INSERT INTO em_info (emp_id, name, phone, aadhar, gender, salary) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $newId, $name, $phone, $aadhar, $gender, $salary);

if ($stmt->execute()) {
    echo "<script>
        alert('Registration Successful! We will contact you shortly.');
        window.location.href = 'worker.html';
    </script>";
} else {
    echo "<script>alert('Registration Failed: " . $stmt->error . "'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
