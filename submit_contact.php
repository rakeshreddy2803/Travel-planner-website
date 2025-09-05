<?php
header('Content-Type: application/json');

// Start session (for CSRF token)
session_start();

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Default XAMPP username
define('DB_PASS', ''); // Default XAMPP password is empty
define('DB_NAME', 'project'); // Your database name

$response = ['success' => false, 'message' => ''];

try {
    // Validate CSRF token
    if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) || 
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        throw new Exception('Invalid CSRF token');
    }

    // Validate required fields
    $required = ['name', 'email', 'subject', 'message'];
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            throw new Exception("Please fill in all required fields");
        }
    }

    // Validate email
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        throw new Exception("Please enter a valid email address");
    }

    // Sanitize inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Connect to database
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL
    $stmt = $conn->prepare("INSERT INTO contact_submissions 
                          (name, email, subject, message, ip_address, user_agent) 
                          VALUES (?, ?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    
    $stmt->bind_param("ssssss", $name, $email, $subject, $message, $ip, $userAgent);
    
    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    // Success
    $response['success'] = true;
    $response['message'] = "Thank you for your message!";

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
    error_log("Contact Form Error: " . $e->getMessage());
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($conn)) $conn->close();
    
    echo json_encode($response);
    exit;
}
?>