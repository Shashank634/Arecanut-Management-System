<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $required = ['arecanut_id', 'action_type', 'arecanut_type', 'price', 'quantity', 'name', 'phone'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            die("Error: Missing required field '$field'");
        }
    }

    $arecanut_id = (int)$_POST['arecanut_id'];
    $action_type = $_POST['action_type'];
    $arecanut_type = $_POST['arecanut_type'];
    $price = (float)$_POST['price'];
    $quantity = (float)$_POST['quantity'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    $total_price = $price * $quantity;
    $randomDays = rand(1, 7);
    $appointment_date = date('Y-m-d', strtotime("+$randomDays days"));

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO orders 
            (user_name, user_phone, arecanut_id, transaction_type, quantity, total_price, appointment_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $phone, $arecanut_id, $action_type, $quantity, $total_price, $appointment_date]);

        if ($action_type === 'buy') {
            $stmt = $pdo->prepare("UPDATE arecanut_varieties SET stock_quintals = stock_quintals - ? WHERE id = ?");
        } else {
            $stmt = $pdo->prepare("UPDATE arecanut_varieties SET stock_quintals = stock_quintals + ? WHERE id = ?");
        }
        $stmt->execute([$quantity, $arecanut_id]);

        $pdo->commit();
        $formatted_date = date('l, F j, Y', strtotime($appointment_date));
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Order Confirmation | Deepa Traders</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <style>
                :root {
                    --primary-color: #2e7d32;
                    --primary-dark: #1b5e20;
                    --accent-color: #8bc34a;
                    --light-gray: #f5f5f5;
                    --text-dark: #212121;
                    --text-light: #ffffff;
                }

                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }

                body {
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                    background: linear-gradient(rgba(255,255,255,0.9), rgba(255,255,255,0.9)),
                        url('https://images.unsplash.com/photo-1605000797499-95a51c5269ae?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center fixed;
                    background-size: cover;
                    min-height: 100vh;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    padding: 20px;
                }

                .container {
                    max-width: 600px;
                    width: 100%;
                    background: #fff;
                    border-radius: 10px;
                    overflow: hidden;
                    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
                    animation: slideUp 0.4s ease-out;
                }

                @keyframes slideUp {
                    from {
                        opacity: 0;
                        transform: translateY(30px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .confirmation-header {
                    background-color: var(--primary-dark);
                    color: var(--text-light);
                    text-align: center;
                    padding: 25px;
                }

                .confirmation-header i {
                    font-size: 2.5rem;
                    color: var(--accent-color);
                    margin-bottom: 10px;
                }

                .confirmation-content {
                    padding: 20px;
                }

                .thank-you-message {
                    text-align: center;
                    margin-bottom: 20px;
                }

                .thank-you-message p {
                    margin: 8px 0;
                    font-size: 1rem;
                }

                .thank-you-message .highlight {
                    color: var(--primary-color);
                    font-weight: 600;
                }

                .confirmation-details {
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 15px;
                    margin-bottom: 20px;
                }

                .detail-card {
                    background-color: var(--light-gray);
                    padding: 15px;
                    border-left: 4px solid var(--primary-color);
                    border-radius: 6px;
                }

                .detail-card h3 {
                    font-size: 0.9rem;
                    color: #555;
                    margin-bottom: 5px;
                }

                .detail-value {
                    font-size: 1.1rem;
                    color: var(--primary-dark);
                    font-weight: bold;
                }

                .action-buttons {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    gap: 12px;
                    margin-top: 10px;
                    flex-wrap: wrap;
                }

                .btn {
                    padding: 8px 14px;
                    font-size: 0.9rem;
                    border: none;
                    border-radius: 6px;
                    cursor: pointer;
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    text-decoration: none;
                    transition: 0.3s ease;
                }

                .btn-primary {
                    background-color: var(--primary-color);
                    color: white;
                }

                .btn-primary:hover {
                    background-color: var(--primary-dark);
                }

                .btn-outline {
                    background-color: transparent;
                    color: var(--primary-color);
                    border: 2px solid var(--primary-color);
                }

                .btn-outline:hover {
                    background-color: var(--primary-color);
                    color: white;
                }

                @media (max-width: 600px) {
                    .confirmation-details {
                        grid-template-columns: 1fr;
                    }
                    .btn {
                        width: 100%;
                        justify-content: center;
                    }
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="confirmation-header">
                    <i class="fas fa-check-circle"></i>
                    <h2>Order Confirmed!</h2>
                </div>
                <div class="confirmation-content">
                    <div class="thank-you-message">
                        <p>Thank you, <span class="highlight"><?= htmlspecialchars($name) ?></span>!</p>
                        <p>Your <span class="highlight"><?= htmlspecialchars($action_type) ?></span> order has been placed.</p>
                        <p>We will contact you at <span class="highlight"><?= htmlspecialchars($phone) ?></span>.</p>
                    </div>

                    <div class="confirmation-details">
                        <div class="detail-card">
                            <h3>Arecanut Type</h3>
                            <div class="detail-value"><?= htmlspecialchars($arecanut_type) ?></div>
                        </div>
                        <div class="detail-card">
                            <h3>Transaction</h3>
                            <div class="detail-value"><?= ucfirst($action_type) ?></div>
                        </div>
                        <div class="detail-card">
                            <h3>Quantity</h3>
                            <div class="detail-value"><?= number_format($quantity, 2) ?> quintals</div>
                        </div>
                        <div class="detail-card">
                            <h3>Price/Quintal</h3>
                            <div class="detail-value">₹<?= number_format($price, 2) ?></div>
                        </div>
                        <div class="detail-card">
                            <h3>Total Price</h3>
                            <div class="detail-value">₹<?= number_format($total_price, 2) ?></div>
                        </div>
                        <div class="detail-card">
                            <h3>Appointment Date</h3>
                            <div class="detail-value"><?= $formatted_date ?></div>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <a href="buy.php" class="btn btn-primary"><i class="fas fa-home"></i> Home</a>
                        <a href="javascript:window.print()" class="btn btn-outline"><i class="fas fa-print"></i> Print</a>
                    </div>
                </div>
            </div>
        </body>
        </html>
        <?php
    } catch (PDOException $e) {
        $pdo->rollBack();
        die("Error processing order: " . $e->getMessage());
    }
} else {
    header("Location: buy.php");
    exit;
}
?>
