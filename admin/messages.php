<?php

session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}

require "../config/database.php";
require "../classes/Contact.php";

$database = new Database();
$conn = $database->connect();

$contact = new Contact($conn);

// Delete Message
if(isset($_GET['delete'])){

    $contact->deleteMessage((int)$_GET['delete']);

    header("Location: messages.php");
    exit();
}

$messages = $contact->getMessages();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Messages</title>

<link rel="stylesheet" href="assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include "includes/sidebar.php"; ?>

<div class="main-content">

<?php include "includes/topbar.php"; ?>

<br><br><h1>Customer Messages</h1>

<table class="admin-table">

<thead>

<tr>

<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Subject</th>
<th>Status</th>
<th>Date</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($row = $messages->fetch_assoc()){ ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo htmlspecialchars($row['fullname']); ?></td>

<td><?php echo htmlspecialchars($row['email']); ?></td>

<td><?php echo htmlspecialchars($row['subject']); ?></td>

<td>

<span class="status <?php echo strtolower($row['status']); ?>">

<?php echo $row['status']; ?>

</span>

</td>

<td>

<?php echo date("d M Y",strtotime($row['created_at'])); ?>

</td>

<td>

<a href="view-message.php?id=<?php echo $row['id']; ?>">

View

</a>

|

<a

href="messages.php?delete=<?php echo $row['id']; ?>"

onclick="return confirm('Delete this message?')">

Delete

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</body>

</html>