<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $table    = 'faculty';
    protected $fillable = ['faculty_id', 'name', 'designation', 'department', 'status', 'password'];
    protected $hidden   = ['password'];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Grade levels (as digit strings) this faculty member may access student
     * records for, based on department. Administration/unrecognized
     * departments (e.g. principals) get full access; subject teachers are
     * scoped to their JHS or SHS level only.
     */
    public function accessibleGradeLevels(): array
    {
        if (str_contains($this->department, 'Junior High')) {
            return ['7', '8', '9', '10'];
        }
        if (str_starts_with($this->department, 'SHS')) {
            return ['11', '12'];
        }

        return ['7', '8', '9', '10', '11', '12'];
    }

    public function canAccessStudent(Student $student): bool
    {
        $gradeNum = preg_replace('/[^0-9]/', '', $student->grade_level ?? '');
        return in_array($gradeNum, $this->accessibleGradeLevels(), true);
    }
}
