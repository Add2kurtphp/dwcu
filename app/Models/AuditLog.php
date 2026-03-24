<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = ['admin_name', 'action', 'module', 'status', 'portal', 'action_type', 'drop_detail'];

    protected $casts = ['drop_detail' => 'array'];
}
