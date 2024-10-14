<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['department'])) {
    // Redirect to login page if no session exists
    header("Location: index.php");
    exit();
}

// Check if session has expired
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $_SESSION['expire_time'])) {
    // If session expired, destroy it and redirect to login page
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
} else {
    // If session is still valid, update last activity time
    $_SESSION['last_activity'] = time();
}

// Department-specific access control
if ($_SESSION['department'] != 1) {
    echo "You do not have permission to access this page.";
    exit();
}
?>
