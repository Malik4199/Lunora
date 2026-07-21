<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<footer class="footer">

    <div class="footer-container">

        <!-- Brand -->
        <div class="footer-col">
            <h2 class="footer-logo">LUNORA</h2>
            <span class="footer-fashion">FASHION</span>

            <p>
                Timeless fashion for every moment.
                Designed with you in mind.
            </p>

            <div class="social-icons">
                <a href="https://www.instagram.com/olayide_exp?igsh=NjlmcnAza3c4ZHZ0" target="parent"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="https://pin.it/3ILVs17Ea" target="parent"><i class="fa-brands fa-pinterest-p"></i></a>
                <a href="https://www.tiktok.com/@o0o0o0o0b0?_r=1&_t=ZS-98CYtpL4TKv" target="parent"><i class="fa-brands fa-tiktok"></i></a>
            </div>

        </div>

        <!-- Shop -->
        <div class="footer-col">

            <h3>SHOP</h3>

            <ul>
                <li><a href="shop.php">All Products</a></li>
                <li><a href="shop.php">New Arrivals</a></li>
                <li><a href="shop.php">Women</a></li>
                <li><a href="shop.php">Men</a></li>
                <li><a href="shop.php">Sale</a></li>
            </ul>

        </div>

        <!-- Customer Care -->
        <div class="footer-col">

            <h3>CUSTOMER CARE</h3>

            <ul>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="orders.php">Shipping & Delivery</a></li>
                <li><a href="contact.php">Returns & Exchanges</a></li>
                <li><a href="product.php">Size Guide</a></li>
                <li><a href="contact.php">FAQs</a></li>
            </ul>

        </div>

        <!-- About -->
        <div class="footer-col">

            <h3>ABOUT US</h3>

            <ul>
                <li><a href="dashboard.php">Our Story</a></li>
                <li><a href="dashboard.php">Sustainability</a></li>
                <li><a href="dashboard.php">Careers</a></li>
                <li><a href="dashboard.php">Press</a></li>
                <li><a href="contact.php">Store Locator</a></li>
            </ul>

        </div>

        <!-- Newsletter -->
        <div class="footer-col">

            <h3>STAY CONNECTED</h3>

            <p>
                Sign up for updates and get
                10% off your first order.
            </p>

            <form action="newsletter.php"  class="newsletter" method="POST">

                <input
                    type="email" name="email"
                    placeholder="Enter your email"
                >

                <button type="submit" name="subscribe">
                    →
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
    </div>
</footer>

</footer>