<?php require "includes/auth_check.php"; ?>

<?php
include "includes/navbar.php";
?>

<!-- Hero Section -->
<section class="dashboard-hero">

    <div class="hero-content">

        <h2>
            Welcome,
            <?php echo $_SESSION['fullname']; ?>
        </h2><br><br>


        <span>NEW COLLECTION</span>

        <h1>
            Elevate Your <br>
            Fashion Style
        </h1>

        <p>
            Discover premium fashion collections designed
            for confidence, elegance, and everyday comfort.
        </p>

        <a href="shop.php" class="shop-btn">Shop Now</a>

    </div>
</section>

<!-- Categories slide -->
<section class="category-slider">

    <div class="category-item">
        <img src="assests/images/categories/women.jpg" alt="Women">
        <h4>Women</h4>
    </div>

    <div class="category-item">
        <img src="assests/images/categories/men.jpg" alt="Men">
        <h4>Men</h4>
    </div>

    <div class="category-item">
        <img src="assests/images/categories/dresses.jpg" alt="Dresses">
        <h4>Dresses</h4>
    </div>

    <div class="category-item">
        <img src="assests/images/categories/tops.jpg" alt="Tops">
        <h4>Tops</h4>
    </div>

    <div class="category-item">
        <img src="assests/images/categories/shoes.jpg" alt="Shoes">
        <h4>Shoes</h4>
    </div>

    <div class="category-item">
        <img src="assests/images/categories/bags.jpg" alt="Bags">
        <h4>Bags</h4>
    </div>

    <div class="category-item">
        <img src="assests/images/categories/accessories.jpg" alt="Accessories">
        <h4>Accessories</h4>
    </div>

    <div class="category-item sale">
        <span>SALE</span>
    </div>

</section>

<!-- SHOP BY CATEGORY -->

<section class="shop-category">

    <div class="section-header">

        <div>
            <small>SHOP BY CATEGORY</small>
            <h2>Find Your</h2>
            <h2>Perfect Style</h2>
        </div>

        <a href="shop.php">View All Categories →</a>

    </div>

    <div class="category-grid">

        <div class="category-card large">
            <img src="assests/images/collections/women.jpg" alt="">
            <div class="overlay">
                <h3>Women's Collection</h3>
                <a href="shop.php">Explore Now →</a>
            </div>
        </div>

        <div class="category-card large">
            <img src="assests/images/collections/men.jpg" alt="">
            <div class="overlay">
                <h3>Men's Collection</h3>
                <a href="shop.php">Explore Now →</a>
            </div>
        </div>

        <div class="category-card large">
            <img src="assests/images/collections/dresses.jpg" alt="">
            <div class="overlay">
                <h3>Dresses</h3>
                <a href="shop.php">Explore Now →</a>
            </div>
        </div>

        <div class="category-card large">
            <img src="assests/images/collections/accessories.jpg" alt="">
            <div class="overlay">
                <h3>Accessories</h3>
                <a href="shop.php">Explore Now →</a>
            </div>
        </div>
    </div>
<!-- </section> -->

<!-- <section class="shop-catego"> -->

    <!-- <div class="ban-contain">

      <div class="promo-cardss">
        <div class="conten">
           <small>LIMITED TIME OFFER</small>
           <h2>Spring Sale<br>Up to 50% Off</h2>
           <button>Shop The Sale →</button>
        </div>

        <div class="imaging">
           <img src="assests/images/collections/sale.jpg" alt="">
        </div>
      </div>

      <div class="promo-cardss">
        <div class="conten">
           <small>NEW ARRIVALS</small>
           <h2>Fresh Style<br>Just Landed</h2>
           <button>Explore New in →</button>
        </div>

        <div class="imaging">
           <img src="assests/images/collections/new.jpg" alt="">
        </div>
     </div>
    </div> -->
</section>

   <!-- BEST SELLERS -->

<section class="best-sellers">

    <div class="section-header">

        <div>
            <small>BEST SELLERS</small>
            <h2>Our Most Loved Picks</h2>
        </div>

        <a href="shop.php">View All Products →</a>

    </div>

    <div class="product-griding">

        <!-- Product 1 -->
        <div class="product-carding">

            <button class="wishlist-btn">
                <i class="fa-regular fa-heart"></i>
            </button>

            <img src="assests/images/products/blazer.png">

            <h3>Linen Blend Blazer</h3>

            <p class="pricess">$89.99</p>

            <div class="ratingss">
                ★★★★★ <span>(324)</span>
            </div>
        </div>

        <!-- Product 2 -->
        <div class="product-carding">

            <button class="wishlist-btn">
                <i class="fa-regular fa-heart"></i>
            </button>

            <img src="assests/images/products/top.png">

            <h3>Ribbed Knit Top</h3>

            <p class="pricess">$29.99</p>

            <div class="ratingss">
                ★★★★★ <span>(190)</span>
            </div>
        </div>

        <!-- Product 3 -->
        <div class="product-carding">

            <button class="wishlist-btn">
                <i class="fa-regular fa-heart"></i>
            </button>

            <img src="assests/images/products/trousers.png">

            <h3>Wide Leg Trousers</h3>

            <p class="pricess">$59.99</p>

            <div class="ratingss">
                ★★★★★ <span>(96)</span>
            </div>
        </div>

        <!-- Product 4 -->
        <div class="product-carding">

            <button class="wishlist-btn">
                <i class="fa-regular fa-heart"></i>
            </button>

            <img src="assests/images/products/bag.png">

            <h3>Leather Shoulder Bag</h3>

            <p class="pricess">$79.99</p>

            <div class="ratingss">
                ★★★★★ <span>(112)</span>
            </div>
        </div>

        <!-- Product 5 -->
        <div class="product-carding">

            <button class="wishlist-btn">
                <i class="fa-regular fa-heart"></i>
            </button>

            <img src="assests/images/products/heels.png">

            <h3>Minimal Strappy Heels</h3>

            <p class="pricess">$49.99</p>

            <div class="ratingss">
                ★★★★★ <span>(64)</span>
            </div>
        </div>

        <!-- Product 6 -->
        <div class="product-carding">

            <button class="wishlist-btn">
                <i class="fa-regular fa-heart"></i>
            </button>

            <img src="assests/images/products/sunglasses.png">

            <h3>Oversized Sunglasses</h3>

            <p class="pricess">$19.99</p>

            <div class="ratingss">
                ★★★★★ <span>(53)</span>
            </div>
        </div>
    </div>

</section> 


<!-- SERVICE FEATURES -->

<section class="services">

    <div class="service-box">
        <i class="fa-solid fa-truck-fast"></i>

        <div>
            <h3>Free Shipping</h3>
            <p>On orders over $99</p>
        </div>
    </div>

    <div class="service-box">
        <i class="fa-solid fa-box-open"></i>

        <div>
            <h3>Easy Returns</h3>
            <p>30-day returns</p>
        </div>
    </div>

    <div class="service-box">
        <i class="fa-solid fa-shield-halved"></i>

        <div>
            <h3>Secure Payment</h3>
            <p>100% protected</p>
        </div>
    </div>

    <div class="service-box">
        <i class="fa-solid fa-headset"></i>

        <div>
            <h3>24/7 Support</h3>
            <p>We're here to help</p>
        </div>
    </div>

</section>

<!-- JOIN OUR STYLE LIST -->

<section class="newsletter">

    <div class="newsletter-image">

        <img src="assests/images/newsletter.jpg" alt="Fashion Newsletter">

    </div>

    <div class="newsletter-content">

        <span>GET 10% OFF YOUR FIRST ORDER</span>

        <h2>Join Our Style List</h2>

        <p>
            Sign up for exclusive ofters, new arrivals, and style inspination.
        </p>

        <form action="newsletter.php" method="POST" class="newsletter-form">
            <input type="email" name="email" placeholder="Enter your email address" required>
            <button type="submit" name="subscribe">
                Subscribe
            </button>
        </form>
        <?php
            if(isset($_GET['newsletter'])){
                if($_GET['newsletter']=="success"){
                    echo "<p class='success'>
                    Subscribed successfully!
                    </p>";
                } elseif($_GET['newsletter']=="empty"){
                    echo "<p class='error'>
                    Email is required.
                </p>"; } else{
                    echo "<p class='error'>
                    ".$_GET['newsletter']."
                </p>";
            }
        }
        ?>
    </div>

</section>
<?php
include "includes/footer.php";
?>