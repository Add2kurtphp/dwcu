<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        Announcement::insert([
            [
                'posted_by'   => 'Karen Kemper',
                'title'       => 'School Orientation for New Students',
                'content'     => 'Deadline for the descriptive essay submission. Submit your drafts via the portal.',
                'target_date' => '2026-03-16',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'posted_by'   => 'Edward Zeller',
                'title'       => 'Quiz in Mathematics',
                'content'     => 'Preparation for the upcoming Algebra quiz. Focus on Linear Equations and Factoring.',
                'target_date' => '2026-03-14',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
