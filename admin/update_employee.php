<?php
$conn = new mysqli("localhost", "root", "", "user_management");
$id = $_POST['id'];
$name = $_POST['name'];

$phone = $_POST['phone'];
$salary = $_POST['salary'];

$conn->query("UPDATE em_info SET name='$name', phone='$phone', salary='$salary' WHERE emp_id='$id'");
header("Location: admin_dashboard.php");
?>
