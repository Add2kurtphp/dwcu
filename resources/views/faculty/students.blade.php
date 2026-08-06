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
        .badge-dropped  { display:inline-block; padding:3px 12px; border-radius:20px; font-weight:700; font-size:0.78rem; background:#fde8ec; color:#c0152f; }

        .action-trigger-btn {
            background:#eef1fb; color:#1e2f7a; border:none; cursor:pointer;
            font-weight:600; font-size:0.78rem; padding:7px 13px; border-radius:7px;
            display:inline-flex; align-items:center; gap:6px;
            font-family:'Afacad', sans-serif; transition:background 0.2s;
        }
        .action-trigger-btn:hover { background:#dde3f5; }

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

        /* ── Report dropdown (JS-generated) ── */
        .sl-report-dropdown {
            position: fixed; background: white;
            border: 1.5px solid #e2e8f0; border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12); z-index: 9999;
            min-width: 190px; padding: 6px;
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
        .sl-drop-item i { width: 16px; text-align: center; font-size: 0.8rem; }
        .sl-drop-item:hover { background: #eef1fb; color: #1e2f7a; }

        /* ── Mobile responsive ── */
        @media (max-width: 768px) {
            .mgmt-header { flex-direction: column; align-items: flex-start; }
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
                <p class="mgmt-desc">View enrolled students and generate their SF9 / SF10 report forms.</p>
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
                        <button class="filter-chip active" id="chip-status-all"     onclick="setStatusFilter(null)">
                            <span class="chip-dot dot-all"></span> All Status
                        </button>
                        <button class="filter-chip" id="chip-status-active"  onclick="setStatusFilter('active')">
                            <span class="chip-dot dot-active"></span> Active
                        </button>
                        <button class="filter-chip" id="chip-status-dropped" onclick="setStatusFilter('dropped')">
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

{{-- Filter panel overlay (mobile) --}}
<div id="sl-filter-overlay"></div>

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

@php
    $studentsJson = $students->map(function ($s) {
        $grade = (int) preg_replace('/[^0-9]/', '', $s->grade_level ?? '0');
        return [
            'id'        => $s->id,
            'studentId' => $s->student_id,
            'name'      => $s->name,
            'email'     => $s->email ?? '',
            'grade'     => $grade,
            'section'   => $s->section ?? '',
            'status'    => $s->status ?? 'active',
        ];
    })->values();
@endphp
<script type="application/json" id="students-data">{!! json_encode($studentsJson) !!}</script>
<script>
window.reportRoutes = {
    base: "{{ url('faculty/students') }}",
};

const STUDENTS = JSON.parse(document.getElementById('students-data').textContent);

// ── State ──────────────────────────────────────────────────────
function getRowsPerPage() { return window.innerWidth <= 768 ? 5 : 10; }
let currentPage   = 1;
let openDropId    = null;
let filterState   = { grade: null, status: null };

const STATUS_CLASSES = { active: 'badge-active', dropped: 'badge-dropped' };

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
        (s.studentId.toLowerCase().includes(q) || s.name.toLowerCase().includes(q) ||
         s.email.toLowerCase().includes(q) || s.section.toLowerCase().includes(q)) &&
        (filterState.grade  === null || s.grade  === filterState.grade) &&
        (filterState.status === null || s.status === filterState.status)
    );
}

function renderTable() {
    closeReportDropdown();
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
                <td class="td-cell">${s.studentId}</td>
                <td class="td-cell">${s.name}</td>
                <td class="td-cell"><a href="mailto:${s.email}" class="email-cell">${s.email}</a></td>
                <td class="td-cell">Grade ${s.grade}${s.section ? ' – ' + s.section : ''}</td>
                <td class="td-cell"><span class="${badge}">${label}</span></td>
                <td class="td-cell">
                    <button class="action-trigger-btn" onclick="toggleReportDropdown(event,${s.id})">
                        <i class="fas fa-file-export"></i> Reports <i class="fas fa-chevron-down" style="font-size:0.6rem;"></i>
                    </button>
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

// ── Report dropdown ─────────────────────────────────────────────
function toggleReportDropdown(event, sid) {
    event.stopPropagation();
    if (openDropId === sid) { closeReportDropdown(); return; }
    closeReportDropdown();
    openDropId = sid;

    const rect = event.currentTarget.getBoundingClientRect();
    const dd   = document.createElement('div');
    dd.id        = 'slReportDropdown';
    dd.className = 'sl-report-dropdown';
    dd.style.top  = (rect.bottom + 4) + 'px';
    dd.style.left = rect.left + 'px';
    dd.innerHTML  = `
        <button class="sl-drop-item" onclick="generateReport(${sid},'sf9')"><i class="fas fa-file-lines"></i> Generate SF9</button>
        <button class="sl-drop-item" onclick="generateReport(${sid},'sf10')"><i class="fas fa-file-contract"></i> Generate SF10</button>`;
    document.body.appendChild(dd);
}

function closeReportDropdown() {
    const dd = document.getElementById('slReportDropdown');
    if (dd) dd.remove();
    openDropId = null;
}

function generateReport(sid, type) {
    closeReportDropdown();
    window.open(window.reportRoutes.base + '/' + sid + '/' + type, '_blank');
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

    document.addEventListener('click', e => {
        if (!e.target.closest('.action-trigger-btn') && !e.target.closest('#slReportDropdown')) closeReportDropdown();
    });
    window.addEventListener('scroll', closeReportDropdown, true);
});
</script>

</body>
</html>
