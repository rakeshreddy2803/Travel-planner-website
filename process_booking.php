<?php
// Database configuration
$db_host = 'localhost'; // Your database host (usually 'localhost')
$db_username = 'root'; // Your database username
$db_password = ''; // Your database password
$db_name = 'project'; // Your database name

// Create connection
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $full_name = sanitize_input($_POST['full_name']);
    $email = sanitize_input($_POST['email']);
    $phone = sanitize_input($_POST['phone']);
    $travel_date = sanitize_input($_POST['travel_date']);
    $travelers = sanitize_input($_POST['travelers']);
    $special_requests = sanitize_input($_POST['special_requests']);
    $payment_method = sanitize_input($_POST['payment_method']);
    $package_id = isset($_POST['package_id']) ? sanitize_input($_POST['package_id']) : '';

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO bookings (full_name, email, phone, travel_date, travelers, special_requests, payment_method, package_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $full_name, $email, $phone, $travel_date, $travelers, $special_requests, $payment_method, $package_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Success - redirect to thank you page or show success message
        header("Location: thank_you.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();

// Function to sanitize form data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>