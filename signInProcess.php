<?php
session_start();
require "connection2.php"; 

// Get POST data
$username = $_POST["e"];
$password = $_POST["p"];
$department = $_POST["d"];

// Prepare the SQL statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM `user` WHERE `username`=? AND `departments_dep_id`=?");
$stmt->bind_param("ss", $username, $department);
$stmt->execute();
$rs = $stmt->get_result();

if ($rs->num_rows == 1) {
    $user = $rs->fetch_assoc();

    // Compare the plain text password directly (recommended: use password hashing)
    if ($password === $user['password']) {

        // Regenerate session ID to prevent session fixation attacks
        session_regenerate_id(true);

        // Store user data in session
        $_SESSION['username'] = $username;
        $_SESSION['department'] = $user['departments_dep_id'];
        $_SESSION['last_activity'] = time(); 
        $_SESSION['expire_time'] = 1800; // 30 minutes

        // Echo department ID to be used for redirection in JavaScript
        echo $user['departments_dep_id']; // Returns 1, 2, or 3
    } else {
        echo "Invalid Username or Password";
    }
} else {
    echo "Invalid Username or Password";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
