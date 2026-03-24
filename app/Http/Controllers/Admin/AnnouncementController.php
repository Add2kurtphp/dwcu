<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderByDesc('target_date')->get();
        return view('admin.announcements', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'target_date' => 'required|date',
            'category'    => 'required|in:general,academic,event,urgent',
            'audience'    => 'required|in:all,jhs,shs',
        ]);

        $announcement = Announcement::create([
            'posted_by'   => Auth::user()->name,
            'title'       => $request->title,
            'content'     => $request->content,
            'target_date' => $request->target_date,
            'category'    => $request->category,
            'audience'    => $request->audience,
        ]);

        return response()->json(['success' => true, 'announcement' => $announcement]);
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required|string',
            'target_date' => 'required|date',
            'category'    => 'required|in:general,academic,event,urgent',
            'audience'    => 'required|in:all,jhs,shs',
        ]);

        $announcement->update($request->only('title', 'content', 'target_date', 'category', 'audience'));

        return response()->json(['success' => true, 'announcement' => $announcement]);
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return response()->json(['success' => true]);
    }
}
