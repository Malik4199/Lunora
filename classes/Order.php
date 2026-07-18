<?php
class Order
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Place Order
    public function placeOrder($user_id, $shipping_fee)
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


        // STEP 3: Calculate Total

        $total = 0;

        while($row = $cartItems->fetch_assoc()){

            $subtotal = $row['price'] * $row['quantity'];

            $total += $subtotal;

        }

        // Reset result pointer

        $cartItems->data_seek(0);


        // STEP 4: Create Order

        $grandTotal = $total + $shipping_fee;

        $sql = "INSERT INTO orders
                (user_id,total_amount,shipping_fee,order_status)
                VALUES(?,?,?,'Pending')";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "idd",
            $user_id,
            $grandTotal,
            $shipping_fee
        );

        $stmt->execute();

        $order_id = $this->conn->insert_id;


        // Save Order Items
        // Deduct Stock
        while($item = $cartItems->fetch_assoc()){

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
            VALUES(?,?,?,?,?,?)";

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


        // STEP 7: Clear Cart

        $sql = "DELETE FROM cart
                WHERE user_id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i",$user_id);

        $stmt->execute();


        // STEP 8: Return Order ID

        return $order_id;

    }


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

    // Update order status
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE orders
                SET status = ?
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

    return $result->fetch_assoc()['total'];
    }

    // Total Revenue
    public function totalRevenue()
    {
    $sql = "SELECT SUM(total_amount) AS revenue FROM orders
            WHERE status='Delivered'";

    $result = $this->conn->query($sql);

    $row = $result->fetch_assoc();

    return $row['revenue'] ?? 0;
}
}

?>