<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        $faculty = Faculty::findOrFail(session('faculty_id'));

        $students = Student::orderBy('grade_level')->orderBy('name')->get()
            ->filter(fn ($s) => $faculty->canAccessStudent($s))
            ->values();

        return view('faculty.students', compact('students'));
    }
}
