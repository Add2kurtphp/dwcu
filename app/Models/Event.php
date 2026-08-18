<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'description', 'event_date', 'category', 'section', 'audience', 'created_by'];

    protected $casts = ['event_date' => 'date'];

    public static function audienceForSection(?string $section): string
    {
        if (!$section) {
            return 'all';
        }

        $grade = (int) preg_replace('/[^0-9]/', '', $section);

        return $grade >= 11 ? 'shs' : 'jhs';
    }
}
