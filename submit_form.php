<?php
// Start session for CSRF token
session_start();

// Database configuration
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = "project";

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed");
    }
    
    // Validate and sanitize input
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));
    
    // Validate inputs
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        die("Please fill all required fields");
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }
    
    if (strlen($name) > 100 || strlen($email) > 100 || strlen($subject) > 200) {
        die("Input too long");
    }
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Prepare and bind with parameterized query
    $stmt = $conn->prepare("INSERT INTO contact_submissions (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "Thank you for your message. We'll get back to you soon!";
    } else {
        error_log("Database error: " . $stmt->error);
        echo "An error occurred. Please try again later.";
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Generate CSRF token for the form
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>