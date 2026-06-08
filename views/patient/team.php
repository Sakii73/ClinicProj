<?php 
$showNav = true; 
include 'layouts/header.php'; 
?>

<div class="container animate-fade-in" style="margin-top: 120px; text-align: center;">
    <h1 style="font-size: 64px; margin-bottom: 10px;">Meet Our Team</h1>
    <p style="font-size: 20px; color: var(--text-muted); margin-bottom: 40px;">Our experienced staff is dedicated to providing friendly, expert care for every patient.</p>

    <div class="grid-container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 22px; margin-top: 30px; text-align: left;">
        <div class="service-card" style="padding: 28px; border-radius: 20px;">
            <h3>Dr. Angela Reyes</h3>
            <p>Lead Physician specializing in family medicine and preventative care.</p>
        </div>
        <div class="service-card" style="padding: 28px; border-radius: 20px;">
            <h3>Nurse Samuel Cruz</h3>
            <p>Patient care coordinator focused on comfort, scheduling, and follow-up.</p>
        </div>
        <div class="service-card" style="padding: 28px; border-radius: 20px;">
            <h3>Dr. Malik Talib</h3>
            <p>Primary care provider with expertise in wellness, diagnosis, and treatment.</p>
        </div>
        <div class="service-card" style="padding: 28px; border-radius: 20px;">
            <h3>Support Team</h3>
            <p>Experienced staff helping you with appointment assistance, insurance, and guidance.</p>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>
