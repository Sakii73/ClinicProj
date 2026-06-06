<?php include 'layouts/admin_header.php'; ?>

<!-- Header -->
<header class="admin-header">
    <h1 id="page-title">Dashboard Overview</h1>
    <div class="user-info">
        <span>Admin User</span>
        <div class="avatar">A</div>
    </div>
</header>

<section class="animate-fade-in">
    <div class="metrics-grid">
        <div class="metric-card">
            <h3>Pending Appointments</h3>
            <div class="value">2</div>
        </div>
        <div class="metric-card">
            <h3>Staff On Duty</h3>
            <div class="value">2</div>
        </div>
        <div class="metric-card">
            <h3>Walk-ins Waiting</h3>
            <div class="value">3</div>
        </div>
    </div>

    <div class="dashboard-split">
        <div class="panel">
            <h2>Recent Activity</h2>
            <ul class="activity-list">
                <li>
                    <span>New walk-in patient added to queue</span>
                    <span class="activity-time">10:15 AM</span>
                </li>
                <li>
                    <span>Ticket TKT-041 marked completed</span>
                    <span class="activity-time">09:10 AM</span>
                </li>
                <li>
                    <span>Dr. Reyes started session</span>
                    <span class="activity-time">08:00 AM</span>
                </li>
            </ul>
        </div>
        <div class="panel">
            <h2>Quick Actions</h2>
            <a href="queue.php" class="btn btn-primary">Manage Walk-ins</a>
            <a href="appointments.php" class="btn btn-secondary" style="margin-top: 10px;">View Appointments</a>
        </div>
    </div>
</section>

<?php include 'layouts/admin_footer.php'; ?>
