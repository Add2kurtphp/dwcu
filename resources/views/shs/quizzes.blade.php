<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizzes | DWCU SHS Portal</title>
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

        /* ── SUMMARY BAR ── */
        .quiz-summary-bar {
            display:flex; justify-content:space-between; align-items:center;
            background:white; border-radius:14px; padding:14px 22px;
            margin-bottom:22px; border:1px solid #e2e8f0;
            box-shadow:0 2px 8px rgba(0,0,0,0.04); flex-wrap:wrap; gap:12px;
        }
        .quiz-summary-left { display:flex; align-items:center; gap:10px; font-size:0.9rem; color:#475569; }
        .quiz-summary-left i { color:#1e2f7a; font-size:1rem; }
        .quiz-summary-right { display:flex; align-items:center; gap:8px; flex-wrap:wrap; }

        /* ── TAGS ── */
        .quiz-tag, .quiz-subject-tag {
            display:inline-flex; align-items:center; gap:5px;
            padding:4px 12px; border-radius:50px; font-size:0.72rem;
            font-weight:700; text-transform:uppercase; letter-spacing:0.04em;
        }
        .tag-open     { background:#dcfce7; color:#15803d; }
        .tag-done     { background:#f1f5f9; color:#64748b; }
        .tag-research { background:rgba(255,255,255,0.18); color:white; border:1px solid rgba(255,255,255,0.3); }
        .tag-physics  { background:#dbeafe; color:#1d4ed8; }
        .tag-calculus { background:#f5f3ff; color:#7c3aed; }
        .tag-biology  { background:#dcfce7; color:#15803d; }

        /* ── DUE BADGES ── */
        .due-badge {
            display:inline-flex; align-items:center; gap:5px;
            padding:4px 12px; border-radius:50px; font-size:0.75rem; font-weight:700;
        }
        .due-urgent { background:#fee2e2; color:#dc2626; }
        .due-normal { background:#fef9c3; color:#b45309; }

        /* ── FEATURED CARD ── */
        .quiz-featured-card {
            background:linear-gradient(135deg,#1e2f7a 0%,#283593 60%,#3949ab 100%);
            border-radius:22px; padding:32px 32px 26px; color:white;
            margin-bottom:22px; position:relative; overflow:hidden;
            box-shadow:0 12px 32px rgba(30,47,122,0.28); transition:transform 0.25s,box-shadow 0.25s;
        }
        .quiz-featured-card:hover { transform:translateY(-3px); box-shadow:0 18px 40px rgba(30,47,122,0.35); }
        .quiz-feat-deco {
            position:absolute; width:300px; height:300px; border-radius:50%;
            background:rgba(255,255,255,0.04); top:-80px; right:-60px; pointer-events:none;
        }
        .quiz-feat-deco::after {
            content:''; position:absolute; width:180px; height:180px; border-radius:50%;
            background:rgba(251,191,36,0.07); bottom:-50px; right:-30px;
        }
        .quiz-feat-header { display:flex; gap:20px; align-items:flex-start; margin-bottom:24px; position:relative; }
        .quiz-feat-icon {
            width:52px; height:52px; background:rgba(255,255,255,0.15);
            border:1px solid rgba(255,255,255,0.2); border-radius:15px;
            display:flex; align-items:center; justify-content:center;
            font-size:1.3rem; flex-shrink:0; margin-top:4px;
        }
        .quiz-feat-meta h2 { font-size:1.45rem; font-weight:700; margin:8px 0 10px; line-height:1.25; }
        .quiz-feat-meta p { font-size:0.9rem; opacity:0.85; line-height:1.6; max-width:580px; margin-bottom:14px; }
        .quiz-feat-info {
            display:flex; gap:18px; flex-wrap:wrap; margin-bottom:18px;
            font-size:0.82rem; color:rgba(255,255,255,0.7);
        }
        .quiz-feat-info span { display:flex; align-items:center; gap:6px; }
        .quiz-feat-footer {
            display:flex; align-items:center; justify-content:space-between;
            flex-wrap:wrap; gap:12px; padding-top:20px;
            border-top:1px solid rgba(255,255,255,0.12); position:relative;
        }

        /* G-Form link card */
        .gform-link-card {
            display:inline-flex; align-items:center; gap:14px;
            background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2);
            border-radius:12px; padding:12px 18px; cursor:pointer;
            transition:all 0.25s; max-width:420px; width:100%;
        }
        .gform-link-card:hover { background:rgba(255,255,255,0.18); transform:translateX(4px); }
        .gform-icon-box {
            width:38px; height:38px; background:#7c3aed; border-radius:10px;
            display:flex; align-items:center; justify-content:center;
            color:white; font-size:1.1rem; flex-shrink:0;
        }
        .gform-text-box { display:flex; flex-direction:column; }
        .gform-label { font-weight:700; font-size:0.85rem; color:rgba(255,255,255,0.95); }
        .gform-filename { font-size:0.75rem; color:rgba(255,255,255,0.6); margin-top:1px; }

        /* Take button (featured) */
        .quiz-take-btn {
            display:inline-flex; align-items:center; gap:8px;
            background:#fbbf24; color:#1e2f7a; border:none;
            padding:11px 24px; border-radius:10px; font-weight:700;
            font-size:0.9rem; cursor:pointer; transition:all 0.25s;
            box-shadow:0 4px 14px rgba(251,191,36,0.35);
        }
        .quiz-take-btn:hover { background:#f59e0b; transform:translateY(-2px); box-shadow:0 8px 20px rgba(251,191,36,0.45); }

        /* ── SMALL QUIZ CARDS ── */
        .quiz-cards-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:20px; }
        .quiz-small-card {
            background:white; border-radius:18px; padding:22px;
            border:1px solid #f1f5f9; border-top:4px solid transparent;
            box-shadow:0 4px 16px rgba(0,0,0,0.05); display:flex;
            flex-direction:column; gap:10px; transition:transform 0.25s,box-shadow 0.25s;
        }
        .quiz-small-card:hover { transform:translateY(-3px); box-shadow:0 10px 28px rgba(0,0,0,0.08); }
        .accent-blue   { border-top-color:#3b82f6; }
        .accent-purple { border-top-color:#a855f7; }
        .accent-green  { border-top-color:#22c55e; }
        .accent-gold   { border-top-color:#fbbf24; }
        .quiz-card-top { display:flex; justify-content:space-between; align-items:center; }
        .quiz-small-card h3 { font-size:1.05rem; font-weight:700; color:#1e2f7a; line-height:1.3; }
        .quiz-small-card p { font-size:0.87rem; color:#64748b; line-height:1.6; flex:1; }
        .quiz-card-footer {
            display:flex; align-items:center; justify-content:space-between;
            padding-top:14px; border-top:1px solid #f1f5f9; margin-top:auto;
        }
        .quiz-questions-info {
            display:flex; align-items:center; gap:5px;
            font-size:0.78rem; color:#94a3b8; font-weight:600;
        }
        .quiz-take-btn-sm {
            display:inline-flex; align-items:center; gap:7px;
            background:#1e2f7a; color:white; border:none;
            padding:8px 18px; border-radius:9px; font-weight:700;
            font-size:0.82rem; cursor:pointer; transition:all 0.25s;
        }
        .quiz-take-btn-sm:hover {
            background:#fbbf24; color:#1e2f7a;
            box-shadow:0 6px 16px rgba(251,191,36,0.35); transform:translateY(-2px);
        }

        /* ── "ARE YOU READY?" MODAL ── */
        .ready-modal-overlay {
            position:fixed; inset:0; background:rgba(15,23,42,0.65);
            display:none; align-items:center; justify-content:center;
            z-index:9998; backdrop-filter:blur(4px); padding:20px;
        }
        .ready-modal-overlay.show { display:flex; }
        .ready-modal-content {
            background:white; border-radius:24px; padding:40px 36px 36px;
            max-width:420px; width:100%; text-align:center;
            box-shadow:0 24px 48px rgba(0,0,0,0.18);
            animation:readyPop 0.28s cubic-bezier(0.34,1.56,0.64,1);
        }
        @keyframes readyPop {
            from { opacity:0; transform:scale(0.85); }
            to   { opacity:1; transform:scale(1); }
        }
        .ready-modal-icon {
            width:68px; height:68px;
            background:linear-gradient(135deg,#1e2f7a,#283593);
            border-radius:50%; display:flex; align-items:center; justify-content:center;
            font-size:1.6rem; color:white; margin:0 auto 20px;
            box-shadow:0 8px 20px rgba(30,47,122,0.3);
        }
        .ready-modal-content h2 { font-size:1.3rem; font-weight:700; color:#1e293b; margin-bottom:6px; }
        .ready-subject-name { font-size:0.9rem; color:#64748b; font-weight:600; margin-bottom:22px; }
        .ready-modal-info {
            display:flex; flex-direction:column; gap:10px;
            background:#f8fafc; border-radius:14px; padding:18px 20px;
            margin-bottom:26px; text-align:left;
        }
        .ready-info-item { display:flex; align-items:center; gap:12px; font-size:0.88rem; color:#334155; font-weight:500; }
        .ready-info-item i { width:20px; text-align:center; color:#1e2f7a; font-size:0.9rem; }
        .ready-modal-actions { display:flex; gap:12px; }
        .ready-cancel-btn {
            flex:1; display:flex; align-items:center; justify-content:center; gap:8px;
            padding:12px; border-radius:12px; border:1.5px solid #e2e8f0;
            background:white; color:#64748b; font-weight:700; font-size:0.9rem;
            cursor:pointer; transition:all 0.2s; font-family:'Afacad',sans-serif;
        }
        .ready-cancel-btn:hover { background:#f1f5f9; }
        .ready-start-btn {
            flex:1; display:flex; align-items:center; justify-content:center; gap:8px;
            padding:12px; border-radius:12px; border:none;
            background:#fbbf24; color:#1e2f7a; font-weight:700; font-size:0.9rem;
            cursor:pointer; transition:all 0.25s; font-family:'Afacad',sans-serif;
            box-shadow:0 4px 14px rgba(251,191,36,0.35);
        }
        .ready-start-btn:hover { background:#f59e0b; transform:translateY(-2px); box-shadow:0 8px 20px rgba(251,191,36,0.45); }

        /* ── QUIZ MODAL ── */
        .shs-quiz-modal-overlay {
            position:fixed; inset:0; background:rgba(15,23,42,0.72);
            display:none; align-items:center; justify-content:center;
            z-index:9999; backdrop-filter:blur(4px); padding:20px;
        }
        .shs-quiz-modal-overlay.active { display:flex; }
        body.shs-quiz-open { overflow:hidden; }
        .shs-quiz-modal-content {
            background:white; width:100%; max-width:720px; max-height:90vh;
            border-radius:20px; box-shadow:0 25px 50px rgba(0,0,0,0.25);
            display:flex; flex-direction:column; overflow:hidden;
            animation:shsQuizIn 0.25s ease-out;
        }
        @keyframes shsQuizIn {
            from { opacity:0; transform:scale(0.96) translateY(-14px); }
            to   { opacity:1; transform:scale(1) translateY(0); }
        }
        .shs-quiz-modal-header {
            background:linear-gradient(135deg,#1e2f7a,#283593);
            padding:20px 28px; display:flex; align-items:center;
            justify-content:space-between; flex-shrink:0; gap:16px;
        }
        .shs-quiz-active-badge {
            display:flex; align-items:center; gap:6px; font-size:0.72rem;
            font-weight:700; text-transform:uppercase; letter-spacing:1.2px;
            color:rgba(255,255,255,0.6); margin-bottom:4px;
        }
        .shs-quiz-modal-header #current-quiz-title { color:white; font-size:1.2rem; font-weight:700; margin:0; }
        .shs-quiz-header-right { display:flex; align-items:center; gap:12px; flex-shrink:0; }
        .timer-pill {
            display:inline-flex; align-items:center; gap:8px;
            background:#fef2f2; color:#ef4444; padding:7px 16px;
            border-radius:50px; font-weight:700; font-size:0.9rem;
            border:1px solid #fee2e2; white-space:nowrap;
        }
        .shs-exit-quiz-btn {
            display:inline-flex; align-items:center; gap:6px;
            background:rgba(255,255,255,0.12); color:white;
            border:1px solid rgba(255,255,255,0.25); padding:8px 16px;
            border-radius:10px; font-weight:600; font-size:0.82rem;
            cursor:pointer; transition:0.2s; white-space:nowrap;
        }
        .shs-exit-quiz-btn:hover { background:rgba(239,68,68,0.8); border-color:transparent; }
        .shs-quiz-modal-body { padding:28px; overflow-y:auto; flex:1; scrollbar-width:none; }
        .shs-quiz-modal-body::-webkit-scrollbar { display:none; }
        .quiz-q-box {
            background:white; padding:26px; border-radius:14px; margin-bottom:20px;
            border:1px solid #e2e8f0; box-shadow:0 2px 8px rgba(0,0,0,0.03);
        }
        .question-text { font-weight:700; color:#1e2f7a; font-size:1.05rem; margin-bottom:18px; }
        .quiz-option {
            display:flex; align-items:center; gap:12px; background:#f8fafc;
            padding:14px 20px; border-radius:50px; margin-bottom:10px;
            border:1.5px solid #e2e8f0; cursor:pointer; transition:all 0.2s;
        }
        .quiz-option:hover { border-color:#1e2f7a; background:#eff6ff; transform:translateX(4px); }
        .quiz-option input[type="radio"] { width:18px; height:18px; accent-color:#1e2f7a; cursor:pointer; }
        .quiz-option label { width:100%; cursor:pointer; font-weight:500; color:#334155; }
        .iframe-container { width:100%; height:62vh; border-radius:14px; overflow:hidden; border:1px solid #e2e8f0; background:#f8fafc; }
        #quiz-iframe { width:100%; height:100%; }
        .shs-quiz-modal-footer { padding:16px 28px; border-top:1px solid #f1f5f9; flex-shrink:0; background:white; }
        .finalize-btn {
            width:100%; display:flex; align-items:center; justify-content:center; gap:10px;
            background:linear-gradient(135deg,#1e2f7a,#283593); color:white; border:none;
            padding:14px; border-radius:12px; font-weight:700; font-size:1rem;
            cursor:pointer; transition:all 0.3s; font-family:'Afacad',sans-serif;
        }
        .finalize-btn:hover { background:linear-gradient(135deg,#162155,#1e2f7a); transform:translateY(-2px); box-shadow:0 8px 20px rgba(30,47,122,0.3); }

        @media (max-width:768px) {
            body { overflow-x:hidden; overflow-y:auto; flex-direction:column; height:auto; min-height:100vh; }
            .sidebar { display:none; }
            .hamburger-btn { display:block; }
            .content-area { width:100%; overflow-x:hidden; overflow-y:visible; }
            .main-header { padding:12px 16px; position:sticky; top:0; z-index:100; }
            .main-header h1 { font-size:1.05rem; }
            .header-user span { display:none; }
            .scroll-container { padding:16px; overflow-y:visible; }
            .quiz-summary-bar { flex-direction:column; align-items:flex-start; }
            .quiz-featured-card { padding:22px 18px 20px; border-radius:18px; }
            .quiz-feat-header { flex-direction:column; gap:14px; }
            .quiz-feat-meta h2 { font-size:1.2rem; }
            .quiz-feat-info { gap:10px; }
            .gform-link-card { max-width:100%; }
            .quiz-feat-footer { flex-direction:column; align-items:flex-start; }
            .quiz-take-btn { width:100%; justify-content:center; }
            .quiz-cards-grid { grid-template-columns:1fr; }
            .quiz-card-footer { flex-direction:column; gap:10px; align-items:flex-start; }
            .quiz-take-btn-sm { width:100%; justify-content:center; }
            .ready-modal-content { padding:30px 22px 26px; }
            .ready-modal-actions { flex-direction:column; }
            .shs-quiz-modal-content { max-width:100%; border-radius:14px; }
            .shs-quiz-modal-header { flex-direction:column; align-items:flex-start; gap:12px; padding:16px 18px; }
            .shs-quiz-header-right { width:100%; justify-content:space-between; }
            .shs-quiz-modal-body { padding:16px; }
            .iframe-container { height:55vh; }
            .shs-quiz-modal-footer { padding:12px 16px; }
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
            <a href="{{ route('shs.quizzes') }}"      class="nav-item active"><i class="fas fa-edit"></i> Quizzes</a>
            <a href="{{ route('shs.gradebook') }}"    class="nav-item"><i class="fas fa-chart-line"></i> Gradebook</a>
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
            <h1>Quizzes</h1>
        </div>
        <a href="{{ route('shs.profile') }}" class="header-user">
            <i class="fas fa-user-graduate"></i>
            <span>{{ session('shs_student_name') }}</span>
        </a>
    </header>

    <div class="scroll-container">

        {{-- ── Summary Bar ── --}}
        <div class="quiz-summary-bar">
            <div class="quiz-summary-left">
                <i class="fas fa-edit"></i>
                <span><strong>4</strong> active quizzes &mdash; March 2026</span>
            </div>
            <div class="quiz-summary-right">
                <span class="quiz-tag tag-open"><i class="fas fa-circle"></i> 4 Open</span>
                <span class="quiz-tag tag-done">0 Completed</span>
            </div>
        </div>

        {{-- ── Featured Quiz Card ── --}}
        <div class="quiz-featured-card">
            <div class="quiz-feat-deco"></div>
            <div class="quiz-feat-header">
                <div class="quiz-feat-icon">
                    <i class="fas fa-flask"></i>
                </div>
                <div class="quiz-feat-meta">
                    <span class="quiz-subject-tag tag-research">Practical Research 2</span>
                    <h2>Mid-Unit Quiz — Research Methods</h2>
                    <p>This quiz is hosted on Google Forms. Click the link below to start. Your grade will be imported automatically after completion.</p>
                    <div class="quiz-feat-info">
                        <span><i class="far fa-calendar-alt"></i> Due: March 10, 2026</span>
                        <span><i class="far fa-clock"></i> 45 Minutes</span>
                        <span><i class="fas fa-external-link-alt"></i> External (G-Form)</span>
                    </div>
                    <div class="gform-link-card" onclick="confirmQuiz('Practical Research 2')">
                        <div class="gform-icon-box">
                            <i class="fab fa-google-drive"></i>
                        </div>
                        <div class="gform-text-box">
                            <span class="gform-label">External Quiz (G-Form)</span>
                            <span class="gform-filename">Science_Quiz_Unit3</span>
                        </div>
                        <i class="fas fa-chevron-right" style="margin-left:auto; color:#94a3b8; font-size:0.8rem;"></i>
                    </div>
                </div>
            </div>
            <div class="quiz-feat-footer">
                <span class="due-badge due-urgent"><i class="fas fa-fire"></i> Due Soon</span>
                <button class="quiz-take-btn" onclick="confirmQuiz('Practical Research 2')">
                    <i class="fas fa-play"></i> Start Quiz
                </button>
            </div>
        </div>

        {{-- ── Small Quiz Cards ── --}}
        <div class="quiz-cards-grid">

            <div class="quiz-small-card accent-blue">
                <div class="quiz-card-top">
                    <span class="quiz-subject-tag tag-physics">Physics</span>
                    <span class="due-badge due-normal"><i class="fas fa-clock"></i> 20 Mins</span>
                </div>
                <h3>Kinematics &amp; Dynamics</h3>
                <p>Brief check on Newtonian mechanics. Ensure you have your scientific calculator ready.</p>
                <div class="quiz-card-footer">
                    <span class="quiz-questions-info"><i class="fas fa-question-circle"></i> 2 questions</span>
                    <button class="quiz-take-btn-sm" onclick="confirmQuiz('Physics')">
                        <i class="fas fa-play"></i> Take Quiz
                    </button>
                </div>
            </div>

            <div class="quiz-small-card accent-purple">
                <div class="quiz-card-top">
                    <span class="quiz-subject-tag tag-calculus">Calculus</span>
                    <span class="due-badge due-normal"><i class="fas fa-clock"></i> 30 Mins</span>
                </div>
                <h3>Limits and Continuity</h3>
                <p>Advanced problems covering the Squeeze Theorem and infinite limits.</p>
                <div class="quiz-card-footer">
                    <span class="quiz-questions-info"><i class="fas fa-question-circle"></i> 2 questions</span>
                    <button class="quiz-take-btn-sm" onclick="confirmQuiz('Calculus')">
                        <i class="fas fa-play"></i> Take Quiz
                    </button>
                </div>
            </div>

            <div class="quiz-small-card accent-green">
                <div class="quiz-card-top">
                    <span class="quiz-subject-tag tag-biology">Biology</span>
                    <span class="due-badge due-normal"><i class="fas fa-clock"></i> 25 Mins</span>
                </div>
                <h3>Cellular Processes</h3>
                <p>Review quiz on Mitosis vs Meiosis and ATP production cycles.</p>
                <div class="quiz-card-footer">
                    <span class="quiz-questions-info"><i class="fas fa-question-circle"></i> 2 questions</span>
                    <button class="quiz-take-btn-sm" onclick="confirmQuiz('Biology')">
                        <i class="fas fa-play"></i> Take Quiz
                    </button>
                </div>
            </div>

        </div>
    </div>
</main>

{{-- ── "Are You Ready?" Confirmation Modal ── --}}
<div class="ready-modal-overlay" id="readyModal">
    <div class="ready-modal-content">
        <div class="ready-modal-icon">
            <i class="fas fa-pencil-alt"></i>
        </div>
        <h2>Ready to take the quiz?</h2>
        <p id="ready-modal-subject" class="ready-subject-name"></p>
        <div class="ready-modal-info">
            <div class="ready-info-item">
                <i class="fas fa-hourglass-half"></i>
                <span id="ready-modal-duration">-- minutes</span>
            </div>
            <div class="ready-info-item">
                <i class="fas fa-question-circle"></i>
                <span id="ready-modal-questions">-- questions</span>
            </div>
            <div class="ready-info-item">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Cannot pause once started</span>
            </div>
        </div>
        <div class="ready-modal-actions">
            <button class="ready-cancel-btn" onclick="closeReadyModal()">
                <i class="fas fa-arrow-left"></i> Not Yet
            </button>
            <button class="ready-start-btn" id="readyStartBtn">
                <i class="fas fa-play"></i> Start Quiz
            </button>
        </div>
    </div>
</div>

{{-- ── Quiz Modal ── --}}
<div class="shs-quiz-modal-overlay" id="shsQuizModal">
    <div class="shs-quiz-modal-content">

        <div class="shs-quiz-modal-header">
            <div class="shs-quiz-header-left">
                <span class="shs-quiz-active-badge"><i class="fas fa-circle" style="font-size:0.5rem; color:#4ade80;"></i> Active Quiz</span>
                <h2 id="current-quiz-title">Quiz Title</h2>
            </div>
            <div class="shs-quiz-header-right">
                <div id="quiz-timer" class="timer-pill">
                    <i class="fas fa-hourglass-half"></i> --:--
                </div>
                <button class="shs-exit-quiz-btn" onclick="closeQuizModal()">
                    <i class="fas fa-times"></i> Exit
                </button>
            </div>
        </div>

        <div class="shs-quiz-modal-body">
            <div id="quiz-questions-area"></div>
            <div id="external-quiz-area" style="display:none;">
                <div class="iframe-container">
                    <iframe id="quiz-iframe" src="" frameborder="0">Loading…</iframe>
                </div>
            </div>
        </div>

        <div class="shs-quiz-modal-footer">
            <button id="submit-quiz-btn" class="finalize-btn">
                <i class="fas fa-paper-plane"></i> Submit and Finalize Grade
            </button>
        </div>

    </div>
</div>

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
    <a href="{{ route('shs.quizzes') }}"      class="nav-item active"><i class="fas fa-edit"></i> Quizzes</a>
    <a href="{{ route('shs.gradebook') }}"    class="nav-item"><i class="fas fa-chart-line"></i> Gradebook</a>
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
    const quizData = {
        'Practical Research 2': {
            isExternal: true,
            url: "https://docs.google.com/forms/d/e/1FAIpQLSd1Wgo_72hdD-MYqh6Q1bYnFwPmPPzfCEfDJ1gOzjUHQW8DSA/viewform?usp=header_3&edit_requested=true",
            timeLimit: 2700
        },
        'Physics': {
            isExternal: false,
            timeLimit: 1200,
            questions: [
                { q: "What is the unit of Force in the SI system?", options: ["Joule","Watt","Newton","Pascal"], correct: 2 },
                { q: "Acceleration is defined as the change in ____ over time.", options: ["Distance","Velocity","Mass","Energy"], correct: 1 }
            ]
        },
        'Calculus': {
            isExternal: false,
            timeLimit: 1800,
            questions: [
                { q: "What is the derivative of a constant?", options: ["1","x","Infinity","0"], correct: 3 },
                { q: "The Squeeze Theorem is also known as the ____ Theorem.", options: ["Sandwich","Expansion","Limit","Continuity"], correct: 0 }
            ]
        },
        'Biology': {
            isExternal: false,
            timeLimit: 1500,
            questions: [
                { q: "Which process produces two identical daughter cells?", options: ["Meiosis","Mitosis","Osmosis","Diffusion"], correct: 1 },
                { q: "Where is ATP primarily produced in the cell?", options: ["Nucleus","Ribosomes","Mitochondria","Golgi Body"], correct: 2 }
            ]
        }
    };

    const quizMeta = {
        'Practical Research 2': { duration: '45 minutes', questions: 'External (G-Form)' },
        'Physics':              { duration: '20 minutes', questions: '2 questions' },
        'Calculus':             { duration: '30 minutes', questions: '2 questions' },
        'Biology':              { duration: '25 minutes', questions: '2 questions' }
    };

    let currentSubject = "";
    let timerInterval;
    let timeLeft = 0;
    let quizActive = false;
    let pendingQuizSubject = null;

    const shsQuizModal = document.getElementById('shsQuizModal');

    function confirmQuiz(subject) {
        pendingQuizSubject = subject;
        const meta = quizMeta[subject] || { duration: '--', questions: '--' };
        document.getElementById('ready-modal-subject').textContent = subject + ' Quiz';
        document.getElementById('ready-modal-duration').textContent = meta.duration;
        document.getElementById('ready-modal-questions').textContent = meta.questions;
        document.getElementById('readyModal').classList.add('show');
    }

    function closeReadyModal() {
        document.getElementById('readyModal').classList.remove('show');
        pendingQuizSubject = null;
    }

    document.getElementById('readyStartBtn').addEventListener('click', function () {
        if (pendingQuizSubject) {
            const subject = pendingQuizSubject;
            closeReadyModal();
            startQuiz(subject);
        }
    });

    document.getElementById('readyModal').addEventListener('click', function (e) {
        if (e.target === this) closeReadyModal();
    });

    function openQuizModal() {
        shsQuizModal.classList.add('active');
        document.body.classList.add('shs-quiz-open');
    }

    function closeQuizModal() {
        const confirmed = confirm("Are you sure you want to exit? Your progress may not be saved.");
        if (!confirmed) return;
        clearInterval(timerInterval);
        quizActive = false;
        shsQuizModal.classList.remove('active');
        document.body.classList.remove('shs-quiz-open');
    }

    shsQuizModal.addEventListener('click', (e) => {
        if (e.target === shsQuizModal) closeQuizModal();
    });

    function startQuiz(subject) {
        if (!quizData[subject]) return;
        currentSubject = subject;
        quizActive = true;
        const data = quizData[subject];

        const questionArea = document.getElementById('quiz-questions-area');
        const externalArea = document.getElementById('external-quiz-area');
        const submitBtn    = document.getElementById('submit-quiz-btn');

        document.getElementById('current-quiz-title').innerText = subject + " Quiz";
        timeLeft = data.timeLimit;
        runTimer();

        if (data.isExternal) {
            questionArea.style.display = "none";
            submitBtn.style.display    = "none";
            externalArea.style.display = "block";
            document.getElementById('quiz-iframe').src = data.url;
        } else {
            externalArea.style.display = "none";
            questionArea.style.display = "block";
            submitBtn.style.display    = "block";
            renderQuestions(data.questions, questionArea);
        }

        document.querySelector('.shs-quiz-modal-body').scrollTop = 0;
        openQuizModal();
    }

    function renderQuestions(questions, container) {
        container.innerHTML = "";
        questions.forEach((item, index) => {
            const optionsHTML = item.options.map((opt, i) => `
                <div class="quiz-option" onclick="this.querySelector('input').click()">
                    <input type="radio" name="q${index}" value="${i}" id="q${index}o${i}">
                    <label for="q${index}o${i}">${opt}</label>
                </div>
            `).join("");
            container.innerHTML += `
                <div class="quiz-q-box">
                    <p class="question-text">Question ${index + 1}: ${item.q}</p>
                    <div class="options-wrapper">${optionsHTML}</div>
                </div>
            `;
        });
    }

    function runTimer() {
        const timerDisplay = document.getElementById('quiz-timer');
        clearInterval(timerInterval);
        timerInterval = setInterval(() => {
            timeLeft--;
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerDisplay.innerHTML = `<i class="fas fa-hourglass-half"></i> ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                alert("Time is up! Your answers are being submitted.");
                finishQuiz();
            }
        }, 1000);
    }

    function finishQuiz() {
        clearInterval(timerInterval);
        quizActive = false;
        const data = quizData[currentSubject];
        if (!data.isExternal) {
            let score = 0;
            data.questions.forEach((item, index) => {
                const selected = document.querySelector(`input[name="q${index}"]:checked`);
                if (selected && parseInt(selected.value) === item.correct) score++;
            });
            alert(`Quiz Finished!\nSubject: ${currentSubject}\nFinal Score: ${score} / ${data.questions.length}`);
        } else {
            alert("Completed. Please ensure you clicked 'Submit' inside the Google Form.");
        }
        shsQuizModal.classList.remove('active');
        document.body.classList.remove('shs-quiz-open');
    }

    document.getElementById('submit-quiz-btn').addEventListener('click', () => {
        if (confirm("Are you sure you want to submit your answers?")) finishQuiz();
    });

    window.onbeforeunload = function () {
        if (quizActive) return "You have an active quiz! Your progress will be lost.";
    };

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
