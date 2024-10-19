<?php

include('includes/db.php'); 
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