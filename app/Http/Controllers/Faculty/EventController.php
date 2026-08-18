<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Event;
use App\Models\Faculty;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'event_date'  => 'required|date',
            'category'    => 'required|in:Quiz,Assignment,Examination',
            'section'     => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $faculty = Faculty::findOrFail(session('faculty_id'));

        $event = Event::create([
            'title'       => $request->title,
            'description' => $request->description,
            'event_date'  => $request->event_date,
            'category'    => $request->category,
            'section'     => $request->section ?: null,
            'audience'    => Event::audienceForSection($request->section),
            'created_by'  => $faculty->name,
        ]);

        AuditLog::record($faculty->name, "Added event — {$event->title}", 'faculty', 'Event', $event->section ?? 'All Sections');

        return response()->json(['success' => true, 'event' => $event]);
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'event_date'  => 'required|date',
            'category'    => 'required|in:Quiz,Assignment,Examination',
            'section'     => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $faculty = Faculty::findOrFail(session('faculty_id'));

        $event->update([
            'title'       => $request->title,
            'description' => $request->description,
            'event_date'  => $request->event_date,
            'category'    => $request->category,
            'section'     => $request->section ?: null,
            'audience'    => Event::audienceForSection($request->section),
        ]);

        AuditLog::record($faculty->name, "Updated event — {$event->title}", 'faculty', 'Event', $event->section ?? 'All Sections');

        return response()->json(['success' => true, 'event' => $event]);
    }

    public function destroy(Event $event)
    {
        $faculty = Faculty::findOrFail(session('faculty_id'));
        AuditLog::record($faculty->name, "Deleted event — {$event->title}", 'faculty', 'Event', $event->section ?? 'All Sections');

        $event->delete();

        return response()->json(['success' => true]);
    }
}
