<?php
include('includes/db.php'); 
// Query to fetch product data
$query = "SELECT * FROM products WHERE category = 'product'";
$result = mysqli_query($conn, $query);

$menuQuery = "SELECT * FROM products where category = 'menu'";
$menuResult = mysqli_query($conn, $menuQuery);
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

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style2.css">
    <style>
        /* Ensure the review container only scrolls horizontally */
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

.see-more-btn {
    display: flex;
    justify-content: center;
    
    
    margin-left: 45%;
    margin-right: 45%;
}

.btn-primary {
    cursor: pointer;
    text-decoration: none;
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
        <a href="#home">home</a>
        <a href="#about">about</a>
        <a href="#menu">menu</a>
        <a href="#products">products</a>
        <a href="#review">review</a>
        <a href="#contact">contact</a>
        <a href="#blogs">blogs</a>
    </nav>

    <div class="icons">
        <div class="fas fa-search" id="search-btn"></div>
        <div class="fas fa-shopping-cart" id="cart-btn"></div>
        <a href="#contact"><div class="fas fa-comment" id="favorite"></div></a>
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


</header>

<!-- header section ends -->

<!-- home section starts  -->

<section class="home" id="home">
    <div class="content">
        <h3 class="animate-h3">Fresh Coffee in the Alltime</h3>
        <p class="animate-p">As a coffee shop owner you want to create community, boost local coffee culture, and make a fantastic brew. .</p>
        <a  onclick="window.location.href='shopdetails.html'" class="btn">Get Our Shop</a>
    </div>
</section>


<!-- home section ends -->

<!-- about section starts  -->

<section class="about" id="about">

    <h1 class="heading"> <span>about</span> us </h1>

    <div class="row">

        <div class="image">
            <img src="images/about-img.jpeg" alt="">
        </div>

        <div class="content">
            <h3>What makes our coffee special?</h3>
            <p>Step outside your door in America and you’re surrounded by coffee options: the drive-thru on the way to work, the gas station pot, the gas station fridge, your neighborhood cafe, and your office break room all offer a chance to dance with the caffeine spirits. Coffee comes in instant granules, pod packs, big bags, big bins, and everything in between, all angling to be the most convenient way to inject some life-boosting caffeine into your body. You’d be forgiven for thinking that coffee is effortless and un-special, something that you love and live for but not something to celebrate and cherish. 
</p>
            <p>Consider us a biased source, but we’re here to pull the curtain back and say:
                
                Coffee is incredibly special.
                
                And, actually, it's relatively amazing that it made it into your hands at all.</p>
            <a href="blog.html#coffeespecial" class="btn">learn more</a>
        </div>

    </div>

</section>

<!-- about section ends -->

<!-- menu section starts  -->

<section class="menu" id="menu">
    <h1 class="heading"> our <span>menu</span> </h1>

    <div class="box-container">
        <!-- -------------------------------------------------------- -->

        <?php
        // Fetch and display each product
        while ($row = mysqli_fetch_assoc($menuResult)) {
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


<!-- Product sections start  -->

<section class="products" id="products">
    <h1 class="heading"> our <span>products</span> </h1>

    <div class="box-container">
        <?php
        // Fetch only 3 products from the database
        $query = "SELECT product_id, product_name, price, special_price, image_url FROM products LIMIT 3";
        $result = $conn->query($query);

        // Check if there are products to display
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Prepare data for the JavaScript functions
                $product_id = $row['product_id'];
                $product_name = htmlspecialchars($row['product_name'], ENT_QUOTES);
                $price = $row['price'];
                $special_price = $row['special_price'] ? $row['special_price'] : $price; // Default to price if no special price
                $image_url = htmlspecialchars($row['image_url'], ENT_QUOTES);

                echo '
                <div class="box">
                    <div class="icons">
                        <a href="javascript:void(0)" class="fas fa-shopping-cart" onclick="addToCart(\'' . $product_id . '\', \'' . $product_name . '\', ' . $special_price . ', \'' . $image_url . '\')"></a>
                        <a href="javascript:void(0)" class="fas fa-heart" onclick="addToFavorites(\'' . $product_id . '\', \'' . $product_name . '\', ' . $special_price . ', \'' . $image_url . '\')"></a>
                        <a href="details.php?id=' . $product_id . '" class="fas fa-eye"></a>
                    </div>
                    <div class="image">
                        <img src="' . $image_url . '" alt="' . $product_name . '">
                    </div>
                    <div class="content">
                        <h3>' . $product_name . '</h3>
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <div class="price">৳' . $special_price . ' <span>৳' . $price . '</span></div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="no-products">No products found.</div>';
        }
        ?>
    </div>

    <!-- See More Button -->
    <div class="see-more-btn">
    <a href="allproducts.php" class="btn btn-primary text-center">See More</a>
</div>

</section>



<!-- review section starts  -->

<section class="review" id="review">
    <h1 class="heading"> customer's <span>review</span> </h1>

    <div class="review-container">
        <div class="scrolling-box-container">
            <?php
            $reviewQuery = "SELECT name, review, image_url, rating FROM reviews ORDER BY id DESC LIMIT 10";
            $rev = $conn->query($reviewQuery); 
            
            if ($rev->num_rows > 0) {
                // Loop through each review and output the content
                while ($row = $rev->fetch_assoc()) {
                    $name = htmlspecialchars($row['name'], ENT_QUOTES);
                    $review = htmlspecialchars($row['review'], ENT_QUOTES);
                    $image_url = htmlspecialchars($row['image_url'], ENT_QUOTES);
                    $rating = intval($row['rating']);
                    ?>

                    <div class="box">
                        <img src="images/quote-img.png" alt="Quote" class="quote">
                        <p><?php echo $review; ?></p>
                        <img src="<?php echo $image_url; ?>" class="user" alt="User  Image">
                        <h3><?php echo $name; ?></h3>
                        <div class="stars">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= $rating) {
                                    echo '<i class="fas fa-star"></i>';
                                } elseif ($i - $rating === 0.5) {
                                    echo '<i class="fas fa-star-half-alt"></i>';
                                } else {
                                    echo '<i class="far fa-star"></i>';
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <?php
                }
            } else {
                echo '<p>No reviews yet.</p>';
            }
            ?>
        </div>
    </div>
</section>

<!-- review section ends -->

<!-- contact section starts  -->

<section class="contact" id="contact">
    <h1 class="heading"> <span>contact</span> us </h1>

    <div class="row">
        <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3340.778054282565!2d90.41535567484812!3d23.830354485702983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c65c3a877bc3%3A0x5946ee1d0c93140a!2sKhilkhet%20Nikunja%202%20Jame%20Masjid!5e1!3m2!1sen!2sbd!4v1728033952677!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

        <form action="process.php" method="POST">
            <h3>get in touch</h3>
            <div class="inputBox">
                <span class="fas fa-user"></span>
                <input type="text" name="name" placeholder="name" required>
            </div>
            <div class="inputBox">
                <span class="fas fa-envelope"></span>
                <input type="email" name="email" placeholder="email" required>
            </div>
            <div class="inputBox">
                <span class="fas fa-phone"></span>
                <input type="text" name="phone" placeholder="phone number" required>
            </div>
            <div class="inputBox">
                <span class="fas fa-comment"></span>
                <input name="message" placeholder="your message" required>
            </div>
            <input type="submit" value="contact now" class="btn">
        </form>
    </div>
</section>


<!-- contact section ends -->

<!-- blogs section starts  -->

<section class="blogs" id="blogs">

    <h1 class="heading"> our <span>blogs</span> </h1>

    <div class="box-container">

        <div class="box">
            <div class="image">
                <img src="images/blog-1.jpeg" alt="">
            </div>
            <div class="content">
                <a href="#" class="title">Type Of coffee</a>
                <span>by admin / 21st may, 2024</span>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, dicta.</p>
                <a href="blog.html#typeOfCoffee" class="btn">read more</a>
            </div>
        </div>

        <div class="box">
            <div class="image">
                <img src="images/blog-2.jpeg" alt="">
            </div>
            <div class="content">
                <a href="#" class="title">Health Of coffee</a>
                <span>by admin / 21st may, 2024</span>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, dicta.</p>
                <a href="blog.html#healthOfCoffee" class="btn">read more</a>
            </div>
        </div>

        <div class="box">
            <div class="image">
                <img src="images/blog-3.jpeg" alt="">
            </div>
            <div class="content">
                <a href="#" class="title">Culture Of Coffee</a>
                <span>by admin / 21st may, 2024</span>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Non, dicta.</p>
                <a href="blog.html#cultureOfCoffee" class="btn">read more</a>
            </div>
        </div>

    </div>

</section>

<!-- blogs section ends -->

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
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#menu">Menu</a>
        <a href="#products">Products</a>
        <a href="#review">Review</a>
        <a href="#contact">Contact</a>
        <a href="#blogs">Blogs</a>
    </div>

    <div class="credit">Created by <span>Arefin Reza</span> | all rights reserved</div>

</section>

<!-- footer section ends -->
 
<!-- custom js file link  -->
<script src="js/script.js"></script>
<script src="js/search.js"></script>
</body>
</html>