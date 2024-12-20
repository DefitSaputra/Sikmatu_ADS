// Toggle Sidebar
const toggleBtn = document.getElementById('sidebarToggle');
const sidebar = document.querySelector('.sidebar');

toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('active');
});

// Close sidebar when clicking outside
document.addEventListener('click', (e) => {
    if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
        sidebar.classList.remove('active');
    }
});

// Toggle Dropdown Profile
const profile = document.querySelector('.profile');
const dropdown = document.querySelector('.profile .dropdown');

profile.addEventListener('click', (e) => {
    e.stopPropagation(); // Prevent bubbling
    dropdown.classList.toggle('show');
});

// Close dropdown when clicking outside
document.addEventListener('click', () => {
    dropdown.classList.remove('show');
});

// Toggle Submenu
const submenuItems = document.querySelectorAll('.has-submenu');

submenuItems.forEach(item => {
    item.addEventListener('click', (e) => {
        if (e.target.closest('.submenu')) return;
        item.classList.toggle('active');
        const submenu = item.querySelector('.submenu');
        submenu.classList.toggle('show');
    });
});
