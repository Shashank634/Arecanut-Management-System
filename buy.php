<?php
require_once 'config.php';

// Fetch arecanut varieties from database
$stmt = $pdo->query("SELECT * FROM arecanut_varieties");
$arecanuts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arecanut Trading Platform | Deepa Traders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #2e7d32;
            --primary-light: #60ad5e;
            --primary-dark: #1b5e20;
            --secondary-color: #388e3c;
            --accent-color: #8bc34a;
            --light-gray: #f5f5f5;
            --medium-gray: #e0e0e0;
            --dark-gray: #757575;
            --text-dark: #212121;
            --text-light: #f5f5f5;
            --header-bg: #ffffff;
            --footer-bg: #1b5e20;
            --card-bg: #ffffff;
            --button-hover: #1b5e20;
            --sell-button: #e53935;
            --sell-button-hover: #c62828;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: var(--light-gray);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header Styles */
        header {
            background-color: var(--header-bg);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 3px solid var(--primary-color);
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logo img {
            height: 50px;
            width: auto;
        }
        
        .logo-text h1 {
            color: var(--primary-dark);
            font-size: 1.8rem;
            margin: 0;
        }
        
        .logo-text span {
            color: var(--primary-light);
            font-size: 0.9rem;
            display: block;
        }
        
        .nav-links {
            display: flex;
            gap: 20px;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--primary-dark);
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 8px 12px;
            border-radius: 5px;
        }
        
        .nav-links a:hover {
            color: white;
            background-color: var(--primary-color);
            transform: translateY(-2px);
        }
        
        .nav-links a i {
            font-size: 1rem;
        }
        
        /* Main Content */
        main {
            flex: 1;
            padding: 30px 0;
        }
        
        .page-title {
            text-align: center;
            margin-bottom: 30px;
            color: var(--primary-dark);
            position: relative;
            padding-bottom: 15px;
        }
        
        .page-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background-color: var(--accent-color);
        }
        
        /* Card Styles */
        .card {
            background-color: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 30px;
            transition: transform 0.3s, box-shadow 0.3s;
            border-top: 4px solid var(--primary-color);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .card h2 {
            color: var(--primary-dark);
            margin-bottom: 20px;
            font-size: 1.5rem;
            border-bottom: 1px solid var(--medium-gray);
            padding-bottom: 10px;
        }
        
        /* Arecanut List */
        .arecanut-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }
        
        .arecanut-item {
            border: 1px solid var(--medium-gray);
            border-radius: 10px;
            overflow: hidden;
            background-color: white;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }
        
        .arecanut-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            border-color: var(--primary-light);
        }
        
        .arecanut-image-container {
            height: 200px;
            overflow: hidden;
            position: relative;
        }
        
        .arecanut-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .arecanut-item:hover .arecanut-image {
            transform: scale(1.05);
        }
        
        .arecanut-details {
            padding: 20px;
        }
        
        .arecanut-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0 0 10px 0;
            color: var(--primary-dark);
        }
        
        .arecanut-price {
            font-size: 1rem;
            color: var(--text-dark);
            margin: 5px 0;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .arecanut-price i {
            color: var(--primary-color);
        }
        
        .arecanut-stock {
            font-size: 0.9rem;
            color: var(--dark-gray);
            margin: 5px 0;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .arecanut-stock i {
            color: var(--primary-color);
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .btn i {
            font-size: 1rem;
        }
        
        .btn-buy {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-buy:hover {
            background-color: var(--button-hover);
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }
        
        .btn-sell {
            background-color: var(--sell-button);
            color: white;
        }
        
        .btn-sell:hover {
            background-color: var(--sell-button-hover);
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(3px);
        }
        
        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            width: 450px;
            max-width: 95%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: modalFadeIn 0.3s ease-out;
            border-top: 5px solid var(--primary-color);
        }
        
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .modal-title {
            color: var(--primary-dark);
            font-size: 1.5rem;
            margin: 0;
        }
        
        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--dark-gray);
            transition: color 0.3s;
        }
        
        .close-btn:hover {
            color: var(--sell-button);
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-dark);
        }
        
        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--medium-gray);
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        
        input:focus, select:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.2);
        }
        
        .submit-btn {
            background-color: var(--primary-color);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            width: 100%;
            font-size: 1rem;
            transition: background-color 0.3s, transform 0.2s;
            margin-top: 10px;
        }
        
        .submit-btn:hover {
            background-color: var(--button-hover);
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }
        
        .submit-btn:active {
            transform: translateY(0);
        }
        
        /* Footer Styles */
        footer {
            background-color: var(--footer-bg);
            color: var(--text-light);
            padding: 40px 0 20px;
            margin-top: 50px;
        }
        
        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .footer-logo img {
            height: 40px;
            width: auto;
        }
        
        .footer-logo-text h3 {
            color: white;
            font-size: 1.3rem;
            margin: 0;
        }
        
        .footer-logo-text span {
            color: var(--accent-color);
            font-size: 0.8rem;
            display: block;
        }
        
        .footer-about p {
            color: var(--medium-gray);
            font-size: 0.9rem;
            line-height: 1.6;
        }
        
        .footer-links h4, .footer-contact h4 {
            color: white;
            font-size: 1.1rem;
            margin-bottom: 15px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-links h4::after, .footer-contact h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: var(--accent-color);
        }
        
        .footer-links ul {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 8px;
        }
        
        .footer-links a {
            color: var(--medium-gray);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 0;
        }
        
        .footer-links a:hover {
            color: white;
            transform: translateX(5px);
        }
        
        .footer-links i {
            width: 20px;
            text-align: center;
            color: var(--accent-color);
        }
        
        .footer-contact p {
            color: var(--medium-gray);
            font-size: 0.9rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .footer-contact i {
            width: 20px;
            text-align: center;
            color: var(--accent-color);
        }
        
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-links a {
            color: white;
            background-color: rgba(255,255,255,0.1);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .social-links a:hover {
            background-color: var(--accent-color);
            color: var(--primary-dark);
            transform: translateY(-3px);
        }
        
        .footer-bottom {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--medium-gray);
            font-size: 0.8rem;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 15px;
            }
            
            .nav-links {
                width: 100%;
                justify-content: space-around;
                flex-wrap: wrap;
            }
            
            .arecanut-list {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
            
            .footer-container {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }
        
        @media (max-width: 480px) {
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
            
            .nav-links {
                gap: 10px;
            }
            
            .nav-links a {
                padding: 6px 8px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container header-container">
            <div class="logo">
                <img src="image/logo.png" alt="Deepa Traders Logo">
                <div class="logo-text">
                    <h1>DEEPA TRADERS</h1>
                    <span>Arecanut Trading Specialists</span>
                </div>
            </div>
            <nav class="nav-links">
                <a href="index.html"><i class="fas fa-home"></i> Home</a>
                <a href="about.html"><i class="fas fa-info-circle"></i> About</a>
                <a href="contact.html"><i class="fas fa-phone"></i> Contact</a>
                <a href="welcome.html"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </nav>
        </div>
    </header>
    
    <main>
        <div class="container">
            <h1 class="page-title">Arecanut Trading Platform</h1>
            
            <div class="card">
                <h2>Available Arecanut Varieties</h2>
                <div class="arecanut-list">
                    <?php foreach ($arecanuts as $arecanut): ?>
                    <div class="arecanut-item">
                        <div class="arecanut-image-container">
                            <img src="<?= htmlspecialchars($arecanut['image_url']) ?>" alt="<?= htmlspecialchars($arecanut['name']) ?>" class="arecanut-image">
                        </div>
                        <div class="arecanut-details">
                            <div class="arecanut-name"><?= htmlspecialchars($arecanut['name']) ?></div>
                            <div class="arecanut-price">
                                <i class="fas fa-rupee-sign"></i>
                                Price: ₹<?= number_format($arecanut['price_per_quintal'], 2) ?> per quintal
                            </div>
                            <div class="arecanut-stock">
                                <i class="fas fa-box-open"></i>
                                Stock Available: <?= number_format($arecanut['stock_quintals'], 2) ?> quintals
                            </div>
                            <div class="action-buttons">
                                <button class="btn btn-buy" onclick="openModal('buy', <?= $arecanut['id'] ?>, '<?= addslashes($arecanut['name']) ?>', <?= $arecanut['price_per_quintal'] ?>, <?= $arecanut['stock_quintals'] ?>)">
                                    <i class="fas fa-shopping-cart"></i> Buy
                                </button>
                                <button class="btn btn-sell" onclick="openModal('sell', <?= $arecanut['id'] ?>, '<?= addslashes($arecanut['name']) ?>', <?= $arecanut['price_per_quintal'] ?>, <?= $arecanut['stock_quintals'] ?>)">
                                    <i class="fas fa-money-bill-wave"></i> Sell
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Order Modal -->
    <div class="modal" id="orderModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalTitle">Place Order</h3>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <form id="orderForm" action="process_order.php" method="POST">
                <input type="hidden" id="arecanutId" name="arecanut_id">
                <input type="hidden" id="actionType" name="action_type">
                <div class="form-group">
                    <label for="arecanutType">Arecanut Type</label>
                    <input type="text" id="arecanutType" name="arecanut_type" readonly>
                </div>
                <div class="form-group">
                    <label for="price">Price per Quintal (₹)</label>
                    <input type="number" id="price" name="price" readonly>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity (Quintal)</label>
                    <input type="number" id="quantity" name="quantity" min="1" value="1" required>
                </div>
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" maxlength="10" required>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> Submit Order
                </button>
            </form>
        </div>
    </div>
    
    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-about">
                    <div class="footer-logo">
                        <img src="image/logo.png" alt="Deepa Traders Logo">
                        <div class="footer-logo-text">
                            <h3>DEEPA TRADERS</h3>
                            <span>Trusted Arecanut Traders</span>
                        </div>
                    </div>
                    <p>We specialize in high-quality arecanut trading with decades of experience in the industry, providing the best prices and service to farmers and buyers alike.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="welcome.html"><i class="fas fa-chevron-right"></i> Home</a></li>
                        <li><a href="about.html"><i class="fas fa-chevron-right"></i> About Us</a></li>
                        <li><a href="contact.html"><i class="fas fa-chevron-right"></i> Contact</a></li>
                       
                    </ul>
                </div>
                
                <div class="footer-contact">
                    <h4>Contact Us</h4>
                    <p><i class="fas fa-map-marker-alt"></i> Nagid Galli,Sirsi, Karnataka, India</p>
                    <p><i class="fas fa-phone"></i> +91 98456 09122</p>
                    <p><i class="fas fa-envelope"></i> info@deepatraders.com</p>
                    <p><i class="fas fa-clock"></i> Mon-Sat: 9:00 AM - 6:00 PM</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> Deepa Traders. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    
    <script>
        function openModal(action, id, type, price, stock) {
            document.getElementById('modalTitle').textContent = `${action === 'buy' ? 'Buy' : 'Sell'} Order - ${type}`;
            document.getElementById('arecanutId').value = id;
            document.getElementById('actionType').value = action;
            document.getElementById('arecanutType').value = type;
            document.getElementById('price').value = price;
            document.getElementById('quantity').max = stock;
            
            document.getElementById('orderModal').style.display = 'flex';
        }
        
        function closeModal() {
            document.getElementById('orderModal').style.display = 'none';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('orderModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>