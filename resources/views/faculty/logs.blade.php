<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs | DWCU Faculty Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    @vite(['resources/css/app.css'])
    <style>
        /* ── Fix logo centering ── */
        .school-logo-img { display: block !important; margin: 0 auto !important; }

        /* ── Portal accent overrides ── */
        .portal-identity                            { color: #ccff00 !important; }
        .nav-link-item.active                       { background: #ccff00 !important; color: #0d1b44 !important; box-shadow: 0 4px 15px rgba(204,255,0,0.2) !important; border-left-color: #0d1b44 !important; }
        .mobile-nav-drawer .nav-item.active-drawer  { background: #ccff00 !important; color: #0d1b44 !important; }

        /* ── Page title & profile ── */
        .page-title       { font-size: 1.6rem; font-weight: 800; color: #0d1b44; margin: 0; }
        .no-underline     { text-decoration: none; color: inherit; }
        .text-inherit     { color: inherit; }
        .profile-icon-box { width: 36px; height: 36px; background: linear-gradient(135deg,#1e2f7a,#0d1b44); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #ccff00; font-size: 0.95rem; }

        /* ══════════════════════════════════════════
           LOGS LAYOUT
        ══════════════════════════════════════════ */
        .logs-container { display: flex; flex-direction: column; gap: 20px; }

        /* ── Top bar ── */
        .logs-topbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; }

        .logs-summary {
            display: flex; align-items: center; gap: 10px;
            font-size: 0.875rem; color: #64748b;
            background: #f8fafc; border: 1px solid #e2e8f0;
            padding: 9px 16px; border-radius: 8px;
        }
        .logs-summary i { color: #1e2f7a; }

        .logs-controls { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }

        /* ── Filter buttons ── */
        .filter-group { display: flex; gap: 8px; flex-wrap: wrap; }

        .filter-btn {
            padding: 8px 18px; border: 1px solid #e2e8f0; border-radius: 20px;
            background: white; color: #475569; font-size: 0.85rem; font-weight: 600;
            cursor: pointer; transition: all 0.2s; font-family: 'Afacad', sans-serif;
        }
        .filter-btn:hover { border-color: #1e2f7a; color: #1e2f7a; }
        .filter-btn.active { background: #1e2f7a; color: white; border-color: #1e2f7a; }

        /* ── Custom section dropdown ── */
        .custom-dropdown { position: relative; }

        .custom-dropdown-trigger {
            display: flex; align-items: center; justify-content: space-between; gap: 10px;
            background: white; border: 1.5px solid #e2e8f0; border-radius: 22px;
            padding: 8px 14px 8px 16px; cursor: pointer; font-family: 'Afacad', sans-serif;
            font-size: 0.875rem; font-weight: 600; color: #334155; min-width: 175px;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s; white-space: nowrap;
        }
        .custom-dropdown-trigger:hover { border-color: #1e2f7a; box-shadow: 0 2px 8px rgba(30,47,122,0.1); }
        .custom-dropdown.open .custom-dropdown-trigger { border-color: #1e2f7a; box-shadow: 0 0 0 3px rgba(30,47,122,0.12); background: #f8faff; }

        .dropdown-trigger-left { display: flex; align-items: center; gap: 8px; }
        .dropdown-trigger-left i { color: #1e2f7a; font-size: 0.8rem; }

        .dropdown-chevron { font-size: 0.65rem; color: #94a3b8; transition: transform 0.25s ease, color 0.2s; }
        .custom-dropdown.open .dropdown-chevron { transform: rotate(180deg); color: #1e2f7a; }

        .custom-dropdown-menu {
            position: absolute; top: calc(100% + 8px); right: 0;
            background: white; border: 1.5px solid #e2e8f0; border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1), 0 2px 8px rgba(0,0,0,0.06);
            list-style: none; padding: 6px; min-width: 210px; z-index: 200;
            opacity: 0; transform: translateY(-6px) scale(0.98);
            pointer-events: none; transition: opacity 0.2s ease, transform 0.2s ease;
            transform-origin: top right; max-height: 280px; overflow-y: auto;
        }
        .custom-dropdown.open .custom-dropdown-menu { opacity: 1; transform: translateY(0) scale(1); pointer-events: all; }

        .dropdown-divider { height: 1px; background: #f1f5f9; margin: 4px 6px; }

        .dropdown-option {
            display: flex; align-items: center; gap: 10px; padding: 9px 12px;
            border-radius: 9px; font-size: 0.875rem; font-weight: 500; color: #475569;
            cursor: pointer; transition: background 0.15s, color 0.15s;
        }
        .dropdown-option:hover { background: #f1f5f9; color: #1e2f7a; }
        .dropdown-option.selected { background: #eef1fb; color: #1e2f7a; font-weight: 700; }
        .dropdown-option > i { width: 18px; text-align: center; color: #94a3b8; font-size: 0.8rem; }
        .dropdown-option.selected > i { color: #1e2f7a; }

        /* ── Grade badges ── */
        .grade-badge { display: inline-flex; align-items: center; justify-content: center; width: 22px; height: 22px; border-radius: 6px; font-size: 0.72rem; font-weight: 800; flex-shrink: 0; }
        .g7  { background: #dbeafe; color: #1d4ed8; }
        .g8  { background: #ede9fe; color: #6d28d9; }
        .g9  { background: #dcfce7; color: #15803d; }
        .g10 { background: #fef9c3; color: #a16207; }
        .g11 { background: #ffedd5; color: #c2410c; }
        .g12 { background: #fce7f3; color: #be185d; }

        /* ── Log table wrapper ── */
        .log-table-wrapper {
            background: white; border-radius: 14px; border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden;
            min-height: 420px; display: flex; flex-direction: column;
        }

        .log-table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .log-table th:nth-child(1) { width: 20%; }
        .log-table th:nth-child(2) { width: 16%; }
        .log-table th:nth-child(3) { width: 38%; }
        .log-table th:nth-child(4) { width: 26%; }

        .log-table thead { background: #1e2f7a; color: white; }
        .log-table thead th { padding: 14px 18px; text-align: left; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; }
        .log-table thead th i { margin-right: 6px; opacity: 0.75; }

        .log-table tbody tr { border-bottom: 1px solid #f1f5f9; transition: background 0.15s; }
        .log-table tbody tr:last-child { border-bottom: none; }
        .log-table tbody tr:hover { background: #f8fafc; }
        .log-table tbody td { padding: 13px 18px; font-size: 0.9rem; color: #334155; vertical-align: middle; }

        .td-timestamp { font-size: 0.82rem; color: #64748b; font-variant-numeric: tabular-nums; }
        .td-timestamp .log-date { display: block; font-weight: 600; color: #334155; }
        .td-timestamp .log-time { display: block; color: #94a3b8; font-size: 0.78rem; margin-top: 2px; }

        /* ── Category badges ── */
        .category-badge { display: inline-flex; align-items: center; gap: 7px; padding: 4px 12px; border-radius: 20px; font-size: 0.78rem; font-weight: 700; white-space: nowrap; }
        .dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }

        .badge-login        { background: #dcfce7; color: #15803d; }
        .badge-login .dot   { background: #22c55e; }
        .badge-logout       { background: #f1f5f9; color: #475569; }
        .badge-logout .dot  { background: #94a3b8; }
        .badge-pass         { background: #f3e8ff; color: #7e22ce; }
        .badge-pass .dot    { background: #a855f7; }
        .badge-grade        { background: #fef9c3; color: #a16207; }
        .badge-grade .dot   { background: #eab308; }
        .badge-announcement { background: #dbeafe; color: #1d4ed8; }
        .badge-announcement .dot { background: #3b82f6; }
        .badge-drop         { background: #fee2e2; color: #b91c1c; }
        .badge-drop .dot    { background: #ef4444; }

        .activity-text { font-weight: 500; }

        tr.drop-row  { cursor: pointer; }
        tr.drop-row:hover td  { background: #fff5f5; }
        .drop-flag   { color: #ef4444; margin-right: 4px; font-size: 0.82rem; }

        .view-drop-hint {
            font-size: 0.72rem; color: #b91c1c; font-weight: 500;
            background: #fee2e2; border: 1px solid #fca5a5; border-radius: 20px;
            padding: 1px 8px; margin-left: 8px; vertical-align: middle;
        }

        tr.grade-row { cursor: pointer; }
        tr.grade-row:hover td { background: #fefce8; }
        .view-students-hint {
            font-size: 0.72rem; color: #a16207; font-weight: 500;
            background: #fef9c3; border: 1px solid #fde68a; border-radius: 20px;
            padding: 1px 8px; margin-left: 8px; vertical-align: middle;
        }

        .detail-text { font-size: 0.82rem; color: #64748b; display: flex; align-items: center; gap: 6px; }
        .detail-text i { color: #94a3b8; }

        /* ── Empty state ── */
        .log-empty { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 50px; color: #94a3b8; gap: 12px; }
        .log-empty i { font-size: 2.5rem; }
        .log-empty p { font-size: 1rem; font-weight: 500; }

        /* ── Pagination ── */
        .pagination-bar { display: flex; align-items: center; justify-content: space-between; padding: 0 4px; }

        .page-btn {
            display: flex; align-items: center; gap: 8px; padding: 9px 20px;
            border: 1px solid #e2e8f0; border-radius: 8px; background: white;
            color: #1e2f7a; font-size: 0.875rem; font-weight: 700; cursor: pointer;
            transition: all 0.2s; font-family: 'Afacad', sans-serif;
        }
        .page-btn:hover:not(:disabled) { background: #1e2f7a; color: white; border-color: #1e2f7a; }
        .page-btn:disabled { opacity: 0.35; cursor: not-allowed; }
        .page-info { font-size: 0.875rem; font-weight: 600; color: #475569; }

        /* ══════════════════════════════════════════
           DROP DETAILS MODAL
        ══════════════════════════════════════════ */
        .drop-modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(15,23,42,0.45); z-index: 1000;
            align-items: center; justify-content: center; padding: 20px;
        }
        .drop-modal-overlay.active { display: flex; }

        .drop-modal-content { background: #fff; border-radius: 18px; box-shadow: 0 20px 60px rgba(0,0,0,0.18); width: 100%; max-width: 480px; overflow: hidden; }

        .drop-modal-header { background: linear-gradient(135deg,#0d1b44,#1e2f7a); padding: 20px 24px; display: flex; align-items: center; justify-content: space-between; gap: 14px; }
        .drop-modal-header-left { display: flex; align-items: center; gap: 14px; }
        .drop-modal-icon { width: 40px; height: 40px; background: rgba(239,68,68,0.2); border: 1px solid rgba(239,68,68,0.35); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #fca5a5; font-size: 1rem; flex-shrink: 0; }
        .drop-modal-header h3 { color: #fff; font-size: 1rem; font-weight: 800; margin: 0 0 3px; }
        .drop-modal-header p  { color: rgba(255,255,255,0.55); font-size: 0.78rem; margin: 0; }
        .drop-modal-close { background: rgba(255,255,255,0.1); border: none; color: rgba(255,255,255,0.7); width: 30px; height: 30px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s, color 0.2s; flex-shrink: 0; }
        .drop-modal-close:hover { background: rgba(255,255,255,0.2); color: #fff; }

        .drop-modal-body { padding: 4px 24px 20px; }

        .drop-info-row { display: flex; align-items: flex-start; gap: 14px; padding: 14px 0; border-bottom: 1px solid #f1f5f9; }
        .drop-info-row:last-child { border-bottom: none; }
        .drop-info-icon { width: 34px; height: 34px; background: #f1f5f9; border-radius: 9px; display: flex; align-items: center; justify-content: center; color: #1e2f7a; font-size: 0.85rem; flex-shrink: 0; margin-top: 1px; }
        .drop-info-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; margin-bottom: 3px; }
        .drop-info-value { font-size: 0.9rem; font-weight: 700; color: #1e293b; }
        .drop-info-sub   { font-size: 0.78rem; color: #64748b; margin-top: 2px; }
        .drop-admin-cell { display: flex; align-items: center; gap: 10px; margin-top: 4px; }
        .drop-admin-avatar { width: 32px; height: 32px; background: linear-gradient(135deg,#1e2f7a,#0d1b44); border-radius: 9px; display: flex; align-items: center; justify-content: center; color: #f1c40f; font-size: 0.72rem; font-weight: 800; flex-shrink: 0; }

        /* ══════════════════════════════════════════
           GRADE STUDENTS MODAL
        ══════════════════════════════════════════ */
        .grade-modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(15,23,42,0.45); z-index: 1000;
            align-items: center; justify-content: center; padding: 20px;
        }
        .grade-modal-overlay.active { display: flex; }

        .grade-modal-content { background: #fff; border-radius: 18px; box-shadow: 0 20px 60px rgba(0,0,0,0.18); width: 100%; max-width: 560px; max-height: 80vh; display: flex; flex-direction: column; overflow: hidden; }

        .grade-modal-header { display: flex; align-items: flex-start; justify-content: space-between; padding: 20px 24px 16px; border-bottom: 1.5px solid #f1f5f9; gap: 12px; }
        .grade-modal-header h3 { font-size: 1.05rem; font-weight: 700; color: #1e2f7a; margin: 0 0 4px; }
        .grade-modal-header p  { font-size: 0.82rem; color: #64748b; margin: 0; }
        .grade-modal-close { background: none; border: none; font-size: 1.5rem; color: #94a3b8; cursor: pointer; line-height: 1; flex-shrink: 0; padding: 0 2px; }
        .grade-modal-close:hover { color: #1e2f7a; }

        .grade-modal-body { overflow-y: auto; padding: 16px 24px 20px; }

        .grade-modal-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        .grade-modal-table thead th { text-align: left; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; padding: 0 10px 10px; border-bottom: 1.5px solid #f1f5f9; }
        .grade-modal-table tbody td { padding: 10px; border-bottom: 1px solid #f8fafc; color: #334155; }
        .grade-modal-table tbody tr:last-child td { border-bottom: none; }
        .grade-modal-table tbody tr:hover td { background: #f8fafc; }

        .grade-score-value { font-weight: 700; color: #1e2f7a; }
        .remarks-badge { font-size: 0.72rem; font-weight: 600; border-radius: 20px; padding: 2px 10px; display: inline-block; }
        .r-excellent    { background: #dcfce7; color: #15803d; }
        .r-good         { background: #dbeafe; color: #1d4ed8; }
        .r-satisfactory { background: #fef9c3; color: #a16207; }
        .r-needs        { background: #fee2e2; color: #b91c1c; }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .logs-topbar   { flex-direction: column; align-items: flex-start; gap: 10px; }
            .logs-controls { flex-direction: column; align-items: flex-start; gap: 10px; width: 100%; }
            .custom-dropdown, .custom-dropdown-trigger { width: 100%; }
            .custom-dropdown-menu { left: 0; right: 0; min-width: unset; }
            .logs-summary { font-size: 0.78rem; padding: 8px 12px; }
            .filter-btn   { padding: 6px 14px; font-size: 0.8rem; }
            .log-table-wrapper { min-height: unset; }

            /* Card-style rows */
            .log-table, .log-table tbody, .log-table tbody tr, .log-table tbody td { display: block; width: 100%; }
            .log-table thead { display: none; }
            .log-table tbody tr { background: white; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 10px; padding: 14px 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
            .log-table tbody tr:last-child { border-bottom: 1px solid #e2e8f0; }
            .log-table tbody td { display: flex; align-items: flex-start; gap: 10px; padding: 5px 0; border: none; font-size: 0.875rem; }
            .log-table tbody td::before { content: attr(data-label); font-size: 0.7rem; font-weight: 700; text-transform: uppercase; color: #94a3b8; min-width: 72px; padding-top: 2px; flex-shrink: 0; }
            .page-btn { padding: 8px 14px; font-size: 0.8rem; }
            .view-students-hint, .view-drop-hint { display: block; margin-left: 0; margin-top: 6px; width: fit-content; }
        }
    </style>
</head>
<body>

<div class="dashboard-wrapper">

    {{-- ── SIDEBAR ── --}}
    <aside class="sidebar-container">
        <div class="sidebar-top-branding">
            <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo" class="school-logo-img">
            <div class="school-title-text">DIVINE WORD COLLEGE <br> OF URDANETA</div>
            <div class="portal-identity">Faculty Portal</div>
        </div>
        <nav class="nav-links-list">
            <a href="{{ route('faculty.students') }}"      class="nav-link-item"><i class="fas fa-users"></i> Student List</a>
            <a href="{{ route('faculty.calendar') }}"      class="nav-link-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
            <a href="{{ route('faculty.gradebook') }}"     class="nav-link-item"><i class="fas fa-book-open"></i> Gradebook</a>
            <a href="{{ route('faculty.announcements') }}" class="nav-link-item"><i class="fas fa-bullhorn"></i> Announcement</a>
            <a href="{{ route('faculty.logs') }}"          class="nav-link-item active"><i class="fas fa-history"></i> Activity Logs</a>
        </nav>
        <div class="sidebar-footer-action">
            <form method="POST" action="{{ route('faculty.logout') }}">
                @csrf
                <button type="submit" class="exit-system-link w-full cursor-pointer border-none bg-transparent">
                    <i class="fas fa-sign-out-alt"></i> Log out
                </button>
            </form>
        </div>
    </aside>

    {{-- ── MAIN CONTENT ── --}}
    <main class="main-viewport-content">

        {{-- ── HEADER ── --}}
        <header class="top-nav-bar">
            <div class="flex items-center gap-3">
                <button class="hamburger-btn" id="hamburger-btn" aria-label="Open menu">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title">Activity Logs</h1>
            </div>
            <a href="{{ route('faculty.profile') }}" class="no-underline text-inherit">
                <div class="user-quick-profile">
                    <div class="profile-info">
                        <span class="user-name">{{ session('faculty_name') }}</span>
                        <span class="user-role">Faculty Member</span>
                    </div>
                    <div class="profile-icon-box">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                </div>
            </a>
        </header>

        <div class="admin-content-grid">
            <div class="logs-container">

                {{-- ── Top bar: summary + filters ── --}}
                <div class="logs-topbar">
                    <div class="logs-summary">
                        <i class="fas fa-shield-alt"></i>
                        <span>Showing faculty activity history including student pass requests. All times are in local time.</span>
                    </div>
                    <div class="logs-controls">
                        <div class="filter-group" id="filterGroup">
                            <button class="filter-btn active" data-filter="All">All</button>
                            <button class="filter-btn" data-filter="Login">Logins</button>
                            <button class="filter-btn" data-filter="Pass">Passes</button>
                            <button class="filter-btn" data-filter="Grade">Grades</button>
                            <button class="filter-btn" data-filter="Announcement">Announcements</button>
                            <button class="filter-btn" data-filter="Drop">Drops</button>
                        </div>
                        <div class="custom-dropdown" id="sectionDropdown">
                            <button class="custom-dropdown-trigger" id="dropdownTrigger" type="button">
                                <span class="dropdown-trigger-left">
                                    <i class="fas fa-layer-group"></i>
                                    <span id="dropdownLabel">All Sections</span>
                                </span>
                                <i class="fas fa-chevron-down dropdown-chevron"></i>
                            </button>
                            <ul class="custom-dropdown-menu" id="dropdownMenu">
                                <li class="dropdown-option selected" data-value="All"><i class="fas fa-border-all"></i> All Sections</li>
                                <li class="dropdown-divider"></li>
                                <li class="dropdown-option" data-value="Grade 7 - Explorers"><span class="grade-badge g7">7</span> Grade 7 — Explorers</li>
                                <li class="dropdown-option" data-value="Grade 8 - Researchers"><span class="grade-badge g8">8</span> Grade 8 — Researchers</li>
                                <li class="dropdown-option" data-value="Grade 9 - Innovators"><span class="grade-badge g9">9</span> Grade 9 — Innovators</li>
                                <li class="dropdown-option" data-value="Grade 10 - Leaders"><span class="grade-badge g10">10</span> Grade 10 — Leaders</li>
                                <li class="dropdown-divider"></li>
                                <li class="dropdown-option" data-value="Grade 11 - STEM"><span class="grade-badge g11">11</span> Grade 11 — STEM</li>
                                <li class="dropdown-option" data-value="Grade 11 - ICT"><span class="grade-badge g11">11</span> Grade 11 — ICT</li>
                                <li class="dropdown-option" data-value="Grade 11 - HUMSS"><span class="grade-badge g11">11</span> Grade 11 — HUMSS</li>
                                <li class="dropdown-divider"></li>
                                <li class="dropdown-option" data-value="Grade 12 - STEM"><span class="grade-badge g12">12</span> Grade 12 — STEM</li>
                                <li class="dropdown-option" data-value="Grade 12 - ICT"><span class="grade-badge g12">12</span> Grade 12 — ICT</li>
                                <li class="dropdown-option" data-value="Grade 12 - HUMSS"><span class="grade-badge g12">12</span> Grade 12 — HUMSS</li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- ── Log table ── --}}
                <div class="log-table-wrapper">
                    <table class="log-table">
                        <thead>
                            <tr>
                                <th><i class="far fa-clock"></i> Timestamp</th>
                                <th><i class="fas fa-tag"></i> Category</th>
                                <th><i class="fas fa-bolt"></i> Activity</th>
                                <th><i class="fas fa-user-graduate"></i> Student / Details</th>
                            </tr>
                        </thead>
                        <tbody id="logTableBody"></tbody>
                    </table>
                    <div class="log-empty" id="logEmpty" style="display:none;">
                        <i class="fas fa-inbox"></i>
                        <p>No logs found for this filter.</p>
                    </div>
                </div>

                {{-- ── Pagination ── --}}
                <div class="pagination-bar">
                    <button class="page-btn" id="prevBtn" onclick="changePage(-1)">
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                    <span class="page-info" id="pageInfo">Page 1 of 1</span>
                    <button class="page-btn" id="nextBtn" onclick="changePage(1)">
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                </div>

            </div>{{-- /logs-container --}}
        </div>{{-- /admin-content-grid --}}
    </main>
</div>

{{-- ── Drop Details Modal ── --}}
<div class="drop-modal-overlay" id="dropModal">
    <div class="drop-modal-content">
        <div class="drop-modal-header">
            <div class="drop-modal-header-left">
                <div class="drop-modal-icon"><i class="fas fa-user-minus"></i></div>
                <div>
                    <h3>Student Drop Record</h3>
                    <p id="dropModalMeta">Enrollment drop details</p>
                </div>
            </div>
            <button class="drop-modal-close" id="dropModalClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="drop-modal-body" id="dropModalBody"></div>
    </div>
</div>

{{-- ── Grade Students Modal ── --}}
<div class="grade-modal-overlay" id="gradeModal">
    <div class="grade-modal-content">
        <div class="grade-modal-header">
            <div>
                <h3 id="gradeModalTitle"></h3>
                <p id="gradeModalMeta"></p>
            </div>
            <button class="grade-modal-close" id="gradeModalClose">&times;</button>
        </div>
        <div class="grade-modal-body">
            <table class="grade-modal-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Score</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody id="gradeModalBody"></tbody>
            </table>
        </div>
    </div>
</div>

{{-- ── Mobile nav ── --}}
<div class="mobile-nav-overlay" id="mobile-nav-overlay"></div>
<div class="mobile-nav-drawer" id="mobile-nav-drawer">
    <button class="mobile-nav-close" id="mobile-nav-close" aria-label="Close menu">
        <i class="fas fa-times"></i>
    </button>
    <div class="mobile-brand">
        <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo" style="width:70px;display:block;margin:0 auto 10px;">
        <p>DIVINE WORD COLLEGE<br>OF URDANETA</p>
        <span>Faculty Portal</span>
    </div>
    <a href="{{ route('faculty.students') }}"      class="nav-item"><i class="fas fa-users"></i> Student List</a>
    <a href="{{ route('faculty.calendar') }}"      class="nav-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
    <a href="{{ route('faculty.gradebook') }}"     class="nav-item"><i class="fas fa-book-open"></i> Gradebook</a>
    <a href="{{ route('faculty.announcements') }}" class="nav-item"><i class="fas fa-bullhorn"></i> Announcement</a>
    <a href="{{ route('faculty.logs') }}"          class="nav-item active-drawer"><i class="fas fa-history"></i> Activity Logs</a>
    <div class="mobile-logout">
        <form method="POST" action="{{ route('faculty.logout') }}">
            @csrf
            <button type="submit" style="background:none;border:none;cursor:pointer;color:inherit;width:100%;text-align:left;font-family:'Afacad',sans-serif;font-size:1rem;">
                <i class="fas fa-sign-out-alt"></i> Log out
            </button>
        </form>
    </div>
</div>

<script src="{{ asset('js/faculty-logs-script.js') }}"></script>
</body>
</html>
