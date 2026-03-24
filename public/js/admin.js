document.addEventListener('DOMContentLoaded', () => {
    // --- MOBILE NAV DRAWER LOGIC ---
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const overlay      = document.getElementById('mobile-nav-overlay');
    const drawer       = document.getElementById('mobile-nav-drawer');
    const closeBtn     = document.getElementById('mobile-nav-close');

    function openDrawer()  { drawer.classList.add('open');    overlay.classList.add('open');    }
    function closeDrawer() { drawer.classList.remove('open'); overlay.classList.remove('open'); }

    if (hamburgerBtn) hamburgerBtn.addEventListener('click', openDrawer);
    if (closeBtn)     closeBtn.addEventListener('click', closeDrawer);
    if (overlay)      overlay.addEventListener('click', closeDrawer);
});
