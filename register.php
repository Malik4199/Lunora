<?php

require "config/database.php";
require "classes/User.php";

$database = new Database();
$conn = $database->connect();

$user = new User($conn);

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    if ($password != $confirmPassword) {

        $message = "Passwords do not match.";

    } else {

        $result = $user->register(
            $fullname,
            $email,
            $phone,
            $password
        );

        if ($result === true) {

            $message = "Registration Successful!";

        } else {

            $message = $result;

        }

    }

}
?>

<?php include "includes/header.php"; ?>

<section class="auth-container">

    <div class="auth-image">

        <img src="assests/images/register-banner.jpg" alt="">

    </div>

    <div class="auth-form">

        <span>CREATE ACCOUNT</span>

        <h2>Join Lunora</h2>

        <p>Create your account and start shopping today.</p>

        <form action="" method="POST">

        <?php if(!empty($message)): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
            <?php endif; ?>
            
            <div class="input-group">
                <label>Full Name</label>
                <input type="text" name="fullname" required>
            </div>

            <div class="input-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>

            <div class="input-group">
                <label>Phone Number</label>
                <input type="text" name="phone">
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="input-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required>
            </div>

            <button type="submit" class="auth-btn">
                Create Account
            </button>

        </form>

        <p class="switch-page">
            Already have an account?
            <a href="login.php">Login</a>
        </p>

    </div>

</section>

<?php include "includes/footer.php"; ?>