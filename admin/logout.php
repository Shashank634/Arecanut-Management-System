<?php
// Start session and destroy it to log the user out
session_start();
session_destroy();
header("Location: admin_login.html"); // Redirect to admin page
exit();
?>
