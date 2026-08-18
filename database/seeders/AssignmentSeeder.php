<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Faculty;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $faculty = Faculty::first();
        $name = $faculty ? $faculty->name : 'Faculty';

        $jhs = [
            ['title' => 'Science: Ecosystems Research', 'subject' => 'Science', 'days' => 5,
             'description' => 'Review the assignment details in the Google Form link provided by your teacher before submitting your photo/file below.',
             'attachment_label' => 'Science_Instructions_v1', 'attachment_link' => 'https://forms.google.com'],
            ['title' => 'Algebraic Expressions', 'subject' => 'Mathematics', 'days' => 8,
             'description' => 'Complete the Algebraic Expressions problem set. Show all your solutions on a clean sheet of paper.'],
            ['title' => 'Argumentative Essay Draft', 'subject' => 'English', 'days' => 11,
             'description' => 'Submit the first draft of your argumentative essay. Ensure proper citations are included.'],
            ['title' => 'Residential Floor Plan', 'subject' => 'TLE', 'days' => 14,
             'description' => 'Upload the photo of your drafting project (Residential Floor Plan). Ensure labels are legible.'],
        ];

        $shs = [
            ['title' => 'Research Proposal (Chapter 1–3)', 'subject' => 'Capstone Research', 'days' => 9,
             'description' => "Submit your Chapter 1–3 draft. Ensure your methodology matches the approved research title from the STEM coordinator.",
             'attachment_label' => 'Research_Guidelines_2026.pdf'],
            ['title' => 'General Physics 2', 'subject' => 'General Physics 2', 'days' => 5,
             'description' => "Problem set on Gauss's Law and Electric Flux. Upload photos of your step-by-step solutions for full credit."],
            ['title' => 'Basic Calculus', 'subject' => 'Basic Calculus', 'days' => 12,
             'description' => 'Derivatives and Rules of Differentiation Practice. Complete the Quizizz practice and upload your final score.'],
            ['title' => 'General Biology 2', 'subject' => 'General Biology 2', 'days' => 15,
             'description' => 'Create a digital poster explaining the Hardy-Weinberg Principle of Equilibrium in a specific population.'],
        ];

        foreach ($jhs as $a) {
            Assignment::updateOrCreate(
                ['title' => $a['title']],
                [
                    'description'      => $a['description'],
                    'subject'          => $a['subject'],
                    'due_date'         => now()->addDays($a['days'])->toDateString(),
                    'audience'         => 'jhs',
                    'attachment_label' => $a['attachment_label'] ?? null,
                    'attachment_link'  => $a['attachment_link'] ?? null,
                    'created_by'       => $name,
                ]
            );
        }
        foreach ($shs as $a) {
            Assignment::updateOrCreate(
                ['title' => $a['title']],
                [
                    'description'      => $a['description'],
                    'subject'          => $a['subject'],
                    'due_date'         => now()->addDays($a['days'])->toDateString(),
                    'audience'         => 'shs',
                    'attachment_label' => $a['attachment_label'] ?? null,
                    'attachment_link'  => $a['attachment_link'] ?? null,
                    'created_by'       => $name,
                ]
            );
        }
    }
}
