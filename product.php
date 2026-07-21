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

require "classes/Review.php";

$review = new Review($conn);

if(isset($_POST['submit_review'])){

    $rating = (int)$_POST['rating'];

    $text = trim($_POST['review']);

    $review->addReview(
        $_SESSION['user_id'],
        $id,
        $rating,
        $text
    );

    header("Location: product.php?id=".$id);

    exit();
}

$reviews = $review->getReviews($id);

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

<div class="product-rating">
<?php
$rating = $productData['rating'] ?? 0;
echo str_repeat("★", floor($rating));
echo str_repeat("☆", 5 - floor($rating));
?>
<span>
<?php echo number_format($rating,1); ?>/5
</span>
</div>

<br>

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

</div>

</div>

</section>

</div>

</section>

<!-- REVIEW FORM START -->
<section class="review-form">

<h2>Leave a Review</h2><br>
<form method="POST">
<label>Rating</label>

<select name="rating" required>

<option value="">Select Rating</option>
<option value="5">★★★★★</option>
<option value="4">★★★★☆</option>
<option value="3">★★★☆☆</option>
<option value="2">★★☆☆☆</option>
<option value="1">★☆☆☆☆</option>

</select>

<textarea name="review" rows="5" placeholder="Write your review..." required></textarea>

<button type="submit" name="submit_review">Submit Review</button>
</form>

</section>

<!-- CUSTOMER REVIEWS -->
<section class="customer-reviews">
<h2>Customer Reviews</h2>
<?php
if($reviews->num_rows > 0){
while($row = $reviews->fetch_assoc()){
?>

<div class="review-card">
<h4><?php echo htmlspecialchars($row['fullname']); ?></h4>
<p><?php
echo str_repeat("★",$row['rating']);
echo str_repeat("☆",5-$row['rating']);
?></p>

<p><?php echo nl2br(htmlspecialchars($row['review'])); ?></p>

<small><?php echo date("d M Y",strtotime($row['created_at'])); ?></small>
</div>
<?php
}

}else{

?>

<p>No reviews yet. Be the first to review this product.</p>

<?php } ?>

</section>

<?php include "includes/footer.php"; ?>

</body>
</html>