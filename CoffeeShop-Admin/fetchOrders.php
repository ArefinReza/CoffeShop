<?php
include('includes/db.php'); 

header('Content-Type: application/json');

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
