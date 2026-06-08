<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Ticket.php';
require_once __DIR__ . '/../../models/Appointment.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/ActivityLog.php';

$ticketModel = new Ticket($conn);
$apptModel = new Appointment($conn);
$userModel = new User($conn);
$logModel = new ActivityLog($conn);

$pendingAppointments = $apptModel->getCountByStatus('pending');
$staffOnDuty = $userModel->countOnlineStaff();
$waitingCount = $ticketModel->getCountByStatus('waiting');
$recentActivities = $logModel->getRecent(5);
?>

<?php include 'layouts/admin_header.php'; ?>

<!-- Header -->
<header class="admin-header">
    <h1 id="page-title">Dashboard Overview</h1>
    <div class="user-info">
        <span><?= htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username'] ?? 'Admin User') ?></span>
        <div class="avatar"><?= htmlspecialchars(substr($_SESSION['full_name'] ?? $_SESSION['username'] ?? 'A', 0, 1)) ?></div>
    </div>
</header>

<section class="animate-fade-in" id="dashboard-page">
    <div class="metrics-grid">
        <div class="metric-card">
            <h3>Pending Appointments</h3>
            <div class="value" id="pending-appointments-count"><?= htmlspecialchars($pendingAppointments) ?></div>
        </div>
        <div class="metric-card">
            <h3>Staff On Duty</h3>
            <div class="value" id="staff-on-duty-count"><?= htmlspecialchars($staffOnDuty) ?></div>
        </div>
        <div class="metric-card">
            <h3>Walk-ins Waiting</h3>
            <div class="value" id="waiting-count"><?= htmlspecialchars($waitingCount) ?></div>
        </div>
    </div>

    <div class="dashboard-split">
        <div class="panel">
            <h2>Recent Activity</h2>
            <ul class="activity-list" id="recent-activity-list">
                <?php if (empty($recentActivities)): ?>
                    <li style="color: var(--text-muted);">No recent activity yet.</li>
                <?php else: ?>
                    <?php foreach ($recentActivities as $activity): ?>
                        <li>
                            <span><?= htmlspecialchars($activity['description']) ?></span>
                            <span class="activity-time"><?= date('M d, H:i', strtotime($activity['logged_at'])) ?></span>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <div class="panel">
            <h2>Quick Actions</h2>
            <a href="queue.php" class="btn btn-primary">Manage Walk-ins</a>
            <a href="appointments.php" class="btn btn-secondary" style="margin-top: 10px;">View Appointments</a>
        </div>
    </div>
</section>

<?php include 'layouts/admin_footer.php'; ?>
