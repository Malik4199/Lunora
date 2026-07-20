<?php

class Cart
{
    private mysqli $conn;

    public function __construct(mysqli $db)
    {
        $this->conn = $db;
    }

    // Check if product already exists in cart
    public function cartItemExists(int $user_id, int $product_id)
    {
        $sql = "SELECT id
                FROM cart
                WHERE user_id = ?
                AND product_id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("ii", $user_id, $product_id);

        $stmt->execute();

        return $stmt->get_result()->num_rows > 0;
    }

    // Add product to cart
    public function addToCart(int $user_id, int $product_id)
    {
        if ($this->cartItemExists($user_id, $product_id)) {

            $sql = "UPDATE cart
                    SET quantity = quantity + 1
                    WHERE user_id = ?
                    AND product_id = ?";

            $stmt = $this->conn->prepare($sql);

            $stmt->bind_param("ii", $user_id, $product_id);

            return $stmt->execute();
        }

        $quantity = 1;

        $sql = "INSERT INTO cart(user_id, product_id, quantity)
                VALUES(?,?,?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "iii",
            $user_id,
            $product_id,
            $quantity
        );

        return $stmt->execute();
    }

    // Get User Cart Items
    public function getCartItems(int $user_id) {
    $sql = "SELECT 
                cart.id AS cart_id,
                cart.quantity,
                products.name,
                products.image,
                products.price
            FROM cart
            JOIN products
            ON cart.product_id = products.id
            WHERE cart.user_id = ?";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param("i", $user_id);

    $stmt->execute();

    return $stmt->get_result();
}

// Update Cart Quantity
public function updateQuantity(int $cart_id, $quantity)
{
    $sql = "UPDATE cart SET quantity = ? WHERE id = ?";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param("ii", $quantity, $cart_id);

    return $stmt->execute();
}

// Remove Cart Item
public function removeItem(int $cart_id)
{
    $sql = "DELETE FROM cart WHERE id = ?";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param("i", $cart_id);

    return $stmt->execute();
}

// Count Cart Items
public function countCart(int $user_id)
{
    $sql = $this->conn->prepare("
        SELECT COUNT(*) AS total
        FROM cart
        WHERE user_id = ?
    ");

    $sql->bind_param("i", $user_id);

    $sql->execute();

    $result = $sql->get_result()->fetch_assoc();

    return $result['total'];
}
}
?>