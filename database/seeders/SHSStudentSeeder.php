<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class SHSStudentSeeder extends Seeder
{
    public function run(): void
    {
        $shsStudents = [
            ['student_id' => '2024-0074', 'name' => 'Jessica Reyes',    'email' => 'reyes.j@dwcu.edu.ph',   'grade_level' => 'Grade 12', 'section' => 'STEM',        'status' => 'active', 'password' => Hash::make('password123')],
            ['student_id' => '2024-0001', 'name' => 'Jorez Romo',       'email' => 'romo.j@dwcu.edu.ph',    'grade_level' => 'Grade 12', 'section' => 'Visionaries', 'status' => 'active', 'password' => Hash::make('password123')],
            ['student_id' => '2024-0080', 'name' => 'Carlos Mendoza',   'email' => 'mendoza.c@dwcu.edu.ph', 'grade_level' => 'Grade 11', 'section' => 'Achievers',   'status' => 'active', 'password' => Hash::make('password123')],
        ];

        foreach ($shsStudents as $s) {
            Student::updateOrCreate(['student_id' => $s['student_id']], $s);
        }
    }
}
