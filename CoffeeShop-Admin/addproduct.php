<?php
include('includes/db.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $special_price = $_POST['special_price'];
    $image_url = $_POST['image_url'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    // Prepare and execute the insert query
    $query = "INSERT INTO products (product_id, product_name, price, special_price, image_url, description, category) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssss", $product_id, $product_name, $price, $special_price, $image_url, $description, $category);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Product added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
