<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            ['student_id' => '2024-0022', 'name' => 'Michael Flores',   'email' => 'flores.m@dwcu.edu.ph',  'grade_level' => 'Grade 7',  'section' => 'Explorers',   'status' => 'active'],
            ['student_id' => '2024-0045', 'name' => 'Mark Zuckerberg',  'email' => 'zuck.m@dwcu.edu.ph',    'grade_level' => 'Grade 8',  'section' => 'Researchers', 'status' => 'active'],
            ['student_id' => '2024-0052', 'name' => 'Emma Hall',        'email' => 'hall.e@dwcu.edu.ph',    'grade_level' => 'Grade 9',  'section' => 'Innovators',  'status' => 'active'],
            ['student_id' => '2024-0015', 'name' => 'Alexandra Cruz',   'email' => 'cruz.a@dwcu.edu.ph',    'grade_level' => 'Grade 7',  'section' => 'Explorers',   'status' => 'active'],
            ['student_id' => '2024-0068', 'name' => 'Steven Santos',    'email' => 'santos.s@dwcu.edu.ph',  'grade_level' => 'Grade 10', 'section' => 'Leaders',     'status' => 'active'],
            ['student_id' => '2024-0074', 'name' => 'Jessica Reyes',    'email' => 'reyes.j@dwcu.edu.ph',   'grade_level' => 'Grade 12', 'section' => 'STEM',        'status' => 'active'],
            ['student_id' => '2024-0001', 'name' => 'Jorez Romo',       'email' => 'romo.j@dwcu.edu.ph',    'grade_level' => 'Grade 12', 'section' => 'Visionaries', 'status' => 'active'],
            ['student_id' => '2024-0080', 'name' => 'Carlos Mendoza',   'email' => 'mendoza.c@dwcu.edu.ph', 'grade_level' => 'Grade 11', 'section' => 'Achievers',   'status' => 'active'],
            ['student_id' => '2024-0091', 'name' => 'Maria Santos',     'email' => 'santos.m@dwcu.edu.ph',  'grade_level' => 'Grade 8',  'section' => 'Researchers', 'status' => 'active'],
            ['student_id' => '2024-0102', 'name' => 'Luis Garcia',      'email' => 'garcia.l@dwcu.edu.ph',  'grade_level' => 'Grade 10', 'section' => 'Leaders',     'status' => 'dropped'],
            ['student_id' => '2024-0113', 'name' => 'Anna Lim',         'email' => 'lim.a@dwcu.edu.ph',     'grade_level' => 'Grade 9',  'section' => 'Innovators',  'status' => 'active'],
            ['student_id' => '2024-0124', 'name' => 'Pedro Cruz',       'email' => 'cruz.p@dwcu.edu.ph',    'grade_level' => 'Grade 7',  'section' => 'Explorers',   'status' => 'active'],
        ];

        foreach ($students as $s) {
            Student::updateOrCreate(['student_id' => $s['student_id']], $s);
        }
    }
}
