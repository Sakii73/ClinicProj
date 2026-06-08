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
            <!-- Hamburger menu implementation -->
            <div class="hamburger-menu">
                <a href="#" class="hamburger-icon" id="adminHamburgerIcon" onclick="toggleHamburgerMenu(event, 'adminHamburgerDropdown')">&#9776;</a>
                <div class="hamburger-dropdown" id="adminHamburgerDropdown">
                    <a href="dashboard.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : '' ?>">Overview</a>
                    <a href="queue.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'queue.php') ? 'active' : '' ?>">Queue</a>
                    <a href="appointments.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'appointments.php') ? 'active' : '' ?>">Appointments</a>
                    <a href="staff.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'staff.php') ? 'active' : '' ?>">Staff</a>
                    
                    <div style="padding: 12px 16px; font-size: 14px; color: var(--text-muted); border-bottom: 1px solid var(--border-color); border-top: 1px solid var(--border-color);">
                        Signed in as <br><b>Admin</b>
                    </div>
                    <a href="../patient/login.php">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <script>
        function toggleHamburgerMenu(event, dropdownId) {
            event.preventDefault();
            var dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle('show');
        }

        // Close the dropdown if the user clicks outside of it
        window.addEventListener('click', function(event) {
            if (!event.target.matches('.hamburger-icon')) {
                var dropdowns = document.getElementsByClassName("hamburger-dropdown");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        });
    </script>

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
