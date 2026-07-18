<?php

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: ../login.php");
    exit();
}

require "../config/database.php";
require "../classes/Product.php";

$database = new Database();
$conn = $database->connect();

$product = new Product($conn);

// Delete Product
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    $product->deleteProduct($id);

    header("Location: products.php");
    exit();
}

// Fetch Products
$products = $product->getProducts();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Manage Products</title>

<link rel="stylesheet" href="assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include "includes/sidebar.php"; ?>

<div class="main-content">

<?php include "includes/topbar.php"; ?>

<br><br>
<h1>Manage Products</h1>

<a href="add-product.php" class="add-btn">
    <i class="fa-solid fa-plus"></i>
    Add New Product
</a>

<div class="recent-orders">

<table>

<thead>

<tr>

<th>ID</th>
<th>Image</th>
<th>Name</th>
<th>Category</th>
<th>Price</th>
<th>Stock</th>
<th>Actions</th>

</tr>

</thead>

<tbody>

<?php while($row = $products->fetch_assoc()){ ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td>
    <img src="../assets/images/products/<?php echo $row['image']; ?>" width="70">
</td>

<td><?php echo htmlspecialchars($row['name']); ?></td>

<td><?php echo htmlspecialchars($row['category_name']); ?></td>

<td>$<?php echo number_format($row['price'], 2); ?></td>

<td><?php echo $row['stock']; ?></td>

<td>

<a href="edit-product.php?id=<?php echo $row['id']; ?>">

<i class="fa-solid fa-pen-to-square"></i>

</a>

&nbsp;&nbsp;

<a href="products.php?delete=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this product?')">

<i class="fa-solid fa-trash"></i>

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</body>

</html>