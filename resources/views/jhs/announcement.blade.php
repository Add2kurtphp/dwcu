<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements | DWCU Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css'])
    <style>
        :root {
            --primary-blue: #1e2f7a;
            --sidebar-dark: #162152;
            --accent-blue: #283593;
            --bg-light: #f0f4f8;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --white: #ffffff;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.07);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Afacad', sans-serif; }

        body { display: flex; height: 100vh; background-color: var(--bg-light); color: var(--text-dark); overflow: hidden; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 270px;
            background: linear-gradient(180deg, #162152 0%, #0d1535 100%);
            color: var(--white);
            display: flex; flex-direction: column; justify-content: space-between;
            padding: 20px; box-shadow: 4px 0 15px rgba(0,0,0,0.15); flex-shrink: 0;
        }
        .brand-section { text-align: center; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 18px; margin-bottom: 16px; }
        .school-logo { width: 75px; margin: 0 auto 10px; display: block; filter: drop-shadow(0 0 10px rgba(255,255,255,0.1)); }
        .school-name { font-size: 0.82rem; font-weight: 700; line-height: 1.4; letter-spacing: 0.5px; }
        .sub-brand {
            display: inline-block; margin-top: 10px;
            background: rgba(173,255,47,0.15); border: 1px solid rgba(173,255,47,0.3);
            color: #adff2f; border-radius: 50px; padding: 3px 14px;
            font-size: 0.72rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;
        }
        .nav-menu { display: flex; flex-direction: column; gap: 3px; }
        .nav-item {
            display: flex; align-items: center; padding: 11px 16px; color: #94a3b8;
            text-decoration: none; border-radius: 12px; transition: all 0.25s ease;
            font-weight: 500; font-size: 0.95rem;
        }
        .nav-item i { margin-right: 13px; font-size: 1rem; width: 18px; text-align: center; }
        .nav-item:hover { background: rgba(255,255,255,0.08); color: var(--white); transform: translateX(4px); }
        .nav-item.active { background: rgba(173,255,47,0.12); color: #adff2f; border: 1px solid rgba(173,255,47,0.2); }
        .sidebar-bottom { padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.08); }
        .logout-btn {
            display: flex; align-items: center; justify-content: center; gap: 10px;
            width: 100%; padding: 12px; border-radius: 10px; background: transparent;
            color: #fca5a5; border: none; cursor: pointer;
            font-weight: 600; font-size: 0.95rem; font-family: 'Afacad', sans-serif;
            transition: background 0.25s, color 0.25s;
        }
        .logout-btn:hover { background: rgba(248,113,113,0.15); color: #fff; }

        /* ── CONTENT AREA ── */
        .content-area { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        .main-header {
            background: var(--white); padding: 18px 40px;
            display: flex; justify-content: space-between; align-items: center;
            border-bottom: 1px solid #e2e8f0; flex-shrink: 0;
        }
        .main-header h1 { font-size: 1.35rem; font-weight: 700; color: var(--primary-blue); }
        .header-user {
            display: flex; align-items: center; gap: 10px; padding: 8px 16px;
            border-radius: 50px; cursor: pointer; transition: all 0.2s ease; border: 1px solid transparent;
            text-decoration: none;
        }
        .header-user:hover { background-color: #f1f5f9; border-color: #e2e8f0; }
        .header-user i { font-size: 1.5rem; color: var(--primary-blue); }
        .header-user span { font-weight: 600; font-size: 0.9rem; color: var(--text-dark); }
        .scroll-container { padding: 30px 40px; overflow-y: auto; flex: 1; }

        /* ── HAMBURGER ── */
        .hamburger-btn { display: none; background: none; border: none; color: var(--primary-blue); font-size: 1.6rem; cursor: pointer; padding: 4px 8px; line-height: 1; }

        /* ── MOBILE NAV ── */
        .mobile-nav-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 998; }
        .mobile-nav-overlay.open { display: block; }
        .mobile-nav-drawer {
            position: fixed; top: 0; left: -300px; width: 270px; height: 100%;
            background: linear-gradient(180deg, #162152 0%, #0d1535 100%);
            z-index: 999; transition: left 0.3s ease; padding: 20px 15px;
            display: flex; flex-direction: column; gap: 6px; overflow-y: auto;
        }
        .mobile-nav-drawer.open { left: 0; }
        .mobile-nav-close { align-self: flex-end; background: none; border: none; color: #cbd5e1; font-size: 1.4rem; cursor: pointer; margin-bottom: 15px; }
        .mobile-nav-drawer .mobile-brand { text-align: center; color: white; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.08); }
        .mobile-nav-drawer .mobile-brand p { font-size: 0.82rem; font-weight: 700; line-height: 1.4; }
        .mobile-nav-drawer .mobile-brand span { display: inline-block; margin-top: 6px; background: rgba(173,255,47,0.15); border: 1px solid rgba(173,255,47,0.3); color: #adff2f; border-radius: 50px; padding: 2px 12px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
        .mobile-nav-drawer .nav-item { display: flex; align-items: center; padding: 12px 15px; color: #94a3b8; text-decoration: none; border-radius: 10px; font-weight: 500; transition: background 0.2s; }
        .mobile-nav-drawer .nav-item i { margin-right: 12px; width: 18px; text-align: center; }
        .mobile-nav-drawer .nav-item:hover { background: rgba(255,255,255,0.08); color: white; }
        .mobile-logout { margin-top: auto; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.08); }

        /* ── PAGE SUMMARY BAR ── */
        .announce-summary-bar {
            display: flex; justify-content: space-between; align-items: center;
            background: white; border-radius: 14px; padding: 14px 22px;
            margin-bottom: 22px; border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .announce-summary-left { display: flex; align-items: center; gap: 10px; font-size: 0.9rem; color: #475569; }
        .announce-summary-left i { color: #1e2f7a; font-size: 1rem; }
        .announce-summary-date { font-size: 0.82rem; color: #94a3b8; display: flex; align-items: center; gap: 6px; }

        /* ── ANNOUNCEMENT CARDS BASE ── */
        .announcement-card {
            background: white; border-radius: 20px; padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;
            display: flex; flex-direction: column;
            transition: box-shadow 0.25s, transform 0.25s;
        }
        .announcement-card:hover { box-shadow: 0 8px 30px rgba(30,47,122,0.1); transform: translateY(-2px); }

        /* ── TAGS ── */
        .announce-tag {
            display: inline-flex; align-items: center; gap: 5px;
            border-radius: 50px; padding: 4px 12px; font-size: 0.72rem;
            font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 10px;
        }
        .tag-general  { background: rgba(30,47,122,0.08);    color: #1e2f7a; }
        .tag-academic { background: rgba(251,191,36,0.12);   color: #b45309; }
        .tag-event    { background: rgba(139,92,246,0.1);    color: #7c3aed; }

        /* ── FEATURED CARD ── */
        .announcement-card.featured {
            background: linear-gradient(135deg, #1e2f7a 0%, #283593 100%);
            color: white; border: none; margin-bottom: 22px;
            position: relative; overflow: hidden;
        }
        .announcement-card.featured::after {
            content: ''; position: absolute; width: 280px; height: 280px;
            border-radius: 50%; border: 50px solid rgba(255,255,255,0.04);
            top: -80px; right: -60px; pointer-events: none;
        }
        .announcement-card.featured .tag-general { background: rgba(255,255,255,0.15); color: rgba(255,255,255,0.9); }
        .featured-header { display: flex; gap: 18px; align-items: flex-start; margin-bottom: 18px; }
        .featured-icon-wrap {
            width: 54px; height: 54px; border-radius: 14px;
            background: rgba(255,255,255,0.15); display: flex; align-items: center;
            justify-content: center; font-size: 1.4rem; color: white; flex-shrink: 0;
        }
        .featured-title-group h2 { font-size: 1.4rem; font-weight: 700; color: white; line-height: 1.3; }
        .announcement-card.featured .date  { color: rgba(255,255,255,0.6); }
        .announcement-card.featured .body-text { color: rgba(255,255,255,0.8); margin-bottom: 22px; }
        .announcement-card.featured .poster-name { color: white; }
        .announcement-card.featured .poster-role { color: rgba(255,255,255,0.55); }
        .announcement-card.featured .poster-avatar { border: 2px solid rgba(255,255,255,0.3); }
        .announcement-card.featured .card-footer { border-top-color: rgba(255,255,255,0.12); }

        /* ── SMALL CARDS ── */
        .secondary-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .announcement-card.small { border-top: 4px solid transparent; }
        .announcement-card.small.accent-yellow { border-top-color: #fbbf24; }
        .announcement-card.small.accent-purple { border-top-color: #8b5cf6; }
        .small-card-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; flex-wrap: wrap; gap: 8px; }
        .announcement-card.small h2 { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 10px; line-height: 1.3; }

        /* ── SHARED ── */
        .date { font-size: 0.82rem; color: #94a3b8; display: inline-flex; align-items: center; gap: 5px; }
        .body-text { font-size: 0.92rem; line-height: 1.7; color: #475569; margin-bottom: 22px; flex: 1; }
        .card-footer {
            display: flex; justify-content: space-between; align-items: center;
            margin-top: auto; padding-top: 16px; border-top: 1px solid rgba(0,0,0,0.05);
        }
        .poster-info { display: flex; align-items: center; gap: 10px; }
        .poster-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.72rem; font-weight: 700; color: white; flex-shrink: 0;
        }
        .poster-avatar-blue   { background: linear-gradient(135deg, #1e2f7a, #3949ab); }
        .poster-avatar-green  { background: linear-gradient(135deg, #16a34a, #22c55e); }
        .poster-avatar-purple { background: linear-gradient(135deg, #7c3aed, #a78bfa); }
        .poster-name { font-size: 0.88rem; font-weight: 600; color: #334155; display: block; }
        .poster-role { font-size: 0.75rem; color: #94a3b8; display: block; margin-top: 1px; }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .hamburger-btn { display: block; }
            .scroll-container { padding: 14px; }
            .main-header {
                padding: 12px 16px; position: sticky; top: 0; z-index: 100;
                display: flex; flex-direction: row; justify-content: space-between;
                align-items: center; flex-wrap: nowrap;
            }
            .main-header > div:first-child { display: flex; align-items: center; gap: 10px; min-width: 0; flex: 1; }
            .main-header h1 { font-size: 1.05rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .header-user { flex-shrink: 0; padding: 6px 10px; }
            .header-user span { display: none; }
            .header-user i { font-size: 1.4rem; }
            .secondary-grid { grid-template-columns: 1fr; gap: 14px; }
            .announcement-card { padding: 20px; border-radius: 16px; }
            .featured-title-group h2 { font-size: 1.15rem; }
            .small-card-top { flex-direction: column; align-items: flex-start; }
            .announce-summary-bar { flex-direction: column; align-items: flex-start; gap: 6px; }
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-top">
        <div class="brand-section">
            <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo" class="school-logo">
            <h2 class="school-name">DIVINE WORD COLLEGE<br>OF URDANETA</h2>
            <p class="sub-brand">Junior High</p>
        </div>
        <nav class="nav-menu">
            <a href="{{ route('jhs.announcement') }}" class="nav-item active"><i class="fas fa-bullhorn"></i> Announcement</a>
            <a href="{{ route('jhs.assignments') }}" class="nav-item"><i class="fas fa-tasks"></i> Assignments</a>
            <a href="{{ route('jhs.quizzes') }}" class="nav-item"><i class="fas fa-edit"></i> Quizzes</a>
            <a href="{{ route('jhs.gradebook') }}" class="nav-item"><i class="fas fa-chart-line"></i> Gradebook</a>
            <a href="{{ route('jhs.calendar') }}" class="nav-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
            <a href="{{ route('jhs.logs') }}" class="nav-item"><i class="fas fa-history"></i> Activity Logs</a>
        </nav>
    </div>
    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('jhs.logout') }}">
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
        <a href="{{ route('jhs.profile') }}" class="header-user">
            <i class="fas fa-user-circle"></i>
            <span>{{ session('jhs_student_name') }}</span>
        </a>
    </header>

    <div class="scroll-container">

        {{-- Page summary bar --}}
        <div class="announce-summary-bar">
            <div class="announce-summary-left">
                <i class="fas fa-bullhorn"></i>
                <span><strong>3</strong> announcements for your section</span>
            </div>
            <span class="announce-summary-date">
                <i class="fas fa-calendar-alt"></i> A.Y. 2025 – 2026
            </span>
        </div>

        {{-- Featured announcement --}}
        <article class="announcement-card featured">
            <div class="featured-header">
                <div class="featured-icon-wrap">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="featured-title-group">
                    <span class="announce-tag tag-general">
                        <i class="fas fa-star"></i> Featured
                    </span>
                    <h2>School Orientation for New Students</h2>
                    <span class="date"><i class="fas fa-calendar-alt"></i> April 15, 2026</span>
                </div>
            </div>
            <p class="body-text">
                Welcome to all new students! Please attend the school orientation in the gymnasium at 8:00 AM.
                Important information about school policies, campus facilities, and academic expectations will be covered.
            </p>
            <div class="card-footer">
                <div class="poster-info">
                    <div class="poster-avatar poster-avatar-blue">AE</div>
                    <div>
                        <span class="poster-name">Anthony Edwards</span>
                        <span class="poster-role">School Administrator</span>
                    </div>
                </div>
            </div>
        </article>

        {{-- Secondary grid --}}
        <div class="secondary-grid">

            <article class="announcement-card small accent-yellow">
                <div class="small-card-top">
                    <span class="announce-tag tag-academic">
                        <i class="fas fa-book"></i> Academic
                    </span>
                    <span class="date"><i class="fas fa-calendar-alt"></i> April 15, 2026</span>
                </div>
                <h2>Quiz in Mathematics</h2>
                <p class="body-text">There will be a Math quiz on March 17, 2026. Make sure to review the topics we've discussed in class, including algebra and geometry.</p>
                <div class="card-footer">
                    <div class="poster-info">
                        <div class="poster-avatar poster-avatar-green">CS</div>
                        <div>
                            <span class="poster-name">Mrs. Catherine Santos</span>
                            <span class="poster-role">Math Teacher</span>
                        </div>
                    </div>
                </div>
            </article>

            <article class="announcement-card small accent-purple">
                <div class="small-card-top">
                    <span class="announce-tag tag-event">
                        <i class="fas fa-calendar-check"></i> Event
                    </span>
                    <span class="date"><i class="fas fa-calendar-alt"></i> April 20, 2026</span>
                </div>
                <h2>Upcoming Career Guidance Seminar</h2>
                <p class="body-text">A Career Guidance Seminar will be held on April 28, 2026 at the school auditorium. All students are encouraged to attend to learn about college preparation, strand selection, and future career opportunities.</p>
                <div class="card-footer">
                    <div class="poster-info">
                        <div class="poster-avatar poster-avatar-purple">AE</div>
                        <div>
                            <span class="poster-name">Anthony Edwards</span>
                            <span class="poster-role">School Admin</span>
                        </div>
                    </div>
                </div>
            </article>

        </div>
    </div>
</main>

{{-- Mobile nav overlay + drawer --}}
<div class="mobile-nav-overlay" id="mobile-nav-overlay"></div>
<div class="mobile-nav-drawer" id="mobile-nav-drawer">
    <button class="mobile-nav-close" id="mobile-nav-close" aria-label="Close menu">
        <i class="fas fa-times"></i>
    </button>
    <div class="mobile-brand">
        <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo" style="width:60px; margin:0 auto 8px; display:block;">
        <p>DIVINE WORD COLLEGE<br>OF URDANETA</p>
        <span>Junior High</span>
    </div>
    <a href="{{ route('jhs.announcement') }}" class="nav-item active"><i class="fas fa-bullhorn"></i> Announcement</a>
    <a href="{{ route('jhs.assignments') }}" class="nav-item"><i class="fas fa-tasks"></i> Assignments</a>
    <a href="{{ route('jhs.quizzes') }}" class="nav-item"><i class="fas fa-edit"></i> Quizzes</a>
    <a href="{{ route('jhs.gradebook') }}" class="nav-item"><i class="fas fa-chart-line"></i> Gradebook</a>
    <a href="{{ route('jhs.calendar') }}" class="nav-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
    <a href="{{ route('jhs.logs') }}" class="nav-item"><i class="fas fa-history"></i> Activity Logs</a>
    <div class="mobile-logout">
        <form method="POST" action="{{ route('jhs.logout') }}">
            @csrf
            <button type="submit" style="background:none; border:none; cursor:pointer; color:#fca5a5; font-weight:600; padding:10px; width:100%; border-radius:8px; font-family:'Afacad',sans-serif; font-size:1rem; display:flex; align-items:center; justify-content:center; gap:8px;">
                <i class="fas fa-sign-out-alt"></i> Log out
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var hamburgerBtn = document.getElementById('hamburger-btn');
    var drawer       = document.getElementById('mobile-nav-drawer');
    var overlay      = document.getElementById('mobile-nav-overlay');
    var closeBtn     = document.getElementById('mobile-nav-close');

    function openMenu()  { drawer.classList.add('open');    overlay.classList.add('open');    document.body.style.overflow = 'hidden'; }
    function closeMenu() { drawer.classList.remove('open'); overlay.classList.remove('open'); document.body.style.overflow = ''; }

    if (hamburgerBtn) hamburgerBtn.addEventListener('click', openMenu);
    if (closeBtn)     closeBtn.addEventListener('click', closeMenu);
    if (overlay)      overlay.addEventListener('click', closeMenu);
});
</script>

</body>
</html>
