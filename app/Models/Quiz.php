<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'faculty_id', 'title', 'subject', 'grade_level', 'section', 'school_year',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
