<?php

include('includes/db.php'); 

$product_id = isset($_GET['id']) ? $_GET['id'] : ''; 
// Handle the review form submission before output
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $review_text = $_POST['review'];
    $rating = intval($_POST['rating']);
    $default_image = "https://e7.pngegg.com/pngimages/954/486/png-clipart-white-cartoon-character-illustration-cuphead-youtube-computer-icons-video-game-trump-dabbing-game-white-thumbnail.png";
    $image_url = $default_image;

    // Handle the image upload
    if (isset($_FILES['review_image']) && $_FILES['review_image']['error'] == 0) {
        $image = $_FILES['review_image'];
        $image_ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $image_path = 'uploads/' . uniqid() . '.' . $image_ext;

        // Move uploaded file to the uploads directory
        if (move_uploaded_file($image['tmp_name'], $image_path)) {
            $image_url = $image_path;
        }
    }

    // Insert the review into the database
    $insert_review_query = "INSERT INTO reviews (product_id, name, review, image_url, rating) VALUES (?, ?, ?, ?, ?)";
    $insert_review_stmt = $conn->prepare($insert_review_query);
    $insert_review_stmt->bind_param("sssss", $product_id, $name, $review_text, $image_url, $rating);

    if ($insert_review_stmt->execute()) {
        // Redirect to avoid form resubmission on refresh
        header("Location: details.php?id=" . $product_id);
        exit;
    } else {
        echo '<p>Failed to submit the review. Please try again.</p>';
    }

    // Close insert statement
    $insert_review_stmt->close();
}

// Fetch product details from the database
$query = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $product_id); // Bind as string
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    ?>
    <!-- Product Details Page with Black Theme -->
    <style>
        body {
            background-color: #1a1a1a;
            font-family: Arial, sans-serif;
            color: #fff;
        }
        .product-details {
            max-width: 700px;
            margin: 40px auto;
            margin-top: 100px;
            padding: 20px;
            background-color: #333;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
        }
        .product-image {
            width: 100%;
            max-width: 300px;
            margin: 20px;
            border: 2px solid #555;
            border-radius: 10px;
            transition: transform 0.2s ease;
        }
        .product-image:hover {
            transform: scale(1.05);
        }
        .product-info h1 {
            font-size: 28px;
            margin-bottom: 10px;
            color: #f39c12;
        }
        .product-info p {
            margin-bottom: 20px;
            font-size: 18px;
        }
        .btn {
            background-color: #f39c12;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #e67e22;
        }
        .review-form, .reviews {
            margin-top: 40px;
        }
        .reviews p {
            border-bottom: 1px solid #555;
            padding-bottom: 10px;
        }
        .review-form input, .review-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #555;
            background-color: #444;
            color: #fff;
        }
        .review-form button {
            width: 100%;
            background-color: #f39c12;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .review-form button:hover {
            background-color: #e67e22;
        }
        .review-image {
            max-width: 100px;
            border-radius: 5px;
            margin-right: 10px;
        }
        .review-entry {
            display: flex;
            align-items: center;
            margin-bottom: 15px;

            max-width: 700px;
            margin: 5px auto;
            margin-top: 10px;
            padding: 20px;
            background-color: #333;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);

        }
        #rating{
            width: 70%;
        }
    </style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MT Coffee Shop</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style2.css">

</head>
<body>
<header class="header">

<a href="#" class="logo">
    <img src="images/logo1.png" alt="">
</a>

<nav class="navbar">
        <a href="index.php#home">home</a>
        <a href="index.php#about">about</a>
        <a href="index.php#menu">menu</a>
        <a href="index.php#products">products</a>
        <a href="index.php#review">review</a>
        <a href="index.php#contact">contact</a>
        <a href="index.php#blogs">blogs</a>
    </nav>
<div class="icons">
    <!-- <div class="fas fa-search" id="search-btn"></div> -->
    <div class="fas fa-shopping-cart" id="cart-btn"></div>
    <!-- <a href="#contact"><div class="fas fa-comment" id="favorite"></div></a> -->
    <div class="fas fa-bars" id="menu-btn"></div>
</div>

<div class="search-form">
    <input type="search" id="search-box" placeholder="Search menu...">
    <label for="search-box" class="fas fa-search" id="search-btn"></label>
</div>

<!-- <div class="cart-items-container"></div> -->
<div class="cart">
    <div class="cart-items-container">
        <!-- Cart items will be dynamically loaded here -->
    </div>
</div>
</header>
    <div class="product-details">
        <img src="<?php echo htmlspecialchars($product['image_url'], ENT_QUOTES); ?>" alt="<?php echo htmlspecialchars($product['product_name'], ENT_QUOTES); ?>" class="product-image animate-p">
        <div class="product-info">
            <h1><?php echo htmlspecialchars($product['product_name'], ENT_QUOTES); ?></h1>
            <p>Price: $<?php echo htmlspecialchars($product['price'], ENT_QUOTES); ?></p>
            <p>Special Price: $<?php echo htmlspecialchars($product['special_price'], ENT_QUOTES); ?></p>
            <p>Description: <?php echo htmlspecialchars($product['description'], ENT_QUOTES); ?></p>
            <a href="javascript:void(0)" class="btn" onclick="addToCart('<?php echo $product_id; ?>', '<?php echo addslashes($product['product_name']); ?>', <?php echo $product['special_price']; ?>, '<?php echo $product['image_url']; ?>')">Add To Cart</a>
        </div>
        <script src="js/script.js"></script>
        <!-- Review Form -->
        <div class="review-form">
            <h2>Leave a Review</h2>
            <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $product_id; ?>" method="POST" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Your Name" required>
                <textarea name="review" placeholder="Your Review" rows="5" required></textarea>
                <input type="number" id="rating" name="rating" min="1" max="5" placeholder="Rating (1-5)" required>
                <!-- <label for="review_image">Upload an image</label> -->
                <!-- <input type="file" name="review_image" accept="image/*"> -->
                <button type="submit">Submit Review</button>
            </form>
        </div>
    </div>

    <?php
    // Fetch and display product reviews
    $reviews_query = "SELECT * FROM reviews WHERE product_id = ?";
    $reviews_stmt = $conn->prepare($reviews_query);
    $reviews_stmt->bind_param("s", $product_id);
    $reviews_stmt->execute();
    $reviews_result = $reviews_stmt->get_result();

    if ($reviews_result->num_rows > 0) {
        echo '<div class="reviews">';
        echo '<h2 class="review-entry">Product Reviews</h2>';
        while ($review = $reviews_result->fetch_assoc()) {
            ?>
            <div class="review-entry">
                <img src="<?php echo htmlspecialchars($review['image_url'], ENT_QUOTES); ?>" alt="Review Image" class="review-image">
                <p><strong><?php echo htmlspecialchars($review['name'], ENT_QUOTES); ?>:</strong> <?php echo htmlspecialchars($review['review'], ENT_QUOTES); ?> - Rating: <?php echo $review['rating']; ?>/5</p>
            </div>
            <?php
        }
        echo '</div>';
    } else {
        echo '<p>No reviews yet. Be the first to leave a review!</p>';
    }

    // Close the database connection
    $stmt->close();
    $reviews_stmt->close();
    $conn->close();
    ?>
    <!-- footer section starts  -->

<section class="footer">

<div class="share">
        <a href="https://www.facebook.com/arefin.reza.saim4464444ud/" class="fab fa-facebook-f"></a>
        <!-- <a href="#" class="fab fa-twitter"></a> -->
        <a href="https://www.instagram.com/arefinsaim/" class="fab fa-instagram"></a>
        <a href="https://www.linkedin.com/in/arefinreza46/" class="fab fa-linkedin"></a>
        <!-- <a href="#" class="fab fa-pinterest"></a> -->
    </div>

<div class="links">
    <a href="index.php#home">Home</a>
    <a href="index.php#about">About</a>
    <a href="index.php#menu">Menu</a>
    <a href="index.php#products">Products</a>
    <a href="index.php#review">Review</a>
    <a href="index.php#contact">Contact</a>
    <a href="index.php#blogs">Blogs</a>
</div>

<div class="credit">© Copyright by<span>Arefin Reza</span> | all rights reserved</div>

</section>

<!-- footer section ends -->

</body>
</html>
<?php
} else {
    echo 'Product not found.';
}
?>

