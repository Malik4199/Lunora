<?php

session_start();

require "config/database.php";
require "classes/Product.php";

$database = new Database();
$conn = $database->connect();

$product = new Product($conn);

$categories = $product->getCategories();

$category_id = isset($_GET['category'])
    ? (int)$_GET['category']
    : "";

$products = $product->getProductsByCategory($category_id);

// Get category name
$pageTitle = "All Products";

if($category_id != ""){

    $catQuery = $conn->prepare(
        "SELECT name FROM categories WHERE id=?"
    );

    $catQuery->bind_param("i",$category_id);

    $catQuery->execute();

    $catResult = $catQuery->get_result();

    if($catResult->num_rows > 0){

        $pageTitle = $catResult->fetch_assoc()['name'];

    }

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title><?php echo $pageTitle; ?> | Lunora</title>

<link rel="stylesheet"
href="assests/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include "includes/navbar.php"; ?>

<!-- CATEGORY HERO -->

<section class="category-hero">

<div class="category-content">

<span>SHOP BY CATEGORY</span>

<h1><?php echo htmlspecialchars($pageTitle); ?></h1>

<p>

Discover premium fashion pieces
carefully selected for your style.

</p>

</div>

</section>

<!-- CATEGORY NAVIGATION -->

<section class="category-nav">

<a
href="categories.php"
class="<?php echo ($category_id=="") ? "active" : ""; ?>">

All

</a>

<?php

$categories = $product->getCategories();

while($cat = $categories->fetch_assoc()){

?>

<a

href="categories.php?category=<?php echo $cat['id']; ?>"

class="<?php

echo ($category_id==$cat['id']) ? "active" : "";

?>">

<?php echo htmlspecialchars($cat['name']); ?>

</a>

<?php } ?>

</section>

<!-- PRODUCTS -->

<section class="shop-products">

<div class="section-title">

<h2>

<?php echo htmlspecialchars($pageTitle); ?>

</h2>

<span>

Showing

<?php echo $products->num_rows; ?>

Products

</span>

</div>

<div class="product-griding">

<?php

if($products->num_rows > 0){

while($row = $products->fetch_assoc()){

?>

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

<a href="cart.php?action=add&id=<?php echo $row['id']; ?>" class="cart-btn">
Add to Cart
</a>

</div>

</div>


<?php

}

}else{

?>

<!-- EMPTY CATEGORY -->

<div class="empty-state">

<i class="fa-solid fa-shirt"></i>

<h2>No Products Found</h2>

<p>
There are currently no products in this category.
</p>


<a href="categories.php" class="shop-btn">

View All Products

</a>


</div>


<?php

}

?>

</div>

</section>


<?php include "includes/footer.php"; ?>


</body>

</html>