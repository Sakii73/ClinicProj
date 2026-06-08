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
        <div class="queue-number"><?php echo htmlspecialchars($_SESSION['ticket_number'] ?? 'TKT-000'); ?></div>
        <p style="font-size: 18px;">Status : Waiting</p>
    </div>
    
    <form action="../../controllers/ticket_controller.php" method="POST" style="margin-top: 20px;">
        <input type="hidden" name="cancel_ticket" value="<?php echo $_SESSION['ticket_id'] ?? 0; ?>">
        <button type="submit" class="cancel-btn">Leave Queue / Cancel Ticket</button>
    </form>
</div>

<?php include 'layouts/footer.php'; ?>
