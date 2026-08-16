<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs | DWCU SHS Portal</title>
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
        }

        /* ── Summary Bar ─────────────────────────────────────── */
        .logs-summary-bar {
            display:flex; justify-content:space-between; align-items:center;
            background:white; border-radius:14px; padding:14px 22px;
            margin-bottom:22px; border:1px solid #e2e8f0;
            box-shadow:0 2px 8px rgba(0,0,0,0.04); flex-wrap:wrap; gap:12px;
        }
        .logs-summary-left { display:flex; align-items:center; gap:10px; font-size:0.9rem; color:#475569; }
        .logs-summary-left i { color:#1e2f7a; font-size:1rem; }
        .logs-summary-right { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
        .logs-tag {
            display:inline-flex; align-items:center; gap:5px;
            padding:4px 12px; border-radius:50px; font-size:0.72rem;
            font-weight:700; text-transform:uppercase; letter-spacing:0.04em;
        }
        .tag-private { background:#f5f3ff; color:#7c3aed; }
        .tag-synced  { background:#dcfce7; color:#15803d; }

        /* ── Stat Cards Row ───────────────────────────────────── */
        .logs-stats-row {
            display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:22px;
        }
        .log-stat-card {
            background:white; border-radius:16px; padding:20px;
            border:1px solid #f1f5f9; box-shadow:0 2px 8px rgba(0,0,0,0.04);
            display:flex; align-items:center; gap:16px;
            transition:transform 0.22s, box-shadow 0.22s;
        }
        .log-stat-card:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,0.08); }
        .log-stat-icon {
            width:48px; height:48px; border-radius:13px;
            display:flex; align-items:center; justify-content:center;
            font-size:1.15rem; flex-shrink:0;
        }
        .log-stat-body { display:flex; flex-direction:column; }
        .log-stat-value { font-size:1.45rem; font-weight:800; color:#1e293b; line-height:1.2; }
        .log-stat-label { font-size:0.78rem; color:#94a3b8; font-weight:600; margin-top:2px; }
        .stat-login  .log-stat-icon { background:rgba(21,128,61,0.1);  color:#15803d; }
        .stat-quiz   .log-stat-icon { background:rgba(124,58,237,0.1); color:#7c3aed; }
        .stat-asst   .log-stat-icon { background:rgba(29,78,216,0.1);  color:#1d4ed8; }
        .stat-recent .log-stat-icon { background:rgba(217,119,6,0.1);  color:#d97706; }
        .stat-recent .log-stat-value { font-size:1.1rem; }

        /* ── Logs Card ────────────────────────────────────────── */
        .logs-card {
            background:white; border-radius:20px;
            border:1px solid #f1f5f9; box-shadow:0 4px 16px rgba(0,0,0,0.05); overflow:hidden;
        }
        .logs-card-header {
            background:linear-gradient(135deg,#1e2f7a 0%,#283593 60%,#3949ab 100%);
            padding:18px 24px; display:flex; align-items:center; justify-content:space-between;
            flex-wrap:wrap; gap:14px;
        }
        .logs-card-header-left { display:flex; align-items:center; gap:14px; }
        .logs-card-icon {
            width:42px; height:42px; background:rgba(255,255,255,0.15);
            border:1px solid rgba(255,255,255,0.2); border-radius:12px;
            display:flex; align-items:center; justify-content:center;
            font-size:1rem; color:white; flex-shrink:0;
        }
        .logs-card-header-left h3 { font-size:1rem; font-weight:700; color:white; margin-bottom:2px; }
        .logs-card-header-left p  { font-size:0.78rem; color:rgba(255,255,255,0.6); }
        .logs-card-header-right { display:flex; align-items:center; gap:10px; flex-wrap:wrap; }

        /* Filter pills */
        .filter-pill-group { display:flex; gap:6px; flex-wrap:wrap; }
        .filter-pill {
            display:inline-flex; align-items:center; gap:5px;
            padding:6px 14px; border:1px solid rgba(255,255,255,0.25);
            border-radius:20px; background:rgba(255,255,255,0.1);
            color:rgba(255,255,255,0.8); font-size:0.78rem; font-weight:600;
            cursor:pointer; transition:all 0.2s; font-family:'Afacad',sans-serif;
        }
        .filter-pill i { font-size:0.7rem; }
        .filter-pill:hover { background:rgba(255,255,255,0.2); color:white; }
        .filter-pill.active { background:#fbbf24; color:#1e2f7a; border-color:#fbbf24; font-weight:700; }

        /* Subject dropdown */
        .subject-filter-wrap {
            display:flex; align-items:center; gap:7px;
            background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.25);
            border-radius:8px; padding:6px 12px;
            color:rgba(255,255,255,0.8); font-size:0.78rem;
        }
        .subject-filter-wrap i { font-size:0.72rem; color:rgba(255,255,255,0.7); }
        .subject-dropdown {
            border:none; outline:none; background:transparent;
            font-size:0.78rem; font-weight:600; color:white;
            cursor:pointer; font-family:'Afacad',sans-serif;
        }
        .subject-dropdown option { color:#1e293b; background:white; }

        /* ── Table ────────────────────────────────────────────── */
        .shs-log-table-wrap { overflow-x:auto; }
        .shs-log-table { width:100%; border-collapse:collapse; table-layout:fixed; }
        .shs-log-table thead { background:#f8fafc; }
        .shs-log-table thead th {
            padding:13px 20px; text-align:left; color:#64748b;
            font-size:0.78rem; font-weight:700; text-transform:uppercase;
            letter-spacing:0.04em; border-bottom:1px solid #f1f5f9;
        }
        .shs-log-table thead th i { margin-right:6px; opacity:0.7; }
        .shs-log-table tbody tr { border-bottom:1px solid #f8fafc; transition:background 0.15s; }
        .shs-log-table tbody tr:last-child { border-bottom:none; }
        .shs-log-table tbody tr:hover { background:#f8fafc; }
        .shs-log-table tbody td { padding:14px 20px; font-size:0.88rem; color:#334155; vertical-align:middle; }
        .shs-td-datetime .log-date { display:block; font-weight:600; color:#1e293b; font-size:0.88rem; }
        .shs-td-datetime .log-time { display:block; color:#94a3b8; font-size:0.76rem; margin-top:2px; font-variant-numeric:tabular-nums; }

        .shs-cat-badge {
            display:inline-flex; align-items:center; gap:6px;
            padding:4px 11px; border-radius:6px; font-size:0.75rem; font-weight:700; white-space:nowrap;
        }
        .shs-cat-badge i { font-size:0.68rem; }
        .cat-auth     { background:#ede9fe; color:#6d28d9; }
        .cat-academic { background:#dbeafe; color:#1d4ed8; }
        .cat-system   { background:#f1f5f9; color:#475569; }

        .shs-status-badge {
            display:inline-flex; align-items:center; gap:7px;
            padding:5px 13px; border-radius:20px; font-size:0.76rem; font-weight:700; white-space:nowrap;
        }
        .shs-status-dot { width:6px; height:6px; border-radius:50%; flex-shrink:0; }
        .status-success  { background:#dcfce7; color:#15803d; }
        .status-success  .shs-status-dot { background:#22c55e; }
        .status-progress { background:#fef9c3; color:#92400e; }
        .status-progress .shs-status-dot { background:#f59e0b; }
        .status-info     { background:#dbeafe; color:#1d4ed8; }
        .status-info     .shs-status-dot { background:#3b82f6; }
        .status-warning  { background:#fee2e2; color:#b91c1c; }
        .status-warning  .shs-status-dot { background:#ef4444; }

        .shs-td-desc { font-weight:500; line-height:1.4; }
        .shs-td-desc .desc-subject-tag {
            display:inline-block; font-size:0.7rem; font-weight:700; color:#64748b;
            background:#f1f5f9; padding:1px 7px; border-radius:4px;
            margin-left:8px; vertical-align:middle;
        }

        .shs-log-empty {
            display:flex; flex-direction:column; align-items:center;
            justify-content:center; padding:56px 20px; gap:10px; color:#94a3b8; text-align:center;
        }
        .empty-icon-wrap {
            width:64px; height:64px; background:#f1f5f9; border-radius:50%;
            display:flex; align-items:center; justify-content:center;
            font-size:1.6rem; margin-bottom:4px;
        }
        .shs-log-empty p     { font-size:1rem; font-weight:600; color:#475569; }
        .shs-log-empty small { font-size:0.82rem; color:#94a3b8; }

        /* ── Pagination footer ────────────────────────────────── */
        .logs-card-footer {
            display:flex; align-items:center; justify-content:space-between;
            padding:14px 20px; border-top:1px solid #f1f5f9;
        }
        .shs-page-btn {
            display:inline-flex; align-items:center; gap:7px;
            padding:8px 20px; border:1.5px solid #e2e8f0; border-radius:10px;
            background:white; color:#1e2f7a; font-size:0.85rem; font-weight:700;
            cursor:pointer; transition:all 0.2s; font-family:'Afacad',sans-serif;
        }
        .shs-page-btn:hover:not(:disabled) { background:#1e2f7a; color:white; border-color:#1e2f7a; box-shadow:0 4px 12px rgba(30,47,122,0.2); }
        .shs-page-btn:disabled { opacity:0.3; cursor:not-allowed; }
        .shs-page-dots { display:flex; align-items:center; gap:6px; }
        .page-dot {
            width:32px; height:32px; border-radius:8px; border:1.5px solid #e2e8f0;
            background:white; color:#64748b; font-size:0.82rem; font-weight:600;
            cursor:pointer; display:flex; align-items:center; justify-content:center;
            transition:all 0.2s; font-family:'Afacad',sans-serif;
        }
        .page-dot:hover { border-color:#1e2f7a; color:#1e2f7a; }
        .page-dot.active { background:#1e2f7a; color:white; border-color:#1e2f7a; }

        /* ── Responsive ───────────────────────────────────────── */
        @media (max-width:1100px) { .logs-stats-row { grid-template-columns:repeat(2,1fr); } }
        @media (max-width:768px) {
            .logs-summary-bar { flex-direction:column; align-items:flex-start; }
            .logs-stats-row { grid-template-columns:repeat(2,1fr); gap:12px; }
            .log-stat-card { padding:16px; }
            .log-stat-value { font-size:1.2rem; }
            .logs-card-header { flex-direction:column; align-items:flex-start; gap:12px; padding:16px; }
            .logs-card-header-right { flex-direction:column; align-items:flex-start; width:100%; gap:8px; }
            .subject-filter-wrap { width:100%; box-sizing:border-box; }
            .subject-dropdown { flex:1; }

            .shs-log-table, .shs-log-table tbody,
            .shs-log-table tbody tr, .shs-log-table tbody td { display:block; width:100%; }
            .shs-log-table thead { display:none; }
            .shs-log-table tbody tr {
                background:white; border-radius:12px; border:1px solid #e2e8f0 !important;
                margin:0 16px 10px; width:calc(100% - 32px);
                padding:14px 16px; box-shadow:0 2px 8px rgba(0,0,0,0.04);
            }
            .shs-log-table tbody td {
                display:flex; align-items:flex-start; gap:10px;
                padding:5px 0; border:none; font-size:0.85rem;
            }
            .shs-log-table tbody td::before {
                content:attr(data-label); font-size:0.68rem; font-weight:700;
                text-transform:uppercase; color:#94a3b8; min-width:70px; padding-top:3px; flex-shrink:0;
            }
            .logs-card-footer { padding:12px 16px; gap:8px; }
            .shs-page-btn { padding:7px 14px; font-size:0.8rem; }
            .page-dot { width:28px; height:28px; font-size:0.78rem; }
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
            <a href="{{ route('shs.calendar') }}"     class="nav-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
            <a href="{{ route('shs.logs') }}"         class="nav-item active"><i class="fas fa-history"></i> Activity Logs</a>
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
            <h1>Activity Logs</h1>
        </div>
        <a href="{{ route('shs.profile') }}" class="header-user">
            <i class="fas fa-user-graduate"></i>
            <span>{{ session('shs_student_name') }}</span>
        </a>
    </header>

    <div class="scroll-container">

        @php
            $shsLoginCount = $logs->where('action_type', 'Auth')->where('action', 'like', 'Logged in%')->count();
            $shsQuizCount  = $logs->where('action_type', 'Academic')->count();
            $shsLastActive = $logs->first()?->created_at?->format('M j') ?? '—';
        @endphp
        <!-- Summary bar -->
        <div class="logs-summary-bar">
            <div class="logs-summary-left">
                <i class="fas fa-shield-alt"></i>
                <span><strong>{{ $logs->count() }}</strong> activity record{{ $logs->count() === 1 ? '' : 's' }}</span>
            </div>
            <div class="logs-summary-right">
                <span class="logs-tag tag-private"><i class="fas fa-lock"></i> Private Log</span>
                <span class="logs-tag tag-synced"><i class="fas fa-sync-alt"></i> Auto-Synced</span>
            </div>
        </div>

        <!-- Stat cards -->
        <div class="logs-stats-row">
            <div class="log-stat-card stat-login">
                <div class="log-stat-icon"><i class="fas fa-sign-in-alt"></i></div>
                <div class="log-stat-body">
                    <span class="log-stat-value">{{ $shsLoginCount }}</span>
                    <span class="log-stat-label">Total Logins</span>
                </div>
            </div>
            <div class="log-stat-card stat-quiz">
                <div class="log-stat-icon"><i class="fas fa-edit"></i></div>
                <div class="log-stat-body">
                    <span class="log-stat-value">{{ $shsQuizCount }}</span>
                    <span class="log-stat-label">Quizzes Taken</span>
                </div>
            </div>
            <div class="log-stat-card stat-asst">
                <div class="log-stat-icon"><i class="fas fa-tasks"></i></div>
                <div class="log-stat-body">
                    <span class="log-stat-value">0</span>
                    <span class="log-stat-label">Submitted Work</span>
                </div>
            </div>
            <div class="log-stat-card stat-recent">
                <div class="log-stat-icon"><i class="fas fa-clock"></i></div>
                <div class="log-stat-body">
                    <span class="log-stat-value">{{ $shsLastActive }}</span>
                    <span class="log-stat-label">Last Active</span>
                </div>
            </div>
        </div>

        <!-- Logs Card -->
        <div class="logs-card">

            <!-- Card header -->
            <div class="logs-card-header">
                <div class="logs-card-header-left">
                    <div class="logs-card-icon"><i class="fas fa-history"></i></div>
                    <div>
                        <h3>Session History</h3>
                        <p id="entryCount">— entries</p>
                    </div>
                </div>
                <div class="logs-card-header-right">
                    <div class="filter-pill-group" id="filterPillGroup">
                        <button class="filter-pill active" data-filter="All"><i class="fas fa-list"></i> All</button>
                        <button class="filter-pill" data-filter="Auth"><i class="fas fa-key"></i> Auth</button>
                        <button class="filter-pill" data-filter="Academic"><i class="fas fa-graduation-cap"></i> Academic</button>
                        <button class="filter-pill" data-filter="System"><i class="fas fa-cog"></i> System</button>
                    </div>
                    <div class="subject-filter-wrap">
                        <i class="fas fa-filter"></i>
                        <select id="subjectFilter" class="subject-dropdown">
                            <option value="All">All Subjects</option>
                            <option value="Physics">Physics</option>
                            <option value="Calculus">Calculus</option>
                            <option value="Biology">Biology</option>
                            <option value="Research">Practical Research</option>
                            <option value="General">General</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="shs-log-table-wrap">
                <table class="shs-log-table">
                    <thead>
                        <tr>
                            <th style="width:20%;"><i class="far fa-clock"></i> Date &amp; Time</th>
                            <th style="width:16%;"><i class="fas fa-tag"></i> Category</th>
                            <th style="width:42%;"><i class="fas fa-bolt"></i> Description</th>
                            <th style="width:22%;"><i class="fas fa-circle"></i> Status</th>
                        </tr>
                    </thead>
                    <tbody id="shs-log-body"></tbody>
                </table>

                <div class="shs-log-empty" id="shs-log-empty" style="display:none;">
                    <div class="empty-icon-wrap"><i class="fas fa-folder-open"></i></div>
                    <p>No activity records match your filter.</p>
                    <small>Try selecting a different category or subject.</small>
                </div>
            </div>

            <!-- Pagination footer -->
            <div class="logs-card-footer">
                <button class="shs-page-btn" id="shsPrevBtn" onclick="shsChangePage(-1)">
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
                <div class="shs-page-dots" id="shs-page-dots"></div>
                <button class="shs-page-btn" id="shsNextBtn" onclick="shsChangePage(1)">
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
        <span>Senior High</span>
    </div>
    <a href="{{ route('shs.announcement') }}" class="nav-item"><i class="fas fa-bullhorn"></i> Announcement</a>
    <a href="{{ route('shs.assignments') }}"  class="nav-item"><i class="fas fa-tasks"></i> Assignments</a>
    <a href="{{ route('shs.quizzes') }}"      class="nav-item"><i class="fas fa-edit"></i> Quizzes</a>
    <a href="{{ route('shs.gradebook') }}"    class="nav-item"><i class="fas fa-chart-line"></i> Gradebook</a>
    <a href="{{ route('shs.calendar') }}"     class="nav-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
    <a href="{{ route('shs.logs') }}"         class="nav-item active"><i class="fas fa-history"></i> Activity Logs</a>
    <div class="mobile-logout">
        <form method="POST" action="{{ route('shs.logout') }}">
            @csrf
            <button type="submit" style="background:none; border:none; cursor:pointer; color:#fca5a5; font-weight:600; padding:10px; width:100%; border-radius:8px; font-family:'Afacad',sans-serif; font-size:1rem; display:flex; align-items:center; justify-content:center; gap:8px;">
                <i class="fas fa-sign-out-alt"></i> Log out
            </button>
        </form>
    </div>
</div>

@php
    $shsLogsJson = $logs->map(fn ($l) => [
        'date'        => $l->created_at->format('Y-m-d'),
        'time'        => $l->created_at->format('H:i:s'),
        'category'    => $l->action_type,
        'description' => $l->action,
        'status'      => 'Success',
        'subject'     => $l->module ?: 'General',
    ])->values();
@endphp
<script type="application/json" id="shs-logs-data">{!! json_encode($shsLogsJson, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}</script>
<script>
    // ─── Data Store (from the server) ────────────────────────────────────────
    const shsLogsData = JSON.parse(document.getElementById('shs-logs-data').textContent);

    shsLogsData.sort((a, b) => `${b.date} ${b.time}`.localeCompare(`${a.date} ${a.time}`));

    // ─── State ────────────────────────────────────────────────────────────────
    const SHS_PER_PAGE    = 10;
    let shsCurrentPage    = 1;
    let shsCategoryFilter = 'All';
    let shsSubjectFilter  = 'All';
    let shsFiltered       = [];

    function generateSHSLog(category, description, status, subject = 'General') {
        const now = new Date();
        shsLogsData.unshift({
            date: now.toISOString().slice(0, 10),
            time: now.toTimeString().slice(0, 8),
            category, description, status, subject,
        });
        shsApplyFilters();
    }

    function shsApplyFilters() {
        shsCurrentPage = 1;
        shsFiltered = shsLogsData.filter(log => {
            const catMatch = shsCategoryFilter === 'All' || log.category === shsCategoryFilter;
            const subMatch = shsSubjectFilter  === 'All' || log.subject  === shsSubjectFilter;
            return catMatch && subMatch;
        });
        shsRenderTable();
    }

    function shsRenderTable() {
        const tbody   = document.getElementById('shs-log-body');
        const empty   = document.getElementById('shs-log-empty');
        const prevBtn = document.getElementById('shsPrevBtn');
        const nextBtn = document.getElementById('shsNextBtn');
        const counter = document.getElementById('entryCount');

        const totalPages = Math.max(1, Math.ceil(shsFiltered.length / SHS_PER_PAGE));
        shsCurrentPage   = Math.min(shsCurrentPage, totalPages);

        const start = (shsCurrentPage - 1) * SHS_PER_PAGE;
        const page  = shsFiltered.slice(start, start + SHS_PER_PAGE);

        counter.textContent = `${shsFiltered.length} ${shsFiltered.length === 1 ? 'entry' : 'entries'}`;

        if (page.length === 0) {
            tbody.innerHTML = '';
            empty.style.display = 'flex';
        } else {
            empty.style.display = 'none';
            tbody.innerHTML = page.map(shsBuildRow).join('');
        }

        prevBtn.disabled = shsCurrentPage === 1;
        nextBtn.disabled = shsCurrentPage === totalPages;
        shsRenderDots(totalPages);
    }

    function shsBuildRow(log) {
        const catClass = `cat-${log.category.toLowerCase()}`;
        const catIcon  = { Auth: 'fas fa-key', Academic: 'fas fa-graduation-cap', System: 'fas fa-cog' }[log.category] || 'fas fa-circle';
        const statusClass = {
            'Success':     'status-success',
            'In Progress': 'status-progress',
            'Info':        'status-info',
            'Warning':     'status-warning',
        }[log.status] || 'status-info';
        const subjectTag = log.subject !== 'General'
            ? `<span class="desc-subject-tag">${log.subject}</span>`
            : '';
        return `
            <tr>
                <td class="shs-td-datetime" data-label="Date & Time">
                    <span class="log-date">${formatDate(log.date)}</span>
                    <span class="log-time">${log.time}</span>
                </td>
                <td data-label="Category">
                    <span class="shs-cat-badge ${catClass}"><i class="${catIcon}"></i> ${log.category}</span>
                </td>
                <td class="shs-td-desc" data-label="Description">
                    ${log.description}${subjectTag}
                </td>
                <td data-label="Status">
                    <span class="shs-status-badge ${statusClass}">
                        <span class="shs-status-dot"></span>${log.status}
                    </span>
                </td>
            </tr>`;
    }

    function formatDate(dateStr) {
        const [y, m, d] = dateStr.split('-');
        const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        return `${months[parseInt(m) - 1]} ${parseInt(d)}, ${y}`;
    }

    function shsRenderDots(totalPages) {
        const container = document.getElementById('shs-page-dots');
        const maxDots   = 5;
        if (totalPages <= 1) {
            container.innerHTML = `<span style="font-size:0.875rem;font-weight:600;color:#475569;">Page 1 of 1</span>`;
            return;
        }
        let start = Math.max(1, shsCurrentPage - Math.floor(maxDots / 2));
        let end   = Math.min(totalPages, start + maxDots - 1);
        if (end - start < maxDots - 1) start = Math.max(1, end - maxDots + 1);
        let html = '';
        for (let i = start; i <= end; i++) {
            html += `<button class="page-dot ${i === shsCurrentPage ? 'active' : ''}" onclick="shsGoToPage(${i})">${i}</button>`;
        }
        container.innerHTML = html;
    }

    function shsChangePage(direction) {
        const totalPages = Math.ceil(shsFiltered.length / SHS_PER_PAGE);
        shsCurrentPage   = Math.min(Math.max(1, shsCurrentPage + direction), totalPages);
        shsRenderTable();
    }

    function shsGoToPage(page) {
        shsCurrentPage = page;
        shsRenderTable();
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('filterPillGroup').addEventListener('click', (e) => {
            const pill = e.target.closest('.filter-pill');
            if (!pill) return;
            shsCategoryFilter = pill.dataset.filter;
            document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
            shsApplyFilters();
        });

        document.getElementById('subjectFilter').addEventListener('change', (e) => {
            shsSubjectFilter = e.target.value;
            shsApplyFilters();
        });

        shsApplyFilters();

        // Hamburger menu
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const drawer       = document.getElementById('mobile-nav-drawer');
        const overlay      = document.getElementById('mobile-nav-overlay');
        const closeBtn     = document.getElementById('mobile-nav-close');
        function openMenu()  { drawer.classList.add('open'); overlay.classList.add('open'); document.body.style.overflow = 'hidden'; }
        function closeMenu() { drawer.classList.remove('open'); overlay.classList.remove('open'); document.body.style.overflow = ''; }
        if (hamburgerBtn) hamburgerBtn.addEventListener('click', openMenu);
        if (closeBtn)     closeBtn.addEventListener('click', closeMenu);
        if (overlay)      overlay.addEventListener('click', closeMenu);
    });
</script>

</body>
</html>
