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

$orders = $order->getUserOrders($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Orders | Lunora</title>

<link rel="stylesheet" href="assets/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include "includes/navbar.php"; ?>

<section class="orders-page">

<h1>My Orders</h1>

<?php if($orders->num_rows > 0){ ?>

<table class="orders-table">

<thead>

<tr>

<th>Order #</th>

<th>Date</th>

<th>Total</th>

<th>Status</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($row = $orders->fetch_assoc()){ ?>

<tr>

<td>

#LN<?php echo str_pad($row['id'],5,"0",STR_PAD_LEFT); ?>

</td>

<td>

<?php echo date("d M Y", strtotime($row['created_at'])); ?>

</td>

<td>

$<?php echo number_format($row['total_amount'],2); ?>

</td>

<td>

<span class="status <?php echo strtolower($row['order_status']); ?>">

<?php echo htmlspecialchars($row['order_status']); ?>

</span>

</td>

<td>

<a
href="order-details.php?id=<?php echo $row['id']; ?>"
class="view-order-btn">

View Details

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

<?php } else { ?>

<div class="empty-state">

<i class="fa-solid fa-box-open"></i>

<h2>No Orders Yet</h2><br>

<p>

You haven't placed any orders yet.

</p><br><br>

<a href="shop.php" class="shop-btn">

Start Shopping

</a>

</div>

<?php } ?>

</section>

<?php include "includes/footer.php"; ?>

</body>

</html>