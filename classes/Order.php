<?php

class Order
{
    private mysqli $conn;

    public function __construct(mysqli $db)
    {
        $this->conn = $db;
    }

    // Place Order
    public function placeOrder(int $user_id, int $shipping_fee)
    {
        // Get User Cart Items
        $sql = "SELECT
                    cart.*,
                    products.name,
                    products.price,
                    products.stock
                FROM cart
                JOIN products
                ON cart.product_id = products.id
                WHERE cart.user_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        $cartItems = $stmt->get_result();

        // Calculate Total
        $total = 0;

        while ($row = $cartItems->fetch_assoc()) {
            $subtotal = $row['price'] * $row['quantity'];
            $total += $subtotal;
        }

        // Reset pointer
        $cartItems->data_seek(0);

        // Create Order
        $grandTotal = $total + $shipping_fee;

        $sql = "INSERT INTO orders
                (user_id, total_amount, shipping_fee, order_status)
                VALUES (?, ?, ?, 'Pending')";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "idd",
            $user_id,
            $grandTotal,
            $shipping_fee
        );

        $stmt->execute();

        $order_id = $this->conn->insert_id;

        // Save Order Items & Deduct Stock
        while ($item = $cartItems->fetch_assoc()) {

            $subtotal = $item['price'] * $item['quantity'];

            $sql = "INSERT INTO order_items
                    (
                        order_id,
                        product_id,
                        product_name,
                        price,
                        quantity,
                        subtotal
                    )
                    VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param(
                "iisdid",
                $order_id,
                $item['product_id'],
                $item['name'],
                $item['price'],
                $item['quantity'],
                $subtotal
            );

            $stmt->execute();

            // Deduct Stock
            $sql = "UPDATE products
                    SET stock = stock - ?
                    WHERE id = ?";

            $update = $this->conn->prepare($sql);

            $update->bind_param(
                "ii",
                $item['quantity'],
                $item['product_id']
            );

            $update->execute();
        }

        // Clear Cart
        $sql = "DELETE FROM cart WHERE user_id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $user_id);

        $stmt->execute();

        return $order_id;
    }

    // Get User Orders
    public function getUserOrders(int $user_id)
    {
        $sql = "SELECT *
                FROM orders
                WHERE user_id = ?
                ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $user_id);

        $stmt->execute();

        return $stmt->get_result();
    }

    // Get Items for One Order
    public function getOrderItems(int $order_id)
    {
        $sql = "SELECT *
                FROM order_items
                WHERE order_id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $order_id);

        $stmt->execute();

        return $stmt->get_result();
    }

    // Get All Orders (Admin)
    public function getOrders()
    {
        $sql = "SELECT
                    orders.*,
                    users.fullname
                FROM orders
                JOIN users
                ON orders.user_id = users.id
                ORDER BY orders.id DESC";

        return $this->conn->query($sql);
    }

    // Update Order Status
    public function updateStatus(int $id, string $status)
    {
        $sql = "UPDATE orders
                SET order_status = ?
                WHERE id = ?";

                $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("si", $status, $id);

        return $stmt->execute();
    }

    // Count Orders
    public function countOrders()
    {
        $sql = "SELECT COUNT(*) AS total FROM orders";

        $result = $this->conn->query($sql);

        $row = $result->fetch_assoc();

        return $row['total'];
    }

    // Total Revenue
    public function totalRevenue()
    {
        $sql = "SELECT SUM(total_amount) AS revenue
                FROM orders
                WHERE order_status = 'Delivered'";

        $result = $this->conn->query($sql);

        $row = $result->fetch_assoc();

        return $row['revenue'] ?? 0;
    }

    // Get Single Order
    public function getOrder(int $order_id, int $user_id)
    {
        $sql = "SELECT *
            FROM orders
            WHERE id = ?
            AND user_id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("ii", $order_id, $user_id);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    public function getRecentOrders($limit = 5)
    {
    $sql = "SELECT
                orders.*,
                users.fullname
            FROM orders
            JOIN users
            ON orders.user_id = users.id
            ORDER BY orders.created_at DESC
            LIMIT ?";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $limit);
    $stmt->execute();

    return $stmt->get_result();
}
}

?>