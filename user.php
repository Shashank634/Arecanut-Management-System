<?php
error_reporting(0);

$conn = new mysqli("localhost", "root", "", "user_management");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT id, username, email, phone FROM users";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Information</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color:rgb(235, 241, 246);
      margin: 0;
      padding: 0;
    }
    h1 {
      background-color:rgb(3, 182, 0);
      color: #fff;
      padding: 20px 0;
      text-align: center;
      margin: 0;
    }
    table {
      width: 90%;
      margin: 30px auto;
      border-collapse: collapse;
      background: #fff;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 12px 15px;
      border: 1px solid #ddd;
      text-align: center;
    }
    th {
      background-color: #0077b6;
      color: #fff;
    }
    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
    tr:hover {
      background-color: #d9f0ff;
    }
  </style>
</head>
<body>
  <h1>User Information</h1>
  <table>
    <tr>
      <th>ID</th>
      <th>Username</th>
      <th>Email</th>
      <th>Phone</th>
    
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['username']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['phone']}</td>
                   </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No user records found</td></tr>";
    }
    $conn->close();
    ?>
  </table>
</body>
</html>
