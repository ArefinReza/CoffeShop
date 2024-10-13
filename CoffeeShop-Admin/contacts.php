<?php

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

// Fetch contacts data
$sql = "SELECT * FROM contacts";
$result = $conn->query($sql);

// Display contacts data
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<p>ID: " . $row["id"]. " - Name: " . $row["name"]. " - Email: " . $row["email"]. " - Phone: " . $row["phone"]. " - Message: " . $row["message"]. " - Created At: " . $row["created_at"];
    }
} else {
    echo "0 results";
}

$conn->close();
?>