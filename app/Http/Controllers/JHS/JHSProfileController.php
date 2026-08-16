<?php

namespace App\Http\Controllers\JHS;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class JHSProfileController extends Controller
{
    public function show()
    {
        $student = Student::find(session('jhs_student_id'));

        if (!$student) {
            return redirect()->route('jhs.login');
        }

        return view('jhs.profile', compact('student'));
    }

    public function updateInfo(Request $request)
    {
        $student = Student::find(session('jhs_student_id'));

        if (!$student) {
            return redirect()->route('jhs.login');
        }

        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'current_address'   => 'nullable|string|max:255',
            'permanent_address' => 'nullable|string|max:255',
            'birthday'          => 'nullable|string|max:100',
            'mother_name'       => 'nullable|string|max:255',
            'father_name'       => 'nullable|string|max:255',
        ]);

        $student->update($request->only(
            'name', 'email', 'current_address', 'permanent_address',
            'birthday', 'mother_name', 'father_name'
        ));

        session(['jhs_student_name' => $student->name]);

        return back()->with('profile_success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $student = Student::find(session('jhs_student_id'));

        if (!$student) {
            return redirect()->route('jhs.login');
        }

        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => ['required', 'string', Password::min(8)->mixedCase()->numbers(), 'confirmed'],
        ]);

        if (!Hash::check($request->current_password, $student->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $student->update(['password' => Hash::make($request->new_password)]);

        return back()->with('password_success', 'Password changed successfully.');
    }
}
