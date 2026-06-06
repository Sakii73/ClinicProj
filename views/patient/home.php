<?php 
$showNav = true; 
include 'layouts/header.php'; 
?>

<div class="container animate-fade-in" style="margin-top: 100px; text-align: center;">
    <h1 style="font-size: 80px; margin-bottom: 10px;">WELCOME!</h1>
    <p style="font-size: 24px; color: var(--text-muted); margin-bottom: 60px;">App Description or Quote</p>
    
    <h3 style="font-size: 24px; margin-bottom: 30px;">How Can we Help You?</h3>
    
    <div style="display: flex; justify-content: center; gap: 20px; margin-bottom: 50px;">
        <a href="consult.php" class="btn btn-outline" style="width: auto; padding: 15px 30px; border-radius: 40px;">Online Consultation</a>
        <a href="services.php" class="btn btn-outline" style="width: auto; padding: 15px 30px; border-radius: 40px;">Our Services</a>
        <a href="book.php" class="btn btn-outline" style="width: auto; padding: 15px 30px; border-radius: 40px;">Book an Appointment</a>
    </div>
    
    <p style="margin-bottom: 15px; font-size: 18px;">About Us?</p>
    <a href="#" class="btn btn-outline" style="width: auto; padding: 12px 40px; border-radius: 40px;">Our Team</a>
</div>

<?php include 'layouts/footer.php'; ?>
