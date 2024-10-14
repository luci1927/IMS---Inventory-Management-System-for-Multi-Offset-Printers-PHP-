<?php
session_start();
require "connection2.php"; 

$username = $_POST["e"];
$password = $_POST["p"];
$department = $_POST["d"];


$stmt = $conn->prepare("SELECT * FROM `user` WHERE `username`=? AND `departments_dep_id`=?");
$stmt->bind_param("ss", $username, $department);
$stmt->execute();
$rs = $stmt->get_result();

if ($rs->num_rows == 1) {
    $user = $rs->fetch_assoc();


    if ($password === $user['password']) {

        session_regenerate_id(true);

        $_SESSION['username'] = $username;
        $_SESSION['department'] = $user['departments_dep_id'];
        $_SESSION['last_activity'] = time(); 
        $_SESSION['expire_time'] = 1800; 


        echo $user['departments_dep_id']; 
    } else {
        echo "Invalid Username or Password";
    }
} else {
    echo "Invalid Username or Password";
}


$stmt->close();
$conn->close();
?>
