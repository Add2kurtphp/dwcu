<?php

namespace App\Http\Controllers\SHS;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SHSAuthController extends Controller
{
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
