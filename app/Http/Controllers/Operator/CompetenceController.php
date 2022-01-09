<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use App\Models\Grade;
use App\Models\Subject;

class CompetenceController extends Controller
{
    public function index($subject = null, $grade = null)
    {
        $subjects = Subject::all();
        $grades = Grade::all();

        $subject ??= $subjects->first()->id;
        $grade ??= $grades->first()->id;

        $data = [
            'subjects' => $subjects,
            'grades' => $grades,
            'competences' => Competence::with('grade')->where([
                'subject_id' => $subject,
                'grade_id' => $grade
            ])->get(),
            'selected' => [
                'subject' => $subject,
                'grade' => $grade,
            ],
        ];

        return view('operator.competences.competence', $data);
    }
}
