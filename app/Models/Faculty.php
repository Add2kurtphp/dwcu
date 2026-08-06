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
}
