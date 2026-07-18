<?php

session_start();

require "config/database.php";
require "classes/Product.php";

$database = new Database();
$conn = $database->connect();

$product = new Product($conn);

$products = $product->getShopProducts();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Shop | Lunora</title>

<link rel="stylesheet" href="assets/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include "includes/navbar.php"; ?>

<!-- SHOP HERO -->

<section class="shop-hero">

    <div class="shop-hero-content">

        <h1>Shop</h1>

        <p>
            Discover timeless fashion pieces designed to elevate your everyday style.
        </p>

    </div>

</section>

<!-- SEARCH & FILTER -->

<section class="shop-controls">

    <form class="search-form" action="" method="GET">

        <input
            type="text"
            name="search"
            placeholder="Search for products...">

        <button type="submit">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>

    </form>

    <div class="filters">

        <select>
            <option>All Categories</option>
            <option>Women</option>
            <option>Men</option>
            <option>Dresses</option>
            <option>Shoes</option>
            <option>Bags</option>
        </select>

        <select>
            <option>Sort By</option>
            <option>Newest</option>
            <option>Price: Low to High</option>
            <option>Price: High to Low</option>
            <option>Best Selling</option>
        </select>

    </div>

</section>

<!-- PRODUCT SECTION -->
<section class="shop-products">

    <div class="section-title">

        <h2>All Products</h2>

        <span>
            Showing <?php echo $products->num_rows; ?> Products
        </span>

    </div>

<div class="product-griding">

    <?php while($row = $products->fetch_assoc()){ ?>

    <div class="product-carding">

    <a href="add-wishlist.php?id=<?php echo $row['id']; ?>" class="wishlist-btn">
    <i class="fa-regular fa-heart"></i>
    </a>

    <img src="assests/images/products/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">

    <h3><?php echo htmlspecialchars($row['name']); ?></h3>

    <p class="pricess">$<?php echo number_format($row['price'], 2); ?></p>

    <div class="ratingss">
        ★★★★★ <span>(0)</span>
    </div>

    <div class="product-actions">
        <a href="product.php?id=<?php echo $row['id']; ?>" class="view-btn">
            View Details
        </a>

        <a href="cart.php?action=add&id=<?php echo $row['id']; ?>" class="cart-btn">
            Add to Cart
        </a>
    </div>

</div>

<?php } ?>
</div>

</section>

<?php include "includes/footer.php"; ?>
</body>
</html>