<?php 
$showNav = true; 
include 'layouts/header.php'; 
?>

<div class="container animate-fade-in" style="margin-top: 120px; text-align: center;">
    <h1 style="font-size: 64px; margin-bottom: 10px;">Meet Our Team</h1>
    <p style="font-size: 20px; color: var(--text-muted); margin-bottom: 40px;">Our experienced staff is dedicated to providing friendly application for every patients and doctors.</p>

    <div class="grid-container team-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 22px; margin-top: 30px; text-align: left;">
        <div class="service-card team-card" style="padding: 28px; border-radius: 20px;">
            <img src="../picture/camua.jpg" alt="Camua" class="team-avatar">
            <h3>Mark Joshua Camua</h3>
            <p>Project Manager (Leader & Designer).</p>
        </div>

        <div class="service-card team-card" style="padding: 28px; border-radius: 20px;">
            <img src="../picture/torres.jpg" alt="Torres" class="team-avatar">
            <h3>Enrique Anjhelo Torres</h3>
            <p>Frontend Designer (HTML & CSS Specialist).</p>
        </div>
        
        <div class="service-card team-card" style="padding: 28px; border-radius: 20px;">
            <img src="../picture/juliado.jpg" alt="Juliado" class="team-avatar">
            <h3>Mark Ian Juliado</h3>
            <p>Client-Side Scripting Engineer (JavaScript Specialist).</p>
        </div>

        <div class="service-card team-card" style="padding: 28px; border-radius: 20px;">
            <img src="../picture/cruz.png" alt="Cruz" class="team-avatar">
            <h3>Kendrick Cruz</h3>
            <p> Backend Systems Engineer (PHP & MySQL Specialist).</p>
        </div>
        
        
    </div>
</div>

<?php include 'layouts/footer.php'; ?>
