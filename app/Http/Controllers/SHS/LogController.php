<?php

namespace App\Http\Controllers\SHS;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Student;

class LogController extends Controller
{
    public function index()
    {
        $student = Student::findOrFail(session('shs_student_id'));

        $logs = AuditLog::where('portal', 'shs')
            ->where('admin_name', $student->name)
            ->orderByDesc('created_at')
            ->get();

        return view('shs.logs', compact('logs'));
    }
}
