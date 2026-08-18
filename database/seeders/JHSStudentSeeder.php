<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Database\Seeders\Concerns\GeneratesPasswords;
use Illuminate\Support\Facades\Hash;

class JHSStudentSeeder extends Seeder
{
    use GeneratesPasswords;

    public function run(): void
    {
        $jhsStudents = [
            ['student_id' => '2024-0022', 'name' => 'Michael Flores',   'email' => 'flores.m@dwcu.edu.ph',     'grade_level' => 'Grade 7',  'section' => 'Explorers',   'status' => 'active'],
            ['student_id' => '2024-0045', 'name' => 'Mark Zuckerberg',  'email' => 'zuck.m@dwcu.edu.ph',       'grade_level' => 'Grade 8',  'section' => 'Researchers', 'status' => 'active'],
            ['student_id' => '2024-0052', 'name' => 'Emma Hall',        'email' => 'hall.e@dwcu.edu.ph',       'grade_level' => 'Grade 9',  'section' => 'Innovators',  'status' => 'active'],
            ['student_id' => '2024-0015', 'name' => 'Alexandra Cruz',   'email' => 'cruz.a@dwcu.edu.ph',       'grade_level' => 'Grade 7',  'section' => 'Explorers',   'status' => 'active'],
            ['student_id' => '2024-0068', 'name' => 'Steven Santos',    'email' => 'santos.s@dwcu.edu.ph',     'grade_level' => 'Grade 10', 'section' => 'Leaders',     'status' => 'active'],
            ['student_id' => '2024-0091', 'name' => 'Maria Santos',     'email' => 'santos.m@dwcu.edu.ph',     'grade_level' => 'Grade 8',  'section' => 'Researchers', 'status' => 'active'],
            ['student_id' => '2024-0113', 'name' => 'Anna Lim',         'email' => 'lim.a@dwcu.edu.ph',        'grade_level' => 'Grade 9',  'section' => 'Innovators',  'status' => 'active'],
            ['student_id' => '2024-0124', 'name' => 'Pedro Cruz',       'email' => 'cruz.p@dwcu.edu.ph',       'grade_level' => 'Grade 7',  'section' => 'Explorers',   'status' => 'active'],
            ['student_id' => '2024-0155', 'name' => 'Leo Mendoza',      'email' => 'mendoza.l@dwcu.edu.ph',    'grade_level' => 'Grade 8',  'section' => 'Explorers',   'status' => 'active'],
            ['student_id' => '2024-0166', 'name' => 'Sofia Reyes',      'email' => 'reyes.s@dwcu.edu.ph',      'grade_level' => 'Grade 10', 'section' => 'Leaders',     'status' => 'active'],
            ['student_id' => '2024-0177', 'name' => 'Juan Dela Cruz',   'email' => 'delacruz.j@dwcu.edu.ph',   'grade_level' => 'Grade 9',  'section' => 'Innovators',  'status' => 'active'],
            ['student_id' => '2024-0188', 'name' => 'Mika Torres',      'email' => 'torres.m@dwcu.edu.ph',     'grade_level' => 'Grade 7',  'section' => 'Researchers', 'status' => 'active'],
        ];

        foreach ($jhsStudents as $s) {
            $password = $this->randomPassword();
            Student::updateOrCreate(['student_id' => $s['student_id']], $s + ['password' => Hash::make($password)]);
            $this->logCredential('Student', $s['name'], $s['student_id'], $password);
        }
    }
}
