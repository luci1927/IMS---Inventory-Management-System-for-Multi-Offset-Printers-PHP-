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

    // Compare the plain text password directly
    if ($password === $user['password']) {
        $_SESSION['username'] = $username;
        $_SESSION['department'] = $user['departments_dep_id'];

        // Echo the department ID for redirection
        echo $user['departments_dep_id']; // This will be 1, 2, or 3
    } else {
        // Invalid password
        echo "Invalid Username or Password";
    }
} else {
    // Invalid username or department
    echo "Invalid Username or Password";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>

