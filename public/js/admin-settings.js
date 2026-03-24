document.addEventListener('DOMContentLoaded', () => {

    // ── Mobile nav drawer ─────────────────────────────────────
    const hamburgerBtn   = document.getElementById('hamburger-btn');
    const overlay        = document.getElementById('mobile-nav-overlay');
    const drawer         = document.getElementById('mobile-nav-drawer');
    const mobileCloseBtn = document.getElementById('mobile-nav-close');

    const openDrawer  = () => { drawer.classList.add('open');    overlay.classList.add('open'); };
    const closeDrawer = () => { drawer.classList.remove('open'); overlay.classList.remove('open'); };

    if (hamburgerBtn)   hamburgerBtn.addEventListener('click', openDrawer);
    if (mobileCloseBtn) mobileCloseBtn.addEventListener('click', closeDrawer);
    if (overlay)        overlay.addEventListener('click', closeDrawer);

    // ── Toast ─────────────────────────────────────────────────
    const toast = document.getElementById('settingsToast');

    function showToast(msg) {
        toast.querySelector('span').textContent = msg;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    // ── Maintenance toggle confirmation ───────────────────────
    document.getElementById('maintenanceToggle').addEventListener('change', e => {
        if (e.target.checked) {
            const ok = confirm('Warning: Maintenance mode will prevent faculty and students from logging in.\n\nProceed?');
            if (!ok) { e.target.checked = false; return; }
            showToast('Maintenance mode enabled.');
        } else {
            showToast('Maintenance mode disabled.');
        }
    });

    // ── Backup toggle ─────────────────────────────────────────
    document.getElementById('backupToggle').addEventListener('change', e => {
        showToast(e.target.checked ? 'Auto-backup enabled.' : 'Auto-backup disabled.');
    });

    // ── Email toggle ──────────────────────────────────────────
    document.getElementById('emailToggle').addEventListener('change', e => {
        showToast(e.target.checked ? 'Email notifications enabled.' : 'Email notifications disabled.');
    });
});
