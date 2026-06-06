<?php 
$showNav = false; 
include 'layouts/header.php'; 
?>

<div class="top-title">App Name</div>

<div class="center-card animate-fade-in" style="margin-top: 80px; width: 500px; padding: 40px;">
    <h1 style="font-size: 36px; margin-bottom: 10px;">Schedule Ticket</h1>
    <p style="text-align: center; margin-bottom: 20px; font-size: 16px;">
        Please Come on the<br>Schedule you provided!
    </p>

    <div class="ticket-box">
        <h2 style="font-size: 28px; font-weight: 600;">Patient<br>Information</h2>
        
        <input type="text" class="form-control" value="Full Name" readonly>
        <input type="text" class="form-control" value="Phone Number (For SMS Alert)" readonly>
        <input type="text" class="form-control" value="Reason for Visit" readonly>
        <input type="text" class="form-control" value="Date" readonly>
    </div>
    
    <div style="text-align: center; margin-top: 20px;">
        <a href="home.php" class="link">Back to Home</a>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>
