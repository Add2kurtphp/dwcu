<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Faculty;
use App\Models\Quiz;
use App\Models\Student;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index(Quiz $quiz)
    {
        abort_unless($quiz->faculty_id == session('faculty_id'), 403);

        $students = Student::where('grade_level', $quiz->grade_level)
            ->where('section', $quiz->section)
            ->orderBy('name')
            ->get();

        $submissions = $quiz->submissions()->get()->keyBy('student_id');

        return view('faculty.quiz-submissions', compact('quiz', 'students', 'submissions'));
    }

    public function show(Submission $submission)
    {
        $submission->load(['quiz', 'student', 'answers.question']);
        abort_unless($submission->quiz->faculty_id == session('faculty_id'), 403);

        return view('faculty.grade-submission', compact('submission'));
    }

    public function grade(Request $request, Submission $submission)
    {
        $submission->load(['quiz', 'answers.question']);
        abort_unless($submission->quiz->faculty_id == session('faculty_id'), 403);

        $request->validate([
            'scores'   => 'required|array',
            'scores.*' => 'nullable|integer|min:0',
        ]);

        $total = 0;
        foreach ($submission->answers as $answer) {
            $max      = $answer->question->points;
            $score    = (int) ($request->scores[$answer->question_id] ?? 0);
            $score    = max(0, min($score, $max));
            $answer->update(['score_awarded' => $score]);
            $total += $score;
        }

        $submission->update([
            'status'      => 'graded',
            'total_score' => $total,
            'graded_at'   => now(),
            'graded_by'   => session('faculty_id'),
        ]);

        $faculty = Faculty::find(session('faculty_id'));
        if ($faculty) {
            AuditLog::record(
                $faculty->name,
                "Posted quiz score — {$submission->quiz->title} ({$submission->student->name}: {$total}/{$submission->total_possible})",
                'faculty',
                'Grade',
                "{$submission->quiz->grade_level} - {$submission->quiz->section}"
            );
        }

        return redirect()
            ->route('faculty.quizzes.submissions', $submission->quiz_id)
            ->with('success', "Grade saved for {$submission->student->name}.");
    }
}
