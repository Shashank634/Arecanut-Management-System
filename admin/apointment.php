<?php
// Include database connection
include('admin_dashboard.php');

// Check if the 'id' and 'status' parameters are set in the URL
if (isset($_GET['id']) && isset($_GET['status'])) {
    $transaction_id = $_GET['id'];
    $status = $_GET['status'];

    // Validate the status to ensure it's either 'completed' or 'cancelled'
    if ($status == 'completed' || $status == 'cancelled') {
        // Update the status in the database
        $sql = "UPDATE orders SET status = ? WHERE id = ?";
        $stmt = $conn3->prepare($sql);
        $stmt->bind_param('si', $status, $transaction_id);

        // Execute the query and check if it was successful
        if ($stmt->execute()) {
            echo "<script>alert('Transaction status updated to $status'); window.location.href = 'admin_dashboard.php';</script>";
        } else {
            echo "<script>alert('Error updating transaction status.'); window.location.href = 'admin_dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid status.'); window.location.href = 'admin_dashboard.php';</script>";
    }
} else {
    echo "<script>alert('Invalid transaction.'); window.location.href = 'admin_dashboard.php';</script>";
}
?>
