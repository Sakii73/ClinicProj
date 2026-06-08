<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Appointment System</title>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Main CSS -->
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <!-- Optional Navbar if $showNav is true -->
    <?php if(isset($showNav) && $showNav): ?>
    <nav class="navbar animate-fade-in">
        <a href="home.php" class="nav-brand">App Name</a>
        <div class="nav-links">
            <!-- Hamburger menu implementation -->
            <div class="hamburger-menu">
                <a href="#" class="hamburger-icon" id="patientHamburgerIcon" onclick="toggleHamburgerMenu(event, 'patientHamburgerDropdown')">&#9776;</a>
                <div class="hamburger-dropdown" id="patientHamburgerDropdown">
                    <a href="services.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'services.php') ? 'active' : '' ?>">Services</a>
                    <a href="book.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'book.php') ? 'active' : '' ?>">Book Now</a>
                    <a href="consult.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'consult.php') ? 'active' : '' ?>">Consult Now</a>
                    
                    <?php if (!empty($_SESSION['user_id'])): ?>
                        <div style="padding: 12px 16px; font-size: 14px; color: var(--text-muted); border-bottom: 1px solid var(--border-color); border-top: 1px solid var(--border-color);">
                            Signed in as <br><b><?= htmlspecialchars($_SESSION['username']) ?></b>
                        </div>
                        <form action="../../controllers/auth_controller.php" method="POST">
                            <input type="hidden" name="action" value="logout">
                            <button type="submit">Logout</button>
                        </form>
                    <?php else: ?>
                        <div style="border-top: 1px solid var(--border-color);"></div>
                        <a href="login.php">Login</a>
                    <?php endif; ?>
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
    <?php endif; ?>
