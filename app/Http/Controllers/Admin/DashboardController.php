<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Announcement;
use App\Models\AuditLog;

class DashboardController extends Controller
{
    public function index()
    {
        $totalFaculty   = Faculty::count();
        $totalStudents  = Student::count();
        $activeStudents = Student::where('status', 'active')->count();
        $droppedStudents = Student::where('status', 'dropped')->count();

        $jhsStudents = Student::where('status', 'active')->whereIn('grade_level', ['Grade 7','Grade 8','Grade 9','Grade 10'])->count();
        $shsStudents = Student::where('status', 'active')->whereIn('grade_level', ['Grade 11','Grade 12'])->count();

        // Per-grade active counts for enrollment bars
        $gradeBreakdown = Student::where('status', 'active')
            ->selectRaw('grade_level, count(*) as count')
            ->groupBy('grade_level')
            ->pluck('count', 'grade_level');

        $recentLogs = AuditLog::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalFaculty', 'totalStudents', 'activeStudents', 'droppedStudents',
            'jhsStudents', 'shsStudents', 'gradeBreakdown', 'recentLogs'
        ));
    }
}
