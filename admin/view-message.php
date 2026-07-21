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

if(!isset($_GET['id'])){
    header("Location: messages.php");
    exit();
}

$id = (int)$_GET['id'];

// Mark message as read
$contact->markAsRead($id);

// Get message
$message = $contact->getMessage($id);

if(!$message){
    header("Location: messages.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>View Message</title>

<link rel="stylesheet" href="assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include "includes/sidebar.php"; ?>

<div class="main-content">

<?php include "includes/topbar.php"; ?>

<div class="message-card">

<h1>Customer Message</h1>

<div class="message-info">

<p>
<strong>Full Name:</strong>
<?php echo htmlspecialchars($message['fullname']); ?>
</p>

<p>
<strong>Email:</strong>
<?php echo htmlspecialchars($message['email']); ?>
</p>

<p>
<strong>Subject:</strong>
<?php echo htmlspecialchars($message['subject']); ?>
</p>

<p>
<strong>Date:</strong>
<?php echo date("d M Y h:i A", strtotime($message['created_at'])); ?>
</p>

<p>
<strong>Status:</strong>

<span class="status <?php echo strtolower($message['status']); ?>">

<?php echo $message['status']; ?>

</span>

</p>

</div>

<div class="message-body">

<h3>Message</h3>

<p>

<?php echo nl2br(htmlspecialchars($message['message'])); ?>

</p>

</div>

<div class="message-actions">

<a href="messages.php" class="back-btn">

<i class="fa-solid fa-arrow-left"></i>

Back

</a>

<a
href="messages.php?delete=<?php echo $message['id']; ?>"
class="delete-btn"
onclick="return confirm('Delete this message?')">

<i class="fa-solid fa-trash"></i>

Delete

</a>

</div>

</div>

</div>

</body>

</html>