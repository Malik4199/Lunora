<?php require "includes/auth_check.php"; ?>

<?php include "includes/navbar.php"; ?>

<!-- ORDERS HERO -->

<section class="orders-hero">

    <div class="orders-hero-content">

        <span>ORDER HISTORY</span>

        <h1>My Orders</h1>

        <p>Track your purchases and view your previous orders.</p>

    </div>

</section>

<!-- ORDERS -->

<section class="orders-section">

    <div class="section-title">

        <h2>Recent Orders</h2>

        <span>3 Orders</span>

    </div>

    <div class="orders-table">

        <table>

            <thead>

                <tr>

                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Delivery</th>
                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>#LN1001</td>
                    <td>16 Jul 2026</td>
                    <td>$65.99</td>

                    <td>
                        <span class="paid">
                            Paid
                        </span>
                    </td>

                    <td>
                        <span class="delivered">
                            Delivered
                        </span>
                    </td>

                    <td>
                        <a href="#" class="view-btn">
                            View Details
                        </a>
                    </td>

                </tr>

                <tr>

                    <td>#LN1002</td>
                    <td>12 Jul 2026</td>
                    <td>$42.99</td>

                    <td>
                        <span class="paid">
                            Paid
                        </span>
                    </td>

                    <td>
                        <span class="shipping">
                            Shipping
                        </span>
                    </td>

                    <td>
                        <a href="#" class="view-btn">
                            View Details
                        </a>
                    </td>

                </tr>

                <tr>

                    <td>#LN1003</td>
                    <td>08 Jul 2026</td>
                    <td>$28.99</td>

                    <td>
                        <span class="pending">
                            Pending
                        </span>
                    </td>

                    <td>
                        <span class="processing">
                            Processing
                        </span>
                    </td>

                    <td>
                        <a href="#" class="view-btn">
                            View Details
                        </a>
                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</section>

<?php include "includes/footer.php"; ?>