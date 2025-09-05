<?php

    session_start();

// Generate new token only if it doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourly - Modern Travel Planner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <meta name="google-signin-client_id" content="YOUR_GOOGLE_CLIENT_ID.apps.googleusercontent.com">
    <meta property="fb:app_id" content="YOUR_FACEBOOK_APP_ID">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@your_twitter_handle">
    <script src="js/social-login.js"></script>
    <script src="../js/auth.js"></script>
</head>
<body>

  

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
                <li class="logged-in-only" style="display: none;"><a href="booking.php">My Bookings</a></li>
                <li class="logged-in-only" style="display: none;"><a href="profile.php">My Profile</a></li>
            </ul>
        </nav>
        <div class="auth-buttons">
            <button class="btn btn-outline login-btn">Login</button>
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

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="hero-content">
                <h1>Discover Your Next Adventure</h1>
                <p>Plan your perfect trip with our all-in-one travel platform. Find the best deals on flights, hotels, and experiences tailored just for you.</p>
                <div class="btn-group">
                    <a href="packages.php" class="btn">Explore Destinations</a>
                    <a href="#services" class="btn btn-outline">How It Works</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <div class="container">
            <div class="section-title">
                <h2>Our Premium Services</h2>
                <p class="section-text">We take care of everything so you can focus on making memories</p>
            </div>
            
            <div class="services-grid">
                <!-- Service 1 -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-hotel"></i>
                    </div>
                    <h3>Luxury Stays</h3>
                    <p>Curated selection of boutique hotels and resorts with exclusive member benefits starting from ₹5,000 per night.</p>
                </div>
                
                <!-- Service 2 -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-plane-departure"></i>
                    </div>
                    <h3>Flight Deals</h3>
                    <p>Best price guarantee on flights with flexible booking options from ₹3,000 onwards.</p>
                </div>
                
                <!-- Service 3 -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-route"></i>
                    </div>
                    <h3>Tailored Itineraries</h3>
                    <p>Personalized travel plans designed by our expert trip planners starting at ₹10,000.</p>
                </div>
                
                <!-- Service 4 -->
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                    <h3>VIP Concierge</h3>
                    <p>24/7 support and exclusive access to local experiences from ₹2,500 per day.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    <section class="reviews-section" id="reviews">
        <div class="container">
            <div class="section-title">
                <h2>Traveler Experiences</h2>
                <p class="section-text">See what our customers have to say about their journeys</p>
            </div>
            <div class="reviews-container">
                <div class="review">
                    <div class="stars">★★★★★</div>
                    <p>"The itinerary was perfectly planned. Every detail was taken care of!"</p>
                    <h4>Aswin</h4>
                    <span>Tamil Nadu,India</span>
                </div>

                <div class="review">
                    <div class="stars">★★★★★</div>
                    <p>"Best travel service I've ever used. Will definitely book again."</p>
                    <h4>Asrith</h4>
                    <span>hyderabad,India</span>
                </div>

                <div class="review">
                    <div class="stars">★★★★☆</div>
                    <p>"Amazing hotels and transportation. Made our anniversary special."</p>
                    <h4>Sanjeev</h4>
                    <span>Banglore,India</span>
                </div>

                <div class="review">
                    <div class="stars">★★★★★</div>
                    <p>"The local guides were incredibly knowledgeable. Highly recommend!"</p>
                    <h4>Rakesh</h4>
                    <span>Hyderabad,India</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <div class="container">
            <div class="section-title">
                <h2>Get In Touch</h2>
                <p class="section-text">Our travel experts are ready to help you plan your dream vacation</p>
            </div>
            
            <div class="contact-container">
                <div class="contact-info">
                    <h3>Contact Information</h3>
                    
                    <div class="contact-details">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-text">
                                <h4>Our Address</h4>
                                <p>SRM University<br>Mangalagiri, Ap 52005</p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="contact-text">
                                <h4>Call Us</h4>
                                <p><a href="tel:+9118005551234">+91 6309170777</a></p>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-text">
                                <h4>Email Us</h4>
                                <p><a href="mailto:hello@tourly.com">hello@tourly.com</a></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="contact-form">
                    <form id="contactForm" method="POST" action="submit_form.php">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input type="text" id="name" name="name" required maxlength="100">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required maxlength="100">
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" required maxlength="200">
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Your Message</label>
                            <textarea id="message" name="message" required></textarea>
                        </div>
                        
                        <button type="submit">Submit</button>
                    </form>
                </div>
<div id="formResponse"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Modal -->
    <div class="modal" id="login-modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2 class="modal-title">Welcome Back</h2>
            
            <!-- Login Form -->
            <form id="login-form">
                <div class="form-group">
                    <label for="login-email">Email Address</label>
                    <input type="email" id="login-email" required>
                </div>
                
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" required>
                </div>
                
                <button type="submit" class="btn">Login</button>
                
                <div class="form-footer">
                    <p><a href="#" class="switch-to-signup">Don't have an account? Sign up</a></p>
                </div>
            </form>

            <!-- Sign Up Form -->
            <form id="signup-form" style="display: none;">
                <div class="form-group">
                    <label for="signup-name">Full Name</label>
                    <input type="text" id="signup-name" required>
                </div>
                
                <div class="form-group">
                    <label for="signup-email">Email Address</label>
                    <input type="email" id="signup-email" required>
                </div>
                
                <div class="form-group">
                    <label for="signup-password">Password</label>
                    <input type="password" id="signup-password" required>
                </div>
                
                <div class="form-group">
                    <label for="signup-confirm-password">Confirm Password</label>
                    <input type="password" id="signup-confirm-password" required>
                </div>
                
                <button type="submit" class="btn">Sign Up</button>
                
                <div class="form-footer">
                    <p><a href="#" class="switch-to-login">Already have an account? Login</a></p>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-container">
                <div class="footer-col">
                    <div class="logo">
                    <img src="https://media-hosting.imagekit.io/99036e7481b34910/Black%20and%20Orange%20Simple%20Travel%20Agency%20Logo%20(1).png?Expires=1840455992&Key-Pair-Id=K2ZIVPTIP2VGHC&Signature=gFN-XfJiVHziV7me6uIpPGFE~Zgyf-~WI7w-zWsNNKbEXLIEMuZug2SdUpBrCl1jj7SRTgbFLH7jq8w4lVHb8hKWkL0gL~m9hjScRQQHL8twXsFo93rqCNOIzHmu9FI4wF5~05lgosUuerBLDkhMGlZngI1uXBLj1bewW7FQX2TwC2ho9Vp0qM8scCR6fTnO8O67gL-MaPPNh6pVs4tmjvq4TlXgonykD~gAdn5I-b-x2f5w1By1GFtbFQy3MddqpHU7dGfQ6LH-DYPfCMkoT835lmZEO3HUSwAmrJTlCFmmsYmFRTy7y1Skq~IeZaMJhIVKeqhZMaql~rIg0PjiuA__ " alt="Travel Agency Logo" width="100" height="100">

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
                        <li><a href="booking.php">My Bookings</a></li>
                        <li><a href="profile.html">My Profile</a></li>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all necessary elements
            const loginForm = document.getElementById('login-form');
            const signupForm = document.getElementById('signup-form');
            const loginBtn = document.querySelector('.login-btn');
            const modal = document.getElementById('login-modal');
            const closeBtn = document.querySelector('.close-modal');
            const switchToSignup = document.querySelector('.switch-to-signup');
            const switchToLogin = document.querySelector('.switch-to-login');
            const modalTitle = document.querySelector('.modal-title');
            const loggedInElements = document.querySelectorAll('.logged-in-only');
            
            // Check if user is logged in on page load
            const user = JSON.parse(localStorage.getItem('user'));
            updateUI(user);
            
            // Login form submission
            if (loginForm) {
                loginForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const email = document.getElementById('login-email').value;
                    const password = document.getElementById('login-password').value;
                    
                    try {
                        const response = await fetch('db_login.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ email, password })
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            // Store user data in localStorage
                            localStorage.setItem('user', JSON.stringify(data.user));
                            updateUI(data.user);
                            
                            // Close modal
                            if (modal) {
                                modal.style.display = 'none';
                            }
                            
                            // Show success message
                            alert('Login successful!');
                        } else {
                            alert(data.message || 'Login failed. Please try again.');
                        }
                    } catch (error) {
                        console.error('Login error:', error);
                        alert('An error occurred during login. Please try again.');
                    }
                });
            }
            
            // Signup form submission
            if (signupForm) {
                signupForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    const name = document.getElementById('signup-name').value;
                    const email = document.getElementById('signup-email').value;
                    const password = document.getElementById('signup-password').value;
                    const confirmPassword = document.getElementById('signup-confirm-password').value;
                    
                    // Basic validation
                    if (password !== confirmPassword) {
                        alert('Passwords do not match!');
                        return;
                    }
                    
                    if (password.length < 8) {
                        alert('Password must be at least 8 characters long!');
                        return;
                    }
                    
                    try {
                        const response = await fetch('db_signup.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ 
                                name, 
                                email, 
                                password 
                            })
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            // Store user data in localStorage
                            localStorage.setItem('user', JSON.stringify(data.user));
                            updateUI(data.user);
                            
                            // Close modal
                            if (modal) {
                                modal.style.display = 'none';
                            }
                            
                            // Show success message
                            alert('Signup successful! You are now logged in.');
                        } else {
                            console.error('Signup error details:', data);
                            alert(`Signup failed: ${data.message}`);
                        }
                    } catch (error) {
                        console.error('Signup error:', error);
                        alert('An error occurred during signup. Please try again.');
                    }
                });
            }
            
            // Logout function
            window.logout = function() {
                localStorage.removeItem('user');
                updateUI(null);
                location.reload();
            };
            
            // Update UI based on login status
            function updateUI(user) {
                const authButtons = document.querySelector('.auth-buttons');
                const userNameSpan = document.getElementById('user-name');
                
                if (user) {
                    // User is logged in
                    if (authButtons) {
                        authButtons.innerHTML = `
                            <span class="text-light me-3">Welcome, ${user.name}!</span>
                            <button class="btn btn-outline" onclick="logout()">Logout</button>
                        `;
                    }
                    
                    // Show logged-in only elements
                    loggedInElements.forEach(el => el.style.display = 'block');
                } else {
                    // User is not logged in
                    if (authButtons) {
                        authButtons.innerHTML = '<button class="btn btn-outline login-btn">Login</button>';
                    }
                    
                    // Hide logged-in only elements
                    loggedInElements.forEach(el => el.style.display = 'none');
                    
                    // Reattach login button event if it was recreated
                    const newLoginBtn = document.querySelector('.login-btn');
                    if (newLoginBtn) {
                        newLoginBtn.addEventListener('click', () => {
                            if (modal) modal.style.display = 'flex';
                        });
                    }
                }
            }
            
            // Modal functionality
            if (loginBtn && modal) {
                loginBtn.addEventListener('click', () => {
                    modal.style.display = 'flex';
                });
            }
            
            if (closeBtn && modal) {
                closeBtn.addEventListener('click', () => {
                    modal.style.display = 'none';
                });
            }
            
            // Close modal when clicking outside
            window.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
            
            // Switch between login and signup forms
            if (switchToSignup && switchToLogin && loginForm && signupForm && modalTitle) {
                switchToSignup.addEventListener('click', (e) => {
                    e.preventDefault();
                    loginForm.style.display = 'none';
                    signupForm.style.display = 'block';
                    modalTitle.textContent = 'Create Account';
                });
                
                switchToLogin.addEventListener('click', (e) => {
                    e.preventDefault();
                    signupForm.style.display = 'none';
                    loginForm.style.display = 'block';
                    modalTitle.textContent = 'Welcome Back';
                });
            }
        }); 
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const responseElement = document.getElementById('formResponse');
            responseElement.innerHTML = ''; // Clear previous messages
            
            fetch('submit_contact.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                // Check if response is JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new TypeError("Oops, we didn't get JSON!");
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    responseElement.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                    this.reset(); // Reset form
                } else {
                    responseElement.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
            })
            .catch(error => {
                // ADD THE NEW ERROR HANDLING HERE:
                // First try to get the response text if available
                if (error.response) {
                    error.response.text().then(text => {
                        console.log("Raw response:", text);
                        responseElement.innerHTML = `
                            <div class="alert alert-danger">
                                Error: ${error.message}<br>
                                Response: ${text}
                            </div>`;
                    });
                } else {
                    // Fallback for network errors etc.
                    console.error('Error:', error);
                    responseElement.innerHTML = `
                        <div class="alert alert-danger">
                            Error: ${error.message || 'An error occurred. Please try again.'}
                        </div>`;
                }
            });
        });
    </script>
</body>
</html>