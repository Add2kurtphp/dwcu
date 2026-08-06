<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quiz->title }} — Submissions | DWCU Faculty Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    @vite(['resources/css/app.css'])
    <style>
        .school-logo-img { display: block !important; margin: 0 auto !important; }
        .portal-identity { color: #ccff00 !important; }
        .nav-link-item.active { background: #ccff00 !important; color: #0d1b44 !important; }

        .back-link { display:inline-flex; align-items:center; gap:6px; color:#1e2f7a; font-weight:700; text-decoration:none; font-size:0.9rem; margin-bottom:14px; }
        .back-link:hover { text-decoration:underline; }

        .quiz-meta { color:#64748b; font-size:0.9rem; margin:0 0 20px; }

        .table-card { background:white; border-radius:16px; border:1.5px solid #e0e4f0; box-shadow:0 4px 16px rgba(0,0,0,0.05); overflow:hidden; }
        .data-table { width:100%; border-collapse:collapse; }
        .data-table th { text-align:left; padding:14px 18px; color:#1e2f7a; font-weight:800; font-size:0.78rem; text-transform:uppercase; letter-spacing:0.5px; border-bottom:2px solid #e0e4f0; background:#f8f9ff; }
        .data-table td { padding:14px 18px; border-bottom:1px solid #f0f2f8; font-size:0.92rem; color:#2d3a5e; }
        .data-table tr:last-child td { border-bottom:none; }

        .badge-none     { display:inline-block; padding:3px 12px; border-radius:20px; font-weight:700; font-size:0.78rem; background:#f1f5f9; color:#64748b; }
        .badge-pending  { display:inline-block; padding:3px 12px; border-radius:20px; font-weight:700; font-size:0.78rem; background:#fff3cd; color:#92640a; }
        .badge-graded   { display:inline-block; padding:3px 12px; border-radius:20px; font-weight:700; font-size:0.78rem; background:#dcfce7; color:#15803d; }

        .btn-grade { background:#1e2f7a; color:white; padding:7px 16px; border-radius:8px; font-weight:600; font-size:0.82rem; text-decoration:none; font-family:'Afacad',sans-serif; }
        .btn-grade:hover { background:#2a3f9d; }

        .alert-success { background:#dcfce7; color:#15803d; padding:12px 18px; border-radius:10px; font-weight:600; margin-bottom:16px; }
    </style>
</head>
<body>
<div class="dashboard-wrapper">
    <aside class="sidebar-container">
        <div class="sidebar-top-branding">
            <img src="{{ asset('image/logo-transparent.png') }}" alt="DWCU Logo" class="school-logo-img">
            <div class="school-title-text">DIVINE WORD COLLEGE <br> OF URDANETA</div>
            <div class="portal-identity">Faculty Portal</div>
        </div>
        <nav class="nav-links-list">
            <a href="{{ route('faculty.students') }}"      class="nav-link-item"><i class="fas fa-users"></i> Student List</a>
            <a href="{{ route('faculty.calendar') }}"      class="nav-link-item"><i class="fas fa-calendar-alt"></i> Calendar</a>
            <a href="{{ route('faculty.gradebook') }}"     class="nav-link-item active"><i class="fas fa-book-open"></i> Gradebook</a>
            <a href="{{ route('faculty.announcements') }}" class="nav-link-item"><i class="fas fa-bullhorn"></i> Announcement</a>
            <a href="{{ route('faculty.logs') }}"          class="nav-link-item"><i class="fas fa-history"></i> Activity Logs</a>
        </nav>
        <div class="sidebar-footer-action">
            <form method="POST" action="{{ route('faculty.logout') }}">
                @csrf
                <button type="submit" class="exit-system-link" style="background:none;border:none;cursor:pointer;width:100%;">
                    <i class="fas fa-sign-out-alt"></i> Log out
                </button>
            </form>
        </div>
    </aside>

    <main class="main-viewport-content">
        <header class="top-nav-bar">
            <h1 style="font-size:1.6rem;font-weight:800;color:#0d1b44;margin:0;">Quiz Submissions</h1>
        </header>

        <div class="admin-content-grid">
            <a href="{{ route('faculty.gradebook') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to Gradebook</a>

            @if (session('success'))
                <div class="alert-success">{{ session('success') }}</div>
            @endif

            <h2 style="color:#0d1b44;margin:0 0 4px;">{{ $quiz->title }}</h2>
            <p class="quiz-meta">{{ $quiz->subject }} — {{ $quiz->grade_level }} {{ $quiz->section }} — {{ $quiz->questions_count ?? $quiz->questions()->count() }} questions</p>

            <div class="table-card">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Score</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                            @php $submission = $submissions->get($student->id); @endphp
                            <tr>
                                <td>{{ $student->student_id }}</td>
                                <td>{{ $student->name }}</td>
                                <td>
                                    @if (!$submission)
                                        <span class="badge-none">Not Submitted</span>
                                    @elseif ($submission->status === 'graded')
                                        <span class="badge-graded">Graded</span>
                                    @else
                                        <span class="badge-pending">Pending Grade</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($submission && $submission->status === 'graded')
                                        {{ $submission->total_score }} / {{ $submission->total_possible }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>
                                    @if ($submission)
                                        <a href="{{ route('faculty.submissions.show', $submission) }}" class="btn-grade">
                                            {{ $submission->status === 'graded' ? 'Re-grade' : 'Grade' }}
                                        </a>
                                    @else
                                        <span style="color:#94a3b8;font-size:0.85rem;">Waiting for submission</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align:center;color:#8892b0;padding:30px;">No students found for this section.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
</body>
</html>
