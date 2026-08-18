<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AuditLog;
use App\Models\Event;
use App\Models\Faculty;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderByDesc('target_date')->get();
        $events = Event::where('event_date', '>=', now()->toDateString())->orderBy('event_date')->limit(20)->get();
        return view('faculty.announcements', compact('announcements', 'events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'section' => 'required|string',
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $faculty = Faculty::findOrFail(session('faculty_id'));
        $grade   = (int) preg_replace('/[^0-9]/', '', $request->section);
        $audience = $grade >= 11 ? 'shs' : 'jhs';

        $announcement = Announcement::create([
            'posted_by'   => $faculty->name,
            'title'       => $request->title,
            'content'     => $request->content,
            'target_date' => now()->toDateString(),
            'category'    => 'general',
            'audience'    => $audience,
        ]);

        AuditLog::record($faculty->name, "Posted announcement — {$announcement->title}", 'faculty', 'Announcement', strtoupper($audience));

        return response()->json(['success' => true, 'announcement' => $announcement]);
    }
}
