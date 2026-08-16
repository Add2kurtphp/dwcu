<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Faculty;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::where('faculty_id', session('faculty_id'))
            ->withCount([
                'submissions',
                'submissions as graded_count' => fn ($q) => $q->where('status', 'graded'),
            ])
            ->latest()
            ->get();

        return response()->json(['quizzes' => $quizzes]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'                             => 'required|string|max:255',
            'subject'                           => 'required|string|max:255',
            'grade_level'                       => 'required|string|max:255',
            'section'                           => 'required|string|max:255',
            'questions'                         => 'required|array|min:1',
            'questions.*.question_text'         => 'required|string',
            'questions.*.type'                  => 'required|in:multiple_choice,short_answer',
            'questions.*.choices'               => 'nullable|array',
            'questions.*.correct_choice_index'  => 'nullable|integer',
            'questions.*.correct_answer'        => 'nullable|string',
        ]);

        $quiz = DB::transaction(function () use ($request) {
            $quiz = Quiz::create([
                'faculty_id'  => session('faculty_id'),
                'title'       => $request->title,
                'subject'     => $request->subject,
                'grade_level' => $request->grade_level,
                'section'     => $request->section,
                'school_year' => '2025-2026',
            ]);

            foreach ($request->questions as $i => $q) {
                $quiz->questions()->create([
                    'question_text'        => $q['question_text'],
                    'type'                 => $q['type'],
                    'choices'              => $q['type'] === 'multiple_choice' ? ($q['choices'] ?? []) : null,
                    'correct_choice_index' => $q['type'] === 'multiple_choice' ? ($q['correct_choice_index'] ?? null) : null,
                    'correct_answer'       => $q['type'] === 'short_answer' ? ($q['correct_answer'] ?? null) : null,
                    'points'               => 10,
                    'order'                => $i,
                ]);
            }

            return $quiz;
        });

        $faculty = Faculty::find(session('faculty_id'));
        if ($faculty) {
            AuditLog::record($faculty->name, "Created quiz: {$quiz->title}", 'faculty', 'Grade', "{$quiz->grade_level} - {$quiz->section}");
        }

        return response()->json(['success' => true, 'quiz' => $quiz]);
    }
}
