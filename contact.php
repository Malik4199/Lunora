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

        <h2>Send Us a Message</h2>

        <form action="#" method="POST">

            <input type="text" name="name" placeholder="Full Name" required>

            <input type="email" name="email" placeholder="Email Address" required>

            <input type="text" name="subject" placeholder="Subject">

            <textarea name="message" rows="6" placeholder="Your Message" required></textarea>

            <button type="submit">Send Message</button>

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