<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Faculty;

class LogController extends Controller
{
    public function index()
    {
        $faculty = Faculty::findOrFail(session('faculty_id'));

        $logs = AuditLog::where('portal', 'faculty')
            ->where('admin_name', $faculty->name)
            ->orderByDesc('created_at')
            ->get();

        return view('faculty.logs', compact('logs'));
    }
}
