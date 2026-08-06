document.addEventListener('DOMContentLoaded', () => {
    // --- Sticky Navbar ---
    const navbar = document.querySelector('.navbar');
    const navbarOffset = navbar.offsetTop;
    const navbarHeight = navbar.offsetHeight;
    let spacer = null;

    window.addEventListener('scroll', () => {
        if (window.scrollY >= navbarOffset) {
            if (!navbar.classList.contains('is-sticky')) {
                navbar.classList.add('is-sticky');
                spacer = document.createElement('div');
                spacer.style.height = navbarHeight + 'px';
                navbar.parentNode.insertBefore(spacer, navbar.nextSibling);
            }
        } else {
            navbar.classList.remove('is-sticky');
            if (spacer) { spacer.remove(); spacer = null; }
        }
    });

    // --- Hamburger Toggle ---
    const hamburger = document.getElementById('navHamburger');
    if (hamburger) {
        hamburger.addEventListener('click', (e) => {
            e.stopPropagation();
            navbar.classList.toggle('nav-open');
        });
    }

    const navLinks = document.querySelectorAll('.nav-links a');
    const studentTrigger = document.querySelector('.submenu > a');
    const studentMenu = document.querySelector('.submenu-list');
    const parentLi = document.querySelector('.submenu');
    const directionsBtn = document.querySelector('.btn-directions');

    // --- 1. Main Dropdown Logic ---
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');

            // If it's a scroll link (starts with #)
            if (href && href.startsWith('#') && href.length > 1) {
                closeAllMenus();
                navbar.classList.remove('nav-open');
                return;
            }

            // If it's a main dropdown trigger
            if (this.parentElement.classList.contains('dropdown')) {
                e.preventDefault();

                const parent = this.parentElement;
                const menu = parent.querySelector('.dropdown-menu');
                const isOpen = menu.classList.contains('show');

                closeAllMenus(); // Close others first

                if (!isOpen) {
                    parent.classList.add('active');
                    menu.classList.add('show');
                }
                return;
            }

            // If it's a submenu trigger, let its dedicated handler deal with it
            if (this.parentElement.classList.contains('submenu')) {
                e.preventDefault();
                return;
            }

            // A real navigation link — close mobile nav
            navbar.classList.remove('nav-open');
        });
    });

    // --- 2. Student Portal Sub-Menu Logic ---
    if (studentTrigger) {
        studentTrigger.addEventListener('click', function(e) {
            e.preventDefault(); 
            e.stopPropagation(); 

            const isOpen = studentMenu.classList.contains('show-submenu');
            
            closeAllSubMenus();

            if (!isOpen) {
                studentMenu.classList.add('show-submenu');
                parentLi.classList.add('active-sub');
            }
        });
    }

    // --- 3. Utility Functions ---
    function closeAllMenus() {
        document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('active'));
        document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('show'));
        closeAllSubMenus(); // Close sub-menus when closing main menus
    }

    function closeAllSubMenus() {
        if(studentMenu) studentMenu.classList.remove('show-submenu');
        if(parentLi) parentLi.classList.remove('active-sub');
    }

    // --- 4. Global Click-to-Close ---
    window.addEventListener('click', (e) => {
        if (!e.target.closest('.navbar')) {
            navbar.classList.remove('nav-open');
        }
        if (!e.target.closest('.dropdown')) {
            closeAllMenus();
        }
        if (!e.target.closest('.submenu')) {
            closeAllSubMenus();
        }
    });

    // --- 5. Directions Button ---
    // Added a check so it doesn't error out on pages without a map
    if (directionsBtn) {
        directionsBtn.addEventListener('click', (e) => {
            e.preventDefault();
            window.open('https://www.google.com/maps/dir//Divine+Word+College+of+Urdaneta', '_blank');
        });
    }

    // --- 6. Scroll-reveal ---
    const revealEls = document.querySelectorAll('.reveal');
    if (revealEls.length && 'IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -60px 0px' });

        revealEls.forEach(el => revealObserver.observe(el));
    } else {
        revealEls.forEach(el => el.classList.add('is-visible'));
    }
});
// Connect this to your "Publish Task" button
const publishBtn = document.querySelector('.publish-task-btn');

if (publishBtn) publishBtn.addEventListener('click', async (e) => {
    e.preventDefault();

    // 1. Grab data from your modal fields
    const taskData = {
        gradeLevel: document.querySelector('#gradeSelect').value,
        subject: document.querySelector('#subjectSelect').value,
        title: document.querySelector('#activityTitle').value,
        formLink: document.querySelector('#googleFormLink').value,
        category: document.querySelector('#categorySelect').value,
        dateCreated: new Date().toISOString()
    };

    try {
        // 2. Send it to your backend API
        const response = await fetch('http://localhost:3000/api/tasks', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(taskData)
        });

        if (response.ok) {
            alert("Task Published Successfully!");
            // Close modal logic here
        }
    } catch (error) {
        console.error("Backend connection failed:", error);
    }
});