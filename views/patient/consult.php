<?php 
$showNav = true; 
include 'layouts/header.php'; 
?>

<div class="container animate-fade-in" style="margin-top: 100px; text-align: center;">
    <h1 style="font-size: 50px; margin-bottom: 5px;">Consult Now</h1>
    <p style="font-size: 18px; color: var(--text-muted); margin-bottom: 40px;">Short Description</p>
    
    <div class="center-card" style="width: 500px; padding: 40px;">
        <h2 style="font-size: 28px; margin-bottom: 25px;">Patient Form</h2>
        <form action="walk_in_ticket.php" method="GET">
            <div class="form-group">
                <input type="text" name="fullname" class="form-control" placeholder="Full Name" style="text-align: center;">
            </div>
            <div class="form-group">
                <input type="tel" name="phone" class="form-control" placeholder="Phone Number (For SMS Alert)" style="text-align: center;">
            </div>
            <div class="form-group">
                <select name="reason" class="form-control" style="text-align: center; appearance: none; background: url('data:image/svg+xml;utf8,<svg fill=\"black\" height=\"24\" viewBox=\"0 0 24 24\" width=\"24\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"M7 10l5 5 5-5z\"/></svg>') no-repeat right 15px center; background-color: white;">
                    <option value="" disabled selected>Reason for Visit</option>
                    <option value="checkup">General Checkup</option>
                    <option value="followup">Follow-up</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" value="Ticket No. (Automatic)" readonly style="text-align: center; background-color: #f9fafb;">
            </div>
            
            <button type="submit" class="btn btn-primary" style="margin-top: 10px; width: 50%;">Submit</button>
        </form>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>
