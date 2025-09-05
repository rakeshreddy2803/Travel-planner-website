<?php
// Start session
session_start();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);

// Include database connection
include_once 'db_connect.php';

// Initialize variables
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourly - Travel Packages</title>
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
    border-radius: var(--border-radius);
    cursor: pointer;
    transition: var(--transition);
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

/* Moving Text Banner */
        .moving-text {
    background-color: var(--secondary-color);
    color: white;
    padding: 10px 0;
            overflow: hidden;
            white-space: nowrap;
            text-align: center;
            font-weight: 500;
        }

        .moving-text span {
            display: inline-block;
    padding-left: 100%;
            animation: scrollText 20s linear infinite;
        }

        @keyframes scrollText {
    0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
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

/* Packages Section */
.packages-section {
    padding: 80px 0;
}

.filter-options {
    background-color: white;
    padding: 20px;
    border-radius: var(--border-radius);
    box-shadow: var(--box-shadow);
    margin-bottom: 40px;
                display: flex;
    flex-wrap: wrap;
    gap: 20px;
    align-items: flex-end;
}

.filter-group {
    flex: 1;
    min-width: 200px;
}

.filter-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--secondary-color);
}

.filter-group select {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: var(--border-radius);
    font-family: 'Poppins', sans-serif;
    background-color: white;
    transition: var(--transition);
}

.filter-group select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(42, 157, 143, 0.2);
}

.continent-heading {
    margin: 50px 0 30px;
    color: var(--secondary-color);
    font-size: 1.8rem;
    position: relative;
    padding-bottom: 10px;
}

.continent-heading::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 3px;
    background-color: var(--accent-color);
}

.packages-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 30px;
            margin-bottom: 40px;
        }

.package-card {
    background-color: white;
    border-radius: var(--border-radius);
            overflow: hidden;
    box-shadow: var(--box-shadow);
    transition: var(--transition);
            display: flex;
    flex-direction: column;
}

.package-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
}

.package-image {
    position: relative;
    height: 220px;
            overflow: hidden;
}

.package-image img {
            width: 100%;
    height: 100%;
            object-fit: cover;
    transition: transform 0.5s ease;
}

.package-card:hover .package-image img {
    transform: scale(1.05);
}

.package-tag {
    position: absolute;
    top: 15px;
    right: 15px;
    background-color: var(--accent-color);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.8rem;
            font-weight: 600;
    text-transform: uppercase;
}

.package-details {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.package-details h3 {
    font-size: 1.3rem;
    margin-bottom: 10px;
    color: var(--secondary-color);
}

.package-info {
            display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
    font-size: 0.9rem;
    color: #666;
}

.package-info span {
    display: flex;
            align-items: center;
}

.package-info i {
    margin-right: 5px;
    color: var(--primary-color);
}

.package-details p {
    margin-bottom: 20px;
    color: #555;
            flex: 1;
}

.package-price {
    margin-bottom: 20px;
}

.package-price .price {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color);
}

.package-price .per-person {
    font-size: 0.9rem;
    color: #777;
    margin-left: 5px;
}

.package-actions {
    display: flex;
    gap: 10px;
}

.package-actions .btn {
    flex: 1;
    padding: 10px;
    font-size: 0.9rem;
}

.load-more-container {
    text-align: center;
    margin-top: 40px;
}

.load-more-container .btn {
    padding: 12px 30px;
}

/* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
    background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
    justify-content: center;
    z-index: 2000;
            opacity: 0;
            visibility: hidden;
    transition: var(--transition);
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
    background-color: white;
    border-radius: var(--border-radius);
            width: 90%;
    max-width: 900px;
            max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    transform: translateY(20px);
    transition: var(--transition);
        }

        .modal-overlay.active .modal-content {
    transform: translateY(0);
        }

        .modal-header {
            position: relative;
    padding: 20px;
    border-bottom: 1px solid #eee;
}

.modal-header h3 {
    color: var(--secondary-color);
        }

        .close-modal {
            position: absolute;
    top: 20px;
    right: 20px;
    font-size: 1.5rem;
    background: none;
            border: none;
            cursor: pointer;
    color: #777;
    transition: var(--transition);
        }

        .close-modal:hover {
    color: var(--danger-color);
    transform: rotate(90deg);
        }

        .modal-body {
    padding: 20px;
}

.modal-footer {
    padding: 20px;
    border-top: 1px solid #eee;
    display: flex;
    justify-content: flex-end;
    gap: 15px;
}

/* Package Details Modal */
#modal-package-image {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: var(--border-radius) var(--border-radius) 0 0;
}

#modal-package-title {
    font-size: 1.8rem;
    color: var(--secondary-color);
            margin-bottom: 15px;
        }

.modal-body .package-info {
    margin-bottom: 20px;
    font-size: 1rem;
}

.tab-titles {
    display: flex;
    border-bottom: 1px solid #eee;
    margin-bottom: 20px;
}

.tab-title {
    padding: 12px 20px;
    font-weight: 500;
    cursor: pointer;
    color: #666;
    position: relative;
}

.tab-title.active {
    color: var(--primary-color);
}

.tab-title.active::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    height: 2px;
    background-color: var(--primary-color);
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

/* Package Details Tab Styles */
.included-list, .itinerary-list, .info-list {
    padding-left: 20px;
    margin-bottom: 20px;
}

.included-list li, .info-list li {
    margin-bottom: 10px;
    position: relative;
    padding-left: 25px;
}

.included-list li::before {
    content: '\f00c';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    left: 0;
    color: var(--primary-color);
}

.info-list li::before {
    content: '\f05a';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    position: absolute;
    left: 0;
    color: var(--primary-color);
}

.itinerary-list {
    list-style-type: none;
    counter-reset: day-counter;
    padding: 0;
}

.itinerary-list li {
    counter-increment: day-counter;
    position: relative;
    margin-bottom: 25px;
    padding-left: 40px;
    padding-bottom: 20px;
    border-left: 2px solid #eee;
}

.itinerary-list li:last-child {
    padding-bottom: 0;
    margin-bottom: 0;
}

.itinerary-list li::before {
    content: 'Day ' counter(day-counter);
    position: absolute;
    top: 0;
    left: -15px;
    width: 30px;
    height: 30px;
    background-color: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: 600;
}

.itinerary-title {
    margin-bottom: 5px;
    color: var(--secondary-color);
    font-weight: 600;
}

.price-breakdown {
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: var(--border-radius);
    margin-bottom: 20px;
}

.price-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px dotted #ddd;
}

.price-row:last-child {
    border-bottom: none;
    font-weight: 700;
    padding-top: 12px;
    color: var(--primary-color);
}

/* Booking Modal */
.modal-booking-form {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

@media (max-width: 768px) {
    .modal-booking-form {
        grid-template-columns: 1fr;
    }
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--secondary-color);
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: var(--border-radius);
    font-family: 'Poppins', sans-serif;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(42, 157, 143, 0.2);
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
}

/* Login and Signup Modals */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: white;
    border-radius: 10px;
    padding: 30px;
    width: 90%;
    max-width: 500px;
    position: relative;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.modal-title {
    text-align: center;
    margin-bottom: 20px;
    color: var(--secondary-color);
}

.form-footer {
    margin-top: 20px;
    text-align: center;
}

.form-footer a {
    color: var(--primary-color);
}

/* Responsive Styles */
@media (max-width: 992px) {
    .packages-grid {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    }
}

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
    
    .packages-grid {
        grid-template-columns: 1fr;
    }
    
    .filter-options {
        flex-direction: column;
    }
}

@media (max-width: 576px) {
    .section-title h2 {
        font-size: 2rem;
    }
    
    .package-actions {
        flex-direction: column;
    }
}
/* Footer Styles */
footer {
    background-color: var(--bg-dark);
    color: var(--text-light);
    padding: 60px 0 20px;
    margin-top: 50px;
}

.footer-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 40px;
    margin-bottom: 40px;
}

.footer-col {
    padding: 0 15px;
}

.footer-col .logo {
    font-size: 1.8rem;
    margin-bottom: 20px;
    color: var(--text-light);
}

.footer-col .logo i {
    color: var(--accent-color);
}

.footer-col p {
    margin-bottom: 20px;
    color: var(--text-muted);
    line-height: 1.6;
}

.footer-col h3 {
    font-size: 1.3rem;
    margin-bottom: 25px;
    position: relative;
    color: var(--text-light);
    padding-bottom: 10px;
}

.footer-col h3::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 2px;
    background-color: var(--accent-color);
}

.footer-links {
    list-style: none;
}

.footer-links li {
    margin-bottom: 12px;
}

.footer-links a {
    color: var(--text-muted);
    transition: all 0.3s ease;
    display: inline-block;
}

.footer-links a:hover {
    color: var(--accent-color);
    transform: translateX(5px);
}

.social-links {
    display: flex;
    gap: 15px;
    margin-top: 20px;
}

.social-links a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background-color: var(--bg-darker);
    color: var(--text-light);
    border-radius: 50%;
    transition: all 0.3s ease;
}

.social-links a:hover {
    background-color: var(--accent-color);
    transform: translateY(-3px);
}

.footer-bottom {
    text-align: center;
    padding-top: 20px;
    border-top: 1px solid var(--bg-darker);
    color: var(--text-muted);
    font-size: 0.9rem;
}

/* Responsive Footer */
@media (max-width: 768px) {
    .footer-container {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .footer-col {
        margin-bottom: 30px;
    }
    
    .footer-col:last-child {
        margin-bottom: 0;
    }
}

/* Continent Navigation */
.continent-navigation {
    margin: 30px 0;
}

.continent-nav-list {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 15px;
    list-style: none;
    padding: 0;
}

.continent-nav-list li {
    margin: 0;
}

.continent-link {
    display: inline-block;
    padding: 8px 16px;
    background-color: white;
    color: var(--secondary-color);
    border: 2px solid var(--primary-color);
    border-radius: 30px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.continent-link:hover, 
.continent-link.active {
    background-color: var(--primary-color);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(47, 133, 90, 0.2);
}

html {
    scroll-behavior: smooth;
}

@media (max-width: 768px) {
    .continent-nav-list {
        flex-direction: row;
        overflow-x: auto;
        padding-bottom: 10px;
        justify-content: flex-start;
    }
    
    .continent-link {
        white-space: nowrap;
    }
}
    </style>
</head>
<body>
    <!-- Moving Text Banner -->
    <div class="moving-text">
        <span>🔥 Special Offer: Get 15% off on all international packages! Limited time offer. Book now! | Refer a friend and get ₹2000 off on your next booking! | Featured Destination: Experience the magic of Bali with our 5-night package starting at just ₹69,999! 🔥</span>
    </div>
    
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-container">
                <a href="finalproject.php" class="logo">
                    <i class="fas fa-plane"></i><span>Tourly</span>
                </a>
                
                <nav>
                    <ul>
                        <li><a href="finalproject.php">Home</a></li>
                        <li><a href="packages.php" class="active">Packages</a></li>
                        <li><a href="finalproject.php#services">Services</a></li>
                        <li><a href="finalproject.php#reviews">Reviews</a></li>
                        <li><a href="finalproject.php#contact">Contact</a></li>
                        <li class="logged-in-only" style="display: none;"><a href="booking.php">My Bookings</a></li>
                        <li class="logged-in-only" style="display: none;"><a href="profile.php">My Profile</a></li>
                    </ul>
                </nav>
                
                <div class="auth-buttons">
                    <?php if ($user): ?>
                        <a href="profile.php" class="btn btn-outline">My Profile</a>
                        <a href="logout.php" class="btn">Logout</a>
                    <?php else: ?>
                    <?php endif; ?>
                </div>
                
                <button class="mobile-nav-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <main>
        <!-- Packages Section -->
        <section class="packages-section">
            <div class="container">
                <div class="section-title">
                    <h2>Explore Our Packages</h2>
                    <p>Discover our carefully curated selection of travel packages. Whether you're looking for adventure, relaxation, or cultural experiences, we have something for every traveler.</p>
                </div>
                
                <!-- Filter Options -->
                <div class="filter-options">
                    <div class="filter-group">
                        <label for="destination-filter">Destination</label>
                        <select id="destination-filter">
                            <option value="all">All Destinations</option>
                            <option value="europe">Europe</option>
                            <option value="asia">Asia</option>
                            <option value="north-america">North America</option>
                            <option value="south-america">South America</option>
                            <option value="africa">Africa</option>
                            <option value="oceania">Oceania</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="duration-filter">Duration</label>
                        <select id="duration-filter">
                            <option value="all">Any Duration</option>
                            <option value="3-5">3-5 Days</option>
                            <option value="6-10">6-10 Days</option>
                            <option value="11-15">11-15 Days</option>
                            <option value="15+">15+ Days</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="price-filter">Price Range</label>
                        <select id="price-filter">
                            <option value="all">All Prices</option>
                            <option value="budget">Budget (Below ₹50,000)</option>
                            <option value="mid-range">Mid-range (₹50,000 - ₹1,00,000)</option>
                            <option value="luxury">Luxury (Above ₹1,00,000)</option>
                        </select>
                    </div>
                    
                    <button id="apply-filters" class="btn">Apply Filters</button>
                    <button id="reset-filters" class="btn btn-outline">Reset</button>
                </div>
                
                <!-- Continent Navigation -->
                <div class="continent-navigation">
                    <ul class="continent-nav-list">
                        <li><a href="#all-packages" class="continent-link active" data-continent="all">All</a></li>
                        <li><a href="#europe-packages" class="continent-link" data-continent="europe">Europe</a></li>
                        <li><a href="#asia-packages" class="continent-link" data-continent="asia">Asia</a></li>
                        <li><a href="#north-america-packages" class="continent-link" data-continent="north-america">North America</a></li>
                        <li><a href="#south-america-packages" class="continent-link" data-continent="south-america">South America</a></li>
                        <li><a href="#africa-packages" class="continent-link" data-continent="africa">Africa</a></li>
                        <li><a href="#oceania-packages" class="continent-link" data-continent="oceania">Oceania</a></li>
                    </ul>
                </div>
                
                <!-- Europe Packages -->
                <div id="europe-packages"></div>
                <h2 class="continent-heading">Europe</h2>
                <div class="packages-grid">
                    <!-- Package Card 1 -->
                    <div class="package-card" data-continent="europe" data-destination="france" data-duration="7" data-price="mid-range">
                        <div class="package-image">
                            <img src="https://i.pinimg.com/474x/d6/35/cd/d635cd00e7c0ff8d867846dc53fea4b4.jpg" alt="Paris & Amsterdam">
                            <div class="package-tag">Featured</div>
                        </div>
                        <div class="package-details">
                            <h3>Paris & Amsterdam (7 days)</h3>
                            <div class="package-info">
                                <span><i class="fas fa-map-marker-alt"></i> France & Netherlands</span>
                                <span><i class="fas fa-calendar-alt"></i> 7 Days / 6 Nights</span>
                            </div>
                            <p>Experience the romance of Paris and the charm of Amsterdam with this comprehensive package.</p>
                            <div class="package-price">
                                <span class="price">₹1,49,999</span>
                                <span class="per-person">per person</span>
                            </div>
                            <div class="package-actions">
                                <a href="#" class="btn btn-outline package-details-btn" data-package-id="1">Details</a>
                                <a href="#" class="btn package-book-btn" data-package-id="1">Book Now</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Package Card 2 -->
                    <div class="package-card" data-continent="europe" data-destination="italy" data-duration="8" data-price="mid-range">
                        <div class="package-image">
                            <img src="https://i.pinimg.com/736x/5b/3b/6e/5b3b6e3f2d9720783397bbb64f5bacc3.jpg" alt="Rome & Florence">
                            <div class="package-tag">Popular</div>
                        </div>
                        <div class="package-details">
                            <h3>Rome & Florence (8 days)</h3>
                            <div class="package-info">
                                <span><i class="fas fa-map-marker-alt"></i> Italy</span>
                                <span><i class="fas fa-calendar-alt"></i> 8 Days / 7 Nights</span>
                            </div>
                            <p>Discover the art, history, and culture of Italy with this comprehensive package.</p>
                            <div class="package-price">
                                <span class="price">₹1,45,999</span>
                                <span class="per-person">per person</span>
                            </div>
                            <div class="package-actions">
                                <a href="#" class="btn btn-outline package-details-btn" data-package-id="2">Details</a>
                                <a href="#" class="btn package-book-btn" data-package-id="2">Book Now</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Package Card 3 -->
                    <div class="package-card" data-continent="europe" data-destination="switzerland" data-duration="6" data-price="luxury">
                        <div class="package-image">
                            <img src="https://images.pexels.com/photos/12340644/pexels-photo-12340644.jpeg" alt="Swiss Alps">
                        </div>
                        <div class="package-details">
                            <h3>Swiss Alps Adventure (6 days)</h3>
                            <div class="package-info">
                                <span><i class="fas fa-map-marker-alt"></i> Switzerland</span>
                                <span><i class="fas fa-calendar-alt"></i> 6 Days / 5 Nights</span>
                            </div>
                            <p>Experience the breathtaking beauty of the Swiss Alps with this adventure-packed itinerary.</p>
                            <div class="package-price">
                                <span class="price">₹1,65,999</span>
                                <span class="per-person">per person</span>
                            </div>
                            <div class="package-actions">
                                <a href="#" class="btn btn-outline package-details-btn" data-package-id="3">Details</a>
                                <a href="#" class="btn package-book-btn" data-package-id="3">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Asia Packages -->
                <div id="asia-packages"></div>
                <h2 class="continent-heading">Asia</h2>
                <div class="packages-grid">
                    <!-- Package Card 4 -->
                    <div class="package-card" data-continent="asia" data-destination="japan" data-duration="9" data-price="luxury">
                        <div class="package-image">
                            <img src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Tokyo & Kyoto">
                            <div class="package-tag">Premium</div>
                        </div>
                        <div class="package-details">
                            <h3>Japan Essentials (9 days)</h3>
                            <div class="package-info">
                                <span><i class="fas fa-map-marker-alt"></i> Japan</span>
                                <span><i class="fas fa-calendar-alt"></i> 9 Days / 8 Nights</span>
                            </div>
                            <p>Immerse yourself in Japanese culture with visits to Tokyo, Kyoto, and Osaka.</p>
                            <div class="package-price">
                                <span class="price">₹1,85,999</span>
                                <span class="per-person">per person</span>
                            </div>
                            <div class="package-actions">
                                <a href="#" class="btn btn-outline package-details-btn" data-package-id="4">Details</a>
                                <a href="#" class="btn package-book-btn" data-package-id="4">Book Now</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Package Card 5 -->
                    <div class="package-card" data-continent="asia" data-destination="thailand" data-duration="7" data-price="mid-range">
                        <div class="package-image">
                            <img src="https://images.pexels.com/photos/1007657/pexels-photo-1007657.jpeg" alt="Thailand">
                        </div>
                        <div class="package-details">
                            <h3>Thailand Highlights (7 days)</h3>
                            <div class="package-info">
                                <span><i class="fas fa-map-marker-alt"></i> Thailand</span>
                                <span><i class="fas fa-calendar-alt"></i> 7 Days / 6 Nights</span>
                            </div>
                            <p>Experience the vibrant culture, beautiful beaches, and delicious food of Thailand.</p>
                            <div class="package-price">
                                <span class="price">₹89,999</span>
                                <span class="per-person">per person</span>
                            </div>
                            <div class="package-actions">
                                <a href="#" class="btn btn-outline package-details-btn" data-package-id="5">Details</a>
                                <a href="#" class="btn package-book-btn" data-package-id="5">Book Now</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Package Card for India -->
                    <div class="package-card" data-continent="asia" data-destination="india" data-duration="6" data-price="mid-range">
                        <div class="package-image">
                            <img src="https://images.unsplash.com/photo-1524492412937-b28074a5d7da?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="India">
                            <div class="package-tag">Best Seller</div>
                        </div>
                        <div class="package-details">
                            <h3>Golden Triangle (6 days)</h3>
                            <div class="package-info">
                                <span><i class="fas fa-map-marker-alt"></i> India</span>
                                <span><i class="fas fa-calendar-alt"></i> 6 Days / 5 Nights</span>
                            </div>
                            <p>Explore India's iconic Golden Triangle: Delhi, Agra, and Jaipur with cultural experiences.</p>
                            <div class="package-price">
                                <span class="price">₹65,999</span>
                                <span class="per-person">per person</span>
                            </div>
                            <div class="package-actions">
                                <a href="#" class="btn btn-outline package-details-btn" data-package-id="11">Details</a>
                                <a href="#" class="btn package-book-btn" data-package-id="11">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- North America Packages -->
                <div id="north-america-packages"></div>
                <h2 class="continent-heading">North America</h2>
                <div class="packages-grid">
                    <!-- Package Card 6 -->
                    <div class="package-card" data-continent="north-america" data-destination="usa" data-duration="6-10" data-price="luxury">
                        <div class="package-image">
                            <img src="https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="New York">
                        </div>
                        <div class="package-details">
                            <h3>New York City Explorer (5 days)</h3>
                            <div class="package-info">
                                <span><i class="fas fa-map-marker-alt"></i> USA</span>
                                <span><i class="fas fa-calendar-alt"></i> 5 Days / 4 Nights</span>
                            </div>
                            <p>Experience the energy and excitement of New York City with this comprehensive city tour.</p>
                            <div class="package-price">
                                <span class="price">₹1,25,999</span>
                                <span class="per-person">per person</span>
                            </div>
                            <div class="package-actions">
                                <a href="#" class="btn btn-outline package-details-btn" data-package-id="6">Details</a>
                                <a href="#" class="btn package-book-btn" data-package-id="6">Book Now</a>
                            </div>
                        </div>
                    </div>
                
                    <!-- Package Card 7 -->
                    <div class="package-card" data-continent="north-america" data-destination="canada" data-duration="6-10" data-price="mid-range">
                        <div class="package-image">
                            <img src="https://images.unsplash.com/photo-1519181245277-cffeb31da2e3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Canadian Rockies">
                        </div>
                        <div class="package-details">
                            <h3>Canadian Rockies (7 days)</h3>
                            <div class="package-info">
                                <span><i class="fas fa-map-marker-alt"></i> Canada</span>
                                <span><i class="fas fa-calendar-alt"></i> 7 Days / 6 Nights</span>
                            </div>
                            <p>Discover the stunning landscapes of the Canadian Rockies with this adventure package.</p>
                            <div class="package-price">
                                <span class="price">₹1,35,999</span>
                                <span class="per-person">per person</span>
                            </div>
                            <div class="package-actions">
                                <a href="#" class="btn btn-outline package-details-btn" data-package-id="7">Details</a>
                                <a href="#" class="btn package-book-btn" data-package-id="7">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- South America Packages -->
                <div id="south-america-packages"></div>
                <h2 class="continent-heading">South America</h2>
                <div class="packages-grid">
                    <!-- Package Card 8 -->
                    <div class="package-card" data-continent="south-america" data-destination="peru" data-duration="6-10" data-price="mid-range">
                        <div class="package-image">
                            <img src="https://images.unsplash.com/photo-1526392060635-9d6019884377?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Machu Picchu">
                        </div>
                        <div class="package-details">
                            <h3>Peru & Machu Picchu (8 days)</h3>
                            <div class="package-info">
                                <span><i class="fas fa-map-marker-alt"></i> Peru</span>
                                <span><i class="fas fa-calendar-alt"></i> 8 Days / 7 Nights</span>
                            </div>
                            <p>Explore the ancient ruins of Machu Picchu and the cultural highlights of Peru.</p>
                            <div class="package-price">
                                <span class="price">₹1,45,999</span>
                                <span class="per-person">per person</span>
                            </div>
                            <div class="package-actions">
                                <a href="#" class="btn btn-outline package-details-btn" data-package-id="8">Details</a>
                                <a href="#" class="btn package-book-btn" data-package-id="8">Book Now</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Package Card for Brazil -->
                    <div class="package-card" data-continent="south-america" data-destination="brazil" data-duration="6-10" data-price="luxury">
                        <div class="package-image">
                            <img src="https://images.unsplash.com/photo-1483729558449-99ef09a8c325?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Rio de Janeiro">
                        </div>
                        <div class="package-details">
                            <h3>Brazil Adventure (9 days)</h3>
                            <div class="package-info">
                                <span><i class="fas fa-map-marker-alt"></i> Brazil</span>
                                <span><i class="fas fa-calendar-alt"></i> 9 Days / 8 Nights</span>
                            </div>
                            <p>Experience Rio de Janeiro, the Amazon rainforest, and the stunning beaches of Brazil.</p>
                            <div class="package-price">
                                <span class="price">₹1,55,999</span>
                                <span class="per-person">per person</span>
                            </div>
                            <div class="package-actions">
                                <a href="#" class="btn btn-outline package-details-btn" data-package-id="12">Details</a>
                                <a href="#" class="btn package-book-btn" data-package-id="12">Book Now</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Package Card for Argentina -->
                    <div class="package-card" data-continent="south-america" data-destination="argentina" data-duration="6-10" data-price="mid-range">
                        <div class="package-image">
                            <img src="https://images.unsplash.com/photo-1589909202802-8f4aadce1849?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Buenos Aires">
                        </div>
                        <div class="package-details">
                            <h3>Argentina Explorer (7 days)</h3>
                            <div class="package-info">
                                <span><i class="fas fa-map-marker-alt"></i> Argentina</span>
                                <span><i class="fas fa-calendar-alt"></i> 7 Days / 6 Nights</span>
                            </div>
                            <p>Discover Buenos Aires, Patagonia, and experience authentic Argentine tango.</p>
                            <div class="package-price">
                                <span class="price">₹1,35,999</span>
                                <span class="per-person">per person</span>
                            </div>
                            <div class="package-actions">
                                <a href="#" class="btn btn-outline package-details-btn" data-package-id="13">Details</a>
                                <a href="#" class="btn package-book-btn" data-package-id="13">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Africa Packages -->
                <div id="africa-packages"></div>
                <h2 class="continent-heading">Africa</h2>
                <div class="packages-grid">
                    <!-- Package Card 9 -->
                    <div class="package-card" data-continent="africa" data-destination="south-africa" data-duration="6-10" data-price="luxury">
                        <div class="package-image">
                            <img src="https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="South African Safari">
                        </div>
                        <div class="package-details">
                            <h3>South African Safari (6 days)</h3>
                            <div class="package-info">
                                <span><i class="fas fa-map-marker-alt"></i> South Africa</span>
                                <span><i class="fas fa-calendar-alt"></i> 6 Days / 5 Nights</span>
                            </div>
                            <p>Experience the thrill of a South African safari with this luxury adventure package.</p>
                            <div class="package-price">
                                <span class="price">₹1,75,999</span>
                                <span class="per-person">per person</span>
                            </div>
                            <div class="package-actions">
                                <a href="#" class="btn btn-outline package-details-btn" data-package-id="9">Details</a>
                                <a href="#" class="btn package-book-btn" data-package-id="9">Book Now</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Package Card for Morocco -->
                    <div class="package-card" data-continent="africa" data-destination="morocco" data-duration="6-10" data-price="mid-range">
                        <div class="package-image">
                            <img src="https://images.unsplash.com/photo-1489493887464-892be6d1daae?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Morocco">
                        </div>
                        <div class="package-details">
                            <h3>Moroccan Magic (8 days)</h3>
                            <div class="package-info">
                                <span><i class="fas fa-map-marker-alt"></i> Morocco</span>
                                <span><i class="fas fa-calendar-alt"></i> 8 Days / 7 Nights</span>
                            </div>
                            <p>Explore the vibrant markets, ancient medinas, and Sahara Desert in Morocco.</p>
                            <div class="package-price">
                                <span class="price">₹1,25,999</span>
                                <span class="per-person">per person</span>
                            </div>
                            <div class="package-actions">
                                <a href="#" class="btn btn-outline package-details-btn" data-package-id="14">Details</a>
                                <a href="#" class="btn package-book-btn" data-package-id="14">Book Now</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Package Card for Egypt -->
                    <div class="package-card" data-continent="africa" data-destination="egypt" data-duration="6-10" data-price="mid-range">
                        <div class="package-image">
                            <img src="https://images.unsplash.com/photo-1503177119275-0aa32b3a9368?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Egypt">
                        </div>
                        <div class="package-details">
                            <h3>Egyptian Wonders (7 days)</h3>
                            <div class="package-info">
                                <span><i class="fas fa-map-marker-alt"></i> Egypt</span>
                                <span><i class="fas fa-calendar-alt"></i> 7 Days / 6 Nights</span>
                            </div>
                            <p>Discover the ancient pyramids, cruise the Nile, and explore Cairo's treasures.</p>
                            <div class="package-price">
                                <span class="price">₹1,15,999</span>
                                <span class="per-person">per person</span>
                            </div>
                            <div class="package-actions">
                                <a href="#" class="btn btn-outline package-details-btn" data-package-id="15">Details</a>
                                <a href="#" class="btn package-book-btn" data-package-id="15">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Oceania Packages -->
                <div id="oceania-packages"></div>
                <h2 class="continent-heading">Oceania</h2>
                <div class="packages-grid">
                    <!-- Package Card 10 -->
                    <div class="package-card" data-continent="oceania" data-destination="australia" data-duration="11-15" data-price="luxury">
                        <div class="package-image">
                            <img src="https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Australia Highlights">
                        </div>
                        <div class="package-details">
                            <h3>Australia Highlights (12 days)</h3>
                            <div class="package-info">
                                <span><i class="fas fa-map-marker-alt"></i> Australia</span>
                                <span><i class="fas fa-calendar-alt"></i> 12 Days / 11 Nights</span>
                            </div>
                            <p>Experience the best of Australia, from Sydney and Melbourne to the Great Barrier Reef.</p>
                            <div class="package-price">
                                <span class="price">₹2,45,999</span>
                                <span class="per-person">per person</span>
                            </div>
                            <div class="package-actions">
                                <a href="#" class="btn btn-outline package-details-btn" data-package-id="10">Details</a>
                                <a href="#" class="btn package-book-btn" data-package-id="10">Book Now</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Package Card for New Zealand -->
                    <div class="package-card" data-continent="oceania" data-destination="new-zealand" data-duration="11-15" data-price="luxury">
                        <div class="package-image">
                            <img src="https://images.unsplash.com/photo-1469521669194-babb45599def?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="New Zealand">
                        </div>
                        <div class="package-details">
                            <h3>New Zealand Adventure (10 days)</h3>
                            <div class="package-info">
                                <span><i class="fas fa-map-marker-alt"></i> New Zealand</span>
                                <span><i class="fas fa-calendar-alt"></i> 10 Days / 9 Nights</span>
                            </div>
                            <p>Experience breathtaking landscapes, thrilling adventures, and Maori culture.</p>
                            <div class="package-price">
                                <span class="price">₹2,15,999</span>
                                <span class="per-person">per person</span>
                            </div>
                            <div class="package-actions">
                                <a href="#" class="btn btn-outline package-details-btn" data-package-id="16">Details</a>
                                <a href="#" class="btn package-book-btn" data-package-id="16">Book Now</a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Package Card for Fiji -->
                    <div class="package-card" data-continent="oceania" data-destination="fiji" data-duration="6-10" data-price="luxury">
                        <div class="package-image">
                            <img src="https://images.pexels.com/photos/1752461/pexels-photo-1752461.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2" alt="Fiji">
                        </div>
                        <div class="package-details">
                            <h3>Fiji Island Paradise (8 days)</h3>
                            <div class="package-info">
                                <span><i class="fas fa-map-marker-alt"></i> Fiji</span>
                                <span><i class="fas fa-calendar-alt"></i> 8 Days / 7 Nights</span>
                            </div>
                            <p>Relax on pristine beaches, snorkel in crystal clear waters, and enjoy Fijian hospitality.</p>
                            <div class="package-price">
                                <span class="price">₹1,85,999</span>
                                <span class="per-person">per person</span>
                            </div>
                            <div class="package-actions">
                                <a href="#" class="btn btn-outline package-details-btn" data-package-id="17">Details</a>
                                <a href="#" class="btn package-book-btn" data-package-id="17">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="load-more-container">
                    <button id="load-more" class="btn btn-outline">Load More Packages</button>
                </div>
            </div>
        </section>
    </main>
    
    <!-- Package Details Modal -->
    <div class="modal-overlay" id="package-details-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-package-title">Package Title</h3>
                <button id="modal-close-btn" class="close-modal">&times;</button>
            </div>
            <img src="" alt="Package Image" id="modal-package-image">
            <div class="modal-body">
                <div class="package-info">
                    <span><i class="fas fa-map-marker-alt"></i> <span id="modal-package-location">Location</span></span>
                    <span><i class="fas fa-calendar-alt"></i> <span id="modal-package-duration">Duration</span></span>
                </div>
                
                <div class="tab-titles">
                    <div class="tab-title active" data-tab="overview">Overview</div>
                    <div class="tab-title" data-tab="included">What's Included</div>
                    <div class="tab-title" data-tab="itinerary">Itinerary</div>
                    <div class="tab-title" data-tab="info">Important Info</div>
                </div>
                
                <div class="tab-content active" id="overview-tab">
                    <p id="modal-package-description">Package description goes here.</p>
                    
                    <div class="price-breakdown">
                        <div class="price-row">
                            <span>Base Price</span>
                            <span id="modal-base-price">₹1,49,999</span>
                        </div>
                        <div class="price-row">
                            <span>Taxes & Fees</span>
                            <span id="modal-taxes">₹15,000</span>
                        </div>
                        <div class="price-row">
                            <span>Total Price (per person)</span>
                            <span id="modal-total-price">₹1,64,999</span>
                        </div>
                    </div>
                </div>
                
                <div class="tab-content" id="included-tab">
                    <ul class="included-list" id="modal-inclusions">
                        <!-- Inclusions will be dynamically added here -->
                    </ul>
                </div>
                
                <div class="tab-content" id="itinerary-tab">
                    <ul class="itinerary-list" id="modal-itinerary">
                        <!-- Itinerary will be dynamically added here -->
                    </ul>
                </div>
                
                <div class="tab-content" id="info-tab">
                    <ul class="info-list" id="modal-info">
                        <!-- Important info will be dynamically added here -->
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="modal-close-btn-2">Close</button>
                <button class="btn" id="modal-book-btn">Book Now</button>
            </div>
        </div>
    </div>
    
    <!-- Booking Modal -->
    <div class="modal-overlay" id="booking-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Book Your Package</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="booking-form" action="process_booking.php" method="post">
                    <input type="hidden" id="package_id" name="package_id" value="">
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                    <?php endif; ?>
                    <div class="modal-booking-form">
                        <div class="form-group">
                            <label for="booking-name">Full Name</label>
                            <input type="text" id="booking-name" name="full_name" value="<?php echo isset($_SESSION['full_name']) ? $_SESSION['full_name'] : ''; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="booking-email">Email Address</label>
                            <input type="email" id="booking-email" name="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="booking-phone">Phone Number</label>
                            <input type="tel" id="booking-phone" name="phone" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="booking-date">Travel Date</label>
                            <input type="date" id="booking-date" name="travel_date" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="booking-travelers">Number of Travelers</label>
                            <select id="booking-travelers" name="travelers" required>
                                <option value="">Select</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6+</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="booking-notes">Special Requests</label>
                            <textarea id="booking-notes" name="special_requests" rows="3"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="booking-payment">Payment Method</label>
                            <select id="booking-payment" name="payment_method" required>
                                <option value="">Select</option>
                                <option value="credit">Credit Card</option>
                                <option value="debit">Debit Card</option>
                                <option value="upi">UPI</option>
                                <option value="netbanking">Net Banking</option>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn">Confirm Booking</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-col">
                    <div class="logo">
                        <i class="fas fa-plane"></i><span>Tourly</span>
                    </div>
                    <p>Making travel planning effortless and enjoyable since 2023. Discover your next adventure with us.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <ul class="footer-links">
                        <li><a href="finalproject.php">Home</a></li>
                        <li><a href="finalproject.php#services">Services</a></li>
                        <li><a href="packages.php">Packages</a></li>
                        <li><a href="bookings.php">My Bookings</a></li>
                        <li><a href="profile.php">My Profile</a></li>
                        <li><a href="finalproject.php#reviews">Reviews</a></li>
                        <li><a href="finalproject.php#contact">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h3>Destinations</h3>
                    <ul class="footer-links">
                        <li><a href="#">Europe</a></li>
                        <li><a href="#">Asia</a></li>
                        <li><a href="#">North America</a></li>
                        <li><a href="#">South America</a></li>
                        <li><a href="#">Africa</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h3>Support</h3>
                    <ul class="footer-links">
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Refund Policy</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 Tourly Travel Company. All Rights Reserved. Prices in Indian Rupees (₹).</p>
            </div>
        </div>
    </footer>

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
            <form id="signup-form" action="db_signup.php" method="post" style="display: none;">
                <div class="form-group">
                    <label for="signup-name">Full Name</label>
                    <input type="text" id="signup-name" name="fullname" required>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Continent navigation functionality
            const continentLinks = document.querySelectorAll('.continent-link');
            const packageCards = document.querySelectorAll('.package-card');
            
            // Group packages by continent
            const packageGroups = {};
            document.querySelectorAll('.continent-heading').forEach(heading => {
                const continent = heading.textContent.toLowerCase();
                packageGroups[continent] = [];
                
                let nextElement = heading.nextElementSibling;
                while(nextElement && !nextElement.classList.contains('continent-heading')) {
                    if(nextElement.classList.contains('packages-grid')) {
                        const cards = nextElement.querySelectorAll('.package-card');
                        cards.forEach(card => {
                            packageGroups[continent].push(card);
                        });
                    }
                    nextElement = nextElement.nextElementSibling;
                }
            });
            
            // Add click event to continent links
            continentLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    // Don't cancel the default behavior to allow scrolling to anchors
                    // but still handle the filtering and active class
                    
                    // Update active state
                    continentLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                    
                    const continent = this.getAttribute('data-continent');
                    
                    // Show all if 'all' is selected
                    if(continent === 'all') {
                        packageCards.forEach(card => {
                            card.style.display = 'flex';
                        });
                        return;
                    }
                    
                    // Hide all cards first
                    packageCards.forEach(card => {
                        card.style.display = 'none';
                    });
                    
                    // Show cards for selected continent
                    const cards = document.querySelectorAll(`.package-card[data-continent="${continent}"]`);
                    cards.forEach(card => {
                        card.style.display = 'flex';
                    });
                });
            });
            
            // Add smooth scrolling for continent links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    // Allow default behavior for hash links
                    // The smooth scrolling is handled by CSS (scroll-behavior: smooth)
                });
            });
        
            // Get all necessary elements
            const loginForm = document.getElementById('login-form');
            const signupForm = document.getElementById('signup-form');
            const loginBtn = document.querySelector('.login-btn');
            const modal = document.getElementById('login-modal');
            const closeBtns = document.querySelectorAll('.close-modal');
            const switchToSignup = document.querySelector('.switch-to-signup');
            const switchToLogin = document.querySelector('.switch-to-login');
            const modalTitle = document.querySelector('.modal-title');
            
            // Package details modal elements
            const packageDetailsModal = document.getElementById('package-details-modal');
            const packageDetailsBtns = document.querySelectorAll('.package-details-btn');
            const modalCloseBtns = document.querySelectorAll('#modal-close-btn, #modal-close-btn-2');
            const modalBookBtn = document.getElementById('modal-book-btn');
            
            // Booking modal elements
            const bookingModal = document.getElementById('booking-modal');
            const packageBookBtns = document.querySelectorAll('.package-book-btn');
            const bookingForm = document.getElementById('booking-form');
            
            // Show login modal
            if (loginBtn) {
                loginBtn.addEventListener('click', () => {
                    modal.style.display = 'flex';
                });
            }
            
            // Close modals
            closeBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const modalToClose = this.closest('.modal') || this.closest('.modal-overlay');
                    if (modalToClose.classList.contains('modal')) {
                        modalToClose.style.display = 'none';
                    } else {
                        modalToClose.classList.remove('active');
                    }
                });
            });
            
            // Switch between login and signup forms
            if (switchToSignup) {
                switchToSignup.addEventListener('click', (e) => {
                    e.preventDefault();
                    loginForm.style.display = 'none';
                    signupForm.style.display = 'block';
                    modalTitle.textContent = 'Create an Account';
                });
            }
            
            if (switchToLogin) {
                switchToLogin.addEventListener('click', (e) => {
                    e.preventDefault();
                    signupForm.style.display = 'none';
                    loginForm.style.display = 'block';
                    modalTitle.textContent = 'Welcome Back';
                });
            }
            
            // Package details functionality
            if (packageDetailsBtns.length > 0) {
                packageDetailsBtns.forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const packageId = this.getAttribute('data-package-id');
                        
                        // In a real application, you would fetch package details from a server
                        // For now, we'll simulate that with mock data
                        const packageData = getPackageDetails(packageId);
                        
                        // Update package details in modal
                        document.getElementById('modal-package-title').textContent = packageData.title;
                        document.getElementById('modal-package-image').src = packageData.image;
                        document.getElementById('modal-package-location').textContent = packageData.location;
                        document.getElementById('modal-package-duration').textContent = packageData.duration;
                        document.getElementById('modal-package-description').textContent = packageData.description;
                        document.getElementById('modal-base-price').textContent = packageData.price;
                        
                        // Show modal
                        packageDetailsModal.classList.add('active');
                    });
                });
            }
            
            // Tab functionality in package details modal
            const tabTitles = document.querySelectorAll('.tab-title');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabTitles.forEach(tab => {
                tab.addEventListener('click', function() {
                    const tabName = this.getAttribute('data-tab');
                    
                    // Update active state
                    tabTitles.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Show selected tab content
                    tabContents.forEach(content => {
                        content.classList.remove('active');
                    });
                    document.getElementById(`${tabName}-tab`).classList.add('active');
                });
            });
            
            // Close package details modal
            if (modalCloseBtns) {
                modalCloseBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        packageDetailsModal.classList.remove('active');
                    });
                });
            }
            
            // Book from package details modal
            if (modalBookBtn) {
                modalBookBtn.addEventListener('click', () => {
                    packageDetailsModal.classList.remove('active');
                    bookingModal.classList.add('active');
                });
            }
            
            // Package booking functionality
            if (packageBookBtns.length > 0) {
                packageBookBtns.forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const packageId = this.getAttribute('data-package-id');
                        
                        // Update booking form with package details
                        document.getElementById('package_id').value = packageId;
                        
                        // Show booking modal
                        bookingModal.classList.add('active');
                    });
                });
            }
            
            // Mock package data
            function getPackageDetails(packageId) {
                const packages = {
                    '1': {
                        title: 'Paris & Amsterdam (7 days)',
                        location: 'France & Netherlands',
                        duration: '7 Days / 6 Nights',
                        price: '₹1,49,999 per person',
                        description: 'Experience the romance of Paris and the charm of Amsterdam with this comprehensive package including luxury accommodation, guided tours, and cultural experiences.',
                        image: 'https://i.pinimg.com/474x/d6/35/cd/d635cd00e7c0ff8d867846dc53fea4b4.jpg'
                    },
                    '2': {
                        title: 'Rome & Florence (8 days)',
                        location: 'Italy',
                        duration: '8 Days / 7 Nights',
                        price: '₹1,45,999 per person',
                        description: 'Discover the art, history, and culture of Italy with this comprehensive package including Rome and Florence.',
                        image: 'https://i.pinimg.com/736x/5b/3b/6e/5b3b6e3f2d9720783397bbb64f5bacc3.jpg'
                    },
                    '3': {
                        title: 'Swiss Alps Adventure (6 days)',
                        location: 'Switzerland',
                        duration: '6 Days / 5 Nights',
                        price: '₹1,65,999 per person',
                        description: 'Experience the breathtaking beauty of the Swiss Alps with this adventure-packed itinerary.',
                        image: 'https://i.pinimg.com/736x/3d/1e/2f/3d1e2f0e7d0a0e5b5e5b5e5b5e5b5e5b.jpg'
                    },
                    '4': {
                        title: 'Japan Essentials (9 days)',
                        location: 'Japan',
                        duration: '9 Days / 8 Nights',
                        price: '₹1,85,999 per person',
                        description: 'Immerse yourself in Japanese culture with visits to Tokyo, Kyoto, and Osaka.',
                        image: 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
                    },
                    '5': {
                        title: 'Thailand Highlights (7 days)',
                        location: 'Thailand',
                        duration: '7 Days / 6 Nights',
                        price: '₹89,999 per person',
                        description: 'Experience the vibrant culture, beautiful beaches, and delicious food of Thailand.',
                        image: 'https://images.unsplash.com/photo-1506665531195-3566af98b107?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
                    },
                    '6': {
                        title: 'New York City Explorer (5 days)',
                        location: 'USA',
                        duration: '5 Days / 4 Nights',
                        price: '₹1,25,999 per person',
                        description: 'Experience the energy and excitement of New York City with this comprehensive city tour.',
                        image: 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
                    },
                    '7': {
                        title: 'Canadian Rockies (7 days)',
                        location: 'Canada',
                        duration: '7 Days / 6 Nights',
                        price: '₹1,35,999 per person',
                        description: 'Discover the stunning landscapes of the Canadian Rockies with this adventure package.',
                        image: 'https://images.unsplash.com/photo-1519181245277-cffeb31da2e3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
                    },
                    '8': {
                        title: 'Peru & Machu Picchu (8 days)',
                        location: 'Peru',
                        duration: '8 Days / 7 Nights',
                        price: '₹1,45,999 per person',
                        description: 'Explore the ancient ruins of Machu Picchu and the cultural highlights of Peru.',
                        image: 'https://images.unsplash.com/photo-1526392060635-9d6019884377?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
                    },
                    '9': {
                        title: 'South African Safari (6 days)',
                        location: 'South Africa',
                        duration: '6 Days / 5 Nights',
                        price: '₹1,75,999 per person',
                        description: 'Experience the thrill of a South African safari with this luxury adventure package.',
                        image: 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
                    },
                    '10': {
                        title: 'Australia Highlights (12 days)',
                        location: 'Australia',
                        duration: '12 Days / 11 Nights',
                        price: '₹2,45,999 per person',
                        description: 'Experience the best of Australia, from Sydney and Melbourne to the Great Barrier Reef.',
                        image: 'https://images.unsplash.com/photo-1506973035872-a4ec16b8e8d9?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
                    },
                    '11': {
                        title: 'Golden Triangle (6 days)',
                        location: 'India',
                        duration: '6 Days / 5 Nights',
                        price: '₹65,999 per person',
                        description: 'Explore India\'s iconic Golden Triangle: Delhi, Agra, and Jaipur with cultural experiences.',
                        image: 'https://images.unsplash.com/photo-1524492412937-b28074a5d7da?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
                    },
                    '12': {
                        title: 'Brazil Adventure (9 days)',
                        location: 'Brazil',
                        duration: '9 Days / 8 Nights',
                        price: '₹1,55,999 per person',
                        description: 'Experience Rio de Janeiro, the Amazon rainforest, and the stunning beaches of Brazil.',
                        image: 'https://images.unsplash.com/photo-1483729558449-99ef09a8c325?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
                    },
                    '13': {
                        title: 'Argentina Explorer (7 days)',
                        location: 'Argentina',
                        duration: '7 Days / 6 Nights',
                        price: '₹1,35,999 per person',
                        description: 'Discover Buenos Aires, Patagonia, and experience authentic Argentine tango.',
                        image: 'https://images.unsplash.com/photo-1589909202802-8f4aadce1849?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
                    },
                    '14': {
                        title: 'Moroccan Magic (8 days)',
                        location: 'Morocco',
                        duration: '8 Days / 7 Nights',
                        price: '₹1,25,999 per person',
                        description: 'Explore the vibrant markets, ancient medinas, and Sahara Desert in Morocco.',
                        image: 'https://images.unsplash.com/photo-1489493887464-892be6d1daae?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
                    },
                    '15': {
                        title: 'Egyptian Wonders (7 days)',
                        location: 'Egypt',
                        duration: '7 Days / 6 Nights',
                        price: '₹1,15,999 per person',
                        description: 'Discover the ancient pyramids, cruise the Nile, and explore Cairo\'s treasures.',
                        image: 'https://images.unsplash.com/photo-1503177119275-0aa32b3a9368?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
                    },
                    '16': {
                        title: 'New Zealand Adventure (10 days)',
                        location: 'New Zealand',
                        duration: '10 Days / 9 Nights',
                        price: '₹2,15,999 per person',
                        description: 'Experience breathtaking landscapes, thrilling adventures, and Maori culture.',
                        image: 'https://images.unsplash.com/photo-1469521669194-babb45599def?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
                    },
                    '17': {
                        title: 'Fiji Island Paradise (8 days)',
                        location: 'Fiji',
                        duration: '8 Days / 7 Nights',
                        price: '₹1,85,999 per person',
                        description: 'Relax on pristine beaches, snorkel in crystal clear waters, and enjoy Fijian hospitality.',
                        image: 'https://images.unsplash.com/photo-1542323228-002ac256e7b8?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
                    }
                };
                
                return packages[packageId];
            }
            
            // Apply filters button functionality
            const applyFiltersBtn = document.getElementById('apply-filters');
            const destinationFilter = document.getElementById('destination-filter');
            const durationFilter = document.getElementById('duration-filter');
            const priceFilter = document.getElementById('price-filter');
            
            if (applyFiltersBtn) {
                applyFiltersBtn.addEventListener('click', function() {
                    // Get selected filter values
                    const selectedDestination = destinationFilter.value;
                    const selectedDuration = durationFilter.value;
                    const selectedPrice = priceFilter.value;
                    
                    // Clear any active continent filters
                    document.querySelectorAll('.continent-link').forEach(link => {
                        if (link.getAttribute('data-continent') === 'all') {
                            link.classList.add('active');
                        } else {
                            link.classList.remove('active');
                        }
                    });
                    
                    // Get all package cards
                    const packageCards = document.querySelectorAll('.package-card');
                    
                    // Filter packages
                    packageCards.forEach(card => {
                        // Default to showing the card
                        let shouldShow = true;
                        
                        // Apply destination filter
                        if (selectedDestination !== 'all') {
                            const cardContinent = card.getAttribute('data-continent');
                            const cardDestination = card.getAttribute('data-destination');
                            if (cardContinent !== selectedDestination && cardDestination !== selectedDestination) {
                                shouldShow = false;
                            }
                        }
                        
                        // Apply duration filter
                        if (shouldShow && selectedDuration !== 'all') {
                            const cardDuration = parseInt(card.getAttribute('data-duration').split('-')[0]);
                            
                            switch(selectedDuration) {
                                case '3-5':
                                    if (cardDuration < 3 || cardDuration > 5) shouldShow = false;
                                    break;
                                case '6-10':
                                    if (cardDuration < 6 || cardDuration > 10) shouldShow = false;
                                    break;
                                case '11-15':
                                    if (cardDuration < 11 || cardDuration > 15) shouldShow = false;
                                    break;
                                case '15+':
                                    if (cardDuration <= 15) shouldShow = false;
                                    break;
                            }
                        }
                        
                        // Apply price filter
                        if (shouldShow && selectedPrice !== 'all') {
                            const cardPriceText = card.querySelector('.price').textContent;
                            const cardPrice = parseInt(cardPriceText.replace(/[^\d]/g, ''));
                            
                            switch(selectedPrice) {
                                case 'budget':
                                    if (cardPrice >= 50000) shouldShow = false;
                                    break;
                                case 'mid-range':
                                    if (cardPrice < 50000 || cardPrice > 100000) shouldShow = false;
                                    break;
                                case 'luxury':
                                    if (cardPrice <= 100000) shouldShow = false;
                                    break;
                            }
                        }
                        
                        // Show or hide the card
                        card.style.display = shouldShow ? 'flex' : 'none';
                    });
                    
                    // Scroll to packages section
                    document.querySelector('.packages-section').scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            }
            
            // Reset filters button functionality
            const resetFiltersBtn = document.getElementById('reset-filters');
            if (resetFiltersBtn) {
                resetFiltersBtn.addEventListener('click', function() {
                    // Reset all filter dropdowns
                    if (destinationFilter) destinationFilter.value = 'all';
                    if (durationFilter) durationFilter.value = 'all';
                    if (priceFilter) priceFilter.value = 'all';
                    
                    // Show all packages
                    document.querySelectorAll('.package-card').forEach(card => {
                        card.style.display = 'flex';
                    });
                    
                    // Set active class to "All" in continent navigation
                    document.querySelectorAll('.continent-link').forEach(link => {
                        if (link.getAttribute('data-continent') === 'all') {
                            link.classList.add('active');
                        } else {
                            link.classList.remove('active');
                        }
                    });
                    
                    // Scroll to packages section
                    document.querySelector('.packages-section').scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            }
        });
    </script>
</body>
</html> 