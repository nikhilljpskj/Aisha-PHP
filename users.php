<?php
// ====================================================================
// FILE: users.php
// PURPOSE: Displays all registered users from MySQL database in a
//          clean responsive table, with delete actions for each row.
// ====================================================================

// 1. Include dependencies
require_once 'config.php';
require_once 'functions.php';

// 2. Fetch all users using our modular helper function
$users = getAllUsers($conn);

// ====================================================================
// 🐞 DEBUGGING TIP:
// To see the structure and count of all fetched users, uncomment:
// echo "<pre>";
// var_dump($users);
// echo "</pre>";
// ====================================================================

// 3. Include site header
include 'header.php';
?>

<!-- Link to Users Page Stylesheet -->
<link rel="stylesheet" href="users.css">

<!-- Hero Banner -->
<section class="hero-section">
    <div class="hero-container">
        <h1 class="hero-title">Registered Users Directory</h1>
        <p class="hero-subtitle">
            View all entries stored in the MySQL database, or remove records using the delete action.
        </p>
    </div>
</section>

<!-- Main Table Section -->
<section class="records-section">
    <div class="records-container">

        <!-- ========================================================== -->
        <!-- ALERT NOTIFICATIONS                                        -->
        <!-- Displays success when a record is deleted or errors        -->
        <!-- ========================================================== -->
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] === 'deleted'): ?>
                <div class="alert alert-success">
                    <strong>🗑️ Deleted!</strong> The user record was permanently removed from the database.
                </div>
            <?php elseif ($_GET['status'] === 'error'): ?>
                <div class="alert alert-danger">
                    <strong>⚠️ Error:</strong> <?php echo isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : 'An error occurred.'; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Directory Header Bar -->
        <div class="directory-bar">
            <div class="directory-title-wrap">
                <h2>All Submissions</h2>
                <span class="badge-count">
                    Total: <?php echo count($users); ?> <?php echo count($users) === 1 ? 'Record' : 'Records'; ?>
                </span>
            </div>
            <a href="index.php#form-section" class="btn btn-add">
                ➕ Add New User
            </a>
        </div>

        <!-- ========================================================== -->
        <!-- TABLE VIEW / EMPTY STATE                                   -->
        <!-- ========================================================== -->
        <?php if (empty($users)): ?>
            <!-- Shown when the database has 0 rows -->
            <div class="empty-card">
                <div class="empty-icon">📭</div>
                <h3>No Users Found in Database</h3>
                <p>There are currently no records stored in the database table.</p>
                <a href="index.php#form-section" class="btn btn-primary" style="margin-top: 15px; display: inline-block;">
                    Submit Your First Entry
                </a>
            </div>
        <?php else: ?>
            <!-- Responsive Table Wrapper: Allows horizontal scrolling on narrow mobile screens -->
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Full Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Location</th>
                            <th>Registered On</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through each user row using foreach loop -->
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <!-- ID Column -->
                                <td class="id-cell">
                                    #<?php echo htmlspecialchars($user['id']); ?>
                                </td>

                                <!-- Name Column -->
                                <td class="name-cell">
                                    <strong><?php echo htmlspecialchars($user['name']); ?></strong>
                                </td>

                                <!-- Mobile Column -->
                                <td>
                                    <a href="tel:<?php echo htmlspecialchars($user['mobile']); ?>" class="contact-link">
                                        <?php echo htmlspecialchars($user['mobile']); ?>
                                    </a>
                                </td>

                                <!-- Email Column -->
                                <td>
                                    <a href="mailto:<?php echo htmlspecialchars($user['email']); ?>" class="contact-link">
                                        <?php echo htmlspecialchars($user['email']); ?>
                                    </a>
                                </td>

                                <!-- Address Column (handles multi-line text cleanly) -->
                                <td class="address-cell">
                                    <?php echo nl2br(htmlspecialchars($user['address'])); ?>
                                </td>

                                <!-- Country & State Combined -->
                                <td>
                                    <span class="location-badge">
                                        <?php echo htmlspecialchars($user['state']); ?>, <?php echo htmlspecialchars($user['country']); ?>
                                    </span>
                                </td>

                                <!-- Submission Timestamp -->
                                <td class="date-cell">
                                    <?php 
                                        // Format date nicely: e.g., "08 Sep 2026, 03:30 PM"
                                        $date = strtotime($user['created_at']);
                                        echo date("d M Y, h:i A", $date);
                                    ?>
                                </td>

                                <!-- Delete Action Button -->
                                <!-- INTERVIEW POINT: JavaScript confirm() provides a simple, client-side confirmation check before performing a destructive action -->
                                <td class="text-center">
                                    <a 
                                        href="delete-user.php?id=<?php echo urlencode($user['id']); ?>" 
                                        class="btn-delete"
                                        onclick="return confirm('⚠️ Are you sure you want to delete <?php echo addslashes($user['name']); ?> (ID #<?php echo $user['id']; ?>)? This action cannot be undone.');"
                                        title="Delete user"
                                    >
                                        🗑️ Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php
// Close database connection
$conn->close();

// Include site footer
include 'footer.php';
?>
