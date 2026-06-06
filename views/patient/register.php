<?php 
$showNav = false; 
include 'layouts/header.php'; 
?>

<div class="top-title">App Name</div>

<div class="center-card animate-fade-in" style="margin-top: 60px;">
    <h1>Create Account</h1>
    <form action="login.php" method="GET">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Enter Username">
        </div>
        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" class="form-control" placeholder="Enter Age">
        </div>
        <div class="form-group">
            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Enter Name">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">
        </div>
        
        <div class="radio-group">
            <label class="radio-label">
                <input type="radio" name="role" value="doctor" checked> Doctor
            </label>
            <label class="radio-label">
                <input type="radio" name="role" value="patient"> Patient
            </label>
        </div>
        
        <button type="submit" class="btn btn-secondary">Create Account</button>
        
        <p style="text-align: center; margin-top: 20px; font-size: 14px;">
            Already Have Account? <a href="login.php" style="color: #38bdf8; text-decoration: none;">Login</a>
        </p>
    </form>
</div>

<?php include 'layouts/footer.php'; ?>
