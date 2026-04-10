<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List | DWCU Faculty Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    @vite(['resources/css/app.css'])
    <style>
        /* ── Fix logo centering ── */
        .school-logo-img { display: block !important; margin: 0 auto !important; }

        /* ── Portal accent overrides ── */
        .portal-identity                           { color: #ccff00 !important; }
        .nav-link-item.active                      { background: #ccff00 !important; color: #0d1b44 !important; box-shadow: 0 4px 15px rgba(204,255,0,0.2) !important; border-left-color: #0d1b44 !important; }
        .mobile-nav-drawer .nav-item.active-drawer { background: #ccff00 !important; color: #0d1b44 !important; }

        /* ── Management header ── */
        .mgmt-header     { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
        .mgmt-desc       { color: #64748b; font-size: 0.9rem; font-weight: 500; margin: 0; }
        .btn-add-student {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, #1e2f7a, #0d1b44);
            color: white; border: none; padding: 11px 22px;
            border-radius: 12px; font-family: 'Afacad', sans-serif;
            font-weight: 700; font-size: 0.9rem; cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 12px rgba(30,47,122,0.25);
        }
        .btn-add-student:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(30,47,122,0.4); }

        /* ── Page layout ── */
        #sl-page-layout { display: flex; gap: 22px; align-items: flex-start; }
        #sl-main-area   { flex: 1; min-width: 0; }

        /* ── Filter panel ── */
        #sl-filter-panel {
            width: 170px; flex-shrink: 0;
            background: white; border-radius: 14px;
            padding: 20px 14px; border: 1px solid #e2e8f0;
            box-shadow: 0 4px 14px rgba(0,0,0,0.05);
            box-sizing: border-box;
        }
        .fp-header   { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; }
        .fp-title    { font-size: 0.72rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.8px; margin: 0; }
        .fp-close    { display: none; background: none; border: none; color: #64748b; font-size: 1rem; cursor: pointer; padding: 4px 8px; border-radius: 6px; transition: background 0.2s; }
        .fp-close:hover { background: #f1f5f9; }
        .fp-group    { margin-bottom: 22px; }
        .fp-group:last-child { margin-bottom: 0; }
        .fp-label    { font-size: 0.76rem; font-weight: 800; color: #1e2f7a; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 8px; display: flex; align-items: center; gap: 6px; }
        .fp-divider  { border: none; border-top: 1px solid #f1f5f9; margin: 16px 0; }

        /* ── Filter chips ── */
        .filter-chip {
            display: flex; align-items: center; gap: 8px;
            width: 100%; text-align: left; padding: 8px 11px;
            border: 1px solid #e2e8f0; border-radius: 8px;
            background: white; font-family: 'Afacad', sans-serif;
            font-size: 0.87rem; font-weight: 600; color: #4a5568;
            cursor: pointer; margin-bottom: 5px; transition: all 0.15s;
            box-sizing: border-box;
        }
        .filter-chip:last-child  { margin-bottom: 0; }
        .filter-chip:hover       { border-color: #1e2f7a; color: #1e2f7a; background: #f0f4ff; }
        .filter-chip.active      { background: #1e2f7a !important; color: white !important; border-color: #1e2f7a !important; }
        .chip-dot                { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
        .dot-all                 { background: #cbd5e1; }
        .dot-active              { background: #22c55e; }
        .dot-inactive            { background: #f59e0b; }
        .dot-dropped             { background: #ef4444; }

        /* ── Mobile filter toggle ── */
        .mobile-filter-row { display: none; margin-bottom: 12px; }
        .mobile-filter-btn {
            display: flex; align-items: center; gap: 8px;
            background: #1e2f7a; color: white; border: none;
            padding: 10px 18px; border-radius: 10px;
            font-family: 'Afacad', sans-serif; font-size: 0.95rem; font-weight: 700;
            cursor: pointer; transition: background 0.2s;
        }
        .mobile-filter-btn:hover { background: #2a3f9d; }
        .filter-badge {
            background: #ccff00; color: #1e2f7a;
            font-size: 0.7rem; font-weight: 800;
            padding: 1px 7px; border-radius: 20px;
        }

        /* ── Filter panel overlay ── */
        #sl-filter-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 950; }
        #sl-filter-overlay.open { display: block; }

        /* ── Search bar ── */
        .search-bar {
            background: white; border-radius: 12px; padding: 12px 18px;
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 16px; border: 1.5px solid #e0e4f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04); transition: border-color 0.2s;
        }
        .search-bar:focus-within { border-color: #1e2f7a; }
        .search-bar i   { color: #8892b0; font-size: 1rem; flex-shrink: 0; }
        .search-bar input {
            background: transparent; border: none; outline: none;
            width: 100%; font-size: 0.95rem;
            font-family: 'Afacad', sans-serif; color: #0d1b44;
        }
        .search-bar input::placeholder { color: #b8c0d4; }

        /* ── Table card ── */
        .table-card {
            background: white; border-radius: 16px; overflow: hidden;
            border: 1.5px solid #e0e4f0; box-shadow: 0 4px 16px rgba(0,0,0,0.05);
            overflow-x: auto;
        }
        .data-table { width: 100%; border-collapse: collapse; min-width: 560px; }
        .data-table th {
            text-align: left; padding: 14px 18px;
            color: #1e2f7a; font-weight: 800; font-size: 0.78rem;
            text-transform: uppercase; letter-spacing: 0.5px;
            border-bottom: 2px solid #e0e4f0; background: #f8f9ff;
        }

        /* ── Table rows (JS-generated) ── */
        .td-cell {
            padding: 14px 18px; border-bottom: 1px solid #f0f2f8;
            font-size: 0.92rem; color: #2d3a5e; font-weight: 500; vertical-align: middle;
        }
        #studentTbody tr:last-child .td-cell { border-bottom: none; }
        #studentTbody tr:hover .td-cell      { background-color: #fafbff; }
        .email-cell     { text-decoration: none; color: #1e2f7a; font-weight: 600; }
        .email-cell:hover { text-decoration: underline; }
        .badge-active   { display:inline-block; padding:3px 12px; border-radius:20px; font-weight:700; font-size:0.78rem; background:#dcfce7; color:#15803d; }
        .badge-inactive { display:inline-block; padding:3px 12px; border-radius:20px; font-weight:700; font-size:0.78rem; background:#fff3cd; color:#92640a; }
        .badge-dropped  { display:inline-block; padding:3px 12px; border-radius:20px; font-weight:700; font-size:0.78rem; background:#fde8ec; color:#c0152f; }
        .btn-edit, .btn-delete {
            border:none; cursor:pointer; font-weight:600; font-size:0.78rem;
            transition:background 0.2s; padding:5px 11px; border-radius:7px;
            display:inline-flex; align-items:center; gap:4px;
            font-family:'Afacad', sans-serif;
        }
        .btn-edit   { background:#eef1fb; color:#1e2f7a; }
        .btn-delete { background:#fde8ec; color:#c0152f; }
        .btn-edit:hover   { background:#dde3f5; }
        .btn-delete:hover { background:#fbd0d8; }

        /* ── Pagination ── */
        .pagination-bar { display: flex; justify-content: center; align-items: center; gap: 15px; margin-top: 20px; }
        .page-nav-btn {
            background: #1e2f7a; color: white; border: none;
            padding: 8px 20px; border-radius: 8px;
            font-family: 'Afacad', sans-serif; font-weight: 700; font-size: 0.9rem;
            cursor: pointer; transition: background 0.2s;
        }
        .page-nav-btn:hover:not(:disabled) { background: #2a3f9d; }
        .page-nav-btn:disabled { background: #e2e8f0; color: #94a3b8; cursor: not-allowed; }
        .page-lbl { font-weight: 700; color: #1e2f7a; font-family: 'Afacad', sans-serif; font-size: 0.95rem; }

        /* ── Edit dropdown (JS-generated) ── */
        .sl-edit-dropdown {
            position: fixed; background: white;
            border: 1.5px solid #e2e8f0; border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12); z-index: 9999;
            min-width: 178px; padding: 6px;
            animation: dropIn 0.15s ease;
        }
        @keyframes dropIn {
            from { opacity: 0; transform: translateY(-6px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0)    scale(1);    }
        }
        .sl-drop-item {
            display: flex; align-items: center; gap: 9px;
            padding: 9px 13px; border: none; background: none;
            width: 100%; text-align: left; cursor: pointer;
            font-family: 'Afacad', sans-serif; font-size: 0.875rem; font-weight: 600;
            border-radius: 8px; transition: background 0.15s, color 0.15s; color: #334155;
        }
        .sl-drop-item i        { width: 16px; text-align: center; font-size: 0.8rem; }
        .sl-drop-edit:hover    { background: #eef1fb; color: #1e2f7a; }
        .sl-drop-dropped:hover { background: #fff1f2; color: #e11d48; }

        /* ── Modal ── */
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
        .modal-header h3  { color: #0d1b44; margin: 0; font-size: 1.05rem; font-weight: 800; }
        .close-x { background: none; border: none; font-size: 1.8rem; color: #8892b0; cursor: pointer; line-height: 1; transition: color 0.2s; }
        .close-x:hover { color: #0d1b44; }
        .input-group { margin-bottom: 16px; text-align: left; }
        .input-group label { display: block; margin-bottom: 5px; font-size: 0.82rem; font-weight: 700; color: #2d3a5e; }
        .input-group input,
        .input-group select {
            width: 100%; padding: 11px 14px; border: 1.5px solid #e0e4f0;
            border-radius: 10px; font-family: 'Afacad', sans-serif; font-size: 0.9rem;
            color: #0d1b44; background: #fafbff; outline: none; box-sizing: border-box;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .input-group input:focus,
        .input-group select:focus { border-color: #1e2f7a; background: white; box-shadow: 0 0 0 3px rgba(30,47,122,0.1); }
        .input-group select {
            -webkit-appearance: none; appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='7' viewBox='0 0 12 7'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%231e2f7a' stroke-width='1.5' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 12px center; background-size: 12px;
            padding-right: 34px; cursor: pointer;
        }
        .input-row   { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .strand-hints { display: flex; gap: 6px; margin-top: 6px; flex-wrap: wrap; }
        .strand-hint { font-size: 0.7rem; font-weight: 700; padding: 2px 8px; border-radius: 20px; cursor: pointer; transition: opacity 0.15s; }
        .strand-hint:hover { opacity: 0.75; }
        .sh-stem { background: #dbeafe; color: #1d4ed8; }
        .sh-ict  { background: #dcfce7; color: #15803d; }
        .sh-hum  { background: #fce7f3; color: #be185d; }
        .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 22px; }
        .btn-secondary {
            background: #f1f5f9; border: none; padding: 10px 22px;
            border-radius: 10px; cursor: pointer; font-weight: 600;
            font-family: 'Afacad', sans-serif; color: #475569; transition: background 0.2s;
        }
        .btn-secondary:hover { background: #e2e8f0; }
        .btn-primary {
            background: linear-gradient(135deg, #1e2f7a, #0d1b44);
            color: white; border: none; padding: 10px 22px;
            border-radius: 10px; cursor: pointer; font-weight: 700;
            font-family: 'Afacad', sans-serif; transition: opacity 0.2s;
        }
        .btn-primary:hover { opacity: 0.9; }

        /* ── Toast ── */
        .toast {
            position: fixed; top: 30px; right: 30px;
            background: #16a34a; color: white; padding: 14px 24px;
            border-radius: 12px; display: none; align-items: center; gap: 10px;
            font-weight: 600; font-size: 0.95rem; font-family: 'Afacad', sans-serif;
            box-shadow: 0 8px 25px rgba(22,163,74,0.3); z-index: 3000;
            transform: translateX(0);
            transition: opacity 0.3s ease;
            opacity: 0;
        }
        .toast.active { display: flex; opacity: 1; }

        /* ── Mobile responsive ── */
        @media (max-width: 768px) {
            .mgmt-header { flex-direction: column; align-items: flex-start; }
            .btn-add-student { width: 100%; justify-content: center; }
            .mobile-filter-row { display: flex; }
            #sl-page-layout { display: block !important; }
            #sl-filter-panel {
                position: fixed !important; bottom: -100% !important; top: auto !important;
                left: 0 !important; right: 0 !important; width: 100% !important;
                max-height: 75vh; overflow-y: auto;
                border-radius: 20px 20px 0 0; z-index: 951;
                box-shadow: 0 -8px 30px rgba(0,0,0,0.15); transition: bottom 0.35s ease;
            }
            #sl-filter-panel.open { bottom: 0 !important; }
            .fp-close { display: block !important; }
            .input-row { grid-template-columns: 1fr; }
            .modal-overlay { align-items: flex-end; }
            .modal-card { padding: 20px 18px; max-height: 92vh; overflow-y: auto; border-radius: 20px 20px 0 0; width: 100%; }
        }
    </style>
</head>
<body>

<div class="dashboard-wrapper">

    {{-- ── SIDEBAR ── --}}
    <aside class="sidebar-container" id="sidebar">
        <div class="sidebar-top-branding">
            <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo"
                 class="school-logo-img">
            <div class="school-title-text">DIVINE WORD COLLEGE <br> OF URDANETA</div>
            <div class="portal-identity">Faculty Portal</div>
        </div>
        <nav class="nav-links-list">
            <a href="{{ route('faculty.students') }}"      class="nav-link-item active"><i class="fas fa-users"></i> Student List</a>
            <a href="{{ route('faculty.calendar') }}"      class="nav-link-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
            <a href="{{ route('faculty.gradebook') }}"     class="nav-link-item"><i class="fas fa-book-open"></i> Gradebook</a>
            <a href="{{ route('faculty.announcements') }}" class="nav-link-item"><i class="fas fa-bullhorn"></i> Announcement</a>
            <a href="{{ route('faculty.logs') }}"          class="nav-link-item"><i class="fas fa-history"></i> Activity Logs</a>
        </nav>
        <div class="sidebar-footer-action">
            <form method="POST" action="{{ route('faculty.logout') }}">
                @csrf
                <button type="submit" class="exit-system-link"
                        style="background:none;border:none;cursor:pointer;width:100%;">
                    <i class="fas fa-sign-out-alt"></i> Log out
                </button>
            </form>
        </div>
    </aside>

    {{-- ── MAIN CONTENT ── --}}
    <main class="main-viewport-content">

        {{-- ── HEADER ── --}}
        <header class="top-nav-bar">
            <div style="display:flex;align-items:center;gap:12px;">
                <button class="hamburger-btn" id="hamburger-btn" aria-label="Open menu">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 style="font-size:1.6rem;font-weight:800;color:#0d1b44;margin:0;">Student List</h1>
            </div>
            <a href="{{ route('faculty.profile') }}" style="text-decoration:none;color:inherit;">
                <div class="user-quick-profile">
                    <div class="profile-info">
                        <span class="user-name">{{ session('faculty_name') }}</span>
                        <span class="user-role">Faculty Member</span>
                    </div>
                    <div style="width:36px;height:36px;background:linear-gradient(135deg,#1e2f7a,#0d1b44);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#ccff00;font-size:0.95rem;">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                </div>
            </a>
        </header>

        <div class="admin-content-grid">

            {{-- ── Management header ── --}}
            <div class="mgmt-header">
                <p class="mgmt-desc">Manage student accounts and monitor their academic progress.</p>
                <button class="btn-add-student" id="openModalBtn">
                    <i class="fas fa-plus"></i> Add Student
                </button>
            </div>

            {{-- ── Page Layout: Filter Panel + Table ── --}}
            <div id="sl-page-layout">

                {{-- Filter Panel --}}
                <aside id="sl-filter-panel">
                    <div class="fp-header">
                        <p class="fp-title"><i class="fas fa-sliders"></i> Sort By</p>
                        <button class="fp-close" id="filter-panel-close" aria-label="Close filters">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    {{-- Grade Filter --}}
                    <div class="fp-group">
                        <p class="fp-label"><i class="fas fa-layer-group"></i> Grade Level</p>
                        <button class="filter-chip active" id="chip-grade-all" onclick="setGradeFilter(null)">
                            <span class="chip-dot dot-all"></span> All Grades
                        </button>
                        <button class="filter-chip" id="chip-grade-7"  onclick="setGradeFilter(7)">Grade 7</button>
                        <button class="filter-chip" id="chip-grade-8"  onclick="setGradeFilter(8)">Grade 8</button>
                        <button class="filter-chip" id="chip-grade-9"  onclick="setGradeFilter(9)">Grade 9</button>
                        <button class="filter-chip" id="chip-grade-10" onclick="setGradeFilter(10)">Grade 10</button>
                        <button class="filter-chip" id="chip-grade-11" onclick="setGradeFilter(11)">Grade 11</button>
                        <button class="filter-chip" id="chip-grade-12" onclick="setGradeFilter(12)">Grade 12</button>
                    </div>

                    <hr class="fp-divider">

                    {{-- Status Filter --}}
                    <div class="fp-group">
                        <p class="fp-label"><i class="fas fa-circle-dot"></i> Status</p>
                        <button class="filter-chip active" id="chip-status-all"      onclick="setStatusFilter(null)">
                            <span class="chip-dot dot-all"></span> All Status
                        </button>
                        <button class="filter-chip" id="chip-status-active"   onclick="setStatusFilter('active')">
                            <span class="chip-dot dot-active"></span> Active
                        </button>
                        <button class="filter-chip" id="chip-status-inactive" onclick="setStatusFilter('inactive')">
                            <span class="chip-dot dot-inactive"></span> Inactive
                        </button>
                        <button class="filter-chip" id="chip-status-dropped"  onclick="setStatusFilter('dropped')">
                            <span class="chip-dot dot-dropped"></span> Dropped
                        </button>
                    </div>
                </aside>

                {{-- Main table area --}}
                <div id="sl-main-area">

                    {{-- Mobile filter toggle --}}
                    <div class="mobile-filter-row">
                        <button class="mobile-filter-btn" id="filter-toggle-btn">
                            <i class="fas fa-sliders"></i> Sort By
                            <span class="filter-badge" id="filter-active-badge" style="display:none;">1</span>
                        </button>
                    </div>

                    {{-- Search --}}
                    <div class="search-bar">
                        <i class="fas fa-search"></i>
                        <input type="text" id="tableSearch"
                               placeholder="Search by ID, name, email, or grade..."
                               oninput="renderTable()">
                    </div>

                    {{-- Table --}}
                    <div class="table-card">
                        <table class="data-table" id="studentTable">
                            <thead>
                                <tr>
                                    <th>ID Number</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Grade &amp; Section</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="studentTbody"></tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="pagination-bar" id="paginationFooter" style="display:none;">
                        <button class="page-nav-btn" id="prevBtn" onclick="changePage(-1)">&#8592; Previous</button>
                        <span class="page-lbl" id="pageLabel">Page 1 of 1</span>
                        <button class="page-nav-btn" id="nextBtn" onclick="changePage(1)">Next &#8594;</button>
                    </div>
                </div>

            </div>{{-- end sl-page-layout --}}
        </div>{{-- end admin-content-grid --}}
    </main>
</div>

{{-- ── Add / Edit Student Modal ── --}}
<div class="modal-overlay" id="addStudentModal">
    <div class="modal-card">
        <div class="modal-header">
            <h3 id="modalTitle"><i class="fas fa-user-plus"></i> Add New Student</h3>
            <button class="close-x" id="closeModalX">&times;</button>
        </div>
        <form id="studentForm">
            <div class="input-group">
                <label>ID Number</label>
                <input type="text" id="formId" placeholder="e.g., 2024-XXXX" required>
            </div>
            <div class="input-group">
                <label>Student Full Name</label>
                <input type="text" id="formName" placeholder="Enter name..." required>
            </div>
            <div class="input-group">
                <label>Institutional Email</label>
                <input type="email" id="formEmail" placeholder="name@dwcu.edu.ph" required>
            </div>
            <div class="input-row">
                <div class="input-group">
                    <label>Grade Level</label>
                    <select id="formGradeLevel" onchange="updateStrandField()">
                        <optgroup label="Junior High School">
                            <option value="7">Grade 7</option>
                            <option value="8">Grade 8</option>
                            <option value="9">Grade 9</option>
                            <option value="10">Grade 10</option>
                        </optgroup>
                        <optgroup label="Senior High School">
                            <option value="11">Grade 11</option>
                            <option value="12">Grade 12</option>
                        </optgroup>
                    </select>
                </div>
                <div class="input-group" id="strandFieldGroup" style="display:none;">
                    <label>Strand</label>
                    <select id="formStrand">
                        <option value="STEM">STEM</option>
                        <option value="ICT">ICT</option>
                        <option value="HUMSS">HUMSS</option>
                    </select>
                    <div class="strand-hints">
                        <span class="strand-hint sh-stem" onclick="document.getElementById('formStrand').value='STEM'">STEM</span>
                        <span class="strand-hint sh-ict"  onclick="document.getElementById('formStrand').value='ICT'">ICT</span>
                        <span class="strand-hint sh-hum"  onclick="document.getElementById('formStrand').value='HUMSS'">HUMSS</span>
                    </div>
                </div>
                <div class="input-group">
                    <label>Account Status</label>
                    <select id="formStatus">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" id="cancelModalBtn">Cancel</button>
                <button type="submit" class="btn-primary" id="submitBtn">Confirm Add</button>
            </div>
        </form>
    </div>
</div>

{{-- Filter panel overlay (mobile) --}}
<div id="sl-filter-overlay"></div>

{{-- Toast notification --}}
<div class="toast" id="toastNotif">
    <i class="fas fa-check-circle"></i>
    <span id="toastMsg">Done!</span>
</div>

{{-- ── Mobile nav overlay + drawer ── --}}
<div class="mobile-nav-overlay" id="mobile-nav-overlay"></div>
<div class="mobile-nav-drawer" id="mobile-nav-drawer">
    <button class="mobile-nav-close" id="mobile-nav-close" aria-label="Close menu">
        <i class="fas fa-times"></i>
    </button>
    <div class="mobile-brand">
        <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo"
             style="width:70px;margin:0 auto 10px;display:block;">
        <p>DIVINE WORD COLLEGE<br>OF URDANETA</p>
        <span>Faculty Portal</span>
    </div>
    <a href="{{ route('faculty.students') }}"      class="nav-item active-drawer"><i class="fas fa-users"></i> Student List</a>
    <a href="{{ route('faculty.calendar') }}"      class="nav-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
    <a href="{{ route('faculty.gradebook') }}"     class="nav-item"><i class="fas fa-book-open"></i> Gradebook</a>
    <a href="{{ route('faculty.announcements') }}" class="nav-item"><i class="fas fa-bullhorn"></i> Announcement</a>
    <a href="{{ route('faculty.logs') }}"          class="nav-item"><i class="fas fa-history"></i> Activity Logs</a>
    <div class="mobile-logout">
        <form method="POST" action="{{ route('faculty.logout') }}">
            @csrf
            <button type="submit"
                    style="background:none;border:none;cursor:pointer;color:#fca5a5;font-weight:600;padding:10px;width:100%;border-radius:8px;font-family:'Afacad',sans-serif;">
                <i class="fas fa-sign-out-alt"></i> Log out
            </button>
        </form>
    </div>
</div>

<script>
// ── Student data ────────────────────────────────────────────────
const STUDENTS = [
    { id: '2024-0001', name: 'Jorez Romo',       email: 'romo.j@dwcu.edu.ph',    section: 'Grade 12 - ICT',        grade: 12, status: 'active'  },
    { id: '2024-0015', name: 'Alexandra Cruz',    email: 'cruz.a@dwcu.edu.ph',    section: 'Grade 7 - Explorers',   grade: 7,  status: 'active'  },
    { id: '2024-0022', name: 'Michael Flores',    email: 'flores.m@dwcu.edu.ph',  section: 'Grade 7 - Explorers',   grade: 7,  status: 'active'  },
    { id: '2024-0045', name: 'Mark Zuckerberg',   email: 'zuck.m@dwcu.edu.ph',    section: 'Grade 8 - Researchers', grade: 8,  status: 'active'  },
    { id: '2024-0052', name: 'Emma Hall',          email: 'hall.e@dwcu.edu.ph',    section: 'Grade 9 - Innovators',  grade: 9,  status: 'active'  },
    { id: '2024-0068', name: 'Steven Santos',      email: 'santos.s@dwcu.edu.ph',  section: 'Grade 10 - Leaders',    grade: 10, status: 'active'  },
    { id: '2024-0074', name: 'Jessica Reyes',      email: 'reyes.j@dwcu.edu.ph',   section: 'Grade 12 - STEM',       grade: 12, status: 'active'  },
    { id: '2024-0080', name: 'Carlos Mendoza',     email: 'mendoza.c@dwcu.edu.ph', section: 'Grade 11 - HUMSS',      grade: 11, status: 'active'  },
    { id: '2024-0091', name: 'Maria Santos',       email: 'santos.m@dwcu.edu.ph',  section: 'Grade 8 - Researchers', grade: 8,  status: 'active'  },
    { id: '2024-0102', name: 'Luis Garcia',        email: 'garcia.l@dwcu.edu.ph',  section: 'Grade 10 - Leaders',    grade: 10, status: 'dropped' },
    { id: '2024-0113', name: 'Anna Lim',           email: 'lim.a@dwcu.edu.ph',     section: 'Grade 9 - Innovators',  grade: 9,  status: 'active'  },
    { id: '2024-0124', name: 'Pedro Cruz',         email: 'cruz.p@dwcu.edu.ph',    section: 'Grade 7 - Explorers',   grade: 7,  status: 'active'  },
];

// ── State ──────────────────────────────────────────────────────
function getRowsPerPage() { return window.innerWidth <= 768 ? 5 : 10; }
let currentPage = 1;
let editingId   = null;
let openDropId  = null;
let filterState = { grade: null, status: null };

const STATUS_CLASSES = { active: 'badge-active', inactive: 'badge-inactive', dropped: 'badge-dropped' };

// ── Filter badge ───────────────────────────────────────────────
function updateFilterBadge() {
    const count = (filterState.grade !== null ? 1 : 0) + (filterState.status !== null ? 1 : 0);
    const badge = document.getElementById('filter-active-badge');
    if (badge) { badge.textContent = count; badge.style.display = count > 0 ? 'inline' : 'none'; }
}

function setGradeFilter(grade) {
    filterState.grade = grade;
    document.querySelectorAll('[id^="chip-grade-"]').forEach(b => b.classList.remove('active'));
    document.getElementById(grade === null ? 'chip-grade-all' : 'chip-grade-' + grade).classList.add('active');
    currentPage = 1; updateFilterBadge(); renderTable();
}

function setStatusFilter(status) {
    filterState.status = status;
    document.querySelectorAll('[id^="chip-status-"]').forEach(b => b.classList.remove('active'));
    document.getElementById(status === null ? 'chip-status-all' : 'chip-status-' + status).classList.add('active');
    currentPage = 1; updateFilterBadge(); renderTable();
}

// ── Filter & render ────────────────────────────────────────────
function getFiltered() {
    const q = document.getElementById('tableSearch').value.toLowerCase();
    return STUDENTS.filter(s =>
        (s.name.toLowerCase().includes(q) || s.id.includes(q) ||
         s.email.toLowerCase().includes(q) || s.section.toLowerCase().includes(q)) &&
        (filterState.grade  === null || s.grade  === filterState.grade) &&
        (filterState.status === null || s.status === filterState.status)
    );
}

function renderTable() {
    closeEditDropdown();
    const data       = getFiltered();
    const totalPages = Math.max(1, Math.ceil(data.length / getRowsPerPage()));
    if (currentPage > totalPages) currentPage = totalPages;

    const slice = data.slice((currentPage - 1) * getRowsPerPage(), currentPage * getRowsPerPage());
    const tbody = document.getElementById('studentTbody');
    tbody.innerHTML = '';

    if (slice.length === 0) {
        tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;padding:40px;color:#8892b0;font-weight:600;font-family:'Afacad',sans-serif;">No students found.</td></tr>`;
    } else {
        slice.forEach(s => {
            const label = s.status.charAt(0).toUpperCase() + s.status.slice(1);
            const badge = STATUS_CLASSES[s.status] || STATUS_CLASSES.active;
            const tr    = document.createElement('tr');
            tr.innerHTML = `
                <td class="td-cell">${s.id}</td>
                <td class="td-cell">${s.name}</td>
                <td class="td-cell"><a href="mailto:${s.email}" class="email-cell">${s.email}</a></td>
                <td class="td-cell">${s.section}</td>
                <td class="td-cell"><span class="${badge}">${label}</span></td>
                <td class="td-cell">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <button onclick="toggleEditDropdown(event,'${s.id}')" class="edit-action btn-edit">
                            <i class="fas fa-pen"></i> Edit <i class="fas fa-chevron-down" style="font-size:0.6rem;margin-left:2px;"></i>
                        </button>
                        <button onclick="deleteStudent('${s.id}')" class="btn-delete">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </td>`;
            tbody.appendChild(tr);
        });
    }

    document.getElementById('pageLabel').textContent = `Page ${currentPage} of ${totalPages}`;
    document.getElementById('prevBtn').disabled = currentPage <= 1;
    document.getElementById('nextBtn').disabled = currentPage >= totalPages;
    document.getElementById('paginationFooter').style.display = data.length > getRowsPerPage() ? 'flex' : 'none';
}

function changePage(dir) {
    const totalPages = Math.max(1, Math.ceil(getFiltered().length / getRowsPerPage()));
    currentPage = Math.max(1, Math.min(totalPages, currentPage + dir));
    renderTable();
}

// ── Edit dropdown ──────────────────────────────────────────────
function toggleEditDropdown(event, sid) {
    event.stopPropagation();
    const existing = document.getElementById('slEditDropdown');
    if (existing && openDropId === sid) { closeEditDropdown(); return; }
    closeEditDropdown();
    openDropId = sid;

    const rect = event.currentTarget.getBoundingClientRect();
    const dd   = document.createElement('div');
    dd.id        = 'slEditDropdown';
    dd.className = 'sl-edit-dropdown';
    dd.style.top  = (rect.bottom + 4) + 'px';
    dd.style.left = rect.left + 'px';
    dd.innerHTML  = `
        <button class="sl-drop-item sl-drop-edit"    onclick="openEditModal('${sid}')"><i class="fas fa-pen"></i> Edit Details</button>
        <button class="sl-drop-item sl-drop-dropped" onclick="markAsDropped('${sid}')"><i class="fas fa-user-slash"></i> Mark as Dropped</button>`;
    document.body.appendChild(dd);
}

function closeEditDropdown() {
    const dd = document.getElementById('slEditDropdown');
    if (dd) dd.remove();
    openDropId = null;
}

function markAsDropped(sid) {
    const s = STUDENTS.find(s => s.id === sid);
    if (s) s.status = 'dropped';
    closeEditDropdown(); renderTable(); showToast('Student marked as dropped.');
}

function deleteStudent(sid) {
    if (!confirm('Are you sure you want to remove this student?')) return;
    const idx = STUDENTS.findIndex(s => s.id === sid);
    if (idx !== -1) { STUDENTS.splice(idx, 1); renderTable(); showToast('Student removed.'); }
}

// ── Modal ──────────────────────────────────────────────────────
function openEditModal(sid) {
    closeEditDropdown();
    const s = STUDENTS.find(s => s.id === sid);
    if (!s) return;
    editingId = sid;
    document.getElementById('modalTitle').innerHTML = `<i class="fas fa-pen"></i> Edit Student Details`;
    document.getElementById('submitBtn').innerText  = 'Save Changes';
    document.getElementById('formId').value    = s.id;
    document.getElementById('formId').readOnly = true;
    document.getElementById('formName').value  = s.name;
    document.getElementById('formEmail').value = s.email;
    document.getElementById('formStatus').value = s.status === 'dropped' ? 'active' : s.status;
    const m = s.section.match(/Grade\s+(\d+)\s*-\s*(.+)/i);
    const gradeNum = m ? m[1] : '7';
    document.getElementById('formGradeLevel').value = gradeNum;
    updateStrandField();
    if (parseInt(gradeNum) >= 11 && m) document.getElementById('formStrand').value = m[2].trim();
    showModal();
}

function showModal() {
    const modal = document.getElementById('addStudentModal');
    modal.style.display = 'flex';
    setTimeout(() => modal.classList.add('show'), 10);
}

function closeModal() {
    const modal = document.getElementById('addStudentModal');
    modal.classList.remove('show');
    setTimeout(() => {
        modal.style.display = 'none';
        document.getElementById('studentForm').reset();
        document.getElementById('formId').readOnly = false;
        document.getElementById('modalTitle').innerHTML = `<i class="fas fa-user-plus"></i> Add New Student`;
        document.getElementById('submitBtn').innerText  = 'Confirm Add';
        editingId = null;
    }, 300);
}

const JHS_SECTIONS = { 7: 'Explorers', 8: 'Researchers', 9: 'Innovators', 10: 'Leaders' };
function buildSection() {
    const grade = parseInt(document.getElementById('formGradeLevel').value);
    if (grade <= 10) return `Grade ${grade} - ${JHS_SECTIONS[grade]}`;
    return `Grade ${grade} - ${document.getElementById('formStrand').value}`;
}

function updateStrandField() {
    const grade = parseInt(document.getElementById('formGradeLevel').value);
    document.getElementById('strandFieldGroup').style.display = grade >= 11 ? '' : 'none';
}

// ── Toast ──────────────────────────────────────────────────────
function showToast(msg) {
    const toast = document.getElementById('toastNotif');
    document.getElementById('toastMsg').textContent = msg;
    toast.classList.add('active');
    setTimeout(() => toast.classList.remove('active'), 3000);
}

// ── Init ───────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {

    // Mobile nav drawer
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const overlay      = document.getElementById('mobile-nav-overlay');
    const drawer       = document.getElementById('mobile-nav-drawer');
    const mobileClose  = document.getElementById('mobile-nav-close');
    const openDrawer   = () => { drawer.classList.add('open'); overlay.classList.add('open'); };
    const closeDrawer  = () => { drawer.classList.remove('open'); overlay.classList.remove('open'); };
    if (hamburgerBtn) hamburgerBtn.addEventListener('click', openDrawer);
    if (mobileClose)  mobileClose.addEventListener('click', closeDrawer);
    if (overlay)      overlay.addEventListener('click', closeDrawer);

    // Mobile filter bottom sheet
    const filterToggleBtn = document.getElementById('filter-toggle-btn');
    const filterPanel     = document.getElementById('sl-filter-panel');
    const filterOverlay   = document.getElementById('sl-filter-overlay');
    const filterCloseBtn  = document.getElementById('filter-panel-close');
    const openFilter  = () => { filterPanel.classList.add('open'); filterOverlay.style.display = 'block'; };
    const closeFilter = () => { filterPanel.classList.remove('open'); filterOverlay.style.display = 'none'; };
    if (filterToggleBtn) filterToggleBtn.addEventListener('click', openFilter);
    if (filterCloseBtn)  filterCloseBtn.addEventListener('click', closeFilter);
    if (filterOverlay)   filterOverlay.addEventListener('click', closeFilter);

    renderTable();
    window.addEventListener('resize', () => { currentPage = 1; renderTable(); });

    // Open Add modal
    document.getElementById('openModalBtn').onclick = () => {
        editingId = null;
        document.getElementById('studentForm').reset();
        document.getElementById('formId').readOnly = false;
        document.getElementById('modalTitle').innerHTML = `<i class="fas fa-user-plus"></i> Add New Student`;
        document.getElementById('submitBtn').innerText  = 'Confirm Add';
        updateStrandField();
        showModal();
    };

    document.getElementById('closeModalX').onclick    = closeModal;
    document.getElementById('cancelModalBtn').onclick = closeModal;
    document.getElementById('addStudentModal').addEventListener('click', e => {
        if (e.target === document.getElementById('addStudentModal')) closeModal();
    });

    document.addEventListener('click', e => {
        if (!e.target.closest('.edit-action') && !e.target.closest('#slEditDropdown')) closeEditDropdown();
    });
    window.addEventListener('scroll', closeEditDropdown, true);

    document.getElementById('studentForm').onsubmit = e => {
        e.preventDefault();
        const id      = document.getElementById('formId').value.trim();
        const name    = document.getElementById('formName').value.trim();
        const email   = document.getElementById('formEmail').value.trim();
        const section = buildSection();
        const status  = document.getElementById('formStatus').value;
        const m       = section.match(/Grade\s+(\d+)/i);
        const grade   = m ? parseInt(m[1]) : 0;

        if (editingId) {
            const s = STUDENTS.find(s => s.id === editingId);
            if (s) { s.name = name; s.email = email; s.section = section; s.grade = grade; s.status = status; }
            showToast('Student updated successfully.');
        } else {
            if (STUDENTS.find(s => s.id === id)) { alert('A student with this ID already exists.'); return; }
            STUDENTS.push({ id, name, email, section, grade, status });
            showToast('Student added successfully.');
        }
        closeModal(); renderTable();
    };
});
</script>

</body>
</html>
