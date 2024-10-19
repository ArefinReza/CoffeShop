// deleteOrder.php
<?php
include('includes/db.php'); 
// Get the order ID from the request
$data = json_decode(file_get_contents("php://input"));
$orderId = $data->id;

// Prepare and execute the delete statement
$sql = "DELETE FROM orders WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $orderId);

if ($stmt->execute()) {
    echo json_encode(["message" => "Order deleted successfully."]);
} else {
    echo json_encode(["message" => "Error deleting order: " . $conn->error]);
}

$stmt->close();
$conn->close();
?>