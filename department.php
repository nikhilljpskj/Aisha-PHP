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
        <h1 class="hero-title">User Department Portal</h1>
        <p class="hero-subtitle">
            Welcome! Please fill out the form below to Departmen  information into our database.
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
            <h2>Department Form</h2>
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
                <label for="department_name	" class="form-label">
                    department_name	 <span class="required-mark">*</span>
                </label>
                <!-- Frontend Validation: required, minlength="2" -->
                <input 
                    type="text"
            id="department_name"
            name="department_name"
            class="form-control"
            placeholder="Enter department name"
            required
            minlength="2"
            maxlength="100"
                >
            </div>

            <div class="form-group">
        <label for="faculty_name" class="form-label">
            Faculty Name <span class="required-mark">*</span>
        </label>

        <input 
            type="text"
            id="faculty_name"
            name="faculty_name"
            class="form-control"
            placeholder="Enter faculty name"
            required
            minlength="2"
            maxlength="100"
        >
    </div>

            <!-- Two-Column Group for Mobile & Email -->
            <!-- <div class="form-row">
               
                <div class="form-group col-half">
                    <label for="faculty_name" class="form-label">
                        faculty_name <span class="required-mark">*</span>
                    </label>
                   Frontend Validation: pattern enforces 10 to 15 digits -->
                    <!-- <input 
                       type="text"
            id="faculty_name"
            name="faculty_name"
            class="form-control"
            placeholder="Enter faculty name"
            required
            minlength="2"
            maxlength="100"
                    >
                    
                </div> --> 

               

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

