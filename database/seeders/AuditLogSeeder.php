<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuditLog;

class AuditLogSeeder extends Seeder
{
    public function run(): void
    {
        AuditLog::truncate();

        $logs = [
            // Most recent first
            ['admin_name' => 'Karen Kemper',   'action' => 'Posted announcement: "School Orientation for New Students"', 'module' => 'ANNOUNCEMENT', 'status' => 'success', 'created_at' => '2026-03-16 08:00:00'],
            ['admin_name' => 'Edward Zeller',  'action' => 'Posted announcement: "Quiz in Mathematics"',                 'module' => 'ANNOUNCEMENT', 'status' => 'success', 'created_at' => '2026-03-14 09:30:00'],
            ['admin_name' => 'System Admin',   'action' => 'Added faculty: Mr. Adrian Paul Garcia (SHS - ICT)',          'module' => 'FACULTY',      'status' => 'success', 'created_at' => '2026-03-13 14:00:00'],
            ['admin_name' => 'System Admin',   'action' => 'Added faculty: Ms. Angela Mae Fernandez (SHS - HUMSS)',      'module' => 'FACULTY',      'status' => 'success', 'created_at' => '2026-03-13 13:50:00'],
            ['admin_name' => 'System Admin',   'action' => 'Added faculty: Mr. Carlo Miguel Reyes (SHS - STEM)',         'module' => 'FACULTY',      'status' => 'success', 'created_at' => '2026-03-13 13:40:00'],
            ['admin_name' => 'System Admin',   'action' => 'Added faculty: Dr. Maria Theresa Dela Cruz (SHS Principal)', 'module' => 'FACULTY',      'status' => 'success', 'created_at' => '2026-03-13 13:30:00'],
            ['admin_name' => 'System Admin',   'action' => 'Added faculty: Mr. Daniel Garcia (JHS - T.L.E)',             'module' => 'FACULTY',      'status' => 'success', 'created_at' => '2026-03-13 13:20:00'],
            ['admin_name' => 'System Admin',   'action' => 'Added faculty: Mrs. Catherine Santos (JHS - Math)',          'module' => 'FACULTY',      'status' => 'success', 'created_at' => '2026-03-13 13:10:00'],
            ['admin_name' => 'System Admin',   'action' => 'Added faculty: Ms. Maria Cruz (JHS - English)',              'module' => 'FACULTY',      'status' => 'success', 'created_at' => '2026-03-13 13:00:00'],
            ['admin_name' => 'System Admin',   'action' => 'Added faculty: Mr. John Michael Reyes (JHS - Science)',      'module' => 'FACULTY',      'status' => 'success', 'created_at' => '2026-03-13 12:50:00'],
            ['admin_name' => 'System Admin',   'action' => 'Added faculty: Mr. Jordan Pizarras (JHS Principal)',         'module' => 'FACULTY',      'status' => 'success', 'created_at' => '2026-03-13 12:40:00'],
            ['admin_name' => 'System',         'action' => 'Portal initialized — Academic Year 2025-2026',               'module' => 'ALL',          'status' => 'info',    'created_at' => '2026-03-10 08:00:00'],
        ];

        foreach ($logs as $log) {
            AuditLog::create($log);
        }
    }
}
