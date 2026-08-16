<?php

namespace App\Http\Controllers\SHS;

use App\Http\Controllers\Controller;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::whereIn('audience', ['all', 'shs'])
            ->orderByDesc('target_date')
            ->get();

        return view('shs.announcement', compact('announcements'));
    }
}
