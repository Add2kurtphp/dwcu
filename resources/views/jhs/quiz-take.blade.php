<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quiz->title }} | DWCU Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Afacad:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css'])
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Afacad', sans-serif; }
        body { background:#f0f4f8; color:#1e293b; min-height:100vh; }
        .wrap { max-width:720px; margin:0 auto; padding:40px 24px; }

        .back-link { display:inline-flex; align-items:center; gap:6px; color:#1e2f7a; font-weight:700; text-decoration:none; font-size:0.9rem; margin-bottom:18px; }
        .back-link:hover { text-decoration:underline; }

        .quiz-header { margin-bottom:24px; }
        .quiz-header h1 { color:#1e2f7a; font-size:1.5rem; margin-bottom:4px; }
        .quiz-header p { color:#64748b; font-size:0.9rem; }

        .q-card { background:white; border-radius:16px; padding:22px 26px; margin-bottom:16px; box-shadow:0 4px 20px rgba(0,0,0,0.05); border:1px solid #f1f5f9; }
        .q-card p.q-text { font-weight:700; color:#1e2f7a; margin-bottom:14px; }

        .choice-row { display:flex; align-items:center; gap:10px; padding:10px 12px; border:1.5px solid #e2e8f0; border-radius:10px; margin-bottom:8px; cursor:pointer; transition:border-color 0.2s, background 0.2s; }
        .choice-row:hover { border-color:#1e2f7a; background:#f8f9ff; }
        .choice-row input { width:16px; height:16px; accent-color:#1e2f7a; }

        .short-answer-input { width:100%; padding:12px; border:1.5px solid #e2e8f0; border-radius:10px; font-family:'Afacad',sans-serif; font-size:0.95rem; }

        .submit-bar { display:flex; justify-content:flex-end; margin-top:20px; }
        .btn-submit { background:#1e2f7a; color:white; border:none; padding:13px 30px; border-radius:12px; font-weight:700; font-size:1rem; cursor:pointer; font-family:'Afacad',sans-serif; }
        .btn-submit:hover { background:#2a3f9d; }
    </style>
</head>
<body>
<div class="wrap">
    <a href="{{ route('jhs.quizzes') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to Quizzes</a>

    <div class="quiz-header">
        <h1>{{ $quiz->title }}</h1>
        <p>{{ $quiz->subject }} — {{ $quiz->questions->count() }} questions — answer everything before submitting, you cannot edit after.</p>
    </div>

    <form method="POST" action="{{ route('jhs.quizzes.submit', $quiz) }}">
        @csrf
        @foreach ($quiz->questions as $question)
            <div class="q-card">
                <p class="q-text">{{ $loop->iteration }}. {{ $question->question_text }}</p>

                @if ($question->type === 'multiple_choice')
                    @foreach ($question->choices as $i => $choice)
                        <label class="choice-row">
                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $i }}" required>
                            <span>{{ $choice }}</span>
                        </label>
                    @endforeach
                @else
                    <input type="text" class="short-answer-input" name="answers[{{ $question->id }}]" placeholder="Type your answer..." required>
                @endif
            </div>
        @endforeach

        <div class="submit-bar">
            <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Submit Quiz</button>
        </div>
    </form>
</div>
</body>
</html>
