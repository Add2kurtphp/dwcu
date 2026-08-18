<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Faculty;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $faculty = Faculty::findOrFail(session('faculty_id'));

        $students = Student::orderBy('grade_level')->orderBy('name')->get()
            ->filter(fn ($s) => $faculty->canAccessStudent($s))
            ->values();

        $gradeRows = Grade::whereIn('student_id', $students->pluck('id'))
            ->where('school_year', GradeController::SCHOOL_YEAR)
            ->get()
            ->groupBy('student_id');

        $subjectGrades = [];
        $allSubjects   = [];
        foreach ($students as $s) {
            $subjects = Grade::subjectsFor($s);
            $allSubjects = array_merge($allSubjects, $subjects);

            $bySubject = $gradeRows->get($s->id, collect())->groupBy('subject');
            $subjectGrades[$s->id] = [];
            foreach ($subjects as $subject) {
                $values = $bySubject->get($subject, collect())->pluck('grade')->filter(fn ($v) => $v !== null);
                $subjectGrades[$s->id][$subject] = $values->count() ? round($values->avg()) : null;
            }
        }
        $allSubjects = array_values(array_unique($allSubjects));

        return view('faculty.students', compact('students', 'subjectGrades', 'allSubjects'));
    }

    public function update(Request $request, Student $student)
    {
        $faculty = Faculty::findOrFail(session('faculty_id'));
        abort_unless($faculty->canAccessStudent($student), 403);

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email',
            'grade_level' => 'required|string',
            'section'     => 'required|string|max:255',
        ]);

        $student->update($request->only('name', 'email', 'grade_level', 'section'));

        AuditLog::record($faculty->name, "Updated student details for {$student->name}", 'faculty', 'Student', "{$student->grade_level} - {$student->section}");

        return response()->json(['success' => true, 'student' => $student]);
    }
}
