// This file handles AJAX-based admin page updates.
$(document).ready(function() {
    const controllerPath = '../../controllers/admin_controller.php';

    function showAdminMessage(message, isError) {
        let $container = $('#admin-ajax-message');
        if (!$container.length) {
            $('body').prepend('<div id="admin-ajax-message" style="position:fixed;top:16px;right:16px;z-index:9999;max-width:360px;"></div>');
            $container = $('#admin-ajax-message');
        }

        const html = '<div style="padding:12px 16px;margin-bottom:12px;border-radius:12px;box-shadow:0 8px 24px rgba(15,23,42,.08);background:' + (isError ? '#fee2e2' : '#dcfce7') + ';color:' + (isError ? '#991b1b' : '#166534') + ';font-weight:600;">' + $('<div/>').text(message).html() + '</div>';
        $container.prepend(html);
        setTimeout(() => $container.children().last().fadeOut(250, function() { $(this).remove(); }), 6000);
    }

    function updateQueue(response) {
        if (response.waitingCount !== undefined) {
            $('#queue-count').text(response.waitingCount);
        }

        const $currentServing = $('#current-serving-card');
        if (response.currentServing) {
            const ticket = response.currentServing;
            $currentServing.html(`
                <span class="status-label">Now Serving</span>
                <h1 class="ticket-display">${ticket.ticket_number}</h1>
                <p class="patient-name">${ticket.full_name}</p>
                <p class="visit-reason">${ticket.reason}</p>
                <p class="patient-phone" style="color: var(--text-muted); font-size: 14px; margin-bottom: 20px;">${ticket.phone}</p>
                <div class="action-buttons">
                    <form class="ajax-action-form" action="${controllerPath}" method="POST" style="display:inline-block; margin-right: 8px;">
                        <input type="hidden" name="action" value="complete_ticket">
                        <input type="hidden" name="ticket_id" value="${ticket.id}">
                        <button type="submit" class="btn btn-primary">Mark Completed</button>
                    </form>
                    <form class="ajax-action-form" action="${controllerPath}" method="POST" style="display:inline-block; margin-top: 10px;">
                        <input type="hidden" name="action" value="no_show_ticket">
                        <input type="hidden" name="ticket_id" value="${ticket.id}">
                        <button type="submit" class="btn btn-outline" style="border-color: #ef4444; color: #ef4444;">No Show</button>
                    </form>
                </div>
            `);
        } else {
            $currentServing.html(`
                <span class="status-label">No Current Ticket</span>
                <h2 style="margin-top: 16px;">There is no ticket being served right now.</h2>
                <p style="color: var(--text-muted); margin-bottom: 20px;">Use the queue list to serve the next waiting patient.</p>
                <form class="ajax-action-form" action="${controllerPath}" method="POST">
                    <input type="hidden" name="action" value="call_next_ticket">
                    <button type="submit" class="btn btn-primary" ${response.waitingCount === 0 ? 'disabled' : ''}>Call Next Ticket</button>
                </form>
            `);
        }

        const $waitingList = $('#waiting-queue-list');
        if (!response.waitingQueue || response.waitingQueue.length === 0) {
            $waitingList.html('<div class="queue-item"><div class="q-left"><div class="q-name" style="font-weight: 600;">No waiting tickets.</div></div></div>');
            return;
        }

        const rows = response.waitingQueue.map(ticket => {
            return `
                <div class="queue-item">
                    <div class="q-left">
                        <span class="q-ticket">${ticket.ticket_number}</span>
                        <div>
                            <div class="q-name">${ticket.full_name}</div>
                            <div class="q-reason">${ticket.reason} • ${new Date(ticket.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
                        </div>
                    </div>
                    <div style="display:flex; gap:8px;">
                        <form class="ajax-action-form" action="${controllerPath}" method="POST" style="margin:0;">
                            <input type="hidden" name="action" value="serve_ticket">
                            <input type="hidden" name="ticket_id" value="${ticket.id}">
                            <button type="submit" class="btn-call">Serve</button>
                        </form>
                        <form class="ajax-action-form" action="${controllerPath}" method="POST" style="margin:0;">
                            <input type="hidden" name="action" value="no_show_ticket">
                            <input type="hidden" name="ticket_id" value="${ticket.id}">
                            <button type="submit" class="btn btn-outline" style="border-color: #ef4444; color: #ef4444;">No Show</button>
                        </form>
                    </div>
                </div>
            `;
        }).join('');

        $waitingList.html(rows);
    }

    function updateAppointments(appointments) {
        const rows = appointments.map(appt => {
            const statusClass = appt.status === 'confirmed' ? 'status-confirmed' : appt.status === 'cancelled' ? 'status-cancelled' : 'status-pending';
            const actions = appt.status === 'pending'
                ? `<form class="ajax-action-form" action="${controllerPath}" method="POST" style="display:inline-block; margin-right: 4px;"><input type="hidden" name="action" value="confirm_appointment"><input type="hidden" name="appointment_id" value="${appt.id}"><button type="submit" class="btn-small btn-confirm">Confirm</button></form><form class="ajax-action-form" action="${controllerPath}" method="POST" style="display:inline-block; margin:0;"><input type="hidden" name="action" value="cancel_appointment"><input type="hidden" name="appointment_id" value="${appt.id}"><button type="submit" class="btn-small btn-cancel">Cancel</button></form>`
                : appt.status === 'confirmed'
                    ? `<form class="ajax-action-form" action="${controllerPath}" method="POST" style="display:inline-block; margin:0;"><input type="hidden" name="action" value="cancel_appointment"><input type="hidden" name="appointment_id" value="${appt.id}"><button type="submit" class="btn-small btn-cancel">Cancel</button></form>`
                    : '<span style="color: var(--text-muted);">No actions</span>';

            return `
                <tr>
                    <td style="font-weight: 600;">${appt.full_name}</td>
                    <td>${appt.phone}</td>
                    <td>${appt.appt_date}</td>
                    <td>${appt.reason}</td>
                    <td><span class="status-badge ${statusClass}">${appt.status}</span></td>
                    <td>${actions}</td>
                </tr>
            `;
        }).join('');

        if (!rows) {
            $('#appointments-table-body').html('<tr><td colspan="6" style="text-align:center; color: var(--text-muted);">No appointments found.</td></tr>');
        } else {
            $('#appointments-table-body').html(rows);
        }
    }

    function updateDashboard(response) {
        $('#pending-appointments-count').text(response.pendingAppointments);
        $('#staff-on-duty-count').text(response.staffOnDuty);
        $('#waiting-count').text(response.waitingCount);

        const activityRows = response.recentActivities.map(activity => {
            return `<li><span>${activity.description}</span><span class="activity-time">${new Date(activity.logged_at).toLocaleString([], {month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit'})}</span></li>`;
        }).join('');

        $('#recent-activity-list').html(activityRows || '<li style="color: var(--text-muted);">No recent activity yet.</li>');
    }

    function updateStaff(response) {
        const staffHtml = response.staff.map(staff => {
            const roleText = staff.role === 'admin' ? 'Staff/Admin' : 'Doctor';
            return `
                <div class="staff-card">
                    <div class="staff-avatar">${staff.full_name.charAt(0)}</div>
                    <div class="staff-info">
                        <h3>${staff.full_name}</h3>
                        <div class="staff-role">${roleText}</div>
                        <div>
                            <span class="staff-status ${staff.is_online ? 'online' : 'offline'}"></span>
                            <span style="font-size: 13px; color: var(--text-muted); text-transform: capitalize;">${staff.is_online ? 'online' : 'offline'}</span>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        $('#staff-grid').html(staffHtml || '<div style="color: var(--text-muted);">No staff members found.</div>');
    }

    function ajaxSubmitForm($form) {
        $.post($form.attr('action'), $form.serialize() + '&ajax=1', function(response) {
            if (!response) {
                showAdminMessage('Unexpected server response.', true);
                return;
            }

            if (response.success) {
                showAdminMessage(response.message || 'Action completed.', false);
            } else {
                showAdminMessage(response.message || 'Action failed.', true);
            }

            if (response.currentServing !== undefined || response.waitingQueue !== undefined) {
                updateQueue(response);
            }
            if (response.appointments) {
                updateAppointments(response.appointments);
            }
            if (response.pendingAppointments !== undefined) {
                updateDashboard(response);
            }
            if (response.staff) {
                updateStaff(response);
            }
        }, 'json').fail(function() {
            showAdminMessage('Server error. Please try again.', true);
        });
    }

    function fetchData(fetchAction, callback) {
        $.getJSON(controllerPath, { action: fetchAction, ajax: 1 }, function(response) {
            if (!response || !response.success) {
                return;
            }
            callback(response);
        });
    }

    $(document).on('submit', '.ajax-action-form', function(event) {
        event.preventDefault();
        ajaxSubmitForm($(this));
    });

    if ($('#queue-page').length) {
        fetchData('fetch_queue', updateQueue);
        setInterval(function() {
            fetchData('fetch_queue', updateQueue);
        }, 8000);
    }

    if ($('#appointments-page').length) {
        fetchData('fetch_appointments', function(response) {
            updateAppointments(response.appointments);
        });
        setInterval(function() {
            fetchData('fetch_appointments', function(response) {
                updateAppointments(response.appointments);
            });
        }, 10000);
    }

    if ($('#dashboard-page').length) {
        fetchData('fetch_dashboard', updateDashboard);
        setInterval(function() {
            fetchData('fetch_dashboard', updateDashboard);
        }, 10000);
    }

    if ($('#staff-page').length) {
        fetchData('fetch_staff', updateStaff);
        setInterval(function() {
            fetchData('fetch_staff', updateStaff);
        }, 15000);
    }
});
