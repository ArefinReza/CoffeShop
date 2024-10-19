<?php
include('includes/db.php'); 
// Fetch all products from the database
$query = "SELECT product_id, product_name, price, special_price, image_url, description, category FROM products";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>

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

        .product-table {
            width: 100%;
            border-collapse: collapse;
        }

        .product-table th, .product-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .product-table th {
            background-color: #007bff;
            color: #fff;
        }

        .product-table td img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }

        .product-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .product-table tr:hover {
            background-color: #f1f1f1;
        }

        .no-products {
            text-align: center;
            font-size: 18px;
            color: #666;
            padding: 20px;
        }

        .back-btn {
            margin-top: 20px;
            display: block;
            text-align: center;
        }

        .back-btn a {
            color: #fff;
            background-color: #007bff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-btn a:hover {
            background-color: #0056b3;
        }
        #admin{
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="sticky-header" id="admin">
            <h1>ALL Product</h1>
            <button class="btn btn-danger" onclick="window.location.href='contacts.html'">Messages</button>
            <button class="btn btn-danger" onclick="window.location.href='addproduct.html'">Add Product</button>
            <button class="btn btn-danger" onclick="window.location.href='index.html'">Order List</button>
        </div>

        <?php if ($result->num_rows > 0) { ?>
            <table class="product-table sticky-table-header">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Special Price</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Action</th> <!-- New column for actions (Edit) -->
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['product_id']; ?></td>
                            <td><?php echo $row['product_name']; ?></td>
                            <td>৳<?php echo $row['price']; ?></td>
                            <td>৳<?php echo $row['special_price'] ? $row['special_price'] : 'N/A'; ?></td>
                            <td><img src="<?php echo $row['image_url']; ?>" alt="Product Image"></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo ucfirst($row['category']); ?></td>
                            <td>
                                <a href="edit_product.php?id=<?php echo $row['product_id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="delete_product.php?id=<?php echo $row['product_id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="no-products">No products found in the database.</div>
        <?php } ?>

        <div class="back-btn">
            <a href="index.html">Go Back to Admin Dashboard</a>
        </div>
    </div>

</body>

</html>

<?php
// Close the database connection
$conn->close();
?>
