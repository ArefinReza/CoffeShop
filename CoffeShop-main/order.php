<?php
// order.php

header('Content-Type: application/json');

// Database connection parameters
$host = 'localhost'; // Your MySQL host
$db = 'coffeeTusi'; // Your database name
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
$email = $conn->real_escape_string($data['email']);
$tableNumber = $conn->real_escape_string($data['table_number']);
$totalPrice = $conn->real_escape_string($data['total_price']); // Get total price from client
$items = $data['items'];

// Check if items are present
if (empty($items)) {
    echo json_encode(['message' => 'No items in the cart.']);
    exit;
}

$orderDetails = [];
foreach ($items as $item) {
    $id = $conn->real_escape_string($item['id']);
    $name = $conn->real_escape_string($item['name']);
    $price = $conn->real_escape_string($item['price']);
    $quantity = intval($item['quantity']);

    // Add item details to order
    $orderDetails[] = [
        'name' => $name,
        'total_price' => $price,
        'quantity' => $quantity,
    ];
}

// Convert order details to JSON format for storage
$orderJSON = $conn->real_escape_string(json_encode($orderDetails));

// Set initial order status as 'pending'
$orderStatus = 'pending';

// Insert order into the database, including total price and order status
$sql = "INSERT INTO orders (email, table_number, items, total_price, order_status) VALUES ('$email', '$tableNumber', '$orderJSON', '$totalPrice', '$orderStatus')";
if (!$conn->query($sql)) {
    echo json_encode(['message' => 'Error: ' . $conn->error]);
    exit;
}

// Close the connection
$conn->close();

// Send a success response
echo json_encode(['message' => 'Order placed successfully with status pending!']);
?>
