<?php
// controllers/ticket_controller.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Ticket.php';
require_once __DIR__ . '/../models/ActivityLog.php';

$ticketModel = new Ticket($conn);
$logModel = new ActivityLog($conn);

// ─── CANCEL TICKET ──────────────────────────────────────────
if (isset($_POST['cancel_ticket'])) {
    $cancelId = (int)$_POST['cancel_ticket'];
    $userId = $_SESSION['user_id'] ?? null;
    
    $ticketModel->cancel($cancelId, $userId);
    
    unset($_SESSION['ticket_id'], $_SESSION['ticket_number'],
          $_SESSION['ticket_name'], $_SESSION['ticket_reason']);
          
    header('Location: ../views/patient/home.php');
    exit;
}

// ─── CREATE TICKET ──────────────────────────────────────────
$fullname = trim($_POST['fullname'] ?? '');
$phone    = trim($_POST['phone']    ?? '');
$reason   = trim($_POST['reason']   ?? '');

if (empty($fullname) || empty($phone) || empty($reason)) {
    $_SESSION['error'] = 'Please fill in all fields.';
    header('Location: ../views/patient/consult.php');
    exit;
}

$ticketNumber = $ticketModel->generateNextTicketNumber();
$ticketId = $ticketModel->create($fullname, $phone, $reason, $ticketNumber);

$logModel->log("New walk-in '$fullname' added to queue as $ticketNumber");

// Store for display on ticket page
$_SESSION['ticket_id']     = $ticketId;
$_SESSION['ticket_number'] = $ticketNumber;
$_SESSION['ticket_name']   = $fullname;
$_SESSION['ticket_reason'] = $reason;

header('Location: ../views/patient/walk_in_ticket.php');
exit;
