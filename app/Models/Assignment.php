<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'title', 'description', 'subject', 'due_date', 'section',
        'audience', 'attachment_label', 'attachment_link', 'created_by',
    ];

    protected $casts = ['due_date' => 'date'];

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }
}
