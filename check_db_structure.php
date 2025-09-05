<?php
// Database configuration
require_once 'db_connect.php';

echo "<h2>Database Structure Check</h2>";

// Get all tables in database
$sql = "SHOW TABLES";
$result = $conn->query($sql);

echo "<h3>Tables in database:</h3>";
echo "<ul>";
if ($result->num_rows > 0) {
    while($row = $result->fetch_row()) {
        echo "<li>".$row[0]."</li>";
    }
} else {
    echo "<li>No tables found</li>";
}
echo "</ul>";

// Check bookings table structure
$sql = "DESCRIBE bookings";
$result = $conn->query($sql);

echo "<h3>Bookings table structure:</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";

$hasPackageId = false;

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['Field']."</td>";
        echo "<td>".$row['Type']."</td>";
        echo "<td>".$row['Null']."</td>";
        echo "<td>".$row['Key']."</td>";
        echo "<td>".$row['Default']."</td>";
        echo "<td>".$row['Extra']."</td>";
        echo "</tr>";
        
        if ($row['Field'] == 'package_id') {
            $hasPackageId = true;
        }
    }
} else {
    echo "<tr><td colspan='6'>No bookings table found or error describing table: " . $conn->error . "</td></tr>";
}
echo "</table>";

if ($hasPackageId) {
    echo "<p style='color:green'>✓ package_id column exists in bookings table</p>";
} else {
    echo "<p style='color:red'>✗ package_id column is missing from bookings table</p>";
    echo "<p>Run the add_package_id.php script to add it.</p>";
}

// Check for any recent bookings with package_id
$sql = "SELECT * FROM bookings WHERE package_id IS NOT NULL ORDER BY id DESC LIMIT 5";
$result = $conn->query($sql);

echo "<h3>Recent bookings with package_id:</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Travel Date</th><th>Package ID</th></tr>";

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['id']."</td>";
        echo "<td>".$row['full_name']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['travel_date']."</td>";
        echo "<td>".$row['package_id']."</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No bookings with package_id found</td></tr>";
}
echo "</table>";

echo "<h3>Links:</h3>";
echo "<ul>";
echo "<li><a href='add_package_id.php'>Run add_package_id.php</a> (adds package_id column if missing)</li>";
echo "<li><a href='fix_bookings.php'>Run fix_bookings.php</a> (assigns package IDs to existing bookings)</li>";
echo "<li><a href='booking.php'>Go to Bookings Page</a></li>";
echo "</ul>";

$conn->close();
?> 