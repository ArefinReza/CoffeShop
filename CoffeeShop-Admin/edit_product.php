<?php
include('includes/db.php'); 
// Get the product ID from the URL
$product_id = $_GET['id'];

// Fetch the product details from the database
$query = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

// Initialize message variables
$update_message = "";
$is_success = false;

// Handle form submission for updating the product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $special_price = $_POST['special_price'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    // Update the product in the database
    $update_query = "UPDATE products SET product_name = ?, price = ?, special_price = ?, description = ?, category = ? WHERE product_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param('sssssi', $product_name, $price, $special_price, $description, $category, $product_id);

    if ($update_stmt->execute()) {
        // Reset form values and show success message
        $product_name = $price = $special_price = $description = $category = '';
        $is_success = true;
        $update_message = "Product updated successfully!";
    } else {
        $update_message = "Error updating product: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>

    <!-- Google Fonts and Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f8;
            margin: 20px;
        }

        .container {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: 500;
            color: #333;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .message {
            margin-bottom: 20px;
            text-align: center;
            font-size: 18px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Edit Product</h2>

        <?php if (!empty($update_message)) { ?>
            <div class="message <?php echo $is_success ? 'success' : 'error'; ?>">
                <?php echo $update_message; ?>
            </div>
        <?php } ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>

            <div class="form-group">
                <label for="special_price">Special Price</label>
                <input type="text" class="form-control" id="special_price" name="special_price" value="<?php echo htmlspecialchars($product['special_price']); ?>">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" class="form-control" id="category" name="category" value="<?php echo htmlspecialchars($product['category']); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>

        <div class="back-btn">
            <a href="allproducts.php" class="btn btn-secondary mt-3">Go Back to All Products</a>
        </div>
    </div>

</body>

</html>

<?php
// Close the database connection
$conn->close();
?>
