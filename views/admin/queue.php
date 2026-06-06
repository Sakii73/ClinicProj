<?php include 'layouts/admin_header.php'; ?>

<!-- Header -->
<header class="admin-header">
    <h1 id="page-title">Queue Management</h1>
    <div class="user-info">
        <span>Admin User</span>
        <div class="avatar">A</div>
    </div>
</header>

<section class="animate-fade-in">
    <div class="queue-layout">
        <!-- Left: Serving Station -->
        <div class="serving-station">
            <h2>Currently Serving Desk</h2>
            <div class="serving-card">
                <span class="status-label">Now Serving</span>
                <h1 class="ticket-display">TKT-041</h1>
                <p class="patient-name">Alice Smith</p>
                <p class="visit-reason">General Checkup</p>
                <p class="patient-phone" style="color: var(--text-muted); font-size: 14px; margin-bottom: 20px;">09171234567</p>
                
                <div class="action-buttons">
                    <button class="btn btn-primary" onclick="alert('Action completed!')">Mark Completed</button>
                    <button class="btn btn-outline" onclick="alert('Marked as No Show!')" style="margin-top: 10px; border-color: #ef4444; color: #ef4444;">No Show</button>
                </div>
            </div>
        </div>

        <!-- Right: Waiting Queue -->
        <div class="waiting-queue">
            <div class="queue-header-flex">
                <h2>Walk-in Queue</h2>
                <span class="queue-badge">3 Waiting</span>
            </div>
            <div class="queue-list">
                
                <div class="queue-item next-up">
                    <div class="q-left">
                        <span class="q-ticket">TKT-042</span>
                        <div>
                            <div class="q-name">James Robertson</div>
                            <div class="q-reason">General Consultation • 09:15 AM</div>
                        </div>
                    </div>
                    <button class="btn-call" onclick="alert('Calling TKT-042')">Call Next</button>
                </div>

                <div class="queue-item">
                    <div class="q-left">
                        <span class="q-ticket">TKT-043</span>
                        <div>
                            <div class="q-name">Emily Davis</div>
                            <div class="q-reason">Vaccination • 09:22 AM</div>
                        </div>
                    </div>
                    <button class="btn-call" onclick="alert('Calling TKT-043')">Call Next</button>
                </div>

                <div class="queue-item">
                    <div class="q-left">
                        <span class="q-ticket">TKT-044</span>
                        <div>
                            <div class="q-name">Michael King</div>
                            <div class="q-reason">Prescription Renewal • 09:30 AM</div>
                        </div>
                    </div>
                    <button class="btn-call" onclick="alert('Calling TKT-044')">Call Next</button>
                </div>

            </div>
        </div>
    </div>
</section>

<?php include 'layouts/admin_footer.php'; ?>
