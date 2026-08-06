<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportFormController extends Controller
{
    public function sf9(Student $student)
    {
        $bySubject = $this->gradesBySubject($student);

        $pdf = Pdf::loadView('reports.sf9', [
            'student'   => $student,
            'bySubject' => $bySubject,
            'average'   => $this->generalAverage($bySubject),
        ])->setPaper('legal', 'portrait');

        return $pdf->stream("SF9-{$student->student_id}.pdf");
    }

    public function sf10(Student $student)
    {
        $bySubject = $this->gradesBySubject($student);

        $pdf = Pdf::loadView('reports.sf10', [
            'student'   => $student,
            'bySubject' => $bySubject,
            'average'   => $this->generalAverage($bySubject),
        ])->setPaper('legal', 'portrait');

        return $pdf->stream("SF10-{$student->student_id}.pdf");
    }

    private function gradesBySubject(Student $student): array
    {
        $grades = $student->grades()->orderBy('subject')->orderBy('quarter')->get();

        $bySubject = [];
        foreach ($grades as $grade) {
            $subject = $grade->subject;
            $bySubject[$subject]['school_year']            = $grade->school_year;
            $bySubject[$subject]['quarters'][$grade->quarter] = $grade->grade;
        }

        foreach ($bySubject as $subject => $data) {
            $quarters = $data['quarters'];
            $final    = $quarters ? round(array_sum($quarters) / count($quarters)) : null;
            $bySubject[$subject]['final']   = $final;
            $bySubject[$subject]['remarks'] = $final !== null && $final >= 75 ? 'Passed' : 'Failed';
        }

        return $bySubject;
    }

    private function generalAverage(array $bySubject): ?float
    {
        $finals = array_filter(array_column($bySubject, 'final'));
        if (empty($finals)) {
            return null;
        }

        return round(array_sum($finals) / count($finals), 2);
    }
}
