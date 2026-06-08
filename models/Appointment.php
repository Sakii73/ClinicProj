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
}
