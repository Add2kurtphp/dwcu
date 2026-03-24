<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | DWCU Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="dashboard-wrapper">
        <aside class="sidebar-container">
            <div class="sidebar-top-branding">
                <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo"
                     class="school-logo-img" style="display:block;margin:0 auto 15px;">
                <div class="school-title-text">
                    DIVINE WORD COLLEGE <br>OF URDANETA
                </div>
                <div class="portal-identity">Administrative Portal</div>
            </div>

            <nav class="nav-links-list">
                <a href="{{ route('admin.dashboard') }}" class="nav-link-item active">
                    <i class="fas fa-th-large"></i> Overview
                </a>
                <a href="{{ route('admin.faculty') }}" class="nav-link-item">
                    <i class="fas fa-chalkboard-teacher"></i> Faculty Management
                </a>
                <a href="{{ route('admin.students') }}" class="nav-link-item">
                    <i class="fas fa-user-graduate"></i> Student Records
                </a>
                <a href="{{ route('admin.announcements') }}" class="nav-link-item">
                    <i class="fas fa-bullhorn"></i> Global Announcements
                </a>
                <a href="{{ route('admin.logs') }}" class="nav-link-item">
                    <i class="fas fa-history"></i> System Audit Logs
                </a>
                <a href="{{ route('admin.settings') }}" class="nav-link-item">
                    <i class="fas fa-cog"></i> System Settings
                </a>
            </nav>

            <div class="sidebar-footer-action">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="exit-system-link"
                            style="background:none;border:none;cursor:pointer;width:100%;">
                        <i class="fas fa-sign-out-alt"></i> Log out
                    </button>
                </form>
            </div>
        </aside>

        <main class="main-viewport-content">
            <header class="top-nav-bar">
                <button class="hamburger-btn" id="hamburger-btn" aria-label="Open menu">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="header-title">
                    <h1 style="font-size:1.6rem;font-weight:800;color:#0d1b44;margin:0 0 2px;">Dashboard Overview</h1>
                    <p id="dashboard-date" style="font-size:0.85rem;color:#8892b0;margin:0;">
                        Welcome back, {{ Auth::user()->name }}!
                    </p>
                </div>
                <a href="{{ route('admin.profile') }}" style="text-decoration:none;color:inherit;">
                    <div class="user-quick-profile">
                        <div class="profile-info">
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <span class="user-role">System Administrator</span>
                        </div>
                        <div class="profile-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                    </div>
                </a>
            </header>

            <div class="admin-content-grid">

                {{-- ── STAT CARDS (4-up) ── --}}
                <section class="stats-row stats-row-4">

                    <div class="stat-card stat-card-blue">
                        <div class="stat-icon-wrap">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="stat-details">
                            <span class="stat-label">Total Faculty</span>
                            <div class="stat-number">{{ $totalFaculty }}</div>
                            <span class="stat-trend">
                                <i class="fas fa-users"></i> Active staff members
                            </span>
                        </div>
                    </div>

                    <div class="stat-card stat-card-green">
                        <div class="stat-icon-wrap">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-details">
                            <span class="stat-label">Total Students</span>
                            <div class="stat-number">{{ $totalStudents }}</div>
                            <span class="stat-trend">
                                <i class="fas fa-database" style="opacity:.6;margin-right:3px;"></i>
                                {{ $activeStudents }} active &nbsp;·&nbsp; {{ $droppedStudents }} dropped
                            </span>
                        </div>
                    </div>

                    <div class="stat-card stat-card-teal">
                        <div class="stat-icon-wrap">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="stat-details">
                            <span class="stat-label">Active Students</span>
                            <div class="stat-number">{{ $activeStudents }}</div>
                            <span class="stat-trend">
                                <i class="fas fa-check-circle trend-up" style="margin-right:3px;"></i>
                                JHS: {{ $jhsStudents }} &nbsp;|&nbsp; SHS: {{ $shsStudents }}
                            </span>
                        </div>
                    </div>

                    <div class="stat-card stat-card-red">
                        <div class="stat-icon-wrap">
                            <i class="fas fa-user-slash"></i>
                        </div>
                        <div class="stat-details">
                            <span class="stat-label">Dropped Students</span>
                            <div class="stat-number">{{ $droppedStudents }}</div>
                            <span class="stat-trend">
                                @if($droppedStudents === 0)
                                    <i class="fas fa-check-circle trend-up" style="margin-right:3px;"></i>No dropped students
                                @else
                                    <i class="fas fa-exclamation-circle" style="margin-right:3px;color:#e57373;"></i>
                                    {{ $droppedStudents }} student{{ $droppedStudents > 1 ? 's' : '' }} this term
                                @endif
                            </span>
                        </div>
                    </div>

                </section>

                {{-- ── ENROLLMENT BREAKDOWN ── --}}
                <div class="management-section-card">
                    <div class="card-header">
                        <div class="card-title-group">
                            <h3><i class="fas fa-layer-group card-title-icon"></i> Enrollment by Level</h3>
                            <p class="sub-portal-text" style="color:#8892b0;font-size:0.85rem;margin:4px 0 0;">
                                Active students per grade level.
                            </p>
                        </div>
                        <a href="{{ route('admin.students') }}" class="view-log-btn-wrapper">
                            <button class="view-all-btn">View All</button>
                        </a>
                    </div>

                    <div class="enrollment-two-col">

                        {{-- JHS --}}
                        <div class="level-section">
                            <div class="level-header">
                                <span class="level-badge level-jhs">JHS</span>
                                <span class="level-count">{{ $jhsStudents }}</span>
                                <span class="level-sub">Grades 7 – 10</span>
                            </div>
                            @foreach([7, 8, 9, 10] as $grade)
                                @php
                                    $count = $gradeBreakdown['Grade '.$grade] ?? 0;
                                    $pct   = $jhsStudents > 0 ? (int) round(($count / $jhsStudents) * 100) : 0;
                                @endphp
                                @if($count > 0)
                                <div class="grade-bar-row">
                                    <span class="grade-bar-label">Grade {{ $grade }}</span>
                                    <div class="grade-bar-track">
                                        <div class="grade-bar-fill" data-width="{{ $pct }}"></div>
                                    </div>
                                    <span class="grade-bar-count">{{ $count }}</span>
                                </div>
                                @endif
                            @endforeach
                        </div>

                        {{-- SHS --}}
                        <div class="level-section">
                            <div class="level-header">
                                <span class="level-badge level-shs">SHS</span>
                                <span class="level-count">{{ $shsStudents }}</span>
                                <span class="level-sub">Grades 11 – 12</span>
                            </div>
                            @foreach([11, 12] as $grade)
                                @php
                                    $count = $gradeBreakdown['Grade '.$grade] ?? 0;
                                    $pct   = $shsStudents > 0 ? (int) round(($count / $shsStudents) * 100) : 0;
                                @endphp
                                @if($count > 0)
                                <div class="grade-bar-row">
                                    <span class="grade-bar-label">Grade {{ $grade }}</span>
                                    <div class="grade-bar-track">
                                        <div class="grade-bar-fill shs-fill" data-width="{{ $pct }}"></div>
                                    </div>
                                    <span class="grade-bar-count">{{ $count }}</span>
                                </div>
                                @endif
                            @endforeach
                        </div>

                    </div>
                </div>

                {{-- ── RECENT PORTAL ACTIVITY ── --}}
                <section class="management-section-card">
                    <div class="card-header">
                        <div class="card-title-group">
                            <h3><i class="fas fa-clock card-title-icon"></i> Recent Portal Activity</h3>
                            <p class="sub-portal-text" style="color:#8892b0;font-size:0.85rem;margin:4px 0 0;">
                                Latest interactions within the JHS &amp; SHS departments.
                            </p>
                        </div>
                        <a href="{{ route('admin.logs') }}" class="view-log-btn-wrapper">
                            <button class="view-all-btn">View Full Log</button>
                        </a>
                    </div>

                    <div class="placeholder-table-area">
                        <table class="activity-table" style="min-width:480px;">
                            <thead>
                                <tr>
                                    <th>Administrator</th>
                                    <th>Module</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentLogs as $log)
                                    @php $mod = strtolower($log->module); @endphp
                                    <tr>
                                        <td><strong>{{ $log->admin_name }}</strong></td>
                                        <td><span class="dept-tag {{ $mod }}">{{ $log->module }}</span></td>
                                        <td>{{ $log->action }}</td>
                                        <td><span class="status-pill {{ $log->status }}">{{ ucfirst($log->status) }}</span></td>
                                        <td style="white-space:nowrap;color:#64748b;font-size:0.8rem;">
                                            {{ $log->created_at->format('M d, h:i A') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align:center;padding:30px;color:#8892b0;font-size:0.9rem;">
                                            No recent activity found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>
        </main>
    </div>

    {{-- Mobile nav overlay + drawer --}}
    <div class="mobile-nav-overlay" id="mobile-nav-overlay"></div>
    <div class="mobile-nav-drawer" id="mobile-nav-drawer">
        <button class="mobile-nav-close" id="mobile-nav-close" aria-label="Close menu">
            <i class="fas fa-times"></i>
        </button>
        <div class="mobile-brand">
            <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo"
                 style="width:70px;margin:0 auto 10px;display:block;">
            <p>DIVINE WORD COLLEGE<br>OF URDANETA</p>
            <span>Administrative Portal</span>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item active-drawer">
            <i class="fas fa-th-large"></i> Overview
        </a>
        <a href="{{ route('admin.faculty') }}" class="nav-item">
            <i class="fas fa-chalkboard-teacher"></i> Faculty Management
        </a>
        <a href="{{ route('admin.students') }}" class="nav-item">
            <i class="fas fa-user-graduate"></i> Student Records
        </a>
        <a href="{{ route('admin.announcements') }}" class="nav-item">
            <i class="fas fa-bullhorn"></i> Global Announcements
        </a>
        <a href="{{ route('admin.logs') }}" class="nav-item">
            <i class="fas fa-history"></i> System Audit Logs
        </a>
        <a href="{{ route('admin.settings') }}" class="nav-item">
            <i class="fas fa-cog"></i> System Settings
        </a>
        <div class="mobile-logout">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit"
                        style="background:none;border:none;cursor:pointer;color:#fca5a5;font-weight:600;padding:10px;width:100%;">
                    <i class="fas fa-sign-out-alt"></i> Log out
                </button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/admin.js') }}"></script>
    <script>
        // Live date in welcome text
        (function () {
            const el = document.getElementById('dashboard-date');
            if (!el) return;
            const opts = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            el.textContent = 'Welcome back, {{ Auth::user()->name }}! — ' +
                new Date().toLocaleDateString('en-US', opts);
        })();

        // Animate grade bars from data-width attribute
        requestAnimationFrame(function () {
            document.querySelectorAll('.grade-bar-fill[data-width]').forEach(function (el) {
                el.style.width = el.dataset.width + '%';
            });
        });
    </script>
</body>
</html>
