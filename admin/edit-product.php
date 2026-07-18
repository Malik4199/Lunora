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

// Get Product ID
if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$id = $_GET['id'];

$productData = $product->getProduct($id);

$categories = $product->getCategories();

if (isset($_POST['update'])) {

    $category_id = $_POST['category_id'];
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $image = $productData['image'];

    if (!empty($_FILES['image']['name'])) {

        $image = $_FILES['image']['name'];

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../assets/images/products/" . $image
        );
    }

    $product->updateProduct(
        $id,
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

<title>Edit Product</title>

<link rel="stylesheet" href="assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include "includes/sidebar.php"; ?>

<div class="main-content">

<?php include "includes/topbar.php"; ?>

<br><br>
<h1>Edit Product</h1>

<div class="product-form">

<form method="POST" enctype="multipart/form-data">
    <label>Category</label>

<select name="category_id">

<?php while($row = $categories->fetch_assoc()){ ?>

<option
value="<?php echo $row['id']; ?>"
<?php if($row['id'] == $productData['category_id']) echo "selected"; ?>>

<?php echo htmlspecialchars($row['name']); ?>

</option>

<?php } ?>

</select>


<label>Product Name</label>

<input
type="text"
name="name"
value="<?php echo htmlspecialchars($productData['name']); ?>"
required>


<label>Description</label>

<textarea
name="description"
rows="5"><?php echo htmlspecialchars($productData['description']); ?></textarea>


<label>Price</label>

<input
type="number"
step="0.01"
name="price"
value="<?php echo $productData['price']; ?>"
required>


<label>Stock</label>

<input
type="number"
name="stock"
value="<?php echo $productData['stock']; ?>"
required>


<label>Current Image</label>

<br>

<img
src="../assets/images/products/<?php echo htmlspecialchars($productData['image']); ?>"
width="120">

<br><br>

<label>Change Image</label>

<input
type="file"
name="image"
accept="image/*">


<button type="submit" name="update">

<i class="fa-solid fa-floppy-disk"></i>

Update Product

</button>

</form>

</div>

</div>

</body>

</html>