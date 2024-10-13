<?php
// Database connection parameters
$host = 'localhost'; // Your MySQL host
$user = 'root'; // Your MySQL username
$pass = ''; // Your MySQL password

// Create a connection to MySQL server
$conn = new mysqli($host, $user, $pass);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if database 'coffeetusi' exists, and create it if it doesn't
$db = 'coffeetusi';
$db_check = "CREATE DATABASE IF NOT EXISTS $db";
if ($conn->query($db_check) === TRUE) {
    echo "Database '$db' exists or created successfully.<br>";
} else {
    die("Error creating database: " . $conn->error);
}

// Connect to the 'coffeetusi' database
$conn->select_db($db);

// Create the 'orders' table if it doesn't exist
$createOrdersTable = "
CREATE TABLE IF NOT EXISTS orders (
    id INT(11) NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
    item_id INT(11) NOT NULL,
    item_name VARCHAR(255) COLLATE utf8mb4_general_ci NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
    table_number VARCHAR(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
    items LONGTEXT COLLATE utf8mb4_bin DEFAULT NULL,
    order_status VARCHAR(50) COLLATE utf8mb4_general_ci DEFAULT 'pending',
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

if ($conn->query($createOrdersTable) === TRUE) {
    echo "Table 'orders' exists or created successfully.<br>";
} else {
    die("Error creating table 'orders': " . $conn->error);
}

// Create the 'contacts' table if it doesn't exist
$createContactsTable = "
CREATE TABLE IF NOT EXISTS contacts (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(100) COLLATE utf8mb4_general_ci NOT NULL,
    email VARCHAR(100) COLLATE utf8mb4_general_ci NOT NULL,
    phone VARCHAR(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
    message TEXT COLLATE utf8mb4_general_ci NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

if ($conn->query($createContactsTable) === TRUE) {
    echo "Table 'contacts' exists or created successfully.<br>";
} else {
    die("Error creating table 'contacts': " . $conn->error);
}

// Close the connection
$conn->close();
?>
