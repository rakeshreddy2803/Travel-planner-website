<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialize variables
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Booking Confirmed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .thank-you-container {
            max-width: 800px;
            margin: 50px auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
        }
        
        .success-icon {
            font-size: 80px;
            color: #2E8B57;
            margin-bottom: 20px;
        }
        
        h1 {
            color: #2E8B57;
            margin-bottom: 20px;
        }
        
        p {
            font-size: 18px;
            margin-bottom: 30px;
        }
        
        .btn {
            display: inline-block;
            background-color: #2E8B57;
            color: white;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            background-color: #247046;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .contact-info {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        .contact-info p {
            font-size: 16px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="thank-you-container">
        <i class="fas fa-check-circle success-icon"></i>
        <h1>Thank You for Your Booking!</h1>
        <p>We're excited to be part of your travel journey. Your booking has been received and is being processed.</p>
        <p>A confirmation email with all your booking details has been sent to your email address.</p>
        
        <div>
            <a href="finalproject.php" class="btn">Return to Home</a>
        </div>
        
        <div class="contact-info">
            <p>Have questions about your booking?</p>
            <p>Contact our support team at <strong>support@tourly.com</strong> or call us at <strong>+91 9876543210</strong></p>
        </div>
    </div>
</body>
</html> 