<?php
// Database configuration
require_once 'db_connect.php';

echo "<h2>Booking Records Inspection</h2>";

// Check if the database has package_id column
$checkSql = "SHOW COLUMNS FROM `bookings` LIKE 'package_id'";
$checkResult = $conn->query($checkSql);

if ($checkResult->num_rows == 0) {
    echo "<p>The package_id column is missing. Please run the add_package_id.php script first.</p>";
    exit();
}

// Get all bookings
$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);

echo "<h3>Current Bookings:</h3>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Date</th><th>Package ID</th><th>Action</th></tr>";

$totalBookings = 0;
$missingPackageId = 0;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $totalBookings++;
        $hasPackageId = !empty($row['package_id']);
        if (!$hasPackageId) {
            $missingPackageId++;
        }
        
        echo "<tr>";
        echo "<td>".$row['id']."</td>";
        echo "<td>".$row['full_name']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "<td>".$row['travel_date']."</td>";
        echo "<td>".($hasPackageId ? $row['package_id'] : "<span style='color:red'>Missing</span>")."</td>";
        echo "<td>";
        if (!$hasPackageId) {
            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='booking_id' value='".$row['id']."'>";
            echo "<select name='package_id'>";
            // Add options for package IDs 1-17
            for ($i = 1; $i <= 17; $i++) {
                echo "<option value='$i'>Package #$i</option>";
            }
            echo "</select>";
            echo "<input type='submit' name='update' value='Update'>";
            echo "</form>";
        } else {
            echo "OK";
        }
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No bookings found</td></tr>";
}
echo "</table>";

echo "<p>Total bookings: $totalBookings</p>";
echo "<p>Bookings with missing package_id: $missingPackageId</p>";

// Update package_id if form is submitted
if(isset($_POST['update']) && isset($_POST['booking_id']) && isset($_POST['package_id'])) {
    $bookingId = $_POST['booking_id'];
    $packageId = $_POST['package_id'];
    
    $updateSql = "UPDATE bookings SET package_id = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("si", $packageId, $bookingId);
    
    if($stmt->execute()) {
        echo "<div style='color:green; margin-top:20px;'>Successfully updated booking #$bookingId with package ID $packageId</div>";
        echo "<meta http-equiv='refresh' content='2;url=fix_bookings.php'>";
    } else {
        echo "<div style='color:red; margin-top:20px;'>Error updating record: " . $stmt->error . "</div>";
    }
    
    $stmt->close();
}

// Add a button to go back to bookings page
echo "<p><a href='booking.php' style='margin-top:20px; display:inline-block; padding:10px; background-color:#2E8B57; color:white; text-decoration:none; border-radius:5px;'>Return to Bookings</a></p>";

$conn->close();
?> 