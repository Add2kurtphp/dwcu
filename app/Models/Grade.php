<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    const JHS_SUBJECTS = [
        'Filipino', 'English', 'Mathematics', 'Science',
        'Araling Panlipunan', 'Edukasyon sa Pagpapakatao', 'MAPEH', 'TLE',
    ];

    const SHS_SUBJECTS = [
        'Oral Communication', 'General Mathematics', 'Earth and Life Science',
        'Personal Development', 'Physical Education and Health', 'Practical Research 1',
    ];

    protected $fillable = [
        'student_id', 'school_year', 'subject', 'quarter', 'grade', 'remarks',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public static function subjectsFor(Student $student): array
    {
        $isSHS = str_contains($student->grade_level, '11') || str_contains($student->grade_level, '12');
        return $isSHS ? self::SHS_SUBJECTS : self::JHS_SUBJECTS;
    }
}
