// Toggle sidebar on mobile
document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
    const sidebar = document.querySelector('aside');
    sidebar.classList.toggle('-translate-x-full');
});

// Handle user editing
function editUser(userId) {
    const row = document.getElementById(`user-row-${userId}`);
    row.querySelectorAll('.user-display').forEach(el => el.classList.add('hidden'));
    row.querySelectorAll('.user-edit').forEach(el => el.classList.remove('hidden'));
}

function cancelEdit(userId) {
    const row = document.getElementById(`user-row-${userId}`);
    row.querySelectorAll('.user-display').forEach(el => el.classList.remove('hidden'));
    row.querySelectorAll('.user-edit').forEach(el => el.classList.add('hidden'));
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert-success, .alert-error');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});

// Confirm delete actions
document.querySelectorAll('[data-confirm]').forEach(element => {
    element.addEventListener('click', function(e) {
        if (!confirm(this.dataset.confirm)) {
            e.preventDefault();
        }
    });
});

// Handle status updates
document.querySelectorAll('select[name="status"]').forEach(select => {
    select.addEventListener('change', function() {
        const originalColor = this.style.backgroundColor;
        this.style.backgroundColor = '#e5e7eb';
        setTimeout(() => {
            this.style.backgroundColor = originalColor;
        }, 200);
    });
});

// Active sidebar link
document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    document.querySelectorAll('nav a').forEach(link => {
        if (link.getAttribute('href') === currentPath.split('/').pop()) {
            link.classList.add('sidebar-active');
        }
    });
});