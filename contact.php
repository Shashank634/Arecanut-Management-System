<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars($_POST["message"]);

    error_reporting(0);

    // Validate email
    if (!$email) {
        echo "<script>alert('Invalid email format.');</script>";
        exit();
    }

    // Email Details
    $to = "hegdeshashank650@gmail.com";
    $subject = "New Contact Message from $name";
    $headers = "From: $email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";

    // Message Content
    $body = "Name: $name\nEmail: $email\nMessage:\n$message";

    // Send Email
    if (mail($to, $subject, $body, $headers)) {
        echo "<script>alert('Message sent successfully');</script>";
    } else {
        echo "<script>alert('Thank you for your message...!');</script>";
    }

    // Store in Database
    $conn = new mysqli("localhost", "root", "", "contact_db");
    if ($conn->connect_error) {
        echo "<script>alert('Database connection failed: " . $conn->connect_error . "');</script>";
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    if ($stmt->execute()) {
        echo "<script>
            alert('We will contact you soon');
            window.location.href = 'welcome.html';
        </script>";
    } else {
        echo "<script>alert('Failed to save message.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
