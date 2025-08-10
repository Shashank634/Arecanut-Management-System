<?php
$conn = new mysqli("localhost", "root", "", "arecanut_trading");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'];

    if (in_array($status, ['completed', 'cancelled'])) {
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        if ($stmt->execute()) {
            echo "<script>alert('Transaction marked as $status.'); window.location.href='admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error updating status.'); window.location.href='admin_dashboard.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Invalid status value.'); window.location.href='admin_dashboard.php';</script>";
    }
} else {
    echo "<script>alert('Missing parameters.'); window.location.href='admin_dashboard.php';</script>";
}

$conn->close();
?>
