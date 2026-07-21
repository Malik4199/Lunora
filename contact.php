<?php

session_start();

require "config/database.php";
require "classes/Contact.php";

$database = new Database();
$conn = $database->connect();

$contact = new Contact($conn);

$success = "";

if(isset($_POST['send'])){

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if(
        !empty($fullname) &&
        !empty($email) &&
        !empty($subject) &&
        !empty($message)
    ){

        $contact->sendMessage(
            $fullname,
            $email,
            $subject,
            $message
        );

        $success = "Your message has been sent successfully.";

    }

}
?>

<?php include "includes/navbar.php"; ?>

<!-- Contact Hero -->

<section class="contact-hero">

    <div class="contact-hero-content">

        <span>GET IN TOUCH</span>

        <h1>Contact Us</h1>

        <p>
            We'd love to hear from you. Reach out with any questions, feedback, or support requests.
        </p>

    </div>

</section>

<!-- Contact Section -->

<section class="contact-section">

    <!-- Contact Form -->

    <div class="contact-form">

        <h2>Send Us a Message</h2><br>

        <form method="POST" class="contact-form">
            <?php if(!empty($success)){ ?>
            <div class="success-message">
                <?php echo $success; ?>
            </div>
            <?php } ?>
            
            <input type="text" name="fullname" placeholder="Full Name" required>
            
            <input type="email" name="email" placeholder="Email Address" required>
            
            <input type="text" name="subject" placeholder="Subject" required>
            
            <textarea name="message" rows="6" required placeholder="Your Messages"></textarea>

            <button type="submit" name="send">Send Message</button>
        </form>
    </div>

    <!-- Contact Info -->

    <div class="contact-info">

        <h2>Contact Information</h2>

        <div class="info-box">
            <i class="fa-solid fa-location-dot"></i>
            <div>
                <h4>Address</h4>
                <p>Ibadan, Oyo State, Nigeria</p>
            </div>
        </div>

        <div class="info-box">
            <i class="fa-solid fa-phone"></i>
            <div>
                <h4>Phone</h4>
                <p>+234 906 435 2549</p>
            </div>
        </div>

        <div class="info-box">
            <i class="fa-solid fa-envelope"></i>
            <div>
                <h4>Email</h4>
                <p>support@lunora.com</p>
            </div>
        </div>

        <div class="info-box">
            <i class="fa-solid fa-clock"></i>
            <div>
                <h4>Business Hours</h4>
                <p>Mon - Sat: 9:00 AM - 6:00 PM</p>
            </div>
        </div>

    </div>

</section>

<!-- Map -->

<section class="map-section">

    <iframe
        src="https://www.google.com/maps?q=Osogbo,+Osun+State&output=embed"
        allowfullscreen=""
        loading="lazy">
    </iframe>

</section>

<?php include "includes/footer.php"; ?>