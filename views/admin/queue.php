<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Ticket.php';

$ticketModel = new Ticket($conn);
$currentServing = $ticketModel->getCurrentServing();
$waitingQueue = $ticketModel->getWaitingQueue();
$waitingCount = $ticketModel->getCountByStatus('waiting');
?>

<?php include 'layouts/admin_header.php'; ?>

<!-- Header -->
<header class="admin-header">
    <h1 id="page-title">Queue Management</h1>
    <div class="user-info">
        <span>Admin User</span>
        <div class="avatar">A</div>
    </div>
</header>

<section class="animate-fade-in" id="queue-page">
    <div class="queue-layout">
        <!-- Left: Serving Station -->
        <div class="serving-station">
            <h2>Currently Serving Desk</h2>
            <div class="serving-card" id="current-serving-card">
                <?php if ($currentServing): ?>
                    <span class="status-label">Now Serving</span>
                    <h1 class="ticket-display"><?= htmlspecialchars($currentServing['ticket_number']) ?></h1>
                    <p class="patient-name"><?= htmlspecialchars($currentServing['full_name']) ?></p>
                    <p class="visit-reason"><?= htmlspecialchars($currentServing['reason']) ?></p>
                    <p class="patient-phone" style="color: var(--text-muted); font-size: 14px; margin-bottom: 20px;">
                        <?= htmlspecialchars($currentServing['phone']) ?>
                    </p>
                    <div class="action-buttons">
                        <form class="ajax-action-form" action="../../controllers/admin_controller.php" method="POST" style="display:inline-block; margin-right: 8px;">
                            <input type="hidden" name="action" value="complete_ticket">
                            <input type="hidden" name="ticket_id" value="<?= htmlspecialchars($currentServing['id']) ?>">
                            <button type="submit" class="btn btn-primary">Mark Completed</button>
                        </form>
                        <form class="ajax-action-form" action="../../controllers/admin_controller.php" method="POST" style="display:inline-block; margin-top: 10px;">
                            <input type="hidden" name="action" value="no_show_ticket">
                            <input type="hidden" name="ticket_id" value="<?= htmlspecialchars($currentServing['id']) ?>">
                            <button type="submit" class="btn btn-outline" style="border-color: #ef4444; color: #ef4444;">No Show</button>
                        </form>
                    </div>
                <?php else: ?>
                    <span class="status-label">No Current Ticket</span>
                    <h2 style="margin-top: 16px;">There is no ticket being served right now.</h2>
                    <p style="color: var(--text-muted); margin-bottom: 20px;">Use the queue list to serve the next waiting patient.</p>
                    <form class="ajax-action-form" action="../../controllers/admin_controller.php" method="POST">
                        <input type="hidden" name="action" value="call_next_ticket">
                        <button type="submit" class="btn btn-primary" <?= $waitingCount === 0 ? 'disabled' : '' ?>>Call Next Ticket</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right: Waiting Queue -->
        <div class="waiting-queue">
            <div class="queue-header-flex">
                <h2>Walk-in Queue</h2>
                <span class="queue-badge" id="queue-count"><?= htmlspecialchars($waitingCount) ?> Waiting</span>
            </div>
            <div class="queue-list" id="waiting-queue-list">
                <?php if (empty($waitingQueue)): ?>
                    <div class="queue-item">
                        <div class="q-left">
                            <div class="q-name" style="font-weight: 600;">No waiting tickets.</div>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($waitingQueue as $ticket): ?>
                        <div class="queue-item">
                            <div class="q-left">
                                <span class="q-ticket"><?= htmlspecialchars($ticket['ticket_number']) ?></span>
                                <div>
                                    <div class="q-name"><?= htmlspecialchars($ticket['full_name']) ?></div>
                                    <div class="q-reason"><?= htmlspecialchars($ticket['reason']) ?> • <?= date('H:i', strtotime($ticket['created_at'])) ?></div>
                                </div>
                            </div>
                            <div style="display:flex; gap:8px;">
                                <form class="ajax-action-form" action="../../controllers/admin_controller.php" method="POST" style="margin:0;">
                                    <input type="hidden" name="action" value="serve_ticket">
                                    <input type="hidden" name="ticket_id" value="<?= htmlspecialchars($ticket['id']) ?>">
                                    <button type="submit" class="btn-call">Serve</button>
                                </form>
                                <form class="ajax-action-form" action="../../controllers/admin_controller.php" method="POST" style="margin:0;">
                                    <input type="hidden" name="action" value="no_show_ticket">
                                    <input type="hidden" name="ticket_id" value="<?= htmlspecialchars($ticket['id']) ?>">
                                    <button type="submit" class="btn btn-outline" style="border-color: #ef4444; color: #ef4444;">No Show</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php include 'layouts/admin_footer.php'; ?>
