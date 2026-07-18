<?php

session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}


require "../config/database.php";
require "../classes/Category.php";


$database = new Database();

$conn = $database->connect();


$category = new Category($conn);


// Add Category

if(isset($_POST['add'])){

    $name = $_POST['name'];

    $category->addCategory($name);

    header("Location: categories.php");

}


// Delete Category

if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    $category->deleteCategory($id);

    header("Location: categories.php");

}


$categories = $category->getCategories();


?>


<!DOCTYPE html>

<html>

<head>

<title>Categories</title>

<link rel="stylesheet" href="assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>


<body>


<?php include "includes/sidebar.php"; ?>


<div class="main-content">


<?php include "includes/topbar.php"; ?>

<br><br>
<h1>Manage Categories</h1>


<!-- Add Category -->

<div class="category-form">


<form method="POST">

<input 
type="text" 
name="name" 
placeholder="Category Name"
required>


<button name="add">
Add Category
</button>


</form>


</div>



<!-- Category Table -->


<div class="recent-orders">


<table>


<thead>

<tr>

<th>ID</th>

<th>Name</th>

<th>Action</th>

</tr>

</thead>


<tbody>


<?php while($row = $categories->fetch_assoc()){ ?>


<tr>

<td>
<?php echo $row['id']; ?>
</td>


<td>
<?php echo $row['name']; ?>
</td>


<td>

<a href="categories.php?delete=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this category?')">

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