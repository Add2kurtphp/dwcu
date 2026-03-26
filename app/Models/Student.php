<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'student_id', 'name', 'email', 'grade_level', 'section', 'status', 'password',
        'current_address', 'permanent_address', 'birthday', 'mother_name', 'father_name',
    ];

    protected $hidden = ['password'];
}
