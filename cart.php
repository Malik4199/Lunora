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

if (
    isset($_GET['action']) &&
    $_GET['action'] == "add" &&
    isset($_GET['id'])
) {

    $cart->addToCart(
        $_SESSION['user_id'],
        $_GET['id']
    );

    header("Location: cart.php");
    exit();

}

$cartItems = $cart->getCartItems($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Your Cart | Lunora</title>

<link rel="stylesheet" href="assests/css/style.css">

</head>


<body>

<?php include "includes/navbar.php"; ?>


<section class="cart-section">

<h1>Your Shopping Cart</h1>


<div class="cart-container">


<div class="cart-items">


<?php 

$total = 0;

while($row = $cartItems->fetch_assoc()){

$subtotal = $row['price'] * $row['quantity'];

$total += $subtotal;

?>

<div class="cart-card">


<img src="assests/images/products/<?php echo $row['image']; ?>">


<div class="cart-info">

<h3>
<?php echo $row['name']; ?>
</h3>


<p>
$<?php echo number_format($row['price'],2); ?>
</p>


<div class="quantity">

<a href="cart.php?action=decrease&cart=<?php echo $row['cart_id']; ?>&qty=<?php echo $row['quantity']; ?>">
    -
</a>

<span><?php echo $row['quantity']; ?></span>

<a href="cart.php?action=increase&cart=<?php echo $row['cart_id']; ?>&qty=<?php echo $row['quantity']; ?>">
    +
</a>

</div>


<a href="cart.php?action=remove&cart=<?php echo $row['cart_id']; ?>"
class="cart-remove"
onclick="return confirm('Remove this item from your cart?')">
    Remove
</a>


</div>


</div>


<?php } ?>


</div>


<div class="cart-summary">

<h2>Order Summary</h2>


<p>
Subtotal:
<span>
$<?php echo number_format($total,2); ?>
</span>
</p>


<p>
Shipping:
<span>
$20
</span>
</p>


<hr>


<h3>
Total:
$<?php echo number_format($total + 20,2); ?>
</h3>


<a href="checkout.php" class="checkout-btn">
Proceed To Checkout
</a>


</div>


</div>


</section>

<?php
// Increase Quantity
if (isset($_GET['action']) && $_GET['action'] == "increase") {

    $cart_id = $_GET['cart'];

    $quantity = $_GET['qty'] + 1;

    $cart->updateQuantity($cart_id, $quantity);

    header("Location: cart.php");
    exit();
}

// Decrease Quantity
if (isset($_GET['action']) && $_GET['action'] == "decrease") {

    $cart_id = $_GET['cart'];

    $quantity = $_GET['qty'] - 1;

    if ($quantity < 1) {
        $quantity = 1;
    }

    $cart->updateQuantity($cart_id, $quantity);

    header("Location: cart.php");
    exit();
}

// Remove Item
if (isset($_GET['action']) && $_GET['action'] == "remove") {

    $cart->removeItem($_GET['cart']);

    header("Location: cart.php");
    exit();
}
?>


<?php include "includes/footer.php"; ?>


</body>

</html>