<?php

class Category
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    // Add Category
    public function addCategory($name)
    {
        $sql = "INSERT INTO categories(name) VALUES(?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("s", $name);

        return $stmt->execute();
    }


    // Get All Categories
    public function getCategories()
    {
        $sql = "SELECT * FROM categories ORDER BY id DESC";

        $result = $this->conn->query($sql);

        return $result;
    }


    // Delete Category
    public function deleteCategory($id)
    {
        $sql = "DELETE FROM categories WHERE id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }

    // Count Categories
public function countCategories()
{
    $sql = "SELECT COUNT(*) AS total FROM categories";

    $result = $this->conn->query($sql);

    return $result->fetch_assoc()['total'];
}

}

?>