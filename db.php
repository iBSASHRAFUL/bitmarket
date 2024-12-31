<?php
$servername = "localhost";
$username = "root"; // Your phpMyAdmin username
$password = ""; // Your phpMyAdmin password
$dbname = "ecommerce";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
