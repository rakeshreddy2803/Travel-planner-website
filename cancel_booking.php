<?php
// Database connection
require_once 'db_connect.php';

// Start session
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if booking ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirect back to bookings page with error
    header("Location: booking.php?error=no_booking_id");
    exit();
}

$bookingId = intval($_GET['id']);

// Delete the booking directly without any session checks
try {
    // Prepare and execute the DELETE statement
    $deleteStmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $deleteStmt->bind_param("i", $bookingId);
    
    if ($deleteStmt->execute()) {
        // Success - booking has been deleted
        header("Location: booking.php?success=booking_cancelled");
        exit();
    } else {
        // Error with the SQL execution
        header("Location: booking.php?error=cancellation_failed&sql_error=" . urlencode($conn->error));
        exit();
    }
    
    $deleteStmt->close();
} catch (Exception $e) {
    // Catch any errors that might occur
    header("Location: booking.php?error=cancellation_failed&sql_error=" . urlencode($e->getMessage()));
    exit();
}

// Close connection
$conn->close();
?> 