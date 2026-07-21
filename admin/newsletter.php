<?php

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: ../login.php");
    exit();
}

require "../config/database.php";
require "../classes/Newsletter.php";

$database = new Database();
$conn = $database->connect();

$newsletter = new Newsletter($conn);

$subscribers = $newsletter->getSubscribers();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Newsletter Subscribers</title>

<link rel="stylesheet" href="assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include "includes/sidebar.php"; ?>

<div class="main-content">

<?php include "includes/topbar.php"; ?><br>

<h1>Newsletter Subscribers</h1>

<table class="admin-table">

<thead>

<tr>

<th>ID</th>
<th>Email</th>
<th>Subscribed On</th>

</tr>

</thead>

<tbody>

<?php while($row = $subscribers->fetch_assoc()){ ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo htmlspecialchars($row['email']); ?></td>

<td><?php echo date("d M Y",strtotime($row['created_at'])); ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</body>

</html>