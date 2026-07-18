<?php

class User
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Check if email already exists
    public function emailExists($email)
    {
        $sql = "SELECT id FROM users WHERE email = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    // Register User
    public function register($fullname, $email, $phone, $password)
    {
        // Check email
        if ($this->emailExists($email)) {
            return "Email already exists.";
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $role = "user";

        $sql = "INSERT INTO users (fullname, email, phone, password, role)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "sssss",
            $fullname,
            $email,
            $phone,
            $hashedPassword,
            $role
        );

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

// Login User
   public function login($email, $password){
    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            session_start();

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            return $user['role'];

        } else {

            return "Incorrect password.";

        }

    }

    return "Email not found.";
}

// Get all users
public function getUsers()
{
    $sql = "SELECT id, fullname, email, phone, role, created_at
            FROM users
            ORDER BY id DESC";

    return $this->conn->query($sql);
}

// Update user role
public function updateRole($id, $role)
{
    $sql = "UPDATE users SET role = ? WHERE id = ?";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param("si", $role, $id);

    return $stmt->execute();
}

// Delete user
public function deleteUser($id)
{
    $sql = "DELETE FROM users WHERE id = ?";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param("i", $id);

    return $stmt->execute();
}

// Count Users
public function countUsers()
{
    $sql = "SELECT COUNT(*) AS total FROM users";

    $result = $this->conn->query($sql);

    return $result->fetch_assoc()['total'];
}

// Get User by ID
public function getUserById($id)
{
    $sql = "SELECT * FROM users WHERE id = ?";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param("i", $id);

    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}

// Update Profile
public function updateProfile($id, $fullname, $phone, $image)
{
    if (!empty($image)) {

        $sql = "UPDATE users
                SET fullname = ?, phone = ?, profile_image = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "sssi",
            $fullname,
            $phone,
            $image,
            $id
        );

    } else {

        $sql = "UPDATE users
                SET fullname = ?, phone = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ssi",
            $fullname,
            $phone,
            $id
        );

    }

    return $stmt->execute();
}

// Change Password
public function changePassword($id, $newPassword)
{
    $password = password_hash($newPassword, PASSWORD_DEFAULT);

    $sql = "UPDATE users
            SET password = ?
            WHERE id = ?";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param(
        "si",
        $password,
        $id
    );

    return $stmt->execute();
}
}

?>