<?php
// models/Ticket.php

class Ticket {
    private $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function generateNextTicketNumber(): string {
        $result = $this->conn->query(
            "SELECT COUNT(*) as count FROM tickets WHERE DATE(created_at) = CURDATE()"
        );
        $row = $result->fetch_assoc();
        $count = (int) $row['count'];
        return 'TKT-' . str_pad($count + 1, 3, '0', STR_PAD_LEFT);
    }

    public function create(string $fullname, string $phone, string $reason, string $ticketNumber) {
        $stmt = $this->conn->prepare(
            "INSERT INTO tickets (full_name, phone, reason, ticket_number, status)
             VALUES (?, ?, ?, ?, 'waiting')"
        );
        $stmt->bind_param("ssss", $fullname, $phone, $reason, $ticketNumber);
        $stmt->execute();
        return $this->conn->insert_id;
    }

    public function cancel(int $ticketId, ?int $cancelledByUserId = null): void {
        $stmt = $this->conn->prepare("UPDATE tickets SET status = 'no_show', cancelled_by = ? WHERE id = ? AND status = 'waiting'");
        $stmt->bind_param("ii", $cancelledByUserId, $ticketId);
        $stmt->execute();
    }
}
