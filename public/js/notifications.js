// Notification filtering functionality
function filterNotifications() {
    const statusFilter = document.getElementById('statusFilter').value;
    const typeFilter = document.getElementById('typeFilter').value;
    
    let url = new URL(window.location);
    
    if (statusFilter) {
        url.searchParams.set('filter', statusFilter);
    } else {
        url.searchParams.delete('filter');
    }
    
    if (typeFilter) {
        url.searchParams.set('type', typeFilter);
    } else {
        url.searchParams.delete('type');
    }
    
    window.location.href = url.toString();
}

// Mark notification as read
function markAsRead(notificationId) {
    fetch(`/notifications/${notificationId}/read`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Mark all notifications as read
function markAllAsRead() {
    if (!confirm(document.getElementById('markAllConfirmText').textContent)) {
        return;
    }
    
    fetch('/notifications/read-all', {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Delete notification
function deleteNotification(notificationId) {
    if (!confirm(document.getElementById('deleteConfirmText').textContent)) {
        return;
    }
    
    fetch(`/notifications/${notificationId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
