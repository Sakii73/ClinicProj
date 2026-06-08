<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/User.php';

$userModel = new User($conn);
$staffMembers = $userModel->getStaffList();
$patientList = $userModel->getPatientList();
?>

<?php include 'layouts/admin_header.php'; ?>

<!-- Header -->
<header class="admin-header">
    <h1 id="page-title">Staff & Doctors</h1>
    <div class="user-info">
        <span><?= htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username'] ?? 'Admin User') ?></span>
        <div class="avatar"><?= htmlspecialchars(substr($_SESSION['full_name'] ?? $_SESSION['username'] ?? 'A', 0, 1)) ?></div>
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

    <div class="panel" style="margin-top: 24px;">
        <h2>Patient Accounts</h2>
        <?php if (empty($patientList)): ?>
            <p style="color: var(--text-muted);">No patient accounts found.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Age</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($patientList as $patient): ?>
                            <tr>
                                <td style="font-weight: 600;"><?= htmlspecialchars($patient['full_name']) ?></td>
                                <td><?= htmlspecialchars($patient['username']) ?></td>
                                <td><?= htmlspecialchars($patient['age']) ?></td>
                                <td>
                                    <span class="status-badge <?= $patient['is_online'] ? 'status-confirmed' : 'status-pending' ?>">
                                        <?= $patient['is_online'] ? 'Online' : 'Offline' ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (in_array($_SESSION['role'] ?? '', ['admin', 'doctor'], true)): ?>
                                        <form action="../../controllers/admin_controller.php" method="POST" style="display:inline-block; margin:0;">
                                            <input type="hidden" name="action" value="delete_user">
                                            <input type="hidden" name="user_id" value="<?= htmlspecialchars($patient['id']) ?>">
                                            <button type="submit" class="btn-small btn-cancel">Delete</button>
                                        </form>
                                    <?php else: ?>
                                        <span style="color: var(--text-muted);">No action</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'layouts/admin_footer.php'; ?>
