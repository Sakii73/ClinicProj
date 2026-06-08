<?php 
$showNav = false; 
include 'layouts/header.php'; 
?>

<div class="top-title">App Name</div>

<div class="center-card animate-fade-in">
    <h1>Login</h1>
    <?php if (isset($_SESSION['error'])): ?>
        <div style="color: red; margin-bottom: 10px; text-align: center;">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['success'])): ?>
        <div style="color: green; margin-bottom: 10px; text-align: center;">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    <form action="../../controllers/auth_controller.php" method="POST">
        <input type="hidden" name="action" value="login">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Enter Username">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">
        </div>
        
        <button type="submit" class="btn btn-secondary" style="margin-top: 20px;">Login</button>
        
        <a href="register.php" class="link" style="color: #38bdf8;">Create Account.</a>
    </form>
</div>

<?php include 'layouts/footer.php'; ?>
