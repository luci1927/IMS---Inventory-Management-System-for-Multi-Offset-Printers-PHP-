<?php
session_start();
require "connection2.php";  // Ensure this is the correct path to your connection file



$username = $_POST["e"];
$password = $_POST["p"];
$department = $_POST["d"];

// Prepared statement to avoid SQL injection
$stmt = $conn->prepare("SELECT * FROM `user` WHERE `username`=? AND `password`=? AND `departments_dep_id`=?");
$stmt->bind_param("sss", $username, $password, $department);
$stmt->execute();
$rs = $stmt->get_result();
$n = $rs->num_rows;

if ($n > 0) {
    $d = $rs->fetch_assoc();
    $dep_id = $d["departments_dep_id"];

    

    // Check the department ID
    if ($dep_id == 1) {
        echo "multi";
    } else if ($dep_id == 2) {
        echo "fair";
    } else if ($dep_id == 3) {
        echo "rajah";
    }

    // Store user in session
    $_SESSION["u"] = $d;

} else {
    // Invalid login attempt
    echo "Invalid Username or Password";
}
?>
