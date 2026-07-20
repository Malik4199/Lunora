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
$recentOrders = $order->getRecentOrders();
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

<div class="dashboard-actions">

<a href="add-product.php" class="action-btn">
<i class="fa-solid fa-plus"></i>
Add Product
</a>

<a href="categories.php" class="action-btn">
<i class="fa-solid fa-layer-group"></i>
Categories
</a>

<a href="orders.php" class="action-btn">
<i class="fa-solid fa-box"></i>
Manage Orders
</a>

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

            <tbody>
                <?php while($row = $recentOrders->fetch_assoc()){ ?>
                <tr>
                    <td>#LN<?php echo str_pad($row['id'],5,"0",STR_PAD_LEFT); ?></td>
                    <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                    <td>$<?php echo number_format($row['total_amount'],2); ?></td>
                    <td>
                        <span class="status <?php echo strtolower($row['order_status']); ?>"></span>
                        <?php echo $row['order_status']; ?></span>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</body>

</html>