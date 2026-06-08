<?php
// models/Service.php

class Service {
    private $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function getAll(): array {
        $result = $this->conn->query("SELECT id, name, description FROM services ORDER BY name ASC");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function create(string $name, string $description): int {
        $stmt = $this->conn->prepare("INSERT INTO services (name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $description);
        $stmt->execute();
        return $this->conn->insert_id;
    }
}
