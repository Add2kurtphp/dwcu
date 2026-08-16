<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = ['admin_name', 'action', 'module', 'status', 'portal', 'action_type', 'drop_detail'];

    protected $casts = ['drop_detail' => 'array'];

    public static function record(string $name, string $action, string $portal, string $actionType, string $module = 'General'): void
    {
        static::create([
            'admin_name'  => $name,
            'action'      => $action,
            'portal'      => $portal,
            'action_type' => $actionType,
            'module'      => $module,
            'status'      => 'success',
        ]);
    }
}
