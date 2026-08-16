<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Faculty;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    const SCHOOL_YEAR = '2025-2026';

    public function show(Student $student)
    {
        $this->authorizeAccess($student);

        return response()->json($this->buildGrid($student));
    }

    public function update(Request $request, Student $student)
    {
        $this->authorizeAccess($student);

        $request->validate([
            'grades'             => 'required|array',
            'grades.*.subject'   => 'required|string',
            'grades.*.quarter'   => 'required|integer|min:1|max:4',
            'grades.*.grade'     => 'nullable|integer|min:0|max:100',
        ]);

        foreach ($request->grades as $g) {
            $key = [
                'student_id'  => $student->id,
                'school_year' => self::SCHOOL_YEAR,
                'subject'     => $g['subject'],
                'quarter'     => $g['quarter'],
            ];

            if ($g['grade'] === null || $g['grade'] === '') {
                Grade::where($key)->delete();
                continue;
            }

            Grade::updateOrCreate($key, [
                'grade'   => $g['grade'],
                'remarks' => $g['grade'] >= 75 ? 'Passed' : 'Failed',
            ]);
        }

        $faculty = Faculty::find(session('faculty_id'));
        if ($faculty) {
            AuditLog::record($faculty->name, "Updated grades for {$student->name}", 'faculty', 'Grade', "{$student->grade_level} - {$student->section}");
        }

        return response()->json($this->buildGrid($student));
    }

    private function authorizeAccess(Student $student): void
    {
        $faculty = Faculty::findOrFail(session('faculty_id'));
        abort_unless($faculty->canAccessStudent($student), 403);
    }

    private function buildGrid(Student $student): array
    {
        $subjects = Grade::subjectsFor($student);

        $existing = Grade::where('student_id', $student->id)
            ->where('school_year', self::SCHOOL_YEAR)
            ->get()
            ->groupBy('subject');

        $grid = [];
        foreach ($subjects as $subject) {
            $rows     = $existing->get($subject, collect());
            $quarters = [];
            foreach ([1, 2, 3, 4] as $q) {
                $row             = $rows->firstWhere('quarter', $q);
                $quarters[$q]    = $row ? $row->grade : null;
            }
            $values        = array_filter($quarters, fn ($v) => $v !== null);
            $grid[$subject] = [
                'quarters' => $quarters,
                'final'    => count($values) ? round(array_sum($values) / count($values)) : null,
            ];
        }

        $quarterAverages = [];
        foreach ([1, 2, 3, 4] as $q) {
            $vals = array_filter(array_map(fn ($s) => $grid[$s]['quarters'][$q] ?? null, $subjects), fn ($v) => $v !== null);
            $quarterAverages[] = count($vals) ? round(array_sum($vals) / count($vals), 1) : null;
        }

        $finals = array_filter(array_column($grid, 'final'));

        return [
            'school_year'      => self::SCHOOL_YEAR,
            'subjects'         => $subjects,
            'grid'             => $grid,
            'quarter_averages' => $quarterAverages,
            'general_average'  => count($finals) ? round(array_sum($finals) / count($finals), 1) : null,
        ];
    }
}
