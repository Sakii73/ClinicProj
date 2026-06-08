<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/User.php';

$userModel = new User($conn);
$staffMembers = $userModel->getStaffList();
?>

<?php include 'layouts/admin_header.php'; ?>

<!-- Header -->
<header class="admin-header">
    <h1 id="page-title">Staff & Doctors</h1>
    <div class="user-info">
        <span>Admin User</span>
        <div class="avatar">A</div>
    </div>
</header>

<section class="animate-fade-in" id="staff-page">
    <div class="panel">
        <h2>Active Staff & Doctors</h2>
        <div class="staff-grid" id="staff-grid">
            <?php if (empty($staffMembers)): ?>
                <div style="color: var(--text-muted);">No staff members found.</div>
            <?php else: ?>
                <?php foreach ($staffMembers as $staff): ?>
                    <div class="staff-card">
                        <div class="staff-avatar"><?= htmlspecialchars(substr($staff['full_name'], 0, 1)) ?></div>
                        <div class="staff-info">
                            <h3><?= htmlspecialchars($staff['full_name']) ?></h3>
                            <div class="staff-role"><?= htmlspecialchars($staff['role'] === 'admin' ? 'Staff/Admin' : 'Doctor') ?></div>
                            <div>
                                <span class="staff-status <?= $staff['is_online'] ? 'online' : 'offline' ?>"></span>
                                <span style="font-size: 13px; color: var(--text-muted); text-transform: capitalize;">
                                    <?= $staff['is_online'] ? 'online' : 'offline' ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'layouts/admin_footer.php'; ?>
