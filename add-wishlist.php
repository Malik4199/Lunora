<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require "config/database.php";
require "classes/Wishlist.php";

$database = new Database();
$conn = $database->connect();

$wishlist = new Wishlist($conn);

if (isset($_GET['id'])) {

    $product_id = (int) $_GET['id'];

    $wishlist->add($_SESSION['user_id'], $product_id);
}

header("Location: wishlist.php");
exit();

?>