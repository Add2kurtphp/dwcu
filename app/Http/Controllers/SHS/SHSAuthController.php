<?php

namespace App\Http\Controllers\SHS;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SHSAuthController extends Controller
{
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

        Session::put('shs_student_id',   $student->id);
        Session::put('shs_student_name', $student->name);

        if ($request->remember) {
            Session::put('shs_remember', true);
        }

        AuditLog::record($student->name, 'Logged in to the SHS Portal', 'shs', 'Auth');

        return redirect()->route('shs.dashboard');
    }

    public function logout(Request $request)
    {
        $name = session('shs_student_name');
        if ($name) {
            AuditLog::record($name, 'Logged out of the SHS Portal', 'shs', 'Auth');
        }

        Session::forget(['shs_student_id', 'shs_student_name', 'shs_remember']);
        $request->session()->regenerate();

        return redirect()->route('shs.login');
    }
}
