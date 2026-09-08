<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Character encoding for standard characters -->
    <meta charset="UTF-8">
    <!-- Viewport meta tag makes the website responsive on mobile phones and tablets -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aisha Pandit - Web Portal</title>
    
    <!-- Link to Header Stylesheet -->
    <link rel="stylesheet" href="header.css">
    <!-- Link to Main Page Stylesheet -->
    <link rel="stylesheet" href="index.css">
    <!-- Link to Footer Stylesheet -->
    <link rel="stylesheet" href="footer.css">
</head>
<body>

    <!-- ========================================================== -->
    <!-- HEADER COMPONENT (header.php)                              -->
    <!-- Contains the website branding/logo and navigation menu     -->
    <!-- ========================================================== -->
    <header class="site-header">
        <div class="header-container">
            <!-- 1. Logo / Brand Name -->
            <div class="site-logo">
                <a href="index.php" class="logo-link">
                    <!-- Simple SVG / icon + text logo -->
                    <span class="logo-badge">AP</span>
                    <span class="logo-text">Aisha<strong>Portal</strong></span>
                </a>
            </div>

            <!-- 2. Navigation Menu -->
            <!-- Semantic <nav> element is best practice for accessibility and SEO -->
            <nav class="site-nav" aria-label="Main Navigation">
                <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
                <ul class="nav-menu">
                    <li class="nav-item"><a href="index.php" class="nav-link <?php echo $currentPage === 'index.php' ? 'active' : ''; ?>">Home</a></li>
                    <li class="nav-item"><a href="index.php#form-section" class="nav-link">Register</a></li>
                    <li class="nav-item"><a href="users.php" class="nav-link <?php echo $currentPage === 'users.php' ? 'active' : ''; ?>">View Users</a></li>
                    <li class="nav-item"><a href="index.php#about" class="nav-link">About</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content Area Starts (Closed in footer.php) -->
    <main class="main-content">
