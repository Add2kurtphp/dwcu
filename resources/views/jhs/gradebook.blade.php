<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gradebook | DWCU Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        /* ── GRADEBOOK LAYOUT ── */
        .gradebook-layout {
            display: flex;
            flex-direction: column;
            gap: 22px;
            padding-bottom: 50px;
        }

        /* ── OVERVIEW CARD ── */
        .grade-overview-card {
            background: linear-gradient(135deg, #1e2f7a 0%, #283593 100%);
            border-radius: 20px;
            padding: 30px;
            position: relative;
            overflow: hidden;
            color: white;
        }
        .grade-overview-decoration {
            position: absolute;
            width: 280px; height: 280px;
            border-radius: 50%;
            border: 50px solid rgba(255,255,255,0.04);
            top: -80px; right: -60px;
            pointer-events: none;
        }
        .grade-overview-top {
            display: flex; justify-content: space-between; align-items: flex-start;
            gap: 20px; margin-bottom: 24px; flex-wrap: wrap;
        }
        .grade-student-info { display: flex; align-items: center; gap: 16px; }
        .grade-avatar {
            width: 58px; height: 58px; border-radius: 16px;
            background: rgba(255,255,255,0.18); border: 2px solid rgba(255,255,255,0.25);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; font-weight: 700; color: white; flex-shrink: 0;
        }
        .grade-level-badge {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(255,255,255,0.15); color: rgba(255,255,255,0.9);
            font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.05em; padding: 4px 12px; border-radius: 50px; margin-bottom: 6px;
        }
        .grade-student-text h2 { font-size: 1.5rem; font-weight: 700; color: white; margin-bottom: 4px; line-height: 1.2; }
        .grade-section-label { font-size: 0.82rem; color: rgba(255,255,255,0.65); display: flex; align-items: center; gap: 6px; }
        .grade-score-display { display: flex; flex-direction: column; align-items: flex-end; text-align: right; }
        .grade-score-label { font-size: 0.78rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: rgba(255,255,255,0.6); margin-bottom: 2px; }
        .grade-score-value { font-size: 3.2rem; font-weight: 700; color: white; line-height: 1; }
        .grade-score-sub { font-size: 0.75rem; color: rgba(255,255,255,0.5); margin-top: 4px; }

        /* Stat chips */
        .grade-stats-row { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 22px; }
        .grade-stat {
            display: flex; align-items: center; gap: 12px;
            background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px; padding: 12px 18px; flex: 1; min-width: 140px;
        }
        .grade-stat-icon {
            width: 36px; height: 36px; background: rgba(255,255,255,0.15);
            border-radius: 10px; display: flex; align-items: center; justify-content: center;
            font-size: 0.95rem; color: white; flex-shrink: 0;
        }
        .grade-stat-val { display: block; font-size: 1.1rem; font-weight: 700; color: white; line-height: 1.2; }
        .grade-stat-label { display: block; font-size: 0.72rem; color: rgba(255,255,255,0.6); font-weight: 500; }

        /* Download button */
        .download-btn {
            background: white; color: #1e2f7a; border: none;
            padding: 12px 22px; border-radius: 12px;
            font-family: 'Afacad', sans-serif; font-weight: 700; font-size: 0.92rem;
            cursor: pointer; display: inline-flex; align-items: center; gap: 9px;
            transition: all 0.25s; align-self: flex-start;
            box-shadow: 0 4px 14px rgba(0,0,0,0.15);
        }
        .download-btn:hover { background: #adff2f; transform: translateY(-2px); box-shadow: 0 6px 18px rgba(0,0,0,0.2); }

        /* ── SECTION CARDS ── */
        .grade-section-card {
            background: white; border-radius: 20px; padding: 28px 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;
        }
        .grade-section-header {
            display: flex; align-items: center; gap: 14px;
            margin-bottom: 22px; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9;
        }
        .grade-section-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, #1e2f7a, #283593);
            border-radius: 12px; display: flex; align-items: center; justify-content: center;
            font-size: 1rem; color: white; flex-shrink: 0;
        }
        .grade-section-header h3 { font-size: 1.05rem; font-weight: 700; color: #1e293b; margin-bottom: 2px; }
        .grade-section-header p { font-size: 0.8rem; color: #94a3b8; }

        /* Chart */
        .graph-container { height: 280px; position: relative; width: 100%; }

        /* Grading summary */
        .grading-summary { display: grid; grid-template-columns: 220px 1fr; gap: 16px; }
        .summary-box { background: #f8fafc; padding: 24px; border-radius: 14px; border: 1px solid #e2e8f0; }
        .automated-average {
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            text-align: center; background: linear-gradient(135deg, #1e2f7a, #283593); border: none;
        }
        .automated-average .summary-label { color: rgba(255,255,255,0.7); font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 8px; }
        .summary-value { font-size: 3rem; font-weight: 700; color: white; line-height: 1; margin-bottom: 6px; }
        .sub-value { font-size: 0.75rem; color: rgba(255,255,255,0.5); text-transform: uppercase; letter-spacing: 0.5px; }
        .grading-breakdown { display: flex; flex-direction: column; gap: 12px; background: transparent; padding: 0; border: none; }
        .breakdown-item {
            display: flex; align-items: center; gap: 14px; padding: 16px 18px;
            background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; border-left-width: 4px;
        }
        .quiz-item  { border-left-color: #8b5cf6; }
        .asst-item  { border-left-color: #22c55e; }
        .breakdown-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0; }
        .quiz-icon { background: #f5f3ff; color: #7c3aed; }
        .asst-icon { background: #f0fdf4; color: #16a34a; }
        .breakdown-text { flex: 1; display: flex; flex-direction: column; gap: 2px; }
        .breakdown-name { font-size: 0.92rem; font-weight: 600; color: #334155; }
        .breakdown-name em { font-style: normal; font-weight: 400; color: #94a3b8; font-size: 0.82rem; }
        .breakdown-weight { font-size: 0.8rem; font-weight: 700; color: #1e2f7a; }
        .sync-tag { font-size: 0.72rem; color: #94a3b8; display: flex; align-items: center; gap: 5px; font-weight: 600; white-space: nowrap; }

        /* Activity Table */
        .table-container { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .activity-table { width: 100%; border-collapse: collapse; }
        .activity-table thead tr { background: #f8fafc; border-radius: 10px; }
        .activity-table th {
            text-align: left; padding: 13px 16px; font-size: 0.78rem; font-weight: 700;
            color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;
            border-bottom: 2px solid #f1f5f9; white-space: nowrap;
        }
        .activity-table td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; color: #475569; font-size: 0.92rem; vertical-align: middle; }
        .activity-table tbody tr:last-child td { border-bottom: none; }
        .activity-table tbody tr:hover td { background: #f8fafc; }

        /* Subject badges */
        .subj-badge { display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; white-space: nowrap; }
        .badge-science { background: #e0f2fe; color: #0369a1; }
        .badge-math    { background: #eff6ff; color: #1d4ed8; }
        .badge-english { background: #f5f3ff; color: #7c3aed; }
        .badge-tle     { background: #fff7ed; color: #c2410c; }

        /* Type badges */
        .type-badge { display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 700; white-space: nowrap; }
        .badge-quiz { background: #f5f3ff; color: #7c3aed; }
        .badge-asst { background: #f0fdf4; color: #16a34a; }

        /* Grade pills */
        .grade-pill { display: inline-flex; align-items: center; padding: 5px 14px; border-radius: 50px; font-size: 0.82rem; font-weight: 700; white-space: nowrap; }
        .grade-high    { background: #dcfce7; color: #15803d; }
        .grade-mid     { background: #dbeafe; color: #1d4ed8; }
        .grade-low     { background: #fef2f2; color: #dc2626; }
        .grade-pending { background: #fef9c3; color: #b45309; }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .grade-overview-top { flex-direction: column; gap: 16px; }
            .grade-score-display { align-items: flex-start; text-align: left; }
            .grade-score-value { font-size: 2.4rem; }
            .grade-section-card { padding: 20px; }
            .grading-summary { grid-template-columns: 1fr; }
            .automated-average { padding: 20px; }
            .graph-container { height: 220px; }
            .activity-table th,
            .activity-table td { padding: 10px 12px; font-size: 0.85rem; white-space: nowrap; }
            .download-btn { width: 100%; justify-content: center; }
            .grade-stats-row { gap: 10px; }
            .grade-stat { min-width: calc(50% - 5px); }
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
                <a href="{{ route('jhs.gradebook') }}" class="nav-item active">
                    <i class="fas fa-chart-line"></i> Gradebook
                </a>
                <a href="{{ route('jhs.calendar') }}" class="nav-item">
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
                <h1>My Gradebook</h1>
            </div>
            <a href="{{ route('jhs.profile') }}" class="header-user">
                <i class="fas fa-user-circle"></i>
                <span>{{ session('jhs_student_name', 'Student Profile') }}</span>
            </a>
        </header>

        <div class="scroll-container">
            <div class="gradebook-layout">

                <!-- Overview Card -->
                <div class="grade-overview-card">
                    <div class="grade-overview-decoration"></div>
                    <div class="grade-overview-top">
                        <div class="grade-student-info">
                            <div class="grade-avatar">MF</div>
                            <div class="grade-student-text">
                                <span class="grade-level-badge"><i class="fas fa-graduation-cap"></i> Grade 7</span>
                                <h2>Michael Flores</h2>
                                <p class="grade-section-label"><i class="fas fa-users"></i> Explorers Section &mdash; A.Y. 2025&ndash;2026</p>
                            </div>
                        </div>
                        <div class="grade-score-display">
                            <span class="grade-score-label">Overall Average</span>
                            <span class="grade-score-value">77.5</span>
                            <span class="grade-score-sub">Weighted Score</span>
                        </div>
                    </div>

                    <div class="grade-stats-row">
                        <div class="grade-stat">
                            <div class="grade-stat-icon"><i class="fas fa-edit"></i></div>
                            <div>
                                <span class="grade-stat-val">77.5%</span>
                                <span class="grade-stat-label">Quizzes Avg</span>
                            </div>
                        </div>
                        <div class="grade-stat">
                            <div class="grade-stat-icon"><i class="fas fa-tasks"></i></div>
                            <div>
                                <span class="grade-stat-val">88.3%</span>
                                <span class="grade-stat-label">Assignments Avg</span>
                            </div>
                        </div>
                        <div class="grade-stat">
                            <div class="grade-stat-icon"><i class="fas fa-check-circle"></i></div>
                            <div>
                                <span class="grade-stat-val">4</span>
                                <span class="grade-stat-label">Activities Done</span>
                            </div>
                        </div>
                    </div>

                    <button class="download-btn" id="download-btn">
                        <i class="fas fa-file-download"></i> Download Report Card
                    </button>
                </div>

                <!-- Performance Chart -->
                <div class="grade-section-card">
                    <div class="grade-section-header">
                        <div class="grade-section-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div>
                            <h3>Performance Analysis</h3>
                            <p>Score breakdown per activity</p>
                        </div>
                    </div>
                    <div class="graph-container">
                        <canvas id="jhsPerformanceChart"></canvas>
                    </div>
                </div>

                <!-- Grading Breakdown -->
                <div class="grade-section-card">
                    <div class="grade-section-header">
                        <div class="grade-section-icon">
                            <i class="fas fa-percent"></i>
                        </div>
                        <div>
                            <h3>Automated Grading Breakdown</h3>
                            <p>How your final grade is computed</p>
                        </div>
                    </div>
                    <div class="grading-summary">
                        <div class="summary-box automated-average">
                            <span class="summary-label">Automated Average</span>
                            <span class="summary-value">77.5</span>
                            <span class="sub-value">Weighted Score</span>
                        </div>
                        <div class="summary-box grading-breakdown">
                            <div class="breakdown-item quiz-item">
                                <div class="breakdown-icon quiz-icon">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="breakdown-text">
                                    <span class="breakdown-name">Quizzes <em>(Summative)</em></span>
                                    <span class="breakdown-weight">60% weight</span>
                                </div>
                                <span class="sync-tag"><i class="fas fa-sync-alt"></i> Auto-Synced</span>
                            </div>
                            <div class="breakdown-item asst-item">
                                <div class="breakdown-icon asst-icon">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <div class="breakdown-text">
                                    <span class="breakdown-name">Assignments <em>(Formative)</em></span>
                                    <span class="breakdown-weight">40% weight</span>
                                </div>
                                <span class="sync-tag"><i class="fas fa-sync-alt"></i> Auto-Synced</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submitted Activities Table -->
                <div class="grade-section-card">
                    <div class="grade-section-header">
                        <div class="grade-section-icon">
                            <i class="fas fa-list-alt"></i>
                        </div>
                        <div>
                            <h3>Submitted Activities</h3>
                            <p>Your completed assignments and quizzes</p>
                        </div>
                    </div>
                    <div class="table-container">
                        <table class="activity-table">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Type</th>
                                    <th>Activity Name</th>
                                    <th>Date Submitted</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="subj-badge badge-science">Science</span></td>
                                    <td><span class="type-badge badge-asst">Assignment</span></td>
                                    <td>Research Paper on Ecosystems</td>
                                    <td>March 07, 2026</td>
                                    <td><span class="grade-pill grade-high">95%</span></td>
                                </tr>
                                <tr>
                                    <td><span class="subj-badge badge-math">Mathematics</span></td>
                                    <td><span class="type-badge badge-asst">Assignment</span></td>
                                    <td>Algebraic Expressions</td>
                                    <td>March 11, 2026</td>
                                    <td><span class="grade-pill grade-pending">Pending</span></td>
                                </tr>
                                <tr>
                                    <td><span class="subj-badge badge-english">English</span></td>
                                    <td><span class="type-badge badge-asst">Assignment</span></td>
                                    <td>Argumentative Essay Draft</td>
                                    <td>March 14, 2026</td>
                                    <td><span class="grade-pill grade-high">100%</span></td>
                                </tr>
                                <tr>
                                    <td><span class="subj-badge badge-science">Science</span></td>
                                    <td><span class="type-badge badge-quiz">Quiz</span></td>
                                    <td>Periodic Table (Unit 3)</td>
                                    <td>Auto-Submitted</td>
                                    <td><span class="grade-pill grade-mid">80%</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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
        <a href="{{ route('jhs.gradebook') }}" class="nav-item active"><i class="fas fa-chart-line"></i> Gradebook</a>
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
        // Performance Chart
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('jhsPerformanceChart').getContext('2d');

            var performanceData = {
                labels: ['Quiz 1', 'Quiz 2', 'Asst 1', 'Asst 2'],
                datasets: [{
                    label: 'Scores (%)',
                    data: [75, 80, 70, 85],
                    backgroundColor: '#1e2f7a',
                    hoverBackgroundColor: '#2a3f9d',
                    borderRadius: 6,
                    barPercentage: 0.5,
                    categoryPercentage: 0.8
                }]
            };

            new Chart(ctx, {
                type: 'bar',
                data: performanceData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e2f7a',
                            titleFont: { family: 'Afacad', size: 14 },
                            bodyFont: { family: 'Afacad', size: 13 },
                            callbacks: {
                                label: function (context) {
                                    return ' Score: ' + context.parsed.y + '%';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                stepSize: 10,
                                font: { family: 'Afacad', weight: '500' },
                                color: '#64748b'
                            },
                            grid: { color: '#f1f5f9' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { family: 'Afacad', weight: '600' },
                                color: '#1e2f7a'
                            }
                        }
                    }
                }
            });
        });

        // Download Report Card
        document.getElementById('download-btn').addEventListener('click', function () {
            var btn = this;
            var originalHTML = btn.innerHTML;

            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Generating PDF...';
            btn.style.opacity = '0.7';
            btn.style.pointerEvents = 'none';

            setTimeout(function () {
                alert('Success! Your Grade 7 - Explorers Report Card has been generated and saved to your device.');
                btn.innerHTML = originalHTML;
                btn.style.opacity = '1';
                btn.style.pointerEvents = 'auto';
            }, 2000);
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
