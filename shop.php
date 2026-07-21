<?php

session_start();

require "config/database.php";
require "classes/Product.php";

$database = new Database();
$conn = $database->connect();

$product = new Product($conn);

$categories = $product->getCategories();

$search = $_GET['search'] ?? "";
$category = $_GET['category'] ?? "";
$sort = $_GET['sort'] ?? "";

$products = $product->searchProducts($search, $category, $sort);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Shop | Lunora</title>

<link rel="stylesheet" href="assests/css/style.css">

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

<form class="search-form" method="GET">

<input
type="text"
name="search"
placeholder="Search products..."
value="<?php echo htmlspecialchars($search); ?>">

<button type="submit">
<i class="fa-solid fa-magnifying-glass"></i>
Search
</button>

<div class="filters">

<select name="category">

<option value="">All Categories</option>

<?php while($cat = $categories->fetch_assoc()){ ?>

<option
value="<?php echo $cat['id']; ?>"
<?php if($category == $cat['id']) echo "selected"; ?>>

<?php echo htmlspecialchars($cat['name']); ?>

</option>

<?php } ?>

</select>


<select name="sort">
<option value="">Sort By</option>

<option value="newest"
<?php if($sort=="newest") echo "selected"; ?>>
Newest
</option>

<option value="low-high"
<?php if($sort=="low-high") echo "selected"; ?>>
Price: Low to High
</option>

<option value="high-low"
<?php if($sort=="high-low") echo "selected"; ?>>
Price: High to Low
</option>

<option value="name"
<?php if($sort=="name") echo "selected"; ?>>
Name (A-Z)
</option>

</select>
</div>
</form>

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

<?php if($products->num_rows > 0){ ?>

<?php while($row = $products->fetch_assoc()){ ?>

<div class="product-carding">

<button class="wishlist-btn">
<a
href="add-wishlist.php?id=<?php echo $row['id']; ?>">

<i class="fa-regular fa-heart"></i>
</a>
</button>

<img
src="assests/images/products/<?php echo htmlspecialchars($row['image']); ?>"
alt="<?php echo htmlspecialchars($row['name']); ?>">

<h3>

<?php echo htmlspecialchars($row['name']); ?>

</h3>

<p class="pricess">

$<?php echo number_format($row['price'],2); ?>

</p>

<div class="ratingss">
<?php
$rating = $row['rating'] ?? 0;
echo str_repeat("★", floor($rating));
echo str_repeat("☆", 5 - floor($rating));
?>
<span><?php echo number_format($rating,1); ?></span>
</div>

<div class="product-actions">
<a href="product.php?id=<?php echo $row['id']; ?>" class="view-btn">
View Details
</a>

<a
href="cart.php?action=add&id=<?php echo $row['id']; ?>"
class="cart-btn">

Add to Cart

</a>

</div>

</div>

<?php } ?>

<?php } else { ?>

<p class="no-products">

No products found.

</p>

<?php } ?>

</div>

</section>

<?php include "includes/footer.php"; ?>

</body>

</html>