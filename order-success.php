<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$order_id = $_GET['id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Order Successful</title>

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<?php include "includes/navbar.php"; ?>

<section class="success-page">

    <div class="success-box">

        <h1>🎉 Order Placed Successfully!</h1>

        <p>
            Thank you for shopping with Lunora.
        </p>

        <h2>
            Order #<?php echo $order_id; ?>
        </h2>

        <a href="orders.php" class="success-btn">
            View My Orders
        </a>

    </div>

</section>

<?php include "includes/footer.php"; ?>

</body>

</html>