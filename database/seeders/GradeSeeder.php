<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Grade;

class GradeSeeder extends Seeder
{
    public function run(): void
    {
        $schoolYear = '2025-2026';

        Student::whereNotNull('password')->each(function (Student $student) use ($schoolYear) {
            $subjects = Grade::subjectsFor($student);

            foreach ($subjects as $subject) {
                for ($quarter = 1; $quarter <= 4; $quarter++) {
                    $grade = rand(80, 96);

                    Grade::updateOrCreate(
                        [
                            'student_id'  => $student->id,
                            'school_year' => $schoolYear,
                            'subject'     => $subject,
                            'quarter'     => $quarter,
                        ],
                        [
                            'grade'   => $grade,
                            'remarks' => $grade >= 75 ? 'Passed' : 'Failed',
                        ]
                    );
                }
            }
        });
    }
}
