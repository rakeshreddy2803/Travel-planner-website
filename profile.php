<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Tourly</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #2F855A;    /* Forest Green */
            --secondary-color: #38A169;  /* Emerald Green */
            --accent-color: #48BB78;     /* Bright Green */
            --neutral-color: #F0FFF4;    /* Light Green */
            --bg-dark: #1A202C;          /* Deep Black */
            --bg-darker: #2D3748;        /* Darker Black */
            --text-light: #FFFFFF;
            --text-lighter: #FFFFFF;
            --text-muted: #38A169;
            --card-bg: rgba(26, 32, 44, 0.95);
            --gradient: linear-gradient(135deg, #2F855A 0%, #48BB78 100%);
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
            font-family: 'Poppins', 'Segoe UI', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-light);
            line-height: 1.7;
            overflow-x: hidden;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Moving Text Banner */
        .moving-text {
            background: var(--gradient);
            color: var(--text-light);
            padding: 12px 0;
            text-align: center;
            font-weight: 500;
            font-size: 14px;
        }

        .moving-text span {
            display: inline-block;
        }

        /* Header Styles */
        header {
            background-color: var(--bg-dark);
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 0.5rem 0;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-lighter);
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo i {
            margin-right: 0.5rem;
            color: var(--primary-color);
            animation: planeEntrance 1.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            opacity: 0;
        }

        .logo span {
            color: var(--primary-color);
            margin-left: 0.3rem;
        }

        nav {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        nav ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 2rem;
        }

        nav ul li a {
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            position: relative;
            padding: 0.5rem 0;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        nav ul li a i {
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        nav ul li a:hover i {
            transform: translateY(-2px);
        }

        nav ul li a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            background: var(--gradient);
            bottom: 0;
            left: 0;
            transition: width 0.3s ease;
        }

        nav ul li a:hover::after {
            width: 100%;
        }

        /* Button Styles */
        .btn {
            padding: 0.5rem 1.2rem;
            font-size: 0.9rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
        }

        .btn-primary {
            background: var(--gradient);
            border: none;
            color: var(--text-light);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--text-light);
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: var(--text-light);
        }

        .auth-buttons {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-left: 2rem;
        }

        .auth-buttons .btn i {
            font-size: 1rem;
        }

        /* Profile Content Styles */
        .profile-container {
            margin-top: 100px;
            padding: 2rem;
            background: var(--card-bg);
            border-radius: 15px;
            box-shadow: var(--shadow);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(10px);
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .profile-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary-color);
        }

        .profile-info h1 {
            color: var(--text-lighter);
            margin-bottom: 0.5rem;
        }

        .profile-info p {
            color: var(--text-muted);
        }

        .profile-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .profile-section {
            margin-top: 2rem;
        }

        .profile-section h2 {
            color: var(--text-lighter);
            margin-bottom: 1rem;
            position: relative;
            padding-bottom: 10px;
        }

        .profile-section h2::after {
            content: '';
            position: absolute;
            width: 50px;
            height: 3px;
            background: var(--gradient);
            bottom: 0;
            left: 0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .info-item {
            background: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            border-radius: 10px;
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(5px);
        }

        .info-item label {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .info-item p {
            margin: 0.5rem 0;
            font-weight: 500;
            color: var(--text-lighter);
        }

        /* Footer Styles */
        footer {
            background: linear-gradient(to bottom, var(--bg-darker), var(--bg-dark));
            color: var(--text-light);
            padding: 80px 0 30px;
            position: relative;
            overflow: hidden;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--gradient);
            opacity: 0.05;
            z-index: 0;
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 50px;
        }

        .footer-col h3 {
            font-size: 18px;
            margin-bottom: 25px;
            color: var(--text-lighter);
            position: relative;
            padding-bottom: 10px;
        }

        .footer-col h3::after {
            content: '';
            position: absolute;
            width: 40px;
            height: 2px;
            background: var(--gradient);
            bottom: 0;
            left: 0;
        }

        .footer-col p {
            margin-bottom: 20px;
            color: var(--text-muted);
            font-size: 14px;
        }

        /* Footer Link Styles */
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
            position: relative;
            padding-left: 0;
            transition: all 0.3s ease;
        }

        .footer-links li::before {
            content: '→';
            position: absolute;
            left: -15px;
            opacity: 0;
            transition: all 0.3s ease;
            color: var(--primary-color);
            font-weight: bold;
        }

        .footer-links li:hover {
            padding-left: 15px;
        }

        .footer-links li:hover::before {
            left: 0;
            opacity: 1;
        }

        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 14px;
            display: inline-block;
            position: relative;
            padding-bottom: 2px;
        }

        .footer-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 1px;
            background: var(--gradient);
            bottom: 0;
            left: 0;
            transition: width 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .footer-links a:hover::after {
            width: 100%;
        }

        .social-links-footer {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links-footer a {
            width: 40px;
            height: 40px;
            background: var(--bg-dark);
            color: var(--primary-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .social-links-footer a:hover {
            background: var(--primary-color);
            color: var(--text-light);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-muted);
            font-size: 14px;
        }

        /* Logo Animations */
        @keyframes planeEntrance {
            0% {
                transform: translateX(-200px);
                opacity: 0;
            }
            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .header-container {
                padding: 0.5rem 1rem;
            }

            nav ul {
                gap: 1.5rem;
            }

            .auth-buttons {
                margin-left: 1.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 1rem;
            }

            nav ul {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }

            .auth-buttons {
                margin-left: 0;
                margin-top: 1rem;
            }
        }

        .preferences-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 1.5rem;
        }

        .preference-group {
            background: rgba(255, 255, 255, 0.05);
            padding: 1.5rem;
            border-radius: 10px;
            border: 1px solid var(--glass-border);
        }

        .preference-group h3 {
            color: var(--text-lighter);
            margin-bottom: 1.2rem;
            font-size: 1.2rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .preference-group h3::after {
            content: '';
            position: absolute;
            width: 40px;
            height: 2px;
            background: var(--gradient);
            bottom: 0;
            left: 0;
        }

        .preference-item {
            margin-bottom: 1.2rem;
            position: relative;
        }

        .preference-item label {
            display: block;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .preference-item:hover label {
            color: var(--primary-color);
        }

        .preference-item::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gradient);
            transition: width 0.3s ease;
        }

        .preference-item:hover::after {
            width: 100%;
        }

        .preference-select {
            width: 100%;
            padding: 0.8rem;
            background: rgba(26, 32, 44, 0.8);
            border: 1px solid var(--glass-border);
            border-radius: 5px;
            color: var(--text-light);
            font-size: 0.95rem;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2338A169' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 35px;
        }

        .preference-select:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(47, 133, 90, 0.3);
            transform: translateY(-2px);
        }

        .preference-select:hover {
            border-color: var(--secondary-color);
            background-color: rgba(26, 32, 44, 0.95);
        }

        .preference-select option {
            background-color: var(--bg-dark);
            color: var(--text-light);
            padding: 10px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            color: var(--text-light);
        }

        .checkbox-label input {
            margin-right: 10px;
            width: 18px;
            height: 18px;
            accent-color: var(--primary-color);
        }

        .preferences-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 1rem;
        }

        .documents-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .document-group {
            background: rgba(255, 255, 255, 0.05);
            padding: 1.5rem;
            border-radius: 10px;
            border: 1px solid var(--glass-border);
        }

        .document-group h3 {
            color: var(--text-lighter);
            margin-bottom: 1.2rem;
            font-size: 1.2rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .document-group h3::after {
            content: '';
            position: absolute;
            width: 40px;
            height: 2px;
            background: var(--gradient);
            bottom: 0;
            left: 0;
        }

        .document-upload {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .document-preview {
            width: 100%;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 5px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .document-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .document-actions {
            display: flex;
            gap: 1rem;
        }

        .document-info {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .document-status {
            margin-top: 0.5rem;
            font-style: italic;
        }

        .btn-danger {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .btn-danger:hover {
            background: rgba(220, 53, 69, 0.3);
        }
    </style>
</head>
<body>
    <!-- Moving Text Banner -->
    <div class="moving-text glass-effect">
        <span>✨ Exclusive Offer: Get 20% off on all international bookings this month! Use code TRAVEL20 at checkout. ✨</span>
    </div>

    <!-- Header -->
    <header>
        <div class="container header-container">
            <a href="finalproject.html" class="logo">
                <i class="fas fa-plane"></i><span>Tourly</span>
            </a>
            <nav>
                <ul>
                    <li><a href="finalproject.php">Home</a></li>
                    <li><a href="packages.php">Packages</a></li>
                    <li><a href="finalproject.php#services">Services</a></li>
                    <li><a href="finalproject.php#reviews">Reviews</a></li>
                    <li><a href="finalproject.php#contact">Contact</a></li>
                    <li ><a href="booking.php">My Bookings</a></li>
                    <li class="logged-in-only" style="display: none;"><a href="profile.php">My Profile</a></li>
 
                </ul>
            </nav>
            <div class="auth-buttons">
                <div class="logged-in-only" style="display: none;">
                    <span id="user-name" class="text-light me-3"></span>
                    <button class="btn btn-outline" onclick="logout()">Logout</button>
                </div>
            </div>
            <button class="mobile-nav-toggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Profile Content -->
    <div class="container">
        <div class="profile-container">
            <div class="profile-header">
                <img src="https://via.placeholder.com/150" alt="Profile Photo" class="profile-photo" id="profilePhoto">
                <div class="profile-info">
                    <h1 id="profileName">User Name</h1>
                    <p id="profileEmail">user@example.com</p>
                    <div class="profile-actions">
                        <button class="btn btn-primary" id="editProfileBtn">Edit Profile</button>
                        <button class="btn btn-outline" id="changePhotoBtn">Change Photo</button>
                    </div>
                </div>
            </div>

            <div class="profile-section">
                <h2>Personal Information</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <label>Full Name</label>
                        <p id="fullName">John Doe</p>
                    </div>
                    <div class="info-item">
                        <label>Email</label>
                        <p id="email">john.doe@example.com</p>
                    </div>
                    <div class="info-item">
                        <label>Mobile Number</label>
                        <p id="mobile">+1 234 567 8900</p>
                    </div>
                    <div class="info-item">
                        <label>Date of Birth</label>
                        <p id="dob">January 1, 1990</p>
                    </div>
                    <div class="info-item">
                        <label>Member Since</label>
                        <p id="memberSince">January 1, 2023</p>
                    </div>
                    <div class="info-item">
                        <label>Account Status</label>
                        <p id="accountStatus">Active</p>
                    </div>
                </div>
            </div>

            <div class="profile-section">
                <h2>Preferences & Settings</h2>
                <div class="preferences-container">
                    <div class="preference-group">
                        <h3>Travel Preferences</h3>
                        <div class="preference-item">
                            <label>Preferred Currency</label>
                            <select id="preferredCurrency" class="preference-select">
                                <option value="USD">USD ($)</option>
                                <option value="EUR">EUR (€)</option>
                                <option value="GBP">GBP (£)</option>
                                <option value="INR">INR (₹)</option>
                            </select>
                        </div>
                        <div class="preference-item">
                            <label>Preferred Language</label>
                            <select id="preferredLanguage" class="preference-select">
                                <option value="en">English</option>
                                <option value="es">Spanish</option>
                                <option value="fr">French</option>
                                <option value="de">German</option>
                                <option value="hi">Hindi</option>
                            </select>
                        </div>
                        <div class="preference-item">
                            <label>Travel Style</label>
                            <select id="travelStyle" class="preference-select">
                                <option value="adventure">Adventure</option>
                                <option value="luxury">Luxury</option>
                                <option value="budget">Budget</option>
                                <option value="family">Family</option>
                                <option value="solo">Solo</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="preference-group">
                        <h3>Notification Settings</h3>
                        <div class="preference-item">
                            <label class="checkbox-label">
                                <input type="checkbox" id="emailNotifications" checked>
                                <span>Email Notifications</span>
                            </label>
                        </div>
                        <div class="preference-item">
                            <label class="checkbox-label">
                                <input type="checkbox" id="smsNotifications">
                                <span>SMS Notifications</span>
                            </label>
                        </div>
                        <div class="preference-item">
                            <label class="checkbox-label">
                                <input type="checkbox" id="promotionalEmails" checked>
                                <span>Promotional Emails</span>
                            </label>
                        </div>
                        <div class="preference-item">
                            <label class="checkbox-label">
                                <input type="checkbox" id="bookingReminders" checked>
                                <span>Booking Reminders</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="preferences-actions">
                    <button class="btn btn-primary" id="savePreferencesBtn">Save Preferences</button>
                </div>
            </div>

            <div class="profile-section">
                <h2>Travel Documents</h2>
                <div class="documents-container">
                    <div class="document-group">
                        <h3>Passport</h3>
                        <div class="document-upload">
                            <div class="document-preview" id="passportPreview">
                                <img src="https://via.placeholder.com/150x100?text=No+Passport" alt="Passport Preview" id="passportImage">
                            </div>
                            <div class="document-actions">
                                <label for="passportUpload" class="btn btn-secondary">Upload Passport</label>
                                <input type="file" id="passportUpload" accept="image/*,.pdf" style="display: none;">
                                <button class="btn btn-danger" id="removePassportBtn">Remove</button>
                            </div>
                            <div class="document-info">
                                <p>Upload your passport photo page or scan</p>
                                <p class="document-status" id="passportStatus">No document uploaded</p>
                            </div>
                        </div>
                    </div>

                    <div class="document-group">
                        <h3>Aadhaar Card</h3>
                        <div class="document-upload">
                            <div class="document-preview" id="aadhaarPreview">
                                <img src="https://via.placeholder.com/150x100?text=No+Aadhaar" alt="Aadhaar Preview" id="aadhaarImage">
                            </div>
                            <div class="document-actions">
                                <label for="aadhaarUpload" class="btn btn-secondary">Upload Aadhaar</label>
                                <input type="file" id="aadhaarUpload" accept="image/*,.pdf" style="display: none;">
                                <button class="btn btn-danger" id="removeAadhaarBtn">Remove</button>
                            </div>
                            <div class="document-info">
                                <p>Upload your Aadhaar card front and back</p>
                                <p class="document-status" id="aadhaarStatus">No document uploaded</p>
                            </div>
                        </div>
                    </div>

                    <div class="document-group">
                        <h3>Travel Insurance</h3>
                        <div class="document-upload">
                            <div class="document-preview" id="insurancePreview">
                                <img src="https://via.placeholder.com/150x100?text=No+Insurance" alt="Insurance Preview" id="insuranceImage">
                            </div>
                            <div class="document-actions">
                                <label for="insuranceUpload" class="btn btn-secondary">Upload Insurance</label>
                                <input type="file" id="insuranceUpload" accept="image/*,.pdf" style="display: none;">
                                <button class="btn btn-danger" id="removeInsuranceBtn">Remove</button>
                            </div>
                            <div class="document-info">
                                <p>Upload your travel insurance policy document</p>
                                <p class="document-status" id="insuranceStatus">No document uploaded</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-col">
                    <div class="logo" style="color: white; margin-bottom: 20px;">
                        <i class="fas fa-plane"></i><span>Tourly</span>
                    </div>
                    <p>Making travel planning effortless and enjoyable since 2023. Discover your next adventure with us.</p>
                    <div class="social-links-footer">
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
                        <li><a href="booking.php">My Bookings</a></li>
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
                <p>&copy; 2025 Tourly Travel Company. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if user is logged in
            const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';
            const currentUser = isLoggedIn ? JSON.parse(localStorage.getItem('currentUser')) : null;
            
            // Update UI based on login status
            const loginBtn = document.getElementById('login-btn');
            const loggedInElements = document.querySelectorAll('.logged-in-only');
            const userNameDisplay = document.getElementById('user-name');
            const logoutBtn = document.getElementById('logout-btn');
            const profileName = document.getElementById('profileName');
            const profileEmail = document.getElementById('profileEmail');
            const fullName = document.getElementById('fullName');
            const email = document.getElementById('email');
            const mobile = document.getElementById('mobile');
            const dob = document.getElementById('dob');
            
            if (isLoggedIn && currentUser) {
                loginBtn.style.display = 'none';
                loggedInElements.forEach(el => el.style.display = 'block');
                userNameDisplay.textContent = currentUser.name;
                
                // Update profile information
                profileName.textContent = currentUser.name;
                profileEmail.textContent = currentUser.email;
                fullName.textContent = currentUser.name;
                email.textContent = currentUser.email;
                mobile.textContent = currentUser.mobile || 'Not provided';
                dob.textContent = currentUser.dob ? new Date(currentUser.dob).toLocaleDateString() : 'Not provided';
            }

            // Mobile navigation toggle
            const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
            const navLinks = document.querySelector('nav ul');

            mobileNavToggle.addEventListener('click', function() {
                navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!event.target.closest('nav') && !event.target.closest('.mobile-nav-toggle')) {
                    navLinks.style.display = 'none';
                }
            });

            // Logout functionality
            logoutBtn.addEventListener('click', function(e) {
                e.preventDefault();
                localStorage.removeItem('isLoggedIn');
                localStorage.removeItem('currentUser');
                window.location.href = 'finalproject.html';
            });

            // Profile photo upload
            const changePhotoBtn = document.getElementById('changePhotoBtn');
            const profilePhoto = document.getElementById('profilePhoto');

            changePhotoBtn.addEventListener('click', function() {
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = 'image/*';
                input.onchange = function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            profilePhoto.src = e.target.result;
                            localStorage.setItem('profilePhoto', e.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                };
                input.click();
            });

            // Load saved profile photo
            const savedPhoto = localStorage.getItem('profilePhoto');
            if (savedPhoto) {
                profilePhoto.src = savedPhoto;
            }

            // Load user preferences
            function loadUserPreferences() {
                const userPreferences = JSON.parse(localStorage.getItem('userPreferences')) || {
                    preferredCurrency: 'USD',
                    preferredLanguage: 'en',
                    travelStyle: 'adventure',
                    emailNotifications: true,
                    smsNotifications: false,
                    promotionalEmails: true,
                    bookingReminders: true
                };
                
                // Set form values
                document.getElementById('preferredCurrency').value = userPreferences.preferredCurrency;
                document.getElementById('preferredLanguage').value = userPreferences.preferredLanguage;
                document.getElementById('travelStyle').value = userPreferences.travelStyle;
                document.getElementById('emailNotifications').checked = userPreferences.emailNotifications;
                document.getElementById('smsNotifications').checked = userPreferences.smsNotifications;
                document.getElementById('promotionalEmails').checked = userPreferences.promotionalEmails;
                document.getElementById('bookingReminders').checked = userPreferences.bookingReminders;

                // Add animation to dropdowns when loaded
                const dropdowns = document.querySelectorAll('.preference-select');
                dropdowns.forEach((dropdown, index) => {
                    setTimeout(() => {
                        dropdown.style.opacity = '0';
                        dropdown.style.transform = 'translateY(10px)';
                        
                        setTimeout(() => {
                            dropdown.style.transition = 'all 0.3s ease';
                            dropdown.style.opacity = '1';
                            dropdown.style.transform = 'translateY(0)';
                        }, 50);
                    }, index * 100);
                });
            }

            // Save user preferences
            document.getElementById('savePreferencesBtn').addEventListener('click', function() {
                const userPreferences = {
                    preferredCurrency: document.getElementById('preferredCurrency').value,
                    preferredLanguage: document.getElementById('preferredLanguage').value,
                    travelStyle: document.getElementById('travelStyle').value,
                    emailNotifications: document.getElementById('emailNotifications').checked,
                    smsNotifications: document.getElementById('smsNotifications').checked,
                    promotionalEmails: document.getElementById('promotionalEmails').checked,
                    bookingReminders: document.getElementById('bookingReminders').checked
                };
                
                localStorage.setItem('userPreferences', JSON.stringify(userPreferences));
                
                // Show success animation
                const saveBtn = this;
                const originalText = saveBtn.innerHTML;
                saveBtn.innerHTML = '<i class="fas fa-check"></i> Saved!';
                saveBtn.style.backgroundColor = 'var(--secondary-color)';
                
                setTimeout(() => {
                    saveBtn.innerHTML = originalText;
                    saveBtn.style.backgroundColor = '';
                }, 2000);
            });

            // Add change event listeners to dropdowns for visual feedback
            const dropdowns = document.querySelectorAll('.preference-select');
            dropdowns.forEach(dropdown => {
                dropdown.addEventListener('change', function() {
                    // Add a subtle animation when value changes
                    this.style.transform = 'scale(1.02)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 200);
                    
                    // Show a small indicator that the value has changed
                    const indicator = document.createElement('span');
                    indicator.className = 'change-indicator';
                    indicator.innerHTML = '<i class="fas fa-check"></i>';
                    indicator.style.position = 'absolute';
                    indicator.style.right = '40px';
                    indicator.style.top = '50%';
                    indicator.style.transform = 'translateY(-50%)';
                    indicator.style.color = 'var(--primary-color)';
                    indicator.style.opacity = '0';
                    indicator.style.transition = 'opacity 0.3s ease';
                    
                    this.parentNode.style.position = 'relative';
                    this.parentNode.appendChild(indicator);
                    
                    setTimeout(() => {
                        indicator.style.opacity = '1';
                    }, 50);
                    
                    setTimeout(() => {
                        indicator.style.opacity = '0';
                        setTimeout(() => {
                            if (this.parentNode.contains(indicator)) {
                                this.parentNode.removeChild(indicator);
                            }
                        }, 300);
                    }, 1500);
                });
            });

            // Edit profile functionality
            const editProfileBtn = document.getElementById('editProfileBtn');
            editProfileBtn.addEventListener('click', function() {
                // Add your edit profile logic here
                alert('Edit profile functionality coming soon!');
            });

            // Document upload functionality
            function setupDocumentUpload(inputId, previewId, imageId, statusId, removeBtnId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);
                const image = document.getElementById(imageId);
                const status = document.getElementById(statusId);
                const removeBtn = document.getElementById(removeBtnId);

                input.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                image.src = e.target.result;
                                status.textContent = 'Document uploaded: ' + file.name;
                                localStorage.setItem(inputId, e.target.result);
                            };
                            reader.readAsDataURL(file);
                        } else if (file.type === 'application/pdf') {
                            image.src = 'https://via.placeholder.com/150x100?text=PDF+Document';
                            status.textContent = 'PDF uploaded: ' + file.name;
                            localStorage.setItem(inputId, 'pdf');
                        }
                    }
                });

                removeBtn.addEventListener('click', function() {
                    image.src = `https://via.placeholder.com/150x100?text=No+${inputId.replace('Upload', '')}`;
                    status.textContent = 'No document uploaded';
                    localStorage.removeItem(inputId);
                    input.value = '';
                });

                // Load saved document
                const savedDoc = localStorage.getItem(inputId);
                if (savedDoc) {
                    if (savedDoc === 'pdf') {
                        image.src = 'https://via.placeholder.com/150x100?text=PDF+Document';
                        status.textContent = 'PDF document uploaded';
                    } else {
                        image.src = savedDoc;
                        status.textContent = 'Document uploaded';
                    }
                }
            }

            // Setup document uploads
            setupDocumentUpload('passportUpload', 'passportPreview', 'passportImage', 'passportStatus', 'removePassportBtn');
            setupDocumentUpload('aadhaarUpload', 'aadhaarPreview', 'aadhaarImage', 'aadhaarStatus', 'removeAadhaarBtn');
            setupDocumentUpload('insuranceUpload', 'insurancePreview', 'insuranceImage', 'insuranceStatus', 'removeInsuranceBtn');
        });
        // In profile.html
function loadProfileData() {
    const user = JSON.parse(localStorage.getItem('user'));
    if (!user) {
        window.location.href = 'finalproject.html';
        return;
    }
    
    document.getElementById('profileName').textContent = user.name;
    document.getElementById('profileEmail').textContent = user.email;
    document.getElementById('fullName').textContent = user.name;
    document.getElementById('email').textContent = user.email;
    document.getElementById('memberSince').textContent = new Date(user.createdAt || Date.now()).toLocaleDateString();
    
    // Load saved preferences
    const preferences = user.preferences || {
        currency: 'INR',
        language: 'en',
        notifications: true
    };
    
    document.getElementById('preferredCurrency').value = preferences.currency;
    document.getElementById('preferredLanguage').value = preferences.language;
    document.getElementById('emailNotifications').checked = preferences.notifications;
}

document.addEventListener('DOMContentLoaded', loadProfileData);
// In all pages with login modal
document.querySelector('.login-btn').addEventListener('click', function() {
    document.getElementById('login-modal').style.display = 'flex';
});

// Login form submission
document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;
    
    if (login(email, password)) {
        document.getElementById('login-modal').style.display = 'none';
        window.location.reload();
    } else {
        alert('Invalid email or password');
    }
});

// Signup form submission
document.getElementById('signup-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const name = document.getElementById('signup-name').value;
    const email = document.getElementById('signup-email').value;
    const password = document.getElementById('signup-password').value;
    const confirmPassword = document.getElementById('signup-confirm-password').value;
    
    if (password !== confirmPassword) {
        alert('Passwords do not match');
        return;
    }
    
    if (signup(name, email, password)) {
        document.getElementById('login-modal').style.display = 'none';
        window.location.reload();
    } else {
        alert('Email already registered');
    }
});
    </script>
</body>
</html>