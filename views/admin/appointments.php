<?php include 'layouts/admin_header.php'; ?>

<!-- Header -->
<header class="admin-header">
    <h1 id="page-title">Appointments</h1>
    <div class="user-info">
        <span>Admin User</span>
        <div class="avatar">A</div>
    </div>
</header>

<section class="animate-fade-in">
    <div class="panel">
        <h2>Scheduled Appointments</h2>
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Phone Number</th>
                        <th>Date</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight: 600;">Sarah Jenkins</td>
                        <td>09192223333</td>
                        <td>2026-06-07</td>
                        <td>General Checkup</td>
                        <td><span class="status-badge status-confirmed">confirmed</span></td>
                        <td>
                            <button class="btn-small btn-cancel" onclick="alert('Cancelled')">Cancel</button>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">David Lee</td>
                        <td>09204445555</td>
                        <td>2026-06-08</td>
                        <td>Follow-up</td>
                        <td><span class="status-badge status-pending">pending</span></td>
                        <td>
                            <button class="btn-small btn-confirm" onclick="alert('Confirmed')">Confirm</button>
                            <button class="btn-small btn-cancel" onclick="alert('Cancelled')">Cancel</button>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: 600;">Anna Smith</td>
                        <td>09216667777</td>
                        <td>2026-06-08</td>
                        <td>Other</td>
                        <td><span class="status-badge status-pending">pending</span></td>
                        <td>
                            <button class="btn-small btn-confirm" onclick="alert('Confirmed')">Confirm</button>
                            <button class="btn-small btn-cancel" onclick="alert('Cancelled')">Cancel</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php include 'layouts/admin_footer.php'; ?>
