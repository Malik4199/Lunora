<?php

class Wishlist
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Add to wishlist
    public function add($user_id, $product_id)
    {
        $check = $this->conn->prepare("
            SELECT id
            FROM wishlist
            WHERE user_id = ? AND product_id = ?
        ");

        $check->bind_param("ii", $user_id, $product_id);
        $check->execute();

        if ($check->get_result()->num_rows > 0) {
            return false;
        }

        $sql = $this->conn->prepare("
            INSERT INTO wishlist(user_id, product_id)
            VALUES(?, ?)
        ");

        $sql->bind_param("ii", $user_id, $product_id);

        return $sql->execute();
    }

    // Get user's wishlist
    public function getWishlist($user_id)
    {
        $sql = $this->conn->prepare("
            SELECT
                wishlist.id AS wishlist_id,
                products.*
            FROM wishlist
            JOIN products
            ON wishlist.product_id = products.id
            WHERE wishlist.user_id = ?
            ORDER BY wishlist.id DESC
        ");

        $sql->bind_param("i", $user_id);
        $sql->execute();

        return $sql->get_result();
    }

    // Remove item
    public function remove($id)
    {
        $sql = $this->conn->prepare("
            DELETE FROM wishlist
            WHERE id = ?
        ");

        $sql->bind_param("i", $id);

        return $sql->execute();
    }

    // Count wishlist items
    public function countWishlist($user_id)
    {
        $sql = $this->conn->prepare("
            SELECT COUNT(*) AS total
            FROM wishlist
            WHERE user_id = ?
        ");

        $sql->bind_param("i", $user_id);
        $sql->execute();

        $result = $sql->get_result()->fetch_assoc();

        return $result['total'];
    }
}
?>