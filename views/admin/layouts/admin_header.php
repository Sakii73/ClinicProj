<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - ClinicProj</title>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Main CSS -->
    <link rel="stylesheet" href="../../public/css/style.css">
    <!-- Admin CSS -->
    <link rel="stylesheet" href="../../public/css/admin.css">
</head>
<body class="admin-body">
    
    <!-- Admin Navbar -->
    <nav class="admin-navbar animate-fade-in">
        <a href="dashboard.php" class="nav-brand">AdminPanel</a>
        <div class="nav-links">
            <a href="dashboard.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : '' ?>">Overview</a>
            <a href="queue.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'queue.php') ? 'active' : '' ?>">Queue</a>
            <a href="appointments.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'appointments.php') ? 'active' : '' ?>">Appointments</a>
            <a href="staff.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'staff.php') ? 'active' : '' ?>">Staff</a>
            <a href="../patient/login.php" class="logout-link">Logout</a>
        </div>
    </nav>

    <?php if (!empty($_SESSION['success']) || !empty($_SESSION['error'])): ?>
        <div class="admin-flash-message" style="padding: 14px 20px; max-width: 1100px; margin: 20px auto 0; border-radius: 10px; font-weight: 500;">
            <?php if (!empty($_SESSION['success'])): ?>
                <div style="color: #166534; background: #d1fae5; border: 1px solid #a7f3d0;"><?= htmlspecialchars($_SESSION['success']) ?></div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['error'])): ?>
                <div style="color: #991b1b; background: #fef2f2; border: 1px solid #fecaca;"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php endif; ?>
        </div>
        <?php unset($_SESSION['success'], $_SESSION['error']); ?>
    <?php endif; ?>

    <div class="admin-container">
        <!-- Main Content -->
        <main class="admin-main">
