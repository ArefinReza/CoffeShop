<?php
$host = 'localhost'; // Change if using an external database
$dbname = 'coffeeTusi'; // Your database name
$username = 'root'; // Your MySQL username
$password = ''; // Your MySQL password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
