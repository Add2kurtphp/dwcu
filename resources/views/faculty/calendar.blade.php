<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar | DWCU Faculty Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    @vite(['resources/css/app.css'])
    <style>
        /* ── Fix logo centering (Tailwind preflight sets img to display:block) ── */
        .school-logo-img { display: block !important; margin: 0 auto !important; }

        /* ── Portal accent overrides ── */
        .portal-identity                            { color: #ccff00 !important; }
        .nav-link-item.active                       { background: #ccff00 !important; color: #0d1b44 !important; box-shadow: 0 4px 15px rgba(204,255,0,0.2) !important; border-left-color: #0d1b44 !important; }
        .mobile-nav-drawer .nav-item.active-drawer  { background: #ccff00 !important; color: #0d1b44 !important; }
        .mobile-nav-drawer .mobile-logout button { color: #fca5a5; }
        .mobile-nav-drawer .mobile-logout button:hover { background: rgba(248,113,113,0.1); border-radius: 8px; }

        /* ── Page title & profile icon ── */
        .page-title         { font-size: 1.6rem; font-weight: 800; color: #0d1b44; margin: 0; }
        .no-underline       { text-decoration: none; color: inherit; }
        .text-inherit       { color: inherit; }
        .profile-icon-box   { width: 36px; height: 36px; background: linear-gradient(135deg,#1e2f7a,#0d1b44); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #ccff00; font-size: 0.95rem; }
        .mgmt-section-title { color: #1e2f7a; margin: 0 0 5px; font-size: 1.1rem; font-weight: 700; }
        .legend-title       { color: #1e2f7a; font-weight: 700; margin-bottom: 14px; font-size: 0.95rem; }

        /* ── Management header ── */
        .list-management-header {
            display: flex; justify-content: space-between; align-items: flex-end;
            padding: 10px 0; margin-bottom: 25px; margin-top: 10px;
        }
        .management-description { color: #64748b; font-size: 0.9rem; font-weight: 500; margin: 0; }

        /* ── Add Event button — same style as Add Student ── */
        .primary-add-btn {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, #1e2f7a, #0d1b44);
            color: white; border: none; padding: 11px 22px;
            border-radius: 12px; font-family: 'Afacad', sans-serif;
            font-weight: 700; font-size: 0.9rem; cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 12px rgba(30,47,122,0.25);
        }
        .primary-add-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(30,47,122,0.4); }

        /* ── Grade filter section ── */
        .search-filter-container {
            background: linear-gradient(135deg, #f8f9ff 0%, #f1f3fb 100%);
            padding: 16px 24px; border-radius: 14px; margin-bottom: 25px;
            border: 1.5px solid #e4e8f5; box-shadow: 0 2px 8px rgba(30,47,122,0.05);
            position: relative;
        }

        /* ── Custom section dropdown ── */
        .cal-custom-dropdown { position: relative; width: 100%; max-width: 420px; font-family: 'Afacad', sans-serif; }
        .cal-dropdown-trigger {
            width: 100%; display: flex; align-items: center; justify-content: space-between;
            background: white; border: 1.5px solid #dde2f0; border-radius: 10px;
            padding: 10px 14px; cursor: pointer; font-family: 'Afacad', sans-serif; gap: 10px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .cal-dropdown-trigger:hover,
        .cal-custom-dropdown.open .cal-dropdown-trigger { border-color: #3f51b5; box-shadow: 0 0 0 3px rgba(63,81,181,0.1); }
        .cal-trigger-left { display: flex; align-items: center; gap: 10px; font-size: 0.9rem; font-weight: 600; color: #1e2f7a; }
        .cal-trigger-left i { color: #3f51b5; }
        .cal-chevron { color: #3f51b5; font-size: 0.72rem; transition: transform 0.2s; flex-shrink: 0; }
        .cal-custom-dropdown.open .cal-chevron { transform: rotate(180deg); }
        .cal-dropdown-menu {
            display: none; position: absolute; top: calc(100% + 6px); left: 0; right: 0;
            background: white; border: 1.5px solid #e2e8f0; border-radius: 12px;
            box-shadow: 0 8px 24px rgba(30,47,122,0.13); z-index: 9999;
            list-style: none; margin: 0; padding: 6px;
            max-height: 280px; overflow-y: auto; animation: calDropIn 0.15s ease;
        }
        .cal-custom-dropdown.open .cal-dropdown-menu { display: block; }
        @keyframes calDropIn { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:translateY(0); } }
        .cal-dropdown-group { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; padding: 8px 10px 4px; }
        .cal-dropdown-option { display: flex; align-items: center; gap: 8px; padding: 8px 10px; border-radius: 8px; font-size: 0.88rem; font-weight: 600; color: #1e2f7a; cursor: pointer; transition: background 0.15s; }
        .cal-dropdown-option:hover    { background: #f1f3fb; }
        .cal-dropdown-option.selected { background: #eef1fb; }

        /* ── Grade badges ── */
        .grade-badge { display: inline-flex; align-items: center; justify-content: center; width: 22px; height: 22px; border-radius: 6px; font-size: 0.7rem; font-weight: 700; flex-shrink: 0; }
        .g7  { background: #dbeafe; color: #1d4ed8; }
        .g8  { background: #ede9fe; color: #6d28d9; }
        .g9  { background: #dcfce7; color: #15803d; }
        .g10 { background: #fef9c3; color: #a16207; }
        .g11 { background: #ffedd5; color: #c2410c; }
        .g12 { background: #fce7f3; color: #be185d; }

        /* ── Calendar main card ── */
        .calendar-main-card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); margin-bottom: 25px; }
        .calendar-grid-container { background-color: #eef1f4; padding: 25px; border-radius: 12px; display: flex; gap: 25px; align-items: flex-start; }
        .calendar-widget { flex: 1.5; background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .calendar-legend-box { flex: 1; background: white; border-radius: 10px; padding: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }

        /* ── Calendar header ── */
        .calendar-header { background: #c5cae9; display: flex; justify-content: space-between; align-items: center; padding: 10px 15px; border-radius: 6px; margin-bottom: 20px; }
        .calendar-header h2 { font-size: 1rem; margin: 0; color: #1e2f7a; font-weight: 700; }
        .calendar-header i { cursor: pointer; color: #1e2f7a; padding: 4px 8px; border-radius: 4px; transition: background 0.15s; }
        .calendar-header i:hover { background: rgba(30,47,122,0.1); }

        /* ── Calendar table ── */
        .calendar-table { width: 100%; border-collapse: separate; border-spacing: 0 5px; }
        .calendar-table th { font-size: 0.8rem; color: #888; padding-bottom: 15px; text-transform: none; text-align: center; }
        .calendar-table td { padding: 10px; text-align: center; font-weight: 500; font-size: 0.9rem; position: relative; cursor: pointer; z-index: 1; }

        /* Event circles */
        .event-blue, .event-green, .event-red { color: white !important; }
        .event-blue::after, .event-green::after, .event-red::after {
            content: ''; position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%); width: 35px; height: 35px;
            border-radius: 50%; z-index: -1;
        }
        .event-blue::after  { background-color: #4a90e2; }
        .event-green::after { background-color: #48bb78; }
        .event-red::after   { background-color: #f56565; }

        /* ── Legend ── */
        .legend-list { list-style: none; padding: 0; margin: 0; }
        .legend-list li { display: flex; align-items: center; gap: 12px; font-size: 0.85rem; margin-bottom: 15px; color: #444; }
        .legend-list h4 { color: #1e2f7a; font-weight: 700; margin-bottom: 14px; }
        .dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
        .dot.blue  { background: #4a90e2; }
        .dot.green { background: #48bb78; }
        .dot.red   { background: #f56565; }

        /* ── Section header row ── */
        .section-header-row { display: flex; justify-content: space-between; align-items: center; margin: 28px 0 14px; }
        .section-label { color: #1e2f7a; margin: 0; font-size: 1.05rem; font-weight: 700; }

        /* ── Deadline items ── */
        .deadline-item {
            background: white; border: 1px solid #eee; padding: 15px 20px;
            border-radius: 10px; margin-bottom: 12px; display: flex;
            justify-content: space-between; align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.03); transition: border-color 0.2s, transform 0.2s;
        }
        .deadline-item:hover { border-color: #3f51b5; transform: scale(1.01); }
        .deadline-info { display: flex; align-items: flex-start; gap: 12px; }
        .deadline-info .dot { margin-top: 5px; }

        /* ── Edit / Delete actions ── */
        .table-actions { display: flex; gap: 8px; flex-shrink: 0; }
        .edit-action {
            background: #f8f9fa; border: 1px solid #ddd; padding: 6px 14px;
            border-radius: 6px; font-size: 0.8rem; font-weight: 600; cursor: pointer;
            font-family: 'Afacad', sans-serif; transition: background 0.2s; display: inline-flex; align-items: center; gap: 5px;
        }
        .edit-action:hover { background: #e9ecef; }
        .delete-action {
            background: none; border: 1px solid #fecaca; color: #ef4444;
            padding: 5px 10px; border-radius: 6px; font-size: 0.78rem;
            cursor: pointer; display: inline-flex; align-items: center; gap: 5px;
            font-family: 'Afacad', sans-serif; font-weight: 600; transition: background 0.15s;
        }
        .delete-action:hover { background: #fee2e2; }

        /* ── Category badges ── */
        .cat-badge { display: inline-block; padding: 2px 9px; border-radius: 20px; font-size: 0.69rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; }
        .cat-quiz       { background: #dbeafe; color: #1e40af; }
        .cat-assignment { background: #dcfce7; color: #166534; }
        .cat-exam-bdg   { background: #fee2e2; color: #991b1b; }
        .cat-meeting    { background: #f3e8ff; color: #6b21a8; }
        .cat-holiday    { background: #fff7ed; color: #9a3412; }
        .cat-general    { background: #f1f5f9; color: #475569; }

        /* ── Expired badge ── */
        .expired-badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 0.67rem; font-weight: 700; background: #f8d7da; color: #721c24; margin-left: 6px; vertical-align: middle; }

        /* ── Announcements ── */
        .ann-add-btn {
            background: #3f51b5; color: white; border: none; padding: 9px 18px;
            border-radius: 8px; font-family: 'Afacad', sans-serif; font-weight: 600; font-size: 0.85rem;
            cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
            box-shadow: 0 3px 8px rgba(63,81,181,0.2); transition: background 0.2s, transform 0.15s;
        }
        .ann-add-btn:hover { background: #303f9f; transform: translateY(-1px); }
        .announcement-item {
            background: white; border: 1px solid #eee; padding: 15px 20px;
            border-radius: 10px; margin-bottom: 10px; transition: border-color 0.2s, transform 0.2s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.03);
        }
        .announcement-item:hover { border-color: #3f51b5; transform: scale(1.005); }
        .announcement-item.is-expired { opacity: 0.72; background: #fff8f8; border-color: #fecaca; }
        .ann-header  { display: flex; justify-content: space-between; align-items: flex-start; gap: 15px; }
        .ann-body    { flex: 1; }
        .ann-title   { font-weight: 700; color: #1e2f7a; font-size: 0.95rem; }
        .ann-meta    { font-size: 0.76rem; color: #64748b; margin-top: 3px; }
        .ann-desc    { font-size: 0.85rem; color: #555; margin: 7px 0 0; line-height: 1.5; }
        .ann-foot    { display: flex; gap: 8px; align-items: center; margin-top: 8px; flex-wrap: wrap; }
        .ann-actions { flex-shrink: 0; }

        /* ── Pagination ── */
        .cal-pagination { display: flex; justify-content: center; align-items: center; gap: 16px; margin-top: 14px; }
        .pag-nav-btn {
            background: #3f51b5; color: white; border: none; padding: 7px 18px;
            border-radius: 8px; font-family: 'Afacad', sans-serif; font-weight: 700; font-size: 0.84rem;
            cursor: pointer; transition: background 0.2s;
        }
        .pag-nav-btn:hover:not(:disabled) { background: #303f9f; }
        .pag-nav-btn:disabled { background: #e2e8f0; color: #94a3b8; cursor: not-allowed; }
        .pag-label { font-weight: 700; color: #1e2f7a; font-size: 0.86rem; font-family: 'Afacad', sans-serif; }

        /* ── Modals ── */
        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(13,27,68,0.6); backdrop-filter: blur(5px);
            z-index: 2000; align-items: center; justify-content: center;
        }
        .modal-overlay.show { display: flex; }
        .modal-card {
            background: white; width: 95%; max-width: 520px;
            padding: 32px; border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            transform: translateY(-20px); transition: transform 0.3s ease;
        }
        .modal-overlay.show .modal-card { transform: translateY(0); }
        .modal-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 22px; padding-bottom: 16px; border-bottom: 1.5px solid #e0e4f0;
        }
        .modal-header h3 { color: #0d1b44; margin: 0; font-size: 1.05rem; font-weight: 800; }
        .close-x { background: none; border: none; font-size: 1.8rem; color: #8892b0; cursor: pointer; line-height: 1; transition: color 0.2s; }
        .close-x:hover { color: #0d1b44; }
        .input-field-group { margin-bottom: 16px; }
        .input-field-group label { display: block; margin-bottom: 5px; font-size: 0.82rem; font-weight: 700; color: #2d3a5e; }
        .input-field-group input,
        .input-field-group select,
        .input-field-group textarea {
            width: 100%; padding: 11px 14px; border: 1.5px solid #e0e4f0;
            border-radius: 10px; font-family: 'Afacad', sans-serif; font-size: 0.9rem;
            color: #0d1b44; background: #fafbff; outline: none; box-sizing: border-box;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .input-field-group input:focus,
        .input-field-group select:focus,
        .input-field-group textarea:focus { border-color: #3f51b5; background: white; box-shadow: 0 0 0 3px rgba(63,81,181,0.1); }
        .input-field-group select {
            -webkit-appearance: none; appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='7' viewBox='0 0 12 7'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%231e2f7a' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 12px center; background-size: 12px; padding-right: 34px; cursor: pointer;
        }
        .input-field-group textarea { resize: vertical; }
        .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .modal-footer-btns { display: flex; justify-content: flex-end; gap: 10px; margin-top: 22px; }
        .btn-secondary { background: #f1f5f9; border: none; padding: 10px 22px; border-radius: 10px; cursor: pointer; font-weight: 600; font-family: 'Afacad', sans-serif; color: #475569; transition: background 0.2s; }
        .btn-secondary:hover { background: #e2e8f0; }
        .btn-primary { background: linear-gradient(135deg, #1e2f7a, #0d1b44); color: white; border: none; padding: 10px 22px; border-radius: 10px; cursor: pointer; font-weight: 700; font-family: 'Afacad', sans-serif; font-size: 0.9rem; transition: opacity 0.2s; }
        .btn-primary:hover { opacity: 0.9; }

        /* ── Announcement modal section dropdown ── */
        .ann-section-dd { position: relative; width: 100%; font-family: 'Afacad', sans-serif; }
        .ann-section-dd-trigger {
            width: 100%; display: flex; align-items: center; justify-content: space-between;
            background: #fcfcfc; border: 1.5px solid #e2e8f0; border-radius: 8px;
            padding: 10px 14px; cursor: pointer; font-family: 'Afacad', sans-serif;
            font-size: 0.9rem; gap: 10px; transition: border-color 0.2s, box-shadow 0.2s;
        }
        .ann-section-dd-trigger:hover,
        .ann-section-dd.open .ann-section-dd-trigger { border-color: #3f51b5; box-shadow: 0 0 0 3px rgba(63,81,181,0.08); }
        .ann-section-dd-left { display: flex; align-items: center; gap: 8px; color: #1e2f7a; font-weight: 600; }
        .ann-section-dd-left i { color: #3f51b5; }
        .ann-section-dd-chevron { font-size: 0.72rem; color: #3f51b5; transition: transform 0.2s; flex-shrink: 0; }
        .ann-section-dd.open .ann-section-dd-chevron { transform: rotate(180deg); }
        .ann-section-dd-menu {
            display: none; position: absolute; top: calc(100% + 4px); left: 0; right: 0;
            background: white; border: 1.5px solid #e2e8f0; border-radius: 10px;
            box-shadow: 0 8px 24px rgba(30,47,122,0.15); z-index: 99999;
            list-style: none; margin: 0; padding: 6px; max-height: 220px; overflow-y: auto;
        }
        .ann-section-dd.open .ann-section-dd-menu { display: block; }
        .ann-section-dd-group { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; padding: 8px 10px 4px; }
        .ann-section-dd-option { display: flex; align-items: center; gap: 8px; padding: 8px 10px; border-radius: 7px; font-size: 0.86rem; font-weight: 600; color: #1e2f7a; cursor: pointer; transition: background 0.15s; }
        .ann-section-dd-option:hover    { background: #f1f3fb; }
        .ann-section-dd-option.selected { background: #eef1fb; }

        /* ── Toast ── */
        .cal-toast {
            position: fixed; top: 30px; right: 30px;
            background: #3f51b5; color: white; padding: 14px 24px;
            border-radius: 12px; display: flex; align-items: center; gap: 10px;
            font-family: 'Afacad', sans-serif; font-weight: 600; font-size: 0.95rem;
            opacity: 0; transform: translateY(-10px); transition: all 0.3s;
            z-index: 9999; pointer-events: none;
        }
        .cal-toast.show { opacity: 1; transform: translateY(0); }

        /* ── Responsive calendar grid ── */
        @media (max-width: 900px) {
            .calendar-grid-container { flex-direction: column; }
            .calendar-widget, .calendar-legend-box { flex: none; width: 100%; }
        }
        @media (max-width: 768px) {
            .list-management-header { flex-direction: column; align-items: flex-start; gap: 12px; }
            .primary-add-btn { width: 100%; justify-content: center; }
            .calendar-main-card { padding: 12px; }
            .calendar-grid-container { padding: 12px; gap: 12px; }
            .section-header-row { flex-wrap: wrap; gap: 10px; }
            .ann-add-btn { width: 100%; justify-content: center; }
            .deadline-item { flex-direction: column; align-items: flex-start; gap: 10px; }
            .deadline-item .table-actions { align-self: flex-end; }
            .search-filter-container { padding: 10px 12px; }
            .cal-custom-dropdown { max-width: 100%; }
            .input-row { grid-template-columns: 1fr; }
        }
        @media (max-width: 600px) {
            .calendar-table td { padding: 5px 2px; font-size: 0.76rem; }
            .calendar-table th { font-size: 0.7rem; padding-bottom: 8px; }
            .event-blue::after, .event-green::after, .event-red::after { width: 26px; height: 26px; }
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
            <a href="{{ route('faculty.calendar') }}"      class="nav-link-item active"><i class="fas fa-calendar-alt"></i> Calendar</a>
            <a href="{{ route('faculty.gradebook') }}"     class="nav-link-item"><i class="fas fa-book-open"></i> Gradebook</a>
            <a href="{{ route('faculty.announcements') }}" class="nav-link-item"><i class="fas fa-bullhorn"></i> Announcement</a>
            <a href="{{ route('faculty.logs') }}"          class="nav-link-item"><i class="fas fa-history"></i> Activity Logs</a>
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
                <h1 class="page-title">Calendar</h1>
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

            {{-- ── Management header ── --}}
            <div class="list-management-header">
                <div class="header-text-group">
                    <h3 class="mgmt-section-title">Event Management</h3>
                    <p class="management-description">Manage events and assignments for your students.</p>
                </div>
                <button class="primary-add-btn" id="openEventModal">
                    <i class="fas fa-plus"></i> Add Event
                </button>
            </div>

            {{-- ── Section filter ── --}}
            <div class="search-filter-container">
                <div class="cal-custom-dropdown" id="calSectionDropdown">
                    <button class="cal-dropdown-trigger" id="calDropdownTrigger" type="button">
                        <span class="cal-trigger-left">
                            <i class="fas fa-layer-group"></i>
                            <span id="calDropdownLabel">All Sections</span>
                        </span>
                        <i class="fas fa-chevron-down cal-chevron"></i>
                    </button>
                    <ul class="cal-dropdown-menu" id="calDropdownMenu">
                        <li class="cal-dropdown-option selected" data-value="">All Sections</li>
                        <li class="cal-dropdown-group">Junior High School</li>
                        <li class="cal-dropdown-option" data-value="Grade 7 - Explorers"><span class="grade-badge g7">7</span> Grade 7 — Explorers</li>
                        <li class="cal-dropdown-option" data-value="Grade 8 - Researchers"><span class="grade-badge g8">8</span> Grade 8 — Researchers</li>
                        <li class="cal-dropdown-option" data-value="Grade 9 - Innovators"><span class="grade-badge g9">9</span> Grade 9 — Innovators</li>
                        <li class="cal-dropdown-option" data-value="Grade 10 - Leaders"><span class="grade-badge g10">10</span> Grade 10 — Leaders</li>
                        <li class="cal-dropdown-group">Senior High School — Grade 11</li>
                        <li class="cal-dropdown-option" data-value="Grade 11 - STEM"><span class="grade-badge g11">11</span> Grade 11 — STEM</li>
                        <li class="cal-dropdown-option" data-value="Grade 11 - ICT"><span class="grade-badge g11">11</span> Grade 11 — ICT</li>
                        <li class="cal-dropdown-option" data-value="Grade 11 - HUMSS"><span class="grade-badge g11">11</span> Grade 11 — HUMSS</li>
                        <li class="cal-dropdown-group">Senior High School — Grade 12</li>
                        <li class="cal-dropdown-option" data-value="Grade 12 - STEM"><span class="grade-badge g12">12</span> Grade 12 — STEM</li>
                        <li class="cal-dropdown-option" data-value="Grade 12 - ICT"><span class="grade-badge g12">12</span> Grade 12 — ICT</li>
                        <li class="cal-dropdown-option" data-value="Grade 12 - HUMSS"><span class="grade-badge g12">12</span> Grade 12 — HUMSS</li>
                    </ul>
                </div>
            </div>

            {{-- ── Calendar widget ── --}}
            <div class="calendar-main-card">
                <div class="calendar-grid-container">
                    <div class="calendar-widget">
                        <div class="calendar-header">
                            <i class="fas fa-chevron-left" id="calPrevMonth"></i>
                            <h2 id="month-year-display">March 2026</h2>
                            <i class="fas fa-chevron-right" id="calNextMonth"></i>
                        </div>
                        <table class="calendar-table">
                            <thead>
                                <tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>
                            </thead>
                            <tbody id="calendar-body"></tbody>
                        </table>
                    </div>
                    <div class="calendar-legend-box">
                        <h4 class="legend-title">Category Legend</h4>
                        <ul class="legend-list">
                            <li><span class="dot blue"></span> Quiz</li>
                            <li><span class="dot green"></span> Assignment</li>
                            <li><span class="dot red"></span> Examination</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- ── Schedule Details ── --}}
            <div class="section-header-row">
                <h3 class="section-label"><i class="fas fa-calendar-check" style="margin-right:8px;font-size:0.95rem;"></i>Schedule Details</h3>
            </div>
            <div id="eventList"></div>
            <div class="cal-pagination" id="evPagination" style="display:none;">
                <button class="pag-nav-btn" id="evPrevBtn" onclick="changeEventPage(-1)">&#8592; Prev</button>
                <span class="pag-label" id="evPageLabel">Page 1 of 1</span>
                <button class="pag-nav-btn" id="evNextBtn" onclick="changeEventPage(1)">Next &#8594;</button>
            </div>

            {{-- ── Announcements ── --}}
            <div class="section-header-row">
                <h3 class="section-label"><i class="fas fa-bullhorn" style="margin-right:8px;font-size:0.95rem;"></i>Announcements</h3>
                <button class="ann-add-btn" id="openAnnModal">
                    <i class="fas fa-plus"></i> Add Announcement
                </button>
            </div>
            <div id="annList"></div>
            <div class="cal-pagination" id="annPagination" style="display:none;">
                <button class="pag-nav-btn" id="annPrevBtn" onclick="changeAnnPage(-1)">&#8592; Prev</button>
                <span class="pag-label" id="annPageLabel">Page 1 of 1</span>
                <button class="pag-nav-btn" id="annNextBtn" onclick="changeAnnPage(1)">Next &#8594;</button>
            </div>

        </div>{{-- /admin-content-grid --}}
    </main>
</div>

{{-- ── Add / Edit Event Modal ── --}}
<div class="modal-overlay" id="eventModal">
    <div class="modal-card">
        <div class="modal-header">
            <h3 id="modalTitle"><i class="fas fa-calendar-plus"></i> Add New Event</h3>
            <button class="close-x" id="closeEventModal">&times;</button>
        </div>
        <form id="eventForm">
            <div class="input-field-group">
                <label>Event Title</label>
                <input type="text" id="eventTitleInput" placeholder="e.g., Midterm Exam" required>
            </div>
            <div class="input-row">
                <div class="input-field-group">
                    <label>Day (1–31)</label>
                    <input type="number" id="eventDateInput" min="1" max="31" required>
                </div>
                <div class="input-field-group">
                    <label>Category</label>
                    <select id="eventTypeInput">
                        <option value="blue">Quiz</option>
                        <option value="green">Assignment</option>
                        <option value="red">Examination</option>
                    </select>
                </div>
            </div>
            <div class="input-field-group">
                <label>Expiry / Due Date</label>
                <input type="date" id="eventExpiryInput" required>
            </div>
            <div class="modal-footer-btns">
                <button type="button" class="btn-secondary" id="cancelEventModal">Cancel</button>
                <button type="submit" class="btn-primary" id="saveEventBtn">Confirm Add</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Add Announcement Modal ── --}}
<div class="modal-overlay" id="annModal">
    <div class="modal-card">
        <div class="modal-header">
            <h3><i class="fas fa-bullhorn"></i> Post Announcement</h3>
            <button class="close-x" id="closeAnnModal">&times;</button>
        </div>
        <form id="annForm">
            <div class="input-field-group">
                <label>Announcement Title</label>
                <input type="text" id="annTitleInput" placeholder="e.g., Faculty Meeting" required>
            </div>
            <div class="input-field-group">
                <label>Target Section</label>
                <input type="hidden" id="annModalSectionValue">
                <div class="ann-section-dd" id="annModalSectionDd">
                    <button class="ann-section-dd-trigger" id="annModalSectionTrigger" type="button">
                        <span class="ann-section-dd-left">
                            <i class="fas fa-layer-group"></i>
                            <span id="annModalSectionLabel">All Sections</span>
                        </span>
                        <i class="fas fa-chevron-down ann-section-dd-chevron"></i>
                    </button>
                    <ul class="ann-section-dd-menu" id="annModalSectionMenu">
                        <li class="ann-section-dd-option selected" data-value=""><i class="fas fa-border-all" style="color:#3f51b5;font-size:0.82rem;"></i> All Sections</li>
                        <li class="ann-section-dd-group">Junior High School</li>
                        <li class="ann-section-dd-option" data-value="Grade 7 - Explorers"><span class="grade-badge g7">7</span> Grade 7 — Explorers</li>
                        <li class="ann-section-dd-option" data-value="Grade 8 - Researchers"><span class="grade-badge g8">8</span> Grade 8 — Researchers</li>
                        <li class="ann-section-dd-option" data-value="Grade 9 - Innovators"><span class="grade-badge g9">9</span> Grade 9 — Innovators</li>
                        <li class="ann-section-dd-option" data-value="Grade 10 - Leaders"><span class="grade-badge g10">10</span> Grade 10 — Leaders</li>
                        <li class="ann-section-dd-group">Senior High School — Grade 11</li>
                        <li class="ann-section-dd-option" data-value="Grade 11 - STEM"><span class="grade-badge g11">11</span> Grade 11 — STEM</li>
                        <li class="ann-section-dd-option" data-value="Grade 11 - ICT"><span class="grade-badge g11">11</span> Grade 11 — ICT</li>
                        <li class="ann-section-dd-option" data-value="Grade 11 - HUMSS"><span class="grade-badge g11">11</span> Grade 11 — HUMSS</li>
                        <li class="ann-section-dd-group">Senior High School — Grade 12</li>
                        <li class="ann-section-dd-option" data-value="Grade 12 - STEM"><span class="grade-badge g12">12</span> Grade 12 — STEM</li>
                        <li class="ann-section-dd-option" data-value="Grade 12 - ICT"><span class="grade-badge g12">12</span> Grade 12 — ICT</li>
                        <li class="ann-section-dd-option" data-value="Grade 12 - HUMSS"><span class="grade-badge g12">12</span> Grade 12 — HUMSS</li>
                    </ul>
                </div>
            </div>
            <div class="input-row">
                <div class="input-field-group">
                    <label>Category</label>
                    <select id="annCategoryInput">
                        <option>Meeting</option>
                        <option>Exam</option>
                        <option>Holiday</option>
                        <option>General</option>
                    </select>
                </div>
                <div class="input-field-group">
                    <label>Expiry Date</label>
                    <input type="date" id="annExpiryInput" required>
                </div>
            </div>
            <div class="input-field-group">
                <label>Description <span style="font-weight:400;color:#aaa;">(optional)</span></label>
                <textarea id="annDescInput" rows="3" placeholder="Brief description or details..."></textarea>
            </div>
            <div class="modal-footer-btns">
                <button type="button" class="btn-secondary" id="cancelAnnModal">Cancel</button>
                <button type="submit" class="btn-primary">Post Announcement</button>
            </div>
        </form>
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
    <a href="{{ route('faculty.calendar') }}"      class="nav-item active-drawer"><i class="fas fa-calendar-alt"></i> Calendar</a>
    <a href="{{ route('faculty.gradebook') }}"     class="nav-item"><i class="fas fa-book-open"></i> Gradebook</a>
    <a href="{{ route('faculty.announcements') }}" class="nav-item"><i class="fas fa-bullhorn"></i> Announcement</a>
    <a href="{{ route('faculty.logs') }}"          class="nav-item"><i class="fas fa-history"></i> Activity Logs</a>
    <div class="mobile-logout">
        <form method="POST" action="{{ route('faculty.logout') }}">
            @csrf
            <button type="submit" style="background:none;border:none;cursor:pointer;color:#fca5a5;font-weight:600;padding:10px;width:100%;border-radius:8px;font-family:'Afacad',sans-serif;font-size:1rem;">
                <i class="fas fa-sign-out-alt"></i> Log out
            </button>
        </form>
    </div>
</div>

{{-- ── Toast ── --}}
<div class="cal-toast" id="calToast"><i class="fas fa-check-circle"></i> <span id="calToastMsg"></span></div>

<script>
// ============================================================
// STORAGE KEYS
// ============================================================
const ANN_STORAGE_KEY = 'dwcu_announcements';
const EVT_STORAGE_KEY = 'dwcu_events';

// ============================================================
// DEFAULT DATA
// ============================================================
const DEFAULT_EVENTS = [
  { id:1, title:'Mathematics Quiz (Algebra)',  day:14, type:'blue',  category:'Quiz',        expiry:'2026-03-14', section:'Grade 9 - Innovators'  },
  { id:2, title:'English Essay Submission',    day:16, type:'green', category:'Assignment',  expiry:'2026-03-16', section:'Grade 9 - Innovators'  },
  { id:3, title:'Science Quarterly Exam',      day:20, type:'red',   category:'Examination', expiry:'2026-03-20', section:'Grade 9 - Innovators'  },
  { id:4, title:'TLE Performance Task',        day:24, type:'green', category:'Assignment',  expiry:'2026-03-24', section:'Grade 8 - Researchers' },
  { id:5, title:'Mathematics Long Quiz #2',    day:28, type:'blue',  category:'Quiz',        expiry:'2026-03-28', section:'Grade 9 - Innovators'  },
  { id:6, title:'Science Fair Judging',        day:22, type:'red',   category:'Examination', expiry:'2026-03-22', section:'Grade 10 - Leaders'    },
  { id:7, title:'ICT Programming Project Due', day: 5, type:'green', category:'Assignment',  expiry:'2026-04-05', section:'Grade 11 - ICT'        },
  { id:8, title:'STEM Chemistry Lab Report',   day:27, type:'green', category:'Assignment',  expiry:'2026-03-27', section:'Grade 12 - STEM'       },
];

const DEFAULT_ANNOUNCEMENTS = [
  { id:1,  title:'Quiz in Mathematics (Algebra)',     category:'Quiz',       expiry:'2026-03-14', desc:'Preparation for the upcoming Algebra quiz. Focus on Linear Equations and Factoring.',   section:'Grade 9 - Innovators',  author:'Math Dept'    },
  { id:2,  title:'English Essay Submission',          category:'Assignment', expiry:'2026-03-16', desc:'Deadline for the descriptive essay submission. Submit your drafts via the portal.',     section:'Grade 9 - Innovators',  author:'English Dept' },
  { id:3,  title:'Faculty Meeting – SHS Department', category:'Meeting',    expiry:'2026-03-25', desc:'Mandatory attendance for all SHS faculty. Venue: AVR Room 3, 3:00 PM.',                 section:'Grade 11 - STEM',       author:'Admin'        },
  { id:4,  title:'Quarterly Examination Schedule',   category:'Exam',       expiry:'2026-04-01', desc:'Exam week is scheduled April 7–11. Please prepare review materials.',                   section:'Grade 12 - STEM',       author:'Admin'        },
  { id:5,  title:'Science Fair Judging Day',          category:'Exam',       expiry:'2026-03-22', desc:'Grade 10 science fair entries will be judged on March 22, Hall B.',                    section:'Grade 10 - Leaders',    author:'Science Dept' },
  { id:6,  title:'TLE Performance Task',             category:'Assignment', expiry:'2026-03-24', desc:'Submit your TLE performance task output to your subject teacher.',                      section:'Grade 8 - Researchers', author:'TLE Dept'     },
  { id:7,  title:'Mathematics Long Quiz #2',         category:'Quiz',       expiry:'2026-03-28', desc:'Coverage includes Quadratic Equations and Systems of Linear Equations.',                section:'Grade 9 - Innovators',  author:'Math Dept'    },
  { id:8,  title:'ICT Programming Project',          category:'Assignment', expiry:'2026-04-05', desc:'Submit your final programming project on the portal. Language: Python or Java.',        section:'Grade 11 - ICT',        author:'ICT Dept'     },
  { id:9,  title:'HUMSS Research Paper Deadline',    category:'Assignment', expiry:'2026-04-03', desc:'Final research paper must be submitted to your HUMSS adviser.',                         section:'Grade 11 - HUMSS',      author:'HUMSS Dept'   },
  { id:10, title:'STEM Chemistry Lab Report',        category:'Assignment', expiry:'2026-03-27', desc:'Laboratory report for the acid-base experiment is due Friday.',                         section:'Grade 12 - STEM',       author:'Science Dept' },
];

// ============================================================
// STORAGE HELPERS
// ============================================================
function loadEvents() {
  try { const s = localStorage.getItem(EVT_STORAGE_KEY); return s ? JSON.parse(s) : [...DEFAULT_EVENTS]; }
  catch { return [...DEFAULT_EVENTS]; }
}
function saveEvents(data) { localStorage.setItem(EVT_STORAGE_KEY, JSON.stringify(data)); }

function loadAnnouncements() {
  try { const s = localStorage.getItem(ANN_STORAGE_KEY); return s ? JSON.parse(s) : [...DEFAULT_ANNOUNCEMENTS]; }
  catch { return [...DEFAULT_ANNOUNCEMENTS]; }
}
function saveAnnouncements(data) { localStorage.setItem(ANN_STORAGE_KEY, JSON.stringify(data)); }

// ============================================================
// STATE
// ============================================================
const TODAY    = new Date(); TODAY.setHours(0,0,0,0);
let EVENTS        = loadEvents();
let ANNOUNCEMENTS = loadAnnouncements();
let nextEventId   = Math.max(...EVENTS.map(e => e.id), 0) + 1;
let nextAnnId     = Math.max(...ANNOUNCEMENTS.map(a => a.id), 0) + 1;
const PER_PAGE    = 4;
let eventPage     = 1;
let annPage       = 1;
let editEventId   = null;
let currentSection = '';
let calYear  = 2026;
let calMonth = 2; // 0-indexed: March

const MONTH_NAMES = ['January','February','March','April','May','June','July','August','September','October','November','December'];

// ============================================================
// UTILITIES
// ============================================================
function isExpired(expiryStr) {
  const d = new Date(expiryStr); d.setHours(0,0,0,0);
  return d < TODAY;
}
const CAT_CLASS = {
  'Quiz':'cat-quiz', 'Assignment':'cat-assignment',
  'Examination':'cat-exam-bdg', 'Exam':'cat-exam-bdg',
  'Meeting':'cat-meeting', 'Holiday':'cat-holiday', 'General':'cat-general',
};
function catCls(cat) { return CAT_CLASS[cat] || 'cat-general'; }

function showToast(msg) {
  const t = document.getElementById('calToast');
  document.getElementById('calToastMsg').textContent = msg;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 2800);
}

// ============================================================
// MODAL HELPERS
// ============================================================
function showModal(el) { el.style.display = 'flex'; setTimeout(() => el.classList.add('show'), 10); }
function hideModal(el) { el.classList.remove('show'); setTimeout(() => { el.style.display = 'none'; }, 300); }

// ============================================================
// CALENDAR
// ============================================================
function generateCalendar() {
  document.getElementById('month-year-display').textContent = MONTH_NAMES[calMonth] + ' ' + calYear;
  const tbody    = document.getElementById('calendar-body');
  const firstDay = new Date(calYear, calMonth, 1).getDay();
  const lastDay  = new Date(calYear, calMonth + 1, 0).getDate();

  const visible = currentSection ? EVENTS.filter(e => e.section === currentSection) : EVENTS;
  const highlights = {};
  visible.forEach(e => { highlights[e.day] = 'event-' + e.type; });

  tbody.innerHTML = '';
  let date = 1;
  for (let i = 0; i < 6; i++) {
    const row = document.createElement('tr');
    for (let j = 0; j < 7; j++) {
      const cell = document.createElement('td');
      if (i === 0 && j < firstDay) {
        cell.innerHTML = '';
      } else if (date > lastDay) {
        row.appendChild(cell); continue;
      } else {
        cell.textContent = date;
        if (highlights[date]) cell.classList.add(highlights[date]);
        date++;
      }
      row.appendChild(cell);
    }
    tbody.appendChild(row);
    if (date > lastDay) break;
  }
}

document.getElementById('calPrevMonth').addEventListener('click', () => {
  calMonth--; if (calMonth < 0) { calMonth = 11; calYear--; }
  generateCalendar();
});
document.getElementById('calNextMonth').addEventListener('click', () => {
  calMonth++; if (calMonth > 11) { calMonth = 0; calYear++; }
  generateCalendar();
});

// ============================================================
// RENDER EVENTS
// ============================================================
function renderEvents() {
  const container = document.getElementById('eventList');
  const filtered  = currentSection ? EVENTS.filter(e => e.section === currentSection) : EVENTS;
  const total     = filtered.length;
  const pages     = Math.max(1, Math.ceil(total / PER_PAGE));
  if (eventPage > pages) eventPage = pages;
  const slice = filtered.slice((eventPage - 1) * PER_PAGE, eventPage * PER_PAGE);
  container.innerHTML = '';

  if (total === 0) {
    container.innerHTML = '<p style="color:#888;padding:15px 0;">No events scheduled for this section.</p>';
    document.getElementById('evPagination').style.display = 'none';
    return;
  }

  slice.forEach(ev => {
    const expired = isExpired(ev.expiry);
    const item = document.createElement('div');
    item.className = 'deadline-item';
    item.innerHTML =
      '<div class="deadline-info">' +
        '<span class="dot ' + ev.type + '"></span>' +
        '<div>' +
          '<p style="margin:0;font-weight:600;">' +
            '<strong>' + MONTH_NAMES[calMonth] + ' ' + ev.day + '</strong> — ' + ev.title +
            (expired ? '<span class="expired-badge">Expired</span>' : '') +
          '</p>' +
          '<div style="margin-top:6px;">' +
            '<span class="cat-badge ' + catCls(ev.category) + '">' + ev.category + '</span>' +
            (ev.section ? '<span style="font-size:0.75rem;color:#94a3b8;margin-left:8px;"><i class="fas fa-users" style="font-size:0.68rem;"></i> ' + ev.section + '</span>' : '') +
            '<span style="font-size:0.75rem;color:#94a3b8;margin-left:8px;"><i class="fas fa-calendar-times" style="font-size:0.68rem;"></i> Due: ' + ev.expiry + '</span>' +
          '</div>' +
        '</div>' +
      '</div>' +
      '<div class="table-actions">' +
        '<button class="edit-action" onclick="openEditEvent(' + ev.id + ')"><i class="fas fa-pen"></i> Edit</button>' +
        '<button class="delete-action" onclick="deleteEvent(' + ev.id + ')"><i class="fas fa-trash"></i></button>' +
      '</div>';
    container.appendChild(item);
  });

  document.getElementById('evPageLabel').textContent = 'Page ' + eventPage + ' of ' + pages;
  document.getElementById('evPrevBtn').disabled = eventPage <= 1;
  document.getElementById('evNextBtn').disabled = eventPage >= pages;
  document.getElementById('evPagination').style.display = total > PER_PAGE ? 'flex' : 'none';
}

// ============================================================
// RENDER ANNOUNCEMENTS
// ============================================================
function renderAnnouncements() {
  const container = document.getElementById('annList');
  const filtered  = currentSection ? ANNOUNCEMENTS.filter(a => a.section === currentSection) : ANNOUNCEMENTS;
  const total     = filtered.length;
  const pages     = Math.max(1, Math.ceil(total / PER_PAGE));
  if (annPage > pages) annPage = pages;
  const slice = filtered.slice((annPage - 1) * PER_PAGE, annPage * PER_PAGE);
  container.innerHTML = '';

  if (total === 0) {
    container.innerHTML = '<p style="color:#888;padding:15px 0;">No announcements for this section.</p>';
    document.getElementById('annPagination').style.display = 'none';
    return;
  }

  slice.forEach(ann => {
    const expired = isExpired(ann.expiry);
    const item = document.createElement('div');
    item.className = 'announcement-item' + (expired ? ' is-expired' : '');
    item.innerHTML =
      '<div class="ann-header">' +
        '<div class="ann-body">' +
          '<span class="ann-title">' + ann.title + (expired ? '<span class="expired-badge">Expired</span>' : '') + '</span>' +
          '<div class="ann-foot">' +
            '<span class="cat-badge ' + catCls(ann.category) + '">' + ann.category + '</span>' +
            (ann.section ? '<span class="ann-meta" style="margin-left:4px;"><i class="fas fa-users" style="font-size:0.68rem;"></i> ' + ann.section + '</span>' : '') +
            '<span class="ann-meta"><i class="fas fa-calendar-times" style="font-size:0.68rem;"></i> Expires: ' + ann.expiry + '</span>' +
          '</div>' +
          (ann.desc ? '<p class="ann-desc">' + ann.desc + '</p>' : '') +
        '</div>' +
        '<div class="ann-actions">' +
          '<button class="delete-action" onclick="deleteAnnouncement(' + ann.id + ')"><i class="fas fa-trash"></i></button>' +
        '</div>' +
      '</div>';
    container.appendChild(item);
  });

  document.getElementById('annPageLabel').textContent = 'Page ' + annPage + ' of ' + pages;
  document.getElementById('annPrevBtn').disabled = annPage <= 1;
  document.getElementById('annNextBtn').disabled = annPage >= pages;
  document.getElementById('annPagination').style.display = total > PER_PAGE ? 'flex' : 'none';
}

// ============================================================
// DELETE
// ============================================================
function deleteEvent(id) {
  if (!confirm('Delete this event?')) return;
  EVENTS.splice(EVENTS.findIndex(e => e.id === id), 1);
  saveEvents(EVENTS);
  generateCalendar();
  renderEvents();
  showToast('Event deleted.');
}

function deleteAnnouncement(id) {
  if (!confirm('Delete this announcement?')) return;
  ANNOUNCEMENTS.splice(ANNOUNCEMENTS.findIndex(a => a.id === id), 1);
  saveAnnouncements(ANNOUNCEMENTS);
  renderAnnouncements();
  showToast('Announcement deleted.');
}

// ============================================================
// PAGINATION
// ============================================================
function changeEventPage(dir) {
  const filtered = currentSection ? EVENTS.filter(e => e.section === currentSection) : EVENTS;
  const pages = Math.max(1, Math.ceil(filtered.length / PER_PAGE));
  eventPage = Math.max(1, Math.min(pages, eventPage + dir));
  renderEvents();
}
function changeAnnPage(dir) {
  const filtered = currentSection ? ANNOUNCEMENTS.filter(a => a.section === currentSection) : ANNOUNCEMENTS;
  const pages = Math.max(1, Math.ceil(filtered.length / PER_PAGE));
  annPage = Math.max(1, Math.min(pages, annPage + dir));
  renderAnnouncements();
}

// ============================================================
// EVENT MODAL
// ============================================================
const eventModal = document.getElementById('eventModal');

document.getElementById('openEventModal').onclick = () => {
  editEventId = null;
  document.getElementById('modalTitle').innerHTML = '<i class="fas fa-calendar-plus"></i> Add New Event';
  document.getElementById('saveEventBtn').textContent = 'Confirm Add';
  document.getElementById('eventForm').reset();
  showModal(eventModal);
};

function openEditEvent(id) {
  const ev = EVENTS.find(e => e.id === id);
  if (!ev) return;
  editEventId = id;
  document.getElementById('modalTitle').innerHTML = '<i class="fas fa-pen"></i> Edit Event';
  document.getElementById('saveEventBtn').textContent = 'Update Event';
  document.getElementById('eventTitleInput').value  = ev.title;
  document.getElementById('eventDateInput').value   = ev.day;
  document.getElementById('eventTypeInput').value   = ev.type;
  document.getElementById('eventExpiryInput').value = ev.expiry;
  showModal(eventModal);
}

document.getElementById('eventForm').addEventListener('submit', e => {
  e.preventDefault();
  const title  = document.getElementById('eventTitleInput').value.trim();
  const day    = parseInt(document.getElementById('eventDateInput').value);
  const type   = document.getElementById('eventTypeInput').value;
  const expiry = document.getElementById('eventExpiryInput').value;
  const catMap = { blue: 'Quiz', green: 'Assignment', red: 'Examination' };

  if (editEventId !== null) {
    const ev = EVENTS.find(e => e.id === editEventId);
    if (ev) { ev.title = title; ev.day = day; ev.type = type; ev.expiry = expiry; ev.category = catMap[type]; }
    showToast('Event updated.');
  } else {
    EVENTS.push({ id: nextEventId++, title, day, type, category: catMap[type], expiry, section: currentSection });
    showToast('Event added.');
  }
  saveEvents(EVENTS);
  generateCalendar();
  renderEvents();
  hideModal(eventModal);
});

document.getElementById('closeEventModal').onclick  = () => hideModal(eventModal);
document.getElementById('cancelEventModal').onclick = () => hideModal(eventModal);

// ============================================================
// ANNOUNCEMENT MODAL
// ============================================================
const annModal = document.getElementById('annModal');

document.getElementById('openAnnModal').onclick = () => {
  document.getElementById('annForm').reset();
  document.getElementById('annModalSectionLabel').textContent = 'All Sections';
  document.getElementById('annModalSectionValue').value = '';
  document.querySelectorAll('#annModalSectionMenu .ann-section-dd-option').forEach(o => o.classList.remove('selected'));
  document.querySelector('#annModalSectionMenu .ann-section-dd-option').classList.add('selected');
  showModal(annModal);
};

document.getElementById('annForm').addEventListener('submit', e => {
  e.preventDefault();
  const title    = document.getElementById('annTitleInput').value.trim();
  const section  = document.getElementById('annModalSectionValue').value;
  const category = document.getElementById('annCategoryInput').value;
  const expiry   = document.getElementById('annExpiryInput').value;
  const desc     = document.getElementById('annDescInput').value.trim();
  ANNOUNCEMENTS.unshift({ id: nextAnnId++, title, category, expiry, desc, section, author: 'Faculty' });
  saveAnnouncements(ANNOUNCEMENTS);
  annPage = 1;
  renderAnnouncements();
  hideModal(annModal);
  showToast('Announcement posted.');
});

document.getElementById('closeAnnModal').onclick  = () => hideModal(annModal);
document.getElementById('cancelAnnModal').onclick = () => hideModal(annModal);

// Ann section dropdown
const annSectionDd      = document.getElementById('annModalSectionDd');
const annSectionTrigger = document.getElementById('annModalSectionTrigger');
annSectionTrigger.addEventListener('click', e => { e.stopPropagation(); annSectionDd.classList.toggle('open'); });
document.querySelectorAll('#annModalSectionMenu .ann-section-dd-option').forEach(opt => {
  opt.addEventListener('click', () => {
    document.getElementById('annModalSectionValue').value = opt.dataset.value;
    document.getElementById('annModalSectionLabel').textContent = opt.textContent.trim();
    document.querySelectorAll('#annModalSectionMenu .ann-section-dd-option').forEach(o => o.classList.remove('selected'));
    opt.classList.add('selected');
    annSectionDd.classList.remove('open');
  });
});

// ============================================================
// SECTION FILTER DROPDOWN
// ============================================================
const calDropdown = document.getElementById('calSectionDropdown');
document.getElementById('calDropdownTrigger').addEventListener('click', e => {
  e.stopPropagation();
  calDropdown.classList.toggle('open');
});
document.querySelectorAll('#calDropdownMenu .cal-dropdown-option').forEach(opt => {
  opt.addEventListener('click', () => {
    currentSection = opt.dataset.value;
    document.getElementById('calDropdownLabel').textContent = opt.textContent.trim();
    document.querySelectorAll('#calDropdownMenu .cal-dropdown-option').forEach(o => o.classList.remove('selected'));
    opt.classList.add('selected');
    calDropdown.classList.remove('open');
    eventPage = 1; annPage = 1;
    generateCalendar();
    renderEvents();
    renderAnnouncements();
  });
});

// ============================================================
// CLOSE DROPDOWNS ON OUTSIDE CLICK
// ============================================================
document.addEventListener('click', () => {
  calDropdown.classList.remove('open');
  annSectionDd.classList.remove('open');
});

// ============================================================
// MOBILE NAV
// ============================================================
const hamburger = document.getElementById('hamburger-btn');
const overlay   = document.getElementById('mobile-nav-overlay');
const drawer    = document.getElementById('mobile-nav-drawer');
const closeNav  = document.getElementById('mobile-nav-close');

function openDrawer()  { overlay.classList.add('open'); drawer.classList.add('open'); }
function closeDrawer() { overlay.classList.remove('open'); drawer.classList.remove('open'); }

hamburger.addEventListener('click', openDrawer);
overlay.addEventListener('click', closeDrawer);
closeNav.addEventListener('click', closeDrawer);

// ============================================================
// INIT
// ============================================================
generateCalendar();
renderEvents();
renderAnnouncements();
</script>
</body>
</html>
