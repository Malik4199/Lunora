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

$categories = $product->getCategories();

if (isset($_POST['save'])) {

    $category_id = $_POST['category_id'];
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file(
        $tmp,
        "../assets/images/products/" . $image
    );

    $product->addProduct(
        $category_id,
        $name,
        $description,
        $price,
        $stock,
        $image
    );

    header("Location: products.php");
    exit();
}

?>

<!DOCTYPE html>

<html>

<head>

<title>Add Product</title>

<link rel="stylesheet" href="assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include "includes/sidebar.php"; ?>

<div class="main-content">

<?php include "includes/topbar.php"; ?>

<br><br>
<h1>Add New Product</h1>


<div class="product-form">
<form method="POST" enctype="multipart/form-data">

<label>Category</label>
<select name="category_id" required>
<option value="">Select Category</option>

<?php while($row = $categories->fetch_assoc()){ ?>

<option value="<?php echo $row['id']; ?>">

<?php echo htmlspecialchars($row['name']); ?>

</option>

<?php } ?>

</select>


<label>Product Name</label>
<input type="text" name="name" required>

<label>Description</label>
<textarea name="description" rows="5" required></textarea>

<label>Price</label>
<input type="number" step="0.01" name="price" required>

<label>Stock Quantity</label>
<input type="number" name="stock" required>

<label>Product Image</label>
<input type="file" name="image" accept="image/*" required>


<button type="submit" name="save">
<i class="fa-solid fa-floppy-disk"></i>
Save Product
</button>

</form>

</div>

</div>

</body>

</html>