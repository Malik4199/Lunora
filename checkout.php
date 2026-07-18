<?php

session_start();

if(!isset($_SESSION['user_id'])){

    header("Location: login.php");

    exit();

}

require "config/database.php";
require "classes/Cart.php";
require "classes/Order.php";

$database = new Database();

$conn = $database->connect();

$cart = new Cart($conn);

$order = new Order($conn);

$cartItems = $cart->getCartItems($_SESSION['user_id']);

$total = 0;

$shipping = 20;

if (isset($_POST['placeOrder'])) {

    $order_id = $order->placeOrder(
        $_SESSION['user_id'],
        $shipping
    );

    header("Location: order-success.php?id=" . $order_id);
    exit();
}

while($row = $cartItems->fetch_assoc()){

    $subtotal = $row['price'] * $row['quantity'];

    $total += $subtotal;

}
?>

<!DOCTYPE html>

<html>

<head>

<title>Checkout</title>

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<?php include "includes/navbar.php"; ?>

<section class="checkout-page">
    <div class="checkout-form">

<h2>Billing Details</h2>
<br><br>

<form method="POST">

<label>Full Name</label>

<input
type="text"
name="fullname"
required>

<label>Email</label>

<input
type="email"
name="email"
required>

<label>Phone</label>

<input
type="text"
name="phone"
required>

<label>Delivery Address</label>

<textarea
name="address"
rows="5"
required></textarea>

<div class="order-summary">

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

$<?php echo number_format($shipping,2); ?>

</span>

</p>

<hr>

<h3>

Total

<span>

$<?php echo number_format($total+$shipping,2); ?>

</span>

</h3>

<button name="placeOrder">

Place Order

</button>

</div>

</form>

</div>