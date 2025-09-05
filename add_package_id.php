<?php
// Database configuration
require_once 'db_connect.php';

// SQL to check if package_id column exists
$checkSql = "SHOW COLUMNS FROM `bookings` LIKE 'package_id'";
$checkResult = $conn->query($checkSql);

if ($checkResult->num_rows == 0) {
    // Column doesn't exist, so add it
    $alterSql = "ALTER TABLE `bookings` ADD COLUMN `package_id` VARCHAR(50) DEFAULT NULL AFTER `payment_method`";
    
    if ($conn->query($alterSql) === TRUE) {
        echo "Column 'package_id' added successfully";
    } else {
        echo "Error adding column: " . $conn->error;
    }
} else {
    echo "Column 'package_id' already exists";
}

$conn->close();
?> 