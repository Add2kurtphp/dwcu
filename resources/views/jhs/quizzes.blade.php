<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizzes | DWCU Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css'])
    <style>
        :root {
            --primary-blue: #1e2f7a;
            --bg-light: #f0f4f8;
            --text-dark: #1e293b;
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
        .quiz-summary-bar {
            display: flex; justify-content: space-between; align-items: center;
            background: white; border-radius: 14px; padding: 14px 22px;
            margin-bottom: 22px; border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .quiz-summary-left { display: flex; align-items: center; gap: 10px; font-size: 0.9rem; color: #475569; }
        .quiz-summary-left i { color: #1e2f7a; font-size: 1rem; }
        .quiz-summary-right { font-size: 0.82rem; color: #94a3b8; display: flex; align-items: center; gap: 6px; }

        /* ── CARDS BASE ── */
        .quiz-card {
            background: white; border-radius: 20px; padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #f1f5f9;
            display: flex; flex-direction: column;
            transition: box-shadow 0.25s, transform 0.25s;
        }
        .quiz-card:hover { box-shadow: 0 8px 30px rgba(30,47,122,0.1); transform: translateY(-2px); }

        /* ── TAGS ── */
        .quiz-tag {
            display: inline-flex; align-items: center; gap: 5px;
            border-radius: 50px; padding: 4px 12px; font-size: 0.72rem;
            font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
        }
        .tag-science { background: #e0f2fe; color: #0369a1; }
        .tag-math    { background: #eff6ff; color: #1d4ed8; }
        .tag-english { background: #f5f3ff; color: #7c3aed; }

        /* ── DUE / DURATION ── */
        .quiz-due { display: inline-flex; align-items: center; gap: 5px; font-size: 0.8rem; font-weight: 600; }
        .due-urgent { color: #ef4444; }
        .due-normal { color: #f59e0b; }
        .quiz-duration { display: inline-flex; align-items: center; gap: 5px; font-size: 0.8rem; font-weight: 600; color: rgba(255,255,255,0.7); }
        .quiz-meta-row { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; margin-top: 4px; }

        /* ── FEATURED CARD ── */
        .quiz-card.featured {
            background: linear-gradient(135deg, #1e2f7a 0%, #283593 100%);
            color: white; border: none; margin-bottom: 22px;
            position: relative; overflow: hidden;
        }
        .quiz-feat-decoration { position: absolute; width: 260px; height: 260px; border-radius: 50%; border: 50px solid rgba(255,255,255,0.04); top: -70px; right: -60px; pointer-events: none; }
        .quiz-feat-header { display: flex; gap: 18px; align-items: flex-start; margin-bottom: 18px; }
        .quiz-feat-icon { width: 54px; height: 54px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; flex-shrink: 0; }
        .science-bg { background: rgba(255,255,255,0.15); color: white; }
        .quiz-feat-title .quiz-tag { background: rgba(255,255,255,0.15); color: rgba(255,255,255,0.9); margin-bottom: 8px; }
        .quiz-feat-title h2 { font-size: 1.4rem; font-weight: 700; color: white; margin-bottom: 6px; line-height: 1.3; }
        .quiz-card.featured .body-text { color: rgba(255,255,255,0.8); margin-bottom: 20px; }

        /* G-Form link */
        .quiz-link { display: flex; align-items: center; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15); border-radius: 12px; padding: 12px 16px; text-decoration: none; transition: background 0.2s; gap: 12px; }
        .quiz-link:hover { background: rgba(255,255,255,0.18); }
        .quiz-link-icon { width: 36px; height: 36px; background: #673ab7; color: white; display: flex; align-items: center; justify-content: center; border-radius: 8px; font-size: 1rem; flex-shrink: 0; }
        .attachment-text { flex: 1; }
        .attachment-text span  { display: block; font-size: 0.88rem; font-weight: 600; color: white; }
        .attachment-text small { color: rgba(255,255,255,0.55); font-size: 0.75rem; }
        .attach-arrow { color: rgba(255,255,255,0.4); font-size: 0.8rem; margin-left: auto; }

        /* ── SMALL CARDS ── */
        .secondary-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .quiz-card.small { border-top: 4px solid transparent; }
        .quiz-card.small.accent-blue   { border-top-color: #3b82f6; }
        .quiz-card.small.accent-purple { border-top-color: #8b5cf6; }
        .small-card-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; flex-wrap: wrap; gap: 8px; }
        .quiz-card.small h3 { font-size: 1.05rem; font-weight: 700; color: #1e293b; margin-bottom: 8px; line-height: 1.3; }
        .body-text { font-size: 0.9rem; line-height: 1.65; color: #475569; margin-bottom: 18px; flex: 1; }
        .card-footer { margin-top: auto; padding-top: 14px; border-top: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; gap: 10px; }
        .quiz-duration-sm { font-size: 0.78rem; color: #94a3b8; display: inline-flex; align-items: center; gap: 5px; font-weight: 600; }

        /* Take Quiz button */
        .take-quiz-btn {
            background: #1e2f7a; color: white; border: none;
            padding: 9px 18px; border-radius: 10px; font-weight: 700; font-size: 0.85rem;
            cursor: pointer; display: inline-flex; align-items: center; gap: 7px;
            transition: all 0.25s; box-shadow: 0 4px 10px rgba(30,47,122,0.2);
            font-family: 'Afacad', sans-serif;
        }
        .take-quiz-btn:hover { background: #22c55e; box-shadow: 0 6px 16px rgba(34,197,94,0.3); transform: translateY(-2px); }

        /* ── READY MODAL ── */
        .ready-modal-overlay { position: fixed; inset: 0; background: rgba(15,23,42,0.65); display: none; align-items: center; justify-content: center; z-index: 9998; backdrop-filter: blur(4px); padding: 20px; }
        .ready-modal-overlay.active { display: flex; }

        .ready-modal-content {
            background: white; width: 100%; max-width: 400px; border-radius: 24px;
            padding: 36px 32px 30px; box-shadow: 0 25px 60px rgba(0,0,0,0.2);
            display: flex; flex-direction: column; align-items: center; text-align: center;
            animation: readyModalIn 0.25s ease-out;
        }
        @keyframes readyModalIn {
            from { opacity: 0; transform: scale(0.92) translateY(-16px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        .ready-modal-icon { width: 68px; height: 68px; background: linear-gradient(135deg, #1e2f7a, #283593); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; color: white; margin-bottom: 20px; box-shadow: 0 8px 20px rgba(30,47,122,0.3); }
        .ready-modal-content h2 { font-size: 1.25rem; font-weight: 700; color: #1e293b; margin-bottom: 6px; }
        .ready-subject-name { font-size: 0.9rem; font-weight: 600; color: #1e2f7a; background: #eff6ff; padding: 4px 16px; border-radius: 50px; margin-bottom: 22px; }
        .ready-modal-info { display: flex; flex-direction: column; gap: 10px; width: 100%; margin-bottom: 26px; }
        .ready-info-item { display: flex; align-items: center; gap: 12px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 11px 16px; font-size: 0.88rem; color: #334155; font-weight: 500; text-align: left; }
        .ready-info-item i { width: 18px; text-align: center; color: #1e2f7a; flex-shrink: 0; }
        .ready-modal-actions { display: flex; gap: 12px; width: 100%; }
        .ready-cancel-btn { flex: 1; padding: 12px; background: white; color: #64748b; border: 1.5px solid #e2e8f0; border-radius: 12px; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 7px; transition: all 0.2s; font-family: 'Afacad', sans-serif; }
        .ready-cancel-btn:hover { background: #f1f5f9; border-color: #cbd5e1; }
        .ready-start-btn { flex: 1.6; padding: 12px; background: linear-gradient(135deg, #1e2f7a, #283593); color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 7px; transition: all 0.25s; box-shadow: 0 4px 14px rgba(30,47,122,0.3); font-family: 'Afacad', sans-serif; }
        .ready-start-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(30,47,122,0.4); }

        /* ── QUIZ MODAL ── */
        .quiz-modal-overlay { position: fixed; inset: 0; background: rgba(15,23,42,0.65); display: none; align-items: center; justify-content: center; z-index: 9999; backdrop-filter: blur(4px); padding: 20px; }
        .quiz-modal-overlay.active { display: flex; }
        body.quiz-open { overflow: hidden; }

        .quiz-modal-content { background: white; width: 100%; max-width: 620px; max-height: 90vh; border-radius: 20px; box-shadow: 0 25px 60px rgba(0,0,0,0.2); display: flex; flex-direction: column; overflow: hidden; animation: quizModalIn 0.25s ease-out; }
        @keyframes quizModalIn {
            from { opacity: 0; transform: scale(0.96) translateY(-12px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        .quiz-modal-header { background: linear-gradient(135deg, #1e2f7a, #283593); padding: 24px 28px; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; }
        .quiz-modal-header-inner { display: flex; align-items: center; gap: 14px; }
        .quiz-modal-icon { width: 46px; height: 46px; background: rgba(255,255,255,0.15); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: white; flex-shrink: 0; }
        .quiz-modal-header h2 { font-size: 1.1rem; font-weight: 700; color: white; margin-bottom: 2px; }
        .quiz-active-label { font-size: 0.75rem; color: rgba(255,255,255,0.65); font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
        .quiz-active-label i { color: #4ade80; font-size: 0.6rem; margin-right: 2px; }
        .quiz-header-right { display: flex; align-items: center; gap: 14px; flex-shrink: 0; }
        #quiz-timer { background: #fef2f2; color: #ef4444; padding: 6px 14px; border-radius: 50px; font-size: 0.85rem; font-weight: 700; border: 1px solid #fee2e2; white-space: nowrap; }
        .quiz-close-btn { background: rgba(255,255,255,0.15); border: none; width: 32px; height: 32px; border-radius: 50%; color: white; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; transition: background 0.2s; flex-shrink: 0; }
        .quiz-close-btn:hover { background: rgba(239,68,68,0.75); }

        .quiz-modal-body { padding: 24px; overflow-y: auto; flex: 1; scrollbar-width: none; }
        .quiz-modal-body::-webkit-scrollbar { display: none; }
        .quiz-instructions-box { display: flex; align-items: flex-start; gap: 10px; background: #eff6ff; border-left: 4px solid #1e2f7a; padding: 12px 16px; border-radius: 0 8px 8px 0; font-size: 0.83rem; color: #334155; margin-bottom: 20px; }
        .quiz-instructions-box i { color: #1e2f7a; margin-top: 1px; flex-shrink: 0; }

        .quiz-q-box { margin-bottom: 20px; padding: 20px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; }
        .quiz-q-box p { font-weight: 700; color: #1e2f7a; margin-bottom: 14px; font-size: 0.95rem; line-height: 1.5; }
        .quiz-option { display: flex; align-items: center; padding: 11px 14px; background: white; border: 1.5px solid #e2e8f0; border-radius: 10px; margin-top: 8px; cursor: pointer; transition: 0.2s; gap: 10px; }
        .quiz-option:hover { background: #f1f5f9; border-color: #1e2f7a; }
        .quiz-option input[type="radio"] { accent-color: #1e2f7a; width: 16px; height: 16px; flex-shrink: 0; }
        .quiz-option label { font-size: 0.9rem; color: #334155; cursor: pointer; }

        .quiz-modal-footer { padding: 16px 28px 24px; border-top: 1px solid #e2e8f0; flex-shrink: 0; background: white; }
        .finalize-btn { width: 100%; padding: 14px; background: linear-gradient(135deg, #1e2f7a, #283593); color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.25s; box-shadow: 0 4px 15px rgba(30,47,122,0.3); font-family: 'Afacad', sans-serif; }
        .finalize-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(30,47,122,0.4); }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .hamburger-btn { display: block; }
            .scroll-container { padding: 14px; }
            .main-header { padding: 12px 16px; position: sticky; top: 0; z-index: 100; display: flex; flex-direction: row; justify-content: space-between; align-items: center; flex-wrap: nowrap; }
            .main-header > div:first-child { display: flex; align-items: center; gap: 10px; min-width: 0; flex: 1; }
            .main-header h1 { font-size: 1.05rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
            .header-user { flex-shrink: 0; padding: 6px 10px; }
            .header-user span { display: none; }
            .header-user i { font-size: 1.4rem; }
            .secondary-grid { grid-template-columns: 1fr; gap: 14px; }
            .quiz-card { padding: 20px; border-radius: 16px; }
            .quiz-feat-header { flex-direction: column; gap: 12px; }
            .quiz-modal-header { padding: 20px; }
            .quiz-modal-body { padding: 16px; }
            .quiz-modal-footer { padding: 12px 20px 20px; }
            .quiz-summary-bar { flex-direction: column; align-items: flex-start; gap: 6px; }
            .small-card-top { flex-direction: column; align-items: flex-start; }
            .card-footer { flex-direction: column; align-items: flex-start; gap: 10px; }
            .take-quiz-btn { width: 100%; justify-content: center; }
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
            <a href="{{ route('jhs.assignments') }}" class="nav-item"><i class="fas fa-tasks"></i> Assignments</a>
            <a href="{{ route('jhs.quizzes') }}" class="nav-item active"><i class="fas fa-edit"></i> Quizzes</a>
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
            <h1>My Quizzes</h1>
        </div>
        <a href="{{ route('jhs.profile') }}" class="header-user">
            <i class="fas fa-user-circle"></i>
            <span>{{ session('jhs_student_name') }}</span>
        </a>
    </header>

    <div class="scroll-container">

        {{-- Summary bar --}}
        <div class="quiz-summary-bar">
            <div class="quiz-summary-left">
                <i class="fas fa-edit"></i>
                <span><strong>3</strong> upcoming quizzes</span>
            </div>
            <span class="quiz-summary-right">
                <i class="fas fa-clock"></i> Review your notes before taking a quiz
            </span>
        </div>

        {{-- Featured quiz --}}
        <article class="quiz-card featured">
            <div class="quiz-feat-decoration"></div>
            <div class="quiz-feat-header">
                <div class="quiz-feat-icon science-bg">
                    <i class="fas fa-flask"></i>
                </div>
                <div class="quiz-feat-title">
                    <span class="quiz-tag tag-science"><i class="fas fa-flask"></i> Science</span>
                    <h2>Science: Unit 3 Periodic Table</h2>
                    <div class="quiz-meta-row">
                        <span class="quiz-due due-urgent"><i class="fas fa-clock"></i> Due: March 10, 2026</span>
                        <span class="quiz-duration"><i class="fas fa-hourglass-half"></i> 30 mins</span>
                    </div>
                </div>
            </div>
            <p class="body-text">This quiz is hosted on Google Forms. Click the link below to open it. Your grade will be imported automatically after completion.</p>
            <a href="https://forms.google.com" target="_blank" class="quiz-link">
                <div class="quiz-link-icon"><i class="fab fa-google-drive"></i></div>
                <div class="attachment-text">
                    <span>External Quiz (G-Form)</span>
                    <small>Science_Quiz_Unit3</small>
                </div>
                <i class="fas fa-external-link-alt attach-arrow"></i>
            </a>
        </article>

        {{-- Small cards --}}
        <div class="secondary-grid">

            <article class="quiz-card small accent-blue">
                <div class="small-card-top">
                    <span class="quiz-tag tag-math"><i class="fas fa-calculator"></i> Mathematics</span>
                    <span class="quiz-due due-normal"><i class="fas fa-clock"></i> Due: March 12, 2026</span>
                </div>
                <h3>Geometry: Angles &amp; Shapes</h3>
                <p class="body-text">Topic: Geometry (Angles and Shapes). Built-in quiz with instant grading.</p>
                <div class="card-footer">
                    <span class="quiz-duration-sm"><i class="fas fa-hourglass-half"></i> 30 mins</span>
                    <button class="take-quiz-btn" onclick="confirmQuiz('Mathematics')">
                        <i class="fas fa-pencil-alt"></i> Take Quiz
                    </button>
                </div>
            </article>

            <article class="quiz-card small accent-purple">
                <div class="small-card-top">
                    <span class="quiz-tag tag-english"><i class="fas fa-book"></i> English</span>
                    <span class="quiz-due due-normal"><i class="fas fa-clock"></i> Due: March 15, 2026</span>
                </div>
                <h3>Grammar: Subject-Verb Agreement</h3>
                <p class="body-text">Topic: Grammar (Subject-Verb Agreement). Answer directly on this page.</p>
                <div class="card-footer">
                    <span class="quiz-duration-sm"><i class="fas fa-hourglass-half"></i> 30 mins</span>
                    <button class="take-quiz-btn" onclick="confirmQuiz('English')">
                        <i class="fas fa-pencil-alt"></i> Take Quiz
                    </button>
                </div>
            </article>

        </div>
    </div>
</main>

{{-- Ready Confirmation Modal --}}
<div class="ready-modal-overlay" id="readyModal">
    <div class="ready-modal-content">
        <div class="ready-modal-icon">
            <i class="fas fa-pencil-alt"></i>
        </div>
        <h2>Ready to take the quiz?</h2>
        <p id="ready-modal-subject" class="ready-subject-name"></p>
        <div class="ready-modal-info">
            <div class="ready-info-item"><i class="fas fa-hourglass-half"></i><span>30 minutes</span></div>
            <div class="ready-info-item"><i class="fas fa-question-circle"></i><span>2 questions</span></div>
            <div class="ready-info-item"><i class="fas fa-exclamation-triangle"></i><span>Cannot pause once started</span></div>
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

{{-- Quiz Modal --}}
<div class="quiz-modal-overlay" id="quizModal">
    <div class="quiz-modal-content">
        <div class="quiz-modal-header">
            <div class="quiz-modal-header-inner">
                <div class="quiz-modal-icon"><i class="fas fa-pencil-alt"></i></div>
                <div>
                    <h2 id="quiz-title">Subject Quiz</h2>
                    <p><span class="quiz-active-label"><i class="fas fa-circle"></i> Active Quiz</span></p>
                </div>
            </div>
            <div class="quiz-header-right">
                <span id="quiz-timer"></span>
                <button class="quiz-close-btn" onclick="closeQuizModal()" aria-label="Exit quiz">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="quiz-modal-body">
            <div class="quiz-instructions-box">
                <i class="fas fa-info-circle"></i>
                <span>Select the best answer for each question. You cannot go back once submitted.</span>
            </div>
            <div id="quiz-questions"></div>
        </div>
        <div class="quiz-modal-footer">
            <button class="finalize-btn" onclick="gradeQuiz()">
                <i class="fas fa-paper-plane"></i> Submit Quiz &amp; See Score
            </button>
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
    <a href="{{ route('jhs.assignments') }}" class="nav-item"><i class="fas fa-tasks"></i> Assignments</a>
    <a href="{{ route('jhs.quizzes') }}" class="nav-item active"><i class="fas fa-edit"></i> Quizzes</a>
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
var quizData = {
    'Mathematics': [
        { q: "What is the sum of the angles in a triangle?",      options: ["90°", "180°", "360°", "270°"],              correct: 1 },
        { q: "A square has a side of 5cm. What is its area?",     options: ["10 sq cm", "20 sq cm", "25 sq cm", "50 sq cm"], correct: 2 }
    ],
    'English': [
        { q: "Which of the following is a noun?",                              options: ["Run", "Beautiful", "Apple", "Quickly"],   correct: 2 },
        { q: "Choose the correct verb: She ___ to school every day.",          options: ["Go", "Goes", "Going", "Gone"],            correct: 1 }
    ]
};

var currentSubject = '';
var timerInterval;
var timeLeft = 1800;

var quizModal  = document.getElementById('quizModal');
var readyModal = document.getElementById('readyModal');

function confirmQuiz(subject) {
    currentSubject = subject;
    document.getElementById('ready-modal-subject').textContent = subject + ' Quiz';
    document.getElementById('readyStartBtn').onclick = function () {
        closeReadyModal();
        startQuiz(subject);
    };
    readyModal.classList.add('active');
    document.body.classList.add('quiz-open');
}

function closeReadyModal() {
    readyModal.classList.remove('active');
    document.body.classList.remove('quiz-open');
}

readyModal.addEventListener('click', function (e) {
    if (e.target === readyModal) closeReadyModal();
});

function openQuizModal() {
    quizModal.classList.add('active');
    document.body.classList.add('quiz-open');
}

function closeQuizModal() {
    if (!confirm('Are you sure you want to exit? Your progress may not be saved.')) return;
    clearInterval(timerInterval);
    quizModal.classList.remove('active');
    document.body.classList.remove('quiz-open');
}

quizModal.addEventListener('click', function (e) {
    if (e.target === quizModal) closeQuizModal();
});

function startQuiz(subject) {
    currentSubject = subject;
    var questionArea = document.getElementById('quiz-questions');
    document.getElementById('quiz-title').textContent = subject + ' Quiz';
    questionArea.innerHTML = '';

    resetTimer();
    startTimer();

    quizData[subject].forEach(function (item, index) {
        var optionsHTML = item.options.map(function (opt, i) {
            return '<div class="quiz-option">' +
                '<input type="radio" name="q' + index + '" value="' + i + '" id="q' + index + 'o' + i + '">' +
                '<label for="q' + index + 'o' + i + '">' + opt + '</label>' +
                '</div>';
        }).join('');

        questionArea.innerHTML += '<div class="quiz-q-box">' +
            '<p>Question ' + (index + 1) + ': ' + item.q + '</p>' +
            optionsHTML +
            '</div>';
    });

    openQuizModal();
}

function startTimer() {
    var timerDisplay = document.getElementById('quiz-timer');
    timerInterval = setInterval(function () {
        timeLeft--;
        var minutes = Math.floor(timeLeft / 60);
        var seconds = timeLeft % 60;
        timerDisplay.innerHTML = '<i class="fas fa-hourglass-half"></i> ' + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
        if (timeLeft <= 0) {
            clearInterval(timerInterval);
            alert('Time is up! Your quiz will be submitted automatically.');
            gradeQuiz();
        }
    }, 1000);
}

function resetTimer() {
    clearInterval(timerInterval);
    timeLeft = 1800;
}

function gradeQuiz() {
    clearInterval(timerInterval);
    var score = 0;
    var total = quizData[currentSubject].length;
    quizData[currentSubject].forEach(function (item, index) {
        var selected = document.querySelector('input[name="q' + index + '"]:checked');
        if (selected && parseInt(selected.value) === item.correct) score++;
    });
    alert('Quiz Submitted Successfully!\n\nSubject: ' + currentSubject + '\nScore: ' + score + ' / ' + total);
    quizModal.classList.remove('active');
    document.body.classList.remove('quiz-open');
}

document.addEventListener('DOMContentLoaded', function () {
    var hamburgerBtn = document.getElementById('hamburger-btn');
    var drawer       = document.getElementById('mobile-nav-drawer');
    var overlay      = document.getElementById('mobile-nav-overlay');
    var closeBtn     = document.getElementById('mobile-nav-close');
    function openDrawer()  { drawer.classList.add('open');    overlay.classList.add('open');    document.body.style.overflow = 'hidden'; }
    function closeDrawer() { drawer.classList.remove('open'); overlay.classList.remove('open'); document.body.style.overflow = ''; }
    if (hamburgerBtn) hamburgerBtn.addEventListener('click', openDrawer);
    if (closeBtn)     closeBtn.addEventListener('click', closeDrawer);
    if (overlay)      overlay.addEventListener('click', closeDrawer);
});
</script>

</body>
</html>
