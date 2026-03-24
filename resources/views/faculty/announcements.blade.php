<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements | DWCU Faculty Portal</title>
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
        .mobile-nav-drawer .mobile-logout button { color: #fca5a5; }
        .mobile-nav-drawer .mobile-logout button:hover { background: rgba(248,113,113,0.1); border-radius: 8px; }

        /* ── Page title & profile ── */
        .page-title       { font-size: 1.6rem; font-weight: 800; color: #0d1b44; margin: 0; }
        .no-underline     { text-decoration: none; color: inherit; }
        .text-inherit     { color: inherit; }
        .profile-icon-box { width: 36px; height: 36px; background: linear-gradient(135deg,#1e2f7a,#0d1b44); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #ccff00; font-size: 0.95rem; }
        .mgmt-section-title    { color: #1e2f7a; margin: 0 0 5px; font-size: 1.1rem; font-weight: 700; }
        .management-description { color: #64748b; font-size: 0.9rem; font-weight: 500; margin: 0; }

        /* ── Management header ── */
        .list-management-header {
            display: flex; justify-content: space-between; align-items: flex-end;
            padding: 10px 0; margin-bottom: 25px; margin-top: 10px;
        }

        /* ── Add Announcement button ── */
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
        .grade-filter-container {
            background: linear-gradient(135deg, #f8f9ff 0%, #f1f3fb 100%);
            padding: 16px 24px; border-radius: 14px; margin-bottom: 25px;
            border: 1.5px solid #e4e8f5; box-shadow: 0 2px 8px rgba(30,47,122,0.05);
            position: relative;
        }

        /* ── Section dropdown ── */
        .ann-custom-dropdown { position: relative; width: 100%; max-width: 420px; font-family: 'Afacad', sans-serif; }

        .ann-dropdown-trigger {
            width: 100%; display: flex; align-items: center; justify-content: space-between;
            background: white; border: 1.5px solid #dde2f0; border-radius: 10px;
            padding: 10px 14px; cursor: pointer; font-family: 'Afacad', sans-serif; gap: 10px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .ann-dropdown-trigger:hover,
        .ann-custom-dropdown.open .ann-dropdown-trigger { border-color: #3f51b5; box-shadow: 0 0 0 3px rgba(63,81,181,0.1); }

        .ann-trigger-left { display: flex; align-items: center; gap: 10px; font-size: 0.9rem; font-weight: 600; color: #1e2f7a; }
        .ann-trigger-left i { color: #3f51b5; }

        .ann-chevron { color: #3f51b5; font-size: 0.72rem; transition: transform 0.2s; flex-shrink: 0; }
        .ann-custom-dropdown.open .ann-chevron { transform: rotate(180deg); }

        .ann-dropdown-menu {
            display: none; position: absolute; top: calc(100% + 6px); left: 0; right: 0;
            background: white; border: 1.5px solid #e2e8f0; border-radius: 12px;
            box-shadow: 0 8px 24px rgba(30,47,122,0.13); z-index: 9999;
            list-style: none; margin: 0; padding: 6px;
            max-height: 280px; overflow-y: auto; animation: annDropIn 0.15s ease;
        }
        .ann-custom-dropdown.open .ann-dropdown-menu { display: block; }
        @keyframes annDropIn { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:translateY(0); } }

        .ann-dropdown-group { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; padding: 8px 10px 4px; }
        .ann-dropdown-option { display: flex; align-items: center; gap: 8px; padding: 8px 10px; border-radius: 8px; font-size: 0.88rem; font-weight: 600; color: #1e2f7a; cursor: pointer; transition: background 0.15s; }
        .ann-dropdown-option:hover    { background: #f1f3fb; }
        .ann-dropdown-option.selected { background: #eef1fb; }

        /* ── Grade badges ── */
        .ann-grade-badge { display: inline-flex; align-items: center; justify-content: center; width: 22px; height: 22px; border-radius: 6px; font-size: 0.7rem; font-weight: 700; flex-shrink: 0; }
        .g7  { background: #dbeafe; color: #1d4ed8; }
        .g8  { background: #ede9fe; color: #6d28d9; }
        .g9  { background: #dcfce7; color: #15803d; }
        .g10 { background: #fef9c3; color: #a16207; }
        .g11 { background: #ffedd5; color: #c2410c; }
        .g12 { background: #fce7f3; color: #be185d; }

        /* ── Announcement grid ── */
        .announcement-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
        }

        /* ── Feed card ── */
        .feed-card {
            background: white; border-radius: 15px; padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        /* ── Post cards ── */
        .post-card {
            border-radius: 14px; padding: 22px; margin-bottom: 20px;
            border: 1px solid #edf2f7; transition: transform 0.2s, box-shadow 0.2s;
            background: white;
        }
        .post-card:last-child { margin-bottom: 0; }
        .post-card:hover { transform: scale(1.01); box-shadow: 0 8px 20px rgba(0,0,0,0.06); }
        .post-card.is-expired { opacity: 0.75; background: #fff8f8; border-color: #fecaca; }

        .post-header { display: flex; align-items: center; gap: 15px; margin-bottom: 14px; }

        .post-icon-box {
            width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center; font-size: 1.1rem;
        }
        .blue-bg   { background: #ebf4ff; color: #3182ce; }
        .green-bg  { background: #f0fff4; color: #38a169; }
        .red-bg    { background: #fff0f0; color: #e53e3e; }
        .purple-bg { background: #f5f0ff; color: #805ad5; }
        .orange-bg { background: #fff5e6; color: #dd6b20; }
        .gray-bg   { background: #f7fafc; color: #718096; }

        .post-meta h4 { margin: 0 0 3px; font-size: 1rem; color: #1a202c; font-weight: 700; }
        .post-date    { font-size: 0.78rem; color: #94a3b8; }
        .post-body    { font-size: 0.92rem; color: #555; line-height: 1.6; margin-bottom: 16px; }

        .post-footer { display: flex; justify-content: space-between; align-items: center; }
        .author-tag  { display: flex; align-items: center; gap: 10px; font-size: 0.88rem; font-weight: 500; color: #374151; }
        .avatar-circle { width: 28px; height: 28px; background: #1e2f7a; border-radius: 50%; flex-shrink: 0; }

        .details-btn {
            background: #eef2ff; color: #1e2f7a; border: none;
            padding: 7px 14px; border-radius: 8px; font-weight: 600;
            font-size: 0.82rem; cursor: pointer; text-decoration: none;
            font-family: 'Afacad', sans-serif; transition: background 0.2s;
        }
        .details-btn:hover { background: #dde5ff; }

        /* ── Category badges ── */
        .expired-badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 0.67rem; font-weight: 700; background: #f8d7da; color: #721c24; margin-left: 6px; vertical-align: middle; }
        .cat-badge { display: inline-block; padding: 2px 9px; border-radius: 20px; font-size: 0.69rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px; }
        .cat-quiz       { background: #dbeafe; color: #1e40af; }
        .cat-assignment { background: #dcfce7; color: #166534; }
        .cat-exam-bdg   { background: #fee2e2; color: #991b1b; }
        .cat-meeting    { background: #f3e8ff; color: #6b21a8; }
        .cat-holiday    { background: #fff7ed; color: #9a3412; }
        .cat-general    { background: #f1f5f9; color: #475569; }

        /* ── Empty state ── */
        .ann-empty-state { display: flex; flex-direction: column; align-items: center; padding: 50px 20px; color: #94a3b8; text-align: center; }
        .ann-empty-state i { font-size: 2.5rem; margin-bottom: 12px; }
        .ann-empty-state p { font-size: 0.95rem; }

        /* ── Sidebar ── */
        .mini-calendar-card {
            background: white; border-radius: 20px; padding: 28px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.07); border: 1px solid #edf2f7;
            position: sticky; top: 20px;
        }

        .date-hero {
            text-align: center; padding: 14px; border-radius: 14px;
            margin-bottom: 18px; border: 2px solid #f0f2f5;
        }
        .date-hero p { text-transform: uppercase; letter-spacing: 1px; font-weight: 700; color: #718096; font-size: 0.78rem; margin: 4px 0; }
        .date-hero h2 { font-size: 3.8rem; margin: 0; color: #3f51b5; line-height: 1; }

        .line-divider { border: none; border-top: 1px solid #e2e8f0; margin: 18px 0; }

        .upcoming-list h4 { color: #1e2f7a; font-size: 0.95rem; margin-bottom: 14px; font-weight: 700; }

        .event-item { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
        .event-day  { background: #f1f5f9; color: #3f51b5; width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; border-radius: 10px; font-weight: 700; font-size: 0.88rem; flex-shrink: 0; }
        .event-text p    { margin: 0; font-weight: 600; color: #2d3748; font-size: 0.86rem; }
        .event-text span { font-size: 0.74rem; color: #a0aec0; }

        .calendar-link { display: block; text-align: center; margin-top: 18px; color: #3f51b5; text-decoration: none; font-weight: 700; font-size: 0.84rem; transition: color 0.2s; }
        .calendar-link:hover { color: #1e2f7a; text-decoration: underline; }

        /* ── Modal ── */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(13,27,68,0.55); backdrop-filter: blur(6px);
            display: none; justify-content: center; align-items: center; z-index: 2000;
        }
        .modal-overlay.active { display: flex; }

        .modal-content {
            background: white; width: 90%; max-width: 550px; padding: 32px;
            border-radius: 20px; box-shadow: 0 20px 50px rgba(0,0,0,0.2);
            animation: zoomIn 0.2s ease-out; font-family: 'Afacad', sans-serif;
        }
        @keyframes zoomIn { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }

        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 14px; border-bottom: 1.5px solid #e2e8f0; }
        .modal-header h3 { color: #0d1b44; font-size: 1.1rem; font-weight: 800; margin: 0; }

        .close-btn { background: #f1f5f9; border: none; font-size: 1.3rem; width: 34px; height: 34px; border-radius: 50%; cursor: pointer; transition: background 0.2s, color 0.2s; display: flex; align-items: center; justify-content: center; }
        .close-btn:hover { background: #fee2e2; color: #ef4444; }

        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 7px; font-weight: 700; color: #374151; font-size: 0.85rem; }
        .form-group input,
        .form-group textarea {
            width: 100%; padding: 11px 14px; border: 1.5px solid #e2e8f0;
            border-radius: 10px; font-family: 'Afacad', sans-serif; font-size: 0.92rem;
            background: #fafbff; outline: none; box-sizing: border-box;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-group input:focus,
        .form-group textarea:focus { border-color: #3f51b5; background: white; box-shadow: 0 0 0 3px rgba(63,81,181,0.1); }
        .form-group textarea { resize: vertical; }

        /* ── Modal section dropdown ── */
        .modal-custom-dropdown { position: relative; width: 100%; font-family: 'Afacad', sans-serif; }

        .modal-dd-trigger {
            width: 100%; display: flex; align-items: center; justify-content: space-between;
            background: #fafbff; border: 1.5px solid #e2e8f0; border-radius: 10px;
            padding: 11px 14px; cursor: pointer; font-family: 'Afacad', sans-serif; gap: 10px;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .modal-dd-trigger:hover,
        .modal-custom-dropdown.open .modal-dd-trigger { border-color: #3f51b5; background: white; box-shadow: 0 0 0 3px rgba(63,81,181,0.1); }

        .modal-dd-left { display: flex; align-items: center; gap: 10px; font-size: 0.9rem; font-weight: 600; color: #1e2f7a; }
        .modal-dd-left i { color: #3f51b5; }

        .modal-dd-chevron { color: #3f51b5; font-size: 0.72rem; transition: transform 0.2s; flex-shrink: 0; }
        .modal-custom-dropdown.open .modal-dd-chevron { transform: rotate(180deg); }

        .modal-dd-menu {
            display: none; position: absolute; top: calc(100% + 6px); left: 0; right: 0;
            background: white; border: 1.5px solid #e2e8f0; border-radius: 12px;
            box-shadow: 0 8px 24px rgba(30,47,122,0.13); z-index: 99999;
            list-style: none; margin: 0; padding: 6px;
            max-height: 260px; overflow-y: auto; animation: annDropIn 0.15s ease;
        }
        .modal-custom-dropdown.open .modal-dd-menu { display: block; }

        .modal-dd-group  { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; padding: 8px 10px 4px; }
        .modal-dd-option { display: flex; align-items: center; gap: 8px; padding: 8px 10px; border-radius: 8px; font-size: 0.88rem; font-weight: 600; color: #1e2f7a; cursor: pointer; transition: background 0.15s; }
        .modal-dd-option:hover    { background: #f1f3fb; }
        .modal-dd-option.selected { background: #eef1fb; }

        .modal-actions { display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px; }
        .btn-secondary { background: #f1f5f9; border: none; padding: 10px 22px; border-radius: 10px; cursor: pointer; font-weight: 600; font-family: 'Afacad', sans-serif; color: #475569; transition: background 0.2s; }
        .btn-secondary:hover { background: #e2e8f0; }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .announcement-grid { grid-template-columns: 1fr; }
            .events-sidebar { order: -1; }
            .mini-calendar-card { position: static; }
        }
        @media (max-width: 768px) {
            .list-management-header { flex-direction: column; align-items: flex-start; gap: 12px; }
            .primary-add-btn { width: 100%; justify-content: center; }
            .grade-filter-container { padding: 10px 12px; }
            .ann-custom-dropdown { max-width: 100%; }
            .post-footer { flex-direction: column; align-items: flex-start; gap: 10px; }
            .details-btn { align-self: flex-end; }
            .modal-content { padding: 22px; }
            .modal-actions { flex-direction: column; }
            .modal-actions button { width: 100%; justify-content: center; }
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
            <a href="{{ route('faculty.announcements') }}" class="nav-link-item active"><i class="fas fa-bullhorn"></i> Announcement</a>
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
                <h1 class="page-title">Announcements</h1>
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
                    <h3 class="mgmt-section-title">Post Management</h3>
                    <p class="management-description">Create and manage student announcements.</p>
                </div>
                <button class="primary-add-btn" id="openModalBtn">
                    <i class="fas fa-plus"></i> Add Announcement
                </button>
            </div>

            {{-- ── Section filter ── --}}
            <div class="grade-filter-container">
                <div class="ann-custom-dropdown" id="annSectionDropdown">
                    <button class="ann-dropdown-trigger" id="annDropdownTrigger" type="button">
                        <span class="ann-trigger-left">
                            <i class="fas fa-layer-group"></i>
                            <span id="annDropdownLabel">All Sections</span>
                        </span>
                        <i class="fas fa-chevron-down ann-chevron"></i>
                    </button>
                    <ul class="ann-dropdown-menu" id="annDropdownMenu">
                        <li class="ann-dropdown-option selected" data-value=""><i class="fas fa-border-all" style="color:#3f51b5;font-size:0.82rem;"></i> All Sections</li>
                        <li class="ann-dropdown-group">Junior High School</li>
                        <li class="ann-dropdown-option" data-value="Grade 7 - Explorers"><span class="ann-grade-badge g7">7</span> Grade 7 — Explorers</li>
                        <li class="ann-dropdown-option" data-value="Grade 8 - Researchers"><span class="ann-grade-badge g8">8</span> Grade 8 — Researchers</li>
                        <li class="ann-dropdown-option" data-value="Grade 9 - Innovators"><span class="ann-grade-badge g9">9</span> Grade 9 — Innovators</li>
                        <li class="ann-dropdown-option" data-value="Grade 10 - Leaders"><span class="ann-grade-badge g10">10</span> Grade 10 — Leaders</li>
                        <li class="ann-dropdown-group">Senior High School — Grade 11</li>
                        <li class="ann-dropdown-option" data-value="Grade 11 - STEM"><span class="ann-grade-badge g11">11</span> Grade 11 — STEM</li>
                        <li class="ann-dropdown-option" data-value="Grade 11 - ICT"><span class="ann-grade-badge g11">11</span> Grade 11 — ICT</li>
                        <li class="ann-dropdown-option" data-value="Grade 11 - HUMSS"><span class="ann-grade-badge g11">11</span> Grade 11 — HUMSS</li>
                        <li class="ann-dropdown-group">Senior High School — Grade 12</li>
                        <li class="ann-dropdown-option" data-value="Grade 12 - STEM"><span class="ann-grade-badge g12">12</span> Grade 12 — STEM</li>
                        <li class="ann-dropdown-option" data-value="Grade 12 - ICT"><span class="ann-grade-badge g12">12</span> Grade 12 — ICT</li>
                        <li class="ann-dropdown-option" data-value="Grade 12 - HUMSS"><span class="ann-grade-badge g12">12</span> Grade 12 — HUMSS</li>
                    </ul>
                </div>
            </div>

            {{-- ── Main grid ── --}}
            <div class="announcement-grid">

                {{-- ── Feed ── --}}
                <section class="announcement-feed">
                    <div class="feed-card">
                        <div id="annFeed"></div>
                        <div class="ann-empty-state" id="annEmpty" style="display:none;">
                            <i class="fas fa-inbox"></i>
                            <p>No announcements for this section.</p>
                        </div>
                    </div>
                </section>

                {{-- ── Sidebar ── --}}
                <aside class="events-sidebar">
                    <div class="mini-calendar-card">
                        <div class="date-hero" id="dateHero"></div>
                        <hr class="line-divider">
                        <div class="upcoming-list">
                            <h4>Upcoming Events</h4>
                            <div id="sidebarEventList"></div>
                        </div>
                        <a href="{{ route('faculty.calendar') }}" class="calendar-link">
                            See full calendar <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </aside>

            </div>{{-- /announcement-grid --}}

        </div>{{-- /admin-content-grid --}}
    </main>
</div>

{{-- ── Add Announcement Modal ── --}}
<div class="modal-overlay" id="announcementModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-edit" style="margin-right:8px;"></i> Create New Post</h3>
            <button class="close-btn" id="closeModalBtn">&times;</button>
        </div>
        <form class="modal-form">
            <div class="form-group">
                <label>Target Grade &amp; Section</label>
                <input type="hidden" id="modalSectionValue" name="section">
                <div class="modal-custom-dropdown" id="modalSectionDropdown">
                    <button class="modal-dd-trigger" id="modalDdTrigger" type="button">
                        <span class="modal-dd-left">
                            <i class="fas fa-layer-group"></i>
                            <span id="modalDdLabel" style="color:#94a3b8;font-weight:500;">Select a class...</span>
                        </span>
                        <i class="fas fa-chevron-down modal-dd-chevron"></i>
                    </button>
                    <ul class="modal-dd-menu" id="modalDdMenu">
                        <li class="modal-dd-group">Junior High School</li>
                        <li class="modal-dd-option" data-value="Grade 7 - Explorers"><span class="ann-grade-badge g7">7</span> Grade 7 — Explorers</li>
                        <li class="modal-dd-option" data-value="Grade 8 - Researchers"><span class="ann-grade-badge g8">8</span> Grade 8 — Researchers</li>
                        <li class="modal-dd-option" data-value="Grade 9 - Innovators"><span class="ann-grade-badge g9">9</span> Grade 9 — Innovators</li>
                        <li class="modal-dd-option" data-value="Grade 10 - Leaders"><span class="ann-grade-badge g10">10</span> Grade 10 — Leaders</li>
                        <li class="modal-dd-group">Senior High School — Grade 11</li>
                        <li class="modal-dd-option" data-value="Grade 11 - STEM"><span class="ann-grade-badge g11">11</span> Grade 11 — STEM</li>
                        <li class="modal-dd-option" data-value="Grade 11 - ICT"><span class="ann-grade-badge g11">11</span> Grade 11 — ICT</li>
                        <li class="modal-dd-option" data-value="Grade 11 - HUMSS"><span class="ann-grade-badge g11">11</span> Grade 11 — HUMSS</li>
                        <li class="modal-dd-group">Senior High School — Grade 12</li>
                        <li class="modal-dd-option" data-value="Grade 12 - STEM"><span class="ann-grade-badge g12">12</span> Grade 12 — STEM</li>
                        <li class="modal-dd-option" data-value="Grade 12 - ICT"><span class="ann-grade-badge g12">12</span> Grade 12 — ICT</li>
                        <li class="modal-dd-option" data-value="Grade 12 - HUMSS"><span class="ann-grade-badge g12">12</span> Grade 12 — HUMSS</li>
                    </ul>
                </div>
            </div>
            <div class="form-group">
                <label>Announcement Title</label>
                <input type="text" placeholder="e.g., Final Exam Schedule" required>
            </div>
            <div class="form-group">
                <label>Content Details</label>
                <textarea rows="5" placeholder="Write the details for the students..." required></textarea>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-secondary" id="cancelModalBtn">Cancel</button>
                <button type="submit" class="primary-add-btn">Post Announcement</button>
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
    <a href="{{ route('faculty.calendar') }}"      class="nav-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
    <a href="{{ route('faculty.gradebook') }}"     class="nav-item"><i class="fas fa-book-open"></i> Gradebook</a>
    <a href="{{ route('faculty.announcements') }}" class="nav-item active-drawer"><i class="fas fa-bullhorn"></i> Announcement</a>
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

<script>const CALENDAR_URL = "{{ route('faculty.calendar') }}";</script>
<script src="{{ asset('js/faculty-announcement.js') }}"></script>
</body>
</html>
