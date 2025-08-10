<?php
// Database connections
$conn1 = new mysqli("localhost", "root", "", "user_management");
$conn2 = new mysqli("localhost", "root", "", "contact_db");
$conn3 = new mysqli("localhost", "root", "", "arecanut_trading");

if ($conn1->connect_error || $conn2->connect_error || $conn3->connect_error) {
    die("Connection failed.");
}

// Queries
$emp_result = $conn1->query("SELECT * FROM em_info");
$user_result = $conn2->query("SELECT * FROM messages");
$product_result = $conn3->query("SELECT * FROM arecanut_varieties");
$purchase_result = $conn3->query("SELECT * FROM orders");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Deepa Traders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f4f8;
            color: #333;
        }
        .sidebar {
            width: 240px;
            background: #2c3e50;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 40px;
        }
        .sidebar h2 {
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
            font-size: 22px;
        }
        .sidebar-content {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 0 20px;
        }
        .nav-btn {
            background: none;
            border: none;
            color: #ecf0f1;
            padding: 10px;
            text-align: left;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .nav-btn:hover {
            background-color: #34495e;
            border-radius: 5px;
        }
        .main-content {
            margin-left: 240px;
            padding: 30px;
        }
        .section {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }
        .section.active {
            display: block;
        }
        h2 {
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background: #3498db;
            color: #fff;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .btn {
            padding: 5px 12px;
            margin-right: 5px;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
        }
        .btn-edit {
            background-color: #27ae60;
        }
        .btn-delete {
            background-color: #c0392b;
        }
        .btn-complete {
            background-color: #2ecc71;
        }
        .btn-cancel {
            background-color: #e67e22;
        }
        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <div class="sidebar-content">
        <button class="nav-btn" id="report-btn"><i class="fas fa-chart-line"></i> Reports</button>
        <button class="nav-btn" id="employees-btn"><i class="fas fa-user"></i> Employees</button>
        <button class="nav-btn" id="users-btn"><i class="fas fa-envelope"></i> User Messages</button>
        <button class="nav-btn" id="products-btn"><i class="fas fa-box"></i> Products</button>
        <button class="nav-btn" id="transactions-btn"><i class="fas fa-handshake"></i> Transactions</button>
        <button class="nav-btn" onclick="window.location.href='logout.php';"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </div>
</div>

<div class="main-content">

    <!-- Financial Report Section -->
    <div id="report" class="section active">
        <h2>Financial Report & Total Employees</h2>
        <div style="display: flex; flex-wrap: wrap; gap: 20px;">
            <div style="flex: 1; background: #e0f7fa; padding: 20px; border-radius: 8px;">
                <h3>Total Employees</h3>
                <p style="font-size: 26px; font-weight: bold;">
                    <?= $emp_result->num_rows ?>
                </p>
            </div>
            <div style="flex: 1; background: #f1f8e9; padding: 20px; border-radius: 8px;">
                <h3>Total Products</h3>
                <p style="font-size: 26px; font-weight: bold;">
                    <?= $product_result->num_rows ?>
                </p>
            </div>
            <div style="flex: 1; background: #fff3e0; padding: 20px; border-radius: 8px;">
                <h3>Total Transactions</h3>
                <p style="font-size: 26px; font-weight: bold;">
                    <?= $purchase_result->num_rows ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Employees Section -->
    <div id="employees" class="section">
        <h2>Employee Records</h2>
        <table>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Salary</th><th>Actions</th></tr>
            <?php while($row = $emp_result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['aadhar'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['aadhar'] ?></td>
                <td><?= $row['phone'] ?></td>
                <td><?= $row['salary'] ?></td>
                <td>
                    <a href="edit_employee.php?id=<?= $row['emp_id'] ?>" class="btn btn-edit">Edit</a>
                    <a href="delete_employee.php?id=<?= $row['emp_id'] ?>" class="btn btn-delete" onclick="return confirm('Delete this employee?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- User Messages Section -->
    <div id="users" class="section">
        <h2>User Messages</h2>
        <table>
            <tr><th>Name</th><th>Email</th><th>Message</th></tr>
            <?php while($row = $user_result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['message'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Products Section -->
    <div id="products" class="section">
        <h2>Product Management</h2>
        <table>
            <tr><th>ID</th><th>Name</th><th>Price/Quintal</th><th>Stock</th></tr>
            <?php while($row = $product_result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['price_per_quintal'] ?> ₹</td>
                <td><?= $row['stock_quintals'] ?> Quintals</td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Transactions Section -->
    <div id="transactions" class="section">
        <h2>Purchase Transactions</h2>
        <table>
            <tr><th>ID</th><th>Name</th><th>Type</th><th>Qty</th><th>Status</th><th>Actions</th></tr>
            <?php while($row = $purchase_result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['user_name'] ?></td>
                <td><?= ucfirst($row['transaction_type']) ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= ucfirst($row['status']) ?></td>
                <td>
                    <a href="update_status.php?id=<?= $row['id'] ?>&status=completed" 
                       class="btn btn-complete" 
                       onclick="return confirm('Mark this transaction as completed?');">
                       Complete
                    </a>
                    <a href="update_status.php?id=<?= $row['id'] ?>&status=cancelled" 
                       class="btn btn-cancel" 
                       onclick="return confirm('Cancel this transaction?');">
                       Cancel
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<script>
    const sections = document.querySelectorAll(".section");
    const buttons = {
        "report-btn": "report",
        "employees-btn": "employees",
        "users-btn": "users",
        "products-btn": "products",
        "transactions-btn": "transactions"
    };

    for (let id in buttons) {
        document.getElementById(id).addEventListener("click", () => {
            sections.forEach(sec => sec.classList.remove("active"));
            document.getElementById(buttons[id]).classList.add("active");
        });
    }

    window.addEventListener('DOMContentLoaded', () => {
        sections.forEach(sec => sec.classList.remove("active"));
        document.getElementById("report").classList.add("active");
    });
</script>

</body>
</html>
