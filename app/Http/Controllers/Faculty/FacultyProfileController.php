<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FacultyProfileController extends Controller
{
    public function show()
    {
        $faculty = Faculty::find(session('faculty_id'));

        if (!$faculty) {
            return redirect()->route('faculty.login');
        }

        return view('faculty.profile', compact('faculty'));
    }

    public function updateInfo(Request $request)
    {
        $faculty = Faculty::find(session('faculty_id'));

        if (!$faculty) {
            return redirect()->route('faculty.login');
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'department'  => 'nullable|string|max:255',
        ]);

        $faculty->update($request->only('name', 'designation', 'department'));

        session(['faculty_name' => $faculty->name]);

        return back()->with('profile_success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $faculty = Faculty::find(session('faculty_id'));

        if (!$faculty) {
            return redirect()->route('faculty.login');
        }

        $request->validate([
            'current_password'      => 'required|string',
            'new_password'          => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $faculty->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $faculty->update(['password' => Hash::make($request->new_password)]);

        return back()->with('password_success', 'Password changed successfully.');
    }
}
