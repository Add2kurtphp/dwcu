<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar | DWCU Portal</title>
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
        .mobile-nav-drawer .nav-item.active { background: rgba(173,255,47,0.12); color: #adff2f; }
        .mobile-logout { margin-top: auto; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.08); }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .hamburger-btn { display: block; }
            .scroll-container { padding: 20px 16px; }
            .main-header {
                padding: 12px 16px; position: sticky; top: 0; z-index: 100;
                display: flex; flex-direction: row;
                justify-content: space-between; align-items: center;
                flex-wrap: nowrap;
            }
            .main-header > div:first-child { display: flex; align-items: center; gap: 10px; min-width: 0; flex: 1; }
            .header-user { flex-shrink: 0; padding: 6px 10px; }
            .header-user span { display: none; }
        }

        /* ── SUMMARY BAR ── */
        .cal-summary-bar {
            display: flex; justify-content: space-between; align-items: center;
            background: white; border-radius: 14px; padding: 14px 22px;
            margin-bottom: 22px; border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04); flex-wrap: wrap; gap: 10px;
        }
        .cal-summary-left { display: flex; align-items: center; gap: 10px; font-size: 0.9rem; color: #475569; }
        .cal-summary-left i { color: #1e2f7a; font-size: 1rem; }
        .cal-summary-right { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
        .cal-summary-chip {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 12px; border-radius: 50px; font-size: 0.72rem;
            font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em;
        }
        .chip-science { background: #e0f2fe; color: #0369a1; }
        .chip-math    { background: #eff6ff; color: #1d4ed8; }
        .chip-english { background: #f5f3ff; color: #7c3aed; }

        /* ── CALENDAR LAYOUT ── */
        .calendar-layout { display: flex; gap: 22px; align-items: flex-start; }

        /* ── CALENDAR CARD ── */
        .calendar-card {
            flex: 2.5; background: white; border-radius: 20px; padding: 28px 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;
        }
        .calendar-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 28px; padding-bottom: 20px; border-bottom: 1px solid #f1f5f9;
        }
        .cal-month-display { display: flex; align-items: center; gap: 12px; }
        .cal-month-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #1e2f7a, #283593);
            border-radius: 10px; display: flex; align-items: center;
            justify-content: center; font-size: 0.9rem; color: white; flex-shrink: 0;
        }
        .calendar-header h2 { font-size: 1.4rem; font-weight: 700; color: #1e293b; }
        .cal-nav-btn {
            background: #f1f5f9; border: 1px solid #e2e8f0; width: 38px; height: 38px;
            border-radius: 50%; cursor: pointer; color: #1e2f7a;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s; font-size: 0.85rem;
        }
        .cal-nav-btn:hover { background: #1e2f7a; color: white; border-color: #1e2f7a; transform: scale(1.05); }

        /* Calendar grid */
        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px; text-align: center; }
        .day-label { font-weight: 700; color: #94a3b8; padding-bottom: 14px; text-transform: uppercase; font-size: 0.72rem; letter-spacing: 0.06em; }
        .days-container { display: contents; }
        .cal-day {
            height: 64px; display: flex; flex-direction: column; align-items: center; justify-content: center;
            border-radius: 12px; border: 1px solid #f1f5f9; cursor: pointer; transition: all 0.2s;
            position: relative; background: #fff; font-size: 0.95rem; font-weight: 500; color: #334155;
        }
        .cal-day:hover { background: #f1f5f9; border-color: #cbd5e1; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.06); }
        .cal-day.today {
            background: linear-gradient(135deg, #1e2f7a, #283593); color: white; font-weight: 700;
            border-color: transparent; box-shadow: 0 4px 14px rgba(30,47,122,0.35);
        }
        .cal-day.has-event { background: #f8fafc; }
        .event-dot { width: 6px; height: 6px; border-radius: 50%; position: absolute; bottom: 7px; }
        .dot-science { background: #0ea5e9; }
        .dot-math    { background: #1d4ed8; }
        .dot-english { background: #7c3aed; }
        .cal-day.today .event-dot { opacity: 0.7; }

        /* Legend */
        .cal-legend {
            display: flex; align-items: center; gap: 20px; flex-wrap: wrap;
            margin-top: 20px; padding-top: 18px; border-top: 1px solid #f1f5f9;
        }
        .legend-item { display: inline-flex; align-items: center; gap: 7px; font-size: 0.8rem; color: #64748b; font-weight: 500; }
        .legend-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }

        /* ── DEADLINES SIDEBAR ── */
        .upcoming-deadlines {
            flex: 1; background: white; border-radius: 20px; padding: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;
        }
        .deadlines-header { display: flex; align-items: center; gap: 14px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9; }
        .deadlines-icon {
            width: 42px; height: 42px; background: linear-gradient(135deg, #1e2f7a, #283593);
            border-radius: 12px; display: flex; align-items: center; justify-content: center;
            font-size: 1rem; color: white; flex-shrink: 0;
        }
        .deadlines-header h3 { font-size: 1rem; font-weight: 700; color: #1e293b; margin-bottom: 2px; }
        .deadlines-header p { font-size: 0.78rem; color: #94a3b8; }

        /* Deadline items */
        .deadline-item {
            display: flex; align-items: center; gap: 12px; padding: 14px 16px;
            border-radius: 14px; margin-bottom: 12px; border: 1px solid #f1f5f9;
            border-left-width: 4px; background: #f8fafc; transition: transform 0.2s, box-shadow 0.2s;
        }
        .deadline-item:last-child { margin-bottom: 0; }
        .deadline-item:hover { transform: translateX(3px); box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
        .science-border { border-left-color: #0ea5e9; }
        .math-border    { border-left-color: #1d4ed8; }
        .english-border { border-left-color: #7c3aed; }
        .deadline-icon-circle {
            width: 36px; height: 36px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; font-size: 0.85rem; flex-shrink: 0;
        }
        .science-circle { background: #e0f2fe; color: #0369a1; }
        .math-circle    { background: #eff6ff; color: #1d4ed8; }
        .english-circle { background: #f5f3ff; color: #7c3aed; }
        .deadline-body { flex: 1; min-width: 0; }
        .deadline-top-row { display: flex; align-items: center; gap: 6px; margin-bottom: 5px; flex-wrap: wrap; }
        .dl-subject-badge {
            display: inline-flex; padding: 2px 9px; border-radius: 50px;
            font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em;
        }
        .badge-science { background: #e0f2fe; color: #0369a1; }
        .badge-math    { background: #eff6ff; color: #1d4ed8; }
        .badge-english { background: #f5f3ff; color: #7c3aed; }
        .dl-type-badge {
            display: inline-flex; padding: 2px 9px; border-radius: 50px;
            font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em;
        }
        .type-quiz { background: #f5f3ff; color: #7c3aed; }
        .type-asst { background: #f0fdf4; color: #16a34a; }
        .deadline-body h4 { font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .deadline-body p { font-size: 0.75rem; color: #94a3b8; }
        .deadline-date-col { flex-shrink: 0; }
        .deadline-date-badge { display: block; text-align: center; padding: 5px 10px; border-radius: 10px; font-size: 0.75rem; font-weight: 700; white-space: nowrap; }
        .deadline-date-badge.urgent { background: #fef2f2; color: #dc2626; }
        .deadline-date-badge.normal { background: #fef9c3; color: #b45309; }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .calendar-layout { flex-direction: column; }
            .upcoming-deadlines { width: 100%; }
        }

        @media (max-width: 768px) {
            .cal-summary-bar { flex-direction: column; align-items: flex-start; gap: 10px; }
            .calendar-card { padding: 18px 14px; border-radius: 16px; }
            .calendar-header { margin-bottom: 14px; padding-bottom: 14px; }
            .calendar-header h2 { font-size: 1.1rem; }
            .calendar-grid { gap: 5px; }
            .day-label { font-size: 0; padding-bottom: 10px; }
            .day-label::first-letter { font-size: 0.7rem; font-weight: 700; color: #94a3b8; }
            .cal-day { height: auto; aspect-ratio: 1 / 1; border-radius: 8px; font-size: 0.8rem; }
            .event-dot { width: 4px; height: 4px; bottom: 3px; }
            .cal-legend { gap: 12px; }
            .deadline-item { padding: 12px; gap: 10px; }
            .deadline-body h4 { font-size: 0.82rem; }
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
                <a href="{{ route('jhs.announcement') }}" class="nav-item">
                    <i class="fas fa-bullhorn"></i> Announcement
                </a>
                <a href="{{ route('jhs.assignments') }}" class="nav-item">
                    <i class="fas fa-tasks"></i> Assignments
                </a>
                <a href="{{ route('jhs.quizzes') }}" class="nav-item">
                    <i class="fas fa-edit"></i> Quizzes
                </a>
                <a href="{{ route('jhs.gradebook') }}" class="nav-item">
                    <i class="fas fa-chart-line"></i> Gradebook
                </a>
                <a href="{{ route('jhs.calendar') }}" class="nav-item active">
                    <i class="fas fa-calendar-alt"></i> Calendar
                </a>
                <a href="{{ route('jhs.logs') }}" class="nav-item">
                    <i class="fas fa-history"></i> Activity Logs
                </a>
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
                <h1>Academic Calendar</h1>
            </div>
            <a href="{{ route('jhs.profile') }}" class="header-user">
                <i class="fas fa-user-circle"></i>
                <span>{{ session('jhs_student_name', 'Student Profile') }}</span>
            </a>
        </header>

        <div class="scroll-container">

            <!-- Summary bar -->
            <div class="cal-summary-bar">
                <div class="cal-summary-left">
                    <i class="fas fa-calendar-alt"></i>
                    <span id="summary-month"><strong>Loading&hellip;</strong></span>
                </div>
                <div class="cal-summary-right">
                    <span class="cal-summary-chip chip-science"><i class="fas fa-lightbulb"></i> Quiz</span>
                    <span class="cal-summary-chip chip-math"><i class="fas fa-tasks"></i> Assignment</span>
                    <span class="cal-summary-chip chip-english"><i class="fas fa-clipboard-list"></i> Examination</span>
                </div>
            </div>

            <!-- Main layout: calendar + deadlines -->
            <div class="calendar-layout">

                <!-- Calendar card -->
                <section class="calendar-card">
                    <div class="calendar-header">
                        <button class="cal-nav-btn" id="prev-month" aria-label="Previous month">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="cal-month-display">
                            <div class="cal-month-icon"><i class="fas fa-calendar-alt"></i></div>
                            <h2 id="current-month">&nbsp;</h2>
                        </div>
                        <button class="cal-nav-btn" id="next-month" aria-label="Next month">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <div class="calendar-grid">
                        <div class="day-label">Sun</div>
                        <div class="day-label">Mon</div>
                        <div class="day-label">Tue</div>
                        <div class="day-label">Wed</div>
                        <div class="day-label">Thu</div>
                        <div class="day-label">Fri</div>
                        <div class="day-label">Sat</div>
                        <div id="calendar-days" class="days-container"></div>
                    </div>

                    <!-- Legend -->
                    <div class="cal-legend">
                        <span class="legend-item">
                            <span class="legend-dot dot-science"></span> Quiz
                        </span>
                        <span class="legend-item">
                            <span class="legend-dot dot-math"></span> Assignment
                        </span>
                        <span class="legend-item">
                            <span class="legend-dot dot-english"></span> Examination
                        </span>
                    </div>
                </section>

                <!-- Deadlines sidebar -->
                <aside class="upcoming-deadlines">
                    <div class="deadlines-header">
                        <div class="deadlines-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div>
                            <h3>Upcoming Deadlines</h3>
                            <p id="deadlines-count">&nbsp;</p>
                        </div>
                    </div>

                    <div class="deadline-list" id="deadline-list"></div>
                </aside>

            </div>
        </div>
    </main>

    <!-- Mobile nav overlay + drawer -->
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
        <a href="{{ route('jhs.announcement') }}" class="nav-item"><i class="fas fa-bullhorn"></i> Announcement</a>
        <a href="{{ route('jhs.assignments') }}" class="nav-item"><i class="fas fa-tasks"></i> Assignments</a>
        <a href="{{ route('jhs.quizzes') }}" class="nav-item"><i class="fas fa-edit"></i> Quizzes</a>
        <a href="{{ route('jhs.gradebook') }}" class="nav-item"><i class="fas fa-chart-line"></i> Gradebook</a>
        <a href="{{ route('jhs.calendar') }}" class="nav-item active"><i class="fas fa-calendar-alt"></i> Calendar</a>
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

    @php
        $eventsJson = $events->map(fn ($e) => [
            'id'          => $e->id,
            'title'       => $e->title,
            'description' => $e->description,
            'date'        => $e->event_date->format('Y-m-d'),
            'category'    => $e->category,
            'section'     => $e->section,
        ])->values();
    @endphp
    <script type="application/json" id="events-data">{!! json_encode($eventsJson, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}</script>
    <script>
        window.EVENTS_DATA = JSON.parse(document.getElementById('events-data').textContent);
    </script>
    <script>
        var CAT_DOT   = { 'Quiz': 'dot-science', 'Assignment': 'dot-math', 'Examination': 'dot-english' };
        var CAT_BADGE = { 'Quiz': 'badge-science', 'Assignment': 'badge-math', 'Examination': 'badge-english' };
        var CAT_ICON_CLASS = { 'Quiz': 'science-circle', 'Assignment': 'math-circle', 'Examination': 'english-circle' };
        var CAT_ICON  = { 'Quiz': 'fa-lightbulb', 'Assignment': 'fa-tasks', 'Examination': 'fa-clipboard-list' };
        var CAT_BORDER = { 'Quiz': 'science-border', 'Assignment': 'math-border', 'Examination': 'english-border' };
        var MONTH_NAMES = ['January','February','March','April','May','June','July','August','September','October','November','December'];

        var today = new Date(); today.setHours(0,0,0,0);
        var calYear  = today.getFullYear();
        var calMonth = today.getMonth();

        function parseEventDate(str) {
            var p = str.split('-');
            return new Date(parseInt(p[0]), parseInt(p[1]) - 1, parseInt(p[2]));
        }

        function renderCalendar() {
            document.getElementById('current-month').textContent = MONTH_NAMES[calMonth] + ' ' + calYear;
            document.getElementById('summary-month').innerHTML = '<strong>' + MONTH_NAMES[calMonth] + ' ' + calYear + '</strong> &mdash; A.Y. 2025&ndash;2026';

            var daysContainer = document.getElementById('calendar-days');
            daysContainer.innerHTML = '';
            var firstDay    = new Date(calYear, calMonth, 1).getDay();
            var daysInMonth = new Date(calYear, calMonth + 1, 0).getDate();

            var monthEvents = window.EVENTS_DATA.filter(function (e) {
                var d = parseEventDate(e.date);
                return d.getFullYear() === calYear && d.getMonth() === calMonth;
            });
            var eventsByDay = {};
            monthEvents.forEach(function (e) {
                var d = parseEventDate(e.date).getDate();
                if (!eventsByDay[d]) eventsByDay[d] = [];
                eventsByDay[d].push(e);
            });

            document.getElementById('deadlines-count').textContent = monthEvents.length + (monthEvents.length === 1 ? ' activity this month' : ' activities this month');

            for (var i = 0; i < firstDay; i++) {
                var empty = document.createElement('div');
                daysContainer.appendChild(empty);
            }

            for (var day = 1; day <= daysInMonth; day++) {
                var daySquare = document.createElement('div');
                daySquare.classList.add('cal-day');

                var isToday = calYear === today.getFullYear() && calMonth === today.getMonth() && day === today.getDate();
                if (isToday) daySquare.classList.add('today');

                var span = document.createElement('span');
                span.textContent = day;
                daySquare.appendChild(span);

                if (eventsByDay[day]) {
                    daySquare.classList.add('has-event');
                    var dot = document.createElement('div');
                    dot.classList.add('event-dot', CAT_DOT[eventsByDay[day][0].category] || 'dot-science');
                    daySquare.appendChild(dot);
                    daySquare.title = eventsByDay[day].map(function (e) { return e.title; }).join(', ');
                }

                daysContainer.appendChild(daySquare);
            }

            renderDeadlines();
        }

        function renderDeadlines() {
            var list = document.getElementById('deadline-list');
            var upcoming = window.EVENTS_DATA
                .filter(function (e) { return parseEventDate(e.date) >= today; })
                .sort(function (a, b) { return parseEventDate(a.date) - parseEventDate(b.date); })
                .slice(0, 6);

            if (upcoming.length === 0) {
                list.innerHTML = '<p style="color:#94a3b8;font-size:0.85rem;text-align:center;padding:20px 0;">No upcoming deadlines.</p>';
                return;
            }

            list.innerHTML = upcoming.map(function (e) {
                var d = parseEventDate(e.date);
                var diffDays = Math.round((d - today) / 86400000);
                var urgent = diffDays <= 3;
                var dateLabel = MONTH_NAMES[d.getMonth()].slice(0,3) + ' ' + d.getDate();
                return '<div class="deadline-item ' + (CAT_BORDER[e.category] || 'science-border') + '">' +
                    '<div class="deadline-icon-circle ' + (CAT_ICON_CLASS[e.category] || 'science-circle') + '">' +
                        '<i class="fas ' + (CAT_ICON[e.category] || 'fa-calendar') + '"></i>' +
                    '</div>' +
                    '<div class="deadline-body">' +
                        '<div class="deadline-top-row">' +
                            '<span class="dl-subject-badge ' + (CAT_BADGE[e.category] || 'badge-science') + '">' + e.category + '</span>' +
                        '</div>' +
                        '<h4>' + e.title + '</h4>' +
                        '<p>' + (e.section || 'All Sections') + (e.description ? ' — ' + e.description : '') + '</p>' +
                    '</div>' +
                    '<div class="deadline-date-col">' +
                        '<span class="deadline-date-badge ' + (urgent ? 'urgent' : 'normal') + '">' + dateLabel + '</span>' +
                    '</div>' +
                '</div>';
            }).join('');
        }

        document.getElementById('prev-month').addEventListener('click', function () {
            calMonth--; if (calMonth < 0) { calMonth = 11; calYear--; }
            renderCalendar();
        });
        document.getElementById('next-month').addEventListener('click', function () {
            calMonth++; if (calMonth > 11) { calMonth = 0; calYear++; }
            renderCalendar();
        });

        document.addEventListener('DOMContentLoaded', renderCalendar);

        // Hamburger menu
        (function () {
            var hamburgerBtn = document.getElementById('hamburger-btn');
            var drawer       = document.getElementById('mobile-nav-drawer');
            var overlay      = document.getElementById('mobile-nav-overlay');
            var closeBtn     = document.getElementById('mobile-nav-close');

            function openMenu() {
                drawer.classList.add('open');
                overlay.classList.add('open');
                document.body.style.overflow = 'hidden';
            }
            function closeMenu() {
                drawer.classList.remove('open');
                overlay.classList.remove('open');
                document.body.style.overflow = '';
            }

            if (hamburgerBtn) hamburgerBtn.addEventListener('click', openMenu);
            if (closeBtn)     closeBtn.addEventListener('click', closeMenu);
            if (overlay)      overlay.addEventListener('click', closeMenu);
        })();
    </script>
</body>
</html>
