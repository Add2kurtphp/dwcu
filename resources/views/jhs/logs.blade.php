<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs | DWCU Portal</title>
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
        .logs-summary-bar {
            display: flex; justify-content: space-between; align-items: center;
            background: white; border-radius: 14px; padding: 14px 22px;
            margin-bottom: 22px; border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04); flex-wrap: wrap; gap: 10px;
        }
        .logs-summary-left { display: flex; align-items: center; gap: 10px; font-size: 0.9rem; color: #475569; }
        .logs-summary-left i { color: #1e2f7a; font-size: 1rem; }
        .logs-summary-right { display: flex; align-items: center; gap: 6px; font-size: 0.82rem; color: #94a3b8; }

        /* ── STAT CARDS ── */
        .logs-stats-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 22px; }
        .log-stat-card {
            background: white; border-radius: 16px; padding: 20px; border: 1px solid #f1f5f9;
            box-shadow: 0 4px 14px rgba(0,0,0,0.04); display: flex; align-items: center; gap: 14px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .log-stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(30,47,122,0.08); }
        .log-stat-icon { width: 46px; height: 46px; border-radius: 13px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
        .stat-login  { background: #dcfce7; color: #16a34a; }
        .stat-quiz   { background: #fef9c3; color: #b45309; }
        .stat-asst   { background: #dbeafe; color: #1d4ed8; }
        .stat-recent { background: #f5f3ff; color: #7c3aed; }
        .log-stat-text { display: flex; flex-direction: column; gap: 2px; }
        .log-stat-val { font-size: 1.4rem; font-weight: 700; color: #1e293b; line-height: 1; }
        .log-stat-label { font-size: 0.75rem; color: #94a3b8; font-weight: 500; }

        /* ── LOGS CARD ── */
        .logs-card {
            background: white; border-radius: 20px; border: 1px solid #f1f5f9;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 30px;
        }
        .logs-card-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 22px 28px; border-bottom: 1px solid #f1f5f9; flex-wrap: wrap; gap: 14px;
        }
        .logs-card-title { display: flex; align-items: center; gap: 14px; }
        .logs-card-icon {
            width: 42px; height: 42px; background: linear-gradient(135deg, #1e2f7a, #283593);
            border-radius: 12px; display: flex; align-items: center; justify-content: center;
            font-size: 1rem; color: white; flex-shrink: 0;
        }
        .logs-card-title h3 { font-size: 1.05rem; font-weight: 700; color: #1e293b; margin-bottom: 2px; }
        .logs-card-title p { font-size: 0.78rem; color: #94a3b8; }

        /* Filter buttons */
        .filter-group { display: flex; gap: 8px; flex-wrap: wrap; }
        .filter-btn {
            padding: 7px 18px; border: 1.5px solid #e2e8f0; border-radius: 50px;
            background: white; color: #475569; font-size: 0.82rem; font-weight: 700;
            cursor: pointer; transition: all 0.2s; font-family: 'Afacad', sans-serif;
        }
        .filter-btn:hover { border-color: #1e2f7a; color: #1e2f7a; background: #f8fafc; }
        .filter-btn.active { background: #1e2f7a; color: white; border-color: #1e2f7a; box-shadow: 0 4px 10px rgba(30,47,122,0.25); }

        /* Table */
        .log-table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .log-table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .log-table th:nth-child(1) { width: 20%; }
        .log-table th:nth-child(2) { width: 16%; }
        .log-table th:nth-child(3) { width: 40%; }
        .log-table th:nth-child(4) { width: 24%; }
        .log-table thead { background: linear-gradient(135deg, #1e2f7a, #283593); }
        .log-table thead th {
            padding: 14px 20px; text-align: left; font-size: 0.72rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.07em; color: rgba(255,255,255,0.9); white-space: nowrap;
        }
        .log-table thead th i { margin-right: 7px; opacity: 0.7; }
        .log-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background 0.15s; }
        .log-table tbody tr:last-child { border-bottom: none; }
        .log-table tbody tr:hover { background: #f8fafc; }
        .log-table tbody td { padding: 14px 20px; font-size: 0.9rem; color: #334155; vertical-align: middle; }
        .td-timestamp { font-variant-numeric: tabular-nums; }
        .log-date { display: block; font-weight: 600; color: #1e293b; font-size: 0.88rem; }
        .log-time { display: block; color: #94a3b8; font-size: 0.76rem; margin-top: 2px; }
        .category-badge { display: inline-flex; align-items: center; gap: 7px; padding: 5px 13px; border-radius: 50px; font-size: 0.76rem; font-weight: 700; white-space: nowrap; }
        .dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
        .badge-login      { background: #dcfce7; color: #15803d; }
        .badge-login .dot { background: #22c55e; }
        .badge-logout      { background: #f1f5f9; color: #475569; }
        .badge-logout .dot { background: #94a3b8; }
        .badge-quiz      { background: #fef9c3; color: #a16207; }
        .badge-quiz .dot { background: #eab308; }
        .badge-assignment      { background: #dbeafe; color: #1d4ed8; }
        .badge-assignment .dot { background: #3b82f6; }
        .activity-text { font-weight: 500; font-size: 0.88rem; }
        .device-text { font-size: 0.82rem; color: #64748b; display: flex; align-items: center; gap: 8px; }
        .device-text i { color: #94a3b8; }

        /* Empty state */
        .log-empty { display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 60px 20px; color: #94a3b8; gap: 10px; }
        .log-empty-icon { width: 64px; height: 64px; background: #f1f5f9; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; color: #cbd5e1; margin-bottom: 6px; }
        .log-empty p { font-size: 1rem; font-weight: 700; color: #475569; }
        .log-empty span { font-size: 0.82rem; color: #94a3b8; }

        /* Pagination */
        .pagination-bar { display: flex; align-items: center; justify-content: space-between; padding: 16px 24px; border-top: 1px solid #f1f5f9; }
        .page-btn {
            display: flex; align-items: center; gap: 8px; padding: 9px 20px;
            border: 1.5px solid #e2e8f0; border-radius: 10px; background: white;
            color: #1e2f7a; font-size: 0.85rem; font-weight: 700; cursor: pointer;
            transition: all 0.2s; font-family: 'Afacad', sans-serif;
        }
        .page-btn:hover:not(:disabled) { background: #1e2f7a; color: white; border-color: #1e2f7a; box-shadow: 0 4px 12px rgba(30,47,122,0.25); }
        .page-btn:disabled { opacity: 0.35; cursor: not-allowed; }
        .page-info { font-size: 0.85rem; font-weight: 600; color: #64748b; }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) { .logs-stats-row { grid-template-columns: repeat(2, 1fr); } }

        @media (max-width: 768px) {
            .logs-summary-bar { flex-direction: column; align-items: flex-start; gap: 8px; }
            .logs-stats-row { grid-template-columns: repeat(2, 1fr); gap: 12px; }
            .log-stat-card { padding: 16px; }
            .log-stat-val { font-size: 1.2rem; }
            .logs-card-header { flex-direction: column; align-items: flex-start; padding: 16px 18px; }
            .filter-group { gap: 6px; }
            .filter-btn { padding: 6px 14px; font-size: 0.78rem; }
            .log-table, .log-table tbody, .log-table tbody tr, .log-table tbody td { display: block; width: 100%; }
            .log-table thead { display: none; }
            .log-table tbody tr { border-bottom: 1px solid #f1f5f9; padding: 14px 18px; }
            .log-table tbody td { display: flex; align-items: flex-start; gap: 10px; padding: 5px 0; border: none; font-size: 0.85rem; }
            .log-table tbody td::before { content: attr(data-label); font-size: 0.68rem; font-weight: 700; text-transform: uppercase; color: #94a3b8; min-width: 72px; padding-top: 3px; flex-shrink: 0; }
            .pagination-bar { padding: 12px 16px; }
            .page-btn { padding: 8px 14px; font-size: 0.8rem; }
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
                <a href="{{ route('jhs.announcement') }}" class="nav-item"><i class="fas fa-bullhorn"></i> Announcement</a>
                <a href="{{ route('jhs.assignments') }}" class="nav-item"><i class="fas fa-tasks"></i> Assignments</a>
                <a href="{{ route('jhs.quizzes') }}" class="nav-item"><i class="fas fa-edit"></i> Quizzes</a>
                <a href="{{ route('jhs.gradebook') }}" class="nav-item"><i class="fas fa-chart-line"></i> Gradebook</a>
                <a href="{{ route('jhs.calendar') }}" class="nav-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
                <a href="{{ route('jhs.logs') }}" class="nav-item active"><i class="fas fa-history"></i> Activity Logs</a>
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
                <h1>Activity Logs</h1>
            </div>
            <a href="{{ route('jhs.profile') }}" class="header-user">
                <i class="fas fa-user-circle"></i>
                <span>{{ session('jhs_student_name', 'Student Profile') }}</span>
            </a>
        </header>

        <div class="scroll-container">

            <!-- Summary bar -->
            <div class="logs-summary-bar">
                <div class="logs-summary-left">
                    <i class="fas fa-shield-alt"></i>
                    <span><strong>15</strong> activity records &mdash; A.Y. 2025&ndash;2026</span>
                </div>
                <div class="logs-summary-right">
                    <i class="fas fa-lock"></i>
                    <span>Personal history visible only to you</span>
                </div>
            </div>

            <!-- Quick stat cards -->
            <div class="logs-stats-row">
                <div class="log-stat-card">
                    <div class="log-stat-icon stat-login"><i class="fas fa-sign-in-alt"></i></div>
                    <div class="log-stat-text">
                        <span class="log-stat-val">3</span>
                        <span class="log-stat-label">Logins This Month</span>
                    </div>
                </div>
                <div class="log-stat-card">
                    <div class="log-stat-icon stat-quiz"><i class="fas fa-edit"></i></div>
                    <div class="log-stat-text">
                        <span class="log-stat-val">4</span>
                        <span class="log-stat-label">Quizzes Taken</span>
                    </div>
                </div>
                <div class="log-stat-card">
                    <div class="log-stat-icon stat-asst"><i class="fas fa-tasks"></i></div>
                    <div class="log-stat-text">
                        <span class="log-stat-val">6</span>
                        <span class="log-stat-label">Assignments Submitted</span>
                    </div>
                </div>
                <div class="log-stat-card">
                    <div class="log-stat-icon stat-recent"><i class="fas fa-clock"></i></div>
                    <div class="log-stat-text">
                        <span class="log-stat-val">Mar 15</span>
                        <span class="log-stat-label">Last Active</span>
                    </div>
                </div>
            </div>

            <!-- Activity log card -->
            <div class="logs-card">
                <div class="logs-card-header">
                    <div class="logs-card-title">
                        <div class="logs-card-icon"><i class="fas fa-list-alt"></i></div>
                        <div>
                            <h3>Activity History</h3>
                            <p>Your complete portal activity log</p>
                        </div>
                    </div>
                    <div class="filter-group" id="filterGroup">
                        <button class="filter-btn active" data-filter="All">All</button>
                        <button class="filter-btn" data-filter="Login">Logins</button>
                        <button class="filter-btn" data-filter="Quiz">Quizzes</button>
                        <button class="filter-btn" data-filter="Assignment">Assignments</button>
                    </div>
                </div>

                <div class="log-table-wrapper">
                    <table class="log-table">
                        <thead>
                            <tr>
                                <th><i class="far fa-clock"></i> Timestamp</th>
                                <th><i class="fas fa-tag"></i> Category</th>
                                <th><i class="fas fa-bolt"></i> Activity</th>
                                <th><i class="fas fa-desktop"></i> Device / Browser</th>
                            </tr>
                        </thead>
                        <tbody id="logTableBody"></tbody>
                    </table>
                    <div class="log-empty" id="logEmpty" style="display:none;">
                        <div class="log-empty-icon"><i class="fas fa-inbox"></i></div>
                        <p>No logs found for this filter.</p>
                        <span>Try selecting a different category above.</span>
                    </div>
                </div>

                <div class="pagination-bar">
                    <button class="page-btn" id="prevBtn" onclick="changePage(-1)">
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                    <span class="page-info" id="pageInfo">Page 1 of 1</span>
                    <button class="page-btn" id="nextBtn" onclick="changePage(1)">
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
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
        <a href="{{ route('jhs.calendar') }}" class="nav-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
        <a href="{{ route('jhs.logs') }}" class="nav-item active"><i class="fas fa-history"></i> Activity Logs</a>
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
        var logsData = [
            { timestamp: new Date('2026-03-15T07:32:10'), category: 'Login',      activity: 'Logged in to the JHS Portal',              device: 'Chrome \u2014 Windows 11' },
            { timestamp: new Date('2026-03-15T07:35:44'), category: 'Assignment', activity: 'Opened Science: Ecosystems Research',        device: 'Chrome \u2014 Windows 11' },
            { timestamp: new Date('2026-03-15T07:48:22'), category: 'Assignment', activity: 'Submitted Science Assignment',               device: 'Chrome \u2014 Windows 11' },
            { timestamp: new Date('2026-03-15T08:10:05'), category: 'Quiz',       activity: 'Started Mathematics Quiz (Geometry)',        device: 'Chrome \u2014 Windows 11' },
            { timestamp: new Date('2026-03-15T08:38:17'), category: 'Quiz',       activity: 'Submitted Mathematics Quiz \u2014 Score: 2/2', device: 'Chrome \u2014 Windows 11' },
            { timestamp: new Date('2026-03-15T08:40:01'), category: 'Logout',     activity: 'Logged out of the JHS Portal',               device: 'Chrome \u2014 Windows 11' },
            { timestamp: new Date('2026-03-14T13:15:30'), category: 'Login',      activity: 'Logged in to the JHS Portal',               device: 'Firefox \u2014 Windows 11' },
            { timestamp: new Date('2026-03-14T13:20:09'), category: 'Assignment', activity: 'Opened English: Argumentative Essay',        device: 'Firefox \u2014 Windows 11' },
            { timestamp: new Date('2026-03-14T13:55:42'), category: 'Assignment', activity: 'Submitted English Assignment',               device: 'Firefox \u2014 Windows 11' },
            { timestamp: new Date('2026-03-14T14:02:18'), category: 'Quiz',       activity: 'Started English Quiz (Grammar)',             device: 'Firefox \u2014 Windows 11' },
            { timestamp: new Date('2026-03-14T14:25:55'), category: 'Quiz',       activity: 'Submitted English Quiz \u2014 Score: 1/2',   device: 'Firefox \u2014 Windows 11' },
            { timestamp: new Date('2026-03-14T14:27:00'), category: 'Logout',     activity: 'Logged out of the JHS Portal',               device: 'Firefox \u2014 Windows 11' },
            { timestamp: new Date('2026-03-13T09:05:11'), category: 'Login',      activity: 'Logged in to the JHS Portal',               device: 'Chrome \u2014 Android Mobile' },
            { timestamp: new Date('2026-03-13T09:08:44'), category: 'Assignment', activity: 'Opened TLE: Residential Floor Plan',         device: 'Chrome \u2014 Android Mobile' },
            { timestamp: new Date('2026-03-13T09:40:29'), category: 'Assignment', activity: 'Submitted TLE Assignment',                   device: 'Chrome \u2014 Android Mobile' }
        ];

        logsData.sort(function (a, b) { return b.timestamp - a.timestamp; });

        var LOGS_PER_PAGE = 10;
        var currentPage  = 1;
        var activeFilter = 'All';
        var filteredLogs = logsData.slice();

        function applyFilter(filter) {
            activeFilter = filter;
            currentPage  = 1;
            filteredLogs = filter === 'All'
                ? logsData.slice()
                : logsData.filter(function (log) { return log.category === filter; });

            document.querySelectorAll('.filter-btn').forEach(function (btn) {
                btn.classList.toggle('active', btn.dataset.filter === filter);
            });

            renderTable();
        }

        function renderTable() {
            var tbody    = document.getElementById('logTableBody');
            var empty    = document.getElementById('logEmpty');
            var prevBtn  = document.getElementById('prevBtn');
            var nextBtn  = document.getElementById('nextBtn');
            var info     = document.getElementById('pageInfo');

            var totalPages = Math.max(1, Math.ceil(filteredLogs.length / LOGS_PER_PAGE));
            currentPage    = Math.min(currentPage, totalPages);

            var start = (currentPage - 1) * LOGS_PER_PAGE;
            var page  = filteredLogs.slice(start, start + LOGS_PER_PAGE);

            if (page.length === 0) {
                tbody.innerHTML = '';
                empty.style.display = 'flex';
            } else {
                empty.style.display = 'none';
                var rows = '';
                for (var i = 0; i < page.length; i++) {
                    rows += buildRow(page[i]);
                }
                tbody.innerHTML = rows;
            }

            info.textContent  = 'Page ' + currentPage + ' of ' + totalPages;
            prevBtn.disabled  = currentPage === 1;
            nextBtn.disabled  = currentPage === totalPages;
        }

        function buildRow(log) {
            var date = log.timestamp.toLocaleDateString('en-PH', { year: 'numeric', month: 'short', day: 'numeric' });
            var time = log.timestamp.toLocaleTimeString('en-PH', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            var badgeClass = 'badge-' + log.category.toLowerCase();
            var deviceIcon = getDeviceIcon(log.device);

            return '<tr>'
                + '<td class="td-timestamp" data-label="Timestamp"><span class="log-date">' + date + '</span><span class="log-time">' + time + '</span></td>'
                + '<td data-label="Category"><span class="category-badge ' + badgeClass + '"><span class="dot"></span>' + log.category + '</span></td>'
                + '<td class="activity-text" data-label="Activity">' + log.activity + '</td>'
                + '<td data-label="Device"><span class="device-text"><i class="' + deviceIcon + '"></i>' + log.device + '</span></td>'
                + '</tr>';
        }

        function getDeviceIcon(device) {
            var d = device.toLowerCase();
            if (d.indexOf('mobile') !== -1 || d.indexOf('android') !== -1 || d.indexOf('iphone') !== -1) return 'fas fa-mobile-alt';
            if (d.indexOf('tablet') !== -1 || d.indexOf('ipad') !== -1) return 'fas fa-tablet-alt';
            return 'fas fa-desktop';
        }

        function changePage(direction) {
            var totalPages = Math.ceil(filteredLogs.length / LOGS_PER_PAGE);
            currentPage = Math.min(Math.max(1, currentPage + direction), totalPages);
            renderTable();
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('filterGroup').addEventListener('click', function (e) {
                var btn = e.target.closest('.filter-btn');
                if (btn) applyFilter(btn.dataset.filter);
            });
            renderTable();
        });

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
