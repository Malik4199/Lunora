<?php

class Product
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get all categories
    public function getCategories()
    {
        $sql = "SELECT * FROM categories ORDER BY name ASC";
        return $this->conn->query($sql);
    }

    // Add Product
    public function addProduct($category_id, $name, $description, $price, $stock, $image)
    {
        $sql = "INSERT INTO products
                (category_id, name, description, price, stock, image)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "issdis",
            $category_id,
            $name,
            $description,
            $price,
            $stock,
            $image
        );

        return $stmt->execute();
    }

    // Get all products
    public function getProducts()
    {
        $sql = "SELECT
                    products.*,
                    categories.name AS category_name
                FROM products
                JOIN categories
                ON products.category_id = categories.id
                ORDER BY products.id DESC";

        return $this->conn->query($sql);
    }

    // Get one product
    public function getProduct($id)
    {
        $sql = "SELECT * FROM products WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // Delete product
    public function deleteProduct($id)
    {
        $sql = "DELETE FROM products WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    // Update product
    public function updateProduct($id, $category_id, $name, $description, $price, $stock, $image)
{
    $sql = "UPDATE products
            SET category_id = ?,
                name = ?,
                description = ?,
                price = ?,
                stock = ?,
                image = ?
            WHERE id = ?";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param(
        "issdisi",
        $category_id,
        $name,
        $description,
        $price,
        $stock,
        $image,
        $id
    );

    return $stmt->execute();
}

// Count Products
public function countProducts()
{
    $sql = "SELECT COUNT(*) AS total FROM products";

    $result = $this->conn->query($sql);

    return $result->fetch_assoc()['total'];
}

// Get Products for Shop
public function getShopProducts()
{
    $sql = "SELECT
                products.*,
                categories.name AS category_name
            FROM products
            JOIN categories
            ON products.category_id = categories.id
            ORDER BY products.id DESC";

    return $this->conn->query($sql);
}


// Get one products
public function getSingleProduct($id)
{
    $sql = "SELECT
                products.*,
                categories.name AS category_name
            FROM products
            JOIN categories
            ON products.category_id = categories.id
            WHERE products.id = ?";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param("i", $id);

    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}
}