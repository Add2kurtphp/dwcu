<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['posted_by', 'title', 'content', 'target_date', 'category', 'audience'];

    protected $casts = ['target_date' => 'date'];
}
