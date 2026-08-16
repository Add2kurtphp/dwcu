<?php

namespace App\Http\Controllers\JHS;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Student;

class LogController extends Controller
{
    public function index()
    {
        $student = Student::findOrFail(session('jhs_student_id'));

        $logs = AuditLog::where('portal', 'jhs')
            ->where('admin_name', $student->name)
            ->orderByDesc('created_at')
            ->get();

        return view('jhs.logs', compact('logs'));
    }
}
