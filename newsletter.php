<?php
require "config/database.php";
require "classes/Newsletter.php";

$database = new Database();

$conn = $database->connect();


$newsletter = new Newsletter($conn);

if(isset($_POST['subscribe'])){
    $email = trim($_POST['email']);

    if(empty($email)){
        header("Location: dashboard.php?newsletter=empty");
        exit();
    }

    $result = $newsletter->subscribe($email);
    if($result === true){
        header("Location: dashboard.php?newsletter=success");
    }else{
        header("Location: dashboard.php?newsletter=".$result);
    }
    exit();
}

?>