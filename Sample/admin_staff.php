<?php
// Sample admin/staff view page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin / Staff Dashboard</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <div class="container">
        <section class="center-card" style="max-width: 1000px; width: 100%; padding: 40px;">
            <h1>Admin / Staff Dashboard</h1>
            <p style="color: #6b7280; text-align: center; margin-bottom: 30px; font-size: 17px;">Use this sample view as the admin or staff landing page. It includes quick links, staff status, and important activity summaries.</p>

            <div class="grid-container" style="grid-template-columns: repeat(3, 1fr); gap: 24px;">
                <div class="service-card">
                    <h3>Pending Appointments</h3>
                    <p>Review upcoming patient bookings and confirm reservations.</p>
                    <span style="font-size: 44px; font-weight: 700; margin-top: 20px; color: #2563eb;">24</span>
                </div>
                <div class="service-card">
                    <h3>Staff On Duty</h3>
                    <p>Active employees currently logged into the system.</p>
                    <span style="font-size: 44px; font-weight: 700; margin-top: 20px; color: #16a34a;">8</span>
                </div>
                <div class="service-card">
                    <h3>Tickets Waiting</h3>
                    <p>New walk-in and support requests that need attention.</p>
                    <span style="font-size: 44px; font-weight: 700; margin-top: 20px; color: #f59e0b;">12</span>
                </div>
            </div>

            <div style="margin-top: 40px; display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
                <div style="background: #ffffff; border-radius: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 30px;">
                    <h2 style="margin-bottom: 20px; text-align: left;">Staff Activity</h2>
                    <div style="display: grid; gap: 18px;">
                        <div style="padding: 20px; border: 1px solid #e5e7eb; border-radius: 20px;">
                            <strong>Dr. Reyes</strong>
                            <p style="color: #6b7280; margin-top: 8px;">Consultations today: 11</p>
                        </div>
                        <div style="padding: 20px; border: 1px solid #e5e7eb; border-radius: 20px;">
                            <strong>Nurse Aya</strong>
                            <p style="color: #6b7280; margin-top: 8px;">Tickets processed: 7</p>
                        </div>
                        <div style="padding: 20px; border: 1px solid #e5e7eb; border-radius: 20px;">
                            <strong>Admin Leo</strong>
                            <p style="color: #6b7280; margin-top: 8px;">New approvals: 4</p>
                        </div>
                    </div>
                </div>
                <div style="background: #ffffff; border-radius: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); padding: 30px;">
                    <h2 style="margin-bottom: 20px; text-align: left;">Quick Actions</h2>
                    <a href="#" class="btn btn-primary" style="margin-bottom: 18px;">Review Schedule</a>
                    <a href="#" class="btn btn-secondary" style="margin-bottom: 18px;">Manage Staff</a>
                    <a href="#" class="btn btn-outline">Create Announcement</a>
                </div>
            </div>

            <div class="ticket-box" style="margin-top: 40px;">
                <h2>Important Notice</h2>
                <p>System maintenance is scheduled for tonight at 10:00 PM. Make sure all patient records are saved and all open tickets are processed before closing.</p>
            </div>
        </section>
    </div>
</body>
</html>
