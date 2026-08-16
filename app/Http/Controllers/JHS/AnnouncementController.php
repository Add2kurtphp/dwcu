<?php

namespace App\Http\Controllers\JHS;

use App\Http\Controllers\Controller;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::whereIn('audience', ['all', 'jhs'])
            ->orderByDesc('target_date')
            ->get();

        return view('jhs.announcement', compact('announcements'));
    }
}
