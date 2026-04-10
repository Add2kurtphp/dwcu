<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gradebook | DWCU SHS Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .grade-summary-bar {
            display:flex; justify-content:space-between; align-items:center;
            background:white; border-radius:14px; padding:14px 22px;
            margin-bottom:22px; border:1px solid #e2e8f0;
            box-shadow:0 2px 8px rgba(0,0,0,0.04); flex-wrap:wrap; gap:12px;
        }
        .grade-summary-left { display:flex; align-items:center; gap:10px; font-size:0.9rem; color:#475569; }
        .grade-summary-left i { color:#1e2f7a; font-size:1rem; }
        .grade-summary-right { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }

        /* ── TAGS ── */
        .grade-tag {
            display:inline-flex; align-items:center; gap:5px;
            padding:4px 12px; border-radius:50px; font-size:0.72rem;
            font-weight:700; text-transform:uppercase; letter-spacing:0.04em;
        }
        .tag-passing { background:#dcfce7; color:#15803d; }
        .tag-pending { background:#fef9c3; color:#b45309; }

        /* ── STAT CARDS ── */
        .grade-stats-row {
            display:grid; grid-template-columns:repeat(4,1fr);
            gap:16px; margin-bottom:22px;
        }
        .grade-stat-card {
            background:white; border-radius:16px; padding:20px;
            border:1px solid #f1f5f9; box-shadow:0 2px 8px rgba(0,0,0,0.04);
            display:flex; align-items:center; gap:16px;
            transition:transform 0.22s,box-shadow 0.22s;
        }
        .grade-stat-card:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,0.08); }
        .stat-card-icon {
            width:48px; height:48px; border-radius:13px;
            display:flex; align-items:center; justify-content:center;
            font-size:1.2rem; flex-shrink:0;
        }
        .stat-card-body { display:flex; flex-direction:column; }
        .stat-card-value { font-size:1.5rem; font-weight:800; color:#1e293b; line-height:1.2; }
        .stat-card-label { font-size:0.78rem; color:#94a3b8; font-weight:600; margin-top:2px; }
        .stat-pass-text { font-size:1.05rem !important; color:#15803d !important; }
        .stat-overall .stat-card-icon { background:rgba(30,47,122,0.1);  color:#1e2f7a; }
        .stat-quiz    .stat-card-icon { background:rgba(124,58,237,0.1); color:#7c3aed; }
        .stat-asst    .stat-card-icon { background:rgba(16,185,129,0.1); color:#10b981; }
        .stat-status  .stat-card-icon { background:rgba(21,128,61,0.1);  color:#15803d; }

        /* ── PERFORMANCE PANEL ── */
        .grade-panel {
            background:white; border-radius:20px; padding:28px 30px;
            border:1px solid #f1f5f9; box-shadow:0 4px 16px rgba(0,0,0,0.05);
            margin-bottom:22px;
        }
        .grade-panel-header {
            display:flex; justify-content:space-between; align-items:center;
            margin-bottom:28px; flex-wrap:wrap; gap:14px;
        }
        .grade-panel-header-left { display:flex; align-items:center; gap:16px; }
        .grade-panel-icon {
            width:50px; height:50px;
            background:linear-gradient(135deg,#1e2f7a,#283593);
            border-radius:14px; display:flex; align-items:center;
            justify-content:center; font-size:1.2rem; color:white; flex-shrink:0;
        }
        .grade-panel-header-left h2 { font-size:1.25rem; font-weight:700; color:#1e293b; margin-bottom:3px; }
        .grade-panel-sub { font-size:0.83rem; color:#64748b; }
        .download-btn {
            display:inline-flex; align-items:center; gap:8px;
            background:white; color:#1e2f7a; border:1.5px solid #1e2f7a;
            padding:10px 20px; border-radius:10px; font-family:'Afacad',sans-serif;
            font-weight:700; font-size:0.88rem; cursor:pointer; transition:all 0.25s;
        }
        .download-btn:hover { background:#1e2f7a; color:white; box-shadow:0 4px 14px rgba(30,47,122,0.25); transform:translateY(-2px); }
        .grade-chart-section { margin-bottom:24px; }
        .grade-section-label {
            font-size:0.8rem; font-weight:700; color:#64748b;
            text-transform:uppercase; letter-spacing:0.05em; margin-bottom:16px;
            display:flex; align-items:center; gap:7px;
        }
        .grade-section-label i { color:#1e2f7a; }
        .graph-container { position:relative; width:100%; height:270px; }
        #shsPerformanceChart { width:100% !important; height:100% !important; }
        .grade-breakdown-row {
            display:grid; grid-template-columns:1fr 1fr;
            gap:16px; padding-top:22px; border-top:1px solid #f1f5f9;
        }
        .breakdown-card {
            display:flex; align-items:center; gap:14px;
            background:#f8fafc; border:1px solid #f1f5f9;
            border-radius:14px; padding:18px 20px;
        }
        .breakdown-icon {
            width:42px; height:42px; border-radius:12px;
            display:flex; align-items:center; justify-content:center;
            font-size:1rem; flex-shrink:0;
        }
        .breakdown-icon.icon-quiz { background:rgba(124,58,237,0.1); color:#7c3aed; }
        .breakdown-icon.icon-asst { background:rgba(16,185,129,0.1);  color:#10b981; }
        .breakdown-info { display:flex; flex-direction:column; flex:1; }
        .breakdown-title { font-size:0.9rem; font-weight:700; color:#1e293b; }
        .breakdown-weight-text { font-size:0.78rem; color:#64748b; margin-top:2px; }
        .sync-chip {
            display:inline-flex; align-items:center; gap:5px;
            background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0;
            border-radius:50px; padding:4px 10px; font-size:0.7rem; font-weight:700; white-space:nowrap;
        }

        /* ── ACTIVITIES CARD ── */
        .activities-card {
            background:white; border-radius:20px;
            border:1px solid #f1f5f9; box-shadow:0 4px 16px rgba(0,0,0,0.05); overflow:hidden;
        }
        .activities-card-header {
            background:linear-gradient(135deg,#1e2f7a,#283593);
            padding:20px 26px; display:flex; align-items:center; gap:16px; color:white;
        }
        .activities-header-left { display:flex; align-items:center; gap:14px; }
        .activities-header-icon {
            width:42px; height:42px; background:rgba(255,255,255,0.15);
            border:1px solid rgba(255,255,255,0.2); border-radius:12px;
            display:flex; align-items:center; justify-content:center;
            font-size:1rem; flex-shrink:0;
        }
        .activities-card-header h3 { font-size:1.05rem; font-weight:700; color:white; margin-bottom:2px; }
        .activities-card-header p { font-size:0.78rem; color:rgba(255,255,255,0.65); }
        .table-container { overflow-x:auto; }
        .activity-table { width:100%; border-collapse:collapse; text-align:left; }
        .activity-table th {
            padding:13px 20px; background:#f8fafc; color:#64748b;
            font-size:0.78rem; font-weight:700; text-transform:uppercase;
            letter-spacing:0.04em; border-bottom:1px solid #f1f5f9; white-space:nowrap;
        }
        .activity-table td { padding:16px 20px; border-bottom:1px solid #f8fafc; font-size:0.9rem; color:#334155; }
        .activity-table tbody tr:last-child td { border-bottom:none; }
        .activity-table tbody tr:hover td { background:#f8fafc; }
        .subject-cell { font-weight:700; color:#1e2f7a; }
        .type-badge {
            display:inline-flex; align-items:center; padding:3px 10px;
            border-radius:50px; font-size:0.7rem; font-weight:700;
            text-transform:uppercase; letter-spacing:0.04em;
        }
        .type-quiz { background:#f5f3ff; color:#7c3aed; }
        .type-asst { background:#dcfce7; color:#15803d; }
        .grade-badge {
            display:inline-flex; align-items:center;
            padding:5px 14px; border-radius:50px; font-size:0.8rem; font-weight:800;
        }
        .grade-perfect { background:#dcfce7; color:#15803d; }
        .grade-high    { background:#dbeafe; color:#1d4ed8; }
        .grade-mid     { background:#fef9c3; color:#b45309; }
        .grade-pending { background:#f1f5f9; color:#64748b; font-style:italic; }

        @media (max-width:1100px) {
            .grade-stats-row { grid-template-columns:repeat(2,1fr); }
        }

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
            .grade-summary-bar { flex-direction:column; align-items:flex-start; }
            .grade-stats-row { grid-template-columns:repeat(2,1fr); gap:12px; }
            .grade-stat-card { padding:16px; }
            .stat-card-value { font-size:1.2rem; }
            .grade-panel { padding:20px 16px; border-radius:16px; }
            .grade-panel-header { flex-direction:column; align-items:flex-start; }
            .download-btn { width:100%; justify-content:center; }
            .graph-container { height:220px; }
            .grade-breakdown-row { grid-template-columns:1fr; }
            .sync-chip { margin-left:56px; }
            .activity-table th,
            .activity-table td { padding:12px 14px; white-space:nowrap; }
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
            <a href="{{ route('shs.gradebook') }}"    class="nav-item active"><i class="fas fa-chart-line"></i> Gradebook</a>
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
            <h1>Gradebook</h1>
        </div>
        <a href="{{ route('shs.profile') }}" class="header-user">
            <i class="fas fa-user-graduate"></i>
            <span>{{ session('shs_student_name') }}</span>
        </a>
    </header>

    <div class="scroll-container">

        {{-- ── Summary Bar ── --}}
        <div class="grade-summary-bar">
            <div class="grade-summary-left">
                <i class="fas fa-chart-line"></i>
                <span><strong>6</strong> graded activities &mdash; 1st Semester 2026</span>
            </div>
            <div class="grade-summary-right">
                <span class="grade-tag tag-passing"><i class="fas fa-check-circle"></i> Passing</span>
                <span class="grade-tag tag-pending">1 Pending</span>
            </div>
        </div>

        {{-- ── Stat Cards ── --}}
        <div class="grade-stats-row">
            <div class="grade-stat-card stat-overall">
                <div class="stat-card-icon"><i class="fas fa-star"></i></div>
                <div class="stat-card-body">
                    <span class="stat-card-value">91.2</span>
                    <span class="stat-card-label">Overall Average</span>
                </div>
            </div>
            <div class="grade-stat-card stat-quiz">
                <div class="stat-card-icon"><i class="fas fa-edit"></i></div>
                <div class="stat-card-body">
                    <span class="stat-card-value">93%</span>
                    <span class="stat-card-label">Quizzes Avg</span>
                </div>
            </div>
            <div class="grade-stat-card stat-asst">
                <div class="stat-card-icon"><i class="fas fa-tasks"></i></div>
                <div class="stat-card-body">
                    <span class="stat-card-value">91%</span>
                    <span class="stat-card-label">Assignments Avg</span>
                </div>
            </div>
            <div class="grade-stat-card stat-status">
                <div class="stat-card-icon"><i class="fas fa-award"></i></div>
                <div class="stat-card-body">
                    <span class="stat-card-value stat-pass-text">PASSING</span>
                    <span class="stat-card-label">Current Status</span>
                </div>
            </div>
        </div>

        {{-- ── Performance Panel ── --}}
        <div class="grade-panel">
            <div class="grade-panel-header">
                <div class="grade-panel-header-left">
                    <div class="grade-panel-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div>
                        <h2>{{ session('shs_student_name') }}</h2>
                        <p class="grade-panel-sub">Grade 12 &mdash; STEM Track &nbsp;&middot;&nbsp; 1st Semester 2026</p>
                    </div>
                </div>
                <button class="download-btn" onclick="downloadReportCard()">
                    <i class="fas fa-file-download"></i> Download Report Card
                </button>
            </div>

            <div class="grade-chart-section">
                <p class="grade-section-label"><i class="fas fa-chart-bar"></i> Performance Analysis</p>
                <div class="graph-container">
                    <canvas id="shsPerformanceChart"></canvas>
                </div>
            </div>

            <div class="grade-breakdown-row">
                <div class="breakdown-card">
                    <div class="breakdown-icon icon-quiz"><i class="fas fa-edit"></i></div>
                    <div class="breakdown-info">
                        <span class="breakdown-title">Quizzes (Summative)</span>
                        <span class="breakdown-weight-text">60% of Final Grade</span>
                    </div>
                    <span class="sync-chip"><i class="fas fa-sync-alt"></i> Auto-Synced</span>
                </div>
                <div class="breakdown-card">
                    <div class="breakdown-icon icon-asst"><i class="fas fa-tasks"></i></div>
                    <div class="breakdown-info">
                        <span class="breakdown-title">Assignments (Formative)</span>
                        <span class="breakdown-weight-text">40% of Final Grade</span>
                    </div>
                    <span class="sync-chip"><i class="fas fa-sync-alt"></i> Auto-Synced</span>
                </div>
            </div>
        </div>

        {{-- ── Submitted Activities ── --}}
        <div class="activities-card">
            <div class="activities-card-header">
                <div class="activities-header-left">
                    <div class="activities-header-icon">
                        <i class="fas fa-list-alt"></i>
                    </div>
                    <div>
                        <h3>Submitted Activities</h3>
                        <p>All graded work for this semester</p>
                    </div>
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
                            <td class="subject-cell">Practical Research 2</td>
                            <td><span class="type-badge type-asst">Assignment</span></td>
                            <td>Draft: Methodology Chapter</td>
                            <td>March 05, 2026</td>
                            <td><span class="grade-badge grade-high">94%</span></td>
                        </tr>
                        <tr>
                            <td class="subject-cell">General Physics 2</td>
                            <td><span class="type-badge type-quiz">Quiz</span></td>
                            <td>Electromagnetism Unit Test</td>
                            <td>March 06, 2026</td>
                            <td><span class="grade-badge grade-mid">88%</span></td>
                        </tr>
                        <tr>
                            <td class="subject-cell">Calculus</td>
                            <td><span class="type-badge type-asst">Assignment</span></td>
                            <td>Problem Set: Integrals</td>
                            <td>March 08, 2026</td>
                            <td><span class="grade-badge grade-perfect">100%</span></td>
                        </tr>
                        <tr>
                            <td class="subject-cell">Biology 2</td>
                            <td><span class="type-badge type-asst">Assignment</span></td>
                            <td>Genetics Laboratory Report</td>
                            <td>March 10, 2026</td>
                            <td><span class="grade-badge grade-pending">Pending</span></td>
                        </tr>
                    </tbody>
                </table>
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
    <a href="{{ route('shs.gradebook') }}"    class="nav-item active"><i class="fas fa-chart-line"></i> Gradebook</a>
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
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('shsPerformanceChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Quiz 1', 'Quiz 2', 'Asst 1', 'Asst 2'],
                datasets: [{
                    label: 'Grade Percentage',
                    data: [92, 94, 88, 91],
                    backgroundColor: '#1e2f7a',
                    borderRadius: 5,
                    barThickness: 60,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { color: '#f1f5f9' },
                        ticks: { stepSize: 10, font: { family: 'Afacad', size: 12 }, color: '#94a3b8' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: 'Afacad', size: 13, weight: '600' }, color: '#1e2f7a' }
                    }
                }
            }
        });
    });

    function downloadReportCard() {
        const btn = document.querySelector('.download-btn');
        const originalContent = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Downloading...';
        btn.style.opacity = '0.8';
        setTimeout(() => {
            alert("Report Card for {{ session('shs_student_name') }} has been generated successfully.");
            btn.innerHTML = originalContent;
            btn.style.opacity = '1';
        }, 2000);
    }

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
