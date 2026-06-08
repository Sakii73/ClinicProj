<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Service.php';

$serviceModel = new Service($conn);
$services = $serviceModel->getAll();
?>

<?php include 'layouts/admin_header.php'; ?>

<!-- Header -->
<header class="admin-header">
    <h1 id="page-title">Services Management</h1>
    <div class="user-info">
        <span><?= htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username'] ?? 'Admin User') ?></span>
        <div class="avatar"><?= htmlspecialchars(substr($_SESSION['full_name'] ?? $_SESSION['username'] ?? 'A', 0, 1)) ?></div>
    </div>
</header>

<section class="animate-fade-in" id="services-page">
    <div class="panel">
        <h2>Add a New Service</h2>
        <form action="../../controllers/admin_controller.php" method="POST" class="admin-form">
            <input type="hidden" name="action" value="add_service">
            <div class="form-group">
                <label for="service-name">Service Name</label>
                <input type="text" id="service-name" name="name" placeholder="e.g. Dental Checkup" required>
            </div>
            <div class="form-group">
                <label for="service-description">Description</label>
                <textarea id="service-description" name="description" rows="4" placeholder="Describe the service" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Service</button>
        </form>
    </div>

    <div class="panel" style="margin-top: 24px;">
        <h2>Available Services</h2>
        <?php if (empty($services)): ?>
            <p style="color: var(--text-muted);">No services have been configured yet.</p>
        <?php else: ?>
            <div class="service-grid">
                <?php foreach ($services as $service): ?>
                    <div class="service-card admin-service-card">
                        <h3><?= htmlspecialchars($service['name']) ?></h3>
                        <p><?= htmlspecialchars($service['description']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'layouts/admin_footer.php'; ?>
