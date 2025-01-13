document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle
    const sidebarToggle = document.querySelector('.btn-toggle-sidebar');
    const sidebar = document.querySelector('.sidebar');
    const closeSidebar = document.querySelector('.btn-close-sidebar');

    if (sidebarToggle && sidebar && closeSidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.add('show');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.remove('show');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', (e) => {
        if (window.innerWidth < 992 &&
            sidebar &&
            sidebar.classList.contains('show') &&
            !sidebar.contains(e.target) &&
            !sidebarToggle.contains(e.target)) {
            sidebar.classList.remove('show');
        }
    });
});
