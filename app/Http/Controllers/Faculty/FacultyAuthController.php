<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class FacultyAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'faculty_id' => 'required|string',
            'password'   => 'required|string',
        ]);

        $faculty = Faculty::where('faculty_id', $request->faculty_id)
                          ->where('status', 'active')
                          ->first();

        if (!$faculty || !Hash::check($request->password, $faculty->password)) {
            return back()->withErrors([
                'faculty_id' => 'Invalid Faculty ID or password.',
            ])->onlyInput('faculty_id');
        }

        Session::put('faculty_id',   $faculty->id);
        Session::put('faculty_name', $faculty->name);

        if ($request->remember) {
            Session::put('faculty_remember', true);
        }

        return redirect()->route('faculty.dashboard');
    }

    public function logout(Request $request)
    {
        Session::forget(['faculty_id', 'faculty_name', 'faculty_remember']);

        return redirect()->route('faculty.login');
    }
}
