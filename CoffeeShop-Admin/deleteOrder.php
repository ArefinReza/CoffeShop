// deleteOrder.php
<?php
$host = 'localhost'; 
$db = 'coffeetusi'; 
$user = 'root'; 
$pass = ''; 

// Create a connection to the MySQL database
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['message' => 'Connection failed: ' . $conn->connect_error]));
}
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