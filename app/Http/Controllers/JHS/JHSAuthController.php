<?php

namespace App\Http\Controllers\JHS;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class JHSAuthController extends Controller
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

        Session::put('jhs_student_id',   $student->id);
        Session::put('jhs_student_name', $student->name);

        if ($request->remember) {
            Session::put('jhs_remember', true);
        }

        return redirect()->route('jhs.dashboard');
    }

    public function logout(Request $request)
    {
        Session::forget(['jhs_student_id', 'jhs_student_name', 'jhs_remember']);
        $request->session()->regenerate();

        return redirect()->route('jhs.login');
    }
}
