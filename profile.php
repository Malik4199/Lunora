<?php

require "includes/auth_check.php";

require "config/database.php";
require "classes/User.php";

$database = new Database();
$conn = $database->connect();

$user = new User($conn);

$currentUser = $user->getUserById($_SESSION['user_id']);

if(isset($_POST['update'])){

    $fullname = trim($_POST['fullname']);
    $phone = trim($_POST['phone']);

    $image = "";

    if(!empty($_FILES['profile_image']['name'])){

        $image = time() . "_" . $_FILES['profile_image']['name'];

        move_uploaded_file(
            $_FILES['profile_image']['tmp_name'],
            "assests/images/profiles/" . $image
        );

    }

    $user->updateProfile(
        $_SESSION['user_id'],
        $fullname,
        $phone,
        $image
    );

    $_SESSION['fullname'] = $fullname;

    header("Location: profile.php");
    exit();
}
?>

<?php include "includes/navbar.php"; ?>

<!-- PROFILE HERO -->

<section class="profile-hero">

    <div class="profile-hero-content">

        <span>MY ACCOUNT</span>

        <h1>Profile</h1>

        <p>
            Manage your account information, orders and wishlist.
        </p>

    </div>

</section>

<!-- PROFILE -->

<section class="profile-section">

    <!-- Left Side -->

    <div class="profile-card">

        <img src="assests/images/profiles/<?php echo htmlspecialchars($currentUser['profile_image']); ?>" alt="Profile">

        <h2><?php echo htmlspecialchars($currentUser['fullname']); ?></h2>

        <p><?php echo htmlspecialchars($currentUser['email']); ?></p>

        <button type="button" class="edit-profile-section" id="editProfileBtn">Edit Profile</button>

    </div>

    <!-- Right Side -->

    <div class="profile-details">

        <h2>Account Information</h2>

        <div class="detail-box">

            <div>
                <h4>Full Name</h4>
                <p><?php echo htmlspecialchars($currentUser['fullname']); ?></p>
            </div>

            <div>
                <h4>Email</h4>
                <p><?php echo htmlspecialchars($currentUser['email']); ?></p>
            </div>

            <div>
                <h4>Phone</h4>
                <p><?php echo htmlspecialchars($currentUser['phone']); ?></p>
            </div>

            <div>
                <h4>Address</h4>
                <p>Not Added Yet</p>
            </div>

        </div>

        <div class="account-actions">

            <a href="orders.php">
                <i class="fa-solid fa-box"></i>
                My Orders
            </a>

            <a href="wishlist.php">
                <i class="fa-solid fa-heart"></i>
                Wishlist
            </a>

            <a href="#">
                <i class="fa-solid fa-lock"></i>
                Change Password
            </a>

            <a href="logout.php" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </a>

        </div>

    </div>

</section>

<section class="edit-profile-section">

<h2>Edit Profile</h2>

<form method="POST" enctype="multipart/form-data" class="edit-profile-form">

<label>Profile Image</label>

<input type="file" name="profile_image" accept="image/*">

<label>Full Name</label>

<input type="text" name="fullname" value="<?php echo htmlspecialchars($currentUser['fullname']); ?>" required>

<label>Phone Number</label>

<input type="text" name="phone" value="<?php echo htmlspecialchars($currentUser['phone']); ?>">

<button type="submit" name="update">

Save Changes

</button>

</form>

</section>

<?php include "includes/footer.php"; ?>