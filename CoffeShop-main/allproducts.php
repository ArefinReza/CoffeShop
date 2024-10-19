<?php
include('includes/db.php'); 

$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed" . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MT Coffee Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style2.css">
    <style>
        .review-container {
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .box {
            display: inline-block;
            width: 300px;
            margin: 10px;
            padding: 20px;
            background-color: #333;
            border-radius: 10px;
            color: #fff;
            text-align: center;
        }

        .box img.quote {
            width: 30px;
            height: 30px;
            margin-bottom: 15px;
        }

        .box img.user {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .stars i {
            color: #f39c12;
        }
        .scrolling-box-container {
            display: flex;
            white-space: nowrap; 
            animation: scrollReviews 30s linear infinite;
        }
        @keyframes scrollReviews {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-100%);
            }
        }

.blur {
    filter: blur(8px);
    pointer-events: auto; 
}


.fullscreen-product {
    position: fixed;
    top: 60%;
    left: 35%;
    transform: translate(-50%, -50%); 
    width: 60%;
    max-width: 800px;
    height: auto; 
    background-color: #222;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
    border-radius: 10px; 
    padding: 20px; 
    transition: all 0.3s ease; 
    overflow-y: auto;
}

.fullscreen-product img {
    max-width: 100%; 
    height: auto; 
    border-radius: 10px;
}

.fullscreen-product h3 {
    font-size: 2rem;
    margin: 20px 0;
    color: #fff; 
}

.fullscreen-product p {
    font-size: 1.5rem;
    color: #ddd; 
    text-align: center;
    margin: 10px 0;
}

.fullscreen-product .btn {
    padding: 10px 20px;
    background-color: #28a745; 
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 1.2rem;
    transition: background-color 0.3s; 
}

/* Button hover effect */
.fullscreen-product .btn:hover {
    background-color: #218838;
}

.search-form {
    position: relative; 
}

.dropdown-content {
    display: none;
    position: absolute; 
    background-color: #333;
    min-width: 200px; 
    border: 1px solid #444;
    border-radius: 5px; 
    z-index: 1; 
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5); 
}

.dropdown-content div {
    padding: 12px 16px; 
    cursor: pointer; 
    color: #fff;
    transition: background-color 0.3s; 
}

.dropdown-content div:hover {
    background-color: #555; 
}


body.fullscreen-active {
    overflow: hidden; 
}
#heading{
    margin-top: 100px;
    color: white;
    text-align: center;
    font-size: 40px;
}


    </style>

</head>
<body>
    
<!-- header section starts  -->

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
        <div class="fas fa-search" id="search-btn"></div>
        <div class="fas fa-shopping-cart" id="cart-btn"></div>
        <a href="index.php#contact"><div class="fas fa-comment" id="favorite"></div></a>
        <div class="fas fa-bars" id="menu-btn"></div>
    </div>

    <div class="search-form">
    <input type="text" id="search-box" placeholder="Search products..." class="search-input">
        <label for="search-box" class="fas fa-search" id="search-btn"></label>
    </div>

    <!-- <div class="cart-items-container"></div> -->
    <div class="cart">
        <div class="cart-items-container">
            <!-- Cart items will be dynamically loaded here -->
        </div>
    </div>
    
    
    <!-- <div class="favorite-items-container"></div> -->


</header>

<!-- header section ends -->
<!-- menu section starts  -->

<section class="menu" id="menu">
    <h1 id="heading"> All <span>Product</span> </h1>
    
    <div class="box-container">
        <!-- -------------------------------------------------------- -->

        <?php
        // Fetch and display each product
        while ($row = mysqli_fetch_assoc($result)) {
            // Prepare data for the JavaScript functions
            $product_id = $row['product_id'];
            $product_name = htmlspecialchars($row['product_name'], ENT_QUOTES);
            $price = $row['price'];
            $special_price = $row['special_price'] ? $row['special_price'] : $price;
            $image_url = htmlspecialchars($row['image_url'], ENT_QUOTES);

            echo '
            <div class="box">
                <img src="' . $image_url . '" alt="' . $product_name . '">
                <h3>' . $product_name . '</h3>
                <div class="price">৳' . $special_price . ' <span>৳' . $price . '</span></div>
                <a href="javascript:void(0)" class="btn" onclick="addToCart(\'' . $product_id . '\', \'' . $product_name . '\', ' . $special_price . ', \'' . $image_url . '\')">Add To Cart</a>
                <a href="details.php?id=' . $product_id . '" class="btn">Details</a>
            </div>';
        }
        ?>

        
    </div>
</section>

<!-- menu section ends -->


<!-- footer section starts  -->

<section class="footer">

    <div class="share">
        <a href="#" class="fab fa-facebook-f"></a>
        <a href="#" class="fab fa-twitter"></a>
        <a href="#" class="fab fa-instagram"></a>
        <a href="#" class="fab fa-linkedin"></a>
        <a href="#" class="fab fa-pinterest"></a>
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

    <div class="credit">Created by <span>Arefin Reza</span> | all rights reserved</div>

</section>

<!-- footer section ends -->


<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="js/search.js"></script>
</body>
</html>