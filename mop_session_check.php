<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['department'])) {

    header("Location: index.php");
    exit();
}

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $_SESSION['expire_time'])) {

    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
} else {
    $_SESSION['last_activity'] = time();
}

if ($_SESSION['department'] != 1) {
    echo "You do not have permission to access this page.";
    exit();
}
?>
