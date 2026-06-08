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

    public function findById(int $ticketId) {
        $stmt = $this->conn->prepare("SELECT * FROM tickets WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $ticketId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: false;
    }

    public function getCurrentServing() {
        $stmt = $this->conn->prepare("SELECT * FROM tickets WHERE status = 'serving' ORDER BY created_at ASC LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: false;
    }

    public function getWaitingQueue(): array {
        $stmt = $this->conn->prepare("SELECT * FROM tickets WHERE status = 'waiting' ORDER BY created_at ASC");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCountByStatus(string $status): int {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM tickets WHERE status = ?");
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return (int) ($row['count'] ?? 0);
    }

    public function callNextTicket() {
        $queue = $this->getWaitingQueue();
        if (empty($queue)) {
            return false;
        }

        $ticket = $queue[0];
        $stmt = $this->conn->prepare("UPDATE tickets SET status = 'serving' WHERE id = ? AND status = 'waiting'");
        $stmt->bind_param("i", $ticket['id']);
        $stmt->execute();

        return $this->findById($ticket['id']);
    }

    public function serveTicket(int $ticketId) {
        $stmt = $this->conn->prepare("UPDATE tickets SET status = 'serving' WHERE id = ? AND status = 'waiting'");
        $stmt->bind_param("i", $ticketId);
        $stmt->execute();
        return $this->findById($ticketId);
    }

    public function complete(int $ticketId): void {
        $stmt = $this->conn->prepare("UPDATE tickets SET status = 'completed' WHERE id = ? AND status = 'serving'");
        $stmt->bind_param("i", $ticketId);
        $stmt->execute();
    }

    public function cancel(int $ticketId, ?int $cancelledByUserId = null): void {
        $stmt = $this->conn->prepare("UPDATE tickets SET status = 'no_show', cancelled_by = ? WHERE id = ? AND status = 'waiting'");
        $stmt->bind_param("ii", $cancelledByUserId, $ticketId);
        $stmt->execute();
    }

    public function markNoShow(int $ticketId, ?int $cancelledByUserId = null): void {
        $stmt = $this->conn->prepare("UPDATE tickets SET status = 'no_show', cancelled_by = ? WHERE id = ? AND status IN ('waiting','serving')");
        $stmt->bind_param("ii", $cancelledByUserId, $ticketId);
        $stmt->execute();
    }
}
