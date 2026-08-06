<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Student;

class GradebookController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('grade_level')->orderBy('name')->get();
        return view('faculty.gradebook', compact('students'));
    }
}
