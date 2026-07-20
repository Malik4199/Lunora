<?php

session_start();

require "config/database.php";
require "classes/Product.php";

$database = new Database();
$conn = $database->connect();

$product = new Product($conn);

if (!isset($_GET['id'])) {
    header("Location: shop.php");
    exit();
}

$id = $_GET['id'];

$productData = $product->getSingleProduct($id);

if (!$productData) {
    header("Location: shop.php");
    exit();
}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo htmlspecialchars($productData['name']); ?> | Lunora</title>

<link rel="stylesheet" href="assets/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include "includes/navbar.php"; ?>

<section class="single-product">

<div class="product-image">

<img
src="assests/images/products/<?php echo htmlspecialchars($productData['image']); ?>"
alt="<?php echo htmlspecialchars($productData['name']); ?>">

</div>

<div class="product-details">

<h1><?php echo htmlspecialchars($productData['name']); ?></h1>

<p class="categoryss">

Category:
<strong><?php echo htmlspecialchars($productData['category_name']); ?></strong>

</p>

<h2>

$<?php echo number_format($productData['price'],2); ?>

</h2>

<p>

<?php echo nl2br(htmlspecialchars($productData['description'])); ?>

</p>

<p>

Stock:

<strong><?php echo $productData['stock']; ?>
  Available
</strong>

</p>

<div class="quantity-box">

<label>Quantity</label>

<input
type="number"
value="1"
min="1"
max="<?php echo $productData['stock']; ?>">

</div>

<div class="product-buttons">

<a
href="cart.php?action=add&id=<?php echo $productData['id']; ?>"
class="cart-btns">

<i class="fa-solid fa-cart-shopping"></i>

Add to Cart

</a>

<a
href="wishlist.php?action=add&id=<?php echo $productData['id']; ?>"
class="wishlist-btn">

<i class="fa-regular fa-heart"></i>

Wishlist

</a>

</div>

</div>

</section>

<?php include "includes/footer.php"; ?>

</body>

</html>