<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Appointment.php';

$apptModel = new Appointment($conn);
$appointments = $apptModel->getAll();

$statusClasses = [
    'pending' => 'status-pending',
    'confirmed' => 'status-confirmed',
    'cancelled' => 'status-cancelled',
];
?>

<?php include 'layouts/admin_header.php'; ?>

<!-- Header -->
<header class="admin-header">
    <h1 id="page-title">Appointments</h1>
    <div class="user-info">
        <span>Admin User</span>
        <div class="avatar">A</div>
    </div>
</header>

<section class="animate-fade-in" id="appointments-page">
    <div class="panel">
        <h2>Scheduled Appointments</h2>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Phone Number</th>
                        <th>Date</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="appointments-table-body">
                    <?php if (empty($appointments)): ?>
                        <tr>
                            <td colspan="6" style="text-align:center; color: var(--text-muted);">No appointments found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($appointments as $appointment): ?>
                            <tr>
                                <td style="font-weight: 600;"><?= htmlspecialchars($appointment['full_name']) ?></td>
                                <td><?= htmlspecialchars($appointment['phone']) ?></td>
                                <td><?= htmlspecialchars($appointment['appt_date']) ?></td>
                                <td><?= htmlspecialchars($appointment['reason']) ?></td>
                                <td>
                                    <span class="status-badge <?= htmlspecialchars($statusClasses[$appointment['status']] ?? '') ?>">
                                        <?= htmlspecialchars($appointment['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($appointment['status'] === 'pending'): ?>
                                        <form class="ajax-action-form" action="../../controllers/admin_controller.php" method="POST" style="display:inline-block; margin-right: 4px;">
                                            <input type="hidden" name="action" value="confirm_appointment">
                                            <input type="hidden" name="appointment_id" value="<?= htmlspecialchars($appointment['id']) ?>">
                                            <button type="submit" class="btn-small btn-confirm">Confirm</button>
                                        </form>
                                        <form class="ajax-action-form" action="../../controllers/admin_controller.php" method="POST" style="display:inline-block; margin:0;">
                                            <input type="hidden" name="action" value="cancel_appointment">
                                            <input type="hidden" name="appointment_id" value="<?= htmlspecialchars($appointment['id']) ?>">
                                            <button type="submit" class="btn-small btn-cancel">Cancel</button>
                                        </form>
                                    <?php elseif ($appointment['status'] === 'confirmed'): ?>
                                        <form class="ajax-action-form" action="../../controllers/admin_controller.php" method="POST" style="display:inline-block; margin:0;">
                                            <input type="hidden" name="action" value="cancel_appointment">
                                            <input type="hidden" name="appointment_id" value="<?= htmlspecialchars($appointment['id']) ?>">
                                            <button type="submit" class="btn-small btn-cancel">Cancel</button>
                                        </form>
                                    <?php else: ?>
                                        <span style="color: var(--text-muted);">No actions</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php include 'layouts/admin_footer.php'; ?>
