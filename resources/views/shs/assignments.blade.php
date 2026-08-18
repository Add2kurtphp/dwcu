<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Assignments | DWCU SHS Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            transition:background 0.25s,color 0.25s; text-decoration:none;
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
        .hamburger-btn { display:none; background:none; border:none; color:var(--primary-blue); font-size:1.6rem; cursor:pointer; padding:4px 8px; line-height:1; }

        .scroll-container { flex:1; overflow-y:auto; padding:28px 40px; }
        .scroll-container::-webkit-scrollbar { width:5px; }
        .scroll-container::-webkit-scrollbar-track { background:#f1f5f9; }
        .scroll-container::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:10px; }

        /* ── Summary Bar ── */
        .assign-summary-bar {
            display:flex; justify-content:space-between; align-items:center;
            background:white; border-radius:14px; padding:14px 22px;
            margin-bottom:22px; border:1px solid #e2e8f0;
            box-shadow:0 2px 8px rgba(0,0,0,0.04); flex-wrap:wrap; gap:12px;
        }
        .assign-summary-left {
            display:flex; align-items:center; gap:10px;
            font-size:0.9rem; color:#475569;
        }
        .assign-summary-left i { color:#1e2f7a; font-size:1rem; }
        .assign-summary-right { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }

        /* ── Tags & Badges ── */
        .assign-tag, .assign-subject-tag {
            display:inline-flex; align-items:center; gap:5px;
            padding:4px 12px; border-radius:50px;
            font-size:0.72rem; font-weight:700;
            text-transform:uppercase; letter-spacing:0.04em;
        }
        .tag-urgent  { background:#fee2e2; color:#dc2626; }
        .tag-pending { background:#fef9c3; color:#b45309; }
        .tag-research { background:rgba(255,255,255,0.18); color:white; border:1px solid rgba(255,255,255,0.3); }
        .tag-physics  { background:#dbeafe; color:#1d4ed8; }
        .tag-calculus { background:#f5f3ff; color:#7c3aed; }
        .tag-biology  { background:#dcfce7; color:#15803d; }

        .due-badge {
            display:inline-flex; align-items:center; gap:5px;
            padding:4px 12px; border-radius:50px;
            font-size:0.75rem; font-weight:700;
        }
        .due-urgent { background:#fee2e2; color:#dc2626; }
        .due-normal { background:#fef9c3; color:#b45309; }

        /* ── Featured Card ── */
        .assign-featured-card {
            background:linear-gradient(135deg,#1e2f7a 0%,#283593 60%,#3949ab 100%);
            border-radius:22px; padding:32px 32px 26px; color:white;
            margin-bottom:22px; position:relative; overflow:hidden;
            box-shadow:0 12px 32px rgba(30,47,122,0.28);
            transition:transform 0.25s,box-shadow 0.25s;
        }
        .assign-featured-card:hover { transform:translateY(-3px); box-shadow:0 18px 40px rgba(30,47,122,0.35); }
        .assign-feat-decoration {
            position:absolute; width:300px; height:300px; border-radius:50%;
            background:rgba(255,255,255,0.04); top:-80px; right:-60px; pointer-events:none;
        }
        .assign-feat-decoration::after {
            content:''; position:absolute; width:180px; height:180px; border-radius:50%;
            background:rgba(251,191,36,0.07); bottom:-50px; right:-30px;
        }
        .assign-feat-header {
            display:flex; gap:20px; align-items:flex-start;
            margin-bottom:24px; position:relative;
        }
        .assign-feat-icon {
            width:52px; height:52px; background:rgba(255,255,255,0.15);
            border:1px solid rgba(255,255,255,0.2); border-radius:15px;
            display:flex; align-items:center; justify-content:center;
            font-size:1.3rem; flex-shrink:0; margin-top:4px;
        }
        .assign-feat-meta h2 { font-size:1.5rem; font-weight:700; margin:8px 0 10px; line-height:1.25; }
        .assign-feat-meta p { font-size:0.9rem; opacity:0.85; line-height:1.6; max-width:580px; margin-bottom:14px; }
        .assign-feat-attach {
            display:inline-flex; align-items:center; gap:7px;
            background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.18);
            border-radius:8px; padding:6px 14px; font-size:0.8rem; color:rgba(255,255,255,0.85);
        }
        .assign-feat-footer {
            display:flex; align-items:center; justify-content:space-between;
            flex-wrap:wrap; gap:12px; padding-top:20px;
            border-top:1px solid rgba(255,255,255,0.12); position:relative;
        }
        .submit-btn {
            display:inline-flex; align-items:center; gap:8px;
            background:#fbbf24; color:#1e2f7a; border:none;
            padding:11px 24px; border-radius:10px; font-weight:700;
            font-size:0.9rem; cursor:pointer; transition:all 0.25s;
            box-shadow:0 4px 14px rgba(251,191,36,0.35);
        }
        .submit-btn:hover { background:#f59e0b; transform:translateY(-2px); box-shadow:0 8px 20px rgba(251,191,36,0.45); }

        /* ── Small Cards ── */
        .assign-cards-grid {
            display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:20px;
        }
        .assign-small-card {
            background:white; border-radius:18px; padding:22px;
            border:1px solid #f1f5f9; border-top:4px solid transparent;
            box-shadow:0 4px 16px rgba(0,0,0,0.05);
            display:flex; flex-direction:column; gap:10px;
            transition:transform 0.25s,box-shadow 0.25s;
        }
        .assign-small-card:hover { transform:translateY(-3px); box-shadow:0 10px 28px rgba(0,0,0,0.08); }
        .accent-blue   { border-top-color:#3b82f6; }
        .accent-purple { border-top-color:#a855f7; }
        .accent-green  { border-top-color:#22c55e; }
        .assign-card-top { display:flex; justify-content:space-between; align-items:center; }
        .assign-small-card h3 { font-size:1.05rem; font-weight:700; color:#1e2f7a; line-height:1.3; }
        .assign-small-card p { font-size:0.87rem; color:#64748b; line-height:1.6; flex:1; }
        .assign-card-footer { padding-top:14px; border-top:1px solid #f1f5f9; margin-top:auto; }
        .submit-btn-sm {
            display:inline-flex; align-items:center; gap:7px;
            background:#1e2f7a; color:white; border:none;
            padding:9px 18px; border-radius:9px; font-weight:700;
            font-size:0.82rem; cursor:pointer; transition:all 0.25s;
            width:100%; justify-content:center;
        }
        .submit-btn-sm:hover {
            background:#fbbf24; color:#1e2f7a;
            box-shadow:0 6px 16px rgba(251,191,36,0.35); transform:translateY(-2px);
        }

        /* ── Submission Modal ── */
        .shs-assign-modal-overlay {
            position:fixed; inset:0; background:rgba(15,23,42,0.65);
            display:none; align-items:center; justify-content:center;
            z-index:9999; backdrop-filter:blur(4px); padding:20px;
        }
        .shs-assign-modal-overlay.active { display:flex; }
        body.shs-assign-open { overflow:hidden; }
        .shs-assign-modal-content {
            background:white; width:100%; max-width:520px; border-radius:20px;
            box-shadow:0 24px 48px rgba(0,0,0,0.18); overflow:hidden;
            animation:shsModalPop 0.25s ease-out;
        }
        @keyframes shsModalPop {
            from { opacity:0; transform:scale(0.95) translateY(-12px); }
            to   { opacity:1; transform:scale(1) translateY(0); }
        }
        .shs-modal-header {
            background:linear-gradient(135deg,#1e2f7a,#283593);
            padding:22px 24px; display:flex; align-items:center;
            gap:16px; color:white;
        }
        .shs-modal-header-icon {
            width:46px; height:46px; background:rgba(255,255,255,0.15);
            border:1px solid rgba(255,255,255,0.2); border-radius:13px;
            display:flex; align-items:center; justify-content:center;
            font-size:1.1rem; flex-shrink:0;
        }
        .shs-modal-header h2 { font-size:1.1rem; font-weight:700; color:white; }
        .shs-modal-header p { font-size:0.78rem; color:rgba(255,255,255,0.65); margin-top:2px; }
        .shs-assign-close-btn {
            background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.18);
            color:rgba(255,255,255,0.8); width:34px; height:34px;
            border-radius:9px; cursor:pointer; font-size:0.9rem;
            display:flex; align-items:center; justify-content:center;
            margin-left:auto; transition:all 0.2s; flex-shrink:0;
        }
        .shs-assign-close-btn:hover { background:rgba(255,255,255,0.22); color:white; }
        .shs-modal-body {
            padding:22px 24px 24px; overflow-y:auto; max-height:70vh; scrollbar-width:none;
        }
        .shs-modal-body::-webkit-scrollbar { display:none; }
        .shs-assign-guidelines {
            display:flex; align-items:flex-start; gap:10px;
            background:#eff6ff; border-left:4px solid #1e2f7a;
            padding:12px 16px; border-radius:0 8px 8px 0;
            font-size:0.83rem; color:#334155; margin-bottom:18px;
        }
        .shs-assign-guidelines i { color:#1e2f7a; margin-top:2px; flex-shrink:0; }
        .input-row { margin-bottom:16px; }
        .input-row label { display:block; font-size:0.83rem; font-weight:700; color:#334155; margin-bottom:6px; }
        .clean-select {
            width:100%; padding:11px 14px; border-radius:10px;
            border:1.5px solid #e2e8f0; font-family:'Afacad',sans-serif;
            font-size:0.92rem; color:#1e293b; background:white;
            outline:none; transition:border-color 0.2s, box-shadow 0.2s;
        }
        .clean-select:focus { border-color:#1e2f7a; box-shadow: 0 0 0 3px rgba(30,47,122,0.1); }

        /* ── Custom subject dropdown ── */
        .custom-subject-dropdown { position: relative; width: 100%; font-family: 'Afacad', sans-serif; }
        .custom-subject-trigger {
            width: 100%; display: flex; align-items: center; justify-content: space-between;
            background: #fafbff; border: 1.5px solid #e2e8f0; border-radius: 10px;
            padding: 11px 14px; cursor: pointer; font-family: 'Afacad', sans-serif;
            font-size: 0.92rem; color: #1e293b; transition: border-color 0.2s, box-shadow 0.2s;
        }
        .custom-subject-trigger:hover { border-color: #94a3b8; }
        .custom-subject-dropdown.open .custom-subject-trigger { border-color: #1e2f7a; box-shadow: 0 0 0 3px rgba(30,47,122,0.1); }
        .subject-chevron { color: #1e2f7a; font-size: 0.72rem; transition: transform 0.2s; }
        .custom-subject-dropdown.open .subject-chevron { transform: rotate(180deg); }
        .custom-subject-menu {
            display: none; position: absolute; top: calc(100% + 6px); left: 0; right: 0;
            background: white; border: 1.5px solid #e2e8f0; border-radius: 12px;
            box-shadow: 0 8px 24px rgba(30,47,122,0.15); z-index: 50;
            list-style: none; margin: 0; padding: 6px; max-height: 220px; overflow-y: auto;
        }
        .custom-subject-dropdown.open .custom-subject-menu { display: block; }
        .custom-subject-option { padding: 9px 12px; border-radius: 8px; font-size: 0.9rem; color: #1e293b; cursor: pointer; transition: background 0.15s; }
        .custom-subject-option:hover { background: #f1f3fb; }
        .custom-subject-option.selected { background: #eef1fb; color: #1e2f7a; font-weight: 700; }
        .clean-drop-zone {
            border:2px dashed #cbd5e1; border-radius:14px; padding:36px 20px;
            text-align:center; margin-bottom:16px; cursor:pointer;
            transition:all 0.25s; color:#64748b; background:#fafafa;
        }
        .clean-drop-zone:hover { border-color:#1e2f7a; background:#f8faff; }
        .clean-drop-zone i { font-size:2.2rem; color:#1e2f7a; display:block; margin-bottom:10px; }
        .clean-drop-zone p { font-size:0.9rem; font-weight:600; margin-bottom:4px; }
        .clean-drop-zone small { font-size:0.75rem; color:#94a3b8; }
        .submission-textarea { resize:vertical; min-height:80px; font-family:'Afacad',sans-serif; }
        .shs-modal-footer {
            display:flex; justify-content:flex-end; align-items:center; gap:12px; margin-top:20px;
        }
        .shs-assign-cancel-btn {
            display:inline-flex; align-items:center; gap:7px;
            background:#f1f5f9; color:#475569; border:1.5px solid #e2e8f0;
            padding:11px 20px; border-radius:10px; font-weight:700;
            font-size:0.9rem; cursor:pointer; transition:background 0.2s;
            font-family:'Afacad',sans-serif;
        }
        .shs-assign-cancel-btn:hover { background:#e2e8f0; }
        .submit-btn-modern {
            display:inline-flex; align-items:center; gap:8px;
            background:linear-gradient(135deg,#1e2f7a,#283593); color:white;
            padding:11px 24px; border-radius:10px; border:none;
            font-weight:700; font-size:0.9rem; cursor:pointer;
            transition:all 0.25s; font-family:'Afacad',sans-serif;
        }
        .submit-btn-modern:hover {
            background:linear-gradient(135deg,#162155,#1e2f7a);
            transform:translateY(-2px); box-shadow:0 6px 16px rgba(30,47,122,0.3);
        }

        /* ── Mobile Nav ── */
        .mobile-nav-overlay {
            display:none; position:fixed; inset:0;
            background:rgba(0,0,0,0.45); z-index:1100;
        }
        .mobile-nav-overlay.open { display:block; }
        .mobile-nav-drawer {
            position:fixed; top:0; left:0; height:100vh; width:270px;
            background:linear-gradient(180deg,#162152 0%,#0d1535 100%);
            color:white; z-index:1200; transform:translateX(-100%);
            transition:transform 0.3s ease; padding:22px 20px; display:flex;
            flex-direction:column; gap:4px; overflow-y:auto;
        }
        .mobile-nav-drawer.open { transform:translateX(0); }
        .mobile-nav-close {
            background:none; border:none; color:#94a3b8; font-size:1.3rem;
            cursor:pointer; align-self:flex-end; margin-bottom:10px;
        }
        .mobile-brand { text-align:center; padding-bottom:16px; margin-bottom:8px; border-bottom:1px solid rgba(255,255,255,0.08); }
        .mobile-brand img { width:60px; margin:0 auto 8px; display:block; }
        .mobile-brand p { font-size:0.78rem; font-weight:700; line-height:1.4; }
        .mobile-brand span {
            display:inline-block; margin-top:8px;
            background:rgba(251,191,36,0.15); border:1px solid rgba(251,191,36,0.35);
            color:#fbbf24; border-radius:50px; padding:2px 12px;
            font-size:0.68rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase;
        }
        .mobile-logout { margin-top:auto; padding-top:16px; border-top:1px solid rgba(255,255,255,0.08); }
        .mobile-logout a {
            display:flex; align-items:center; gap:10px;
            color:#fca5a5; text-decoration:none; font-weight:600; font-size:0.95rem;
            padding:10px 16px; border-radius:10px; transition:background 0.2s;
        }
        .mobile-logout a:hover { background:rgba(248,113,113,0.15); color:#fff; }

        /* ── Responsive ── */
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
            .assign-summary-bar { flex-direction:column; align-items:flex-start; }
            .assign-featured-card { padding:22px 18px 20px; border-radius:18px; }
            .assign-feat-header { flex-direction:column; gap:14px; }
            .assign-feat-meta h2 { font-size:1.2rem; }
            .assign-feat-footer { flex-direction:column; align-items:flex-start; }
            .submit-btn { width:100%; justify-content:center; }
            .assign-cards-grid { grid-template-columns:1fr; }
            .shs-assign-modal-content { border-radius:16px; }
            .shs-modal-footer { flex-direction:column-reverse; }
            .shs-assign-cancel-btn, .submit-btn-modern { width:100%; justify-content:center; }
            .clean-drop-zone { padding:24px 14px; }
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
                <a href="{{ route('shs.announcement') }}" class="nav-item">
                    <i class="fas fa-bullhorn"></i> Announcement
                </a>
                <a href="{{ route('shs.assignments') }}" class="nav-item active">
                    <i class="fas fa-tasks"></i> Assignments
                </a>
                <a href="{{ route('shs.quizzes') }}" class="nav-item">
                    <i class="fas fa-edit"></i> Quizzes
                </a>
                <a href="{{ route('shs.gradebook') }}" class="nav-item">
                    <i class="fas fa-chart-line"></i> Gradebook
                </a>
                <a href="{{ route('shs.calendar') }}" class="nav-item">
                    <i class="fas fa-calendar-alt"></i> Calendar
                </a>
                <a href="{{ route('shs.logs') }}" class="nav-item">
                    <i class="fas fa-history"></i> Activity Logs
                </a>
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
                <h1>Assignments</h1>
            </div>
            <a href="{{ route('shs.profile') }}" class="header-user" style="text-decoration:none;">
                <i class="fas fa-user-graduate"></i>
                <span>{{ session('shs_student_name', 'Student') }}</span>
            </a>
        </header>

        @php
            $subjectMeta = [
                'Capstone Research'   => ['tag' => 'tag-research', 'icon' => 'fa-microscope', 'accent' => 'accent-blue'],
                'General Physics 2'   => ['tag' => 'tag-physics',  'icon' => 'fa-atom',        'accent' => 'accent-blue'],
                'Basic Calculus'      => ['tag' => 'tag-calculus', 'icon' => 'fa-square-root-alt', 'accent' => 'accent-purple'],
                'General Biology 2'   => ['tag' => 'tag-biology',  'icon' => 'fa-dna',         'accent' => 'accent-green'],
            ];
            $defaultMeta = ['tag' => 'tag-physics', 'icon' => 'fa-book', 'accent' => 'accent-blue'];
            $pendingCount = $assignments->filter(fn ($a) => !$submissions->has($a->id))->count();
            $urgentCount = $assignments->filter(fn ($a) => !$submissions->has($a->id) && now()->diffInDays($a->due_date, false) <= 3)->count();
            $featured = $assignments->first();
            $rest = $assignments->slice(1);
        @endphp

        <div class="scroll-container">

            <!-- Summary bar -->
            <div class="assign-summary-bar">
                <div class="assign-summary-left">
                    <i class="fas fa-tasks"></i>
                    <span><strong>{{ $assignments->count() }}</strong> active assignment{{ $assignments->count() === 1 ? '' : 's' }}</span>
                </div>
                <div class="assign-summary-right">
                    <span class="assign-tag tag-urgent"><i class="fas fa-fire"></i> {{ $urgentCount }} Due Soon</span>
                    <span class="assign-tag tag-pending">{{ $pendingCount }} Pending</span>
                </div>
            </div>

            @if ($assignments->isEmpty())
                <p style="color:#94a3b8;text-align:center;padding:40px 0;">No assignments posted yet.</p>
            @endif

            @if ($featured)
                @php
                    $meta = $subjectMeta[$featured->subject] ?? $defaultMeta;
                    $submitted = $submissions->has($featured->id);
                    $isUrgent = now()->diffInDays($featured->due_date, false) <= 3;
                @endphp
                <!-- Featured assignment card -->
                <div class="assign-featured-card">
                    <div class="assign-feat-decoration"></div>
                    <div class="assign-feat-header">
                        <div class="assign-feat-icon">
                            <i class="fas {{ $meta['icon'] }}"></i>
                        </div>
                        <div class="assign-feat-meta">
                            <span class="assign-subject-tag {{ $meta['tag'] }}">{{ $featured->subject }}</span>
                            <h2>{{ $featured->title }}</h2>
                            @if ($featured->description)
                                <p>{{ $featured->description }}</p>
                            @endif
                            @if ($featured->attachment_label)
                                <div class="assign-feat-attach">
                                    <i class="fas fa-paperclip"></i>
                                    <span>{{ $featured->attachment_label }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="assign-feat-footer">
                        <span class="due-badge {{ $isUrgent ? 'due-urgent' : 'due-normal' }}"><i class="fas fa-fire"></i> Due: {{ $featured->due_date->format('F d, Y') }}</span>
                        @if ($submitted)
                            <button class="submit-btn" disabled style="opacity:0.75;cursor:default;">
                                <i class="fas fa-check-circle"></i> Submitted
                            </button>
                        @else
                            <button class="submit-btn" onclick="openSubmissionModal({{ $featured->id }}, '{{ addslashes($featured->subject) }}')">
                                <i class="fas fa-upload"></i> Submit Work
                            </button>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Small cards grid -->
            <div class="assign-cards-grid">
                @foreach ($rest as $a)
                    @php
                        $meta = $subjectMeta[$a->subject] ?? $defaultMeta;
                        $submitted = $submissions->has($a->id);
                        $isUrgent = now()->diffInDays($a->due_date, false) <= 3;
                    @endphp
                    <div class="assign-small-card {{ $meta['accent'] }}">
                        <div class="assign-card-top">
                            <span class="assign-subject-tag {{ $meta['tag'] }}">{{ $a->subject }}</span>
                            <span class="due-badge {{ $isUrgent ? 'due-urgent' : 'due-normal' }}"><i class="fas {{ $isUrgent ? 'fa-fire' : 'fa-clock' }}"></i> {{ $a->due_date->format('M d') }}</span>
                        </div>
                        <h3>{{ $a->title }}</h3>
                        @if ($a->description)
                            <p>{{ $a->description }}</p>
                        @endif
                        <div class="assign-card-footer">
                            @if ($submitted)
                                <button class="submit-btn-sm" disabled style="opacity:0.75;cursor:default;background:#16a34a;">
                                    <i class="fas fa-check-circle"></i> Submitted
                                </button>
                            @else
                                <button class="submit-btn-sm" onclick="openSubmissionModal({{ $a->id }}, '{{ addslashes($a->subject) }}')">
                                    <i class="fas fa-upload"></i> Submit Work
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <!-- Submission Modal -->
    <div class="shs-assign-modal-overlay" id="shsAssignModal">
        <div class="shs-assign-modal-content">

            <div class="shs-modal-header">
                <div class="shs-modal-header-icon">
                    <i class="fas fa-file-import"></i>
                </div>
                <div>
                    <h2>Turn In Assignment</h2>
                    <p>Upload your work for submission</p>
                </div>
                <button class="shs-assign-close-btn" onclick="closeSubmissionModal()" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="shs-modal-body">
                <div class="shs-assign-guidelines">
                    <i class="fas fa-info-circle"></i>
                    <span>Accepted: <strong>PDF, DOCX, JPG, PNG</strong> &mdash; Max size: <strong>25MB</strong>. Include your name and subject in the filename.</span>
                </div>

                <div class="input-row">
                    <label>Select Subject</label>
                    <input type="hidden" id="subject-select" value="Capstone Research">
                    <div class="custom-subject-dropdown" id="subjectDropdown">
                        <button type="button" class="custom-subject-trigger" id="subjectTrigger">
                            <span id="subjectLabel">Capstone Research</span>
                            <i class="fas fa-chevron-down subject-chevron"></i>
                        </button>
                        <ul class="custom-subject-menu" id="subjectMenu">
                            <li class="custom-subject-option selected" data-value="Capstone Research">Capstone Research</li>
                            <li class="custom-subject-option" data-value="General Physics 2">General Physics 2</li>
                            <li class="custom-subject-option" data-value="Basic Calculus">Basic Calculus</li>
                            <li class="custom-subject-option" data-value="General Biology 2">General Biology 2</li>
                        </ul>
                    </div>
                </div>

                <div class="clean-drop-zone" id="drop-zone">
                    <input type="file" id="fileInput" hidden>
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p id="file-label">Click to upload or drag file here</p>
                    <small>Max file size: 25MB (PDF, DOCX, JPG)</small>
                </div>

                <div class="input-row">
                    <label>Comments <span style="font-weight:400; color:#94a3b8;">(optional)</span></label>
                    <textarea id="submission-comments" class="clean-select submission-textarea" rows="3" placeholder="Add a note for your teacher..."></textarea>
                </div>

                <div class="shs-modal-footer">
                    <button class="shs-assign-cancel-btn" onclick="closeSubmissionModal()">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button class="submit-btn-modern" id="submitBtn">
                        <i class="fas fa-paper-plane"></i> Submit to Teacher
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Mobile nav overlay + drawer -->
    <div class="mobile-nav-overlay" id="mobile-nav-overlay"></div>
    <div class="mobile-nav-drawer" id="mobile-nav-drawer">
        <button class="mobile-nav-close" id="mobile-nav-close" aria-label="Close menu">
            <i class="fas fa-times"></i>
        </button>
        <div class="mobile-brand">
            <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo" class="school-logo">
            <p>DIVINE WORD COLLEGE<br>OF URDANETA</p>
            <span>Senior High</span>
        </div>
        <a href="{{ route('shs.announcement') }}" class="nav-item">
            <i class="fas fa-bullhorn"></i> Announcement
        </a>
        <a href="{{ route('shs.assignments') }}" class="nav-item active">
            <i class="fas fa-tasks"></i> Assignments
        </a>
        <a href="{{ route('shs.quizzes') }}" class="nav-item">
            <i class="fas fa-edit"></i> Quizzes
        </a>
        <a href="{{ route('shs.gradebook') }}" class="nav-item">
            <i class="fas fa-chart-line"></i> Gradebook
        </a>
        <a href="{{ route('shs.calendar') }}" class="nav-item">
            <i class="fas fa-calendar-alt"></i> Calendar
        </a>
        <a href="{{ route('shs.logs') }}" class="nav-item">
            <i class="fas fa-history"></i> Activity Logs
        </a>
        <div class="mobile-logout">
            <form method="POST" action="{{ route('shs.logout') }}">
                @csrf
                <button type="submit" style="background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:10px;color:#fca5a5;font-weight:600;font-size:0.95rem;padding:10px 16px;border-radius:10px;width:100%;font-family:'Afacad',sans-serif;transition:background 0.2s;">
                    <i class="fas fa-sign-out-alt"></i> Log out
                </button>
            </form>
        </div>
    </div>

    <script>
        window.SUBMIT_URL_TEMPLATE = "{{ route('shs.assignments.submit', ['assignment' => '__ID__']) }}";
        var currentAssignmentId = null;
        function csrfToken() {
            var m = document.querySelector('meta[name="csrf-token"]');
            return m ? m.content : '';
        }

        // Custom subject dropdown
        var subjectDropdown    = document.getElementById('subjectDropdown');
        var subjectTrigger     = document.getElementById('subjectTrigger');
        var subjectMenu        = document.getElementById('subjectMenu');
        var subjectLabel       = document.getElementById('subjectLabel');
        var subjectHiddenInput = document.getElementById('subject-select');

        function setSubject(subject) {
            subjectHiddenInput.value = subject;
            subjectLabel.textContent = subject;
            subjectMenu.querySelectorAll('.custom-subject-option').forEach(function (o) {
                o.classList.toggle('selected', o.dataset.value === subject);
            });
        }

        subjectTrigger.addEventListener('click', function (e) {
            e.stopPropagation();
            subjectDropdown.classList.toggle('open');
        });

        subjectMenu.addEventListener('click', function (e) {
            var opt = e.target.closest('.custom-subject-option');
            if (!opt) return;
            setSubject(opt.dataset.value);
            subjectDropdown.classList.remove('open');
        });

        document.addEventListener('click', function (e) {
            if (!subjectDropdown.contains(e.target)) subjectDropdown.classList.remove('open');
        });

        // Modal open/close
        window.openSubmissionModal = function(assignmentId, subject) {
            currentAssignmentId = assignmentId;
            if (subject) setSubject(subject);
            document.getElementById('shsAssignModal').classList.add('active');
            document.body.classList.add('shs-assign-open');
        };

        window.closeSubmissionModal = function() {
            document.getElementById('shsAssignModal').classList.remove('active');
            document.body.classList.remove('shs-assign-open');
        };

        document.addEventListener('DOMContentLoaded', function() {
            var fileInput    = document.getElementById('fileInput');
            var dropZone     = document.getElementById('drop-zone');
            var fileLabel    = document.getElementById('file-label');
            var submitBtn    = document.getElementById('submitBtn');
            var subjectSelect = document.getElementById('subject-select');
            var modal        = document.getElementById('shsAssignModal');

            // Close on backdrop click
            modal.addEventListener('click', function(e) {
                if (e.target === modal) closeSubmissionModal();
            });

            // File upload
            dropZone.addEventListener('click', function() { fileInput.click(); });

            fileInput.addEventListener('change', function() { handleFiles(this.files); });

            ['dragenter','dragover','dragleave','drop'].forEach(function(evt) {
                dropZone.addEventListener(evt, function(e) { e.preventDefault(); e.stopPropagation(); });
            });
            ['dragenter','dragover'].forEach(function(evt) {
                dropZone.addEventListener(evt, function() {
                    dropZone.style.background = '#f1f5f9';
                    dropZone.style.borderColor = '#1e2f7a';
                });
            });
            ['dragleave','drop'].forEach(function(evt) {
                dropZone.addEventListener(evt, function() {
                    dropZone.style.background = '';
                    dropZone.style.borderColor = '#cbd5e1';
                });
            });
            dropZone.addEventListener('drop', function(e) { handleFiles(e.dataTransfer.files); });

            function handleFiles(files) {
                if (!files.length) return;
                var name = files[0].name;
                var size = (files[0].size / 1024 / 1024).toFixed(2);
                if (size > 25) {
                    alert('File is too large! Maximum limit is 25MB.');
                    fileInput.value = '';
                    return;
                }
                fileLabel.innerHTML = '<i class="fas fa-file-check" style="color:#10b981;"></i> <strong>' + name + '</strong> (' + size + ' MB)';
                dropZone.style.borderColor = '#10b981';
            }

            // Real submission
            submitBtn.addEventListener('click', function() {
                if (!fileInput.files.length) {
                    alert('Please attach a file before submitting.');
                    return;
                }
                if (!currentAssignmentId) return;

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';

                var formData = new FormData();
                formData.append('file', fileInput.files[0]);
                formData.append('comments', document.getElementById('submission-comments').value);

                var url = window.SUBMIT_URL_TEMPLATE.replace('__ID__', currentAssignmentId);

                fetch(url, {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken() },
                    body: formData,
                })
                    .then(function (r) { if (!r.ok) return r.json().then(function (e) { return Promise.reject(e); }); return r.json(); })
                    .then(function () {
                        submitBtn.innerHTML = '<i class="fas fa-check"></i> Submitted!';
                        setTimeout(function () { window.location.reload(); }, 900);
                    })
                    .catch(function (err) {
                        var msg = (err && err.message) ? err.message : 'Error submitting assignment.';
                        alert(msg);
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Submit to Teacher';
                    });
            });

            // Mobile nav
            var hamburger = document.getElementById('hamburger-btn');
            var drawer    = document.getElementById('mobile-nav-drawer');
            var overlay   = document.getElementById('mobile-nav-overlay');
            var closeNav  = document.getElementById('mobile-nav-close');

            function openMenu()  { drawer.classList.add('open'); overlay.classList.add('open'); document.body.style.overflow = 'hidden'; }
            function closeMenu() { drawer.classList.remove('open'); overlay.classList.remove('open'); document.body.style.overflow = ''; }

            if (hamburger) hamburger.addEventListener('click', openMenu);
            if (closeNav)  closeNav.addEventListener('click', closeMenu);
            if (overlay)   overlay.addEventListener('click', closeMenu);
        });
    </script>
</body>
</html>
