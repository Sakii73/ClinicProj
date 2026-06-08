<?php
// controllers/appointment_controller.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../models/ActivityLog.php';

$fullname = trim($_POST['fullname'] ?? '');
$phone    = trim($_POST['phone']    ?? '');
$date     = trim($_POST['date']     ?? '');
$reason   = trim($_POST['reason']   ?? '');
$patientId = $_SESSION['user_id'] ?? null;

if (empty($fullname) || empty($phone) || empty($date) || empty($reason)) {
    $_SESSION['error'] = 'Please fill in all fields.';
    header('Location: ../views/patient/book.php');
    exit;
}

// Validate date is not in the past
if (strtotime($date) < strtotime('today')) {
    $_SESSION['error'] = 'Please select a future date.';
    header('Location: ../views/patient/book.php');
    exit;
}

$apptModel = new Appointment($conn);
$apptModel->create($patientId, $fullname, $phone, $date, $reason);

$logModel = new ActivityLog($conn);
$logModel->log("New appointment booked for '$fullname' on $date");

// Store for display on schedule ticket page
$_SESSION['appt_name']   = $fullname;
$_SESSION['appt_phone']  = $phone;
$_SESSION['appt_date']   = $date;
$_SESSION['appt_reason'] = $reason;

header('Location: ../views/patient/schedule_ticket.php');
exit;
