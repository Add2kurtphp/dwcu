<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('grade_level')->orderBy('name')->get();
        return view('admin.students', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id'  => 'required|unique:students,student_id',
            'name'        => 'required|string|max:255',
            'email'       => 'required|email',
            'grade_level' => 'required|string',
            'section'     => 'required|string|max:255',
        ]);

        $student = Student::create([
            'student_id'  => $request->student_id,
            'name'        => $request->name,
            'email'       => $request->email,
            'grade_level' => $request->grade_level,
            'section'     => $request->section,
            'status'      => 'active',
        ]);

        return response()->json(['success' => true, 'student' => $student]);
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email',
            'grade_level' => 'required|string',
            'section'     => 'required|string|max:255',
            'status'      => 'required|in:active,dropped',
        ]);

        $student->update($request->only('name', 'email', 'grade_level', 'section', 'status'));

        return response()->json(['success' => true, 'student' => $student]);
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->json(['success' => true]);
    }
}
