<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Faculty;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $faculty = Faculty::first();
        $name = $faculty ? $faculty->name : 'Faculty';

        $samples = [
            ['title' => 'Mathematics Quiz — Chapter 2 (Linear Equations)', 'days' => 3,  'category' => 'Quiz',        'section' => 'Grade 9 - Innovators'],
            ['title' => 'Science Investigatory Project Submission',        'days' => 7,  'category' => 'Assignment',  'section' => 'Grade 10 - Leaders'],
            ['title' => 'Practical Research 2 — Final Paper',              'days' => 10, 'category' => 'Assignment',  'section' => 'Grade 11 - HUMSS'],
            ['title' => '1st Quarter Examination',                         'days' => 14, 'category' => 'Examination', 'section' => null],
            ['title' => 'English Reading Comprehension Quiz',               'days' => 5,  'category' => 'Quiz',        'section' => 'Grade 8 - Researchers'],
            ['title' => 'ICT Programming Project Defense',                  'days' => 18, 'category' => 'Examination', 'section' => 'Grade 12 - ICT'],
        ];

        foreach ($samples as $s) {
            Event::updateOrCreate(
                ['title' => $s['title']],
                [
                    'event_date' => now()->addDays($s['days'])->toDateString(),
                    'category'   => $s['category'],
                    'section'    => $s['section'],
                    'audience'   => Event::audienceForSection($s['section']),
                    'created_by' => $name,
                ]
            );
        }
    }
}
