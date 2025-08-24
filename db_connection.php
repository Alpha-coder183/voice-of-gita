<?php
// Database configuration
$host = 'localhost'; // Change if your database is hosted on another server
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password
$dbname = 'voice_of_gita';

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
