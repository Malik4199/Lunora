<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUNORA</title>

    <link rel="stylesheet" href="assests/css/style.css">

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>

<div class="top-bar">
    FREE SHIPPING ON ALL ORDERS ABOVE $5000
</div>

<header>

    <!-- Logo -->
    <div class="logo">
        <a href="index.php">LUNORA</a>
    </div>

    <!-- Navigation -->
    <nav>
        <a href="index.php">Home</a>
        <a href="shop.php">Shop</a>
        <a href="login.php">Contact</a>
    </nav>

    <!-- Right Side -->
    <div class="header-right">

        <!-- Search -->
        <form class="search-box" action="shop.php" method="GET">

            <input
                type="text"
                name="search"
                placeholder="Search products...">

            <button type="submit">

                <i class="fa-solid fa-magnifying-glass"></i>

            </button>

        </form>

        <!-- Wishlist -->
        <a href="wishlist.php" class="icon">

            <i class="fa-regular fa-heart"></i>

        </a>

        <!-- Account Dropdown -->
        <div class="dropdown">

            <button class="dropbtn">

                <i class="fa-regular fa-user"></i>

                <i class="fa-solid fa-angle-down"></i>

            </button>

            <div class="dropdown-content">

                <a href="login.php">Login</a>

                <a href="register.php">Register</a>

            </div>

        </div>

        <!-- Cart -->
        <a href="cart.php" class="cart">

            <i class="fa-solid fa-bag-shopping"></i>

            <span>0</span>

        </a>

    </div>

</header>

