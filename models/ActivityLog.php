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
}
