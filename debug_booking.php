<?php
// Start the session
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
require_once 'db_connect.php';

echo "<h2>Booking System Debug Information</h2>";

// 1. Check session variables
echo "<h3>Session Variables:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

// 2. Check if database connection is working
echo "<h3>Database Connection:</h3>";
if ($conn && !$conn->connect_error) {
    echo "<p style='color:green'>✓ Database connection successful</p>";
    
    // 3. Check bookings table
    $sql = "SHOW TABLES LIKE 'bookings'";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        echo "<p style='color:green'>✓ Bookings table exists</p>";
        
        // 4. Check bookings table structure
        $sql = "DESCRIBE bookings";
        $result = $conn->query($sql);
        
        if ($result) {
            echo "<h4>Bookings Table Structure:</h4>";
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $key => $value) {
                    echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
                }
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "<p style='color:red'>✗ Error describing bookings table: " . $conn->error . "</p>";
        }
        
        // 5. Check existing bookings
        $sql = "SELECT * FROM bookings LIMIT 5";
        $result = $conn->query($sql);
        
        if ($result) {
            if ($result->num_rows > 0) {
                echo "<h4>Sample Bookings (up to 5):</h4>";
                echo "<table border='1' cellpadding='5'>";
                
                // Headers
                $first = $result->fetch_assoc();
                if ($first) {
                    echo "<tr>";
                    foreach (array_keys($first) as $key) {
                        echo "<th>" . htmlspecialchars($key) . "</th>";
                    }
                    echo "</tr>";
                    
                    // Row data
                    echo "<tr>";
                    foreach ($first as $value) {
                        echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
                    }
                    echo "</tr>";
                    
                    // Rest of the rows
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        foreach ($row as $value) {
                            echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
                        }
                        echo "</tr>";
                    }
                }
                
                echo "</table>";
            } else {
                echo "<p style='color:blue'>ℹ No bookings found in the database</p>";
            }
        } else {
            echo "<p style='color:red'>✗ Error querying bookings: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:red'>✗ Bookings table does not exist</p>";
    }
} else {
    echo "<p style='color:red'>✗ Database connection failed: " . ($conn ? $conn->connect_error : 'Connection object not created') . "</p>";
}

// 6. Test links
echo "<h3>Test Links:</h3>";
echo "<ul>";
echo "<li><a href='booking.php'>Go to Bookings Page</a></li>";
echo "<li><a href='cancel_booking.php?id=1'>Test Cancel Booking (ID=1)</a></li>";
echo "</ul>";

// Close connection if it exists
if ($conn) {
    $conn->close();
}
?> 