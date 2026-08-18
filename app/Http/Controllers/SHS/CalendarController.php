<?php

namespace App\Http\Controllers\SHS;

use App\Http\Controllers\Controller;
use App\Models\Event;

class CalendarController extends Controller
{
    public function index()
    {
        $events = Event::whereIn('audience', ['all', 'shs'])->orderBy('event_date')->get();

        return view('shs.calendar', compact('events'));
    }
}
