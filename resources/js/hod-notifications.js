// HOD Notification System
function loadHodNotifications() {
    fetch('/hod/notifications')
        .then(res => res.json())
        .then(data => {
            let list = document.getElementById('notificationList');
            let badge = document.getElementById('notificationBadge');

            list.innerHTML = '';

            if (data.length > 0) {
                data.forEach(notification => {
                    let timeAgo = new Date(notification.created_at).toLocaleString('id-ID');
                    let projectLink = '';
                    
                    // Add link to project if it's a commission notification
                    if (notification.type === 'commission_submitted' && notification.data && notification.data.project_id) {
                        projectLink = `<a href="/hod/komisi/${notification.data.project_id}" class="btn btn-sm btn-primary mt-2">Lihat Detail</a>`;
                    }

                    let item = `
                        <li class="dropdown-item border-bottom py-2" data-notification-id="${notification.id}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <p class="mb-1 small">${notification.message}</p>
                                    <small class="text-muted">${timeAgo}</small>
                                    ${projectLink}
                                </div>
                                <button class="btn btn-sm btn-link text-muted mark-read-btn" data-id="${notification.id}">
                                    <i class="bi bi-check"></i>
                                </button>
                            </div>
                        </li>`;
                    list.innerHTML += item;
                });

                // Add click handlers for mark as read buttons
                document.querySelectorAll('.mark-read-btn').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        markNotificationAsRead(this.dataset.id);
                    });
                });
            } else {
                list.innerHTML = `<li class="dropdown-item text-muted">Tidak ada notifikasi baru</li>`;
            }

            // Update badge
            if (data.length > 0) {
                badge.textContent = data.length;
                badge.style.display = 'inline';
            } else {
                badge.style.display = 'none';
            }
        })
        .catch(err => {
            console.error('Error loading notifications:', err);
            document.getElementById('notificationList').innerHTML = 
                `<li class="dropdown-item text-danger">Gagal memuat notifikasi</li>`;
        });
}

function markNotificationAsRead(notificationId) {
    fetch(`/hod/notifications/${notificationId}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            // Remove the notification from the list
            const notificationElement = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (notificationElement) {
                notificationElement.remove();
            }
            // Reload notifications to update badge
            loadHodNotifications();
        }
    })
    .catch(err => {
        console.error('Error marking notification as read:', err);
    });
}

function markAllHodNotificationsAsRead() {
    fetch('/hod/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            loadHodNotifications();
        }
    })
    .catch(err => {
        console.error('Error marking all notifications as read:', err);
    });
}

// Initialize HOD notifications
document.addEventListener('DOMContentLoaded', function() {
    // Load notifications on page load
    loadHodNotifications();

    // Mark all as read handler
    const markAllBtn = document.getElementById('markAllRead');
    if (markAllBtn) {
        markAllBtn.addEventListener('click', function(e) {
            e.preventDefault();
            markAllHodNotificationsAsRead();
        });
    }

    // Setup real-time notifications if Pusher is available
    if (typeof window.Echo !== 'undefined') {
        window.Echo.channel('hod-notifications')
            .listen('.commission.submitted', (e) => {
                console.log('New commission notification:', e);
                
                // Show toast notification
                showNotificationToast('Komisi Baru', `PM ${e.pm_name} telah menginput komisi untuk proyek ${e.project_title}`);
                
                // Reload notifications
                loadHodNotifications();
            });
    }

    // Refresh notifications every 30 seconds
    setInterval(loadHodNotifications, 30000);
});

// Toast notification function
function showNotificationToast(title, message) {
    // Create toast element if it doesn't exist
    let toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
        document.body.appendChild(toastContainer);
    }

    const toastId = 'toast-' + Date.now();
    const toastHTML = `
        <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bi bi-bell-fill text-primary me-2"></i>
                <strong class="me-auto">${title}</strong>
                <small>Baru saja</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        </div>
    `;

    toastContainer.insertAdjacentHTML('beforeend', toastHTML);

    // Show the toast
    const toastElement = document.getElementById(toastId);
    const toast = new bootstrap.Toast(toastElement);
    toast.show();

    // Remove toast element after it's hidden
    toastElement.addEventListener('hidden.bs.toast', function() {
        toastElement.remove();
    });
}