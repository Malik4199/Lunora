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

if (isset($_GET['remove'])) {

    $wishlist->remove((int) $_GET['remove']);

    header("Location: wishlist.php");
    exit();
}

$items = $wishlist->getWishlist($_SESSION['user_id']);

?>

<?php include "includes/navbar.php"; ?>

<!-- WISHLIST HERO -->

<section class="wishlist-hero">

    <div class="wishlist-hero-content">

        <span>YOUR FAVORITES</span>

        <h1>My Wishlist</h1>

        <p>Save your favorite fashion pieces and shop them anytime.</p>

    </div>

</section>

<!-- WISHLIST -->

<div class="wishlist-gridss">

<?php while($row = $items->fetch_assoc()){ ?>

<div class="wishlist-cardss">

<img
src="assests/images/products/<?php echo htmlspecialchars($row['image']); ?>"
alt="<?php echo htmlspecialchars($row['name']); ?>">

<h3><?php echo htmlspecialchars($row['name']); ?></h3>

<p class="price">
$<?php echo number_format($row['price'],2); ?>
</p>

<div class="wishlist-actions">

<a
href="cart.php?action=add&id=<?php echo $row['id']; ?>"
class="cart-btnn">

Add to Cart

</a>

<a
href="wishlist.php?remove=<?php echo $row['wishlist_id']; ?>"
class="remove-btnn"
onclick="return confirm('Remove this item from wishlist?')">

Remove

</a>

</div>

</div>

<?php } ?>

</div>
    
</section>

<?php include "includes/footer.php"; ?>