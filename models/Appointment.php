<?php
// models/Appointment.php

class Appointment {
    private $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function create(?int $patientId, string $fullname, string $phone, string $date, string $reason) {
        $stmt = $this->conn->prepare(
            "INSERT INTO appointments (patient_id, full_name, phone, appt_date, reason, status)
             VALUES (?, ?, ?, ?, ?, 'pending')"
        );
        $stmt->bind_param("issss", $patientId, $fullname, $phone, $date, $reason);
        $stmt->execute();
        return $this->conn->insert_id;
    }

    public function getAll(): array {
        $result = $this->conn->query("SELECT * FROM appointments ORDER BY appt_date ASC, created_at ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCountByStatus(string $status): int {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM appointments WHERE status = ?");
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return (int) ($row['count'] ?? 0);
    }

    public function confirm(int $appointmentId): void {
        $stmt = $this->conn->prepare("UPDATE appointments SET status = 'confirmed' WHERE id = ? AND status = 'pending'");
        $stmt->bind_param("i", $appointmentId);
        $stmt->execute();
    }

    public function cancel(int $appointmentId): void {
        $stmt = $this->conn->prepare("UPDATE appointments SET status = 'cancelled' WHERE id = ? AND status != 'cancelled'");
        $stmt->bind_param("i", $appointmentId);
        $stmt->execute();
    }
}
