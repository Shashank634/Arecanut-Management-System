<?php
$conn = new mysqli("localhost", "root", "", "user_management");
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM em_info WHERE emp_id='$id'");
$row = $result->fetch_assoc();
?>

<form action="update_employee.php" method="post">
    <input type="hidden" name="id" value="<?= $id ?>">
    Name: <input type="text" name="name" value="<?= $row['name'] ?>"><br>
   
    Phone: <input type="text" name="phone" value="<?= $row['phone'] ?>"><br>
    Salary: <input type="text" name="salary" value="<?= $row['salary'] ?>"><br>
    <button type="submit">Update</button>
</form>
