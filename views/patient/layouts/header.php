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
            <a href="services.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'services.php') ? 'active' : '' ?>">Services</a>
            <a href="book.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'book.php') ? 'active' : '' ?>">Book Now</a>
            <a href="consult.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'consult.php') ? 'active' : '' ?>">Consult Now</a>
            <!-- Hamburger icon mockup -->
            <a href="#" style="font-size: 24px;">&#9776;</a>
        </div>
    </nav>
    <?php endif; ?>
