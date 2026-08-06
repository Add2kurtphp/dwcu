<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SF9 - {{ $student->name }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1a1a1a; margin: 0; }
        .sheet { padding: 20px 28px; }

        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .header-table td { vertical-align: top; }
        .school-name { font-size: 15px; font-weight: bold; text-transform: uppercase; }
        .form-title   { font-size: 13px; font-weight: bold; margin-top: 4px; }
        .form-subtitle{ font-size: 11px; margin-top: 2px; }

        .info-table { width: 100%; border-collapse: collapse; margin: 14px 0; }
        .info-table td { padding: 4px 6px; font-size: 11px; }
        .info-label { font-weight: bold; width: 130px; color: #333; }
        .info-value { border-bottom: 1px solid #999; }

        .grades-table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .grades-table th, .grades-table td {
            border: 1px solid #333; padding: 6px 8px; text-align: center; font-size: 11px;
        }
        .grades-table th { background: #f0f0f0; font-weight: bold; }
        .subject-col { text-align: left; }

        .avg-row td { font-weight: bold; background: #f7f7f7; }

        .sig-table { width: 100%; border-collapse: collapse; margin-top: 50px; }
        .sig-table td { text-align: center; font-size: 11px; padding-top: 4px; width: 33%; }
        .sig-line { border-top: 1px solid #333; padding-top: 4px; }
    </style>
</head>
<body>
<div class="sheet">

    <table class="header-table">
        <tr>
            <td style="width: 70%;">
                <div class="school-name">Divine Word College of Urdaneta</div>
                <div class="form-title">School Form 9 (SF9) — Learner's Report Card</div>
                <div class="form-subtitle">School Year: {{ $bySubject ? reset($bySubject)['school_year'] : '—' }}</div>
            </td>
            <td style="width: 30%; text-align: right;">
                <div>Student No.: <strong>{{ $student->student_id }}</strong></div>
            </td>
        </tr>
    </table>

    <table class="info-table">
        <tr>
            <td class="info-label">Learner's Name:</td>
            <td class="info-value">{{ $student->name }}</td>
            <td class="info-label">Grade &amp; Section:</td>
            <td class="info-value">{{ $student->grade_level }} — {{ $student->section }}</td>
        </tr>
    </table>

    <table class="grades-table">
        <thead>
            <tr>
                <th class="subject-col">Learning Area</th>
                <th>Q1</th>
                <th>Q2</th>
                <th>Q3</th>
                <th>Q4</th>
                <th>Final Rating</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bySubject as $subject => $data)
                <tr>
                    <td class="subject-col">{{ $subject }}</td>
                    <td>{{ $data['quarters'][1] ?? '—' }}</td>
                    <td>{{ $data['quarters'][2] ?? '—' }}</td>
                    <td>{{ $data['quarters'][3] ?? '—' }}</td>
                    <td>{{ $data['quarters'][4] ?? '—' }}</td>
                    <td>{{ $data['final'] ?? '—' }}</td>
                    <td>{{ $data['remarks'] ?? '—' }}</td>
                </tr>
            @endforeach
            <tr class="avg-row">
                <td class="subject-col" colspan="5">General Average</td>
                <td colspan="2">{{ $average ?? '—' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="sig-table">
        <tr>
            <td><div class="sig-line">Class Adviser</div></td>
            <td><div class="sig-line">Parent / Guardian</div></td>
            <td><div class="sig-line">School Principal</div></td>
        </tr>
    </table>

</div>
</body>
</html>
