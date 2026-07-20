<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require "config/database.php";
require "classes/Wishlist.php";

$database = new Database();
$conn = $database->connect();

$wishlist = new Wishlist($conn);

// Remove item
if (isset($_GET['remove'])) {

    $wishlist->remove((int)$_GET['remove']);

    header("Location: wishlist.php");
    exit();
}

// Get wishlist items
$items = $wishlist->getWishlist($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Wishlist | Lunora</title>

<link rel="stylesheet" href="assests/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include "includes/navbar.php"; ?>

<!-- HERO -->

<section class="wishlist-hero">

<div class="wishlist-hero-content">

<span>YOUR FAVORITES</span>

<h1>My Wishlist</h1>

<p>
Save your favorite fashion pieces and shop them anytime.
</p>

</div>

</section>

<!-- WISHLIST -->

<section class="wishlist-section">

<div class="wishlist-gridss">

<?php if($items->num_rows > 0){ ?>

<?php while($row = $items->fetch_assoc()){ ?>

<div class="wishlist-cardss">

<img
src="assests/images/products/<?php echo htmlspecialchars($row['image']); ?>"
alt="<?php echo htmlspecialchars($row['name']); ?>">

<h3>

<?php echo htmlspecialchars($row['name']); ?>

</h3>

<p class="price">

$<?php echo number_format($row['price'],2); ?>

</p>

<div class="wishlist-actions">

<a
href="cart.php?action=add&id=<?php echo $row['product_id']; ?>"
class="cart-btnn">

Add to Cart

</a>

<a
href="wishlist.php?remove=<?php echo $row['wishlist_id']; ?>"
class="remove-btnn"
onclick="return confirm('Remove this item from your wishlist?')">

Remove

</a>

</div>

</div>

<?php } ?>

<?php } else { ?>

<div class="empty-state">

<i class="fa-solid fa-heart"></i>

<h2>Your Wishlist is Empty</h2><br>

<p>

Save products you love and they'll appear here.

</p><br>

<a href="shop.php" class="shop-btn">

Browse Products

</a>

</div>

<?php } ?>

</div>

</section>

<?php include "includes/footer.php"; ?>

</body>

</html>