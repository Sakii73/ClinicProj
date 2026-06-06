<?php 
$showNav = false; 
include 'layouts/header.php'; 
?>

<div class="top-title">App Name</div>

<div class="center-card animate-fade-in" style="margin-top: 80px; width: 500px; padding: 40px;">
    <h1 style="font-size: 36px; margin-bottom: 10px;">Walk-in Ticket</h1>
    <p style="text-align: center; margin-bottom: 20px; font-size: 16px;">
        You can safely step out. We will text<br>you when it's your turn.
    </p>

    <div class="ticket-box">
        <h2 style="font-size: 20px; font-weight: normal; margin-bottom: 5px;">Your Queue Number</h2>
        <div class="queue-number">TKT - 001</div>
        <p style="font-size: 18px;">Status : Waiting</p>
    </div>
    
    <button class="cancel-btn" onclick="window.location.href='home.php'">Leave Queue / Cancel Ticket</button>
</div>

<?php include 'layouts/footer.php'; ?>
