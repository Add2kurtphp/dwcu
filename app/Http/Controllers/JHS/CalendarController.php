<?php

namespace App\Http\Controllers\JHS;

use App\Http\Controllers\Controller;
use App\Models\Event;

class CalendarController extends Controller
{
    public function index()
    {
        $events = Event::whereIn('audience', ['all', 'jhs'])->orderBy('event_date')->get();

        return view('jhs.calendar', compact('events'));
    }
}
