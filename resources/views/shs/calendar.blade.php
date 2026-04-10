<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar | DWCU SHS Portal</title>
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
            display:flex; justify-content:space-between; align-items:center; flex-wrap:nowrap;
            border-bottom:1px solid #e2e8f0; flex-shrink:0;
        }
        .main-header h1 { font-size:1.35rem; font-weight:700; color:var(--primary-blue); }
        .header-user {
            display:flex; align-items:center; gap:10px; padding:8px 16px;
            border-radius:50px; text-decoration:none; transition:all 0.2s ease; border:1px solid transparent;
            flex-shrink:0;
        }
        .header-user:hover { background-color:#f1f5f9; border-color:#e2e8f0; }
        .header-user i { font-size:1.5rem; color:var(--primary-blue); }
        .header-user span { font-weight:600; font-size:0.9rem; color:var(--text-dark); }
        .scroll-container { padding:30px 40px; overflow-y:auto; flex:1; }

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

        /* ── SUMMARY BAR ── */
        .cal-summary-bar {
            display:flex; justify-content:space-between; align-items:center;
            background:white; border-radius:14px; padding:14px 22px;
            margin-bottom:22px; border:1px solid #e2e8f0;
            box-shadow:0 2px 8px rgba(0,0,0,0.04); flex-wrap:wrap; gap:12px;
        }
        .cal-summary-left { display:flex; align-items:center; gap:10px; font-size:0.9rem; color:#475569; }
        .cal-summary-left i { color:#1e2f7a; font-size:1rem; }
        .cal-summary-right { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
        .cal-tag {
            display:inline-flex; align-items:center; gap:5px;
            padding:4px 12px; border-radius:50px; font-size:0.72rem;
            font-weight:700; text-transform:uppercase; letter-spacing:0.04em;
        }
        .tag-event    { background:#dbeafe; color:#1d4ed8; }
        .tag-deadline { background:#fee2e2; color:#dc2626; }

        /* ── CALENDAR BODY ── */
        .cal-body { display:flex; gap:22px; align-items:flex-start; }

        /* ── MAIN CALENDAR CARD ── */
        .cal-main-card {
            flex:1; background:white; border-radius:20px;
            border:1px solid #f1f5f9; box-shadow:0 4px 16px rgba(0,0,0,0.05); overflow:hidden;
        }
        .cal-card-header {
            background:linear-gradient(135deg,#1e2f7a 0%,#283593 60%,#3949ab 100%);
            padding:20px 28px; display:flex; justify-content:space-between;
            align-items:center; color:white;
        }
        .cal-month-title h2 { font-size:1.3rem; font-weight:700; color:white; text-align:center; line-height:1.2; }
        .cal-month-title span { font-size:0.75rem; color:rgba(255,255,255,0.6); display:block; text-align:center; margin-top:2px; }
        .cal-nav-btn {
            width:36px; height:36px; border-radius:10px;
            border:1px solid rgba(255,255,255,0.25); background:rgba(255,255,255,0.12);
            color:white; display:flex; align-items:center; justify-content:center;
            cursor:pointer; font-size:0.85rem; transition:all 0.2s; flex-shrink:0;
        }
        .cal-nav-btn:hover { background:rgba(255,255,255,0.25); }
        .cal-grid-wrap { padding:22px 24px 16px; }
        .cal-day-labels {
            display:grid; grid-template-columns:repeat(7,1fr);
            text-align:center; font-size:0.72rem; font-weight:700; color:#94a3b8;
            letter-spacing:0.05em; margin-bottom:12px; padding-bottom:12px;
            border-bottom:1px solid #f1f5f9;
        }
        .cal-days-grid { display:grid; grid-template-columns:repeat(7,1fr); gap:8px; }
        .calendar-day-box {
            aspect-ratio:1; background:white; border:1px solid #f1f5f9; border-radius:10px;
            display:flex; flex-direction:column; align-items:center; justify-content:center;
            font-size:0.95rem; font-weight:500; color:#475569; cursor:pointer;
            position:relative; transition:all 0.2s;
        }
        .calendar-day-box:hover {
            background:#f0f4ff; border-color:#c7d2fe; color:#1e2f7a;
            transform:translateY(-2px); box-shadow:0 4px 12px rgba(30,47,122,0.1);
        }
        .calendar-day-box.empty { background:transparent; border:none; cursor:default; pointer-events:none; }
        .calendar-day-box.current-day {
            background:linear-gradient(135deg,#1e2f7a,#3949ab) !important;
            color:white !important; border:none; box-shadow:0 4px 14px rgba(30,47,122,0.35); font-weight:700;
        }
        .calendar-day-box.current-day:hover { transform:translateY(-2px); }
        .event-dot { width:5px; height:5px; border-radius:50%; position:absolute; bottom:6px; }
        .dot-school   { background:#3b82f6; }
        .dot-research { background:#a855f7; }
        .dot-physics  { background:#0ea5e9; }
        .dot-math     { background:#10b981; }
        .cal-legend {
            display:flex; align-items:center; gap:18px; flex-wrap:wrap;
            padding:14px 24px 18px; border-top:1px solid #f1f5f9;
        }
        .legend-item { display:flex; align-items:center; gap:6px; font-size:0.75rem; color:#64748b; font-weight:600; }
        .legend-dot { width:8px; height:8px; border-radius:50%; display:inline-block; flex-shrink:0; }

        /* ── SIDE PANEL ── */
        .cal-side-panel { width:280px; flex-shrink:0; }
        .cal-deadlines-card {
            background:white; border-radius:20px;
            border:1px solid #f1f5f9; box-shadow:0 4px 16px rgba(0,0,0,0.05); overflow:hidden;
        }
        .cal-deadlines-header {
            background:linear-gradient(135deg,#1e2f7a,#283593);
            padding:18px 20px; display:flex; align-items:center; gap:12px; color:white;
        }
        .cal-deadlines-icon {
            width:38px; height:38px; background:rgba(255,255,255,0.15);
            border:1px solid rgba(255,255,255,0.2); border-radius:10px;
            display:flex; align-items:center; justify-content:center;
            font-size:0.9rem; flex-shrink:0;
        }
        .cal-deadlines-header h3 { font-size:0.95rem; font-weight:700; color:white; margin-bottom:2px; }
        .cal-deadlines-header p { font-size:0.75rem; color:rgba(255,255,255,0.6); }
        .cal-deadlines-list { padding:14px 16px 16px; display:flex; flex-direction:column; gap:10px; }
        .cal-deadline-item {
            display:flex; align-items:center; gap:12px;
            background:#f8fafc; border-radius:12px; padding:12px 14px;
            border-left:4px solid #cbd5e1; transition:transform 0.2s,box-shadow 0.2s;
        }
        .cal-deadline-item:hover { transform:translateX(3px); box-shadow:0 2px 8px rgba(0,0,0,0.06); }
        .border-research { border-left-color:#a855f7; }
        .border-physics  { border-left-color:#3b82f6; }
        .border-math     { border-left-color:#10b981; }
        .border-bio      { border-left-color:#f59e0b; }
        .cal-date-box { display:flex; flex-direction:column; align-items:center; flex-shrink:0; min-width:36px; }
        .cal-date-num { font-size:1.2rem; font-weight:800; color:#1e2f7a; line-height:1; }
        .cal-date-mon { font-size:0.62rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.04em; }
        .cal-deadline-info h4 { font-size:0.83rem; font-weight:700; color:#1e293b; margin-bottom:3px; }
        .cal-deadline-info p { font-size:0.75rem; color:#64748b; display:flex; align-items:center; gap:5px; }
        .cal-deadline-info p i { font-size:0.65rem; color:#94a3b8; }

        @media (max-width:900px) { .cal-side-panel { width:240px; } }

        @media (max-width:768px) {
            .sidebar { display:none; }
            .hamburger-btn { display:block; }
            .main-header { padding:12px 16px; position:sticky; top:0; z-index:100; display:flex; flex-direction:row; justify-content:space-between; align-items:center; flex-wrap:nowrap; }
            .main-header > div:first-child { display:flex; align-items:center; gap:10px; min-width:0; flex:1; }
            .main-header h1 { font-size:1.05rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
            .header-user { flex-shrink:0; padding:6px 10px; }
            .header-user span { display:none; }
            .header-user i { font-size:1.4rem; }
            .scroll-container { padding:14px; }
            .cal-summary-bar { flex-direction:column; align-items:flex-start; }
            .cal-body { flex-direction:column; gap:18px; }
            .cal-main-card { width:100%; }
            .cal-side-panel { width:100%; }
            .cal-grid-wrap { padding:14px 12px 10px; }
            .cal-days-grid { gap:5px; }
            .calendar-day-box { border-radius:7px; font-size:0.8rem; }
            .calendar-day-box:hover { transform:none; }
            .event-dot { bottom:3px; width:4px; height:4px; }
            .cal-day-labels { font-size:0; }
            .cal-day-labels > div::first-letter { font-size:0.68rem; font-weight:700; color:#94a3b8; }
            .cal-legend { gap:12px; padding:12px 14px 14px; }
            .cal-deadline-item { padding:10px 12px; }
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
            <a href="{{ route('shs.announcement') }}" class="nav-item"><i class="fas fa-bullhorn"></i> Announcement</a>
            <a href="{{ route('shs.assignments') }}"  class="nav-item"><i class="fas fa-tasks"></i> Assignments</a>
            <a href="{{ route('shs.quizzes') }}"      class="nav-item"><i class="fas fa-edit"></i> Quizzes</a>
            <a href="{{ route('shs.gradebook') }}"    class="nav-item"><i class="fas fa-chart-line"></i> Gradebook</a>
            <a href="{{ route('shs.calendar') }}"     class="nav-item active"><i class="fas fa-calendar-alt"></i> Calendar</a>
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
            <h1>Calendar</h1>
        </div>
        <a href="{{ route('shs.profile') }}" class="header-user">
            <i class="fas fa-user-graduate"></i>
            <span>{{ session('shs_student_name') }}</span>
        </a>
    </header>

    <div class="scroll-container">

        {{-- ── Summary Bar ── --}}
        <div class="cal-summary-bar">
            <div class="cal-summary-left">
                <i class="fas fa-calendar-alt"></i>
                <span><strong>March 2026</strong> &mdash; Academic Calendar</span>
            </div>
            <div class="cal-summary-right">
                <span class="cal-tag tag-event"><i class="fas fa-circle"></i> 4 Events</span>
                <span class="cal-tag tag-deadline"><i class="fas fa-flag"></i> 4 Deadlines</span>
            </div>
        </div>

        {{-- ── Calendar Body ── --}}
        <div class="cal-body">

            {{-- Main Calendar Card --}}
            <div class="cal-main-card">
                <div class="cal-card-header">
                    <button class="cal-nav-btn" id="prevMonth">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="cal-month-title">
                        <h2 id="current-month">March 2026</h2>
                        <span>1st Semester</span>
                    </div>
                    <button class="cal-nav-btn" id="nextMonth">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

                <div class="cal-grid-wrap">
                    <div class="cal-day-labels">
                        <div>SUN</div>
                        <div>MON</div>
                        <div>TUE</div>
                        <div>WED</div>
                        <div>THU</div>
                        <div>FRI</div>
                        <div>SAT</div>
                    </div>
                    <div id="calendar-days" class="cal-days-grid"></div>
                </div>

                <div class="cal-legend">
                    <span class="legend-item"><span class="legend-dot dot-research"></span> Research</span>
                    <span class="legend-item"><span class="legend-dot dot-physics"></span> Physics</span>
                    <span class="legend-item"><span class="legend-dot dot-math"></span> Calculus</span>
                    <span class="legend-item"><span class="legend-dot dot-school"></span> School Event</span>
                </div>
            </div>

            {{-- Side Panel --}}
            <div class="cal-side-panel">
                <div class="cal-deadlines-card">
                    <div class="cal-deadlines-header">
                        <div class="cal-deadlines-icon">
                            <i class="fas fa-flag"></i>
                        </div>
                        <div>
                            <h3>Upcoming Deadlines</h3>
                            <p>March 2026</p>
                        </div>
                    </div>
                    <div class="cal-deadlines-list">

                        <div class="cal-deadline-item border-research">
                            <div class="cal-date-box">
                                <span class="cal-date-num">10</span>
                                <span class="cal-date-mon">MAR</span>
                            </div>
                            <div class="cal-deadline-info">
                                <h4>Practical Research 2</h4>
                                <p><i class="fas fa-edit"></i> Mid-Unit Quiz (G-Form)</p>
                            </div>
                        </div>

                        <div class="cal-deadline-item border-physics">
                            <div class="cal-date-box">
                                <span class="cal-date-num">22</span>
                                <span class="cal-date-mon">MAR</span>
                            </div>
                            <div class="cal-deadline-info">
                                <h4>General Physics 2</h4>
                                <p><i class="fas fa-tasks"></i> Gauss's Law Problem Set</p>
                            </div>
                        </div>

                        <div class="cal-deadline-item border-math">
                            <div class="cal-date-box">
                                <span class="cal-date-num">25</span>
                                <span class="cal-date-mon">MAR</span>
                            </div>
                            <div class="cal-deadline-info">
                                <h4>Basic Calculus</h4>
                                <p><i class="fas fa-tasks"></i> Differentiation Practice</p>
                            </div>
                        </div>

                        <div class="cal-deadline-item border-bio">
                            <div class="cal-date-box">
                                <span class="cal-date-num">28</span>
                                <span class="cal-date-mon">MAR</span>
                            </div>
                            <div class="cal-deadline-info">
                                <h4>Biology 2</h4>
                                <p><i class="fas fa-tasks"></i> Hardy-Weinberg Poster</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

{{-- ── Mobile Nav Overlay + Drawer ── --}}
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
    <a href="{{ route('shs.announcement') }}" class="nav-item"><i class="fas fa-bullhorn"></i> Announcement</a>
    <a href="{{ route('shs.assignments') }}"  class="nav-item"><i class="fas fa-tasks"></i> Assignments</a>
    <a href="{{ route('shs.quizzes') }}"      class="nav-item"><i class="fas fa-edit"></i> Quizzes</a>
    <a href="{{ route('shs.gradebook') }}"    class="nav-item"><i class="fas fa-chart-line"></i> Gradebook</a>
    <a href="{{ route('shs.calendar') }}"     class="nav-item active"><i class="fas fa-calendar-alt"></i> Calendar</a>
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
    document.addEventListener('DOMContentLoaded', function () {
        const daysContainer = document.getElementById('calendar-days');
        const monthYearText = document.getElementById('current-month');

        const year  = 2026;
        const month = 2;    // March (0-indexed)
        const today = 22;   // March 22, 2026

        const events = {
            8:  { type: 'school'   },
            10: { type: 'research' },
            12: { type: 'school'   },
            20: { type: 'research' },
            22: { type: 'physics'  },
            25: { type: 'math'     },
            28: { type: 'math'     }
        };

        function generateCalendar() {
            daysContainer.innerHTML = '';

            const firstDay    = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            for (let i = 0; i < firstDay; i++) {
                const empty = document.createElement('div');
                empty.classList.add('calendar-day-box', 'empty');
                daysContainer.appendChild(empty);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const dayDiv = document.createElement('div');
                dayDiv.classList.add('calendar-day-box');

                if (day === today) dayDiv.classList.add('current-day');

                dayDiv.innerHTML = `<span>${day}</span>`;

                if (events[day]) {
                    const dot = document.createElement('div');
                    dot.classList.add('event-dot', `dot-${events[day].type}`);
                    dayDiv.appendChild(dot);
                }

                daysContainer.appendChild(dayDiv);
            }
        }

        generateCalendar();
    });

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
