<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faculty;
use Database\Seeders\Concerns\GeneratesPasswords;
use Illuminate\Support\Facades\Hash;

class FacultySeeder extends Seeder
{
    use GeneratesPasswords;

    public function run(): void
    {
        $faculty = [
            ['faculty_id' => 'FAC-2026-001', 'name' => 'Mr. Jordan Pizarras',             'designation' => 'Junior High School Principal',             'department' => 'Administration',    'status' => 'active'],
            ['faculty_id' => 'FAC-2026-002', 'name' => 'Mr. John Michael Reyes',          'designation' => 'Secondary School Teacher III (Science)',    'department' => 'Junior High School', 'status' => 'active'],
            ['faculty_id' => 'FAC-2026-003', 'name' => 'Ms. Maria Cruz',                  'designation' => 'Secondary School Teacher II (English)',     'department' => 'Junior High School', 'status' => 'active'],
            ['faculty_id' => 'FAC-2026-004', 'name' => 'Mrs. Catherine Santos',           'designation' => 'Secondary School Teacher III (Math)',       'department' => 'Junior High School', 'status' => 'active'],
            ['faculty_id' => 'FAC-2026-005', 'name' => 'Mr. Daniel Garcia',               'designation' => 'Secondary School Teacher III (T.L.E)',      'department' => 'Junior High School', 'status' => 'active'],
            ['faculty_id' => 'FAC-2026-006', 'name' => 'Dr. Maria Theresa Dela Cruz, EdD','designation' => 'Senior High School Principal',              'department' => 'Administration',    'status' => 'active'],
            ['faculty_id' => 'FAC-2026-007', 'name' => 'Mr. Carlo Miguel Reyes',          'designation' => 'General Mathematics & Physics',             'department' => 'SHS - STEM',        'status' => 'active'],
            ['faculty_id' => 'FAC-2026-008', 'name' => 'Ms. Angela Mae Fernandez',        'designation' => 'Philippine Politics & Creative Writing',    'department' => 'SHS - HUMSS',       'status' => 'active'],
            ['faculty_id' => 'FAC-2026-009', 'name' => 'Mr. Adrian Paul Garcia',          'designation' => 'Programming & Web Development',             'department' => 'SHS - ICT',         'status' => 'active'],
        ];

        foreach ($faculty as $f) {
            $password = $this->randomPassword();
            Faculty::updateOrCreate(['faculty_id' => $f['faculty_id']], $f + ['password' => Hash::make($password)]);
            $this->logCredential('Faculty', $f['name'], $f['faculty_id'], $password);
        }
    }
}
