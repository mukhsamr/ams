<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;

class CompetenceController extends Controller
{
    public function index(Request $request)
    {
        $subjects = Subject::all();
        $grades = Grade::all();

        $subject = $request->subject ?? ($subjects->first() ? $subjects->first()->id : null);
        $grade = $request->grade ?? ($grades->first() ? $grades->first()->id : null);

        $competence = Competence::withGrade()
            ->where('subject_id', $subject)
            ->where('grade_id', $grade)
            ->withUsed()->paginate(10)->withQueryString();

        $data = [
            'subjects' => $subjects,
            'grades' => $grades,
            'competences' => $competence,
            'selected' => [
                'subject' => $subject,
                'grade' => $grade,
            ],
        ];

        return view('operator.competences.competence', $data);
    }

    public function edit($id)
    {
        return view('teacher.competences.modal-edit', [
            'subjects' => Subject::all(),
            'grades' => Grade::all(),
            'competence' => Competence::withUsed()->find($id),
        ]);
    }
}
