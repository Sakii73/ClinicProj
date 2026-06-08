<?php
// models/User.php

class User {
    private $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function findByUsername(string $username) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: false;
    }

    public function markOnline(int $userId, bool $isOnline): void {
        $stmt = $this->conn->prepare("UPDATE users SET is_online = ? WHERE id = ?");
        $onlineInt = $isOnline ? 1 : 0;
        $stmt->bind_param("ii", $onlineInt, $userId);
        $stmt->execute();
    }

    public function create(string $username, string $fullname, int $age, string $passwordHash, string $role) {
        $stmt = $this->conn->prepare(
            "INSERT INTO users (username, full_name, age, password, role) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("ssiss", $username, $fullname, $age, $passwordHash, $role);
        $stmt->execute();
        return $this->conn->insert_id;
    }
}
