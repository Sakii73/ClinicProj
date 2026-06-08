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

    public function findById(int $id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: false;
    }

    public function deleteById(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getPatientList(): array {
        $result = $this->conn->query("SELECT id, username, full_name, age, is_online FROM users WHERE role = 'patient' ORDER BY full_name ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getStaffList(): array {
        $result = $this->conn->query("SELECT id, full_name, role, is_online FROM users WHERE role IN ('doctor','admin') ORDER BY full_name ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countOnlineStaff(): int {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM users WHERE role IN ('doctor','admin') AND is_online = 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return (int) ($row['count'] ?? 0);
    }
}
