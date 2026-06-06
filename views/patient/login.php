<?php 
$showNav = false; 
include 'layouts/header.php'; 
?>

<div class="top-title">App Name</div>

<div class="center-card animate-fade-in">
    <h1>Login</h1>
    <form action="home.php" method="GET">
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
