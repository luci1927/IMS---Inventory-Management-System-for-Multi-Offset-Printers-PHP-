<?php
$serverName = "localhost"; 
$username = "root";       
$password = "Multi@2024";           
$dbname = "ims"; 

$conn = new mysqli($serverName, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
