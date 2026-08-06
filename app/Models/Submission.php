<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'quiz_id', 'student_id', 'status', 'total_score', 'total_possible',
        'submitted_at', 'graded_at', 'graded_by',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'graded_at'    => 'datetime',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function grader()
    {
        return $this->belongsTo(Faculty::class, 'graded_by');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
