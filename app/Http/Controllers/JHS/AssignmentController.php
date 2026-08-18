<?php

namespace App\Http\Controllers\JHS;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\AuditLog;
use App\Models\Student;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $studentId = session('jhs_student_id');

        $assignments = Assignment::where('audience', 'jhs')->orderBy('due_date')->get();
        $submissions = AssignmentSubmission::where('student_id', $studentId)
            ->whereIn('assignment_id', $assignments->pluck('id'))
            ->get()
            ->keyBy('assignment_id');

        return view('jhs.assignments', compact('assignments', 'submissions'));
    }

    public function submit(Request $request, Assignment $assignment)
    {
        abort_unless($assignment->audience === 'jhs', 404);

        $request->validate([
            'file'     => 'required|file|max:25600|mimes:jpg,jpeg,png,pdf,docx,doc',
            'comments' => 'nullable|string|max:2000',
        ]);

        $studentId = session('jhs_student_id');
        $student   = Student::findOrFail($studentId);

        $path = $request->file('file')->store('assignment_submissions', 'public');

        $submission = AssignmentSubmission::updateOrCreate(
            ['assignment_id' => $assignment->id, 'student_id' => $studentId],
            [
                'file_path'    => $path,
                'file_name'    => $request->file('file')->getClientOriginalName(),
                'file_size'    => $request->file('file')->getSize(),
                'comments'     => $request->comments,
                'submitted_at' => now(),
            ]
        );

        AuditLog::record($student->name, "Submitted assignment — {$assignment->title}", 'jhs', 'Assignment', $assignment->subject);

        return response()->json([
            'success'    => true,
            'submission' => [
                'assignment_id' => $submission->assignment_id,
                'file_name'     => $submission->file_name,
                'submitted_at'  => $submission->submitted_at->toDateTimeString(),
            ],
        ]);
    }
}
