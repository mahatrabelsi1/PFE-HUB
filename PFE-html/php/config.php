<?php
// Database credentials
$host = 'localhost'; // or the IP address of your database server
$dbname = 'PFE_HUB'; // the name of your database
$username = 'root'; // your database username
$password = ''; // your database password

// Create a new MySQLi connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
