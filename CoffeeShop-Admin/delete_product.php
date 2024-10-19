<?php
include('includes/db.php'); 

// Check if the product ID is set
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>alert('Product deleted successfully!'); window.location.href='allproducts.php';</script>";
    } else {
        echo "<script>alert('Error deleting product: " . $conn->error . "'); window.location.href='allproducts.php';</script>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>