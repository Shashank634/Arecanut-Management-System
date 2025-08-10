<?php
$conn = new mysqli("localhost", "root", "", "user_management");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $sql = "DELETE FROM em_info WHERE emp_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?delete=success");
    } else {
        header("Location: admin_dashboard.php?delete=error");
    }
    $stmt->close();
}
?>