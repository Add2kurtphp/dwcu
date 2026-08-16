<?php

namespace App\Http\Controllers\SHS;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Quiz;
use App\Models\Student;
use App\Models\Submission;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $student = Student::findOrFail(session('shs_student_id'));

        $quizzes = Quiz::where('grade_level', $student->grade_level)
            ->where('section', $student->section)
            ->withCount('questions')
            ->latest()
            ->get();

        $submissions = Submission::where('student_id', $student->id)
            ->whereIn('quiz_id', $quizzes->pluck('id'))
            ->get()
            ->keyBy('quiz_id');

        return view('shs.quizzes', compact('quizzes', 'submissions'));
    }

    public function show(Quiz $quiz)
    {
        $student = Student::findOrFail(session('shs_student_id'));
        abort_unless($quiz->grade_level === $student->grade_level && $quiz->section === $student->section, 403);

        $existing = Submission::where('quiz_id', $quiz->id)->where('student_id', $student->id)->first();
        if ($existing) {
            return redirect()->route('shs.quizzes')->with('error', 'You already submitted this quiz.');
        }

        $quiz->load('questions');

        return view('shs.quiz-take', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $student = Student::findOrFail(session('shs_student_id'));
        abort_unless($quiz->grade_level === $student->grade_level && $quiz->section === $student->section, 403);

        if (Submission::where('quiz_id', $quiz->id)->where('student_id', $student->id)->exists()) {
            return redirect()->route('shs.quizzes')->with('error', 'You already submitted this quiz.');
        }

        $request->validate(['answers' => 'required|array']);

        $quiz->load('questions');
        $totalPossible = $quiz->questions->sum('points');

        $submission = Submission::create([
            'quiz_id'        => $quiz->id,
            'student_id'     => $student->id,
            'status'         => 'submitted',
            'total_possible' => $totalPossible,
            'submitted_at'   => now(),
        ]);

        foreach ($quiz->questions as $question) {
            $given = $request->answers[$question->id] ?? null;

            if ($question->type === 'multiple_choice') {
                $selected  = $given !== null ? (int) $given : null;
                $isCorrect = $selected !== null && $selected === $question->correct_choice_index;

                $submission->answers()->create([
                    'question_id'           => $question->id,
                    'selected_choice_index' => $selected,
                    'is_correct'            => $isCorrect,
                    'score_awarded'         => $isCorrect ? $question->points : 0,
                ]);
            } else {
                $submission->answers()->create([
                    'question_id'   => $question->id,
                    'answer_text'   => $given,
                    'score_awarded' => null,
                ]);
            }
        }

        AuditLog::record($student->name, "Submitted quiz: {$quiz->title}", 'shs', 'Academic', $quiz->subject);

        return redirect()->route('shs.quizzes')->with('success', 'Quiz submitted! Your teacher will finalize your grade.');
    }
}
