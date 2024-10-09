<?php
$servername = "localhost"; // or your DB server name
$username = "root";        // DB username
$password = "password";            // DB password
$dbname = "ims"; // Replace with your actual DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
