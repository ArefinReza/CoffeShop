<?php
// updateOrderStatus.php

header('Content-Type: application/json');

// Database connection parameters
$host = 'localhost'; // Your MySQL host
$db = 'coffeetusi'; // Your database name
$user = 'root'; // Your MySQL username
$pass = ''; // Your MySQL password

// Create a connection to the MySQL database
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['message' => 'Connection failed: ' . $conn->connect_error]));
}

// Get the JSON input
$data = json_decode(file_get_contents('php://input'), true);
$orderId = intval($data['id']);
$orderStatus = $conn->real_escape_string($data['order_status']);

// Update the order status
$sql = "UPDATE orders SET order_status='$orderStatus' WHERE id=$orderId";
if ($conn->query($sql) === TRUE) {
    echo json_encode(['message' => 'Order status updated successfully!']);
} else {
    echo json_encode(['message' => 'Error: ' . $conn->error]);
}

// Close the connection
$conn->close();
