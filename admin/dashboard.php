<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: ../login.php");
    exit();
}

require "../config/database.php";
require "../classes/Product.php";
require "../classes/Category.php";
require "../classes/User.php";
require "../classes/Order.php";

$database = new Database();
$conn = $database->connect();

$product = new Product($conn);
$category = new Category($conn);
$user = new User($conn);
$order = new Order($conn);

$totalProducts = $product->countProducts();
$totalCategories = $category->countCategories();
$totalUsers = $user->countUsers();
$totalOrders = $order->countOrders();
$totalRevenue = $order->totalRevenue();
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard</title>

<link rel="stylesheet" href="assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include "includes/sidebar.php"; ?>

<div class="main-content">

<?php include "includes/topbar.php"; ?>

<div class="dashboard-cards">

    <div class="card">
        <i class="fa-solid fa-shirt"></i>
        <h3>Total Products</h3>
        <h2><?php echo $totalProducts; ?></h2>
    </div>

    <div class="card">
        <i class="fa-solid fa-layer-group"></i>
        <h3>Total Categories</h3>
        <h2><?php echo $totalCategories; ?></h2>
    </div>

    <div class="card">
        <i class="fa-solid fa-users"></i>
        <h3>Total Users</h3>
        <h2><?php echo $totalUsers; ?></h2>
    </div>

    <div class="card">
        <i class="fa-solid fa-cart-shopping"></i>
        <h3>Total Orders</h3>
        <h2><?php echo $totalOrders; ?></h2>
    </div>

    <div class="card">
        <i class="fa-solid fa-dollar-sign"></i>
        <h3>Total Revenue</h3>
        <h2>$<?php echo number_format($totalRevenue, 2); ?></h2>
    </div>

</div>

<!-- Recent Orders -->

<div class="recent-orders">

    <h2>Recent Orders</h2>

    <table>

        <thead>

            <tr>

                <th>Order ID</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>

            </tr>

        </thead>

        <tbody>

            <tr>

                <td>#LN1001</td>
                <td>John Doe</td>
                <td>$45.99</td>
                <td><span class="status delivered">Delivered</span></td>

            </tr>

            <tr>

                <td>#LN1002</td>
                <td>Mary James</td>
                <td>$22.99</td>
                <td><span class="status pending">Pending</span></td>

            </tr>

            <tr>

                <td>#LN1003</td>
                <td>David Paul</td>
                <td>$78.99</td>
                <td><span class="status shipping">Shipping</span></td>

            </tr>

        </tbody>

    </table>

</div>

</div>

</body>

</html>