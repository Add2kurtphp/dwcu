<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Database\Seeders\Concerns\GeneratesPasswords;
use Illuminate\Support\Facades\Hash;

class SHSStudentSeeder extends Seeder
{
    use GeneratesPasswords;

    public function run(): void
    {
        $shsStudents = [
            ['student_id' => '2024-0074', 'name' => 'Jessica Reyes',    'email' => 'reyes.j@dwcu.edu.ph',   'grade_level' => 'Grade 12', 'section' => 'STEM',        'status' => 'active'],
            ['student_id' => '2024-0001', 'name' => 'Jorez Romo',       'email' => 'romo.j@dwcu.edu.ph',    'grade_level' => 'Grade 12', 'section' => 'Visionaries', 'status' => 'active'],
            ['student_id' => '2024-0080', 'name' => 'Carlos Mendoza',   'email' => 'mendoza.c@dwcu.edu.ph', 'grade_level' => 'Grade 11', 'section' => 'Achievers',   'status' => 'active'],
        ];

        foreach ($shsStudents as $s) {
            $password = $this->randomPassword();
            Student::updateOrCreate(['student_id' => $s['student_id']], $s + ['password' => Hash::make($password)]);
            $this->logCredential('Student', $s['name'], $s['student_id'], $password);
        }
    }
}
