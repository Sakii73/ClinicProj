<?php include 'layouts/admin_header.php'; ?>

<!-- Header -->
<header class="admin-header">
    <h1 id="page-title">Staff & Doctors</h1>
    <div class="user-info">
        <span>Admin User</span>
        <div class="avatar">A</div>
    </div>
</header>

<section class="animate-fade-in">
    <div class="panel">
        <h2>Active Staff & Doctors</h2>
        <div class="staff-grid">
            
            <div class="staff-card">
                <div class="staff-avatar">R</div>
                <div class="staff-info">
                    <h3>Dr. Reyes</h3>
                    <div class="staff-role">Doctor (General)</div>
                    <div>
                        <span class="staff-status online"></span>
                        <span style="font-size: 13px; color: var(--text-muted); text-transform: capitalize;">online</span>
                    </div>
                </div>
            </div>

            <div class="staff-card">
                <div class="staff-avatar">S</div>
                <div class="staff-info">
                    <h3>Dr. Santos</h3>
                    <div class="staff-role">Doctor (Pediatrics)</div>
                    <div>
                        <span class="staff-status offline"></span>
                        <span style="font-size: 13px; color: var(--text-muted); text-transform: capitalize;">offline</span>
                    </div>
                </div>
            </div>

            <div class="staff-card">
                <div class="staff-avatar">L</div>
                <div class="staff-info">
                    <h3>Admin Leo</h3>
                    <div class="staff-role">Staff/Admin</div>
                    <div>
                        <span class="staff-status online"></span>
                        <span style="font-size: 13px; color: var(--text-muted); text-transform: capitalize;">online</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include 'layouts/admin_footer.php'; ?>
