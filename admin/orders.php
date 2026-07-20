<?php

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: ../login.php");
    exit();
}

require "../config/database.php";
require "../classes/Order.php";

$database = new Database();
$conn = $database->connect();

$order = new Order($conn);

if(isset($_POST['update'])){

    $order->updateStatus(
        $_POST['id'],
        $_POST['status']
    );

    header("Location: orders.php");
    exit();
}

$orders = $order->getOrders();

?>

<!DOCTYPE html>

<html>

<head>

<title>Orders</title>

<link rel="stylesheet" href="assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include "includes/sidebar.php"; ?>

<div class="main-content">

<?php include "includes/topbar.php"; ?>

<br><br>
<h1>Manage Orders</h1>

<div class="recent-orders">

<table>

<thead>

<tr>

<th>ID</th>
<th>Customer</th>
<th>Total</th>
<th>Status</th>
<th>Date</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($row = $orders->fetch_assoc()){ ?>

<tr>

<td>#<?php echo $row['id']; ?></td>

<td><?php echo htmlspecialchars($row['fullname']); ?></td>

<td>$<?php echo number_format($row['total_amount'],2); ?></td>

<td><?php echo htmlspecialchars($row['order_status']); ?></td>

<td><?php echo $row['created_at']; ?></td>

<td>

<form method="POST">

<input
type="hidden"
name="id"
value="<?php echo $row['id']; ?>">

<select name="status">

<option value="Pending">Pending</option>

<option value="Processing">Processing</option>

<option value="Shipped">Shipped</option>

<option value="Delivered">Delivered</option>

<option value="Cancelled">Cancelled</option>

</select>

<button name="update">

Update

</button>

</form>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</body>

</html>