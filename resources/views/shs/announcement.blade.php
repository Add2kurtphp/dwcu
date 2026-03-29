<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements | DWCU SHS Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css'])
    <style>
        :root {
            --primary-blue: #1e2f7a;
            --bg-light: #f0f4f8;
            --text-dark: #1e293b;
            --white: #ffffff;
        }

        * { margin:0; padding:0; box-sizing:border-box; font-family:'Afacad',sans-serif; }

        body { display:flex; height:100vh; background-color:var(--bg-light); color:var(--text-dark); overflow:hidden; }

        /* ── SIDEBAR ── */
        .sidebar {
            width:270px; background:linear-gradient(180deg,#162152 0%,#0d1535 100%);
            color:var(--white); display:flex; flex-direction:column; justify-content:space-between;
            padding:20px; box-shadow:4px 0 15px rgba(0,0,0,0.15); flex-shrink:0;
        }
        .brand-section { text-align:center; border-bottom:1px solid rgba(255,255,255,0.08); padding-bottom:18px; margin-bottom:16px; }
        .school-logo { width:75px; margin:0 auto 10px; display:block; filter:drop-shadow(0 0 10px rgba(255,255,255,0.1)); }
        .school-name { font-size:0.82rem; font-weight:700; line-height:1.4; letter-spacing:0.5px; }
        .sub-brand {
            display:inline-block; margin-top:10px;
            background:rgba(251,191,36,0.15); border:1px solid rgba(251,191,36,0.35);
            color:#fbbf24; border-radius:50px; padding:3px 14px;
            font-size:0.72rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase;
        }
        .nav-menu { display:flex; flex-direction:column; gap:3px; }
        .nav-item {
            display:flex; align-items:center; padding:11px 16px; color:#94a3b8;
            text-decoration:none; border-radius:12px; transition:all 0.25s ease;
            font-weight:500; font-size:0.95rem;
        }
        .nav-item i { margin-right:13px; font-size:1rem; width:18px; text-align:center; }
        .nav-item:hover { background:rgba(255,255,255,0.08); color:var(--white); transform:translateX(4px); }
        .nav-item.active { background:rgba(251,191,36,0.12); color:#fbbf24; border:1px solid rgba(251,191,36,0.25); }
        .sidebar-bottom { padding-top:16px; border-top:1px solid rgba(255,255,255,0.08); }
        .logout-btn {
            display:flex; align-items:center; justify-content:center; gap:10px;
            width:100%; padding:12px; border-radius:10px; background:transparent;
            color:#fca5a5; border:none; cursor:pointer;
            font-weight:600; font-size:0.95rem; font-family:'Afacad',sans-serif;
            transition:background 0.25s,color 0.25s;
        }
        .logout-btn:hover { background:rgba(248,113,113,0.15); color:#fff; }

        /* ── CONTENT AREA ── */
        .content-area { flex:1; display:flex; flex-direction:column; overflow:hidden; }
        .main-header {
            background:var(--white); padding:18px 40px;
            display:flex; justify-content:space-between; align-items:center;
            border-bottom:1px solid #e2e8f0; flex-shrink:0;
        }
        .main-header h1 { font-size:1.35rem; font-weight:700; color:var(--primary-blue); }
        .header-user {
            display:flex; align-items:center; gap:10px; padding:8px 16px;
            border-radius:50px; text-decoration:none; transition:all 0.2s ease; border:1px solid transparent;
        }
        .header-user:hover { background-color:#f1f5f9; border-color:#e2e8f0; }
        .header-user i { font-size:1.5rem; color:var(--primary-blue); }
        .header-user span { font-weight:600; font-size:0.9rem; color:var(--text-dark); }
        .scroll-container { padding:30px 40px; overflow-y:auto; flex:1; }

        /* ── SUMMARY BAR ── */
        .announce-summary-bar {
            display:flex; justify-content:space-between; align-items:center;
            background:white; border-radius:14px; padding:14px 22px;
            margin-bottom:22px; border:1px solid #e2e8f0;
            box-shadow:0 2px 8px rgba(0,0,0,0.04); flex-wrap:wrap; gap:12px;
        }
        .announce-summary-left { display:flex; align-items:center; gap:10px; font-size:0.9rem; color:#475569; }
        .announce-summary-left i { color:#1e2f7a; font-size:1rem; }
        .announce-summary-right { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }

        /* ── TAGS ── */
        .announce-tag {
            display:inline-flex; align-items:center; gap:5px;
            padding:4px 12px; border-radius:50px; font-size:0.72rem;
            font-weight:700; text-transform:uppercase; letter-spacing:0.04em;
        }
        .tag-urgent   { background:#fee2e2; color:#dc2626; }
        .tag-academic { background:#dbeafe; color:#1d4ed8; }
        .tag-event    { background:#dcfce7; color:#15803d; }

        /* ── FEATURED CARD ── */
        .announce-featured-card {
            background:linear-gradient(135deg,#1e2f7a 0%,#283593 60%,#3949ab 100%);
            border-radius:22px; padding:36px 36px 28px; color:white;
            margin-bottom:22px; box-shadow:0 12px 32px rgba(30,47,122,0.28);
            position:relative; overflow:hidden; transition:transform 0.25s,box-shadow 0.25s;
        }
        .announce-featured-card:hover { transform:translateY(-3px); box-shadow:0 18px 40px rgba(30,47,122,0.35); }
        .announce-feat-deco {
            position:absolute; width:280px; height:280px; border-radius:50%;
            background:rgba(255,255,255,0.05); top:-80px; right:-60px; pointer-events:none;
        }
        .announce-feat-deco::after {
            content:''; position:absolute; width:180px; height:180px; border-radius:50%;
            background:rgba(251,191,36,0.08); bottom:-60px; right:-40px;
        }
        .announce-feat-header { display:flex; gap:20px; align-items:flex-start; margin-bottom:24px; position:relative; }
        .announce-feat-icon-wrap {
            width:52px; height:52px; background:rgba(255,255,255,0.15);
            border:1px solid rgba(255,255,255,0.2); border-radius:15px;
            display:flex; align-items:center; justify-content:center;
            font-size:1.3rem; flex-shrink:0; margin-top:4px;
        }
        .announce-feat-header h2 { font-size:1.55rem; font-weight:700; margin-bottom:10px; line-height:1.25; }
        .announce-feat-header p { font-size:0.92rem; opacity:0.85; line-height:1.6; max-width:600px; }
        .announce-feat-footer {
            display:flex; justify-content:space-between; align-items:center;
            padding-top:20px; border-top:1px solid rgba(255,255,255,0.12);
            flex-wrap:wrap; gap:12px; position:relative;
        }
        .announce-date { display:flex; align-items:center; gap:6px; font-size:0.82rem; color:rgba(255,255,255,0.7); }

        /* ── SMALL CARDS ── */
        .announce-cards-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(300px,1fr)); gap:20px; }
        .announce-small-card {
            background:white; border-radius:18px; padding:24px;
            border:1px solid #f1f5f9; box-shadow:0 4px 16px rgba(0,0,0,0.05);
            display:flex; flex-direction:column; gap:12px;
            transition:transform 0.25s,box-shadow 0.25s; border-top:4px solid transparent;
        }
        .announce-small-card:hover { transform:translateY(-3px); box-shadow:0 10px 28px rgba(0,0,0,0.08); }
        .accent-blue { border-top-color:#3b82f6; }
        .accent-gold { border-top-color:#fbbf24; }
        .announce-small-top { display:flex; justify-content:space-between; align-items:center; }
        .announce-date-sm { display:flex; align-items:center; gap:5px; font-size:0.75rem; color:#94a3b8; }
        .announce-small-card h3 { font-size:1.05rem; font-weight:700; color:#1e2f7a; line-height:1.3; }
        .announce-small-card p { font-size:0.87rem; color:#64748b; line-height:1.6; flex:1; }
        .announce-small-footer { padding-top:14px; border-top:1px solid #f1f5f9; margin-top:auto; }

        /* ── POSTER ── */
        .announce-poster { display:flex; align-items:center; gap:10px; }
        .poster-avatar {
            width:36px; height:36px; border-radius:50%;
            display:flex; align-items:center; justify-content:center;
            font-size:0.72rem; font-weight:700; color:white; flex-shrink:0;
        }
        .poster-avatar-blue   { background:linear-gradient(135deg,#3b82f6,#1d4ed8); }
        .poster-avatar-purple { background:linear-gradient(135deg,#a855f7,#7c3aed); }
        .poster-name { display:block; font-size:0.83rem; font-weight:700; color:#1e293b; }
        .announce-feat-footer .poster-name { color:rgba(255,255,255,0.9); }
        .poster-role { display:block; font-size:0.72rem; color:#94a3b8; }
        .announce-feat-footer .poster-role { color:rgba(255,255,255,0.55); }

        /* ── HAMBURGER ── */
        .hamburger-btn { display:none; background:none; border:none; color:var(--primary-blue); font-size:1.6rem; cursor:pointer; padding:4px 8px; line-height:1; }

        /* ── MOBILE NAV ── */
        .mobile-nav-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:998; }
        .mobile-nav-overlay.open { display:block; }
        .mobile-nav-drawer {
            position:fixed; top:0; left:-300px; width:270px; height:100%;
            background:linear-gradient(180deg,#162152 0%,#0d1535 100%);
            z-index:999; transition:left 0.3s ease; padding:20px 15px;
            display:flex; flex-direction:column; gap:6px; overflow-y:auto;
        }
        .mobile-nav-drawer.open { left:0; }
        .mobile-nav-close { align-self:flex-end; background:none; border:none; color:#cbd5e1; font-size:1.4rem; cursor:pointer; margin-bottom:15px; }
        .mobile-nav-drawer .mobile-brand { text-align:center; color:white; margin-bottom:20px; padding-bottom:15px; border-bottom:1px solid rgba(255,255,255,0.08); }
        .mobile-nav-drawer .mobile-brand p { font-size:0.82rem; font-weight:700; line-height:1.4; }
        .mobile-nav-drawer .mobile-brand span { display:inline-block; margin-top:6px; background:rgba(251,191,36,0.15); border:1px solid rgba(251,191,36,0.3); color:#fbbf24; border-radius:50px; padding:2px 12px; font-size:0.7rem; font-weight:700; text-transform:uppercase; }
        .mobile-nav-drawer .nav-item { display:flex; align-items:center; padding:12px 15px; color:#94a3b8; text-decoration:none; border-radius:10px; font-weight:500; transition:background 0.2s; }
        .mobile-nav-drawer .nav-item i { margin-right:12px; width:18px; text-align:center; }
        .mobile-nav-drawer .nav-item:hover { background:rgba(255,255,255,0.08); color:white; }
        .mobile-nav-drawer .nav-item.active { background:rgba(251,191,36,0.12); color:#fbbf24; }
        .mobile-logout { margin-top:auto; padding-top:15px; border-top:1px solid rgba(255,255,255,0.08); }

        @media (max-width:768px) {
            body { overflow-x:hidden; overflow-y:auto; flex-direction:column; height:auto; min-height:100vh; }
            .sidebar { display:none; }
            .hamburger-btn { display:block; }
            .content-area { width:100%; overflow-x:hidden; overflow-y:visible; }
            .main-header { padding:12px 16px; position:sticky; top:0; z-index:100; }
            .main-header h1 { font-size:1.05rem; }
            .header-user span { display:none; }
            .scroll-container { padding:16px; overflow-y:visible; }
            .announce-summary-bar { flex-direction:column; align-items:flex-start; }
            .announce-featured-card { padding:24px 20px 20px; border-radius:18px; }
            .announce-feat-header { flex-direction:column; gap:14px; }
            .announce-feat-header h2 { font-size:1.2rem; }
            .announce-cards-grid { grid-template-columns:1fr; }
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-top">
        <div class="brand-section">
            <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo" class="school-logo">
            <h2 class="school-name">DIVINE WORD COLLEGE<br>OF URDANETA</h2>
            <p class="sub-brand">Senior High</p>
        </div>
        <nav class="nav-menu">
            <a href="{{ route('shs.announcement') }}" class="nav-item active"><i class="fas fa-bullhorn"></i> Announcement</a>
            <a href="{{ route('shs.assignments') }}"  class="nav-item"><i class="fas fa-tasks"></i> Assignments</a>
            <a href="{{ route('shs.quizzes') }}"      class="nav-item"><i class="fas fa-edit"></i> Quizzes</a>
            <a href="{{ route('shs.gradebook') }}"    class="nav-item"><i class="fas fa-chart-line"></i> Gradebook</a>
            <a href="{{ route('shs.calendar') }}"     class="nav-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
            <a href="{{ route('shs.logs') }}"         class="nav-item"><i class="fas fa-history"></i> Activity Logs</a>
        </nav>
    </div>
    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('shs.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Log out
            </button>
        </form>
    </div>
</aside>

<main class="content-area">

    <header class="main-header">
        <div style="display:flex; align-items:center; gap:12px;">
            <button class="hamburger-btn" id="hamburger-btn" aria-label="Open menu">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Announcements</h1>
        </div>
        <a href="{{ route('shs.profile') }}" class="header-user">
            <i class="fas fa-user-graduate"></i>
            <span>{{ session('shs_student_name') }}</span>
        </a>
    </header>

    <div class="scroll-container">

        {{-- ── Summary Bar ── --}}
        <div class="announce-summary-bar">
            <div class="announce-summary-left">
                <i class="fas fa-bullhorn"></i>
                <span><strong>3</strong> announcements &mdash; March 2026</span>
            </div>
            <div class="announce-summary-right">
                <span class="announce-tag tag-urgent"><i class="fas fa-exclamation-circle"></i> 1 Urgent</span>
                <span class="announce-tag tag-academic">1 Academic</span>
                <span class="announce-tag tag-event">1 Event</span>
            </div>
        </div>

        {{-- ── Featured Card ── --}}
        <div class="announce-featured-card">
            <div class="announce-feat-deco"></div>
            <div class="announce-feat-header">
                <div class="announce-feat-icon-wrap">
                    <i class="fas fa-flask"></i>
                </div>
                <div>
                    <span class="announce-tag tag-urgent" style="margin-bottom:10px; display:inline-flex;">
                        <i class="fas fa-exclamation-circle"></i> Urgent
                    </span>
                    <h2>STEM Innovation Expo 2026</h2>
                    <p>Final project proposals for the upcoming Innovation Expo are due this Friday. Ensure your prototypes are ready for initial inspection by the strand coordinators.</p>
                </div>
            </div>
            <div class="announce-feat-footer">
                <div class="announce-poster">
                    <div class="poster-avatar poster-avatar-blue">CR</div>
                    <div>
                        <span class="poster-name">Mr. Carlo Miguel Reyes</span>
                        <span class="poster-role">SHS Coordinator</span>
                    </div>
                </div>
                <span class="announce-date"><i class="far fa-calendar-alt"></i> March 12, 2026</span>
            </div>
        </div>

        {{-- ── Small Cards ── --}}
        <div class="announce-cards-grid">

            <div class="announce-small-card accent-blue">
                <div class="announce-small-top">
                    <span class="announce-tag tag-academic">Academic</span>
                    <span class="announce-date-sm"><i class="far fa-calendar-alt"></i> Mar 15, 2026</span>
                </div>
                <h3>Quarterly Exam Permits</h3>
                <p>Examination permits are now available at the Registrar's office. Please secure yours before the exam week starts to avoid delays.</p>
                <div class="announce-small-footer">
                    <div class="announce-poster">
                        <div class="poster-avatar poster-avatar-blue">AE</div>
                        <div>
                            <span class="poster-name">Anthony Edwards</span>
                            <span class="poster-role">School Admin</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="announce-small-card accent-gold">
                <div class="announce-small-top">
                    <span class="announce-tag tag-event">Event</span>
                    <span class="announce-date-sm"><i class="far fa-calendar-alt"></i> Mar 18, 2026</span>
                </div>
                <h3>Foundation Day Preparations</h3>
                <p>Join the student council meeting this afternoon at the SHS Building Lobby to discuss the booth themes and student activities.</p>
                <div class="announce-small-footer">
                    <div class="announce-poster">
                        <div class="poster-avatar poster-avatar-purple">AE</div>
                        <div>
                            <span class="poster-name">Anthony Edwards</span>
                            <span class="poster-role">School Admin</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

{{-- ── Mobile nav overlay + drawer ── --}}
<div class="mobile-nav-overlay" id="mobile-nav-overlay"></div>
<div class="mobile-nav-drawer" id="mobile-nav-drawer">
    <button class="mobile-nav-close" id="mobile-nav-close" aria-label="Close menu">
        <i class="fas fa-times"></i>
    </button>
    <div class="mobile-brand">
        <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo" style="width:60px; margin:0 auto 8px; display:block;">
        <p>DIVINE WORD COLLEGE<br>OF URDANETA</p>
        <span>Senior High</span>
    </div>
    <a href="{{ route('shs.announcement') }}" class="nav-item active"><i class="fas fa-bullhorn"></i> Announcement</a>
    <a href="{{ route('shs.assignments') }}"  class="nav-item"><i class="fas fa-tasks"></i> Assignments</a>
    <a href="{{ route('shs.quizzes') }}"      class="nav-item"><i class="fas fa-edit"></i> Quizzes</a>
    <a href="{{ route('shs.gradebook') }}"    class="nav-item"><i class="fas fa-chart-line"></i> Gradebook</a>
    <a href="{{ route('shs.calendar') }}"     class="nav-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
    <a href="{{ route('shs.logs') }}"         class="nav-item"><i class="fas fa-history"></i> Activity Logs</a>
    <div class="mobile-logout">
        <form method="POST" action="{{ route('shs.logout') }}">
            @csrf
            <button type="submit" style="background:none; border:none; cursor:pointer; color:#fca5a5; font-weight:600; padding:10px; width:100%; border-radius:8px; font-family:'Afacad',sans-serif; font-size:1rem; display:flex; align-items:center; justify-content:center; gap:8px;">
                <i class="fas fa-sign-out-alt"></i> Log out
            </button>
        </form>
    </div>
</div>

<script>
(function () {
    var hamburgerBtn = document.getElementById('hamburger-btn');
    var drawer       = document.getElementById('mobile-nav-drawer');
    var overlay      = document.getElementById('mobile-nav-overlay');
    var closeBtn     = document.getElementById('mobile-nav-close');

    function openMenu()  { drawer.classList.add('open');    overlay.classList.add('open');    document.body.style.overflow = 'hidden'; }
    function closeMenu() { drawer.classList.remove('open'); overlay.classList.remove('open'); document.body.style.overflow = ''; }

    if (hamburgerBtn) hamburgerBtn.addEventListener('click', openMenu);
    if (closeBtn)     closeBtn.addEventListener('click', closeMenu);
    if (overlay)      overlay.addEventListener('click', closeMenu);
})();
</script>

</body>
</html>
