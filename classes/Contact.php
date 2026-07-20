<?php

use Dom\Mysql;

class Contact
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Save Message
    public function sendMessage(string $fullname, string $email, string $subject, string $message)
    {
        $sql = "INSERT INTO contact_messages
                (fullname,email,subject,message)
                VALUES(?,?,?,?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ssss",
            $fullname,
            $email,
            $subject,
            $message
        );

        return $stmt->execute();
    }

    // Get All Messages
    public function getMessages()
    {
        $sql = "SELECT *
                FROM contact_messages
                ORDER BY created_at DESC";

        return $this->conn->query($sql);
    }

    // Get One Message
    public function getMessage(int $id)
    {
        $sql = "SELECT *
                FROM contact_messages
                WHERE id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i",$id);

        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    // Mark as Read
    public function markAsRead(int $id)
    {
        $sql = "UPDATE contact_messages
                SET status='Read'
                WHERE id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i",$id);

        return $stmt->execute();
    }

    // Delete Message
    public function deleteMessage(int $id)
    {
        $sql = "DELETE FROM contact_messages
                WHERE id=?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i",$id);

        return $stmt->execute();
    }

    // Count Messages
    public function countMessages()
    {
        $result = $this->conn->query(
            "SELECT COUNT(*) AS total
             FROM contact_messages"
        );

        return $result->fetch_assoc()['total'];
    }

    // Count Unread
    public function countUnread()
    {
        $result = $this->conn->query(
            "SELECT COUNT(*) AS total
             FROM contact_messages
             WHERE status='Unread'"
        );

        return $result->fetch_assoc()['total'];
    }
}

?>