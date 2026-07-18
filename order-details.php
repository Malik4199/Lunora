<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require "config/database.php";
require "classes/Order.php";

$database = new Database();
$conn = $database->connect();

$order = new Order($conn);

if (!isset($_GET['id'])) {
    header("Location: orders.php");
    exit();
}

$order_id = (int) $_GET['id'];

$orderInfo = $order->getOrder($order_id, $_SESSION['user_id']);

if (!$orderInfo) {
    die("Order not found.");
}

$items = $order->getOrderItems($order_id);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Order Details | Lunora</title>

<link rel="stylesheet" href="assests/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include "includes/navbar.php"; ?>

<section class="order-details">

<h1>

Order #LN<?php echo str_pad($orderInfo['id'], 5, "0", STR_PAD_LEFT); ?>

</h1>

<div class="order-summary">

<p>

<strong>Date:</strong>

<?php echo date("d M Y", strtotime($orderInfo['created_at'])); ?>

</p>

<p>

<strong>Status:</strong>

<span class="status <?php echo strtolower($orderInfo['order_status']); ?>">

<?php echo $orderInfo['order_status']; ?>

</span>

</p>

</div>

<table class="orders-table">

<thead>

<tr>

<th>Product</th>

<th>Price</th>

<th>Quantity</th>

<th>Subtotal</th>

</tr>

</thead>

<tbody>

<?php while($item = $items->fetch_assoc()){ ?>

<tr>

<td>

<?php echo htmlspecialchars($item['product_name']); ?>

</td>

<td>

$<?php echo number_format($item['price'],2); ?>

</td>

<td>

<?php echo $item['quantity']; ?>

</td>

<td>

$<?php echo number_format($item['subtotal'],2); ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>
<div class="order-total">

<p>

Shipping Fee

<strong>

$<?php echo number_format($orderInfo['shipping_fee'],2); ?>

</strong>

</p>

<h2>

Grand Total

$<?php echo number_format($orderInfo['total_amount'],2); ?>

</h2>

</div>

</section>

<?php include "includes/footer.php"; ?>

</body>

</html>