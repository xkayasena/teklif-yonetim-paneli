import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const deleteItemName = document.getElementById('deleteItemName');
    const cancelDelete = document.getElementById('cancelDelete');

    // Modal olmayan sayfalarda JavaScript'i çalıştırma.
    if (!deleteModal || !deleteForm || !deleteItemName || !cancelDelete) {
        return;
    }

    // İşlem onay modalını aç.
    document.querySelectorAll('[data-delete-url]').forEach((button) => {
        button.addEventListener('click', () => {
            deleteForm.action = button.dataset.deleteUrl;
            deleteItemName.textContent = button.dataset.deleteName ?? '';

            deleteModal.classList.remove('hidden');
            deleteModal.classList.add('flex');
        });
    });

    // Modalı kapat.
    cancelDelete.addEventListener('click', () => {
        deleteModal.classList.add('hidden');
        deleteModal.classList.remove('flex');
    });
});


function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('sidebarToggle');
    const icon = document.getElementById('sidebarToggleIcon');

    if (!sidebar || !toggle || !icon || toggle.dataset.ready) return;
    toggle.dataset.ready = 'true';

    function setCollapsed(collapsed) {
        sidebar.classList.toggle('w-20', collapsed);
        sidebar.classList.toggle('w-64', !collapsed);

        const header = sidebar.querySelector(':scope > div:first-child');
        header.classList.toggle('justify-center', collapsed);
        header.classList.toggle('gap-3', !collapsed);
        header.classList.toggle('gap-0', collapsed);
        header.classList.toggle('px-3', !collapsed);
        header.classList.toggle('px-2', collapsed);

        sidebar.querySelectorAll('.sidebar-label').forEach(el => {
            el.classList.toggle('hidden', collapsed);
        });

        sidebar.querySelectorAll('.sidebar-link').forEach(el => {
            el.classList.toggle('justify-center', collapsed);
            el.classList.toggle('px-3', !collapsed);
            el.classList.toggle('px-2', collapsed);
        });

        toggle.classList.toggle('ml-auto', !collapsed);
        toggle.classList.toggle('mx-auto', collapsed);

        icon.innerHTML = collapsed
            ? '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>'
            : '<path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>';

        toggle.setAttribute('aria-expanded', String(!collapsed));
        localStorage.setItem('sidebar-collapsed', String(collapsed));
    }

    setCollapsed(localStorage.getItem('sidebar-collapsed') === 'true');

    toggle.addEventListener('click', () => {
        setCollapsed(!sidebar.classList.contains('w-20'));
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSidebar);
} else {
    initSidebar();
}

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .catch(error => console.error('PWA kayıt hatası:', error));
    });
}
