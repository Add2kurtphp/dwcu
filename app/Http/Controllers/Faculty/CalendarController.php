<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Event;

class CalendarController extends Controller
{
    public function index()
    {
        $events        = Event::orderBy('event_date')->get();
        $announcements = Announcement::orderByDesc('target_date')->get();

        return view('faculty.calendar', compact('events', 'announcements'));
    }
}
