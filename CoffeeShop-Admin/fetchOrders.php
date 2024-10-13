<?php
// fetchOrders.php

header('Content-Type: application/json');

// Database connection parameters (make sure these match your database setup)
$host = 'localhost'; // Your MySQL host (change if necessary)
$db = 'coffeeTusi'; // Your database name
$user = 'root'; // Your MySQL username
$pass = ''; // Your MySQL password

// Create a connection to the MySQL database
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['message' => 'Connection failed: ' . $conn->connect_error]));
}

// Fetch orders from the database
// $sql = "SELECT * FROM orders ORDER BY id DESC";
$sql = "SELECT id, email, item_id, item_name, total_price, created_at, table_number, items, order_status FROM orders ORDER BY id DESC";
$result = $conn->query($sql);

$orders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

// Close the connection
$conn->close();

// Return the orders as JSON
echo json_encode($orders);
