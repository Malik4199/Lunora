<?php

class Product
{
    private mysqli $conn;

    public function __construct(mysqli $db)
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
    public function addProduct(
        int $category_id,
        string $name,
        string $description,
        float $price,
        int $stock,
        string $image
    )
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
                    categories.name AS category_name,
                    ROUND(AVG(reviews.rating),1) AS rating
                FROM products
                JOIN categories
                ON products.category_id = categories.id
                LEFT JOIN reviews
                ON products.id = reviews.product_id
                GROUP BY products.id
                ORDER BY products.id DESC";

        return $this->conn->query($sql);
    }

    // Get one product
    public function getProduct(int $id)
    {
        $sql = "SELECT * FROM products WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // Delete product
    public function deleteProduct(int $id)
    {
        $sql = "DELETE FROM products WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    // Update product
    public function updateProduct(
        int $id,
        int $category_id,
        string $name,
        string $description,
        float $price,
        int $stock,
        string $image
    )
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

    // Shop Products
    public function getShopProducts()
    {
        $sql = "SELECT
                    products.*,
                    categories.name AS category_name,
                    ROUND(AVG(reviews.rating),1) AS rating
                FROM products
                JOIN categories
                ON products.category_id = categories.id
                LEFT JOIN reviews
                ON products.id = reviews.product_id
                GROUP BY products.id
                ORDER BY products.id DESC";

        return $this->conn->query($sql);
    }

    // Single Product
    public function getSingleProduct(int $id)
    {
        $sql = "SELECT
                    products.*,
                    categories.name AS category_name, 
                    ROUND(AVG(reviews.rating),1) AS rating
                FROM products
                JOIN categories
                ON products.category_id = categories.id
                LEFT JOIN reviews
                ON products.id = reviews.product_id
                WHERE products.id = ?
                GROUP BY products.id";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // Search Products
    public function searchProducts($search = "", $category = "", $sort = "")
    {
        $sql = "SELECT
                    products.*,
                    categories.name AS category_name,
                    ROUND(AVG(reviews.rating),1) AS rating
                FROM products
                JOIN categories
                ON products.category_id = categories.id
                LEFT JOIN reviews
                ON products.id = reviews.product_id
                WHERE 1";

        if (!empty($search)) {

            $search = $this->conn->real_escape_string($search);

            $sql .= " AND products.name LIKE '%$search%'";
        }

        if (!empty($category)) {

            $category = (int)$category;

            $sql .= " AND products.category_id = $category";
        }

        $sql .= " GROUP BY products.id";

        switch ($sort) {

            case "low-high":
                $sql .= " ORDER BY products.price ASC";
                break;

            case "high-low":
                $sql .= " ORDER BY products.price DESC";
                break;

            case "name":
                $sql .= " ORDER BY products.name ASC";
                break;

            default:
                $sql .= " ORDER BY products.id DESC";
        }

        return $this->conn->query($sql);
    }

    // Products By Category
    public function getProductsByCategory($category_id = "")
    {
        $sql = "SELECT
                    products.*,
                    categories.name AS category_name,
                    ROUND(AVG(reviews.rating),1) AS rating
                FROM products
                JOIN categories
                ON products.category_id = categories.id
                LEFT JOIN reviews
                ON products.id = reviews.product_id";

        if (!empty($category_id)) {

            $category_id = (int)$category_id;

            $sql .= " WHERE products.category_id = $category_id";
        }

        $sql .= " GROUP BY products.id";
        $sql .= " ORDER BY products.id DESC";

        return $this->conn->query($sql);
    }
}

?>