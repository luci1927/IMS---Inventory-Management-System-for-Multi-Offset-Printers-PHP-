<?php
$servername = "localhost"; 
$username = "root";       
$password = "Tharindu@0929";           
$dbname = "ims"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
