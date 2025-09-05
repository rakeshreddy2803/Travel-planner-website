<?php
// Database connection
require_once 'db_connect.php';

// Check if user is logged in (you may need to adjust this based on your authentication system)
session_start();
$isLoggedIn = true; // Always treat user as logged in for booking functionality
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; // Default to user ID 1 if not set

// Function to get bookings
function getBookings($conn, $userId = null, $timeFilter = 'all') {
    $bookings = [];
    
    // Base query
    $sql = "SELECT * FROM bookings";
    $where = [];
    $params = [];
    $types = "";
    
    // Skip user filter - show all bookings
    /*
    // Add user filter if logged in
    if ($userId) {
        $where[] = "email = ?";
        $params[] = $_SESSION['email'];
        $types .= "s";
    }
    */
    
    // Add time filter
    $today = date('Y-m-d');
    $thisMonth = date('Y-m-01');
    $nextMonth = date('Y-m-d', strtotime('first day of next month'));
    
    if ($timeFilter == 'upcoming') {
        $where[] = "travel_date >= ?";
        $params[] = $today;
        $types .= "s";
    } else if ($timeFilter == 'current') {
        $where[] = "travel_date >= ? AND travel_date < ?";
        $params[] = $thisMonth;
        $params[] = $nextMonth;
        $types .= "ss";
    } else if ($timeFilter == 'past') {
        $where[] = "travel_date < ?";
        $params[] = $today;
        $types .= "s";
    }
    
    // Complete the query
    if (!empty($where)) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }
    
    // Order by travel date
    $sql .= " ORDER BY travel_date";
    
    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch bookings
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
    
    $stmt->close();
    return $bookings;
}

// Get bookings based on filter (default to all bookings for now)
$currentFilter = isset($_GET['filter']) ? $_GET['filter'] : 'upcoming';
$bookings = getBookings($conn, $userId, $currentFilter);

// Function to get package image URL based on package ID
function getPackageImageUrl($packageId) {
    // Default fallback image if no package ID is available
    $defaultImage = "https://source.unsplash.com/500x300/?travel";
    
    if (!$packageId) {
        return $defaultImage;
    }
    
    // Map of package IDs to image URLs - same as in packages.php
    $packageImages = [
        '1' => 'https://i.pinimg.com/474x/d6/35/cd/d635cd00e7c0ff8d867846dc53fea4b4.jpg',
        '2' => 'https://i.pinimg.com/736x/5b/3b/6e/5b3b6e3f2d9720783397bbb64f5bacc3.jpg',
        '3' => 'https://images.pexels.com/photos/12340644/pexels-photo-12340644.jpeg',
        '4' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        '5' => 'https://images.pexels.com/photos/1007657/pexels-photo-1007657.jpeg',
        '6' => 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        '7' => 'https://images.unsplash.com/photo-1519181245277-cffeb31da2e3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        '8' => 'https://images.unsplash.com/photo-1526392060635-9d6019884377?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        '9' => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        '10' => 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        '11' => 'https://images.unsplash.com/photo-1524492412937-b28074a5d7da?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        '12' => 'https://images.unsplash.com/photo-1483729558449-99ef09a8c325?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        '13' => 'https://images.unsplash.com/photo-1589909202802-8f4aadce1849?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        '14' => 'https://images.unsplash.com/photo-1489493887464-892be6d1daae?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        '15' => 'https://images.unsplash.com/photo-1503177119275-0aa32b3a9368?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        '16' => 'https://images.unsplash.com/photo-1469521669194-babb45599def?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        '17' => 'https://images.unsplash.com/photo-1542323228-002ac256e7b8?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
    ];
    
    return isset($packageImages[$packageId]) ? $packageImages[$packageId] : $defaultImage;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourly - My Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
:root {
    --primary-color: #2E8B57;    /* Sea Green */
    --secondary-color: #3CB371;  /* Medium Sea Green */
    --accent-color: #48BB78;     /* Emerald */
    --bg-dark: #1A202C;          /* Dark Background */
    --bg-darker: #2D3748;        /* Darker Background */
    --text-light: #FFFFFF;       /* White Text */
    --text-lighter: #F7FAFC;     /* Lighter Text */
    --text-muted: #718096;       /* Muted Text */
    --card-bg: rgba(26, 32, 44, 0.95);
    --gradient: linear-gradient(135deg, #2E8B57 0%, #3CB371 100%);
    --shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
    --hover-shadow: 0 8px 15px rgba(47, 133, 90, 0.3);
    --glass-bg: rgba(255, 255, 255, 0.1);
    --glass-border: rgba(255, 255, 255, 0.2);
    --glass-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    line-height: 1.6;
    color: var(--dark-color);
    background-color: #f5f5f5;
    overflow-x: hidden;
}

a {
    text-decoration: none;
    color: inherit;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    text-align: center;
}

.btn:hover {
    background-color: #21867a;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.btn-outline {
    background-color: transparent;
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
}

.btn-outline:hover {
    background-color: var(--primary-color);
    color: white;
}

.section-title {
    text-align: center;
    margin-bottom: 40px;
}

.section-title h2 {
    font-size: 2.5rem;
    color: var(--secondary-color);
    margin-bottom: 15px;
    position: relative;
    display: inline-block;
}

.section-title h2::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background-color: var(--accent-color);
}

.section-title p {
    color: #666;
    max-width: 700px;
    margin: 0 auto;
}

/* Booking Tabs */
.booking-tabs {
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
    gap: 10px;
}

.booking-tab {
    padding: 10px 25px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
}

.booking-tab.active {
    background-color: var(--primary-color);
    color: white;
}

/* Bookings Grid */
.bookings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 25px;
    margin-bottom: 50px;
}

.booking-card {
    background-color: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.booking-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

.booking-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.booking-details {
    padding: 20px;
}

.booking-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 10px;
    color: var(--primary-color);
}

.booking-info {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
    color: #666;
}

.booking-info i {
    margin-right: 10px;
    color: var(--secondary-color);
    min-width: 20px;
    text-align: center;
}

.booking-status {
    display: inline-block;
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 0.85rem;
    margin-top: 10px;
    margin-bottom: 15px;
}

.status-upcoming {
    background-color: #d1e7f0;
    color: #2389ad;
}

.status-current {
    background-color: #d4f5e9;
    color: #28a87b;
}

.status-past {
    background-color: #f0f0f0;
    color: #777;
}

.booking-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
}

.booking-actions .btn {
    padding: 8px 15px;
    font-size: 0.9rem;
}

/* No Bookings Message */
.no-bookings {
    grid-column: 1 / -1;
    text-align: center;
    padding: 50px 20px;
    border-radius: 10px;
    background-color: white;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.no-bookings i {
    font-size: 3rem;
    color: var(--primary-color);
    margin-bottom: 20px;
}

.no-bookings h3 {
    font-size: 1.8rem;
    margin-bottom: 15px;
    color: var(--secondary-color);
}

.no-bookings p {
    max-width: 500px;
    margin: 0 auto 25px;
    color: #666;
}

/* Modal Overlay for Booking Details */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 1000;
    overflow-y: auto;
}

.modal-content {
    background-color: white;
    width: 90%;
    max-width: 800px;
    margin: 50px auto;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
}

.modal-header {
    padding: 20px;
    background-color: var(--primary-color);
    color: white;
    position: relative;
}

.modal-header h3 {
    margin: 0;
    font-size: 1.6rem;
}

.close-modal {
    position: absolute;
    top: 15px;
    right: 20px;
    font-size: 1.8rem;
    background: none;
    border: none;
    color: white;
    cursor: pointer;
}

.modal-body {
    padding: 30px;
}

.booking-details-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.booking-details-image {
    width: 100%;
    border-radius: 8px;
    margin-bottom: 20px;
}

.booking-details-info h4 {
    color: var(--primary-color);
    margin-top: 20px;
    margin-bottom: 15px;
    font-size: 1.3rem;
}

.booking-details-list {
    list-style-type: none;
    padding-left: 0;
}

.booking-details-list li {
    margin-bottom: 10px;
    display: flex;
    align-items: flex-start;
}

.booking-details-list li i {
    color: var(--secondary-color);
    margin-right: 10px;
    margin-top: 5px;
}

.booking-details-table {
    width: 100%;
    border-collapse: collapse;
}

.booking-details-table th, 
.booking-details-table td {
    padding: 12px 10px;
    text-align: left;
    border-bottom: 1px solid #eee;
}

.booking-details-table th {
    width: 40%;
    color: #555;
    font-weight: 600;
}

@media (max-width: 768px) {
    .booking-details-content {
        grid-template-columns: 1fr;
    }
}
/* Header Styles */
header {
    background-color: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
    padding: 15px 0;
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    display: flex;
    align-items: center;
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--secondary-color);
}

.logo i {
    margin-right: 10px;
    color: var(--primary-color);
}

nav ul {
    display: flex;
    list-style: none;
}

nav ul li {
    margin-left: 30px;
    position: relative;
}

nav ul li a {
    font-weight: 500;
    transition: var(--transition);
    padding: 5px 0;
}

nav ul li a:hover,
nav ul li a.active {
    color: var(--primary-color);
}

nav ul li a.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: var(--primary-color);
}

.auth-buttons {
    display: flex;
    align-items: center;
}

.auth-buttons .btn {
    margin-left: 15px;
}

.mobile-nav-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 1.5rem;
    color: var(--secondary-color);
    cursor: pointer;
}

/* Responsive Header Styles */
@media (max-width: 768px) {
    .header-container {
        flex-wrap: wrap;
    }
    
    nav {
        order: 3;
        width: 100%;
        margin-top: 20px;
    }
    
    nav ul {
        flex-direction: column;
        gap: 15px;
    }
    
    nav ul li {
        margin-left: 0;
    }
    
    .auth-buttons {
        margin-left: auto;
    }
}
/* Moving Text Banner */
.moving-text {
    background-color: var(--primary-color); /* Using your green color variable */
    color: white; /* White text */
    padding: 12px 0;
    overflow: hidden;
    white-space: nowrap;
    position: relative;
    font-weight: 600;
}

.moving-text span {
    display: inline-block;
    padding-left: 100%; /* Start off-screen to the right */
    animation: scrollText 20s linear infinite;
}

@keyframes scrollText {
    0% { 
        transform: translateX(0); /* Start from right edge */
    }
    100% { 
        transform: translateX(-100%); /* Move to left edge */
    }
}
/* Header Styles */
header {
    background-color: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
    padding: 15px 0;
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    display: flex;
    align-items: center;
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--secondary-color);
}

.logo i {
    margin-right: 10px;
    color: var(--primary-color);
}

nav ul {
    display: flex;
    list-style: none;
}

nav ul li {
    margin-left: 30px;
    position: relative;
}

nav ul li a {
    font-weight: 500;
    transition: var(--transition);
    padding: 5px 0;
}

nav ul li a:hover,
nav ul li a.active {
    color: var(--primary-color);
}

nav ul li a.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: var(--primary-color);
}

.auth-buttons {
    display: flex;
    align-items: center;
}

.auth-buttons .btn {
    margin-left: 15px;
}

.mobile-nav-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 1.5rem;
    color: var(--secondary-color);
    cursor: pointer;
}

/* Responsive Header Styles */
@media (max-width: 768px) {
    .header-container {
        flex-wrap: wrap;
    }
    
    nav {
        order: 3;
        width: 100%;
        margin-top: 20px;
    }
    
    nav ul {
        flex-direction: column;
        gap: 15px;
    }
    
    nav ul li {
        margin-left: 0;
    }
    
    .auth-buttons {
        margin-left: auto;
    }
}
    </style>
</head>
<body>
    <!-- Moving Text Banner -->
    <div class="moving-text">
        <span>Special Offer: Get 15% off on all international packages! Limited time offer. Book now!</span>
    </div>

    <!-- Header -->
    <header>
        <div class="container header-container">
            <a href="finalproject.php" class="logo">
                <i class="fas fa-plane"></i><span>Tourly</span>
            </a>
            <nav>
                <ul>
                    <li><a href="finalproject.php">Home</a></li>
                    <li><a href="packages.php">Packages</a></li>
                    <li><a href="finalproject.php#services">Services</a></li>
                    <li><a href="finalproject.php#reviews">Reviews</a></li>
                    <li><a href="finalproject.php#contact">Contact</a></li>
                    <?php if ($isLoggedIn): ?>
                    <li><a href="booking.php" class="active">My Bookings</a></li>
                    <li><a href="profile.php">My Profile</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            <div class="auth-buttons">
                <?php if (!$isLoggedIn): ?>
                <button class="btn btn-outline login-btn">Login</button>
                <?php else: ?>
                <div>
                    <span id="user-name" class="text-light me-3"><?php echo $_SESSION['full_name'] ?? ''; ?></span>
                    <button class="btn btn-outline" onclick="logout()">Logout</button>
                </div>
                <?php endif; ?>
            </div>
            <button class="mobile-nav-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Bookings Section -->
    <section class="bookings-section">
        <div class="container">
            <?php
            // Display success or error messages
            if (isset($_GET['success']) && $_GET['success'] == 'booking_cancelled') {
                echo '<div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                        <strong>Success!</strong> Your booking has been cancelled successfully.
                      </div>';
            } elseif (isset($_GET['error'])) {
                $error = $_GET['error'];
                $errorMsg = '';
                
                if ($error == 'no_booking_id') {
                    $errorMsg = 'No booking ID provided.';
                } elseif ($error == 'invalid_booking') {
                    $errorMsg = 'Invalid booking or you do not have permission to cancel this booking.';
                } elseif ($error == 'cancellation_failed') {
                    $errorMsg = 'Failed to cancel booking. Please try again.';
                    if (isset($_GET['sql_error'])) {
                        $errorMsg .= ' SQL Error: ' . htmlspecialchars($_GET['sql_error']);
                    }
                } elseif ($error == 'not_logged_in') {
                    $errorMsg = 'You must be logged in to cancel a booking.';
                } elseif ($error == 'booking_not_found') {
                    $errorMsg = 'The booking you are trying to cancel could not be found.';
                } elseif ($error == 'not_authorized') {
                    $errorMsg = 'You are not authorized to cancel this booking.';
                }
                
                if (!empty($errorMsg)) {
                    echo '<div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                            <strong>Error!</strong> ' . $errorMsg . '
                          </div>';
                }
            }
            ?>
            
            <div class="section-title">
                <h2>My Bookings</h2>
                <p class="section-text">Manage and view all your upcoming and past travel bookings in one place</p>
            </div>
            
            <!-- Booking Tabs -->
            <div class="booking-tabs">
                <div class="booking-tab <?php echo $currentFilter == 'upcoming' ? 'active' : ''; ?>" data-tab="upcoming">Upcoming Trips</div>
                <div class="booking-tab <?php echo $currentFilter == 'current' ? 'active' : ''; ?>" data-tab="current">This Month</div>
                <div class="booking-tab <?php echo $currentFilter == 'past' ? 'active' : ''; ?>" data-tab="past">Past Trips</div>
            </div>
            
            <!-- Bookings Grid -->
            <div class="bookings-grid">
                <?php if (empty($bookings)): ?>
                <!-- No bookings message (shown when no bookings exist) -->
                <div class="no-bookings" id="no-bookings-message">
                    <i class="fas fa-suitcase-rolling"></i>
                    <h3>No Bookings Found</h3>
                    <p>You haven't made any bookings yet. Explore our packages and start planning your next adventure!</p>
                    <a href="packages.php" class="btn">Browse Packages</a>
                </div>
                <?php else: ?>
                    <?php foreach ($bookings as $booking): ?>
                    <div class="booking-card">
                        <?php
                        // Get package image based on package_id/trip_id
                        $packageImage = getPackageImageUrl($booking['package_id'] ?? $booking['trip_id'] ?? null);
                        ?>
                        <img src="<?php echo $packageImage; ?>" alt="Travel Image" class="booking-image">
                        <div class="booking-details">
                            <h3 class="booking-title"><?php echo htmlspecialchars($booking['full_name']); ?></h3>
                            
                            <div class="booking-info">
                                <i class="fas fa-map-marker-alt"></i>
                                <span><?php echo !empty($booking['special_requests']) ? htmlspecialchars(substr($booking['special_requests'], 0, 30)) . '...' : 'No special requests'; ?></span>
                            </div>
                            
                            <div class="booking-info">
                                <i class="fas fa-calendar-alt"></i>
                                <span><?php echo date('M d, Y', strtotime($booking['travel_date'])); ?></span>
                            </div>
                            
                            <div class="booking-info">
                                <i class="fas fa-users"></i>
                                <span><?php echo htmlspecialchars($booking['travelers']); ?> Travelers</span>
                            </div>
                            
                            <?php
                            $today = new DateTime();
                            $travelDate = new DateTime($booking['travel_date']);
                            $diff = $today->diff($travelDate);
                            
                            if ($travelDate < $today) {
                                $status = 'past';
                                $statusText = 'Completed';
                            } elseif ($travelDate->format('Y-m') == $today->format('Y-m')) {
                                $status = 'current';
                                $statusText = 'This Month';
                            } else {
                                $status = 'upcoming';
                                $statusText = 'Upcoming';
                            }
                            ?>
                            
                            <span class="booking-status status-<?php echo $status; ?>"><?php echo $statusText; ?></span>
                            
                            <div class="booking-actions">
                                <button class="btn btn-outline view-details-btn" data-booking-id="<?php echo $booking['id']; ?>">View Details</button>
                                <button class="btn cancel-booking-btn" data-booking-id="<?php echo $booking['id']; ?>">Cancel</button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Booking Details Modal -->
    <div class="modal-overlay" id="booking-details-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Booking Details</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="booking-details-content">
                    <div>
                        <img src="" alt="Booking Image" class="booking-details-image" id="modal-booking-image">
                        
                        <div class="booking-details-info">
                            <h4>Special Requests</h4>
                            <p id="modal-booking-description"></p>
                        </div>
                    </div>
                    
                    <div>
                        <div class="booking-details-info">
                            <h4>Trip Details</h4>
                            <table class="booking-details-table">
                                <tr>
                                    <th>Full Name</th>
                                    <td id="modal-booking-name"></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td id="modal-booking-email"></td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td id="modal-booking-phone"></td>
                                </tr>
                                <tr>
                                    <th>Travel Date</th>
                                    <td id="modal-booking-dates"></td>
                                </tr>
                                <tr>
                                    <th>Travelers</th>
                                    <td id="modal-booking-travelers"></td>
                                </tr>
                                <tr>
                                    <th>Payment Method</th>
                                    <td id="modal-booking-payment"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal" id="login-modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2 class="modal-title">Welcome Back</h2>
            
            <!-- Login Form -->
            <form id="login-form" action="db_login.php" method="post">
                <div class="form-group">
                    <label for="login-email">Email Address</label>
                    <input type="email" id="login-email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" name="password" required>
                </div>
                
                <button type="submit" class="btn">Login</button>
                
                <div class="form-footer">
                    <p><a href="#" class="switch-to-signup">Don't have an account? Sign up</a></p>
                </div>
            </form>

            <!-- Sign Up Form -->
            <form id="signup-form" style="display: none;" action="db_signup.php" method="post">
                <div class="form-group">
                    <label for="signup-name">Full Name</label>
                    <input type="text" id="signup-name" name="full_name" required>
                </div>
                
                <div class="form-group">
                    <label for="signup-email">Email Address</label>
                    <input type="email" id="signup-email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="signup-password">Password</label>
                    <input type="password" id="signup-password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="signup-confirm-password">Confirm Password</label>
                    <input type="password" id="signup-confirm-password" name="confirm_password" required>
                </div>
                
                <button type="submit" class="btn">Sign Up</button>
                
                <div class="form-footer">
                    <p><a href="#" class="switch-to-login">Already have an account? Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Show/hide login modal
        const loginBtn = document.querySelector('.login-btn');
        const loginModal = document.getElementById('login-modal');
        const closeModalBtns = document.querySelectorAll('.close-modal');
        
        if (loginBtn) {
            loginBtn.addEventListener('click', () => {
                loginModal.style.display = 'block';
            });
        }
        
        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                document.getElementById('booking-details-modal').style.display = 'none';
                loginModal.style.display = 'none';
            });
        });
        
        // Switch between login and signup forms
        const switchToSignup = document.querySelector('.switch-to-signup');
        const switchToLogin = document.querySelector('.switch-to-login');
        const loginForm = document.getElementById('login-form');
        const signupForm = document.getElementById('signup-form');
        
        if (switchToSignup) {
            switchToSignup.addEventListener('click', e => {
                e.preventDefault();
                loginForm.style.display = 'none';
                signupForm.style.display = 'block';
            });
        }
        
        if (switchToLogin) {
            switchToLogin.addEventListener('click', e => {
                e.preventDefault();
                signupForm.style.display = 'none';
                loginForm.style.display = 'block';
            });
        }
        
        // Booking Tabs Functionality
        const bookingTabs = document.querySelectorAll('.booking-tab');
        
        bookingTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs
                bookingTabs.forEach(t => t.classList.remove('active'));
                
                // Add active class to clicked tab
                tab.classList.add('active');
                
                // Redirect to the same page with the filter parameter
                window.location.href = `booking.php?filter=${tab.dataset.tab}`;
            });
        });
        
        // View Booking Details
        const viewDetailsBtns = document.querySelectorAll('.view-details-btn');
        const bookingDetailsModal = document.getElementById('booking-details-modal');
        
        viewDetailsBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const bookingId = btn.dataset.bookingId;
                
                // Get the booking card that contains this button
                const bookingCard = btn.closest('.booking-card');
                
                // Get data from the booking card
                const bookingTitle = bookingCard.querySelector('.booking-title').textContent;
                const bookingSpecialRequests = bookingCard.querySelectorAll('.booking-info')[0].querySelector('span').textContent;
                const bookingDate = bookingCard.querySelectorAll('.booking-info')[1].querySelector('span').textContent;
                const bookingTravelers = bookingCard.querySelectorAll('.booking-info')[2].querySelector('span').textContent;
                
                // Get the booking from the PHP data
                <?php echo "const bookings = " . json_encode($bookings) . ";"; ?>
                const booking = bookings.find(b => b.id == bookingId);
                
                if (booking) {
                    // Fill the modal with data
                    document.getElementById('modal-booking-image').src = bookingImage;
                    document.getElementById('modal-booking-name').textContent = booking.full_name;
                    document.getElementById('modal-booking-email').textContent = booking.email;
                    document.getElementById('modal-booking-phone').textContent = booking.phone;
                    document.getElementById('modal-booking-dates').textContent = bookingDate;
                    document.getElementById('modal-booking-travelers').textContent = booking.travelers;
                    document.getElementById('modal-booking-payment').textContent = booking.payment_method;
                    document.getElementById('modal-booking-description').textContent = booking.special_requests || 'No special requests';
                    
                    // Show the modal
                    bookingDetailsModal.style.display = 'block';
                }
            });
        });
        
        // Cancel Booking
        const cancelBookingBtns = document.querySelectorAll('.cancel-booking-btn');
        
        cancelBookingBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const bookingId = btn.dataset.bookingId;
                if (confirm('Are you sure you want to cancel this booking?')) {
                    window.location.href = `cancel_booking.php?id=${bookingId}`;
                }
            });
        });
        
        // Logout function
        function logout() {
            window.location.href = 'logout.php';
        }
    </script>
</body>
</html> 