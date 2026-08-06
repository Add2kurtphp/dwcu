<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Submission | DWCU Faculty Portal</title>
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

        .q-grade-card { background:white; padding:20px; border-radius:12px; margin-bottom:16px; border:1px solid #e0e6ed; border-left:5px solid #1e2f7a; box-shadow:0 4px 10px rgba(0,0,0,0.05); }
        .q-grade-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:12px; gap:12px; }
        .q-grade-header p { margin:0; font-weight:700; color:#1e2f7a; font-family:'Afacad',sans-serif; }
        .q-points { color:#64748b; font-size:0.8rem; font-weight:600; white-space:nowrap; }

        .mc-choice { display:flex; align-items:center; gap:8px; padding:8px 10px; border-radius:7px; margin-bottom:6px; font-size:0.9rem; }
        .mc-selected { background:#eef1fb; font-weight:600; }
        .mc-correct { color:#15803d; }
        .mc-incorrect { color:#dc2626; }

        .short-answer-box { background:#f8f9ff; border:1px solid #e0e4f0; border-radius:8px; padding:12px 14px; margin:8px 0; font-size:0.92rem; color:#2d3a5e; }
        .reference-answer { color:#64748b; font-size:0.82rem; margin-top:6px; }

        .score-input-row { display:flex; align-items:center; gap:8px; margin-top:10px; }
        .score-input-row input { width:70px; padding:8px; border:1.5px solid #cbd5e1; border-radius:8px; font-family:'Afacad',sans-serif; font-size:0.95rem; text-align:center; }
        .score-input-row span { color:#64748b; font-size:0.85rem; }

        .grade-footer { display:flex; justify-content:space-between; align-items:center; margin-top:24px; padding-top:20px; border-top:1px solid #e0e4f0; }
        .btn-save-grade { background:#1e2f7a; color:white; border:none; padding:12px 28px; border-radius:10px; font-weight:700; cursor:pointer; font-family:'Afacad',sans-serif; }
        .btn-save-grade:hover { background:#2a3f9d; }
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
            <h1 style="font-size:1.6rem;font-weight:800;color:#0d1b44;margin:0;">Grade Submission</h1>
        </header>

        <div class="admin-content-grid">
            <a href="{{ route('faculty.quizzes.submissions', $submission->quiz_id) }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Submissions
            </a>

            <h2 style="color:#0d1b44;margin:0 0 4px;">{{ $submission->quiz->title }}</h2>
            <p style="color:#64748b;font-size:0.9rem;margin:0 0 20px;">
                Student: <strong>{{ $submission->student->name }}</strong> ({{ $submission->student->student_id }})
                — Submitted {{ $submission->submitted_at->format('M j, Y g:i A') }}
            </p>

            <form method="POST" action="{{ route('faculty.submissions.grade', $submission) }}">
                @csrf

                @foreach ($submission->answers as $answer)
                    @php $question = $answer->question; @endphp
                    <div class="q-grade-card">
                        <div class="q-grade-header">
                            <p>{{ $loop->iteration }}. {{ $question->question_text }}</p>
                            <span class="q-points">{{ $question->points }} pts</span>
                        </div>

                        @if ($question->type === 'multiple_choice')
                            @foreach ($question->choices as $i => $choice)
                                <div class="mc-choice {{ $i === $answer->selected_choice_index ? 'mc-selected' : '' }}">
                                    <i class="fas {{ $i === $question->correct_choice_index ? 'fa-check mc-correct' : ($i === $answer->selected_choice_index ? 'fa-times mc-incorrect' : 'fa-circle-notch') }}" style="width:16px;"></i>
                                    <span>{{ $choice }}</span>
                                    @if ($i === $answer->selected_choice_index) <em style="margin-left:6px;color:#64748b;font-size:0.8rem;">(student's answer)</em> @endif
                                </div>
                            @endforeach
                            <div class="score-input-row">
                                <input type="number" name="scores[{{ $question->id }}]" min="0" max="{{ $question->points }}"
                                       value="{{ $answer->score_awarded ?? ($answer->is_correct ? $question->points : 0) }}">
                                <span>/ {{ $question->points }} (auto-graded, adjustable)</span>
                            </div>
                        @else
                            <div class="short-answer-box">{{ $answer->answer_text ?: '(no answer given)' }}</div>
                            @if ($question->correct_answer)
                                <p class="reference-answer">Reference answer: {{ $question->correct_answer }}</p>
                            @endif
                            <div class="score-input-row">
                                <input type="number" name="scores[{{ $question->id }}]" min="0" max="{{ $question->points }}"
                                       value="{{ $answer->score_awarded }}" required>
                                <span>/ {{ $question->points }} — enter points manually</span>
                            </div>
                        @endif
                    </div>
                @endforeach

                <div class="grade-footer">
                    <span style="color:#64748b;font-weight:600;">Total possible: {{ $submission->total_possible }} pts</span>
                    <button type="submit" class="btn-save-grade"><i class="fas fa-check"></i> Save Grade</button>
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html>
