<?php

class Newsletter
{
    private mysqli $conn;

    public function __construct(mysqli $db)
    {
        $this->conn = $db;
    }

    public function subscribe(string $email)
    {
        $sql = "INSERT IGNORE INTO newsletter(email) VALUES(?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);

        return $stmt->execute();
    }

    public function getSubscribers()
    {
        return $this->conn->query(
            "SELECT * FROM newsletter ORDER BY id DESC"
        );
    }

    public function countSubscribers()
    {
        $result = $this->conn->query(
            "SELECT COUNT(*) AS total FROM newsletter"
        );

        return $result->fetch_assoc()['total'];
    }
}
?>