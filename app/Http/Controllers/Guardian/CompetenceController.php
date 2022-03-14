<?php

namespace App\Http\Controllers\Guardian;

use App\Http\Controllers\Controller;
use App\Models\Competence;
use App\Models\Subject;
use Illuminate\Http\Request;

class CompetenceController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $subGrade = $user->guardian->subGrade;
        $subjects = Subject::all();
        $subject = $request->subject ?: $subjects->first()->id ?? null;

        $competences = Competence::where([
            'subject_id' => $subject,
            'grade_id' => $subGrade->grade_id,
        ])->withUsed()->paginate(10)->withQueryString();

        $data = [
            'grade' => $subGrade->grade,
            'subjects' => $subjects,
            'competences' => $competences,
            'selected'  => $subject
        ];
        return view('guardian.competences.competence', $data);
    }

    public function edit($id)
    {
        return view('guardian.competences.modal-edit', [
            'subjects' => Subject::all(),
            'grade' => auth()->user()->guardian->subGrade->grade,
            'competence' => Competence::withUsed()->find($id),
        ]);
    }
}
