<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require "config/database.php";
require "classes/Cart.php";

$database = new Database();
$conn = $database->connect();

$cart = new Cart($conn);

/*  ADD PRODUCT TO CART */

if (
    isset($_GET['action']) &&
    $_GET['action'] == "add" &&
    isset($_GET['id'])
) {

    $cart->addToCart(
        $_SESSION['user_id'],
        (int)$_GET['id']
    );

    header("Location: shop.php");
    exit();
}

/* INCREASE QUANTITY */

if (
    isset($_GET['action']) &&
    $_GET['action'] == "increase"
) {

    $cart_id = (int)$_GET['cart'];
    $quantity = (int)$_GET['qty'] + 1;

    $cart->updateQuantity($cart_id, $quantity);

    header("Location: cart.php");
    exit();
}

/*  DECREASE QUANTITY */

if (
    isset($_GET['action']) &&
    $_GET['action'] == "decrease"
) {

    $cart_id = (int)$_GET['cart'];

    $quantity = (int)$_GET['qty'] - 1;

    if ($quantity < 1) {
        $quantity = 1;
    }

    $cart->updateQuantity($cart_id, $quantity);

    header("Location: cart.php");
    exit();
}

/* REMOVE ITEM */

if (
    isset($_GET['action']) &&
    $_GET['action'] == "remove"
) {

    $cart->removeItem((int)$_GET['cart']);

    header("Location: cart.php");
    exit();
}

/*   GET CART ITEMS */

$cartItems = $cart->getCartItems($_SESSION['user_id']);

$hasItems = ($cartItems->num_rows > 0);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Your Cart | Lunora</title>

<link rel="stylesheet" href="assests/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include "includes/navbar.php"; ?>

<section class="cart-section">

<h1>Your Shopping Cart</h1>

<div class="cart-container">

<div class="cart-items">

<?php

$total = 0;

if($hasItems){

while($row = $cartItems->fetch_assoc()){

$subtotal = $row['price'] * $row['quantity'];

$total += $subtotal;

?>

<div class="cart-card">

<img
src="assests/images/products/<?php echo htmlspecialchars($row['image']); ?>"
alt="<?php echo htmlspecialchars($row['name']); ?>">

<div class="cart-info">

<h3>

<?php echo htmlspecialchars($row['name']); ?>

</h3>

<p>

$<?php echo number_format($row['price'],2); ?>

</p>

<div class="quantity">

<a href="cart.php?action=decrease&cart=<?php echo $row['cart_id']; ?>&qty=<?php echo $row['quantity']; ?>">

-

</a>

<span>

<?php echo $row['quantity']; ?>

</span>

<a href="cart.php?action=increase&cart=<?php echo $row['cart_id']; ?>&qty=<?php echo $row['quantity']; ?>">

+

</a>

</div>

<a
href="cart.php?action=remove&cart=<?php echo $row['cart_id']; ?>"
class="cart-remove"
onclick="return confirm('Remove this item from your cart?')">

Remove

</a>

</div>

</div>

<?php }

} else { ?>

<div class="empty-state">

<i class="fa-solid fa-cart-shopping"></i>

<h2>Your Cart is Empty</h2><br>

<p>

Looks like you haven't added any products yet.

</p><br>

<a href="shop.php" class="shop-btn">

Continue Shopping

</a>

</div>

<?php } ?>

</div>

<?php if($hasItems){ ?>

<div class="cart-summary">

<h2>Order Summary</h2>

<p>

Subtotal

<span>

$<?php echo number_format($total,2); ?>

</span>

</p>

<p>

Shipping

<span>

$20.00

</span>

</p>

<hr>

<h3>

Total

<span>

$<?php echo number_format($total + 20,2); ?>

</span>

</h3>

<a href="checkout.php" class="checkout-btn">

Proceed To Checkout

</a>

</div>

<?php } ?>

</div>

</section>

<?php include "includes/footer.php"; ?>

</body>

</html>