<?php
// models/ActivityLog.php

class ActivityLog {
    private $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function log(string $description): void {
        $stmt = $this->conn->prepare("INSERT INTO activity_log (description) VALUES (?)");
        $stmt->bind_param("s", $description);
        $stmt->execute();
    }

    public function getRecent(int $limit = 5): array {
        $stmt = $this->conn->prepare("SELECT description, logged_at FROM activity_log ORDER BY logged_at DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
