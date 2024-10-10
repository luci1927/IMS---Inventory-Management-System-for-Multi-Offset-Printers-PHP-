<?php
session_start();
require "connection2.php"; 



$username = $_POST["e"];
$password = $_POST["p"];
$department = $_POST["d"];


$stmt = $conn->prepare("SELECT * FROM `user` WHERE `username`=? AND `password`=? AND `departments_dep_id`=?");
$stmt->bind_param("sss", $username, $password, $department);
$stmt->execute();
$rs = $stmt->get_result();
$n = $rs->num_rows;

if ($n == 1) {
    $d = $rs->fetch_assoc();
    $dep_id = $d["departments_dep_id"];

    if ($dep_id == 1) {
        echo "multi";
    } else if ($dep_id == 2) {
        echo "fair";
    } else if ($dep_id == 3) {
        echo "rajah";
    }


    $_SESSION["u"] = $d;

} else {

    echo "Invalid Username or Password";
}
?>
