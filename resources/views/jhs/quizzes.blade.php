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
        body { display: flex; min-height: 100vh; background-color: var(--bg-light); color: var(--text-dark); }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 270px;
            background: linear-gradient(180deg, #162152 0%, #0d1535 100%);
            color: var(--white);
            display: flex; flex-direction: column; justify-content: space-between;
            padding: 20px; box-shadow: 4px 0 15px rgba(0,0,0,0.15); flex-shrink: 0;
        }
        .brand-section { text-align: center; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 18px; margin-bottom: 16px; }
        .school-logo { width: 75px; margin: 0 auto 10px; display: block; }
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
        .nav-item:hover { background: rgba(255,255,255,0.08); color: var(--white); }
        .nav-item.active { background: rgba(173,255,47,0.12); color: #adff2f; border: 1px solid rgba(173,255,47,0.2); }
        .sidebar-bottom { padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.08); }
        .logout-btn {
            display: flex; align-items: center; justify-content: center; gap: 10px;
            width: 100%; padding: 12px; border-radius: 10px; background: transparent;
            color: #fca5a5; border: none; cursor: pointer;
            font-weight: 600; font-size: 0.95rem; font-family: 'Afacad', sans-serif;
        }
        .logout-btn:hover { background: rgba(248,113,113,0.15); color: #fff; }

        /* ── CONTENT AREA ── */
        .content-area { flex: 1; display: flex; flex-direction: column; }
        .main-header {
            background: var(--white); padding: 18px 40px;
            display: flex; justify-content: space-between; align-items: center;
            border-bottom: 1px solid #e2e8f0; flex-shrink: 0;
        }
        .main-header h1 { font-size: 1.35rem; font-weight: 700; color: var(--primary-blue); }
        .header-user {
            display: flex; align-items: center; gap: 10px; padding: 8px 16px;
            border-radius: 50px; cursor: pointer; border: 1px solid transparent; text-decoration: none;
        }
        .header-user:hover { background-color: #f1f5f9; border-color: #e2e8f0; }
        .header-user i { font-size: 1.5rem; color: var(--primary-blue); }
        .header-user span { font-weight: 600; font-size: 0.9rem; color: var(--text-dark); }
        .scroll-container { padding: 30px 40px; flex: 1; }

        .hamburger-btn { display: none; background: none; border: none; color: var(--primary-blue); font-size: 1.6rem; cursor: pointer; padding: 4px 8px; }

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
        .mobile-nav-drawer .nav-item { display: flex; align-items: center; padding: 12px 15px; color: #94a3b8; text-decoration: none; border-radius: 10px; font-weight: 500; }
        .mobile-nav-drawer .nav-item i { margin-right: 12px; width: 18px; text-align: center; }
        .mobile-nav-drawer .nav-item:hover { background: rgba(255,255,255,0.08); color: white; }
        .mobile-logout { margin-top: auto; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.08); }

        /* ── ALERTS ── */
        .alert-success { background:#dcfce7; color:#15803d; padding:12px 18px; border-radius:10px; font-weight:600; margin-bottom:18px; }
        .alert-error   { background:#fee2e2; color:#b91c1c; padding:12px 18px; border-radius:10px; font-weight:600; margin-bottom:18px; }

        /* ── QUIZ LIST ── */
        .quiz-card {
            background: white; border-radius: 16px; padding: 22px 26px;
            box-shadow: var(--shadow); border: 1px solid #f1f5f9;
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 16px; flex-wrap: wrap; gap: 14px;
        }
        .quiz-card h3 { color: var(--primary-blue); font-size: 1.05rem; margin-bottom: 4px; }
        .quiz-card p { color: #64748b; font-size: 0.85rem; }

        .badge-available { display:inline-block; padding:4px 14px; border-radius:20px; font-weight:700; font-size:0.78rem; background:#dbeafe; color:#1d4ed8; }
        .badge-pending    { display:inline-block; padding:4px 14px; border-radius:20px; font-weight:700; font-size:0.78rem; background:#fff3cd; color:#92640a; }
        .badge-graded     { display:inline-block; padding:4px 14px; border-radius:20px; font-weight:700; font-size:0.78rem; background:#dcfce7; color:#15803d; }

        .btn-take { background:var(--primary-blue); color:white; padding:10px 22px; border-radius:10px; font-weight:700; text-decoration:none; font-size:0.9rem; }
        .btn-take:hover { background:#2a3f9d; }

        .empty-state { text-align:center; color:#94a3b8; padding:60px 20px; }
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
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @forelse ($quizzes as $quiz)
            @php $submission = $submissions->get($quiz->id); @endphp
            <div class="quiz-card">
                <div>
                    <h3>{{ $quiz->title }}</h3>
                    <p>{{ $quiz->subject }} — {{ $quiz->questions_count }} questions</p>
                </div>
                <div style="display:flex;align-items:center;gap:14px;">
                    @if (!$submission)
                        <span class="badge-available">Available</span>
                        <a href="{{ route('jhs.quizzes.take', $quiz) }}" class="btn-take">Take Quiz</a>
                    @elseif ($submission->status === 'graded')
                        <span class="badge-graded">Graded: {{ $submission->total_score }}/{{ $submission->total_possible }}</span>
                    @else
                        <span class="badge-pending">Submitted — Awaiting Grade</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-inbox" style="font-size:2.5rem;margin-bottom:12px;display:block;"></i>
                No quizzes available for your section yet.
            </div>
        @endforelse
    </div>
</main>

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
    document.addEventListener('DOMContentLoaded', function () {
        const hamburgerBtn = document.getElementById('hamburger-btn');
        const overlay      = document.getElementById('mobile-nav-overlay');
        const drawer       = document.getElementById('mobile-nav-drawer');
        const closeBtn     = document.getElementById('mobile-nav-close');
        const openDrawer   = () => { drawer.classList.add('open'); overlay.classList.add('open'); };
        const closeDrawer  = () => { drawer.classList.remove('open'); overlay.classList.remove('open'); };
        if (hamburgerBtn) hamburgerBtn.addEventListener('click', openDrawer);
        if (closeBtn)     closeBtn.addEventListener('click', closeDrawer);
        if (overlay)      overlay.addEventListener('click', closeDrawer);
    });
</script>
</body>
</html>
