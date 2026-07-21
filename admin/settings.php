<?php

session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {
    header("Location: ../login.php");
    exit();
}

require "../config/database.php";
require "../classes/Setting.php";

$database = new Database();
$conn = $database->connect();

$setting = new Setting($conn);

$message = "";

if(isset($_POST['update'])){

    $store_name = trim($_POST['store_name']);
    $store_email = trim($_POST['store_email']);
    $store_phone = trim($_POST['store_phone']);
    $store_address = trim($_POST['store_address']);
    $shipping_fee = $_POST['shipping_fee'];

    if($setting->updateSettings(
        $store_name,
        $store_email,
        $store_phone,
        $store_address,
        $shipping_fee
    )){
        $message = "Settings updated successfully.";
    }else{
        $message = "Unable to update settings.";
    }

}

$data = $setting->getSettings();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Store Settings</title>

<link rel="stylesheet" href="assets/css/admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<?php include "includes/sidebar.php"; ?>

<div class="main-content">

<?php include "includes/topbar.php"; ?>

<div class="page-header"><br>

<h1>Store Settings</h1>

<p>Manage your Lunora store information.</p>

</div>

<?php if(!empty($message)){ ?>

<div class="success-message">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST" class="settings-form">

<div class="form-group">

<label>Store Name</label>

<input
type="text"
name="store_name"
value="<?php echo htmlspecialchars($data['store_name']); ?>"
required>

</div>

<div class="form-group">

<label>Store Email</label>

<input
type="email"
name="store_email"
value="<?php echo htmlspecialchars($data['store_email']); ?>"
required>

</div>

<div class="form-group">

<label>Store Phone</label>

<input
type="text"
name="store_phone"
value="<?php echo htmlspecialchars($data['store_phone']); ?>"
required>

</div>

<div class="form-group">

<label>Store Address</label>

<textarea
name="store_address"
rows="4"
required><?php echo htmlspecialchars($data['store_address']); ?></textarea>

</div>

<div class="form-group">

<label>Shipping Fee ($)</label>

<input
type="number"
step="0.01"
name="shipping_fee"
value="<?php echo $data['shipping_fee']; ?>" required>
</div>

<button type="submit" name="update" class="save-btn">
<i class="fa-solid fa-floppy-disk"></i>
Save Settings
</button>

</form>
</div>
</body>

</html>