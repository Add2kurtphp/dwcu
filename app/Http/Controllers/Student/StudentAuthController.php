<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class StudentAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.student-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string',
            'password'   => 'required|string',
        ]);

        $student = Student::where('student_id', $request->student_id)
                          ->where('status', 'active')
                          ->first();

        if (!$student || !$student->password || !Hash::check($request->password, $student->password)) {
            return back()->withErrors([
                'student_id' => 'Invalid Student ID or password.',
            ])->onlyInput('student_id');
        }

        $request->session()->regenerate();

        $grade  = (int) preg_replace('/[^0-9]/', '', $student->grade_level ?? '0');
        $portal = $grade >= 11 ? 'shs' : 'jhs';

        Session::put("{$portal}_student_id", $student->id);
        Session::put("{$portal}_student_name", $student->name);

        if ($request->remember) {
            Session::put("{$portal}_remember", true);
        }

        AuditLog::record($student->name, 'Logged in to the ' . strtoupper($portal) . ' Portal', $portal, 'Login');

        return redirect()->route("{$portal}.dashboard");
    }
}
