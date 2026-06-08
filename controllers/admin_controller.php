<?php
// controllers/admin_controller.php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/Ticket.php';
require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/ActivityLog.php';

$action = trim($_REQUEST['action'] ?? '');
$ajax = isset($_REQUEST['ajax']) && $_REQUEST['ajax'] === '1';

$ticketModel = new Ticket($conn);
$apptModel = new Appointment($conn);
$userModel = new User($conn);
$logModel = new ActivityLog($conn);
$userId = $_SESSION['user_id'] ?? null;

function jsonResponse(array $data): void {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function getQueuePayload(Ticket $ticketModel): array {
    return [
        'currentServing' => $ticketModel->getCurrentServing() ?: null,
        'waitingQueue'   => $ticketModel->getWaitingQueue(),
        'waitingCount'   => $ticketModel->getCountByStatus('waiting'),
    ];
}

function getAppointmentsPayload(Appointment $apptModel): array {
    return ['appointments' => $apptModel->getAll()];
}

function getDashboardPayload(Ticket $ticketModel, Appointment $apptModel, User $userModel, ActivityLog $logModel): array {
    return [
        'pendingAppointments' => $apptModel->getCountByStatus('pending'),
        'staffOnDuty'         => $userModel->countOnlineStaff(),
        'waitingCount'        => $ticketModel->getCountByStatus('waiting'),
        'recentActivities'    => $logModel->getRecent(5),
    ];
}

function getStaffPayload(User $userModel): array {
    return ['staff' => $userModel->getStaffList()];
}

$redirect = '../views/admin/dashboard.php';

switch ($action) {
    case 'fetch_queue':
        jsonResponse(array_merge(['success' => true], getQueuePayload($ticketModel)));
        break;

    case 'fetch_appointments':
        jsonResponse(array_merge(['success' => true], getAppointmentsPayload($apptModel)));
        break;

    case 'fetch_dashboard':
        jsonResponse(array_merge(['success' => true], getDashboardPayload($ticketModel, $apptModel, $userModel, $logModel)));
        break;

    case 'fetch_staff':
        jsonResponse(array_merge(['success' => true], getStaffPayload($userModel)));
        break;

    case 'call_next_ticket':
        $current = $ticketModel->getCurrentServing();
        if ($current) {
            $message = 'Please complete the current serving ticket before calling the next one.';
            if ($ajax) {
                jsonResponse(array_merge(['success' => false, 'message' => $message], getQueuePayload($ticketModel)));
            }
            $_SESSION['error'] = $message;
            $redirect = '../views/admin/queue.php';
            break;
        }

        $ticket = $ticketModel->callNextTicket();
        if ($ticket) {
            $message = "Now serving {$ticket['ticket_number']}";
            $logModel->log($message);
            if ($ajax) {
                jsonResponse(array_merge(['success' => true, 'message' => $message], getQueuePayload($ticketModel)));
            }
            $_SESSION['success'] = $message;
            $redirect = '../views/admin/queue.php';
            break;
        }

        $message = 'No waiting tickets available.';
        if ($ajax) {
            jsonResponse(array_merge(['success' => false, 'message' => $message], getQueuePayload($ticketModel)));
        }
        $_SESSION['error'] = $message;
        $redirect = '../views/admin/queue.php';
        break;

    case 'serve_ticket':
        $ticketId = (int)($_REQUEST['ticket_id'] ?? 0);
        $current = $ticketModel->getCurrentServing();
        if ($current) {
            $message = 'A ticket is already being served. Complete it before serving another one.';
            if ($ajax) {
                jsonResponse(array_merge(['success' => false, 'message' => $message], getQueuePayload($ticketModel)));
            }
            $_SESSION['error'] = $message;
            $redirect = '../views/admin/queue.php';
            break;
        }

        $ticket = $ticketModel->findById($ticketId);
        if ($ticket && $ticket['status'] === 'waiting') {
            $ticketModel->serveTicket($ticketId);
            $message = "Ticket {$ticket['ticket_number']} is now being served.";
            $logModel->log($message);
            if ($ajax) {
                jsonResponse(array_merge(['success' => true, 'message' => $message], getQueuePayload($ticketModel)));
            }
            $_SESSION['success'] = $message;
            $redirect = '../views/admin/queue.php';
            break;
        }

        $message = 'Ticket cannot be served.';
        if ($ajax) {
            jsonResponse(array_merge(['success' => false, 'message' => $message], getQueuePayload($ticketModel)));
        }
        $_SESSION['error'] = $message;
        $redirect = '../views/admin/queue.php';
        break;

    case 'complete_ticket':
        $ticketId = (int)($_REQUEST['ticket_id'] ?? 0);
        $ticket = $ticketModel->findById($ticketId);
        if ($ticket && $ticket['status'] === 'serving') {
            $ticketModel->complete($ticketId);
            $message = "Ticket {$ticket['ticket_number']} marked completed.";
            $logModel->log($message);
            if ($ajax) {
                jsonResponse(array_merge(['success' => true, 'message' => $message], getQueuePayload($ticketModel)));
            }
            $_SESSION['success'] = $message;
            $redirect = '../views/admin/queue.php';
            break;
        }

        $message = 'Unable to complete ticket.';
        if ($ajax) {
            jsonResponse(array_merge(['success' => false, 'message' => $message], getQueuePayload($ticketModel)));
        }
        $_SESSION['error'] = $message;
        $redirect = '../views/admin/queue.php';
        break;

    case 'no_show_ticket':
        $ticketId = (int)($_REQUEST['ticket_id'] ?? 0);
        $ticket = $ticketModel->findById($ticketId);
        if ($ticket && in_array($ticket['status'], ['waiting', 'serving'], true)) {
            $ticketModel->markNoShow($ticketId, $userId);
            $message = "Ticket {$ticket['ticket_number']} marked no-show.";
            $logModel->log($message);
            if ($ajax) {
                jsonResponse(array_merge(['success' => true, 'message' => $message], getQueuePayload($ticketModel)));
            }
            $_SESSION['success'] = $message;
            $redirect = '../views/admin/queue.php';
            break;
        }

        $message = 'Unable to mark ticket as no-show.';
        if ($ajax) {
            jsonResponse(array_merge(['success' => false, 'message' => $message], getQueuePayload($ticketModel)));
        }
        $_SESSION['error'] = $message;
        $redirect = '../views/admin/queue.php';
        break;

    case 'confirm_appointment':
        $appointmentId = (int)($_REQUEST['appointment_id'] ?? 0);
        if ($appointmentId > 0) {
            $apptModel->confirm($appointmentId);
            $message = 'Appointment confirmed.';
            $logModel->log("Appointment #{$appointmentId} confirmed.");
            if ($ajax) {
                jsonResponse(array_merge(['success' => true, 'message' => $message], getAppointmentsPayload($apptModel)));
            }
            $_SESSION['success'] = $message;
            $redirect = '../views/admin/appointments.php';
            break;
        }

        $message = 'Unable to confirm appointment.';
        if ($ajax) {
            jsonResponse(['success' => false, 'message' => $message]);
        }
        $_SESSION['error'] = $message;
        $redirect = '../views/admin/appointments.php';
        break;

    case 'cancel_appointment':
        $appointmentId = (int)($_REQUEST['appointment_id'] ?? 0);
        if ($appointmentId > 0) {
            $apptModel->cancel($appointmentId);
            $message = 'Appointment cancelled.';
            $logModel->log("Appointment #{$appointmentId} cancelled.");
            if ($ajax) {
                jsonResponse(array_merge(['success' => true, 'message' => $message], getAppointmentsPayload($apptModel)));
            }
            $_SESSION['success'] = $message;
            $redirect = '../views/admin/appointments.php';
            break;
        }

        $message = 'Unable to cancel appointment.';
        if ($ajax) {
            jsonResponse(['success' => false, 'message' => $message]);
        }
        $_SESSION['error'] = $message;
        $redirect = '../views/admin/appointments.php';
        break;

    default:
        if ($ajax) {
            jsonResponse(['success' => false, 'message' => 'Invalid admin action.']);
        }
        $_SESSION['error'] = 'Invalid admin action.';
        break;
}

header('Location: ' . $redirect);
exit;
