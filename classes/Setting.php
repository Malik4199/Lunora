<?php

class Setting
{
    private mysqli $conn;

    public function __construct(mysqli $db)
    {
        $this->conn = $db;
    }

    public function getSettings()
    {
        return $this->conn
            ->query("SELECT * FROM settings LIMIT 1")
            ->fetch_assoc();
    }

    public function updateSettings(
        string $name,
        string $email,
        string $phone,
        string $address,
        float $shipping
    ): bool {

        $sql="UPDATE settings
              SET
              store_name=?,
              store_email=?,
              store_phone=?,
              store_address=?,
              shipping_fee=?
              WHERE id=1";

        $stmt=$this->conn->prepare($sql);

        $stmt->bind_param(
            "ssssd",
            $name,
            $email,
            $phone,
            $address,
            $shipping
        );

        return $stmt->execute();
    }
}
?>