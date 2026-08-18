<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Assignments | DWCU Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css'])
    <style>
        :root {
            --primary-blue: #1e2f7a;
            --sidebar-dark: #162152;
            --bg-light: #f0f4f8;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --white: #ffffff;
            --shadow: 0 4px 20px rgba(0,0,0,0.07);
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
            border-radius: 50px; cursor: pointer; transition: all 0.2s ease;
            border: 1px solid transparent; text-decoration: none;
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
        .mobile-logout { margin-top: auto; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.08); }

        /* ── SUMMARY BAR ── */
        .assign-summary-bar {
            display: flex; justify-content: space-between; align-items: center;
            background: white; border-radius: 14px; padding: 14px 22px;
            margin-bottom: 22px; border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .assign-summary-left { display: flex; align-items: center; gap: 10px; font-size: 0.9rem; color: #475569; }
        .assign-summary-left i { color: #1e2f7a; font-size: 1rem; }
        .assign-summary-right { font-size: 0.82rem; color: #ef4444; display: flex; align-items: center; gap: 6px; }

        /* ── CARDS BASE ── */
        .assignment-card {
            background: white; border-radius: 20px; padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;
            display: flex; flex-direction: column;
            transition: box-shadow 0.25s, transform 0.25s;
        }
        .assignment-card:hover { box-shadow: 0 8px 30px rgba(30,47,122,0.1); transform: translateY(-2px); }

        /* ── TAGS ── */
        .assign-tag {
            display: inline-flex; align-items: center; gap: 5px;
            border-radius: 50px; padding: 4px 12px; font-size: 0.72rem;
            font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
        }
        .tag-science { background: #e0f2fe; color: #0369a1; }
        .tag-math    { background: #eff6ff; color: #1d4ed8; }
        .tag-english { background: #f5f3ff; color: #7c3aed; }
        .tag-tle     { background: #fff7ed; color: #c2410c; }

        /* ── DUE DATE ── */
        .assign-due { display: inline-flex; align-items: center; gap: 5px; font-size: 0.8rem; font-weight: 600; }
        .due-urgent { color: #ef4444; }
        .due-normal { color: #f59e0b; }

        /* ── FEATURED CARD ── */
        .assignment-card.featured {
            background: linear-gradient(135deg, #1e2f7a 0%, #283593 100%);
            color: white; border: none; margin-bottom: 22px;
            position: relative; overflow: hidden;
        }
        .assign-feat-decoration {
            position: absolute; width: 260px; height: 260px; border-radius: 50%;
            border: 50px solid rgba(255,255,255,0.04); top: -70px; right: -60px; pointer-events: none;
        }
        .assign-feat-header { display: flex; gap: 18px; align-items: flex-start; margin-bottom: 18px; }
        .assign-feat-icon { width: 54px; height: 54px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
        .science-bg { background: rgba(255,255,255,0.15); color: white; }
        .assign-feat-title .assign-tag { background: rgba(255,255,255,0.15); color: rgba(255,255,255,0.9); margin-bottom: 8px; }
        .assign-feat-title h2 { font-size: 1.4rem; font-weight: 700; color: white; margin-bottom: 8px; line-height: 1.3; }
        .assignment-card.featured .assign-due { color: #fca5a5; }
        .assignment-card.featured .body-text  { color: rgba(255,255,255,0.8); margin-bottom: 20px; }

        /* Attachment link */
        .attachment-link {
            display: flex; align-items: center;
            background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15);
            border-radius: 12px; padding: 12px 16px; text-decoration: none;
            margin-bottom: 18px; transition: background 0.2s; gap: 12px;
        }
        .attachment-link:hover { background: rgba(255,255,255,0.18); }
        .attachment-icon { width: 36px; height: 36px; background: #0f9d58; color: white; display: flex; align-items: center; justify-content: center; border-radius: 8px; font-size: 1rem; flex-shrink: 0; }
        .attachment-text { flex: 1; }
        .attachment-text span  { display: block; font-size: 0.88rem; font-weight: 600; color: white; }
        .attachment-text small { color: rgba(255,255,255,0.55); font-size: 0.75rem; }
        .attach-arrow { color: rgba(255,255,255,0.4); font-size: 0.8rem; margin-left: auto; }

        /* Featured submit button */
        .submit-btn {
            background: white; color: #1e2f7a; border: none;
            padding: 13px 24px; border-radius: 12px; font-weight: 700; font-size: 0.95rem;
            cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.25s; align-self: flex-start; font-family: 'Afacad', sans-serif;
        }
        .submit-btn:hover { background: #adff2f; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,0.2); }

        /* ── SMALL CARDS ── */
        .secondary-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .assignment-card.small { border-top: 4px solid transparent; }
        .assignment-card.small.accent-blue   { border-top-color: #3b82f6; }
        .assignment-card.small.accent-purple { border-top-color: #8b5cf6; }
        .assignment-card.small.accent-orange { border-top-color: #f97316; }
        .small-card-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; flex-wrap: wrap; gap: 8px; }
        .assignment-card.small h3 { font-size: 1.05rem; font-weight: 700; color: #1e293b; margin-bottom: 8px; line-height: 1.3; }
        .body-text { font-size: 0.9rem; line-height: 1.65; color: #475569; margin-bottom: 18px; flex: 1; }
        .card-footer { margin-top: auto; padding-top: 14px; border-top: 1px solid #f1f5f9; }

        /* Small submit button */
        .submit-btn-sm {
            background: #1e2f7a; color: white; border: none;
            padding: 9px 18px; border-radius: 10px; font-weight: 700; font-size: 0.85rem;
            cursor: pointer; display: inline-flex; align-items: center; gap: 7px;
            transition: all 0.25s; box-shadow: 0 4px 10px rgba(30,47,122,0.2);
            font-family: 'Afacad', sans-serif;
        }
        .submit-btn-sm:hover { background: #22c55e; box-shadow: 0 6px 16px rgba(34,197,94,0.3); transform: translateY(-2px); }

        /* ── SUBMISSION MODAL ── */
        .submission-modal-overlay {
            position: fixed; inset: 0; background: rgba(15,23,42,0.65);
            display: none; align-items: center; justify-content: center;
            z-index: 9999; backdrop-filter: blur(4px); padding: 20px;
        }
        .submission-modal-overlay.active { display: flex; }
        body.modal-open { overflow: hidden; }

        .submission-modal-content {
            background: white; width: 100%; max-width: 500px; max-height: 92vh;
            border-radius: 20px; box-shadow: 0 25px 60px rgba(0,0,0,0.2);
            overflow-y: auto; animation: modalIn 0.25s ease-out; scrollbar-width: none;
        }
        .submission-modal-content::-webkit-scrollbar { display: none; }

        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.96) translateY(-12px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        .submission-modal-header {
            background: linear-gradient(135deg, #1e2f7a, #283593);
            padding: 24px 28px; display: flex; justify-content: space-between; align-items: center;
            border-radius: 20px 20px 0 0; position: sticky; top: 0; z-index: 1;
        }
        .submission-modal-header-inner { display: flex; align-items: center; gap: 14px; }
        .submission-modal-icon { width: 46px; height: 46px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; color: white; flex-shrink: 0; }
        .submission-modal-header h2 { font-size: 1.1rem; font-weight: 700; color: white; margin-bottom: 2px; }
        .submission-modal-header p  { font-size: 0.8rem; color: rgba(255,255,255,0.65); }
        .submission-close-btn { background: rgba(255,255,255,0.15); border: none; width: 32px; height: 32px; border-radius: 50%; color: white; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; transition: background 0.2s; flex-shrink: 0; }
        .submission-close-btn:hover { background: rgba(255,255,255,0.25); }

        .submission-modal-body { padding: 0; }
        .jhs-assign-guidelines { display: flex; align-items: flex-start; gap: 10px; background: #eff6ff; border-left: 4px solid #1e2f7a; padding: 12px 20px; margin: 20px 28px 0; border-radius: 0 8px 8px 0; font-size: 0.83rem; color: #334155; }
        .jhs-assign-guidelines i { color: #1e2f7a; margin-top: 2px; flex-shrink: 0; }

        .submission-form { padding: 20px 28px 28px; }
        .modal-input-group { margin-bottom: 18px; }
        .modal-input-group label { display: block; font-size: 0.83rem; font-weight: 700; color: #334155; margin-bottom: 7px; text-transform: uppercase; letter-spacing: 0.04em; }
        .optional-label { font-weight: 400; color: #94a3b8; text-transform: none; letter-spacing: 0; }
        .form-select { width: 100%; padding: 11px 14px; border-radius: 10px; border: 1.5px solid #e2e8f0; font-family: 'Afacad', sans-serif; font-size: 0.95rem; color: #1e293b; outline: none; transition: border-color 0.2s, box-shadow 0.2s; }
        .form-select:focus { border-color: #1e2f7a; box-shadow: 0 0 0 3px rgba(30,47,122,0.1); }

        /* ── Custom subject dropdown ── */
        .custom-subject-dropdown { position: relative; width: 100%; font-family: 'Afacad', sans-serif; }
        .custom-subject-trigger {
            width: 100%; display: flex; align-items: center; justify-content: space-between;
            background: #fafbff; border: 1.5px solid #e2e8f0; border-radius: 10px;
            padding: 11px 14px; cursor: pointer; font-family: 'Afacad', sans-serif;
            font-size: 0.95rem; color: #1e293b; transition: border-color 0.2s, box-shadow 0.2s;
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

        .upload-box { border: 2px dashed #cbd5e1; border-radius: 14px; padding: 36px 20px; text-align: center; cursor: pointer; background: #f8fafc; display: flex; flex-direction: column; align-items: center; gap: 10px; transition: 0.3s; margin-bottom: 18px; }
        .upload-box:hover { background: #f1f5f9; border-color: #1e2f7a; }
        .upload-box i     { font-size: 2rem; color: #94a3b8; }
        .upload-box span  { font-weight: 600; color: #334155; font-size: 0.9rem; }
        .upload-box small { color: #94a3b8; font-size: 0.78rem; }
        .submission-comments { resize: vertical; min-height: 72px; font-family: 'Afacad', sans-serif; }

        .finalize-btn {
            width: 100%; margin-top: 8px; padding: 14px;
            background: linear-gradient(135deg, #1e2f7a, #283593);
            color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 1rem;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            gap: 8px; transition: all 0.25s; box-shadow: 0 4px 15px rgba(30,47,122,0.3);
            font-family: 'Afacad', sans-serif;
        }
        .finalize-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(30,47,122,0.4); }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .hamburger-btn { display: block; }
            .main-header {
                padding: 12px 16px; position: sticky; top: 0; z-index: 100;
                display: flex; flex-direction: row; justify-content: space-between;
                align-items: center; flex-wrap: nowrap;
            }
            .main-header > div:first-child { display: flex; align-items: center; gap: 10px; min-width: 0; flex: 1; }
            .main-header h1 { font-size: 1.05rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .header-user { flex-shrink: 0; padding: 6px 10px; }
            .header-user span { display: none; }
            .header-user i { font-size: 1.4rem; }
            .scroll-container { padding: 14px; }
            .secondary-grid { grid-template-columns: 1fr; gap: 14px; }
            .assignment-card { padding: 20px; border-radius: 16px; }
            .assign-feat-header { flex-direction: column; gap: 12px; }
            .upload-box { padding: 24px 16px; }
            .submission-form { padding: 16px 20px 24px; }
            .submission-modal-header { padding: 20px; }
            .jhs-assign-guidelines { margin: 16px 20px 0; }
            .assign-summary-bar { flex-direction: column; align-items: flex-start; gap: 6px; }
            .small-card-top { flex-direction: column; align-items: flex-start; }
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
            <a href="{{ route('jhs.assignments') }}" class="nav-item active"><i class="fas fa-tasks"></i> Assignments</a>
            <a href="{{ route('jhs.quizzes') }}" class="nav-item"><i class="fas fa-edit"></i> Quizzes</a>
            <a href="{{ route('jhs.gradebook') }}" class="nav-item"><i class="fas fa-chart-line"></i> Gradebook</a>
            <a href="{{ route('jhs.calendar') }}" class="nav-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
            <a href="{{ route('jhs.logs') }}" class="nav-item"><i class="fas fa-history"></i> Activity Logs</a>
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
            <h1>My Assignments</h1>
        </div>
        <a href="{{ route('jhs.profile') }}" class="header-user">
            <i class="fas fa-user-circle"></i>
            <span>{{ session('jhs_student_name') }}</span>
        </a>
    </header>

    @php
        $subjectMeta = [
            'Science'     => ['tag' => 'tag-science', 'icon' => 'fa-flask',      'accent' => 'accent-blue'],
            'Mathematics' => ['tag' => 'tag-math',    'icon' => 'fa-calculator', 'accent' => 'accent-blue'],
            'English'     => ['tag' => 'tag-english', 'icon' => 'fa-book',       'accent' => 'accent-purple'],
            'TLE'         => ['tag' => 'tag-tle',     'icon' => 'fa-tools',      'accent' => 'accent-orange'],
        ];
        $defaultMeta = ['tag' => 'tag-tle', 'icon' => 'fa-book', 'accent' => 'accent-blue'];
        $pendingCount = $assignments->filter(fn ($a) => !$submissions->has($a->id))->count();
        $featured = $assignments->first();
        $rest = $assignments->slice(1);
    @endphp

    <div class="scroll-container">

        {{-- Summary bar --}}
        <div class="assign-summary-bar">
            <div class="assign-summary-left">
                <i class="fas fa-tasks"></i>
                <span><strong>{{ $pendingCount }}</strong> pending assignment{{ $pendingCount === 1 ? '' : 's' }}</span>
            </div>
            <span class="assign-summary-right">
                <i class="fas fa-exclamation-circle"></i> Submit before the due date
            </span>
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
            {{-- Featured assignment --}}
            <article class="assignment-card featured">
                <div class="assign-feat-decoration"></div>
                <div class="assign-feat-header">
                    <div class="assign-feat-icon science-bg">
                        <i class="fas {{ $meta['icon'] }}"></i>
                    </div>
                    <div class="assign-feat-title">
                        <span class="assign-tag"><i class="fas {{ $meta['icon'] }}"></i> {{ $featured->subject }}</span>
                        <h2>{{ $featured->title }}</h2>
                        <span class="assign-due {{ $isUrgent ? 'due-urgent' : 'due-normal' }}"><i class="fas fa-clock"></i> Due: {{ $featured->due_date->format('F d, Y') }}</span>
                    </div>
                </div>
                @if ($featured->description)
                    <p class="body-text">{{ $featured->description }}</p>
                @endif
                @if ($featured->attachment_link)
                    <a href="{{ $featured->attachment_link }}" target="_blank" class="attachment-link">
                        <div class="attachment-icon"><i class="fab fa-google-drive"></i></div>
                        <div class="attachment-text">
                            <span>Teacher's Attachment</span>
                            <small>{{ $featured->attachment_label ?? 'View file' }}</small>
                        </div>
                        <i class="fas fa-external-link-alt attach-arrow"></i>
                    </a>
                @endif
                @if ($submitted)
                    <button class="submit-btn" disabled style="opacity:0.7;cursor:default;">
                        <i class="fas fa-check-circle"></i> Submitted
                    </button>
                @else
                    <button class="submit-btn" onclick="openSubmissionModal({{ $featured->id }}, '{{ addslashes($featured->subject) }}')">
                        <i class="fas fa-upload"></i> Submit Work
                    </button>
                @endif
            </article>
        @endif

        {{-- Small cards --}}
        <div class="secondary-grid">
            @foreach ($rest as $a)
                @php
                    $meta = $subjectMeta[$a->subject] ?? $defaultMeta;
                    $submitted = $submissions->has($a->id);
                    $isUrgent = now()->diffInDays($a->due_date, false) <= 3;
                @endphp
                <article class="assignment-card small {{ $meta['accent'] }}">
                    <div class="small-card-top">
                        <span class="assign-tag {{ $meta['tag'] }}"><i class="fas {{ $meta['icon'] }}"></i> {{ $a->subject }}</span>
                        <span class="assign-due {{ $isUrgent ? 'due-urgent' : 'due-normal' }}"><i class="fas fa-clock"></i> Due: {{ $a->due_date->format('F d, Y') }}</span>
                    </div>
                    <h3>{{ $a->title }}</h3>
                    @if ($a->description)
                        <p class="body-text">{{ $a->description }}</p>
                    @endif
                    <div class="card-footer">
                        @if ($submitted)
                            <button class="submit-btn-sm" disabled style="opacity:0.7;cursor:default;background:#16a34a;">
                                <i class="fas fa-check-circle"></i> Submitted
                            </button>
                        @else
                            <button class="submit-btn-sm" onclick="openSubmissionModal({{ $a->id }}, '{{ addslashes($a->subject) }}')">
                                <i class="fas fa-upload"></i> Submit Work
                            </button>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</main>

{{-- Submission Modal --}}
<div class="submission-modal-overlay" id="submissionModal">
    <div class="submission-modal-content">
        <div class="submission-modal-header">
            <div class="submission-modal-header-inner">
                <div class="submission-modal-icon">
                    <i class="fas fa-cloud-upload-alt"></i>
                </div>
                <div>
                    <h2>Turn In Assignment</h2>
                    <p>Upload a picture of your paper or your digital file.</p>
                </div>
            </div>
            <button class="submission-close-btn" onclick="closeSubmissionModal()" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="submission-modal-body">
            <div class="jhs-assign-guidelines">
                <i class="fas fa-info-circle"></i>
                <span>Accepted: <strong>JPG, PNG, PDF</strong> &mdash; Max size: <strong>25MB</strong>. Include your name and subject in the filename.</span>
            </div>
            <div class="submission-form">
                <div class="modal-input-group">
                    <label>Select Subject</label>
                    <input type="hidden" id="subject-select" value="Science">
                    <div class="custom-subject-dropdown" id="subjectDropdown">
                        <button type="button" class="custom-subject-trigger" id="subjectTrigger">
                            <span id="subjectLabel">Science</span>
                            <i class="fas fa-chevron-down subject-chevron"></i>
                        </button>
                        <ul class="custom-subject-menu" id="subjectMenu">
                            <li class="custom-subject-option selected" data-value="Science">Science</li>
                            <li class="custom-subject-option" data-value="Mathematics">Mathematics</li>
                            <li class="custom-subject-option" data-value="English">English</li>
                            <li class="custom-subject-option" data-value="TLE">TLE</li>
                        </ul>
                    </div>
                </div>
                <div class="upload-box" id="drop-zone" onclick="document.getElementById('fileInput').click();">
                    <input type="file" id="fileInput" hidden>
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span id="file-label">Click to upload or drag file here</span>
                    <small>Supported: JPG, PNG, PDF</small>
                </div>
                <div class="modal-input-group">
                    <label>Comments <span class="optional-label">(optional)</span></label>
                    <textarea class="form-select submission-comments" id="submission-comments" rows="3" placeholder="Add a note for your teacher..."></textarea>
                </div>
                <button class="finalize-btn" id="turnInBtn" onclick="submitWork()">
                    <i class="fas fa-paper-plane"></i> Turn In Assignment
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Mobile nav overlay + drawer --}}
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
    <a href="{{ route('jhs.assignments') }}" class="nav-item active"><i class="fas fa-tasks"></i> Assignments</a>
    <a href="{{ route('jhs.quizzes') }}" class="nav-item"><i class="fas fa-edit"></i> Quizzes</a>
    <a href="{{ route('jhs.gradebook') }}" class="nav-item"><i class="fas fa-chart-line"></i> Gradebook</a>
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
window.SUBMIT_URL_TEMPLATE = "{{ route('jhs.assignments.submit', ['assignment' => '__ID__']) }}";
function csrfToken() {
    var m = document.querySelector('meta[name="csrf-token"]');
    return m ? m.content : '';
}

document.addEventListener('DOMContentLoaded', function () {

    // ── Mobile nav ──
    var hamburgerBtn = document.getElementById('hamburger-btn');
    var drawer       = document.getElementById('mobile-nav-drawer');
    var overlay      = document.getElementById('mobile-nav-overlay');
    var closeBtn     = document.getElementById('mobile-nav-close');
    function openDrawer()  { drawer.classList.add('open');    overlay.classList.add('open');    document.body.style.overflow = 'hidden'; }
    function closeDrawer() { drawer.classList.remove('open'); overlay.classList.remove('open'); document.body.style.overflow = ''; }
    if (hamburgerBtn) hamburgerBtn.addEventListener('click', openDrawer);
    if (closeBtn)     closeBtn.addEventListener('click', closeDrawer);
    if (overlay)      overlay.addEventListener('click', closeDrawer);

    // ── File input label ──
    var fileInput = document.getElementById('fileInput');
    var fileLabel = document.getElementById('file-label');
    if (fileInput) {
        fileInput.onchange = function () {
            if (this.files && this.files.length > 0) {
                fileLabel.textContent = 'File ready: ' + this.files[0].name;
                fileLabel.style.color = '#0f9d58';
            }
        };
    }
});

var submissionModal   = document.getElementById('submissionModal');
var subjectDropdown   = document.getElementById('subjectDropdown');
var subjectTrigger    = document.getElementById('subjectTrigger');
var subjectMenu       = document.getElementById('subjectMenu');
var subjectLabel      = document.getElementById('subjectLabel');
var subjectHiddenInput = document.getElementById('subject-select');
var currentAssignmentId = null;

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

function openSubmissionModal(assignmentId, subject) {
    currentAssignmentId = assignmentId;
    if (subject) setSubject(subject);
    submissionModal.classList.add('active');
    document.body.classList.add('modal-open');
}

function closeSubmissionModal() {
    submissionModal.classList.remove('active');
    document.body.classList.remove('modal-open');
}

submissionModal.addEventListener('click', function (e) {
    if (e.target === submissionModal) closeSubmissionModal();
});

function submitWork() {
    var fileInput = document.getElementById('fileInput');
    var turnInBtn = document.getElementById('turnInBtn');

    if (fileInput.files.length === 0) {
        alert('Please select or upload a photo of your work first!');
        return;
    }
    if (!currentAssignmentId) return;

    turnInBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
    turnInBtn.disabled = true;

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
            turnInBtn.innerHTML = '<i class="fas fa-check"></i> Submitted!';
            turnInBtn.style.background = '#0f9d58';
            setTimeout(function () { window.location.reload(); }, 900);
        })
        .catch(function (err) {
            var msg = (err && err.message) ? err.message : 'Error submitting assignment.';
            alert(msg);
            turnInBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Turn In Assignment';
            turnInBtn.disabled = false;
        });
}
</script>

</body>
</html>
