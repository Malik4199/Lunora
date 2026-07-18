<?php require "includes/auth_check.php"; ?>

<?php include "includes/navbar.php"; ?>

<!-- PROFILE HERO -->

<section class="profile-hero">

    <div class="profile-hero-content">

        <span>MY ACCOUNT</span>

        <h1>Profile</h1>

        <p>
            Manage your account information, orders and wishlist.
        </p>

    </div>

</section>

<!-- PROFILE -->

<section class="profile-section">

    <!-- Left Side -->

    <div class="profile-card">

        <img src="assests/images/profile.jpg" alt="Profile">

        <h2>Duke Adatu</h2>

        <p>duke@email.com</p>

        <button>Edit Profile</button>

    </div>

    <!-- Right Side -->

    <div class="profile-details">

        <h2>Account Information</h2>

        <div class="detail-box">

            <div>
                <h4>Full Name</h4>
                <p>Duke Adatu</p>
            </div>

            <div>
                <h4>Email</h4>
                <p>duke@email.com</p>
            </div>

            <div>
                <h4>Phone</h4>
                <p>+234 800 000 0000</p>
            </div>

            <div>
                <h4>Address</h4>
                <p>Osogbo, Osun State</p>
            </div>

        </div>

        <div class="account-actions">

            <a href="orders.php">
                <i class="fa-solid fa-box"></i>
                My Orders
            </a>

            <a href="wishlist.php">
                <i class="fa-solid fa-heart"></i>
                Wishlist
            </a>

            <a href="#">
                <i class="fa-solid fa-lock"></i>
                Change Password
            </a>

            <a href="logout.php" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </a>

        </div>

    </div>

</section>

<?php include "includes/footer.php"; ?>