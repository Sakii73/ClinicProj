<?php
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/Service.php';

$serviceModel = new Service($conn);
$services = $serviceModel->getAll();
$showNav = true;
include 'layouts/header.php';
?>

<div class="container animate-fade-in" style="margin-top: 120px; text-align: center;">
    <h1 style="font-size: 64px; margin-bottom: 10px;">Our Services</h1>
    <p style="font-size: 20px; color: var(--text-muted);">Explore the services we offer at CliniCare.</p>

    <?php if (empty($services)): ?>
        <p style="color: var(--text-muted); margin-top: 24px;">No services are currently available. Please check back later.</p>
    <?php else: ?>
        <div class="grid-container">
            <?php foreach ($services as $service): ?>
                <div class="service-card">
                    <h3><?= htmlspecialchars($service['name']) ?></h3>
                    <p><?= htmlspecialchars($service['description']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'layouts/footer.php'; ?>
