<?php

namespace App\Http\Controllers\JHS;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class JHSAuthController extends Controller
{
    public function logout(Request $request)
    {
        $name = session('jhs_student_name');
        if ($name) {
            AuditLog::record($name, 'Logged out of the JHS Portal', 'jhs', 'Logout');
        }

        Session::forget(['jhs_student_id', 'jhs_student_name', 'jhs_remember']);
        $request->session()->regenerate();

        return redirect()->route('jhs.login');
    }
}
