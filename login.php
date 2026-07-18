<?php

require "config/database.php";
require "classes/User.php";

$database = new Database();
$conn = $database->connect();

$user = new User($conn);

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $result = $user->login($email, $password);

    if ($result == "admin") {

        header("Location: admin/dashboard.php");
        exit();

    } elseif ($result == "user") {

        header("Location: dashboard.php");
        exit();

    } else {

        $message = $result;

    }

}
?>

<?php include "includes/header.php"; ?>

<section class="auth-container">

    <div class="auth-image">

        <img src="assests/images/login-banner.jpg" alt="">

    </div>

    <div class="auth-form">

        <span>WELCOME BACK</span>

        <h2>Login to Lunora</h2>

        <p>Sign in to continue shopping your favorite styles.</p>

        <form action="" method="POST">

        <?php if(!empty($message)): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
            <div class="input-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="remember">

                <label>
                    <input type="checkbox">
                    Remember Me
                </label>

                <a href="#">Forgot Password?</a>

            </div>

            <button type="submit" class="auth-btn">
                Login
            </button>

        </form>

        <p class="switch-page">
            Don't have an account?
            <a href="register.php">Create Account</a>
        </p>

    </div>

</section>

<?php include "includes/footer.php"; ?>