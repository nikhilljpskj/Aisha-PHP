<?php
// ====================================================================
// FILE: index.php
// PURPOSE: Frontend page containing the registration/contact form
// ARCHITECTURE: Includes header.php at top and footer.php at bottom
// ====================================================================

// 1. Include the reusable site header and navigation bar
include 'header.php';
?>

<!-- Hero Banner / Page Intro -->
<section class="hero-section">
    <div class="hero-container">
        <h1 class="hero-title">User Registration Portal</h1>
        <p class="hero-subtitle">
            Welcome! Please fill out the form below to register your information into our database.
        </p>
    </div>
</section>

<!-- Main Form Section -->
<section class="form-section" id="form-section">
    <div class="form-card">

        <!-- ========================================================== -->
        <!-- ALERT MESSAGES (Success / Error Notification)              -->
        <!-- INTERVIEW POINT: How do we show messages after redirect?   -->
        <!-- We read the 'status' and 'msg' parameters from the URL     -->
        <!-- using PHP's $_GET superglobal array.                       -->
        <!-- ========================================================== -->
        <?php
        // Check if a 'status' parameter is passed in the URL (e.g. index.php?status=success)
        if (isset($_GET['status'])) {
            if ($_GET['status'] === 'success') {
                echo '<div class="alert alert-success">';
                echo '<strong>🎉 Success!</strong> Your details have been submitted and saved into the MySQL database successfully. ';
                echo '<a href="users.php" style="color: #065f46; font-weight: 700; text-decoration: underline; margin-left: 6px;">View All Users Directory &rarr;</a>';
                echo '</div>';
            } elseif ($_GET['status'] === 'error') {
                // htmlspecialchars() prevents Cross-Site Scripting (XSS) if someone enters malicious text in the URL
                $errorMsg = isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : 'An error occurred while saving your data.';
                echo '<div class="alert alert-danger">';
                echo '<strong>⚠️ Submission Failed:</strong> ' . $errorMsg;
                echo '</div>';
            }
        }
        ?>

        <!-- Form Heading -->
        <div class="form-header">
            <h2>Registration Form</h2>
            <p>All fields marked with <span class="required-mark">*</span> are required.</p>
        </div>

        <!-- ========================================================== -->
        <!-- HTML5 FORM                                                 -->
        <!-- INTERVIEW QUESTIONS:                                       -->
        <!-- 1. Why action="form-submit.php"? Specifies the backend     -->
        <!--    script that will process and insert the submitted data.  -->
        <!-- 2. Why method="POST"? POST securely sends data in the HTTP -->
        <!--    request body rather than exposing it in the URL (GET).  -->
        <!-- ========================================================== -->
        <form action="form-submit.php" method="POST" class="user-form" novalidate="false">

            <!-- 1. Full Name -->
            <div class="form-group">
                <label for="name" class="form-label">
                    Full Name <span class="required-mark">*</span>
                </label>
                <!-- Frontend Validation: required, minlength="2" -->
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control" 
                    placeholder="Enter your full name (e.g. Aisha Pandit)" 
                    required 
                    minlength="2"
                    maxlength="100"
                >
            </div>

            <!-- Two-Column Group for Mobile & Email -->
            <div class="form-row">
                <!-- 2. Mobile Number -->
                <div class="form-group col-half">
                    <label for="mobile" class="form-label">
                        Mobile Number <span class="required-mark">*</span>
                    </label>
                    <!-- Frontend Validation: pattern enforces 10 to 15 digits -->
                    <input 
                        type="tel" 
                        id="mobile" 
                        name="mobile" 
                        class="form-control" 
                        placeholder="e.g. 9876543210" 
                        required 
                        pattern="[0-9]{10,15}"
                        title="Please enter a valid 10 to 15 digit phone number"
                    >
                    <small class="form-hint">Numbers only (10-15 digits)</small>
                </div>

                <!-- 3. Email Address -->
                <div class="form-group col-half">
                    <label for="email" class="form-label">
                        Email Address <span class="required-mark">*</span>
                    </label>
                    <!-- Frontend Validation: type="email" enforces standard email format -->
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control" 
                        placeholder="e.g. aisha@example.com" 
                        required
                        maxlength="100"
                    >
                </div>
            </div>

            <!-- 4. Street Address -->
            <div class="form-group">
                <label for="address" class="form-label">
                    Residential Address <span class="required-mark">*</span>
                </label>
                <textarea 
                    id="address" 
                    name="address" 
                    class="form-control textarea-control" 
                    rows="3" 
                    placeholder="Enter complete street address, house no, locality..." 
                    required
                ></textarea>
            </div>

            <!-- Two-Column Group for Country & State -->
            <div class="form-row">
                <!-- 5. Country -->
                <div class="form-group col-half">
                    <label for="country" class="form-label">
                        Country <span class="required-mark">*</span>
                    </label>
                    <select id="country" name="country" class="form-control select-control" required>
                        <option value="">-- Select Country --</option>
                        <option value="India">India</option>
                        <option value="United States">United States</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="Canada">Canada</option>
                        <option value="Australia">Australia</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <!-- 6. State -->
                <div class="form-group col-half">
                    <label for="state" class="form-label">
                        State / Province <span class="required-mark">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="state" 
                        name="state" 
                        class="form-control" 
                        placeholder="e.g. Maharashtra, California..." 
                        required
                        maxlength="50"
                    >
                </div>
            </div>

            <!-- Form Action Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Submit Registration
                </button>
                <button type="reset" class="btn btn-secondary">
                    Clear Form
                </button>
            </div>

        </form>

        <!-- Project Reference Note (Assignment Compliance) -->
        <div class="form-note">
            <p>
                💡 <em>Reference standard: Form insertion using PHP MySQLi prepared statements.</em>
            </p>
        </div>

    </div>
</section>

<!-- Additional Information Section (About the Project) -->
<section class="info-section" id="about">
    <div class="info-container">
        <h2>About This Project</h2>
        <div class="info-grid">
            <div class="info-box">
                <div class="info-icon">🔒</div>
                <h3>Prepared Statements</h3>
                <p>SQL queries are pre-compiled to defend against SQL injection attacks, separating commands from user data.</p>
            </div>
            <div class="info-box">
                <div class="info-icon">⚡</div>
                <h3>Dual Validation</h3>
                <p>Client-side HTML5 validation provides rapid feedback, while server-side PHP validation guarantees data integrity.</p>
            </div>
            <div class="info-box">
                <div class="info-icon">📱</div>
                <h3>100% Responsive</h3>
                <p>Pure CSS flexbox and media queries ensure seamless viewing across phones, tablets, and desktops.</p>
            </div>
        </div>
    </div>
</section>

<?php
// 2. Include the reusable site footer
include 'footer.php';
?>
